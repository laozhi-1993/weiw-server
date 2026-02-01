<?php

/**
 * 文件下载器类
 * 使用流式下载并支持进度监控
 */
class File_Downloader
{
    /**
     * @var resource 文件句柄，用于写入本地文件
     */
    private $fileHandle;
    
    /**
     * @var resource 网络流句柄，用于读取远程文件
     */
    private $stream;
    
    /**
     * @var int 文件总大小（字节）
     */
    private $length = 0;
    
    /**
     * @var int 已下载大小（字节）
     */
    private $count = 0;
    
    /**
     * 字节单位换算表
     * @var array
     */
    private const BYTE_UNITS = [
        'B' => 1,
        'KB' => 1024,
        'MB' => 1024 * 1024,
        'GB' => 1024 * 1024 * 1024,
        'TB' => 1024 * 1024 * 1024 * 1024,
    ];
    
    /**
     * 构造函数
     * 
     * @param string $url 要下载的文件URL
     * @param string $savePath 本地保存路径
     * @throws Exception 如果打开文件或流失败
     */
    public function __construct(string $url, string $savePath)
    {
        // 创建流上下文，设置超时和连接头
        $context = stream_context_create([
            'http' => [
                'timeout' => 10.0,
                'header' => "Connection: close\r\n"
            ]
        ]);
        
        // 打开本地文件用于写入
        $this->fileHandle = fopen($savePath, 'wb');
        if ($this->fileHandle === false) {
            throw new Exception("无法打开本地文件: $savePath");
        }
        
        // 打开远程文件流
        $this->stream = fopen($url, 'rb', false, $context);
        if ($this->stream === false) {
            fclose($this->fileHandle);
            throw new Exception("无法打开远程文件: $url");
        }
        
        // 从HTTP头中获取文件总大小
        $metaData = stream_get_meta_data($this->stream);
        if (isset($metaData['wrapper_data'])) {
            foreach ($metaData['wrapper_data'] as $header) {
                if (preg_match('!Content-Length:\s*([0-9]+)!i', $header, $c)) {
                    $this->length = (int)$c[1];
                    break;
                }
            }
        }
        
        // 注册到事件循环中
        Simple::add($this->stream, $this);
    }
    
    /**
     * 获取文件总大小
     * 
     * @param bool $formatted 是否格式化为易读的单位（KB/MB/GB）
     * @param int $decimals 格式化时保留的小数位数
     * @return int|string 文件总大小，如果$formatted为true返回字符串，否则返回字节数
     */
    public function getTotalSize(bool $formatted = false, int $decimals = 2): string|int
    {
        if ($formatted) {
            return $this->formatBytes($this->length, $decimals);
        }
        return $this->length;
    }
    
    /**
     * 获取已下载大小
     * 
     * @param bool $formatted 是否格式化为易读的单位（KB/MB/GB）
     * @param int $decimals 格式化时保留的小数位数
     * @return int|string 已下载大小，如果$formatted为true返回字符串，否则返回字节数
     */
    public function getDownloadedSize(bool $formatted = false, int $decimals = 2): string|int
    {
        if ($formatted) {
            return $this->formatBytes($this->count, $decimals);
        }
        return $this->count;
    }
    
    /**
     * 获取下载进度百分比
     * 
     * @param int $decimals 保留的小数位数
     * @return float 进度百分比（0-100），如果总大小未知则返回0
     */
    public function getProgressPercentage(int $decimals = 2): float
    {
        if ($this->length <= 0) {
            return 0;
        }
        
        $percentage = ($this->count / $this->length) * 100;
        return round($percentage, $decimals);
    }
    
    /**
     * 获取下载进度详细信息
     * 
     * @return array 包含下载详情的数组
     */
    public function getProgressInfo(): array
    {
        return [
            'total' => $this->formatBytes($this->length),
            'downloaded' => $this->formatBytes($this->count),
            'percentage' => $this->getProgressPercentage(2),
        ];
    }
    
    /**
     * 设置进度回调函数
     * 每秒调用一次回调函数，传递当前进度信息
     * 
     * @param callable $callback 回调函数，接收一个参数：进度信息数组
     * @return int 定时器ID，可用于手动清除定时器
     */
    public function onProgress(callable $callback)
    {
        $timerId = null;
        $timerId = Simple::onInterval(function() use ($callback, &$timerId) {
            // 下载完成时清除定时器
            if ($this->count >= $this->length) {
                Simple::clearInterval($timerId);
            }
            
            // 调用用户回调，传递进度信息
            $callback([
                'total'      => $this->formatBytes($this->length),
                'downloaded' => $this->formatBytes($this->count),
                'percentage' => $this->getProgressPercentage(2),
            ]);
        }, 1); // 每秒执行一次
        
        return $timerId;
    }
    
    /**
     * 格式化字节数为易读的单位
     * 
     * @param int $bytes 字节数
     * @param int $decimals 保留的小数位数
     * @return string 格式化后的字符串，如 "1.23 MB"
     */
    private function formatBytes(int $bytes, int $decimals = 2): string
    {
        if ($bytes <= 0) {
            return "0 B";
        }
        
        $units = array_reverse(self::BYTE_UNITS);
        
        foreach ($units as $unit => $size) {
            if ($bytes >= $size) {
                $value = $bytes / $size;
                return number_format($value, $decimals) . " " . $unit;
            }
        }
        
        return number_format($bytes, $decimals) . " B";
    }
    
    /**
     * 关闭句柄，清理资源
     * 在下载完成或出错时调用
     */
    public function handleClose()
    {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
            $this->fileHandle = null;
        }
        
        if ($this->stream) {
            fclose($this->stream);
            $this->stream = null;
        }
    }
    
    /**
     * 读取数据块并写入文件
     * 由事件循环自动调用
     * 
     * @param int $id 连接ID
     * @param resource $stream 流资源
     */
    public function handleRead($id, $stream)
    {
        // 读取数据块
        $data = fread($stream, 8192);
        
        if ($data) {
            // 更新已下载字节数并写入文件
            $this->count += strlen($data);
            fwrite($this->fileHandle, $data);
            
            // 如果已下载完毕，关闭句柄
            if ($this->count >= $this->length) {
                $this->handleClose();
            }
        }
    }
    
    /**
     * 是否下载完成
     * 
     * @return bool 如果下载完成返回true
     */
    public function isCompleted(): bool
    {
        return $this->count >= $this->length && $this->length > 0;
    }
    
    /**
     * 析构函数，确保资源被正确释放
     */
    public function __destruct()
    {
        $this->handleClose();
    }
}
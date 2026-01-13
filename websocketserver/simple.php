<?php

/**
 * Simple - 简单的事件驱动 WebSocket 服务器核心类
 * 
 * 这个类提供了一个轻量级的事件循环系统，支持：
 * 1. 流（socket）的异步I/O管理
 * 2. 定时循环回调（onLoop）
 * 3. 间隔定时器（onInterval）
 * 4. 事件驱动的服务器架构
 */
class Simple
{
    // ==================== 静态属性定义 ====================
    
    /** @var int 客户端连接ID计数器，为每个新连接生成唯一ID */
    protected static $id = 0;
    
    /** @var int 定时器ID计数器，为每个新定时器生成唯一ID */
    protected static $intervalId = 0;
    
    /** @var array 存储所有流资源的数组，键为ID，值为stream资源 */
    protected static $streams = [];
    
    /** @var array 存储所有流对应的实例对象，键为ID，值为对象实例 */
    protected static $instances = [];
    
    /** @var array 存储主循环回调函数的数组，每个元素是一个可调用对象 */
    protected static $onLoops = [];
    
    /** @var array 存储间隔定时器的数组，键为定时器ID，值为定时器配置 */
    protected static $onIntervals = [];
    
    
    // ==================== 循环回调管理 ====================
    
    /**
     * 添加主循环回调函数
     * 
     * 在每次事件循环迭代中都会执行这些回调函数
     * 适用于需要频繁执行的逻辑，如状态检查、统计信息更新等
     * 
     * @param callable $cb 回调函数，无参数
     * @return void
     */
    public static function onLoop(callable $cb)
    {
        static::$onLoops[] = $cb;
    }
    
    
    // ==================== 定时器管理 ====================
    
    /**
     * 添加间隔定时器
     * 
     * 创建一个按照指定间隔重复执行的定时器
     * 定时器会在每个事件循环迭代中检查是否到达执行时间
     * 
     * @param callable $callback 回调函数，定时器触发时执行
     * @param int $interval 执行间隔（秒）
     * @return int 返回定时器ID，可用于后续清除定时器
     */
    public static function onInterval(callable $callback, int $interval)
    {
        // 生成唯一定时器ID
        $id = ++static::$intervalId;
        
        // 存储定时器配置
        static::$onIntervals[$id] = [
            'callback' => $callback,   // 回调函数
            'interval' => $interval,   // 执行间隔（秒）
            'time' => time()           // 上次执行时间戳
        ];
        
        return $id;
    }
    
    /**
     * 清除间隔定时器
     * 
     * 根据定时器ID移除定时器，停止其后续执行
     * 
     * @param int $id 定时器ID，由onInterval方法返回
     * @return void
     */
    public static function clearInterval($id) {
        unset(static::$onIntervals[$id]);
    }
    
    
    // ==================== 流管理 ====================
    
    /**
     * 添加流资源到管理器中
     * 
     * 将流资源（通常是socket连接）添加到事件循环中进行监控
     * 当流可读时，会调用对应实例的handleRead方法
     * 
     * @param resource $stream 流资源（如socket连接）
     * @param mixed $instance 处理该流的对象实例
     * @return int 返回流ID，可用于后续引用该流
     */
    public static function add($stream, $instance)
    {
        // 设置流为非阻塞模式，避免I/O操作阻塞事件循环
        stream_set_blocking($stream, false);
        
        // 生成唯一流ID
		static::$id++;
        
        // 存储流资源和对应的实例
        static::$streams[static::$id] = $stream;
        static::$instances[static::$id] = $instance;
        
        return static::$id;
    }

    /**
     * 移除流资源
     * 
     * 从管理器中移除指定的流，不再监控其状态
     * 注意：此方法不会关闭流资源，调用者需要自行处理资源清理
     * 
     * @param int $id 流ID，由add方法返回
     * @return void
     */
    public static function remove($id)
    {
        // 从流数组和实例数组中移除对应条目
        unset(static::$streams[$id]);
        unset(static::$instances[$id]);
    }
    
    // ==================== 辅助方法 ====================
    
    /**
     * 获取管理器统计信息
     * 
     * 返回当前管理器中各种资源的数量统计
     * 用于监控和调试
     * 
     * @return array 统计信息数组
     */
    public static function stats()
    {
        return [
            'total_streams' => count(static::$streams),
            'total_instances' => count(static::$instances),
            'loop_callbacks' => count(static::$onLoops),
            'intervals' => count(static::$onIntervals),
            'last_id' => static::$id,
            'last_interval_id' => static::$intervalId
        ];
    }
    
    /**
     * 关闭所有流资源
     * 
     * 清理所有管理的流资源，关闭连接
     * 通常用于服务器关闭时调用
     * 
     * @return void
     */
    public static function shutdown()
    {
        foreach(static::$streams as $id => $stream) {
            if (is_resource($stream)) {
                fclose($stream);
            }
        }
        
        // 清空所有数组
        static::$streams = [];
        static::$instances = [];
        static::$onLoops = [];
        static::$onIntervals = [];
        
        // 重置计数器
        static::$id = 0;
        static::$intervalId = 0;
    }
    
    // ==================== 事件循环主逻辑 ====================
    
    /**
     * 启动事件循环
     * 
     * 这是服务器的核心方法，启动无限循环的事件处理：
     * 1. 执行主循环回调
     * 2. 检查并执行间隔定时器
     * 3. 监控所有流资源的可读事件
     * 4. 处理就绪的流事件
     * 
     * 循环会一直运行直到脚本被终止
     * 
     * @return void
     */
    public static function run()
    {
        // 流选择器的参数初始化
        $write  = null;    // 不需要监控可写流
        $except = null;    // 不需要监控异常流
        $tv_sec  = 0;      // select超时时间（秒），避免无限阻塞
        $tv_usec = 1000;   // select超时时间（微秒）
        
        // 主事件循环，无限运行
        while(true)
        {
            // ===== 步骤1：执行主循环回调 =====
            // 执行所有注册的onLoop回调函数
            foreach(static::$onLoops as $callbacks) {
                $callbacks();
            }
            
            // ===== 步骤2：检查并执行间隔定时器 =====
            // 遍历所有定时器，检查是否到达执行时间
            foreach(static::$onIntervals as $id => $interval)
            {
                // 计算距离上次执行的时间差
                if ((time() - $interval['time']) >= $interval['interval']) {
                    // 更新定时器最后执行时间
                    static::$onIntervals[$id]['time'] = time();
                    
                    // 执行定时器回调
                    $interval['callback']();
                }
            }
            
            
            // ===== 步骤3：构建可读流数组 =====
            $read = static::$streams;
            
            
            // ===== 步骤4：使用stream_select监控流状态 =====
            // 会修改$read数组，只保留当前可读的流
            @stream_select(
                $read,      // 输入：要监控的可读流数组；输出：实际可读的流
                $write,     // 可写流数组（未使用）
                $except,    // 异常流数组（未使用）
                $tv_sec,    // 超时时间（秒）
                $tv_usec    // 超时时间（微秒）
            );
            
            
            // ===== 步骤5：处理就绪的流 =====
            // 遍历所有可读的流，调用对应实例的handleRead方法
            foreach($read as $id => $stream)
            {
                // 如果实例里有 handleRead 方法就执行它
                if (is_callable([static::$instances[$id], 'handleRead'])) {
                    static::$instances[$id]->handleRead($id, $stream);
                }

                // 判断是否是有效的流或流以关闭
                if (!is_resource($stream) || feof($stream)) {

                    // 如果实例里有 handleClose 就执行它
                    if (is_callable([static::$instances[$id], 'handleClose'])) {
                        static::$instances[$id]->handleClose($id, $stream);
                    }

                    // 从管理器中移除无效流
                    static::remove($id);
                }
            }
            
            // 注意：这里没有显式的usleep，因为stream_select已经提供了阻塞/超时机制
            // 当没有流事件时，循环会等待最多1秒，避免CPU占用过高
        }
    }
}
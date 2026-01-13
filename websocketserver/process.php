<?php

class Process
{
    private $command;         // 完整的启动命令字符串
    private $cwd;             // 工作目录
    private $env;             // 环境变量（可选）

    private $process      = null; // proc_open 返回的资源
    private $pipes        = [];   // [0 => stdin, 1 => stdout, 2 => stderr]
    private $stdoutBuffer = '';
    private $stderrBuffer = '';


    public function __construct(string $command, string $cwd, array $env = null)
    {
        $this->command     = $command;
        $this->cwd         = $cwd;
        $this->env         = $env;
    }

    /**
     * 启动外部进程
     */
    public function start(): bool
    {
        if ($this->isRunning()) {
            return false;
        }

        $descriptorspec = [
            0 => ["pipe", "r"],  // stdin  - 用于向进程输入命令
            1 => ["pipe", "w"],  // stdout - 标准输出
            2 => ["pipe", "w"],  // stderr - 错误输出
        ];

        $this->process = proc_open(
            $this->command,
            $descriptorspec,
            $this->pipes,
            $this->cwd,
            $this->env,
            ['bypass_shell' => true]  // Windows 下推荐，避免 shell 解析问题
        );

        if (!is_resource($this->process)) {
            return false;
        }

        // stdin 保持阻塞（写命令时需要），stdout/stderr 尝试非阻塞（Windows 无效但保留）
        stream_set_blocking($this->pipes[0], true);
        stream_set_blocking($this->pipes[1], false);
        stream_set_blocking($this->pipes[2], false);

        return true;
    }

    public function getCommand()
    {
        return $this->command;
    }

    /**
     * 向进程发送命令（末尾自动加换行）
     */
    public function writeCommand(string $command): bool
    {
        if (!$this->isRunning() || !is_resource($this->pipes[0])) {
            return false;
        }

        $command = rtrim($command) . "\n";
        return (bool)fwrite($this->pipes[0], $command);
    }

    /**
     * 读取标准信息
     */
    public function freadStdout()
    {
        if (!$this->isRunning() || !is_resource($this->pipes[1])) {
            return [];
        }

        $this->stdoutBuffer .= $this->readPipeNonBlocking($this->pipes[1]);
		$lines = explode("\n", $this->stdoutBuffer);
		
        if (array_pop($lines) === '') {
            $this->stdoutBuffer = '';
            return $lines;
        }

        return [];
    }

    /**
     * 读取错误信息
     */
    public function freadStderr()
    {
        if (!$this->isRunning() || !is_resource($this->pipes[2])) {
            return [];
        }

        $this->stderrBuffer .= $this->readPipeNonBlocking($this->pipes[2]);
		$lines = explode("\n", $this->stderrBuffer);
		
        if (array_pop($lines) === '') {
            $this->stderrBuffer = '';
            return $lines;
        }

        return [];
    }

    /**
     * 判断程序是否在运行
     */
    public function isRunning(): bool
    {
        if (is_resource($this->process)) {
            return proc_get_status($this->process)['running'];
        }

        return false;
    }

    /**
     * 强制终止进程
     */
    public function kill(): void
    {
        if ($this->isRunning() && is_resource($this->process)) {
            proc_terminate($this->process);
        }
    }

    /**
     * 关闭所有资源
     */
    public function close()
    {
        foreach($this->pipes as $pipe) {
            if (is_resource($pipe)) {
                fclose($pipe);
            }
        }
		
        if (is_resource($this->process)) {
			proc_terminate($this->process);
            proc_close($this->process);
        }

        $this->process = null;
        $this->pipes   = [];
    }

    // ==================== 私有方法 ====================

    /**
     * Windows 兼容的非阻塞 pipe 读取
     */
    private function readPipeNonBlocking($pipe): string|false
    {
        if (!is_resource($pipe)) {
            return false;
        }

        $stat = fstat($pipe);
        if (!$stat) {
            return false;
        }

        $available = $stat['size'] ?? $stat['unread_bytes'] ?? 0;
        if ($available <= 0) {
            return '';
        }

        return fread($pipe, 8192);
    }
}
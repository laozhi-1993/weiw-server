<?php

class Process
{
    private $cwd;             // 工作目录
    private $env;             // 环境变量（可选）

    private $process      = null; // proc_open 返回的资源
    private $pipes        = [];   // [0 => stdin, 1 => stdout, 2 => stderr]
    private $stdoutBuffer = '';
    private $stderrBuffer = '';


    public function __construct(string $cwd, array|null $env = null)
    {
        $this->cwd = $cwd;
        $this->env = $env;
    }

    /**
     * 发送命令
     */
    public function send(string $command): bool
    {
        try
        {
            if ($this->isRunning()) {
                return false;
            }

            $filePath = $this->cwd . DIRECTORY_SEPARATOR . $command;
            if (file_exists($filePath) && is_file($filePath)) {
                $command = $filePath;
            }

            $descriptorspec = [
                0 => ["pipe", "r"],  // stdin  - 用于向进程输入命令
                1 => ["pipe", "w"],  // stdout - 标准输出
                2 => ["pipe", "w"],  // stderr - 错误输出
            ];

            $this->process = proc_open(
                $command,
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
        catch(error $error)
        {
            return false;
        }
    }

    /**
     * 向进程发送命令（末尾自动加换行）
     */
    public function writeCommand(string $command): bool
    {
        if (!isset($this->pipes[0])) {
            return false;
        }

        if (!is_resource($this->pipes[0])) {
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
        if (!isset($this->pipes[1])) {
            return [];
        }

        if (!is_resource($this->pipes[1])) {
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
        if (!isset($this->pipes[2])) {
            return [];
        }

        if (!is_resource($this->pipes[2])) {
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
     * 判断是否是 windows 系统
     */
    public function isWindows()
    {
        return PHP_OS_FAMILY === 'Windows';
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
    private function readPipeNonBlocking($pipe): string
    {
		if (!is_resource($pipe)) {
			return false;
		}

        if ($this->isWindows())
        {
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
        else
        {
			$read   = [$pipe];
			$write  = null;
			$except = null;

			// 超时设很短，避免阻塞太久（0.05秒 ~ 0.2秒 都行）
			$changed = @stream_select($read, $write, $except, 0, 50000); // 50ms

			if ($changed === false) {
				// select 出错（罕见）
				return '';
			}

			if ($changed === 0) {
				// 超时 → 暂无数据
				return '';
			}

			// 有数据可读了，安全读取
			$data = @fread($pipe, 8192);
			return $data !== false ? $data : '';
		}
    }
}
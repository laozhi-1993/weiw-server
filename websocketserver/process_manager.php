<?php

class process_manager
{
    /** @var ManagedProcess[] */
    private array $processes = [];
	private $websocket;
	private $rootdir;
	private $runscript;

    public function __construct(web_socket_server $websocket, string $rootdir)
    {
        $this->websocket = $websocket;
		$this->rootdir = $rootdir;
		
		if (!is_dir($rootdir)) {
			mkdir($rootdir, 0777, true);
		}
		
		if (PHP_OS_FAMILY === 'Windows') {
			$this->runscript = 'run.bat';
		} else {
			$this->runscript = 'run.sh';
		}
    }

	public function update()
	{
		$names = [];
		$directorys = array_map('realpath', glob("{$this->rootdir}/*", GLOB_ONLYDIR));
		
		foreach($directorys as $directory)
		{
			$name = basename($directory);
			$names[$name] = null;
			
			if (!isset($this->processes[$name])) {
				$this->processes[$name] = new Process($directory);
			}
		}
		
		
		$result = array_diff_key($this->processes, $names);
		
		foreach($result as $name => $processe) {
			$processe->close();
			unset($this->processes[$name]);
		}
	}

    /**
     * 根据客户端获取进程实例
     */
    public function getProcesse(web_socket_client $client)
    {
		$queryParams = $client->getQueryParams();
		
		if (!isset($queryParams['name'])) {
			return [null, null];
		}
		
        if (!isset($this->processes[$queryParams['name']])) {
            return [null, null];
        }
		
        return [$queryParams['name'], $this->processes[$queryParams['name']]];
    }

    /**
     * 获取所有进程（返回 ManagedProcess[]）
     */
    public function all(): array
    {
        return $this->processes;
    }

    /**
     * 获取当前管理的进程总数（包括运行中和已停止的）
     */
    public function count(): int
    {
        return count($this->processes);
    }

    /**
     * 获取正在运行的进程数量
     */
    public function countRunning(): int
    {
        return count($this->running());
    }

    /**
     * 获取已停止的进程数量（仍保存在管理器中但未运行）
     */
    public function countStopped(): int
    {
        return $this->count() - $this->countRunning();
    }

    /**
     * 获取所有正在运行的进程
     */
    public function running(): array
    {
        return array_filter($this->processes, fn($p) => $p->isRunning());
    }

	public function start()
	{
		$this->websocket->onConnect(function ($ws, $client) {
			
			$cookies = $client->getCookies();
			$token = $cookies['login_token'] ?? '';
			
			$user = mc_user_authentication::getUser($token);
			if (!$user || !$user->isAdmin()) {
				$client->send(web_socket_client::encode('没有权限'));
				$client->close();
				return;
			}
			
			[$name, $Process] = $this->getProcesse($client);
			
			if (!$name) {
				$client->send(web_socket_client::encode('服务器不存在'));
				$client->close();
				return;
			}
		});


		$this->websocket->onMessage(function ($ws, $client, $msg) {
			
			[$name, $Process] = $this->getProcesse($client);
			
			if ($name) {
				
				if ($msg === 'start') {
					$Process->send($this->runscript);
					return;
				}
				
				if ($msg === 'kill') {
					$Process->kill();
					return;
				}
				
				if ($Process->isRunning())
				{
					$Process->writeCommand($msg);
				}
				else
				{
					$Process->send($msg);
				}
				
				return;
			}
			
			$client->close();
		});


		Simple::onInterval(function() {
			
			foreach ($this->all() as $name => $Process)
			{
				$state = '';
				if ($Process->isRunning()) {
					$state = '{start}';
				} else {
					$state = '{stop}';
				}
				
				$state = web_socket_client::encode($state);
				$this->websocket->broadcast($name, $state);
			}
		}, 1);


		Simple::onLoop(function () {
			
			foreach ($this->all() as $name => $Process)
			{
				foreach($Process->freadStdout() as $stdout) {
					$stdout = mb_convert_encoding($stdout, 'UTF-8', 'GBK');
					$stdout = web_socket_client::encode($stdout);
					
					$this->websocket->broadcast($name, $stdout);
				}

				foreach($Process->freadStderr() as $stderr) {
					$stderr = mb_convert_encoding($stderr, 'UTF-8', 'GBK');
					$stderr = web_socket_client::encode($stderr);
					
					$this->websocket->broadcast($name, $stderr);
				}
			}
			
			$this->update();
		});
	}
}

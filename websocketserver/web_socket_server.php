<?php

/**
 * WebSocket 服务器
 */
class web_socket_server
{
    /** @var resource 服务端 socket */
    protected $server;

    /** @var Client[] 所有客户端 */
    protected $clients = [];

    /** 初始化心跳时间 */
    protected $lastPing;

    /** 心跳检测间隔（秒） */
    protected $heartbeatInterval = 1;

    /** 心跳超时时间（秒） */
    protected $heartbeatTimeout  = 60;

    /* ========= 事件回调 ========= */
    protected $onConnects  = [];
    protected $onCloses    = [];
    protected $onMessages  = [];
    protected $onSendBody;

    /**
     * 构造函数
     * @param string $host 监听地址
     * @param int    $port 监听端口
     */
    public function __construct($host = '0.0.0.0', $port = 9001)
    {
        $this->lastPing = time();
        $errno = 0;
        $errstr = '';

        // 创建 TCP 服务
        $this->server = stream_socket_server(
            "tcp://{$host}:{$port}",
            $errno,
            $errstr
        );

        if ($this->server === false) {
            throw new RuntimeException(
                "无法启动 WebSocket 服务器: {$errstr} (错误代码: {$errno})"
            );
        }


        Simple::add($this->server, $this);
		Simple::onInterval([$this, 'checkHeartbeat'], $this->heartbeatInterval);

        echo "WebSocket server started on {$host}:{$port}\n";
    }

    /* ========= 事件注册 ========= */

    /** 连接建立事件 */
    public function onConnect (callable $cb) { $this->onConnects[] = $cb; }

    /** 连接关闭事件 */
    public function onClose   (callable $cb) { $this->onCloses[]   = $cb; }

    /** 接收消息事件 */
    public function onMessage (callable $cb) { $this->onMessages[] = $cb; }

    /** 发送body事件 */
    public function onSendBody(callable $cb) { $this->onSendBody   = $cb; }

    /* ========= 客户端管理 ========= */

    /** 获取所有客户端 */
    public function getAllClients(): array
    {
        return $this->clients;
    }

    /** 获取当前连接数 */
    public function getClientCount(): int
    {
        return count($this->clients);
    }

    /* ========= 对外操作 ========= */

    /** 向所有已握手客户端广播消息 */
    public function broadcast(string $name, string $message)
    {
        foreach ($this->clients as $client) {
            if ($client->isHandshaked()) {
                $getQueryParams = $client->getQueryParams();
                if (isset($getQueryParams['name']) && $getQueryParams['name'] === $name) {
					$client->send($message);
                }
            }
        }
    }

	/** 心跳检测 */
	public function checkHeartbeat()
	{
		foreach ($this->clients as $client) {
			if ($client->isHandshaked()) {

				// 超时未响应 pong
				if (time() - $client->getLastPong() > $this->heartbeatTimeout) {
					// 关闭客户端
					$client->close();
				} else {
					// 发送 ping
					$client->send(web_socket_client::encode('', 0x9));
				}
			}
		}
	}

    /** WebSocket 握手 */
    public function handshake(web_socket_client $client, string $data): bool
    {
        if (preg_match('#Sec-WebSocket-Key:\s*(.+)\r\n#i', $data, $m)) {
            /* ---- 计算 Sec-WebSocket-Accept ---- */
            $accept = base64_encode(
                sha1(trim($m[1]) . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true)
            );

            /* ---- 返回握手响应 ---- */
            $resp  = "HTTP/1.1 101 Switching Protocols\r\n";
            $resp .= "Upgrade: websocket\r\n";
            $resp .= "Connection: Upgrade\r\n";
            $resp .= "Sec-WebSocket-Accept: $accept\r\n\r\n";

            $client->send($resp);
            $client->setHandshaked();

            return true;
        }

        return false;
    }

    /** http 握手 */
    public function buildResponse(web_socket_client $client, int $status, string $body)
    {
        $statuses = [
            200 => 'OK',
            404 => 'Not Found',
            500 => 'Internal Server Error'
        ];

        $statusText = $statuses[$status];
        $length = strlen($body);

        $text  = "HTTP/1.1 {$status} {$statusText}\r\n";
        $text .= "Content-Type: text/html; charset=utf-8\r\n";
        $text .= "Content-Length: {$length}\r\n";
        $text .= "Connection: close\r\n\r\n";
        $text .= $body;

        $client->send($text);
    }

    /* ========= 触发 ========= */

	public function handleClose($id, $stream)
	{
        unset($this->clients[$id]);

        foreach($this->onCloses as $onClose) {
            ($onClose)($id, $this);
        }
	}

    public function handleRead($id, $stream)
    {
		/* ======== 新连接 ======== */
		if ($stream === $this->server) {
			$conn = @stream_socket_accept($this->server, 0);
			if ($conn) {
				$id = Simple::add($conn, $this);
				$this->clients[$id] = new web_socket_client($id, $conn);
			}
			return;
		}

		/* ===== 已连接客户端 ===== */
		$client = $this->clients[$id] ?? null;
		if (!$client) {
			return;
		}

		if (!$client->appendBuffer()) {
            $client->close();
			return;
		}

		// 尚未完成握手
		if (!$client->isHandshaked()) {

			if ($client->getHeaderBuffer($data))
			{
				$client->parseAndSaveHeaders($data);
				$client->parseAndSaveCookies($data);
				$client->parseAndSaveQueryParams($data);


				if ($client->isWebSocket()) {
					if ($this->handshake($client, $data)) {
						foreach($this->onConnects as $onConnect) {
					    	($onConnect)($this, $client);
					    }
					} else {
                        $client->close();
                    }
				} else {
					if ($this->onSendBody) {
						$body = ($this->onSendBody)($this, $client);
					} else {
						$body = 'Hello World!';
					}

					$this->buildResponse($client, 200, $body);
				}
			}

			return;
		}

		// 获取数据
		if (!$client->getFrame($frame)) return;

		switch ($frame['opcode']) {

			// 文本消息
			case 0x1:
				foreach($this->onMessages as $onMessage) {
					($onMessage)($this, $client, $frame['payload']);
				}
				break;

			// 关闭连接
			case 0x8:
				$client->close();
				break;

			// pong 响应
			case 0xA:
				$client->touchPong();
				break;
		}
    }
}

<?php
/**
 * 客户端对象
 * 用于表示一个 WebSocket 连接客户端
 */
class web_socket_client
{
    /** @var resource 客户端 socket 资源 */
    protected $socket;

    /** @var int 客户端唯一 ID */
    protected $id;

    /** @var string 存储数据 */
    protected $buffer = '';

    /** @var bool 是否已完成 WebSocket 握手 */
    protected $handshaked = false;

    /** @var int 最近一次收到 pong 的时间戳 */
    protected $lastPong;

    /** @var array 客户端携带的 Cookie */
    protected $cookies = [];

    /** @var array 客户端携带的 queryParams */
    protected $queryParams = [];

    /* ========= Headers ========= */
    protected $requestHeaders = [];
    protected $requestMethod = '';
    protected $requestPath = '';

    /**
     * 构造函数
     * @param resource $socket 客户端 socket
     */
    public function __construct(int $id, $socket)
    {
        $this->id       = $id;
        $this->socket   = $socket;
        $this->lastPong = time();       // 初始化心跳时间
    }

    /* ========= 基础信息 ========= */

    /** 获取客户端 ID */
    public function getId(): int
    {
        return $this->id;
    }

    /** 获取 socket 资源 */
    public function getSocket()
    {
        return $this->socket;
    }

    /** 获取 method */
    public function getMethod(): string
    {
        return $this->requestMethod;
    }

    /** 获取 path */
    public function getPath(): string
    {
        return $this->requestPath;
    }

    /** 获取所有 Header */
    public function getHeaders(): array
    {
        return $this->requestHeaders;
    }

    /** 获取所有 Cookie */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    /** 获取所有 QueryParam */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /** 获取数据 */
    public function getBuffer(): string
    {
        return $this->buffer;
    }

    /** 判断报头完成则获取数据并清空数据 */
    public function getHeaderBuffer(&$buffer): bool
    {
        if (str_contains($this->buffer, "\r\n\r\n")) {
            $buffer = $this->buffer;
            $this->buffer = '';
            return true;
        }

        return false;
    }

    /** 判断帧完成则获取数据并清空数据 */
    public function getFrame(&$frame): bool
    {
        $frame = web_socket_client::decode($this->getBuffer());
        if ($frame) {
            $this->setBuffer('');
            return true;
        }

        return false;
    }

    /** 是否已完成握手 */
    public function isHandshaked(): bool
    {
        return $this->handshaked;
    }

    /** 是否是 websocket 连接 */
    public function isWebSocket(): bool
    {
        $headers = $this->getHeaders();
        if (!isset($headers['Connection'])) {
            return false;
        }

        if (!isset($headers['Upgrade'])) {
            return false;
        }

        return ($headers['Connection'] === 'Upgrade' && $headers['Upgrade'] === 'websocket');
    }

    /** 设置握手状态 */
    public function setHandshaked(bool $value = true)
    {
        $this->handshaked = $value;
    }


    public function setBuffer(string $data)
    {
        $this->buffer = $data;
    }

    /* ======== 解析报头 ======= */

    /** 解析 Header 并保存 */
    public function parseAndSaveHeaders(string $data): bool
    {
        [$header, $body] = explode("\r\n\r\n", $data, 2);
        if ($body === null) {
            return false;
        }

        $lines = explode("\r\n", $header);
        $requestLine = array_shift($lines);
        foreach($lines as $line) {
            if ((trim($line) !== '') && (strpos($line, ':') !== false)) {
                [$key, $value] = explode(':', $line, 2);

                $key = trim($key);
                $value = trim($value);
                $this->requestHeaders[$key] = $value;
            }
        }

        if (preg_match('#^(\w+)\s+([^\s]+)\?([^\s]+)\s+HTTP/#i', $requestLine, $m)) {
            $requestMethod = $m[1];
            $requestPath   = $m[2];
        }

        return true;
    }

    /** 解析 Cookie 并保存 */
    public function parseAndSaveCookies(string $data): bool
    {
        if (preg_match('#Cookie:\s*(.+)\r\n#i', $data, $m)) {
            $items = explode(';', $m[1]);
            foreach ($items as $item) {
                [$key, $value] = explode('=', $item, 2);

                $key = trim($key);
                $value = trim($value);
                $this->cookies[$key] = urldecode($value);
            }

            return true;
        }

        return false;
    }

    /** 解析 QueryParam 并保存 */
    public function parseAndSaveQueryParams(string $data): bool
    {
        if (preg_match('#^GET\s+([^\s\?]+)(\?([^\s]*))?\s+HTTP#i', $data, $m)) {
            $path = $m[1];                    // 如 /ws
            $queryString = $m[3] ?? '';       // 查询字符串部分（如 token=abc&user=123）

            if ($queryString !== '') {
                parse_str($queryString, $this->queryParams);
                // parse_str 会自动 urldecode
            }

            return true;
        }

        return false;
    }

    /* ========= 心跳 ========= */

    /** 更新 pong 时间（客户端响应 ping） */
    public function touchPong()
    {
        $this->lastPong = time();
    }

    /** 获取最近一次 pong 时间 */
    public function getLastPong(): int
    {
        return $this->lastPong;
    }

    /* ========= 帧处理 ========= */

    /**
     * 解码 WebSocket 数据帧
     */
	static function decode(string $data): array|false
	{
		if (strlen($data) < 2) {
			return false; // 帧头不完整
		}
		
		$firstByte = ord($data[0]);
		$secondByte = ord($data[1]);
		
		// 解析帧头
		$fin = ($firstByte & 0x80) >> 7;
		$opcode = $firstByte & 0x0F;
		$masked = ($secondByte & 0x80) >> 7;
		$len = $secondByte & 0x7F;
		
		if (!$masked) {
			return false; // 客户端帧必须掩码
		}
		
		// 计算偏移量和实际长度
		$offset = 2;
		if ($len === 126) {
			if (strlen($data) < $offset + 2) return false;
			$len = unpack('n', substr($data, $offset, 2))[1];
			$offset += 2;
		} elseif ($len === 127) {
			if (strlen($data) < $offset + 8) return false;
			$len = unpack('J', substr($data, $offset, 8))[1];
			$offset += 8;
		}
		
		// 检查数据完整性
		if (strlen($data) < $offset + 4 + $len) {
			return false;
		}
		
		// 提取掩码和负载
		$mask = substr($data, $offset, 4);
		$payload = substr($data, $offset + 4, $len);
		
		// 解掩码
		$decoded = '';
		for ($i = 0; $i < $len; $i++) {
			$decoded .= $payload[$i] ^ $mask[$i % 4];
		}
		
		return [
			'fin' => $fin,
			'opcode' => $opcode,
			'masked' => $masked,
			'length' => $len,
			'payload' => $decoded
		];
	}

    /**
     * 编码 WebSocket 数据帧
     */
    static function encode(string $payload, int $opcode = 0x1): string
    {
        // FIN + opcode
        $frame = chr(0x80 | $opcode);
        $len   = strlen($payload);

        if ($len <= 125) {
            $frame .= chr($len);
        } elseif ($len < 65536) {
            $frame .= chr(126) . pack('n', $len);
        } else {
            $frame .= chr(127) . pack('J', $len);
        }

        return $frame . $payload;
    }

    /* ========= 读取 ========= */

    /** 向客户端读取数据 */
    public function read(): string|false
    {
        $data = @fread($this->socket, 8192);
        if ($data === false || $data === '') {
            return false;
        }

        return $data;
    }


    public function appendBuffer(): bool
    {
        $data = $this->read();
        if ($data) {
            $this->buffer .= $data;
            return true;
        }

        return false;
    }

    /* ========= 发送 ========= */

    /** 向客户端发送数据 */
    public function send(string $data)
    {
        if (is_resource($this->socket)) {
            fwrite($this->socket, $data);
        }
    }

    /** 关闭客户端连接 */
    public function close()
    {
        if (is_resource($this->socket)) {
            fclose($this->socket);
        }
    }
}

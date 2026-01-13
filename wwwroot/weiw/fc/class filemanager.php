<?php


/**
 * 文件管理类
 * 所有操作限制在指定的根目录内，防止越界访问
 * 支持：列表、上传、创建文件夹、删除（递归）、移动、复制、重命名、递归获取所有文件
 */
class FileManager
{
    private string $rootPath;        // 根目录绝对路径（真实路径）
    private string $baseUrl;         // 访问文件的完整域名+端口基础URL，例如：https://example.com/storage/

    /**
     * 构造函数
     * @param string $rootPath 允许操作的根目录（服务器绝对路径）
     * @param string $baseUrl  文件下载链接的前缀（带协议、域名、端口，可选路径）
     */
    public function __construct(string $rootPath, string $baseUrl = '')
    {
        $this->rootPath = rtrim(realpath($rootPath), DIRECTORY_SEPARATOR) ?: $rootPath;
        if (!is_dir($this->rootPath)) {
            mkdir($this->rootPath, 0777, true);
        }

        // 确保 baseUrl 以 / 结尾
        $this->baseUrl = rtrim($baseUrl, '/') . '/';
    }

    /**
     * 规范化路径，防止目录穿越，并确保在根目录内
     * @param string $path 相对路径
     * @return string 绝对路径（如果非法返回根目录）
     */
    private function safePath(string $path = ''): string
    {
        $path = trim($path, '/\\');

        if ($path === '' || $path === '.' || $path === '..') {
            return $this->rootPath;
        }

        $fullPath = realpath($this->rootPath . DIRECTORY_SEPARATOR . $path);

        // realpath 失败或不在根目录内，则返回根目录
        if ($fullPath === false || strpos($fullPath, $this->rootPath . DIRECTORY_SEPARATOR) !== 0) {
            return $this->rootPath;
        }

        return $fullPath;
    }

    /**
     * 获取相对路径（相对于根目录）
     * @param string $fullPath 绝对路径
     * @return string
     */
    private function getRelativePath(string $fullPath): string
    {
        if (strpos($fullPath, $this->rootPath . DIRECTORY_SEPARATOR) === 0) {
            $relative = substr($fullPath, strlen($this->rootPath) + 1);
            return str_replace('\\', '/', $relative);
        }
        return '';
    }

    /**
     * 获取上一级目录的相对路径
     * 示例：
     *   'a/b/c'     => 'a/b'
     *   'a/b/'      => 'a'
     *   'images'    => ''
     *   ''          => ''
     *   '/'         => ''
     *   'docs/../images' => '' （经过 safePath 安全处理后）
     *
     * @param string $path 当前相对路径（可带或不带首尾斜杠）
     * @return string 上一级目录的相对路径（空字符串表示根目录）
     */
    public function getParentDir(string $path = ''): string
    {
        // 先进行路径安全校验，防止目录穿越
        $absPath = $this->safePath($path);

        // 如果就是根目录，直接返回空字符串
        if ($absPath === $this->rootPath) {
            return '';
        }

        // 获取当前路径的父目录（服务器绝对路径）
        $parentAbs = dirname($absPath);

        // 如果父目录就是根目录，返回空字符串
        if ($parentAbs === $this->rootPath || $parentAbs === DIRECTORY_SEPARATOR) {
            return '';
        }

        // 转换为相对于根目录的路径，并统一使用正斜杠
        $parentRelative = $this->getRelativePath($parentAbs);
        return str_replace('\\', '/', $parentRelative);
    }

    /**
     * 将相对路径解析为面包屑导航数组
     * 示例：'a/b/c/d' => ['a' => '/a', 'b' => '/a/b', 'c' => '/a/b/c', 'd' => '/a/b/c/d']
     * 
     * @param string $path 相对路径（可带或不带首尾斜杠）
     * @return array
     */
    public function getBreadcrumb(string $path = ''): array
    {
        // 先安全化路径，防止目录穿越
        $absPath = $this->safePath($path);
    
        // 获取相对于根目录的路径（已统一为 / 分隔符）
        $relative = $this->getRelativePath($absPath);
        $relative = str_replace('\\', '/', $relative); // 确保统一正斜杠

        // 如果是根目录，返回空数组（或可根据需求返回 ['home' => '/']）
        if ($relative === '' || $relative === '.') {
            return [];
        }

        // 拆分路径段，去掉空段
        $segments = explode('/', trim($relative, '/'));

        $breadcrumb = [];
        $currentPath = '';

        foreach ($segments as $segment) {
            // 跳过空或 . ..
            if ($segment === '' || $segment === '.' || $segment === '..') {
                continue;
            }

            $currentPath .= '/' . $segment;
            $breadcrumb[$segment] = $currentPath;
        }

        return $breadcrumb;
    }

    /**
     * 获取文件/文件夹列表
     * @param string $dir 相对路径
     * @return array
     */
    public function getList(string $dir = ''): array
    {
        $absPath = $this->safePath($dir);
        if (!is_dir($absPath)) {
            return [];
        }

        $items = [];
        $entries = scandir($absPath);
        foreach ($entries as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            $fullPath = $absPath . DIRECTORY_SEPARATOR . $entry;
            $relativePath = $this->getRelativePath($fullPath);
            $url = $this->baseUrl . rawurlencode($relativePath);

            $isDir = is_dir($fullPath);
            $items[] = [
                'name'     => $entry,
                'path'     => $relativePath,                    // 相对路径（不含开头的根）
                'fullpath' => $fullPath,                         // 服务器绝对路径（仅调试用，生产慎露）
                'type'     => $isDir ? 'dir' : pathinfo($entry, PATHINFO_EXTENSION),
                'size'     => $isDir ? 'Folder' : $this->formatSize(filesize($fullPath)),
                'time'     => date('Y-m-d H:i:s', filemtime($fullPath)),
                'url'      => $isDir ? '' : $url,
                'is_dir'   => $isDir,
            ];
        }

        // 可选：按名称排序
        usort($items, function ($a, $b) {
            if ($a['is_dir'] === $b['is_dir']) {
                return strcasecmp($a['name'], $b['name']);
            }
            return $a['is_dir'] ? -1 : 1; // 文件夹在前
        });

        return $items;
    }

    /**
     * 递归获取目录下所有文件（不包含文件夹）
     * @param string $dir
     * @return array
     */
    public function getAllFiles(string $dir = ''): array
    {
        $absPath = $this->safePath($dir);
        $files = [];

        if (!is_dir($absPath)) {
            return $files;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($absPath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isFile()) {
                $fullPath = $item->getRealPath();
                $relativePath = $this->getRelativePath($fullPath);
                $url = $this->baseUrl . rawurlencode($relativePath);

                $files[] = [
                    'name' => $item->getFilename(),
                    'path' => $relativePath,
                    'size' => $item->getSize(),
                    'time' => $item->getMTime(),
                    'url'  => $url,
                ];
            }
        }

        return $files;
    }

    /**
     * 创建文件夹
     * @param string $dir 相对路径
     * @return bool
     */
    public function createDir(string $dir): bool
    {
        $absPath = $this->safePath($dir);
        if (is_dir($absPath)) {
            return true;
        }

        return mkdir($absPath, 0755);
    }

	/**
	 * 安全上传文件（自动递归创建目录）
	 *
	 * @param string $relativePath 目标相对路径，例如 'uploads/2025/avatar.jpg'
	 * @param array  $file         $_FILES['file'] 中的一项
	 * @return string|bool         成功返回上传后的相对路径，失败返回 false
	 */
	public function upload(string $relativePath, array $file): bool
	{
		// 上传错误检查
		if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
			return false;
		}

		// 1. 清理并规范化相对路径（统一用 /）
		$relativePath = trim($relativePath, '/\\');
		if ($relativePath === '') {
			return false; // 禁止上传到根目录？或根据需求允许
		}

		// 禁止任何形式的绝对路径
		if (
			str_starts_with($relativePath, '/') ||
			preg_match('#^[A-Za-z]:[\\\\/]#i', $relativePath) ||  // Windows 盘符路径
			str_contains($relativePath, ':\\') ||
			str_starts_with($relativePath, '\\\\')                // UNC 路径
		) {
			return false;
		}

		// 2. 分离目录和文件名
		$pathParts = explode('/', str_replace('\\', '/', $relativePath));
		$filename = array_pop($pathParts);           // 最后一级是文件名
		$dirSegments = array_filter($pathParts);     // 目录段（过滤空）

		// 3. 基本文件名安全检查
		if (
			$filename === '' ||
			$filename === '.' ||
			$filename === '..' ||
			strpbrk($filename, "\0\\/:*?\"<>|") !== false
		) {
			return false;
		}

		// 4. 安全递归创建目录
		$basePath = realpath($this->rootPath);
		if ($basePath === false) {
			return false;
		}
		$basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

		$current = $basePath;
		foreach ($dirSegments as $seg) {
			if ($seg === '' || $seg === '.' || $seg === '..') {
				return false;
			}

			$dir = $current . $seg;

			if (file_exists($dir) && !is_dir($dir)) {
				return false; // 中间路径不能是文件
			}

			if (!is_dir($dir)) {
				if (!mkdir($dir, 0755)) {
					return false;
				}
			}

			$real = realpath($dir);
			if ($real === false || strpos($real . DIRECTORY_SEPARATOR, $basePath) !== 0) {
				return false; // 符号链接跳出或路径无效
			}

			$current = $real . DIRECTORY_SEPARATOR;
		}

		// 5. 执行上传
		if (move_uploaded_file($file['tmp_name'], $current . $filename)) {
			return true;
		}

		return false;
	}

    /**
     * 重命名（文件或文件夹）
     * @param string $oldPath 旧相对路径
     * @param string $newName 新名称（仅名称，不含路径）
     * @return bool
     */
    public function rename(string $oldPath, string $newName): bool
    {
        $oldAbs = $this->safePath($oldPath);
        if (!file_exists($oldAbs)) {
            return false;
        }

        $newAbs = dirname($oldAbs) . DIRECTORY_SEPARATOR . $newName;
        if (file_exists($newAbs)) {
            return false;
        }

        return rename($oldAbs, $newAbs);
    }

    /**
     * 移动（文件或文件夹）
     * @param string $source 源相对路径
     * @param string $targetDir 目标目录相对路径
     * @return bool
     */
    public function move(string $source, string $targetDir): bool
    {
        $sourceAbs = $this->safePath($source);
        $targetAbs = $this->safePath($targetDir);

        if (!file_exists($sourceAbs) || !is_dir($targetAbs)) {
            return false;
        }

        $newPath = $targetAbs . DIRECTORY_SEPARATOR . basename($sourceAbs);
        if (file_exists($newPath)) {
            return false;
        }

        return rename($sourceAbs, $newPath);
    }

    /**
     * 复制（文件或文件夹）
     * @param string $source
     * @param string $targetDir
     * @return bool
     */
    public function copy(string $source, string $targetDir): bool
    {
        $sourceAbs = $this->safePath($source);
        $targetAbs = $this->safePath($targetDir);

        if (!file_exists($sourceAbs) || !is_dir($targetAbs)) {
            return false;
        }

        $destination = $targetAbs . DIRECTORY_SEPARATOR . basename($sourceAbs);

        if (is_file($sourceAbs)) {
            return copy($sourceAbs, $destination);
        }

        // 递归复制目录
        if (!is_dir($destination) && !mkdir($destination, 0755, true)) {
            return false;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourceAbs, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $targetPath = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
            if ($item->isDir()) {
                if (!is_dir($targetPath)) {
                    mkdir($targetPath, 0755, true);
                }
            } else {
                copy($item->getRealPath(), $targetPath);
            }
        }

        return true;
    }

    /**
     * 递归删除文件或文件夹
     * @param string $path 相对路径
     * @return bool
     */
    public function delete(string $path): bool
    {
        $absPath = $this->safePath($path);
        if (!file_exists($absPath) || $absPath === $this->rootPath) {
            return false; // 禁止删除根目录
        }

        if (is_file($absPath)) {
            return unlink($absPath);
        }

        // 删除目录
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($absPath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isDir()) {
                rmdir($item->getRealPath());
            } else {
                unlink($item->getRealPath());
            }
        }

        return rmdir($absPath);
    }

    /**
     * 判断文件或文件夹是否存在（相对于根目录的相对路径）
     * 
     * @param string $path 相对路径（如 'images/photo.jpg' 或 'docs/folder'）
     * @return bool 存在返回 true，不存在或路径非法返回 false
     */
    public function exists(string $path = ''): bool
    {
        // 空路径视为根目录，根目录一定存在
        if ($path === '' || $path === '/' || trim($path, '/\\') === '') {
            return true;
        }

        // 通过 safePath 获取绝对路径（已防止穿越）
        $absPath = $this->safePath($path);

        // 如果 safePath 返回根目录，说明原路径非法或试图访问上级
        // 但我们要区分：如果是明确传入根目录之外的非法路径，应返回 false
        // 由于 safePath 会把非法路径降级为根目录，我们额外判断原始路径是否被截断
        $relative = $this->getRelativePath($absPath);
        $normalizedInput = trim(str_replace('\\', '/', $path), '/');

        // 如果处理后的相对路径与输入不一致（被截断），说明路径非法
        if ($normalizedInput !== '' && $relative === '') {
            return false;
        }

        // 最终判断文件/文件夹是否存在
        return file_exists($absPath);
    }

	private function formatSize($bytes) {
		// 定义单位
		$units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

		// 计算数组索引
		$i = 0;

		// 循环直到文件大小小于 1024
		while ($bytes >= 1024 && $i < count($units) - 1) {
			$bytes /= 1024;
			$i++;
		}

		// 格式化并返回结果
		return number_format($bytes, 2) . ' ' . $units[$i];
	}
}

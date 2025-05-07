<?php class file_handler
{
	public static function getFilesRecursively($directory, $baseDirectory)
	{
		$files = [];
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

		foreach ($iterator as $fileInfo)
		{
			if ($fileInfo->isFile())
			{
				// 获取相对路径
				$absolutePath = $fileInfo->getPathname();
				$relativePath = str_replace($baseDirectory . DIRECTORY_SEPARATOR, '', $absolutePath);
				$files[] = $relativePath;
			}
		}

		return $files;
	}
	
	public static function delete($path) {
		// 如果是文件，直接删除
		if (is_file($path)) {
			return unlink($path); // 删除文件
		}

		// 如果是目录，递归删除
		if (is_dir($path)) {
			// 遍历目录内容
			$files = array_diff(scandir($path), array('.', '..')); // 排除 '.' 和 '..'

			// 删除目录中的所有内容
			foreach ($files as $file) {
				$currentPath = $path . DIRECTORY_SEPARATOR . $file;
				// 递归删除文件或目录
				self::delete($currentPath);
			}

			// 删除空目录
			return rmdir($path);
		}

		return false; // 如果路径既不是文件也不是目录，返回 false
	}
	
	public static function getRootDir() {
		$rootDir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'files';
		
		if (!is_dir($rootDir)) {
			mkdir($rootDir, 0777, true);
		}
		
		return realpath($rootDir);
	}
	
	public static function getPath() {
		$rootDir = self::getRootDir();
		
		$splitPathToArray = function($fullPath)
		{
			if ($fullPath == '') {
				return [];
			}
			
			$pathParts = explode('/', $fullPath);  // 按路径分隔符拆分路径
			$currentPath = '';
			$result = [];
			
			foreach ($pathParts as $part) {
				$currentPath .= $part . '/'; // 构建当前的完整路径
				$result[] = [
					'name' => $part,
					'path' => rtrim($currentPath, '/') // 去掉末尾的分隔符
				];
			}
			
			return $result;
		};
		
		if (isset($_GET['p'])) {
			$absolutePath = realpath($rootDir.DIRECTORY_SEPARATOR.$_GET['p']);
		} else {
			$absolutePath = $rootDir;
		}
		
		if (strpos($absolutePath, $rootDir) === 0) {
			$currentPath = str_replace('\\', '/', ltrim(substr($absolutePath, strlen($rootDir)), DIRECTORY_SEPARATOR));
		} else {
			$currentPath = '';
			$absolutePath = $rootDir;
		}

		return [
			'absolutePath' => $absolutePath,
			'currentPath'  => $currentPath,
			'root'         => $rootDir,
			'pathArray'    => $splitPathToArray($currentPath),
			'parent'       => dirname($currentPath)
		];
	}
	
	public static function formatSize($bytes) {
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
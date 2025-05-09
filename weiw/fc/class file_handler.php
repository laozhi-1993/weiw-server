<?php class file_handler
{
	public $webRoot;
	public $basePath;
	public $currentPath;
	
	
	public function __construct(string $currentPath, string $basePath = '.')
	{
		$this->webRoot = $_SERVER['DOCUMENT_ROOT'];
		$this->basePath = $basePath;
		$this->currentPath = $currentPath;
		
		
		if (!is_dir($this->basePath)) {
			mkdir($this->basePath, 0777, true);
		}
	}
	
	public function isExists() {
		return file_exists($this->getFullPath());
	}
	
	public function isDir() {
		return is_dir($this->getFullPath());
	}
	
	public function isFile() {
		return is_file($this->getFullPath());
	}
	
	
	
	public function getWebRoot() {
		return $this->webRoot;
	}
	
	public function getBasePath() {
		return realpath($this->basePath);
	}
	
	public function getCurrentPath() {
		if ($this->currentPath === '.') {
			return '';
		}
		
		$this->currentPath = str_replace('\\', '/', $this->currentPath);
		$this->currentPath = str_replace(['../','./'], '', $this->currentPath);
		
		return $this->currentPath;
	}
	
	public function getFullPath() {
		return $this->joinPaths($this->basePath, $this->getCurrentPath());
	}
	
	public function getParentDir() {
		return rawurlencode(dirname($this->getCurrentPath()));
	}
	
	public function getPathToArray() {
		// 分割路径并过滤空元素
		$parts = explode('/', $this->getCurrentPath());
		$parts = array_filter($parts, function($value) {
			return $value !== '';
		});
		// 重新索引数组以确保顺序正确
		$parts = array_values($parts);
		
		$result = [];
		$currentParts = [];
		
		foreach ($parts as $part) {
			$currentParts[] = $part; // 累积当前路径部分
			$fullPath = implode('/', $currentParts); // 生成完整路径
			$result[] = ['name'=>$part, 'path'=>rawurlencode($fullPath)]; // 添加到结果数组
		}
		
		return $result;
	}
	
	public function getFilesRecursively()
	{
		if (!$this->isDir()) {
			return [];
		}
		
		$webRoot = $this->getWebRoot();
		$containedPath = $this->getFullPath();
		
		$files = [];
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($containedPath));
		
		foreach ($iterator as $fileInfo)
		{
			if ($fileInfo->isFile()) {
				$files[] = [
					filemtime($fileInfo->getPathname()),
					http::get_current_url() . $this->relativePath($webRoot, $fileInfo->getPathname()),
					$this->relativePath($containedPath, $fileInfo->getPathname()),
				];
			}
		}
		
		return $files;
	}
	
	public function getDirectoryListing()
	{
		if (!$this->isDir()) {
			return [];
		}
		
		$dirs = [];
		$files = [];
		$absPath = $this->getFullPath();
		$iterator = new DirectoryIterator($absPath);
		
		foreach ($iterator as $fileInfo) {
			if ($fileInfo->isDot()) {
				continue;
			}
			
			// 公共字段
			$entry = [
				'type' => $fileInfo->isDir() ? 'dir' : 'file',
				'name' => $fileInfo->getFilename(),
				'path' => rawurlencode($this->joinPaths(
					$this->getCurrentPath(),
					$fileInfo->getFilename()
				)),
				'url'  => http::get_current_url() . $this->relativePath(
					$this->getWebRoot(),
					$fileInfo->getPathname()
				),
				'date' => date("Y-m-d H:i", $fileInfo->getMTime() + 28800),
			];
			
			// 类型相关字段
			$entry['size'] = $entry['type'] === 'file' 
				? $this->formatSize($fileInfo->getSize())
				: 'Folder';
			
			if ($fileInfo->isDir()) {
				$dirs[] = $entry;
			}
			
			if ($fileInfo->isFile()) {
				$files[] = $entry;
			}
		}
		
		return array_merge($dirs, $files);
	}
	
	
	
	public function upload()
	{
		ini_set('max_execution_time', 0);
		ini_set('max_input_time', 0);
		
		if ($_FILES['file']['error'] !== 0) {
			throw new Exception("文件上传错误: {$_FILES['file']['error']}");
		}
		
		$dir = dirname($this->getFullPath());
		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		
		if (!move_uploaded_file($_FILES['file']['tmp_name'], $this->getFullPath())) {
			return false;
		}
		
		return true;
	}
	
	public function delete()
	{
		$absPath = $this->getFullPath();
		
		if ($this->isFile($absPath)) {
			return unlink($absPath);
		}

		$iterator = new RecursiveDirectoryIterator($absPath, RecursiveDirectoryIterator::SKIP_DOTS);
		$files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);

		foreach ($files as $file) {
			if ($file->isDir()) {
				rmdir($file->getRealPath());
			} else {
				unlink($file->getRealPath());
			}
		}

		return rmdir($absPath);
	}
	
	
	
	private function relativePath($root, $path)
	{
		if (strpos($path, $root) === 0) {
			return str_replace(DIRECTORY_SEPARATOR, '/', substr($path, strlen($root)+1));
		}
		
		return false;
	}
	
	private function joinPaths(string ...$paths) {
		return rtrim(str_replace('/', DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, array_filter($paths))), DIRECTORY_SEPARATOR);
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
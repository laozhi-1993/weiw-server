<?php return function ()
	{
		try
		{
			$user = mc_user_authentication::getUser();
			if (!$user || !$user->isAdmin()) {
				return ['error' => '没有权限'];
			}
			
			
			$paths = file_handler::getPath();
			$rootDirName = basename($paths['root']);
			$dirs  = [];
			$files = [];
			
			if (!is_dir($paths['absolutePath'])) {
				return [];
			}
			
			foreach(scandir($paths['absolutePath']) as $fileName)
			{
				if ($fileName !== '.' && $fileName !== '..')
				{
					if ($paths['currentPath'] === '') {
						$currentPath  = $fileName;
					} else {
						$currentPath  = $paths['currentPath'].'/'.$fileName;
					}
					
					$absolutePath = $paths['absolutePath'] . DIRECTORY_SEPARATOR . $fileName;
					$modifiedTime = filemtime($absolutePath);
					$date         = date("Y-m-d H:i", $modifiedTime + 28800);
					$url          = http::get_current_url("{$rootDirName}/{$currentPath}");
					
					if (is_file($absolutePath))
					{
						$size = file_handler::formatSize(filesize($absolutePath));
						$type = 'file';
						
						$files[] = [
							'type' => $type,
							'name' => $fileName,
							'path' => $currentPath,
							'url' => $url,
							'size' => $size,
							'date' => $date,
						];
					}
					else
					{
						$size = 'Folder';
						$type = 'dir';
						
						$dirs[] = [
							'type' => $type,
							'name' => $fileName,
							'path' => $currentPath,
							'url' => $url,
							'size' => $size,
							'date' => $date,
						];
					}
				}
			}
			
			return [
				'current'       => $paths['currentPath'],
				'pathArray'     => $paths['pathArray'],
				'parent'        => $paths['parent'],
				'directoryList' => array_merge($dirs, $files)
			];
		}
		catch(Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};
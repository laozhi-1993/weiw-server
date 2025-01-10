<?php return function ()
{
    try
	{
        // 获取当前用户
        $user = mc_user_authentication::getUser();
        if (!$user) {
            throw new Exception('没有登录');
        }

        // 定义目录路径
        $minecraftDir = file_handler::getMinecraftDir();
        $modsDir = $minecraftDir . DIRECTORY_SEPARATOR . 'mods';

        // 获取mods文件
        $mods = glob($modsDir . DIRECTORY_SEPARATOR . '*.jar');
        $files = file_handler::getFilesRecursively($minecraftDir, $minecraftDir);
        
        // 获取用户数据和客户端配置
        $userData = $user->toArray();
        $clientData = config::loadConfig('client');
        $clientData['username']    = $userData['name'];
        $clientData['uuid']        = $userData['uuid'];
        $clientData['accessToken'] = $userData['accessToken'];
        $clientData['mods']        = [];
        $clientData['downloads']   = [];

        // 处理 mods
        foreach ($mods as $modName) {
            if (!is_dir($modName)) {
                $clientData['mods'][] = basename($modName);
            }
        }

        // 处理文件下载
        foreach ($files as $file) {
			$time = filemtime($minecraftDir . DIRECTORY_SEPARATOR . $file);
            $path = str_replace('\\', '/', $file);
            $fileUrl = http::get_current_url('minecraft/' . $file);
			
            $clientData['downloads'][] = [
				'url' => $fileUrl,
				'path' => $path,
				'time' => $time,
			];
        }

        return $clientData;

    }
	catch (Exception $Exception)
	{
        return ['error' => $Exception->getMessage()];
    }
};
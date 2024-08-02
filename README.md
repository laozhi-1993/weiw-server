# weiw-server

## 项目简介
`weiw-server` 是 [weiw-launcher](https://github.com/laozhi-1993/weiw-launcher) 项目的服务端组件。它与 [weiw-launcher](https://github.com/laozhi-1993/weiw-launcher) 客户端协同工作，提供用户认证和游戏相关的服务器功能。

## 功能特性

- **登录认证**：通过 authlib-injector 实现与原版 Minecraft 相同的登录认证体验。
- **用户界面**：友好的用户界面，方便操作。
- **皮肤系统**：支持简单的皮肤更换和使用功能。
- **金钱系统**：允许编辑 Minecraft 服务器指令，使玩家能够用金钱购买执行命令、进行每日签到获取金钱，并通过管理权限进行金钱分配。
- **RCON 指令执行**：支持通过 RCON 在客户端执行 Minecraft 服务器上的指令。

## 使用说明

### 安装要求

- PHP 版本: 7+
- PHP 扩展：
  - **gd**：需要安装 GD 扩展，用于图像处理。
  - **openssl**：需要安装 OpenSSL 扩展，用于加密和解密功能。

### 安装方法

#### 方法一：手动安装 PHP 和 HTTP 服务端环境

1. 安装 PHP 7 或更高版本。
2. 安装 HTTP 服务端（如 Apache 或 Nginx）。
3. 下载源码并将其放置到配置好的 Web 服务器根目录下。
4. 配置管理员文件：
   - 在 `weiw/config/admin.php` 文件中进行管理员配置。

#### 方法二：使用配置好的 PHP 和 HTTP 服务端整合包

1. 下载配置好的整合包：[项目发布页面](https://github.com/laozhi-1993/weiw-server/releases)
2. 解压整合包。
3. 配置管理员文件：
   - 在 `wwwroot/weiw/config/admin.php` 文件中进行管理员配置。
4. 运行 `webserver.exe` 启动服务器。
   - 运行后会弹出一个窗口，输入数字并按回车执行相应功能。
   - 输入 `1` 启动 Web 服务端。

### 配置管理员文件

- `admin.php`：用于配置管理员权限的文件。
  - **路径**:
    - 方法一: `weiw/config/admin.php`
    - 方法二: `wwwroot/weiw/config/admin.php`
  - **内容示例**:
    ```php
    <?php
    return array('admin1', 'admin2');
    ```
    - 每个元素代表一个管理员用户名。可以添加多个管理员用户名，每个用户名作为数组中的一个元素。

## authlib-injector 配置说明

1. **下载 authlib-injector**：
   - 从 [authlib-injector 项目](https://github.com/authlib-injector/authlib-injector) 页面下载最新版本的 authlib-injector。

2. **配置 authlib-injector**：
   - 将下载的 `authlib-injector.jar` 文件放置到 Minecraft 服务器目录下。
   - 根据 [authlib-injector 文档](https://github.com/authlib-injector/authlib-injector#readme) 进行必要的配置，确保它能够与 `weiw-server` 正常通信和进行用户认证。

## Minecraft 服务器配置说明

1. **准备 Minecraft 服务器**：
   - 确保已安装并配置了 Minecraft 服务器（如 Vanilla、PaperMC 等）。

2. **配置 RCON**：
   - 在 Minecraft 服务器的配置文件 `server.properties` 中启用 RCON。
   - 设置 `enable-rcon=true` 和 `rcon.port=25575`（或其他选择的端口）。
   - 设置 `rcon.password=yourpassword` 为 RCON 密码。

3. **编辑启动脚本**：
   - 创建新的 `.bat` 启动脚本，用于启动 Minecraft 服务器并配置 `authlib-injector`。
   - 启动脚本示例（`start_server.bat`）：
     ```bat
     @echo off
     set AUTHLIB_PATH=authlib-injector.jar
     set MINECRAFT_PATH=minecraft_server.jar
     set JAVA_OPTS=-Xmx2G -Xms1G

     java %JAVA_OPTS% -javaagent:%AUTHLIB_PATH%=http://127.0.0.1/weiw/index_auth.php -jar %MINECRAFT_PATH%
     pause
     ```
   - **注意**：在上面的脚本中，`127.0.0.1` 是本地回环地址。如果 `weiw-server` 运行在不同的主机上，请将 `127.0.0.1` 替换为 `weiw-server` 的实际地址或 IP。

## 相关项目

- [weiw-launcher](https://github.com/laozhi-1993/weiw-launcher): `weiw-launcher` 是 `weiw-server` 项目的客户端组件，提供用户登录和 Minecraft 启动功能。
- [authlib-injector](https://github.com/yushijinhun/authlib-injector): 一个用于 Minecraft 登录认证的库，`weiw-launcher` 使用该库实现与原版 Minecraft 相同的登录认证体验。

// 导入必要的Java类库
import java.io.*;
import java.net.HttpURLConnection;
import java.net.URLDecoder;
import java.net.URI;
import java.net.URL;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.StandardCopyOption;
import java.util.ArrayList;
import java.util.List;
import org.json.JSONObject;
import org.json.JSONArray;

/**
 * 文件下载器类，主要功能：
 * 1. 从远程JSON配置获取文件下载列表
 * 2. 下载缺失的文件到本地mods目录
 * 3. 删除不在白名单中的旧文件
 */
public class fileManager {
    
    // 主程序入口
    public static void main(String[] args) {
        try {
            List<String> modNames = new ArrayList<>(); // 存储合法文件名白名单
            
            // 从第一个命令行参数获取JSON配置URL
            String jsonstr = fetchJson(args[0]); 
            String modsFolder = "mods"; // 本地存储目录
            
            // 解析JSON数据
            JSONObject json = new JSONObject(jsonstr);
            JSONArray jsonMods = json.getJSONArray("mods"); // 获取mods数组
            
            // 遍历所有mod下载地址
            for (int i = 0; i < jsonMods.length(); i++) {
                String url = jsonMods.getString(i);
                
                // 处理URL编码的文件名
                File fileUrl = new File(URLDecoder.decode(url, "UTF-8"));
                File filePath = new File(modsFolder, fileUrl.getName());
                
                // 仅当文件不存在时才下载
                if (!filePath.isFile()) {
                    FileDownload(url, filePath.getPath());
                }
                
                modNames.add(fileUrl.getName()); // 将文件名加入白名单
            }
            
            // 清理不在白名单中的旧文件
            deleteFilesNotInWhitelist(modsFolder, modNames);
        } catch (Exception e) {
            System.err.println(e.getMessage());
        }
    }

    /**
     * 清理不在白名单中的文件
     * @param folderPath 要清理的文件夹路径
     * @param whitelist 允许保留的文件名列表
     */
    public static void deleteFilesNotInWhitelist(String folderPath, List<String> whitelist) {
        File folder = new File(folderPath);

        // 验证文件夹有效性
        if (!folder.exists() || !folder.isDirectory()) {
            System.out.println("路径不存在或不是文件夹：" + folderPath);
            return;
        }

        File[] files = folder.listFiles();
        if (files == null) {
            System.out.println("无法列出文件夹内容。");
            return;
        }

        // 遍历文件夹内所有文件
        for (File file : files) {
            if (file.isFile()) {
                // 删除不在白名单中的文件
                if (!whitelist.contains(file.getName())) {
                    boolean deleted = file.delete();
                    System.out.println((deleted ? "已删除: " : "删除失败: ") + file.getName());
                }
            }
        }
    }

    /**
     * 从远程获取JSON配置
     * @param JSONurl JSON配置文件的URL地址
     * @return JSON字符串
     */
    public static String fetchJson(String JSONurl) {
        try {
            URI uri = new URI(JSONurl); // 解析URL
            URL url = uri.toURL();
            
            // 创建HTTP连接
            HttpURLConnection connection = (HttpURLConnection) url.openConnection();
            
            // 设置请求参数
            connection.setRequestMethod("GET");
            connection.setRequestProperty("Accept", "application/json"); // 要求JSON响应
            
            // 检查HTTP状态码
            if (connection.getResponseCode() != 200) {
                throw new RuntimeException("HTTP " + connection.getResponseCode());
            }
            
            // 读取响应内容
            try (BufferedReader reader = new BufferedReader(
                new InputStreamReader(connection.getInputStream()))) {
                StringBuilder response = new StringBuilder();
                String line;
                while ((line = reader.readLine()) != null) {
                    response.append(line);
                }
                return response.toString();
            } finally {
                connection.disconnect(); // 确保关闭连接
            }
        } catch (Exception e) {
            throw new RuntimeException("获取json失败：" + e.getMessage());
        }
    }

    /**
     * 文件下载方法（核心功能）
     * @param fileUrl 要下载的文件URL
     * @param savePath 本地保存路径
     */
    public static void FileDownload(String fileUrl, String savePath) {
        try {
			System.out.println("地址：" + fileUrl);
			
            // 创建临时文件（防止下载中断导致文件损坏）
            Path tempFile = Files.createTempFile("download_", ".tmp");
            
            // 准备目标路径
            Path targetPath = new File(savePath).toPath().toAbsolutePath();
            Files.createDirectories(targetPath.getParent()); // 创建父目录
            
            try {
                // 处理可能包含特殊字符的URL
                URI uri = new URI(fileUrl);
                URL url = uri.toURL();
                
                // 建立HTTP连接
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                
                // 配置网络参数
                connection.setRequestProperty("User-Agent", "Mozilla/5.0 (Windows NT 10.0; Win64; x64)");
                connection.setConnectTimeout(5000);  // 5秒连接超时
                connection.setReadTimeout(10000);    // 10秒读取超时
                
                // 验证响应状态
                if (connection.getResponseCode() != 200) {
                    throw new RuntimeException("HTTP " + connection.getResponseCode());
                }
                
                // 获取文件大小（用于进度显示）
                int fileSize = connection.getContentLength();
                
                // 使用带缓冲的流进行下载
                try (
                    BufferedInputStream bis = new BufferedInputStream(connection.getInputStream());
                    FileOutputStream fos = new FileOutputStream(tempFile.toFile());
                ) {
                    byte[] buffer = new byte[8192]; // 8KB缓冲区
                    int bytesRead;
                    long totalRead = 0;
                    
                    // 循环读取数据
                    while ((bytesRead = bis.read(buffer)) != -1) {
                        fos.write(buffer, 0, bytesRead);
                        totalRead += bytesRead;
                        
                        // 计算并显示下载进度
                        double progress = (fileSize > 0) ? (double) totalRead / fileSize * 100 : 0;
						
                        String output = String.format("\r进度：%.1f%% 大小：%s ", progress, formatSize(fileSize));
                        System.out.print(output);
                    }
					
                    System.out.println("下载完成");
                } finally {
                    connection.disconnect(); // 确保断开连接
                }
                
                // 将临时文件移动到最终位置
                Files.move(tempFile, targetPath, StandardCopyOption.REPLACE_EXISTING);
            } finally {
                // 清理临时文件（如果移动失败）
                if (Files.exists(tempFile)) {
                    Files.delete(tempFile);
                }
            }
        } catch (Exception e) {
            System.out.println("下载失败: " + e.getMessage());
        }
    }

    /**
     * 格式化文件大小为易读格式（例如：1.5MB）
     * @param bytes 字节数
     * @return 格式化后的字符串
     */
    private static String formatSize(long bytes) {
        if (bytes < 1024) return bytes + " B";
        int exp = (int) (Math.log(bytes) / Math.log(1024));
        String unit = "KMGTPE".charAt(exp-1) + "B"; // 单位换算
        return String.format("%.1f%s", bytes / Math.pow(1024, exp), unit);
    }
}
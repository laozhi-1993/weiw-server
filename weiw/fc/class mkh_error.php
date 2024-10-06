<?php class mkh_error extends error
	{
		public function __construct($getcode,$getMessage,$getfile,$getLine)
		{
			$this->code    = $getcode;
			$this->message = $getMessage;
			$this->file    = $getfile;
			$this->line    = $getLine;
			//error_log("{$this->message} {$this->file} {$this->line}",3,__MKHDIR__.'/log.txt');
		}
		public static function view($error_code,$error_message,$error_file,$error_line)
		{
			echo "<p><b>错误信息：</b><span>{$error_message}</span></p>";
			echo "<p><b>错误文件：</b><span>{$error_file}</span></p>";
			echo "<p><b>错误行数：</b><span>{$error_line}</span></p>";
			exit(0);
		}
		public static function warning($text)
		{
			header('content-type: text/html');
			exit("<center><font size='7'>{$text}</font></center>");
		}
	}
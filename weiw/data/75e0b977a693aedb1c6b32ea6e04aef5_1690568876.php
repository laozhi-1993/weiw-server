<?php defined('__MKHDIR__') or die(http_response_code(404)) ?><?php isset($this->_Unified['mc_textures']['data']) or $this->_Unified['mc_textures']['data'] = false ?><?php isset($this->_Unified['value']) or $this->_Unified['value'] = false ?><?php isset($this->_Unified['index']) or $this->_Unified['index'] = false ?><?php isset($this->_Unified['mc_textures']['current_page']) or $this->_Unified['mc_textures']['current_page'] = false ?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<script src="js/jquery.min.js"></script>
		<script src="js/tips.js"></script>
		<script>
			function set_texture(id)
			{
				$.getJSON("/weiw/index.php?<?php echo token ?>",{"mods":"mc_set_texture","id":id},function (result){
					if(result.error == "ok")
					{
						$(window.parent.document).find('#avatar img').attr('src',`/weiw/index_auth.php/avatar?size=48&hash=${result.hash}`);
						tips('使用成功');
					}
					else
					{
						tips(result.error);
					}
				});
			}
		</script>
		<style>
			body {
				padding-bottom: 50px;
				overflow-y: scroll;
				overflow-x: hidden;
			}
			.other {
				color: #ddd;
				font-size: 12px;
				padding: 10px;
				margin-bottom: 5px;
				border-radius: 5px;
				background: radial-gradient(#666,#555);
			}
			.textures {
				margin-right: -10px;
				font-size: 0;
				overflow: hidden;
			}
			.textures .paiban {
				display: inline-block;
				width: 25%;
			}
			.textures .paiban .kapian {
				background: radial-gradient(#666,#555);
				border-radius: 5px;
				font-size: medium;
				overflow: hidden;
				margin-right: 10px;
				margin-bottom: 10px;
			}
			.textures .paiban .kapian .information {
				padding: 5px;
			}
			.textures .paiban .kapian .information span {
				padding: 0 10px;
				line-height: 20px;
				height: 22px;
				max-width: calc(100% - 80px);
				color: #437070;
				font-size: 10px;
				display: inline-block;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
				border-radius: 11px;
				background-color: #FFFFE0;
			}
			.textures .paiban .kapian .preview {
				position: relative;
				top: 0;
				margin: 5%;
				padding-top: 101%;
			}
			.textures .paiban .kapian .preview img 
			{
				position: absolute;
				top: 0;
				width: 100%;
				height: 100%;
			}
			.textures .paiban .kapian .attribute {
				background-color: #e6e9ec;
				height: 30px;
				position: relative;
				top: 0;
			}
			.textures .paiban .kapian .attribute button {
				background-color: #0C9CFF;
				border-radius: 0 0 5px 5px;
				border: none;
				cursor: pointer;
				color: #FFFFFF;
				text-align: center;
				height: 100%;
				width: 100%;
			}
			
			.page {
				margin: 20px auto;
				text-align: center;
				font-size: 0;
			}
			.page a {
				display: inline-block;
				padding: 10px 20px;
				font-size: medium;
				cursor: pointer;
				color: #f7f7ff;
				text-decoration-line: none;
			}
			.page a:hover {
				animation-name: anniu;
				animation-duration: 0.3s;
				animation-timing-function: ease-in;
				background-color: #cc00cc;
			}
			.page .s {
				background-color: #ff00ff;
				border-radius: 5px 0 0 5px;
			}
			.page .x {
				background-color: #ff00ff;
				border-radius: 0 5px 5px 0;
			}
			@media screen and (min-width: 1300px) {
				.textures .paiban {
					width: 20%;
				}
			}
			@media screen and (min-width: 1800px) {
				.textures .paiban {
					width: 10%;
				}
			}
		</style>
	</head>
	<body>
		<div class="result">
			<style>
				.result {
					position: relative;
					top: 0;
					left: 0;
					z-index: 1;
				}
				.result data {
					display: none;
				}
				.result div {
					margin-bottom: 10px;
					position: relative;
					padding: 10px;
					padding-right: 30px;
					background-color: #FFFFFF;
					border-radius: 5px;
				}
				.result div span:first-child {
					color: #52808C;
				}
				.result div span:last-child {
					position: absolute;
					top: 0;
					right: 5px;
					display: inline-block;
					cursor: pointer;
					padding: 10px;
					color: #52808C;
				}
			</style>
			<data>
				<div id="{id}">
					<span>{error}</span>
					<span title="关闭" onclick="tips_remove({id})">X</span>
				</div>
			</data>
		</div>
		<div class="other">
			<span>材质来源于<a href="javascript:window.parent.OpenAPI('https://littleskin.cn/')">LittleSkin 皮肤站</a>。</span>
		</div>
		<div class="textures">
			<?php if(is_array($this->_Unified['mc_textures']['data']) && count($this->_Unified['mc_textures']['data'])): ?><?php foreach($this->_Unified['mc_textures']['data'] as $this->_Unified['value']): ?><div class="paiban">
				<div class="kapian">
					<div class="information">
						<span title="<?php echo $this->_Unified['value']['type'] ?>"><?php echo $this->_Unified['value']['type'] ?></span>
						<span title="<?php echo $this->_Unified['value']['name'] ?>"><?php echo $this->_Unified['value']['name'] ?></span>
					</div>
					<div class="preview">
						<img src="https://littleskin.cn/preview/<?php echo $this->_Unified['value']['tid'] ?>?height=150" />
					</div>
					<div class="attribute">
						<button onclick="set_texture('<?php echo $this->_Unified['value']['tid'] ?>')">使用</button>
					</div>
				</div>
			</div><?php endforeach; ?><?php endif; ?>
			<div class="page">
				<a href="<?php echo $this->_Unified['index'] ?>?page=<?php echo $this->_Unified['mc_textures']['current_page']-1 ?>" class="s">&lt;上一页</a>
				<a href="<?php echo $this->_Unified['index'] ?>?page=<?php echo $this->_Unified['mc_textures']['current_page']+1 ?>" class="x">下一页&gt;</a>
			</div>
		</div>
	</body>
</html>
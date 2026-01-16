<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_verify_access');
	$MKH ->mods('mc_client');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<title>编辑客户端</title>
		<style>
			body {
				margin: 0;
				height: 100vh;
				box-sizing: border-box;
				background-color: #2e2e2e;
			}
			section {
				padding: 20px;
				padding-top: 0;
				box-sizing: border-box;
			}
			button {
				user-select: none;
			}

			main {
				margin: 0 auto;
				position: relative;
				color: #00ff9d;
			}

			main .nested {
				padding: 20px;
				border-top: 3px solid #FF5800;
				border-radius: 5px;
				background-color: #3c3c3c;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
			}

			.details-container {
				margin-top: 0;
				padding: 20px;
				border-radius: 5px;
				background-color: #3c3c3c;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
			}

			/* 按需并排的表单控件 */
			.form-inline {
				display: flex;
				justify-content: space-between;
				gap: 20px;
			}

			.form-inline .form-group {
				flex: 1;
			}

			/* 表单控件样式 */
			.form-group {
				position: relative;
				margin-bottom: 20px;
			}

			label {
				display: block;
				margin-bottom: 8px;
				font-size: 14px;
			}

			.title {
				margin: 10;
				padding: 10px;
				color: #fff;
				font-size: 20px;
				text-align: center;
				border-radius: 10px;
				background-color: #444;
			}

			.title-drag {
				text-align: center;
				color: #24cf2c;
			}

			/* 输入框聚焦时显示下拉列表 */
			input:focus + .list {
				opacity: 1;
				visibility: visible;
				transform: translateY(0);
			}

			/* 下拉列表样式 */
			input + .list {
				position: absolute;
				top: calc(100% + 8px);
				left: 0;
				z-index: 1;
				width: 100%;
				background-color: #555;
				border-radius: 5px;
				opacity: 0;
				visibility: hidden;
				transform: translateY(10px);
				transition: all 0.3s ease;
			}

			input + .list .scrollbar {
				margin: 10px;
				max-height: 200px;
				overflow-y: auto;
				scrollbar-width: thin;
				scrollbar-color: #4CAF50 #555;
			}

			input + .list .scrollbar center {
				display: flex;
				justify-content: center;
				align-items: center;
				color: #fff;
				height: 50px;
			}

			/* 下拉列表项样式 */
			input + .list .scrollbar div {
				padding: 5px 10px;
				cursor: pointer;
				transition: all 0.3s ease;
			}

			input + .list .scrollbar div:hover {
				background-color: #444;
			}

			input,
			textarea,
			select {
				width: 100%;
				padding: 13px;
				color: #00ff9d;
				outline: none;
				font-size: 16px;
				background-color: #333;
				border: 1px solid #555;
				border-radius: 5px;
				box-sizing: border-box;
				scrollbar-width: thin;
				scrollbar-color: #4CAF50 #333;
				transition: all 0.3s ease;
			}

			input:focus,
			textarea:focus,
			select:focus {
				border-color: #ff7b00;
				box-shadow: 0 0 0 3px rgba(255, 123, 0, 0.2), inset 0 2px 10px rgba(0,0,0,0.2);
			}

			input::placeholder,
			textarea::placeholder,
			select::placeholder {
				color: #888;
			}

			textarea {
				resize: vertical;
				min-height: 200px;
			}


			.addContainer {
				padding: 20px;
				border-top: 3px solid #FF5800;
				border-radius: 5px;
				background-color: #3c3c3c;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
			}

			.addContainer .extension .buttons {
				display: flex;
				justify-content: space-between;
				gap: 20px;
				margin: 20px 0;
			}

			.addContainer .extension .buttons button {
				width: 100%;
				height: 50px;
				font-size: 18px;
				cursor: pointer;
				color: #fff;
				border: none;
				border-radius: 5px;
				background-color: #5555ff;
				transition: all 0.3s ease;
			}
			.addContainer .extension .buttons button:hover {
				background-color: #3333ff;
				transform: translateY(2px);
			}

			.addContainer .extension .buttons button:active {
				transform: translateY(0);
			}

			.addContainer .extension .list {
				background-color: #4B4B4B;
				border-radius: 5px;
				height: 150px;
				padding: 10px;
			}

			.addContainer .extension .list .scrollbar {
				height: 100%;
				overflow-y: auto;
				scrollbar-width: thin;
				scrollbar-color: #4CAF50 #4B4B4B;
			}

			.addContainer .extension .list .scrollbar center {
				display: flex;
				justify-content: center;
				align-items: center;
				color: #fff;
				height: 100%;
				font-size: 25px;
			}

			.addContainer .extension .list .scrollbar div {
				padding: 5px 10px;
				cursor: pointer;
				transition: all 0.3s ease;
			}

			.addContainer .extension .list .scrollbar div:hover {
				background-color: #555;
			}

			/* 按钮样式 */
			.save-btn {
				background-color: #5555ff;
				color: #fff;
				padding: 10px 20px;
				border: none;
				border-radius: 5px;
				font-size: 16px;
				cursor: pointer;
				transition: background-color 0.3s ease;
			}

			.save-btn:hover {
				background-color: #3333ff;
			}


			.loader {
				position: relative;
				width: 85px;
				height: 50px;
				background-repeat: no-repeat;
				background-image: linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0);
				background-position: 0px center, 15px center, 30px center, 45px center, 60px center, 75px center, 90px center;
				animation: rikSpikeRoll 0.65s linear infinite alternate;
			}


			@keyframes rikSpikeRoll {
			  0% { background-size: 10px 3px;}
			  16% { background-size: 10px 50px, 10px 3px, 10px 3px, 10px 3px, 10px 3px, 10px 3px}
			  33% { background-size: 10px 30px, 10px 50px, 10px 3px, 10px 3px, 10px 3px, 10px 3px}
			  50% { background-size: 10px 10px, 10px 30px, 10px 50px, 10px 3px, 10px 3px, 10px 3px}
			  66% { background-size: 10px 3px, 10px 10px, 10px 30px, 10px 50px, 10px 3px, 10px 3px}
			  83% { background-size: 10px 3px, 10px 3px,  10px 10px, 10px 30px, 10px 50px, 10px 3px}
			  100% { background-size: 10px 3px, 10px 3px, 10px 3px,  10px 10px, 10px 30px, 10px 50px}
			}
		</style>
	</head>
	<body>
		<section>
			<includes-scrollbar><?php include('../includes/scrollbar.html') ?></includes-scrollbar>
			<includes-message><?php include('../includes/message.html') ?></includes-message>
			
			<main>
				<form action="/weiw/index.php?mods=mc_client_save" method="POST">
					<div class="details-container">
						<div class="form-group">
							<input type="number" name="weight" value="{echo:var.mc_client.weight}" placeholder="权重值：权重值越大，在客户端列表中的排序越靠前。">
						</div>
						<div class="form-inline">
							<div class="form-group">
								<label>服务器地址</label>
								<textarea name="server" rows="12" placeholder="每行一个地址" spellcheck="false">{echo:var.mc_client.server}</textarea>
							</div>

							<div class="form-group">
								<label>虚拟机参数</label>
								<textarea name="jvm" rows="12" placeholder="每行一个参数" spellcheck="false">{echo:var.mc_client.jvm}</textarea>
							</div>
						</div>

						<h1 class="title">文件下载列表</h1>
						<div class="form-group">
							<textarea name="downloads" rows="15" placeholder="每行一个地址">{echo:var.mc_client.downloads}</textarea>
						</div>

						<input type="hidden" name="name" value="{echo:var.mc_client.name}">
						<button type="submit" class="save-btn">保存</button>
					</div>
				</form>
			</main>
		</section>
		
		
		<script src="../js/main.js"></script>
		<script>
			handleFormSubmit("form", (fetch) => {
				fetch.then((data) => {
					if (data.error) {
						showMessage(data.error);
					} else {
						showMessage("保存完成");
					}
				});
			});
		</script>
	</body>
</html>
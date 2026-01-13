<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<title>更改密码</title>
		<style>
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
				font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			}
			
			body {
				background-color: #2e2e2e;
				min-height: 100vh;
				display: flex;
				justify-content: center;
				align-items: center;
				user-select: none;
			}
			
			.container {
				width: 100%;
				max-width: 880px;
			}
			
			.card {
				padding: 50px;
			}
			
			h2 {
				color: #fff;
				text-align: center;
				margin-bottom: 30px;
				font-size: 24px;
				position: relative;
			}
			
			h2::after {
				content: '';
				position: absolute;
				bottom: -10px;
				left: 50%;
				transform: translateX(-50%);
				width: 60px;
				height: 3px;
				background: linear-gradient(to right, #4a90e2, #5bc0de);
				border-radius: 3px;
			}
			
			.form-group {
				margin-bottom: 25px;
				position: relative;
			}
			
			label {
				display: block;
				margin-bottom: 8px;
				font-weight: 500;
				color: #ddd;
			}
			
			.input-with-icon {
				position: relative;
			}
			
			.svg-icon {
				position: absolute;
				left: 15px;
				top: 50%;
				transform: translateY(-50%);
				color: #5bc0de;
				width: 25px;
				height: 25px;
				fill: currentColor;
			}
			
			input {
				width: 100%;
				padding: 14px 14px 14px 45px;
				border: 2px solid #444;
				border-radius: 10px;
				background-color: #333;
				color: #fff;
				font-size: 16px;
				transition: all 0.3s ease;
			}
			
			input:focus {
				outline: none;
				border-color: #4a90e2;
				background-color: #3a3a3a;
				box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
			}
			
			.toggle-password {
				position: absolute;
				right: 15px;
				top: 50%;
				transform: translateY(-50%);
				background: none;
				border: none;
				color: #888;
				cursor: pointer;
				width: 25px;
				height: 25px;
			}
			
			.toggle-password svg {
				width: 100%;
				height: 100%;
				fill: currentColor;
			}
			
			.password-strength {
				margin-top: 8px;
				height: 6px;
				border-radius: 3px;
				background-color: #444;
				overflow: hidden;
			}
			
			.strength-meter {
				height: 100%;
				width: 0;
				background-color: #e74c3c;
				transition: width 0.3s ease, background-color 0.3s ease;
			}
			
			.strength-labels {
				display: flex;
				justify-content: space-between;
				margin-top: 8px;
				font-size: 12px;
				color: #888;
			}
			
			.requirements {
				margin-top: 5px;
				font-size: 13px;
				color: #aaa;
			}
			
			.requirement {
				display: flex;
				align-items: center;
				margin-bottom: 3px;
			}
			
			.requirement svg {
				margin-right: 5px;
				width: 12px;
				height: 12px;
				fill: currentColor;
				flex-shrink: 0;
			}
			
			.requirement.valid {
				color: #2ecc71;
			}
			
			.btn-group {
				display: flex;
				gap: 15px;
				margin-top: 20px;
			}
			
			.btn-group button {
				flex: 1;
				border: none;
				border-radius: 10px;
				font-size: 16px;
				font-weight: 600;
				cursor: pointer;
				transition: all 0.3s ease;
				padding: 12px;
				display: flex;
				align-items: center;
				justify-content: center;
				gap: 8px;
			}
			
			.submit-btn {
				background: linear-gradient(135deg, #4a90e2, #5bc0de);
				color: white;
			}
			
			.submit-btn:hover {
				background: linear-gradient(135deg, #3a80d2, #4bb0ce);
				box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
			}
			
			.home-btn {
				background: rgba(255, 255, 255, 0.1);
				color: #ddd;
				border: 1px solid rgba(255, 255, 255, 0.2);
			}
			
			.home-btn:hover {
				background: rgba(255, 255, 255, 0.2);
				box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
			}
		</style>
	</head>
	<body>
		<includes-header><?php include('includes/window-header.html') ?></includes-header>
		<includes-scrollbar><?php include('includes/scrollbar.html') ?></includes-scrollbar>
		
		<div class="container">
			<div class="card">
				<h2>更改密码</h2>
				
				<form id="passwordForm" action="/weiw/index.php?mods=mc_change_password" method="GET">
					<div class="form-group">
						<label for="currentPassword">当前密码</label>
						<div class="input-with-icon">
							<!-- 钥匙图标 -->
							<svg class="svg-icon" viewBox="0 0 24 24">
								<path d="M12.65 10C11.83 7.67 9.61 6 7 6c-3.31 0-6 2.69-6 6s2.69 6 6 6c2.61 0 4.83-1.67 5.65-4H17v4h4v-4h2v-4H12.65zM7 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
							</svg>
							<input type="password" name="currentPassword" id="currentPassword" placeholder="输入当前密码" required>
							<button type="button" class="toggle-password">
								<!-- 眼睛图标（默认隐藏） -->
								<svg class="eye-icon" viewBox="0 0 24 24">
									<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
								</svg>
								<!-- 眼睛关闭图标（默认隐藏） -->
								<svg class="eye-slash-icon" viewBox="0 0 24 24" style="display: none;">
									<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>
								</svg>
							</button>
						</div>
					</div>
					
					<div class="form-group">
						<label for="newPassword">新密码</label>
						<div class="input-with-icon">
							<!-- 锁图标 -->
							<svg class="svg-icon" viewBox="0 0 24 24">
								<path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
							</svg>
							<input type="password" name="newPassword" id="newPassword" placeholder="创建新密码" required>
							<button type="button" class="toggle-password">
								<!-- 眼睛图标（默认隐藏） -->
								<svg class="eye-icon" viewBox="0 0 24 24">
									<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
								</svg>
								<!-- 眼睛关闭图标（默认隐藏） -->
								<svg class="eye-slash-icon" viewBox="0 0 24 24" style="display: none;">
									<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>
								</svg>
							</button>
						</div>
						<div class="password-strength">
							<div class="strength-meter" id="strengthMeter"></div>
						</div>
						<div class="strength-labels">
							<span>弱</span>
							<span>中</span>
							<span>强</span>
						</div>
						
						<div class="requirements">
							<div class="requirement" id="lengthReq">
								<!-- 圆圈图标 -->
								<svg viewBox="0 0 24 24">
									<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
								</svg>
								<span>至少8个字符</span>
							</div>
							<div class="requirement" id="numberReq">
								<svg viewBox="0 0 24 24">
									<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
								</svg>
								<span>包含数字</span>
							</div>
							<div class="requirement" id="specialReq">
								<svg viewBox="0 0 24 24">
									<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
								</svg>
								<span>包含特殊字符</span>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="confirmPassword">确认新密码</label>
						<div class="input-with-icon">
							<!-- 锁图标 -->
							<svg class="svg-icon" viewBox="0 0 24 24">
								<path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
							</svg>
							<input type="password" name="confirmPassword" id="confirmPassword" placeholder="再次输入新密码" required>
							<button type="button" class="toggle-password">
								<!-- 眼睛图标（默认隐藏） -->
								<svg class="eye-icon" viewBox="0 0 24 24">
									<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
								</svg>
								<!-- 眼睛关闭图标（默认隐藏） -->
								<svg class="eye-slash-icon" viewBox="0 0 24 24" style="display: none;">
									<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>
								</svg>
							</button>
						</div>
						<div id="confirmMessage" style="margin-top: 8px; font-size: 14px;"></div>
					</div>
					
					<div class="btn-group">
						<button type="submit" class="submit-btn">更改密码</button>
						<button type="button" class="home-btn" onclick="window.location.href='index.php'">返回首页</button>
					</div>
				</form>
			</div>
		</div>

		<script src="js/main.js"></script>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				// 密码可见性切换
				const toggleButtons = document.querySelectorAll('.toggle-password');
				toggleButtons.forEach(button => {
					button.addEventListener('click', function() {
						const input = this.previousElementSibling;
						const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
						input.setAttribute('type', type);
						
						// 切换SVG图标
						const eyeIcon = this.querySelector('.eye-icon');
						const eyeSlashIcon = this.querySelector('.eye-slash-icon');
						
						if (type === 'text') {
							eyeIcon.style.display = 'none';
							eyeSlashIcon.style.display = 'block';
						} else {
							eyeIcon.style.display = 'block';
							eyeSlashIcon.style.display = 'none';
						}
					});
				});
				
				// 密码强度检测
				const newPasswordInput = document.getElementById('newPassword');
				const strengthMeter = document.getElementById('strengthMeter');
				const requirements = {
					lengthReq: document.getElementById('lengthReq'),
					numberReq: document.getElementById('numberReq'),
					specialReq: document.getElementById('specialReq')
				};
				
				newPasswordInput.addEventListener('input', function() {
					const password = this.value;
					let strength = 0;
					
					// 检查密码要求
					const hasMinLength = password.length >= 8;
					const hasNumber = /\d/.test(password);
					const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);
					
					// 更新要求状态
					updateRequirement(requirements.lengthReq, hasMinLength);
					updateRequirement(requirements.numberReq, hasNumber);
					updateRequirement(requirements.specialReq, hasSpecialChar);
					
					// 计算强度
					if (hasMinLength) strength += 33;
					if (hasNumber) strength += 33;
					if (hasSpecialChar) strength += 34;
					
					// 更新强度条
					strengthMeter.style.width = strength + '%';
					
					// 更新强度条颜色
					if (strength < 40) {
						strengthMeter.style.backgroundColor = '#e74c3c'; // 红色
					} else if (strength < 70) {
						strengthMeter.style.backgroundColor = '#f39c12'; // 黄色
					} else {
						strengthMeter.style.backgroundColor = '#2ecc71'; // 绿色
					}
				});
				
				function updateRequirement(element, isValid) {
					if (isValid) {
						element.classList.add('valid');
						// 替换为勾选图标
						const svg = element.querySelector('svg');
						svg.innerHTML = `
							<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
						`;
					} else {
						element.classList.remove('valid');
						// 恢复为圆圈图标
						const svg = element.querySelector('svg');
						svg.innerHTML = `
							<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
						`;
					}
				}
				
				// 密码确认
				const confirmPasswordInput = document.getElementById('confirmPassword');
				const confirmMessage = document.getElementById('confirmMessage');
				
				confirmPasswordInput.addEventListener('input', function() {
					const newPassword = newPasswordInput.value;
					const confirmPassword = this.value;
					
					if (confirmPassword === '' || newPassword === confirmPassword) {
						confirmMessage.textContent = '';
						confirmMessage.style.color = '';
					} else {
						confirmMessage.textContent = '密码不匹配';
						confirmMessage.style.color = '#e74c3c';
					}
				});
				
				// 表单提交
				handleFormSubmit("#passwordForm", (fetch) => {
					confirmMessage.textContent = '';
					confirmMessage.style.color = '';
					
					fetch.then((data) => {
						if (data.status === 'success') {
							confirmMessage.textContent = data.message;
							confirmMessage.style.color = '#2ecc71';
							return;
						}
						
						if (data.status === 'error') {
							confirmMessage.textContent = data.message;
							confirmMessage.style.color = '#e74c3c';
							return;
						}
					});
				});
			});
		</script>
	</body>
</html>
<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<title>更改密码</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
			}
			
			.container {
				width: 100%;
				max-width: 880px;
			}
			
			.card {
				background: rgba(40, 40, 40, 0.9);
				border-radius: 16px;
				box-shadow: 0 10px 10px rgba(0, 0, 0, 0.3);
				padding: 40px;
				backdrop-filter: blur(10px);
				border: 1px solid rgba(255, 255, 255, 0.1);
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
			
			.input-with-icon i {
				position: absolute;
				left: 15px;
				top: 50%;
				transform: translateY(-50%);
				color: #5bc0de;
				font-size: 16px;
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
				font-size: 16px;
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
			
			.requirement i {
				margin-right: 5px;
				font-size: 12px;
				width: 16px;
			}
			
			.requirement.valid {
				color: #2ecc71;
			}
			
			.btn-group {
				display: flex;
				gap: 15px;
				margin-top: 20px;
			}
			
			button {
				flex: 1;
				padding: 14px;
				border: none;
				border-radius: 10px;
				font-size: 16px;
				font-weight: 600;
				cursor: pointer;
				transition: all 0.3s ease;
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
							<i class="fas fa-key"></i>
							<input type="password" name="currentPassword" id="currentPassword" placeholder="输入当前密码" required>
							<button type="button" class="toggle-password">
								<i class="fas fa-eye"></i>
							</button>
						</div>
					</div>
					
					<div class="form-group">
						<label for="newPassword">新密码</label>
						<div class="input-with-icon">
							<i class="fas fa-lock"></i>
							<input type="password" name="newPassword" id="newPassword" placeholder="创建新密码" required>
							<button type="button" class="toggle-password">
								<i class="fas fa-eye"></i>
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
								<i class="fas fa-circle"></i>
								<span>至少8个字符</span>
							</div>
							<div class="requirement" id="numberReq">
								<i class="fas fa-circle"></i>
								<span>包含数字</span>
							</div>
							<div class="requirement" id="specialReq">
								<i class="fas fa-circle"></i>
								<span>包含特殊字符</span>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="confirmPassword">确认新密码</label>
						<div class="input-with-icon">
							<i class="fas fa-lock"></i>
							<input type="password" name="confirmPassword" id="confirmPassword" placeholder="再次输入新密码" required>
							<button type="button" class="toggle-password">
								<i class="fas fa-eye"></i>
							</button>
						</div>
						<div id="confirmMessage" style="margin-top: 8px; font-size: 14px;"></div>
					</div>
					
					<div class="btn-group">
						<button type="submit" class="submit-btn">更改密码</button>
						<button type="button" class="home-btn" onclick="window.location.href='index.php'">
							<i class="fas fa-home"></i> 返回首页
						</button>
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
						
						// 切换图标
						const icon = this.querySelector('i');
						icon.classList.toggle('fa-eye');
						icon.classList.toggle('fa-eye-slash');
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
						element.querySelector('i').className = 'fas fa-check-circle';
					} else {
						element.classList.remove('valid');
						element.querySelector('i').className = 'fas fa-circle';
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
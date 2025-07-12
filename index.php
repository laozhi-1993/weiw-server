<?php include_once('weiw/index.php');
	
	
    $MKH = new mkh(__FILE__);
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=0.50, user-scalable=no">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
		<title>{echo:var.config.name} - 官方客户端下载</title>
		<style>
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
				font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
				scrollbar-width: thin;
				scrollbar-color: #4CAF50 #333;
			}
			
			body {
				background: linear-gradient(135deg, #0a1929, #1c3b5a);
				color: #fff;
				overflow-x: hidden;
				position: relative;
				min-height: 100vh;
			}
			
			/* 动态粒子背景 */
			#particles-js {
				position: fixed;
				width: 100%;
				height: 100%;
				top: 0;
				left: 0;
				z-index: -1;
			}
			
			/* 导航栏 */
			header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				padding: 20px 10%;
				background: rgba(10, 25, 41, 0.85);
				backdrop-filter: blur(10px);
				position: fixed;
				width: 100%;
				top: 0;
				z-index: 1000;
				border-bottom: 2px solid #4d9f3d;
				box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
				transition: all 0.3s ease;
			}
			
			header.scrolled {
				padding: 15px 10%;
				background: rgba(10, 25, 41, 0.95);
				box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
			}
			
			.logo {
				font-size: 28px;
				font-weight: 800;
				background: linear-gradient(45deg, #4d9f3d, #2ecc71, #1abc9c);
				-webkit-background-clip: text;
				background-clip: text;
				color: transparent;
				text-shadow: 0 0 15px rgba(46, 204, 113, 0.5);
				letter-spacing: 1px;
				transition: all 0.3s ease;
			}
			
			.logo .domain {
				font-size: 14px;
				display: block;
				margin-top: 2px;
				color: #3498db;
				text-shadow: none;
				font-weight: normal;
			}
			
			.nav-links a {
				color: #ecf0f1;
				text-decoration: none;
				margin-left: 30px;
				font-size: 18px;
				font-weight: 500;
				transition: all 0.3s ease;
				padding: 8px 15px;
				border-radius: 20px;
				position: relative;
			}
			
			.nav-links a::after {
				content: '';
				position: absolute;
				bottom: 0;
				left: 50%;
				transform: translateX(-50%);
				width: 0;
				height: 2px;
				background: #4d9f3d;
				transition: width 0.3s ease;
			}
			
			.nav-links a:hover::after {
				width: 80%;
			}
			
			.nav-links a:hover {
				color: #4d9f3d;
			}
			
			/* 英雄区域 */
			.hero {
				height: 100vh;
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
				text-align: center;
				padding: 0 20px;
				position: relative;
				margin-top: 80px;
			}
			
			.hero h1 {
				font-size: 5.5rem;
				margin-bottom: 25px;
				background: linear-gradient(45deg, #4d9f3d, #2ecc71, #1abc9c);
				-webkit-background-clip: text;
				background-clip: text;
				color: transparent;
				text-shadow: 0 0 20px rgba(46, 204, 113, 0.6);
				animation: pulse 3s infinite;
				letter-spacing: 2px;
				transition: all 0.5s ease;
			}
			
			.hero p {
				font-size: 1.6rem;
				max-width: 800px;
				margin-bottom: 50px;
				color: #ecf0f1;
				line-height: 1.6;
				text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
				transition: all 0.5s ease;
			}
			
			/* 下载按钮 */
			.download-btn {
				background: linear-gradient(45deg, #e74c3c, #e67e22);
				color: white;
				border: none;
				padding: 20px 50px;
				font-size: 1.7rem;
				font-weight: 700;
				border-radius: 50px;
				cursor: pointer;
				transition: all 0.4s ease;
				box-shadow: 0 10px 25px rgba(230, 126, 34, 0.4);
				position: relative;
				overflow: hidden;
				z-index: 1;
			}
			
			.download-btn::before {
				content: '';
				position: absolute;
				top: 0;
				left: -100%;
				width: 100%;
				height: 100%;
				background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
				transition: 0.6s;
				z-index: -1;
			}
			
			.download-btn:hover::before {
				left: 100%;
			}
			
			.download-btn:hover {
				transform: translateY(-8px);
				box-shadow: 0 15px 30px rgba(230, 126, 34, 0.6);
			}
			
			/* 服务器特色区域 */
			.features {
				padding: 120px 60px;
				background: rgba(13, 33, 53, 0.85);
				backdrop-filter: blur(8px);
				border-radius: 20px;
				margin: 0 5%;
				border: 2px solid rgba(46, 204, 113, 0.2);
				box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
				position: relative;
				z-index: 2;
			}
			
			.section-title {
				text-align: center;
				font-size: 3.2rem;
				margin-bottom: 70px;
				color: #2ecc71;
				position: relative;
				text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
			}
			
			.section-title::after {
				content: '';
				position: absolute;
				bottom: -20px;
				left: 50%;
				transform: translateX(-50%);
				width: 150px;
				height: 5px;
				background: linear-gradient(45deg, #4d9f3d, #2ecc71);
				border-radius: 3px;
				box-shadow: 0 2px 10px rgba(46, 204, 113, 0.5);
			}
			
			.features-grid {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
				gap: 50px;
			}
			
			.feature-card {
				background: rgba(20, 50, 80, 0.6);
				border-radius: 20px;
				padding: 40px 30px;
				text-align: center;
				transition: all 0.4s ease;
				border: 2px solid rgba(46, 204, 113, 0.3);
				backdrop-filter: blur(10px);
				box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
				position: relative;
				overflow: hidden;
			}
			
			.feature-card::before {
				content: '';
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 5px;
				background: linear-gradient(90deg, #4d9f3d, #3498db);
				opacity: 0.3;
				transition: height 0.3s ease;
			}
			
			.feature-card:hover::before {
				height: 100%;
				opacity: 0.1;
			}
			
			.feature-card:hover {
				transform: translateY(-15px);
				border-color: #2ecc71;
				box-shadow: 0 15px 35px rgba(46, 204, 113, 0.3);
				background: rgba(25, 60, 95, 0.7);
			}
			
			.feature-icon {
				font-size: 60px;
				margin-bottom: 25px;
				color: #e67e22;
				text-shadow: 0 0 15px rgba(230, 126, 34, 0.5);
			}
			
			.feature-card h3 {
				font-size: 2rem;
				margin-bottom: 20px;
				color: #2ecc71;
				position: relative;
				z-index: 2;
			}
			
			.feature-card p {
				font-size: 1.2rem;
				color: #ecf0f1;
				line-height: 1.7;
				position: relative;
				z-index: 2;
			}
			
			/* 联系方式区域 */
			.contact {
				padding: 120px 5% 80px;
				text-align: center;
				background: rgba(10, 25, 41, 0.9);
				margin-top: 80px;
				position: relative;
			}
			
			.contact::before {
				content: '';
				position: absolute;
				top: -50px;
				left: 0;
				width: 100%;
				height: 100px;
				background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M1200 0L0 0 892.25 114.72 1200 0z" fill="%230a1929"></path></svg>');
				background-size: 100% 100%;
			}
			
			.contact-container {
				background: rgba(20, 50, 80, 0.7);
				padding: 60px;
				border-radius: 25px;
				border: 2px solid rgba(52, 152, 219, 0.3);
				backdrop-filter: blur(10px);
				box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
			}
			
			.contact-container h3 {
				font-size: 3rem;
				margin-bottom: 60px;
				color: #3498db;
				text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
				position: relative;
				display: inline-block;
			}
			
			.contact-container h3::after {
				content: '';
				position: absolute;
				bottom: -15px;
				left: 50%;
				transform: translateX(-50%);
				width: 80%;
				height: 3px;
				background: linear-gradient(90deg, #4d9f3d, #3498db, #e67e22);
				border-radius: 3px;
			}
			
			.contact-grid {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
				gap: 50px;
			}
			
			.contact-card {
				background: rgba(30, 70, 110, 0.6);
				border-radius: 20px;
				padding: 40px 30px;
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: center;
				transition: all 0.4s ease;
				border: 2px solid rgba(52, 152, 219, 0.2);
				position: relative;
				overflow: hidden;
			}
			
			.contact-card::before {
				content: '';
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 5px;
				background: linear-gradient(90deg, #4d9f3d, #3498db, #e67e22);
				opacity: 0.5;
				transition: height 0.3s ease;
				z-index: 1;
			}
			
			.contact-card:hover::before {
				height: 100%;
				opacity: 0.1;
			}
			
			.contact-card:hover {
				transform: translateY(-10px);
				box-shadow: 0 15px 35px rgba(52, 152, 219, 0.2);
				border-color: #3498db;
			}
			
			.contact-icon {
				font-size: 60px;
				margin-bottom: 25px;
				color: #3498db;
				text-shadow: 0 0 15px rgba(52, 152, 219, 0.5);
				transition: all 0.3s ease;
				z-index: 2;
				position: relative;
			}
			
			.contact-card:hover .contact-icon {
				transform: scale(1.2);
				color: #2ecc71;
			}
			
			.contact-title {
				font-size: 2.2rem;
				margin-bottom: 20px;
				color: #2ecc71;
				text-align: center;
				z-index: 2;
				position: relative;
			}
			
			.contact-action {
				background: rgba(52, 152, 219, 0.3);
				color: white;
				border: none;
				padding: 12px 30px;
				font-size: 1.2rem;
				font-weight: 600;
				border-radius: 30px;
				cursor: pointer;
				transition: all 0.3s ease;
				text-decoration: none;
				display: inline-block;
				z-index: 3;
				position: relative;
			}
			
			.contact-action:hover {
				background: rgba(46, 204, 113, 0.5);
				transform: translateY(-3px);
				box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
			}
			
			/* 页脚 */
			footer {
				text-align: center;
				padding: 30px;
				background: rgba(5, 15, 25, 0.9);
				border-top: 1px solid rgba(46, 204, 113, 0.2);
				display: flex;
				flex-direction: column;
				align-items: center;
			}
			
			footer p {
				color: #7f8c8d;
				font-size: 1.1rem;
			}
			
			/* 返回顶部按钮 */
			.back-to-top {
				position: fixed;
				bottom: 30px;
				right: 30px;
				width: 50px;
				height: 50px;
				background: linear-gradient(45deg, #4d9f3d, #3498db);
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				color: white;
				font-size: 24px;
				cursor: pointer;
				opacity: 0;
				visibility: hidden;
				transform: translateY(20px);
				transition: all 0.4s ease;
				z-index: 100;
				box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
				border: 2px solid rgba(255, 255, 255, 0.2);
			}
			
			.back-to-top.visible {
				opacity: 1;
				visibility: visible;
				transform: translateY(0);
			}
			
			.back-to-top:hover {
				transform: translateY(-5px);
				background: linear-gradient(45deg, #e67e22, #e74c3c);
			}
			
			/* 动画效果 */
			@keyframes pulse {
				0% {
					text-shadow: 0 0 15px rgba(46, 204, 113, 0.5);
				}
				50% {
					text-shadow: 0 0 40px rgba(46, 204, 113, 0.9);
				}
				100% {
					text-shadow: 0 0 15px rgba(46, 204, 113, 0.5);
				}
			}
			
			
			@media (max-width: 768px) {
				.hero {
					height: 600px;
				}
				
				.hero h1 {
					font-size: 3.8rem;
				}
				
				.hero p {
					font-size: 1.3rem;
				}
				
				.section-title {
					font-size: 2.5rem;
				}
				
				.features {
					padding: 30px;
				}
				
				.contact-container {
					padding: 30px;
				}
				
				.logo {
					font-size: 24px;
				}
				
				.nav-links a {
					margin-left: 0;
					font-size: 16px;
					padding: 6px 12px;
				}
			}
		</style>
	</head>
	<body>
		<!-- 动态粒子背景 -->
		<div id="particles-js"></div>
		
		<!-- 返回顶部按钮 -->
		<div class="back-to-top">
			<i class="fas fa-arrow-up"></i>
		</div>
		
		<!-- 导航栏 -->
		<header>
			<div class="logo">
				<span>{echo:var.config.name}</span>
				<span class="domain">{echo:var.config.domain}</span>
			</div>
			<div class="nav-links">
				<a href="#features">服务器特色</a>
				<a href="#contact">联系我们</a>
			</div>
		</header>
		
		<!-- 主内容区 -->
		<section class="hero">
			<h1>欢迎来到{echo:var.config.name}官网</h1>
			<p>加入我们的方块世界！体验史诗级RPG剧情、原创小游戏、生存挑战与建筑竞赛。24小时稳定运行，与全球玩家一起创造无限可能！</p>
			<button class="download-btn" onclick="window.open('{echo:var.config.download}', '_blank')">
				<i class="fas fa-download"></i> 立即下载客户端
			</button>
			
			<!-- 滚动提示 -->
			<div style="position: absolute; bottom: 50px; animation: bounce 2s infinite;">
				<i class="fas fa-chevron-down" style="font-size: 2rem; color: #3498db;"></i>
			</div>
		</section>
		
		<!-- 服务器特色 -->
		<section class="features" id="features">
			<h2 class="section-title">服务器特色</h2>
			<div class="features-grid">
				<div class="feature-card">
					<div class="feature-icon">
						<i class="fas fa-shield-alt"></i>
					</div>
					<h3>极致反作弊</h3>
					<p>采用先进的反作弊系统，实时监控玩家行为，杜绝一切作弊行为。公平的游戏环境，让每位玩家都能享受纯粹的游戏乐趣。</p>
				</div>
				
				<div class="feature-card">
					<div class="feature-icon">
						<i class="fas fa-network-wired"></i>
					</div>
					<h3>多线BGP网络</h3>
					<p>全国多线BGP网络接入，电信、联通、移动三网直连，无论您在何处都能享受低于50ms的超低延迟游戏体验。</p>
				</div>
				
				<div class="feature-card">
					<div class="feature-icon">
						<i class="fas fa-gamepad"></i>
					</div>
					<h3>多种游戏模式</h3>
					<p>10+种游戏模式：空岛战争、职业战争、跑酷挑战、RPG剧情副本等，每周更新活动，永葆游戏新鲜感！</p>
				</div>
			</div>
		</section>
		
		<!-- 联系方式 -->
		<section class="contact" id="contact">
			<div class="contact-container">
				<h3>联系我们</h3>
				<p style="font-size: 1.4rem; margin-bottom: 50px; max-width: 800px; margin-left: auto; margin-right: auto;">
					遇到任何问题或有建议？我们的团队随时为您服务，通过以下方式联系我们：
				</p>
				
				<div class="contact-grid">
					<!-- QQ群 -->
					<div class="contact-card">
						<i class="fab fa-qq contact-icon"></i>
						<h3 class="contact-title">官方QQ群</h3>
						<a href="#" class="contact-action">123456789 (2000人群)</a>
					</div>
					
					<!-- 邮箱 -->
					<div class="contact-card">
						<i class="fas fa-envelope contact-icon"></i>
						<h3 class="contact-title">客服邮箱</h3>
						<a href="mailto:support@blockworld.com" class="contact-action">support@blockworld.com</a>
					</div>
					
					<!-- B站 -->
					<div class="contact-card">
						<i class="fab fa-bilibili contact-icon"></i>
						<h3 class="contact-title">官方B站账号</h3>
						<a href="#" class="contact-action">访问主页</a>
					</div>
					
					<!-- 微信 -->
					<div class="contact-card">
						<i class="fab fa-weixin contact-icon"></i>
						<h3 class="contact-title">微信公众号</h3>
						<a href="#" class="contact-action">扫码关注</a>
					</div>
				</div>
			</div>
		</section>
		
		<!-- 页脚 -->
		<footer>
			<p>© 2025 {echo:var.config.name} | 打造最有趣的我的世界服务器</p>
		</footer>
		
		<!-- 粒子背景脚本 -->
		<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
		<script>
			// 初始化粒子背景
			particlesJS("particles-js", {
				particles: {
					number: { value: 120, density: { enable: true, value_area: 1200 } },
					color: { value: ["#4d9f3d", "#2ecc71", "#3498db", "#e67e22"] },
					shape: { type: "circle" },
					opacity: { value: 0.8, random: true },
					size: { value: 5, random: { enable: true, minimumValue: 3 } },
					move: {
						enable: true,
						speed: 2.5,
						direction: "none",
						random: true,
						straight: false,
						out_mode: "out"
					}
				},
				interactivity: {
					detect_on: "canvas",
					events: {
						onhover: { enable: true, mode: "repulse" },
						onclick: { enable: true, mode: "push" }
					}
				}
			});
			
			// 平滑滚动
			document.querySelectorAll('a[href^="#"]').forEach(anchor => {
				anchor.addEventListener('click', function(e) {
					e.preventDefault();
					document.querySelector(this.getAttribute('href')).scrollIntoView({
						behavior: 'smooth'
					});
				});
			});
			
			// 修复动画导致的按钮选择问题
			document.addEventListener('DOMContentLoaded', function() {
				// 确保所有可点击元素有正确的z-index
				const clickableElements = document.querySelectorAll('a, button');
				clickableElements.forEach(el => {
					el.style.position = 'relative';
					el.style.zIndex = '10';
				});
				
				// 添加滚动动画效果（不应用到按钮）
				const observer = new IntersectionObserver((entries) => {
					entries.forEach(entry => {
						if (entry.isIntersecting) {
							entry.target.style.opacity = 1;
							entry.target.style.transform = 'translateY(0)';
						}
					});
				}, {
					threshold: 0.1
				});
				
				// 观察需要动画的元素（排除按钮）
				document.querySelectorAll('.feature-card, .contact-card, .section-title').forEach(card => {
					card.style.opacity = 0;
					card.style.transform = 'translateY(30px)';
					card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
					observer.observe(card);
				});
			});
			
			// 返回顶部按钮逻辑
			const backToTopBtn = document.querySelector('.back-to-top');
			
			window.addEventListener('scroll', () => {
				if (window.scrollY > 300) {
					backToTopBtn.classList.add('visible');
					document.querySelector('header').classList.add('scrolled');
				} else {
					backToTopBtn.classList.remove('visible');
					document.querySelector('header').classList.remove('scrolled');
				}
			});
			
			backToTopBtn.addEventListener('click', () => {
				window.scrollTo({
					top: 0,
					behavior: 'smooth'
				});
			});
			
			// 添加滚动动画效果
			const scrollElements = document.querySelectorAll('.feature-card, .contact-card, .section-title');
			
			const elementInView = (el, scrollOffset = 100) => {
				const elementTop = el.getBoundingClientRect().top;
				return (
					elementTop <= (window.innerHeight || document.documentElement.clientHeight) - scrollOffset
				);
			};
			
			const displayScrollElement = (element) => {
				element.style.opacity = 1;
				element.style.transform = 'translateY(0)';
			};
			
			const hideScrollElement = (element) => {
				element.style.opacity = 0;
				element.style.transform = 'translateY(30px)';
			};
			
			const handleScrollAnimation = () => {
				scrollElements.forEach((el) => {
					if (elementInView(el, 100)) {
						displayScrollElement(el);
					} else {
						hideScrollElement(el);
					}
				});
			};
			
			// 初始化隐藏元素
			scrollElements.forEach((el) => {
				el.style.opacity = 0;
				el.style.transform = 'translateY(30px)';
				el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
			});
			
			window.addEventListener('scroll', () => {
				handleScrollAnimation();
			});
			
			// 初始检查
			handleScrollAnimation();
		</script>
	</body>
</html>
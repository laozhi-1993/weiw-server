	function fetchAndAppendHtml(url, containerSelector, onFinally) {
		fetch(url)
			.then(response => response.text())
			.then(html => {
				const container = document.querySelector(containerSelector);
				if (container) {
					container.insertAdjacentHTML('beforeend', html);
				}
			})
			.finally(onFinally);
	}
	
	function handleFormSubmit(selectors, callback) {
		document.querySelectorAll(selectors).forEach(function (form) {
			let isFetching = false;  // 添加一个标志变量

			form.addEventListener('submit', function(event) {
				event.preventDefault();  // 阻止表单默认提交

				// 如果正在请求中，则不发送新的请求
				if (isFetching) {
					return;
				}

				isFetching = true;  // 设置标志为 true，表示正在进行请求

				// 获取表单的 action 地址
				const url = form.action;
				// 获取表单的 method 值，默认为 'GET'
				const method = form.method.toUpperCase() || 'GET';

				// 获取表单数据
				const formData = new FormData(form);
				const queryParams = new URLSearchParams();

				// 将表单数据添加到查询字符串（仅适用于 GET 请求）
				formData.forEach((value, key) => {
					queryParams.append(key, value);
				});

				// 根据 method 选择 GET 或 POST 请求
				if (method === 'GET') {
					// 如果是 GET 请求，拼接查询参数
					const separator = url.includes('?') ? '&' : '?';
					const fetchRequest = fetch(url + separator + queryParams.toString(), {
						method: 'GET'
					})
					.then(response => response.json())
					.finally(() => {
						isFetching = false;  // 请求完成后，重置标志
					});
					
					callback(fetchRequest, form);
				}
				
				if (method === 'POST') {
					// 如果是 POST 请求，使用 formData 作为请求体
					const fetchRequest = fetch(url, {
						method: 'POST',
						body: formData
					})
					.then(response => response.json())
					.finally(() => {
						isFetching = false;  // 请求完成后，重置标志
					});
					
					callback(fetchRequest, form);
				}
			});
		});
	}
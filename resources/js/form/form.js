import { createBootstrapModal } from "../modal/createBootstrapModal";

const form = document.querySelector('form');

form?.addEventListener('submit', function (event) {
	event.preventDefault();
	const formData = new FormData(form);
	fetch(form.action, {
		method: 'POST',
		body: formData
	})
		.then(response => {
			if (!response.ok) {
				throw new Error('Ошибка ответа');
			}
			return response.json();
		})
		.then(data => {
			let text
			if (data['success'] === 1) {
				text = 'Форма успешно отправлена'
			} else {
				text = 'Произошла ошибка. Обратитесь в службу поддержки'
			}
			createBootstrapModal(text)
			form.reset()
		})
		.catch(error => {
			console.error('Произошла ошибка:', error);
		});
});

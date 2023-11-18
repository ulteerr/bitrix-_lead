export function createBootstrapModal(text) {
	
	const modalHtml = `
        <div class="modal fade" id="customModal" tabindex="-1" role="dialog" aria-labelledby="customModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Отправка Формы</h5>
                        <button type="button" class="close" data-dismiss="modal" data-click="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">${text}</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-click="close" data-dismiss="modal">Продолжить</button>
                    </div>
                </div>
            </div>
        </div>`;

	const modalWrapper = document.createElement('div');
	modalWrapper.innerHTML = modalHtml;

	document.body.appendChild(modalWrapper);

	const modal = new bootstrap.Modal(modalWrapper.querySelector('#customModal'));
	modal.show();

	const closesBtns = modalWrapper.querySelectorAll('[data-click="close"]')
	closesBtns?.forEach(closeBtn => {
		closeBtn.addEventListener('click', () => {
			modal.hide();
		})
	})
}

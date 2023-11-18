import IMask from 'imask';
const phones = document.querySelectorAll('[data-name="phone"]')

phones?.forEach(phone => {

	IMask(phone, {
		mask: '+{7} (000) 000-00-00'
	});

})
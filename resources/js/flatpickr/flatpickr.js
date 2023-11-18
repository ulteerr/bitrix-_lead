
import flatpickr from 'flatpickr';
import { Russian } from "flatpickr/dist/l10n/ru.js"

flatpickr('[data-name="birthday"]', {
	"locale": Russian,
	dateFormat: "d.m.Y",
	maxDate: "31.12.2016",
	disableMobile: true,
});







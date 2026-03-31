(function ($) {

	//Datepicker v1 - https://www.daterangepicker.com/
	/*var $inputdates = $('input[name="dates"]');
	$(function() {
		$inputdates.daterangepicker({
			  autoUpdateInput: false,
			  autoApply:true,
			  minDate:new Date(),
			  locale: {
				  cancelLabel: 'Clear'
			  }
		  });
		  $inputdates.on('apply.daterangepicker', function(ev, picker) {
			  $(this).val(picker.startDate.format('MM-DD-YY') + '  >  ' + picker.endDate.format('MM-DD-YY'));
		  });
		  $inputdates.on('cancel.daterangepicker', function(ev, picker) {
			  $(this).val('');
		  });
	  });*/

	//Datepicker V2 - https://easepick.com/
	$(function () {
		const element = document.getElementById('dates');

		if (!element) {
			return;
		}

		const pageLocale = (document.documentElement.lang || 'en').toLowerCase();
		const pickerLocales = {
			fr: { lang: 'fr-FR', format: 'DD/MM/YYYY', one: 'nuit', other: 'nuits' },
			en: { lang: 'en-EN', format: 'MM/DD/YYYY', one: 'night', other: 'nights' },
			de: { lang: 'de-DE', format: 'DD.MM.YYYY', one: 'Nacht', other: 'Nächte' },
			it: { lang: 'it-IT', format: 'DD/MM/YYYY', one: 'notte', other: 'notti' },
		};
		const localeKey = Object.keys(pickerLocales).find(key => pageLocale.startsWith(key)) || 'en';
		const pickerLocale = pickerLocales[localeKey];

	/* Booked Dates */
		const DateTime = easepick.DateTime;
		const bookedDates = [
			['2023-09-01', '2023-09-04'],
			'2023-09-07',
			['2023-10-11', '2023-10-17'],
		].map(d => {
			if (d instanceof Array) {
				const start = new DateTime(d[0], 'YYYY-MM-DD');
				const end = new DateTime(d[1], 'YYYY-MM-DD');

				return [start, end];
			}

			return new DateTime(d, 'YYYY-MM-DD');
		});

		/* Configuration picker */
		const picker = new easepick.create({
			element,
			css: [
				'css/daterangepicker_v2.css',
			],
			lang: pickerLocale.lang, // Language tags https://www.techonthenet.com/js/language_tags.php
			format: pickerLocale.format,
			calendars: 2,
			grid: 2,
			zIndex: 99999,
			plugins: ['LockPlugin', 'RangePlugin'],
			RangePlugin: {
				tooltipNumber(num) {
					return num - 1;
				},
				locale: {
					one: pickerLocale.one,
					other: pickerLocale.other,
				},
			},
			LockPlugin: {
				minDate: new Date(),
				minDays: 1,
				inseparable: false,
				filter(date, picked) {
					if (picked.length === 1) {
						const incl = date.isBefore(picked[0]) ? '[)' : '(]';
						return !picked[0].isSame(date, 'day') && date.inArray(bookedDates, incl);
					}
					return date.inArray(bookedDates, '[)');
				}
			},
		});

	}); // End Easypick

})(jQuery);

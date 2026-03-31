$(function() {
      "use strict";

      //Datepicker v1 embedded - https://www.daterangepicker.com/
      /* var picker = $('#date_booking').daterangepicker({
        parentEl: '#daterangepicker-embedded-container',
        autoUpdateInput: false,
        autoApply :true,
        alwaysShowCalendars:true
      });
      // range update listener
      picker.on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM-DD-YY') + ' to ' + picker.endDate.format('MM-DD-YY'));
      });
      // prevent hide after range selection
      picker.data('daterangepicker').hide = function () {};
      // show picker on load
      picker.data('daterangepicker').show();
      */

      //Datepicker V2 embedded - - https://easepick.com/
      $(function () {
      const element = document.getElementById('date_booking');

      if (!element) {
        return;
      }

      const pageLocale = (document.documentElement.lang || 'en').toLowerCase();
      const pickerLocales = {
        fr: { lang: 'fr-FR', format: 'DD/MM/YYYY', one: 'nuit', other: 'nuits' },
        en: { lang: 'en-US', format: 'MM/DD/YYYY', one: 'night', other: 'nights' },
        de: { lang: 'de-DE', format: 'DD.MM.YYYY', one: 'Nacht', other: 'Nächte' },
        it: { lang: 'it-IT', format: 'DD/MM/YYYY', one: 'notte', other: 'notti' },
      };
      const localeKey = Object.keys(pickerLocales).find(key => pageLocale.startsWith(key)) || 'en';
      const pickerLocale = pickerLocales[localeKey];
      const nightLabel = element.dataset.nightLabel || pickerLocale.one;
      const nightsLabel = element.dataset.nightsLabel || pickerLocale.other;

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
        zIndex: 10,
        inline: true,
        plugins: ['LockPlugin', 'RangePlugin'],
        RangePlugin: {
          tooltipNumber(num) {
            return num - 1;
          },
          locale: {
            one: nightLabel,
            other: nightsLabel,
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

    }); // End Easypick config
  });

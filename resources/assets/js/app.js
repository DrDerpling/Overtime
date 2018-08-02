/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./materialize/materialize.js');
const flatpickr = require("flatpickr");
const rangePlugin = require('flatpickr/dist/plugins/rangePlugin')

//Modal setup
let modals = document.querySelectorAll('.modal');
if (modals instanceof NodeList) {
    let options = {};
    let instances = M.Modal.init(modals, options);
}

let inputs = document.querySelectorAll('.has-character-counter');
if (inputs instanceof NodeList) {
    let options = {};
    M.CharacterCounter.init(inputs);
}

let sidenav = document.querySelectorAll('.sidenav');
if (inputs instanceof NodeList) {
    let options = {'onOpenStart': true};
    let instances = M.Sidenav.init(sidenav, options);
}

const startDateInput = document.querySelector(".start_datepicker");

const daysLeft = document.querySelector("#daysLeft")
if (startDateInput instanceof HTMLElement) {
    const max = parseInt(startDateInput.dataset.maxdays)
    const mode =  (startDateInput.dataset.maxdays < 2) ? 'single' : 'range'
    console.log(max)
    const fp = flatpickr(startDateInput, {
        onChange: function(selectedDates, dateStr, instance) {
            let maxDays = 0;
            if (instance.config.mode.match('single')) {
                maxDays = instance.config.max
            } else {
                maxDays = instance.config.max - 1
            }

            let firstDate = new Date(dateStr);
            let endDate = new Date(firstDate)
            endDate.setDate(firstDate.getDate() + maxDays)
            console.log(maxDays)
            console.log(endDate)
            let count = 0;
            //Calculate how many weekend happen
            while (firstDate <= endDate) {
                let dayOfWeek = firstDate.getDay();
                if(dayOfWeek === 6 || dayOfWeek === 0)
                {
                    count++
                    endDate.setDate(endDate.getDate() + 1)
                }

                firstDate.setDate(firstDate.getDate() + 1);
            }
            console.log(count)

            instance.set('weekendDays', count)
            instance.set('endDate', endDate)
            instance.set('maxDate', endDate)

        },
        onClose: function(selectedDates, dateStr, instance) {
            const endDate = instance.config.endDate
            const weekendDays = instance.config.weekendDays
            if (selectedDates[0] < endDate) {
                // The number of milliseconds in one day
                const one_day = 1000 * 60 * 60 * 24

                // Convert both dates to milliseconds
                let date1_ms = selectedDates[0].getTime()
                let date2_ms = endDate.getTime()

                // Calculate the difference in milliseconds
                var difference_ms = Math.abs(date1_ms - date2_ms)

                // Convert back to days
                const daysLeft = Math.round(difference_ms / one_day - weekendDays - 1)

                //Sets days left in display
                instance.config.dayLeftDisplay.innerText = "" + daysLeft
            } else if (instance.config.mode.match('single')) {
                instance.config.dayLeftDisplay.innerText = "" + 0
            }
        },
        max: max,
        mode: mode,
        minDate: 'today',
        dayLeftDisplay: daysLeft,
        plugins: [new rangePlugin({ input: ".end_datepicker"})]
    });
}


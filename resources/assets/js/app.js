/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./materialize/materialize.js');
const flatpickr = require("flatpickr");

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

const myInput = document.querySelector(".start_datepicker");
if (myInput instanceof HTMLElement) {
    const fp = flatpickr(myInput, {
        mode: 'range',
        onChange: function(selectedDates, dateStr, instance) {
            let maxDays = instance.config.max
            let firstDate = new Date(dateStr);
            let endDate = new Date(dateStr).fp_incr(maxDays)
            while (firstDate <= endDate) {
                let dayOfWeek = firstDate.getDay();
                if((dayOfWeek === 6) || (dayOfWeek === 0))
                {
                    maxDays++;
                }

                firstDate.setDate(firstDate.getDate() + 1);
            }

            endDate = new Date(dateStr).fp_incr(maxDays + 1)

            instance.set('maxDate', endDate)

        },
        max: myInput.dataset.maxdays,
        minDate: 'today',
    });
}


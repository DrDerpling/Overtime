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

const countWorkDays = (firstDate, endDate, calcEndDate = false) => {
    let weekendDays = 0;
    let workDays = 0;
    //Calculate how many weekend days are in between
    while (firstDate <= endDate) {
        let dayOfWeek = firstDate.getDay();
        if (dayOfWeek === 6 || dayOfWeek === 0) {
            weekendDays++;
            if (calcEndDate) {
                endDate.setDate(endDate.getDate() + 1);
            }
        } else {
            workDays++
        }

        firstDate.setDate(firstDate.getDate() + 1);
    }
    return {endDate: endDate, weekendDays: weekendDays, workDays: workDays}
}

const rangepicker = (startDateInput) => {
    const max = startDateInput.dataset.maxdays;
    const daysLeft = document.querySelector("#daysLeft");

    const fp = flatpickr(startDateInput, {
        onChange: function (selectedDates, dateStr, instance) {
            let maxDays = parseInt(instance.config.max);
            if (selectedDates.length === 1 && instance.config.mode.match('range')) {
                let firstDate = new Date(dateStr);
                let endDate = new Date(firstDate);
                endDate.setDate(firstDate.getDate() + maxDays);

                let object = countWorkDays(firstDate, endDate, true);

                instance.set('maxDate', object.endDate)
            } else if (selectedDates.length === 2) {
                let object = countWorkDays(selectedDates[0], selectedDates[1], false);
                daysLeft.innerText = "" + maxDays - object.workDays + 1
            } else if (instance.config.mode.match('single')) {
                daysLeft.innerText = "" + 0
            }
        },
        max: max,
        mode: 'range',
        minDate: new Date().fp_incr(1),
        dayLeftDisplay: daysLeft,
        weekNumbers: true,
        locale: {
            "firstDayOfWeek": 1
        }
    });
}

const startDateInput = document.querySelector(".start_datepicker");

if (startDateInput instanceof HTMLElement) {
    rangepicker(startDateInput);
}

var payoutSlider = document.getElementById('#payout-slider');
if (payoutSlider instanceof HTMLElement) {
    let max = payoutSlider.dataset.maxHours;
    M.noUiSlider.create(payoutSlider, {
        start: [0, max],
        connect: true,
        step: 0.25,
        orientation: 'horizontal', // 'horizontal' or 'vertical'
        range: {
            'min': 0,
            'max': max
        },
        format: wNumb({
            decimals: 2
        })
    });
}

let toastMessage = document.querySelector('#toastMessage')
if (toastMessage instanceof HTMLElement) {
    M.toast({html: toastMessage.innerText});
}

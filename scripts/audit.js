"use strict";

let weightSelects = document.querySelectorAll('.checklist__weight');

for (let i = 0, max = weightSelects.length; i < max; i++) {
    weightSelects[i].addEventListener('change', () => {
        weightSelects[i].classList.add('pending');

        ajax('/modules/weight', {
            method: 'POST',
            data: {
                audit: auditid,
                checklist: weightSelects[i].dataset.checklist,
                weight: weightSelects[i].value
            },
            success: xhr => {
                weightSelects[i].classList.remove('pending');
                console.log(xhr.response);
                let sum = 0;
                for (let weight of JSON.parse(xhr.response)) {
                    sum += weight;
                }
                document.querySelector('.error-checklist-sum').hidden = Math.round(sum * 100) === 100;
            }
        });
    });
}

let joinChecklistButtons = document.querySelectorAll('[data-join]');

for (let i = 0, max = joinChecklistButtons.length; i < max; i++) {
    let activator = joinChecklistButtons[i];
    activator.addEventListener('click', () => {
        ajax('/modules/joinchecklist', {
            method: 'POST',
            data: {
                checklist: activator.dataset.join,
                id: auditid
            },
            success: () => {
                activator.hidden = true;
                document.querySelector('[data-leave="' + activator.dataset.join + '"]').hidden = false;
            }
        });
    });
}

let leaveChecklistButtons = document.querySelectorAll('[data-leave]');

for (let i = 0, max = leaveChecklistButtons.length; i < max; i++) {
    let activator = leaveChecklistButtons[i];
    activator.addEventListener('click', () => {
        ajax('/modules/leavechecklist', {
            method: 'POST',
            data: {
                checklist: activator.dataset.leave,
                id: auditid
            },
            success: () => {
                activator.hidden = true;
                document.querySelector('[data-join="' + activator.dataset.leave + '"]').hidden = false;
            }
        });
    });
}

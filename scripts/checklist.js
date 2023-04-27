"use strict";

let markdescActivators = document.querySelectorAll('[data-markdesc]');

for (let i = 0, max = markdescActivators.length; i < max; i++) {
    let activator = markdescActivators[i];

    activator.addEventListener('click', evt => {
        evt.preventDefault();
        document.querySelector('#markdesc-' + activator.dataset.markdesc).hidden = !document.querySelector('#markdesc-' + activator.dataset.markdesc).hidden;
        activator.classList.toggle('active');
    });
}

let standardActivators = document.querySelectorAll('[data-standard]');

for (let i = 0, max = standardActivators.length; i < max; i++) {
    let activator = standardActivators[i];

    activator.addEventListener('click', evt => {
        evt.preventDefault();
        document.querySelector('#standard-' + activator.dataset.standard).hidden = !document.querySelector('#standard-' + activator.dataset.standard).hidden;
        activator.classList.toggle('active');
    });
}

let openedbyneg2  = [];
let commentsActivators = document.querySelectorAll('[data-comments]');
let throttle = [];

for (let i = 0, max = commentsActivators.length; i < max; i++) {
    let activator = commentsActivators[i];
    let id = activator.dataset.comments;
    let status = document.querySelector('#comments-' + id + ' .status');

    throttle.push(0);

    document.querySelector('#comments-' + id + ' textarea').addEventListener('input', evt => {
        status.textContent = ' Сохранение...';

        if (throttle[id]) {
            clearTimeout(throttle[id]);
        }

        throttle[id] = setTimeout(() => {
            throttle[id] = 0;

            ajax('/modules/comment', {
                method: 'POST',
                data: {
                    criteria: id,
                    text: evt.target.value,
                    checklist: checklistid,
                    audit: auditid
                },
                success: xhr => {
                    status.textContent = 'Сохранено';
                    console.log(xhr.response);
                    openedbyneg2[id] = false;
                    if (evt.target.value.trim()) {
                        activator.classList.add('filled');
                    } else {
                        activator.classList.remove('filled');
                    }
                }
            });
        }, 1000);
    });

    activator.addEventListener('click', evt => {
        evt.preventDefault();
        document.querySelector('#comments-' + id).hidden = !document.querySelector('#comments-' + id).hidden;
        activator.classList.toggle('active');
    });
}

let titles = document.querySelectorAll('[data-category]');

for (let i = 0, max = titles.length; i < max; i++) {
    let activator = titles[i];


    activator.addEventListener('click', evt => {
        evt.preventDefault();
        document.querySelector('#category-' + activator.dataset.category).hidden = !document.querySelector('#category-' + activator.dataset.category).hidden;
        activator.classList.toggle('active');
    });
}

let criteriaMarks = document.querySelectorAll('[data-criteria]');

for (let i = 0, max = criteriaMarks.length; i < max; i++) {
    criteriaMarks[i].addEventListener('change', evt => {
        criteriaMarks[i].classList.add('pending');
        let mark = evt.target;

        console.log(parseInt(mark.value), document.querySelector('#comments-' + mark.dataset.criteria), '#comments-' + mark.dataset.criteria);
        if (parseInt(mark.value) === -2) {
            if (document.querySelector('#comments-' + mark.dataset.criteria).hidden) {
                openedbyneg2[mark.dataset.criteria] = true;
            }
            document.querySelector('#comments-' + mark.dataset.criteria).hidden = false;
            document.querySelector('[data-comments="' + mark.dataset.criteria + '"]').classList.add('active');
        } else if (openedbyneg2[mark.dataset.criteria] && !document.querySelector('#comments-' + mark.dataset.criteria + ' textarea').value.trim()) {
            document.querySelector('#comments-' + mark.dataset.criteria).hidden = true;
            document.querySelector('[data-comments="' + mark.dataset.criteria + '"]').classList.remove('active');
            openedbyneg2[mark.dataset.criteria] = false;
        }

        ajax('/modules/mark', {
            method: 'POST',
            data: {
                criteria: mark.dataset.criteria,
                checklist: checklistid,
                audit: auditid,
                mark: mark.value
            },
            success: xhr => {
                criteriaMarks[i].classList.remove('pending');
                console.log(xhr.response);
            }
        });
    });
}

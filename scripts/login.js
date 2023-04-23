"use strict";

var loginApp = new Vue ({
    el: '.content',
    data: {

    },
    methods: {
        login: function (evt) {
            evt.preventDefault();
            ajax('/modules/login', {
                method: 'POST',
                data: document.querySelector('form'),
                success: function (xhr) {
                    console.log(xhr.response);
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        }
    }
});
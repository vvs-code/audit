"use strict";

var ajax = function ajax(url, obj) {
    if (!url) {
        throw new Error('ajax(): key "url" must exist');
    }
    obj.data = obj.data || '';
    if (obj.data instanceof HTMLFormElement) {
        obj.data = new FormData(obj.data);
    } else if (typeof(obj.data) === 'object') {
        var formData = new FormData();
        for (var key in obj.data) {
            if (obj.data.hasOwnProperty(key)) {
                formData.append(key, obj.data[key]);
            }
        }
        obj.data = formData;
    } else {
        obj.data = String(obj.data);
    }
    var xhr = new XMLHttpRequest();
    xhr.open(obj.method || 'POST', url, obj.async === undefined ? true : obj.async);
    typeof obj.progress === 'function' && (xhr.upload.onprogress = obj.progress);
    typeof obj.getProgress === 'function' && (xhr.onprogress = obj.getProgress);
    xhr.onreadystatechange = function () {
        typeof obj.onreadystatechange === 'function' && obj.onreadystatechange(xhr);
        if (xhr.readyState !== 4) {
            return;
        }
        typeof obj.onready === 'function' && obj.onready(xhr);
        if (obj.onstatus && _typeof(obj.onstatus) === 'object') {
            for (var key in obj.onstatus) {
                if (obj.onstatus.hasOwnProperty(key) && xhr.status === parseInt(key, 10)) {
                    typeof obj.onstatus[key] === 'function' && obj.onstatus[key](xhr);
                }
            }
        }
        if (xhr.status === 200) {
            typeof obj.success === 'function' && obj.success(xhr);
        } else {
            typeof obj.error === 'function' && obj.error(xhr);
        }
    };
    xhr.send(obj.data);
};




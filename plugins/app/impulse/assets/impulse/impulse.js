'use strict';

(function () {
    var impulse = {
        level: {
            error: 1,
            warning: 2,
            info: 4,
            trace: 8
        },
        air: function (category, message, level) {
            category = category || '';
            message = message || '';
            level = level || impulse.level.info;

            var data = new FormData(),
                xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

            data.append('level', level);
            data.append('category', category);
            data.append('message', message);

            xhr.open('POST', '/impulse/air/push');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function (state) {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {

                    } else if (xhr.status != 200) {

                    }
                }
            };
            xhr.send(data);
        }
    };

    window.impulse = impulse;
})();

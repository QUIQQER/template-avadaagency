require(['MooTools'], function () {
    window.addEvent("domready", function () {
        "use strict";

        var ToTop = document.getElements('[href=#top]');
        if (ToTop) {
            ToTop.addEvent('click', function (event) {
                event.stop();
                new Fx.Scroll(window).toTop();
            });
        }

        require(['qui/QUI', 'utils/Controls'], function (QUI, Controls) {
            QUI.addEvent("onError", function (msg, url, linenumber) {
                console.error(msg);
                console.error(url);
                console.error('LineNo: ' + linenumber);
            });
        });
    });
});
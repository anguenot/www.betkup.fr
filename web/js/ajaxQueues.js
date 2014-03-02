/*!
 * jQuery.ajaxQueue - A queue for ajax requests
 *
 * (c) 2011 Pedro Sland
 * Original by (c) 2011 Corey Frang
 *
 * Dual licensed under the MIT and GPL licenses.
 *
 * Requires jQuery 1.5+
 */
(function ($) {

// Object for namespaced queues
    window.ajaxQueue = {};

    $.ajaxQueue = function (ajaxOpts) {
        var jqXHR,
            dfd = $.Deferred(),
            promise = dfd.promise(),
            queue = ajaxOpts.queue || 'default';

        if (!ajaxQueue[queue]) {
            ajaxQueue[queue] = [];
        }

        // queue our ajax request
        ajaxQueue[queue].push(doRequest);

        // add the abort method
        promise.abort = function (statusText) {

            var ret = promise;

            // proxy abort to the jqXHR if it is active
            if (jqXHR) {
                ret = jqXHR.abort(statusText);
            }

            var index = $.inArray(doRequest, ajaxQueue[queue]);

            if (index > -1) {
                ajaxQueue[queue].splice(index, 1);
            }

            // and then reject the deferred
            dfd.rejectWith(ajaxOpts.context || ajaxOpts, [ promise, statusText, "" ]);
            return promise;
        };

        // run the actual query
        function doRequest() {
            jqXHR = $.ajax(ajaxOpts)
                .done(dfd.resolve)
                .fail(dfd.reject)
                .always(doNext);
        }

        // Remove the current item and run the next if it exists.
        function doNext() {
            ajaxQueue[queue].shift();

            if (ajaxQueue[queue][0]) {
                ajaxQueue[queue][0]();
            }
        }

        if (ajaxQueue[queue].length == 1) {
            doRequest();
        }

        return promise;
    };

})(jQuery);
var ajaxQueueManager = [], simpleXhr = null;

(function ($) {
    $.fn.loadContent = function (params, callback) {
        var handler = $(this), handlerId = $(this).attr('id');

        function getQueueName() {
            var queueId = handlerId;
            if (typeof(queueId) == 'undefined') {
                queueId = handler.parent().attr('id');
                if (typeof(queueId) == 'undefined') {
                    queueId = handler.parent().parent().attr('id');
                    if (typeof(queueId) == 'undefined') {
                        queueId = handler.parent().parent().parent().attr('id');
                        if (typeof(queueId) == 'undefined') {
                            queueId = 'queueAjax';
                        }
                    }
                }
            }
            return queueId;
        }

        function showLoading(data) {
            handler.parent().loadingModal({
                show:true,
                loadingId:handlerId,
                modalId:handlerId
            });
        }

        function hideLoading(data) {
            handler.parent().loadingModal({
                show:false,
                loadingId:handlerId,
                modalId:handlerId
            });
        }

        function xhrComplete(data) {
            handler.fadeOut(0, function () {
                handler.html(data);

                if (params.animateDiv != '') {
                    var cancelBtn = '<input class="f1-button revertBtn" type="button" value="Annuler" onclick="revertDiv(\'' + params.animateDiv.attr('id') + '\');"/>';
                    params.animateDiv.find('.prediction_btn').append(cancelBtn);
                }

                hideLoading();

                handler.fadeIn(500, function () {
                    eval(callback);
                });
            });
        }

        params = $.extend({
            'url':'',
            'method':'GET',
            'data':{},
            'animateDiv':'',
            'onCompleteFunction':xhrComplete,
            'queue':false,
            'abortOld':false,
            'queueName':'',
            'executeQueue':false
        }, params);

        if (params.queue != false && params.queueName == '') {
            params.queueName = getQueueName();
            params.queueName = params.queueName.replace(/-_/g, '');
        }

        function qNext() {
            $.ajax(ajaxQueueManager[params.queueName].shift()).success(qNext);
        }

        // Reset the queue
        function qAbort() {
            ajaxQueueManager[params.queueName] = [];
        }

        function qAjax(options) {
            if (typeof ajaxQueueManager[params.queueName] == 'undefined') {
                ajaxQueueManager[params.queueName] = [];
            }
            ajaxQueueManager[params.queueName].push(options);
        }

        if (params.url != '') {
            if (params.queue != false) {

                // Abort the last requests if asking
                if (params.abortOld) {
                   qAbort();
                }
                // Put the request into queue.
                qAjax({
                    url:params.url,
                    type:params.method,
                    data:params.data,
                    async:true,
                    dataType:'html',
                    error:function (jqXHR, textStatus) {
                        hideLoading();
                    },
                    beforeSend:showLoading,
                    success:params.onCompleteFunction
                });
                if (params.executeQueue === true) {
                    qNext();
                }
            } else {
                // Abort the last request if asking.
                if (params.abortOld) {
                    if (typeof simpleXhr != 'undefined' && simpleXhr !== null) {
                        simpleXhr.abort();
                    }
                }
                // Use simple Ajax jQuery when we doesn't want to add calls in queue.
                simpleXhr = $.ajax({
                    type:params.method,
                    url:params.url,
                    data:params.data,
                    async:true,
                    dataType:'html',
                    error:function (jqXHR, textStatus) {
                        hideLoading();
                    },
                    beforeSend:showLoading
                }).done(params.onCompleteFunction);
            }
        }
    };
})(jQuery);
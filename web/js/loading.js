/* 
 Document   : loadingModal
 Created on : 23 nov. 2011, 10:43:30
 Author     : jonathan
 Description:
 jQuery loadingModal function to show or hide somme loading modal stuff on div
 Requires: jQuery v1.4+
 */
(function ($) {

    /*
     *  function loadingModal(), used to add somme loading modal stuff on div
     *
     * Usage:
     *     $(yourDivJQueryObject).loadingModal({show: true, loadingId: 'default', modalId: 'default'});
     */
    /*$.fn.loadingModal = function(params){

     params = $.extend({
     show: true,
     loadingId: 'default',
     modalId: 'default'
     }, params);

     if(params.show == true) {
     var modalHeight = $(this).height();
     var modalWidth = $(this).width();

     var positionX = parseInt(modalWidth)/2;
     var positionY = parseInt(modalHeight)/2;

     var loadingDiv = '<div id="loadingDivWait_'+params.loadingId+'" class="showLoadingDivWait">&nbsp;</div>';
     var modalDiv = '<div id="modalDivWait_'+params.modalId+'" class="showModalDivWait">&nbsp;</div>';

     $(this).prepend(modalDiv+loadingDiv);

     var widthLoadingDiv = $(this).find('#loadingDivWait_'+params.loadingId).width();
     var heightLoadingDiv = $(this).find('#loadingDivWait_'+params.loadingId).height();

     var centerLoadingDivX = positionX - (parseInt(widthLoadingDiv)/2);
     var centerLoadingDivY = positionY - (parseInt(heightLoadingDiv)/2);

     $(this).find('#modalDivWait_'+params.modalId).width(modalWidth).height(modalHeight);
     $(this).find('#loadingDivWait_'+params.modalId).css('margin-top', centerLoadingDivY+'px');
     $(this).find('#loadingDivWait_'+params.modalId).css('margin-left', centerLoadingDivX+'px');

     } else if(params.show == false) {
     $(this).find('#loadingDivWait_'+params.loadingId).remove();
     $(this).find('#modalDivWait_'+params.modalId).remove();
     }
     };*/
    ///// XXX Fix this dirty thing !!! ////
    $.fn.loadingModal = function (params) {

        params = $.extend({
            show:true,
            loadingId:'default',
            modalId:'default'
        }, params);

        params.loadingId = params.loadingId.replace(/-/g, '_');
        params.modalId = params.modalId.replace(/-/g, '_');

        if (params.show == true) {

            var modalHeight = $(this).height();
            var modalWidth = $(this).width();

            var positionX = parseInt(modalWidth) / 2;
            var positionY = parseInt(modalHeight) / 2;

            var loadingDiv = '<div id="loadingDivWait_' + params.loadingId + '" style="display: block; position: absolute; z-index: 10000; width: 220px; height: 19px;"><img src="/images/interface/wait_big.gif" width="220" height="19" /></div>';
            var modalDiv = '<div id="modalDivWait_' + params.modalId + '" style="position: absolute; display: block;background: rgba(255,255,255,0.6);z-index: 9000;">&nbsp;</div>';

            $(this).prepend(modalDiv + loadingDiv);

            var widthLoadingDiv = $(this).find('#loadingDivWait_' + params.loadingId).width();
            var heightLoadingDiv = $(this).find('#loadingDivWait_' + params.loadingId).height();

            var cssWidth = $(this).css('width');
            var patt = /%/g;
            if (patt.test(cssWidth)) {
                var minHeight = $(this).css('min-height');
                var marginTop = '-10px';
                if (minHeight == 'undefined' || typeof minHeight == 'undefined') {
                    minHeight = 0;
                }
                if (minHeight > modalHeight) {
                    modalHeight = minHeight;
                    marginTop = '-' + (modalHeight / 2) + 'px';
                }

                $(this).find('#modalDivWait_' + params.modalId).width(modalWidth).height(modalHeight);
                $(this).find('#loadingDivWait_' + params.modalId).css({
                    'top':'50%',
                    'left':'50%',
                    'margin-top':marginTop,
                    'margin-left':'-110px'
                });
            } else {
                var centerLoadingDivX = positionX - (parseInt(widthLoadingDiv) / 2);
                var centerLoadingDivY = positionY - (parseInt(heightLoadingDiv) / 2);

                $(this).find('#modalDivWait_' + params.modalId).width(modalWidth).height(modalHeight);
                $(this).find('#loadingDivWait_' + params.modalId).css('margin-top', centerLoadingDivY + 'px');
                $(this).find('#loadingDivWait_' + params.modalId).css('margin-left', centerLoadingDivX + 'px');
            }
        } else if (params.show == false) {
            $(this).find('#loadingDivWait_' + params.loadingId).remove();
            $(this).find('#modalDivWait_' + params.modalId).remove();
        }
    };

})(jQuery);
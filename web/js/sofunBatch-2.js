/**
 * jQuery plugin SofunBatch
 * Author: Jonathan
 */
(function ($) {
    /**
     * function SofunBatch(), used to load and move kups/rooms using a batch
     *
     * Needs:
     *         jQuery 1.6+
     *
     * Constraints:
     *         $(yourcontainerJQueryObject) need to be a div HTML
     *
     * Usage:
     *     $(yourcontainerJQueryObject).SofunBatch({
	 *     		id: 'default', (identifier for displayed elements)
	 *     		previousOffset: 0,
	 *			currentOffset: 0,
	 *			nextOffset: 2,
	 *     		batchSize: 2, (batch size, max number of element can be displayed)
	 *     		totalResults: 4,
	 *     		nbDisplay: 2, (number of element you want to display, currently 2 or 4)
	 *     		nbLine: 1, (number of line (table > tr) you want to display, currently 1 or 2)
	 *     		method: 'POST',
	 *     		ajaxSource: 'sofunBatch.php',
	 *     		async: 'false',
	 *     		elementHeight: 20, (if we know the final height of an element (a kup for example), it is better to give the size directly)
	 *     		textPager: 'Slide', (text for the pager, before the next/previous button)
	 *     		imgNext: 'Next', (the HTML image tag/HTML div tag/text of the next button for the pager)
	 *			imgPrev: 'Previous',(the HTML image tag/HTML div tag/text of the previous button for the pager)
	 *     });
     */
    $.fn.SofunBatch = function (params) {

        var onPreviousMove = false, onNextMove = false;

        // Default values
        var defaults = {
            id:'default',
            previousOffset:0,
            currentOffset:0,
            nextOffset:2,
            batchSize:2,
            totalResults:4,
            nbDisplay:2,
            nbLine:1,
            method:'POST',
            ajaxSource:'sofunBatch.php',
            data:{},
            async:true,
            elementHeight:'',
            textPager:'Slide',
            imgNext:'Next',
            imgPrev:'Previous',
            tfootCustom:0,
            prevClass:'',
            nextClass:'',
            loading:false
        };

        // Merge the given parameters with the default ones
        var opts = $.extend(defaults, params);

        // The container who is selected
        var container = $(this);

        // Initialization at startup
        _init();

        /**
         * Initialization
         * This function loads the first element to display synchronously and prepare the next element asynchronously
         */
        function _init() {
            // First we create an HTML table that will contain our elements (kups/room)
            var myTable = '<table id="sofunBatchTable_' + opts.id + '" style="border-spacing: 0px; border-collapse:collapse;"><thead></thead><tbody id="sofunBatchTBody_' + opts.id + '"><tr id="sofunBatchTr_' + opts.id + '" style="position:absolute; left: 0px;"></tr></tbody><tfoot id="sofunBatchTFoot_' + opts.id + '" style="position:absolute;"></tfoot></table>';
            container.html(myTable);

            // css properties width = yourcontainerJQueryObject width and height = yourcontainerJQueryObject height
            container.find('#sofunBatchTable_' + opts.id).css('width',function () {
                return container.width() + 'px';
            }).css('height', function () {
                    return container.height() + 'px';
                });

            // When the table is created, we call the render function that will do the rest (load elements and pager)
            _render();
        }

        /**
         * Rendering the results
         */
        function _render() {
            // First we load content in tbody.
            _call();

            if (parseInt(opts.totalResults, 10) > parseInt(opts.batchSize, 10)) {

                // Update the offsets
                opts.currentOffset = parseInt(opts.nextOffset, 10);
                opts.nextOffset = parseInt(opts.nextOffset, 10) + parseInt(opts.batchSize, 10);
            }
        }

        /**
         * Do Call Ajax function
         */
        function _call(params) {
            // Merge the given parameters with the defaults ones
            params = $.extend({
                currentOffset:parseInt(opts.currentOffset),
                batchSize:opts.batchSize,
                nbLine:opts.nbLine
            }, params);

            var offset = 0;
            while (offset < opts.totalResults) {

                // Update the offset for ajax call.
                var ajaxData = $.extend(
                    {
                        'offset':offset,
                        'batchSize':params.batchSize,
                        'nbLine':params.nbLine
                    }, opts.data
                );

                $.ajaxQueue({
                    url:opts.ajaxSource,
                    type:opts.method,
                    data:ajaxData,
                    async:true,
                    queue:'sofunBatchQueue_' + opts.id,
                    dataType:'html',
                    beforeSend:function (jqXHR, settings) {
                        // Create an MD5 hash code to set a unique id depending on url and data passing.
                        var hash = calcMD5(settings.url + settings.data);
                        jqXHR.hashCode = hash;

                        var tdHeight = '';
                        if (opts.elementHeight != '') {
                            tdHeight = 'height: ' + parseInt(opts.elementHeight, 10) + 'px;';
                        } else {
                            tdHeight = 'min-height: 180px;';
                        }

                        container.find('#sofunBatchTable_' + opts.id).find('#sofunBatchTBody_' + opts.id).find('#sofunBatchTr_' + opts.id).append(
                            '<td style="vertical-align: top; min-width: 700px; ' + tdHeight + '" class="sofunBatchTdcontainer" id="sofunBatchTdContent_' + opts.id + '_' + hash + '"></td>'
                        );

                        container.find('#sofunBatchTdContent_' + opts.id + '_' + hash).loadingModal({
                            show:true,
                            loadingId:opts.id,
                            modalId:opts.id
                        });
                    },
                    success:function (data, textStatus, jqXHR) {

                        container.find('#sofunBatchTdContent_' + opts.id + '_' + jqXHR.hashCode).loadingModal({
                            show:false,
                            loadingId:opts.id,
                            modalId:opts.id
                        });
                        container.find('#sofunBatchTdContent_' + opts.id + '_' + jqXHR.hashCode).html(data);

                        if (parseInt(opts.totalResults, 10) > parseInt(opts.batchSize, 10)) {
                            _addPager();
                        }

                    }
                });
                offset += parseInt(params.batchSize, 10);
            }
        }

        /**
         * Move next function
         */
        function _moveNext() {

            var tRObject, divWidth;
            // Get the tr object and it's width
            tRObject = container.find('#sofunBatchTable_' + opts.id).find('#sofunBatchTr_' + opts.id);
            divWidth = parseInt(tRObject.find('.sofunBatchTdDiv:first').width());
            // Do animation
            if(!onNextMove) {
                _moveNextAnimate(tRObject, divWidth);
            }
        }

        /**
         * Do the animation for _moveNext function
         */
        function _moveNextAnimate(tRObject, divWidth) {
            // Initialize the animation
            onNextMove = true;

            if (Math.floor(parseInt(opts.currentOffset, 10) / parseInt(opts.totalResults, 10)) <= 0) {
                // Update the offsets
                opts.previousOffset = parseInt(opts.currentOffset, 10);
                opts.currentOffset = parseInt(opts.nextOffset, 10);
                opts.nextOffset = parseInt(opts.nextOffset) + parseInt(opts.batchSize);

                // Do next animation
                tRObject.animate({
                    left:'-=' + parseInt(divWidth * opts.nbDisplay)
                }, 1000, function() {
                    onNextMove = false;
                });
            } else {
                // Do the butts animation
                tRObject.animate({
                    left:'-=40'
                }, 200).animate({
                        left:'+=40'
                    }, 200, function() {
                        onNextMove = false;
                    });
            }
        }

        /**
         * Move previous function
         */
        function _movePrevious() {

            var tRObject, divWidth;
            // Get the tr object and it's width
            tRObject = container.find('#sofunBatchTable_' + opts.id).find('#sofunBatchTr_' + opts.id);
            divWidth = parseInt(tRObject.find('.sofunBatchTdDiv:first').width());
            // Do animation
            if(!onPreviousMove) {
                _movePreviousAnimate(tRObject, divWidth);
            }
        }

        /**
         * Do the animation for _movePrevious function
         */
        function _movePreviousAnimate(tRObject, divWidth) {

            // Initialize the animation
            onPreviousMove = true;

            if (parseInt(opts.previousOffset, 10) > 0) {
                // Update the offsets
                opts.nextOffset = parseInt(opts.nextOffset, 10) - parseInt(opts.batchSize, 10);
                opts.currentOffset = parseInt(opts.previousOffset, 10);
                opts.previousOffset = parseInt(opts.previousOffset, 10) - parseInt(opts.batchSize, 10);

                // Do previous animation
                tRObject.animate({
                    left:'+=' + parseInt(divWidth * opts.nbDisplay)
                }, 1000, function() {
                    onPreviousMove = false;
                });
            } else {
                // Do the butts animation
                tRObject.animate({
                    left:'+=40'
                }, 200).animate({
                        left:'-=40'
                    }, 200, function() {
                        onPreviousMove = false;
                    });
            }
        }

        /**
         * Add pagination buttons
         */
        function _addPager() {
            // Add in tfoot the div that will contain the previous/next buttons and create the buttons
            container.find('#sofunBatchTFoot_' + opts.id).html('<div id="sofunBatchTfootDiv_' + opts.id + '"></div>');

            var tableTfoot;
            if (opts.tfootCustom == 1) {
                tableTfoot = opts.imgPrev + opts.imgNext;
            } else {
                tableTfoot = '<table style="border-spacing: 0px; border-collapse:collapse; text-align:left; vertical-align:middle;"><tr><td style="color:#b2b2b2; font-size: 10px; padding-right: 10px; width:150px; text-align: right;">' + opts.textPager + '</td><td><a href="javascript:void(0);" id="sofunBatchPrev_' + opts.id + '">' + opts.imgPrev + '</a></td><td><a href="javascript:void(0);" id="sofunBatchNext_' + opts.id + '">' + opts.imgNext + '</a></td></tr></table>';
            }
            container.find('#sofunBatchTable_' + opts.id).find('#sofunBatchTfootDiv_' + opts.id).html(tableTfoot);
            // By default, the div will appear in the right side of the table with a margin right of 20px
            if (opts.tfootCustom != 1) {
                container.find('#sofunBatchTable_' + opts.id).find('#sofunBatchTfootDiv_' + opts.id).find('table').css('margin-left', function () {
                    return (parseInt(container.width()) - parseInt(container.find('#sofunBatchTfootDiv_' + opts.id).find('table').width()) - 20) + 'px';
                });
                // By default, the pager will appear at the bottom of container
            }
            var marginTopHeight;
            if (opts.elementHeight == '') {

                marginTopHeight = parseInt((container.find('#sofunBatchTr_' + opts.id).height()), 10);
                container.find('#sofunBatchTable_' + opts.id).find('#sofunBatchTFoot_' + opts.id).css('top', marginTopHeight + 'px');
            } else {
                marginTopHeight = parseInt((parseInt(opts.elementHeight, 10) * opts.nbLine), 10);
                container.find('#sofunBatchTable_' + opts.id).find('#sofunBatchTFoot_' + opts.id).css('top', marginTopHeight + 'px');
            }

            // Add event handler on the buttons next/previous
            if (opts.tfootCustom == 1) {
                $('#sofunBatchTfootDiv_' + opts.id).find('.' + opts.prevClass).click(function () {
                    _movePrevious();
                });
                $('#sofunBatchTfootDiv_' + opts.id).find('.' + opts.nextClass).click(function () {
                    _moveNext();
                });
            } else {
                container.find('#sofunBatchPrev_' + opts.id).click(function () {
                    _movePrevious();
                });
                container.find('#sofunBatchNext_' + opts.id).click(function () {
                    _moveNext();
                });
            }
        }
    };
})(jQuery);
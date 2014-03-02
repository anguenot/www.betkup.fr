(function($) {
	$.fn.charCounter = function(params) {
		var counterLabel, handle, charLength;
		
		handle = $(this);
		params = $.extend({
        	'maxlength' : 20,
        	'lengthcut' : true,
        	'counterId' : 'sofun-counter',
        	'counterText' : 'characters left',
        	'position' : 'after'
        }, params);
		
		var _addToCounter = function(value) {
			if(value == 'init') {
				counterLabel = '<label class="sofun-counter" id="'+params.counterId+'">'+params.maxlength+' '+params.counterText+'</label>';
				if(params.position == 'before') {
					handle.before(counterLabel);
				} else if(params.position == 'after') {
					handle.after(counterLabel);
				}
			} else {
				$('#'+params.counterId).html(value+' '+params.counterText);
				if(value == 0) {
					$('#'+params.counterId).removeClass('sofun-counter-green');
					$('#'+params.counterId).addClass('sofun-counter-red');
				} else {
					$('#'+params.counterId).removeClass('sofun-counter-red');
					$('#'+params.counterId).addClass('sofun-counter-green');
				}
			}
		};
		
		var _addMaxlength = function() {
			if(handle.get(0).tagName == 'input') {
				handle.attr('maxlength', params.maxlength);
			} else {
				handle.attr('maxlength', params.maxlength);
				handle.attr('lengthcut', params.lengthcut);
			}
		};
		
		// Initialisation
		var _init = function() {
			_addToCounter('init');
			_addMaxlength();
		};
		
		_init();
		//Get current length
		charLength = params.maxlength - handle.val().length;
		_addToCounter(charLength);
		handle.keyup(function() {			
			// Get new length of characters
			charLength = params.maxlength - $(this).val().length;
			_addToCounter(charLength);
		});
	};
})(jQuery);
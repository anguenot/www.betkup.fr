(function($) {
	var oldWidth = [], oldHeight = [], _divToAnimate = [], oldUrl = '',
		isAlreadyRemoved = false, isAlreadyMerged = false;
	
	$.fn.removeAllOtherWindow = function(params) {
        var handler = $(this);
        
        params = $.extend({
        	'contener' : '',
        	'divToAnimate': [],
        	'oldUrl' : '',
        	'urlCallBack' : '',
        	'method' : 'GET',
        	'saveBtnClass' : 'savePronostic',
        	'fnSavePronostics' : function() {},
        	'btnContener' : '',
        	'callback' : function() {},
        	'data' : {}
        }, params);
        
        if(isAlreadyRemoved === false) {
        	_divToAnimate = params.divToAnimate;
        
	        if($.isArray(params.divToAnimate)) {
	        	for(var i=0; i < params.divToAnimate.length; i++) {
	        		oldWidth[i] = $('#'+params.divToAnimate[i]).width();
	        		oldHeight[i] = $('#'+params.divToAnimate[i]).height();
	        		if(handler.attr('id') != params.divToAnimate[i]) {
	        			_animate(params.divToAnimate[i], i);
	            	}
	        	}
	        	_animateDiv(handler);
	        	oldUrl = params.oldUrl;
	        	isAlreadyRemoved = true;
	        	isAlreadyMerged = false;
	        }
        }
        
        function _animateDiv(handle) {
    		var width, height, _opacity, delay;
        	
        	width = handle.width();
        	height = handle.height();
        	delay = 900;
        	_opacity = 1;
        	
        	handle.animate({
        		opacity: _opacity,
        		width: $('#'+params.contener).width()-20,
        		height: 680
        	}, delay, function() { handleCallBack(handle); });
        	
        	handle.find('.f1-contener').fadeOut(700);
        	
        	handle.find('.background-div').animate({
        		opacity: _opacity,
        		width: $('#'+params.contener).width()-20,
        		height: 670
        	}, delay, function() { });
        	
        }
        
        function _animate(div, index) {
        	var width, height, _opacity, orientation, delay;
        	
        	orientation = $('#'+div).attr('orientation');
        	width = $('#'+div).width();
        	height = $('#'+div).height();
        	delay = 500;
        	_opacity = 0;
        
        	switch(orientation) {
	        	case 'left':
	        		$('#'+div).animate({
	            		opacity: _opacity,
	            		left: "-="+width
	            	}, delay, function() {animationCallBack('#'+div);});
	        		break;
	        	case 'top':
	        		$('#'+div).animate({
	            		opacity: _opacity,
	            		top: "-="+height
	            	}, delay, function() {animationCallBack('#'+div);});
	        		break;
	        	case 'right':
	        		$('#'+div).animate({
	            		opacity: _opacity,
	            		right: "-="+width
	            	}, delay, function() {animationCallBack('#'+div);});
	        		break;	
	        	case 'bottom':
	        		$('#'+div).animate({
	            		opacity: _opacity,
	            		bottom: "-="+height
	            	}, delay, function() {animationCallBack('#'+div);});
	        		break;
	        	default:
	        		
	        		break;
        	}
        }
        
        function handleCallBack(obj) {
        	obj.find('.f1-contener').width($('#'+params.contener).width()-30).loadContent({
        		'url' : params.urlCallBack,
            	'method' : params.method,
            	'data' : params.data,
            	'animateDiv' : handler
        	});
        	
        	obj.find('.savePronostic').val('Enregistrer').attr('onclick', '').unbind('click').click(function() {
        		savePredictions();
        	});
        }
        
        function animationCallBack(obj) {
        	$(obj).hide();
        }
        
	};
	
	$.fn.mergeAllWindow = function(params) {
		var handler = $(this);
        
        params = $.extend({
        	'contener' : '',
        	'divToAnimate': _divToAnimate,
        	'urlCallBack' : '',
        	'method' : 'GET',
        	'btnContener' : '',
        	'saveBtnClass' : 'savePronostic',
        	'callback' : function() {},
        	'data' : {}
        }, params);
        
        if(isAlreadyMerged === false) {
	        if($.isArray(params.divToAnimate)) {
	        	var index;
	        	for(var i=0; i < params.divToAnimate.length; i++) {
	        		if(handler.attr('id') == params.divToAnimate[i]) {
	        			index = i;
	        			break;
	        		}
	        	}
	        	_animateDiv(handler,index, function() {
		        	for(var i=0; i < params.divToAnimate.length; i++) {
		        		if(handler.attr('id') != params.divToAnimate[i]) {
		        			_animate(params.divToAnimate[i]);
		            	}
		        	}
	        	});
	        	isAlreadyRemoved = false;
	        	isAlreadyMerged = true;
	        	
	        	if(typeof params.callback == 'function') {
	        		setTimeout(function() {
	        			var data = '';
	        			params.callback.call(this, data);
	        		}, 1500);
	        	}
	        }
        }

        function _animateDiv(handle, index, callback) {
    		var _opacity, delay;
        	delay = 900;
        	_opacity = 1;
        	
        	handle.animate({
        		opacity: _opacity,
        		width: oldWidth[index],
        		height: oldHeight[index]
        	}, delay, function() { 
        		handle.find('.revertBtn').remove();
        		
        		handle.find('.savePronostic').val('Pronostiquer !').attr('onclick', '').unbind('click').click(function() {
        			animateDiv(handle.attr('id'));
            	});
        		
        		handle.find('.f1-contener').width(oldWidth[index]);
        		handle.find('.f1-contener').height(oldHeight[index]);
        		
        		if(handle.find('.f1-contener').length) {
        			handle.find('.f1-contener').loadContent({
    	        		'url' : oldUrl,
    	            	'method' : params.method,
    	            	'data' : params.data
    	        	});
            	}
        	});
        	
        	handle.find('.f1-contener').fadeOut(700);
        	
        	handle.find('.background-div').animate({
        		opacity: _opacity,
        		width: oldWidth[index],
        		height: oldHeight[index]-10
        	}, delay, callback);
        }
        
        function _animate(div) {
        	var width, height, _opacity, orientation, delay;
        	
        	orientation = $('#'+div).attr('orientation');
        	width = $('#'+div).width();
        	height = $('#'+div).height();
        	
        	params.contener = div;
        	params.urlCallBack = '';
        	delay = 500;
        	_opacity = 1;
        	$('#'+div).show();
        	
        	switch(orientation) {
	        	case 'left':
	        		$('#'+div).animate({
	            		opacity: _opacity,
	            		left: "+="+width
	            	}, delay, function() {animationCallBack('#'+div);});
	        		break;
	        	case 'top':
	        		$('#'+div).animate({
	            		opacity: _opacity,
	            		top: "+="+height
	            	}, delay, function() {animationCallBack('#'+div);});
	        		break;
	        	case 'right':
	        		$('#'+div).animate({
	            		opacity: _opacity,
	            		right: "+="+width
	            	}, delay, function() {animationCallBack('#'+div);});
	        		break;	
	        	case 'bottom':
	        		$('#'+div).animate({
	            		opacity: _opacity,
	            		bottom: "+="+height
	            	}, delay, function() {animationCallBack('#'+div);});
	        		break;
	        	default:
	        		
	        		break;
        	}
        }
        
        function animationCallBack(obj) {
        }
	};
	
	$.fn.showBetWindow = function(params) {
		var handler = $(this);
		
		params = $.extend({
        	'contener' : '',
        	'backgroudDiv' : '',
        	'divToAnimate': _divToAnimate,
        	'betUrl' : '',
        	'predictionDatas' : {},        	
        	'method' : 'GET',
        	'btnContener' : '',
        	'saveBtnClass' : 'savePronostic',
        	'callback' : function() {},
        	'data' : {}
        }, params);
		
		var betXhr = $.ajax({
			'url' : params.betUrl,
			'type' : params.method,
			'dataType' : 'html',
			'beforeSend' : function() {
				$('#'+params.backgroudDiv).loadingModal();
			}, 'data' : params.predictionDatas
		});
		
		betXhr.done(function(response) {
			$('#'+params.backgroudDiv).find('.savePronostic').val('Miser !').attr('onclick', '').unbind('click').click(function() {
				saveBet();
        	});
			$('#'+params.backgroudDiv).loadingModal({show: false});
			$('#'+params.backgroudDiv).animate({
				'height' : 540
			}, 500);
			$('#'+params.backgroudDiv).find('.background-div').animate({
				'height' : 530
			}, 500, function() {
				handler.html(response);
			});
			
		});
	};
	
})(jQuery);
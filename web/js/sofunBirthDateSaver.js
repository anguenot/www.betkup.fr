(function($) {
	/**
	 * Function SofunBirthDate, used to set the user birth date
	 * 
	 * Needs : Jquery 1.6+, jquery.cookie plugin 
	 * 
	 * Usage :
	 * 
	 * SofunBirthDate({ 
	 * day: jQuery Object, 
	 * month: jQuery Object, 
	 * year: jQuery Object 
	 * ...
	 * });
	 */
	
	$.fn.SofunBirthDate = function(options) {
		
		var defaultOptions = {
			day : $('#connexion_birthdate_day'),
			month : $('#connexion_birthdate_month'),
			year : $('#connexion_birthdate_year'),
			dayMenu: $('#connexion_birthdate_day-menu'),
			dayButton: $('#connexion_birthdate_day-button'),
			monthMenu: $('#connexion_birthdate_month-menu'),
			monthButton: $('#connexion_birthdate_month-button'),
			yearMenu: $('#connexion_birthdate_year-menu'),
			yearButton: $('#connexion_birthdate_year-button'),
			email: '',
			birthDate: '',
			callback: ''
		};
		
		// Init	
		var opts = $.extend(defaultOptions, options);
		
		// Call callback function
		if(opts.callback == 'setBirthDate') {
			setBirthDate(opts);
		}
		
		/**
		 * Function setBirthDate() Used to set the user birth date value
		 * depending on the user birth date cookie and email value
		*/
		function setBirthDate(opts) {
			var email = opts.email;
			
			if (email != '' && email != null) {
				if (opts.birthDate != '') {
					
					var birthDate = opts.birthDate.split('/');
	                
					opts.day.val(parseInt(birthDate[0], 10));
					opts.month.val(parseInt(birthDate[1], 10));
					opts.year.val(parseInt(birthDate[2], 10));
					
					// Fix for the selectMenu jquery plugin
					opts.dayMenu.find("a").attr('aria-selected', 'false');
					opts.dayMenu.find('li').removeClass('ui-selectmenu-item-selected');
					opts.dayMenu.find("a:contains('"+birthDate[0]+"')").attr('aria-selected', 'true');
					opts.dayMenu.find("a:contains('"+birthDate[0]+"')").parent().addClass('ui-selectmenu-item-selected');
					opts.dayButton.find('.ui-selectmenu-status').html(birthDate[0]);
					
					opts.monthMenu.find("a").attr('aria-selected', 'false');
					opts.monthMenu.find('li').removeClass('ui-selectmenu-item-selected');
					opts.monthMenu.find("a:contains('"+birthDate[1]+"')").attr('aria-selected', 'true');
					opts.monthMenu.find("a:contains('"+birthDate[1]+"')").parent().addClass('ui-selectmenu-item-selected');
					opts.monthButton.find('.ui-selectmenu-status').html(birthDate[1]);
					
					opts.yearMenu.find("a").attr('aria-selected', 'false');
					opts.yearMenu.find('li').removeClass('ui-selectmenu-item-selected');
					opts.yearMenu.find("a:contains('"+birthDate[2]+"')").attr('aria-selected', 'true');
					opts.yearMenu.find("a:contains('"+birthDate[2]+"')").parent().addClass('ui-selectmenu-item-selected');
					opts.yearButton.find('.ui-selectmenu-status-small-box').html(birthDate[2]);
				}
			}
		};
		
		return $(this);
	};
	
})(jQuery);

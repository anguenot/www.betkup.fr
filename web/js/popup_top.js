$(document).ready(function() {

	var popupDisplay = 0;
	$("#boutonConnexionPopup").click(function(key) {
		if (popupDisplay == 0) {
			$('#popupConnection').show();
			popupDisplay = 1;
		} else if (popupDisplay == 1) {
			$('#popupConnection').hide();
			popupDisplay = 0;
		}
	});

});
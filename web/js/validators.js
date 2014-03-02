function isValidZipcode(zipcode, widget) {
	var formatCodeZip = new RegExp("^(([0-8][0-9AB])|(9[0-8AB]))[0-9]{3}$", "g");
	if(!formatCodeZip.test(zipcode)) {
        return false;
    } else {
    	return true;
    }
}

function isValidEmail(email) {
	var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if(!rege.test(email)) {
		return false;
	} else {
		return true;
	}
}

function isValidPassword(password) {
	 var rege = /^(.{5})+/;
	 if(!rege.test(password)) {
		return false;
	 } else {
		return true;
	 }
}

function isValidDeposit(deposit) {
	var rege = /^([0-9])+$/;
	if(!rege.test(deposit)) {
		return false;
	} else {
		return true;
	}
}


function isValidNicknameFormat(nickname) {
	var rege = new RegExp("^[0-9A-Za-zÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸàâäçéèêëîïôöùûüÿÆŒæœ€#$'()*+,./:;=?!@_ -]*$", "g");
	if(!rege.test(nickname)) {
		return false;
	} else {
		return true;
	}
}

function isValidNicknameSize(nickname) {
	var rege = /^(.{5})+/;
	if(!rege.test(nickname)) {
		return false;
	} else {
		return true;
	}
}

function isExistNickName(nickname, url) {
	var response = false;
	var jxhr = $.ajax({
			type: 'post',
			async: false,
			url: url,
			dataType: 'text',
			data: {accountPseudo: nickname},
			cache: false 
	});
	
	jxhr.done(function(data) {
		response = data;
	});
	
	return response;
}

function isValidString64(string) {
	var rege = new RegExp("^[0-9A-Za-zÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸàâäçéèêëîïôöùûüÿÆŒæœ€#$'()*+,./:;=?!@_ -]*$", "g");
	if(!rege.test(string)) {
		return false;
	} else {
		return true;
	}
}


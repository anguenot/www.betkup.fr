function checkAge(min_age, year, month, day)
{
	/* the minumum age you want to allow in */
	var min_age = parseInt(min_age);

	/* change "age_form" to whatever your form has for a name="..." */
	var year = parseInt(year);
	var month = parseInt(month) - 1;
	var day = parseInt(day);

	var theirDate = new Date((year + min_age), month, day);
	var today = new Date;

	if ( (today.getTime() - theirDate.getTime()) < 0) {
		return false;
	}
	else {
		return true;
	}
}
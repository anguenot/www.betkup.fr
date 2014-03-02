<div class="popupConnection" id="popupConnection" style="overflow: hidden; display: none;">
    <div class="account" align="left" style="margin-top: 30px; margin-left: 30px;">
        <div class="login">
            <form name="formPopupConnection" id="formPopupConnection" method="post" action="<?php echo url_for(array('module' => 'account', 'action' => 'login')) ?>" onsubmit="return false;">
                <span class="legende" style="font-style: normal;"><?php echo strtoupper($form['email']->renderLabel()) ?></span><br/>
                <label><?php echo $form['email']->render() ?></label><br/>
                <?php echo $form['email']->renderError() ?><br/>

                <span class="legende" style="font-style: normal;"><?php echo strtoupper($form['password']->renderLabel()) ?></span><br/>
                <label><?php echo $form['password']->render() ?></label><br/>
                <?php echo $form['password']->renderError() ?><br />

                <span class="legende" style="font-style: normal;"><?php echo $form['birthdate']->renderLabel() ?></span><br/>
                <div style="height: 5px;"></div>
                <label><?php echo $form['birthdate']->render() ?></label><br/>

                <?php echo $form->renderHiddenFields(); ?>

                <div align="center" style="margin-top: 15px; width: 255px;">
                    <input type="image" id="buttonSubmitPopup" src="/images/header/popupConnection/connexion.png">
                    <div style="margin-top: 5px; margin-bottom: 5px;">
                    	<?php echo link_to(__('label_header_popup_password_forgotten'), array('module' => 'account', 'action' => 'passwordForgotten'))?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

    function verifWidgetText(widget) {
        var valueInWidget = $("#"+widget).val();
        if ( valueInWidget == '' ) {
            $("#"+widget).focus();
            $("#"+widget).removeClass("formInputVarcharSelected");
            $("#"+widget).addClass("formInputVarcharError");
            return(false);
        }
        return(true);
    }

    function hideMessageErrorFromWidget(widget) {
        $("#"+widget).removeClass("formInputVarcharError");
        $("#"+widget).addClass("formInputVarcharSelected");
    }

    $(".input-text").keyup(function(key) {
        hideMessageErrorFromWidget(this.id);
    });

    $(".input-text").focus(function(key) {
        $(this).addClass("formInputVarcharSelected");
    });

    $(".input-text").blur(function(key) {
        $(".input-text").removeClass("formInputVarcharSelected");
    });

    $("#buttonSubmitPopup").click(function(){

        var formValide = true;

        if ( !verifWidgetText('connexion_email') ) {
            return(false);
        }

        if ( !verifWidgetText('connexion_password') ) {
            return(false);
        }

        document.formPopupConnection.submit();
    });
    
$(function() {
	$("#connexion_birthdate_day").selectmenu({
		style:'dropdown', 
		width: 80,
		menuWidth: 80
	});
	$("#connexion_birthdate_month").selectmenu({
		style:'dropdown', 
		width: 80,
		menuWidth: 80
	});
	$("#connexion_birthdate_year").selectmenu({
		style:'dropdown', 
		width: 80,
		menuWidth: 80
	});

	if($('#connexion_email').val() != '') {
		birthDate();
	}
	$('#connexion_email').keyup(function() {birthDate();});
	$('#connexion_email').mouseleave(function() {birthDate();});
});

function birthDate() {
	
	var email = $('#connexion_email').val();
	var cookieName = "<?php echo $birthdateCookiePrefix;?>"+email.replace(/[@\.]/g, '_');
	if($.cookie(cookieName) != null && $.cookie(cookieName) != '' && $.cookie(cookieName)  != 'undefined') {

		$('#connexion_email').SofunBirthDate({
			birthDate: $.cookie(cookieName), 
			email: email, 
			callback: 'setBirthDate'
		});
	}
}
</script>
<p style="height: 100px;"></p>
<div align="center" class="account">

    <?php if($sf_user->getAttribute('is_draft', '0', 'predictionsSave') ||
            $sf_user->getAttribute('grid_is_draft', '0', 'predictionsSave') ||
            $sf_user->getAttribute('ranking_is_draft', '0', 'predictionsSave') ||
            $sf_user->getAttribute('best_lap_is_draft', '0', 'predictionsSave')) : ?>
    <div style="margin: 0 auto; border: 1px solid #f2b45e; margin-top: 30px; text-align: center; width: 700px; font: bold 16px Arial, sans-serif; color: #E65E1B; padding: 10px; background: rgba(255, 195, 112, 0.6);">
        <?php echo __('text_account_login_page_draft_infos') ?>
    </div>
    <?php endif; ?>
    <?php echo image_tag('/images/account/login/padlock.png', array('size' => '56x85' ,'style' => 'border: none; margin-left: 8px; margin-top: -20px;'))?>
    <div style="width: 806px; height: 479px; background: url('/images/account/login/background.png');" class="login">
        <p style="height: 16px;"></p>
        <div class="header" style="width: 788px; height: 64px; border: 0px solid red;">
            <div class="link">
                <a href="<?php echo url_for("@homepage") ?>" style="font-family: Arial, sans-serif; font-size: 11px; font-weight: normal; font-style: normal; color: #FFFFFF;">Retour accueil</a>
            </div>
        </div>
        <p style="height: 10px;"></p>
        <table border="0" width="770" height="350" cellpadding="0" cellspacing="0">
            <tr>
                <td width="385" align="center" valign="top">
                    <div class="right" style="width: 320px; text-align: center;">
                        <h1>
                        	<?php echo __('text_login_facebook_connect'); ?> 
                        </h1>
                        <p><?php echo __('text_login_facebook_first_visit', array('%s%' => '<br />'));?></p>
                        <a href="<?php echo url_for(array('module' => 'account', 'action' => 'loginFacebook')) ?>" style="">
                            <?php echo image_tag('facebook/connect.png', array('alt' => '', 'border' => '0', 'size' => '107x25')); ?>
                        </a>
                    </div>
                    <div class="right" style="width: 385px; text-align: left;margin-top:-10px;">
                    	<div style="padding-top: 80px; margin-left: auto; margin-right:auto; width: 366px; height: 194px; background: url(/images/account/login/background_login_register.png) center no-repeat">
                    		<div style="margin-left: 40px;">
	                    		<h2><?php echo __('text_login_no_account') ?></h2>
	                    		<p style="margin:0; padding:0;"><?php echo __('text_login_folow_comunity')?></p>
	                    		<div style="clear: both; margin-left:40px; margin-top:5px;">
		                    		<div style="float:left; text-align: center; margin-top:15px;">
		                    			<?php echo image_tag('/images/account/login/arrow.png', array('size' => '63x37'))?>
		                    		</div>
		                    		<div style="float:left; text-align: right; margin-left: 40px;">
		                    			<span class="orange" style="margin-right: 15px;"><?php echo ucfirst(strtolower(__('label_header_free')))?></span><br />
		                    			<a href="<?php echo $registerUrl; ?>">
		                    				<?php echo image_tag('/images/account/login/button_register.png', array('size' => '142x57'))?>
		                    			</a>
		                    		</div>
	                    		</div>
                    		</div>
                    	</div>
                    </div>
                </td>
                <td width="385" align="center" valign="top">

                    <div class="right" style="width: 260px; text-align: center;">

                        <h1>
                        	<?php echo __('text_login_betkup_connect')?>
                        </h1>
                        <p><?php echo __('text_login_description_connect')?></p>

                        <form name="formLogin" id="formLogin" method="post" action="">

                            <div style="text-align: left;">

                                <span class="legende" style="font-style: normal;"><?php echo strtoupper($form['email']->renderLabel()) ?></span><br/>
                                <label><?php echo $form['email']->render() ?></label><br/>
                                <?php echo $form['email']->renderError() ?>

                                <span class="legende" style="font-style: normal;"><?php echo strtoupper($form['password']->renderLabel()) ?></span><br/>
                                <label><?php echo $form['password']->render() ?></label><br/>
                                <?php echo $form['password']->renderError() ?>

                                <span class="legende" style="font-style: normal;"><?php echo $form['birthdate']->renderLabel() ?></span><br/>
                                <div style="height: 5px;"></div>
                                <label><?php echo $form['birthdate']->render() ?></label><br/>

                                <?php if (isset($formBirthdateError) && $formBirthdateError != ""): ?>
                                    <ul class="error_list">
                                        <li><?php echo __('login_form_birthdate_error'); ?></li>
                                    </ul><br/>
                                <?php endif ?>

                                <?php if (isset($messageError) && $messageError != ""): ?>
                                    <div align="center" style="margin-top: 5px; margin-bottom: 5px;">
                                        <ul class="error_list">
                                            <li><?php echo $messageError ?></li>
                                        </ul>
                                    </div>
                                <?php endif ?>
                                <?php echo $form->renderHiddenFields(); ?>
                            </div>
							<div style="margin-top: 20px">
								<a href="javascript:submitForm();">
									<?php echo image_tag('/images/interface/connexion.png', array('size' => '90x34'))?>
								</a>
							</div>
                            <div style="margin-top: 8px; margin-bottom: 5px;">
                                <a href="<?php echo url_for(array('module' => 'account', 'action' => 'passwordForgotten')) ?>"><?php echo __('label_header_popup_password_forgotten')?></a>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<p style="height: 200px;"></p>
<script type="text/javascript">

	function submitForm() {
		$('#formLogin').submit();
	}
	
    $(function() {
	    $(".input-text").focus(function(key) {
	        $(this).addClass("formInputVarcharSelected");
	    });
	
	    $(".input-text").blur(function(key) {
	        $(".input-text").removeClass("formInputVarcharSelected");
	    });
    
		$("#connexionLogin_birthdate_day").selectmenu({
			style:'dropdown', 
			width: 80,
			menuWidth: 80
		});
		$("#connexionLogin_birthdate_month").selectmenu({
			style:'dropdown', 
			width: 80,
			menuWidth: 80
		});
		$("#connexionLogin_birthdate_year").selectmenu({
			style:'dropdown', 
			width: 80,
			menuWidth: 80
		});

		if($('#connexionLogin_email').val() != '') {
			setBirthDate();
		}
		$('#connexionLogin_email').keyup(function() {setBirthDate();});
		$('#connexionLogin_email').mouseleave(function() {setBirthDate();});
    });

    function setBirthDate() {
    	var email = $('#connexionLogin_email').val();
    	var cookieName = "<?php echo $birthdateCookiePrefix;?>"+email.replace(/[@\.]/g, '_');
    	if($.cookie(cookieName) != null && $.cookie(cookieName) != '' && $.cookie(cookieName)  != 'undefined') {
    		$('#connexionLogin_email').SofunBirthDate({
        		email: email, 
        		birthDate: $.cookie(cookieName),
        		callback: 'setBirthDate',
       			day : $('#connexionLogin_birthdate_day'),
       			month : $('#connexionLogin_birthdate_month'),
       			year : $('#connexionLogin_birthdate_year'),
       			dayMenu: $('#connexionLogin_birthdate_day-menu'),
       			dayButton: $('#connexionLogin_birthdate_day-button'),
      			monthMenu: $('#connexionLogin_birthdate_month-menu'),
        		monthButton: $('#connexionLogin_birthdate_month-button'),
        		yearMenu: $('#connexionLogin_birthdate_year-menu'),
        		yearButton: $('#connexionLogin_birthdate_year-button')
            });
    	}
    }
</script>
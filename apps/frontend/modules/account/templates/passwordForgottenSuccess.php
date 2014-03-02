<p style="height: 100px;"></p>
<div align="center" class="account">
	<img src="/images/account/login/padlock.png" border="0" style="margin-left: 8px;">
	<div style="width: 806px; background: url('/images/account/forgotten/background.png'); background-repeat: no-repeat;" class="login">

		<p style="height: 16px;"></p>
		<div class="header"
			style="width: 788px; height: 64px; border: 0px solid red;">
			<div class="link">
				<a href="<?php echo url_for("@homepage") ?>"
					style="font-family: Arial, sans-serif; font-size: 11px; font-weight: normal; font-style: normal; color: #FFFFFF; margin-left: 5px;">Retour
					accueil</a>
			</div>
		</div>
		<p style="height: 35px; background-color: white; width: 785px; margin: 0px;"></p>
		<table border="0" width="785px;" height="350" cellpadding="0" cellspacing="0" style="background-color: white;">
			<tr>
				<td width="385" align="center" valign="top">
					<div class="right" style="width: 240px;">

						<p style="text-align: left;"><?php echo __('text_password_forgotten') ?></p>

						<form name="formLogin" id="formLogin" method="post"
							action="<?php echo url_for(array('module' => 'account', 'action' => 'passwordForgotten')) ?>"
							>
							<div style="text-align: left;">
								<spanclass="legende" style="font-style: normal;"><?php echo strtoupper($form['email']->renderLabel()) ?></span>
                                <br />
                                <label><?php echo $form['email']->render() ?> </label><br />
								<?php echo $form['email']->renderError() ?>
								<?php if (isset($messageError) && $messageError != ""): ?>
                                        <div align="center" style="margin-top: 5px; margin-bottom: 5px;">
                                            <ul class="error_list">
                                                <li><?php echo $messageError ?></li>
                                            </ul>
                                        </div>
                                <?php endif ?>
                                <?php echo $form->renderHiddenFields(); ?>
                            </div>
                            <?php include_component('interface', 'captchaPassword',         array('bloc' => 'gold', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '400', 'messageError' => __('captcha_message_error'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountHumain', 'blocLegende' => __('legende_bloc_captcha'), 'blocValue' => '', 'blocHelp' => '')) ?>
							<input type="image"
								src="/images/interface/boutonSend_<?php echo $sf_user->getCulture() ?>.png"
								border="0">
						</form>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<p class="bottom-background-white" style="height: 35px;  width: 785px;"></p>
</div>
<p style="height: 200px;"></p>
<script type="text/javascript">
$(function() {
    $(".input-text").focus(function(key) {
        $(this).addClass("formInputVarcharSelected");
    });

    $(".input-text").blur(function(key) {
        $(".input-text").removeClass("formInputVarcharSelected");
    });
});
</script>

<div class="layoutIntAllBlanc">
    <div class="interface">
        <?php echo image_tag('moncompte/top.png', array('alt' => '', 'border' => '0', 'size' => '990x4')); ?>
        <p style="height: 40px;"></p>
        <?php include_component('interface', 'header', array('image' => '/images/account/create/titleAdvanced_'.strtolower($sf_user->getCulture()).'.png', 'title' => __('text_cancel'), 'link' => url_for("@homepage") )) ?>
        <p style="height: 25px;"></p>
        <div class="gauche">
            <?php include_component('account', 'left', array('form' => 'advanced')) ?>
        </div>
        <div class="droite" style="margin-top: 0px;">
			<table style="border-collapse: collapse; border-spacing: 0px;">
        		<tr>
        			<td style="vertical-align: top; padding-top: 10px;">
        				<?php echo image_tag('/image/default/me/alert.png', array('class' => 'alert', 'size' => '12x12', 'alt' => __('label_me_alert'))); ?>
					</td>
        			<td style="vertical-align: top;">
        				<div style="font-family: Arial; color: #444444; padding: 0px; padding-left: 15px; padding-right: 10px; font-size: 12px;"><?php echo __('text_account_registerAdvanced_warnig_top_regular'); ?> <b><?php echo __('text_account_registerAdvanced_warnig_top_bold'); ?></b> <?php echo link_to(__('text_account_registerAdvanced_more_link'), '@homepage', array('class' => 'registerGreenLink')); ?>.</div>
        				<div style="font-family: Arial; color: #444444; padding: 0px; margin-top: 10px; padding-left: 15px; padding-right: 10px; font-size: 12px;"><?php echo __('text_account_registerAdvanced_warnig_bottom_regular'); ?></div>
        			</td>
        		</tr>
        	</table>
        	<br /><br />
            <?php echo image_tag('account/create/complex/header.png', array('alt' => '', 'border' => '0', 'size' => '666x38', 'style' => 'margin-bottom: 40px;')); ?>

                <form name="formCreationCompteSimple" method="post" action="">

                <input type="hidden" name="information[isUpgrade]" value="<?php echo $isUpgrade ?>">

				<a href="javascript:void(0);" id="anchor"></a>
                <?php include_component('interface', 'radio',           array('bloc' => 'information', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountCivilite_messageError_text'),       'blocName' => 'accountCivilite', 'blocLegende' => '', 'blocValue' => $information_accountCivilite, 'blocChoices' => array('M', 'Mme', 'Mlle'))) ?>
                <?php include_component('interface', 'simpleWidget',    array('bloc' => 'information', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountLastname_messageError_text'),            'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountLastname', 'blocLegende' => __('account_registerAdvanced_accountLastname_legende_text').' *', 'blocValue' => $information_accountLastname, 'blocHelp' => __('account_registerAdvanced_accountLastname_help_text'))) ?>
                <?php include_component('interface', 'simpleWidget',    array('bloc' => 'information', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountFirstname_messageError_text'),         'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountFirstname', 'blocLegende' => __('account_registerAdvanced_accountFirstname_legende_text').' *', 'blocValue' => $information_accountFirstname, 'blocHelp' => __('account_registerAdvanced_accountFirstname_help_text'))) ?>
                <?php include_component('interface', 'simpleWidget',    array('bloc' => 'information', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountAdresse_messageError_text'),           'blocIcone' => '', 'blocName' => 'accountAdresse', 'blocLegende' => __('account_registerAdvanced_accountAdresse_legende_text').' *', 'blocValue' => $information_accountAdresse, 'blocHelp' => __('account_registerAdvanced_accountAdresse_help_text'))) ?>
                <?php include_component('interface', 'countries', 	    array('bloc' => 'information', 'width1' => '160', 'width2' => '245', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountCountry_messageError_text'),           'blocName' => 'accountCountry', 'blocLegende' => __('account_registerAdvanced_accountCountry_legende_text').' *', 'blocValue' => $information_accountCountry, 'blocValueDefault' => 'FR', 'blocChoices' => $countries, 'blocFirstRow' => '', 'widthGadget' => '224', 'blocHelp' => __('account_registerAdvanced_accountCountry_help_text'))) ?>
				<?php include_component('interface', 'simpleWidget',    array('bloc' => 'information', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountCity_messageError_text'),          'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountCity', 'blocLegende' => __('account_registerAdvanced_accountCity_legende_text').' *', 'blocValue' => $information_accountCity, 'blocHelp' => __('account_registerAdvanced_accountCity_help_text'))) ?>
                <div id="showHideCodeZip" style="display: none;">
                	<?php include_component('interface', 'simpleWidget',array('bloc' => 'information', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountCodezip_messageError_text'),          'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountCodezip', 'blocLegende' => __('account_registerAdvanced_accountCodezip_legende_text').' *', 'blocValue' => $information_accountCodezip, 'blocHelp' => __('account_registerAdvanced_accountCodezip_help_text'))) ?>
                </div>

                <?php echo image_tag('account/create/complex/separation1.png', array('alt' => '', 'border' => '0', 'size' => '666x33', 'style' => 'margin-top: 14,5px; margin-bottom: 15px;')); ?>
                <?php include_component('interface', 'date',            array('bloc' => 'personal', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => '', 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountBirthdate', 'blocLegende' => __('account_registerAdvanced_accountBirthdate_legende_text').' *', 'blocChoices1' => $blocChoices1, 'blocChoices2' => $blocChoices2, 'blocChoices3' => $blocChoices3, 'blocValue1' => $personal_accountBirthdate_1, 'blocValue2' => $personal_accountBirthdate_2, 'blocValue3' => $personal_accountBirthdate_3, 'blocHelp' => __('account_registerAdvanced_accountBirthdate_help_text'))) ?>
                <?php include_component('interface', 'countries',       array('bloc' => 'personal', 'width1' => '160', 'width2' => '245', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountBirthcountry_messageError_text'), 'blocName' => 'accountBirthcountry', 'blocLegende' => __('account_registerAdvanced_accountBirthcountry_legende_text').' *', 'blocValue' => $personal_accountBirthcountry, 'blocValueDefault' => 'FR', 'blocChoices' => $allCountries, 'blocFirstRow' => '', 'widthGadget' => '224', 'blocHelp' => __('account_registerAdvanced_accountBirthcountry_help_text'))) ?>
                <?php include_component('interface', 'simpleWidget',    array('bloc' => 'personal', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountBirthplace_messageError_text'), 'blocIcone' => '', 'blocName' => 'accountBirthplace', 'blocLegende' => __('account_registerAdvanced_accountBirthplace_legende_text').' *', 'blocValue' => $personal_accountBirthplace,'blocHelp' => __('account_registerAdvanced_accountBirthplace_help_text'))) ?>
				<input type="hidden" name="personal[accountBirthregion]" id="accountBirthregion" value="<?php echo $personal_accountBirthregion; ?>" />

                <?php if ( !$isUpgrade ): ?>
	                <?php echo image_tag('account/create/complex/separation2.png', array('alt' => '', 'border' => '0', 'size' => '666x33', 'style' => 'margin-top: 14,5px; margin-bottom: 15px;')); ?>
	                <?php include_component('interface', 'blockPseudo',    array('bloc' => 'information',  'width1' => '160', 'width2' => '204', 'width3' => '', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountPseudo_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountPseudo', 'blocLegende' => __('account_registerAdvanced_accountPseudo_legende_text').' *', 'blocValue' => $login_accountPseudo, 'blocHelp' => __('account_registerAdvanced_accountPseudo_help_text'))) ?>
	               	<?php include_component('interface', 'simpleWidget', array('bloc' => 'login', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountEmail_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountEmail', 'blocLegende' => __('account_registerAdvanced_accountEmail_legende_text').' *', 'blocValue' => $login_accountEmail, 'blocHelp' => __('account_registerAdvanced_accountEmail_help_text'))) ?>
	                <?php include_component('interface', 'simpleWidget', array('bloc' => 'login', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountPassword_messageError_text'), 'blocType' => 'password', 'blocIcone' => '', 'blocName' => 'accountPassword', 'blocLegende' => __('account_registerAdvanced_accountPassword_legende_text').' *', 'blocValue' => $login_accountPassword, 'blocHelp' => __('account_registerAdvanced_accountPassword_help_text'))) ?>
	                <?php include_component('interface', 'simpleWidget', array('bloc' => 'login', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountConfirmation_messageError_text'), 'blocType' => 'password', 'blocIcone' => '', 'blocName' => 'accountConfirmation', 'blocLegende' => __('account_registerAdvanced_accountConfirmation_legende_text').' *', 'blocValue' => $login_accountConfirmation, 'blocHelp' => __('account_registerAdvanced_accountConfirmation_help_text'))) ?>
                <?php else :?>
	                <input type="hidden" name="information[accountPseudo]" id="accountPseudo" value="<?php echo $login_accountPseudo; ?>" />
					<input type="hidden" name="login[accountEmail]" id="accountEmail" value="<?php echo $login_accountEmail; ?>" />

					<?php if($login_accountPassword == '') :?>
						<?php echo image_tag('account/create/complex/separation2.png', array('alt' => '', 'border' => '0', 'size' => '666x33', 'style' => 'margin-top: 14,5px; margin-bottom: 15px;')); ?>
		                <?php include_component('interface', 'simpleWidget', array('bloc' => 'login', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountPassword_messageError_text'), 'blocType' => 'password', 'blocIcone' => '', 'blocName' => 'accountPassword', 'blocLegende' => __('account_registerAdvanced_accountPassword_legende_text').' *', 'blocValue' => '', 'blocHelp' => __('account_registerAdvanced_accountPassword_help_text'))) ?>
	                	<?php include_component('interface', 'simpleWidget', array('bloc' => 'login', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountConfirmation_messageError_text'), 'blocType' => 'password', 'blocIcone' => '', 'blocName' => 'accountConfirmation', 'blocLegende' => __('account_registerAdvanced_accountConfirmation_legende_text').' *', 'blocValue' => '', 'blocHelp' => __('account_registerAdvanced_accountConfirmation_help_text'))) ?>
                	<?php else : ?>
						<input type="hidden" name="login[accountPassword]" id="accountPassword" value="<?php echo $login_accountPassword; ?>" />
						<input type="hidden" name="login[accountConfirmation]" id="accountConfirmation" value="<?php echo $login_accountConfirmation; ?>" />
					<?php endif; ?>
                <?php endif ?>

                <?php echo image_tag('account/create/complex/separation3.png', array('alt' => '', 'border' => '0', 'size' => '666x33', 'style' => 'margin-top: 14,5px; margin-bottom: 15px;')); ?>
                
                <div style="height: 15px;"></div>
                <div style="width:580px; margin-left:auto; margin-right: auto;">
	                <table style="border-collapse: collapse; border-spacing: 0px;">
		        		<tr>
		        			<td style="vertical-align: middle;">
		        				<?php echo image_tag('/image/default/me/alert.png', array('class' => 'alert', 'size' => '12x12', 'alt' => __('label_me_alert'))); ?>
							</td>
		        			<td style="vertical-align: middle;">
		        				<div style=" font-family: Arial; color: #444444; padding: 0px; padding-left: 15px; padding-right: 10px; font-size: 12px;">
		        					<?php echo __('text_register_bank_infos_msg', array('%br%' => '<br />'))?>
		        				</div>
		        			</td>
		        		</tr>
		        	</table>
	        	</div>
	        	<div style="height: 15px;"></div>
                <?php include_component('interface', 'radio',           array('bloc' => 'gold', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => '', 'blocName' => 'accountRib', 'blocLegende' => __('account_registerAdvanced_accountRib_legende_text'), 'blocValue' => 'RIB', 'blocChoices' => array('RIB', 'IBAN'))) ?>
				<div id="blockRIB">
				<?php include_component('interface', 'simpleWidget',    array('bloc' => 'gold', 'width1' => '160', 'width2' => '120', 'widthGadget' => '120', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountCodeBank_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountCodeBank', 'blocLegende' => __('account_registerAdvanced_accountCodeBank_legende_text').' *', 'blocValue' => $gold_accountRib_1, 'blocHelp' => __('account_registerAdvanced_accountCodeBank_help_text'))) ?>
				<?php include_component('interface', 'simpleWidget',    array('bloc' => 'gold', 'width1' => '160', 'width2' => '120', 'widthGadget' => '120', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountCodeGuichet_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountCodeGuichet', 'blocLegende' => __('account_registerAdvanced_accountCodeGuichet_legende_text').' *', 'blocValue' => $gold_accountRib_2, 'blocHelp' => __('account_registerAdvanced_accountCodeGuichet_help_text'))) ?>
				<?php include_component('interface', 'simpleWidget',    array('bloc' => 'gold', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountNumAccount_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountNumAccount', 'blocLegende' => __('account_registerAdvanced_accountNumAccount_legende_text').' *', 'blocValue' => $gold_accountRib_3, 'blocHelp' => __('account_registerAdvanced_accountNumAccount_help_text'))) ?>
				<?php include_component('interface', 'simpleWidget',    array('bloc' => 'gold', 'width1' => '160', 'width2' => '120', 'widthGadget' => '120', 'marginLeftError' => '4010', 'messageError' => __('account_registerAdvanced_accountKeyRIB_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountKeyRIB', 'blocLegende' => __('account_registerAdvanced_accountKeyRIB_legende_text').' *', 'blocValue' => $gold_accountRib_4, 'blocHelp' => __('account_registerAdvanced_accountKeyRIB_help_text'))) ?>
				</div>
				<div id="blockIBAN" style="display: none;">
				<?php include_component('interface', 'simpleWidget',    array('bloc' => 'gold', 'width1' => '160', 'width2' => '120', 'widthGadget' => '120', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountSwift_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountSwift', 'blocLegende' => __('account_registerAdvanced_accountSwift_legende_text').' *', 'blocValue' => isset($gold_accountIban_1) ? $gold_accountIban_1 : "", 'blocHelp' => __('account_registerAdvanced_accountSwift_help_text'))) ?>
				<?php include_component('interface', 'simpleWidget',    array('bloc' => 'gold', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountIban_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountIban', 'blocLegende' => __('account_registerAdvanced_accountIban_legende_text').' *', 'blocValue' => isset($gold_accountIban_2) ? $gold_accountIban_2 : "", 'blocHelp' => __('account_registerAdvanced_accountIban_help_text'))) ?>
				</div>
				<?php include_component('interface', 'select',          array('bloc' => 'gold', 'width1' => '190', 'width2' => '245', 'width3'=>'200', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountDepotLimit_messageError_text'), 'blocName' => 'accountDepotLimit', 'blocLegende' => __('account_registerAdvanced_accountDepotLimit_legende_text').' *', 'blocValue' => '', 'blocChoices' => $ribLimit, 'blocFirstValue' => '0', 'blocFirstRow' => __('account_registerAdvanced_accountDepotLimit_firstRow_text'), 'widthGadget' => '224', 'blocHelp' => __('account_registerAdvanced_accountDepotLimit_help_text'))) ?>
				<div id="blockLimitDepotPerso" style="display: none;">
				<?php include_component('interface', 'simpleWidget',    array('bloc' => 'gold', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountLimiteDepotPerso_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountLimiteDepotPerso', 'blocLegende' => __('account_registerAdvanced_accountLimiteDepotPerso_legende_text').' *', 'blocValue' => '', 'blocHelp' => __('account_registerAdvanced_accountLimiteDepotPerso_help_text'))) ?>
				</div>
				<?php include_component('interface', 'select',          array('bloc' => 'gold', 'width1' => '190', 'width2' => '245', 'width3'=>'200', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountMiseLimit_messageError_text'), 'blocName' => 'accountMiseLimit', 'blocLegende' => __('account_registerAdvanced_accountMiseLimit_legende_text').' *', 'blocValue' => '', 'blocChoices' => $ribLimit, 'blocFirstValue' => '0', 'blocFirstRow' => __('account_registerAdvanced_accountMiseLimit_firstRow_text'), 'widthGadget' => '224', 'blocHelp' => __('account_registerAdvanced_accountMiseLimit_help_text'))) ?>
				<div id="blockLimitMisePerso" style="display: none;">
				<?php include_component('interface', 'simpleWidget',    array('bloc' => 'gold', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountLimiteMisePerso_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountLimiteMisePerso', 'blocLegende' => __('account_registerAdvanced_accountLimiteMisePerso_legende_text').' *', 'blocValue' => '', 'blocHelp' => __('account_registerAdvanced_accountLimiteMisePerso_help_text'))) ?>
				</div>

			    <?php include_component('interface', 'captcha',         array('bloc' => 'gold', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '410', 'messageError' => __('account_registerAdvanced_accountHumain_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountHumain', 'blocLegende' => __('account_registerAdvanced_accountHumain_legende_text').' *', 'blocValue' => '', 'blocHelp' => '')) ?>

                <?php echo image_tag('account/create/complex/separation4.png', array('alt' => '', 'border' => '0', 'size' => '666x33', 'style' => 'margin-top: 14,5px; margin-bottom: 15px;')); ?>

                <?php $cguLink = '<a class="link-register" href="'.$cguUrl.'" target="new">'.__('accountAcceptConditions_link_text').'</a>';?>
                <?php $rulesLink = '<a class="link-register" href="'.$rulesUrl.'" target="new">'.__('accountAcceptRules_link_text').'</a>';?>
                <?php $cguRulesText = __('account_registerAdvanced_accountAcceptConditions_legende_text_1').'<br />'; ?>
                <?php $cguRulesText .= '<ul style="margin-left: 15px;"><li>'.__('account_registerAdvanced_accountAcceptConditions_legende_text_2').' '.$cguLink.' '.__('account_registerAdvanced_accountAcceptConditions_legende_text_3').' '.$rulesLink.' '.__('account_registerAdvanced_accountAcceptConditions_legende_text_4').'</li>'; ?>
                <?php $cguRulesText .= '<li style="margin-top:5px;">'.__('account_registerAdvanced_accountAcceptConditions_legende_text_5').'</li></ul>'; ?>

                <?php include_component('interface', 'accept', array('bloc' => 'accept', 'marginLeftError' => '-234', 'blocName' => 'accountAcceptConditions', 'messageError' => __('account_registerAdvanced_accountAcceptConditions_messageError_text'), 'blocLegende' => $cguRulesText, 'blocValue' => '1', 'blocChecked' => '')) ?>
                <?php include_component('interface', 'accept', array('bloc' => 'accept', 'marginLeftError' => '440', 'blocName' => 'accountAcceptOffres', 'messageError' => '', 'blocLegende' => __('account_registerAdvanced_accountAcceptOffres_legende_text'), 'blocValue' => '1', 'blocChecked' => '')) ?>

                <a href="javascript:void(0);">
                    <?php echo image_tag('interface/boutonInscrire_'.$sf_user->getCulture().'.png', array('id' => 'buttonSubmit', 'alt' => '', 'border' => '0', 'size' => '154x45', 'style' => 'margin-top: 30px; margin-left: 210px; margin-bottom: 80px; ')); ?>
                </a>
            </form>
        </div>
        <div style="clear:both;"></div>
    </div>
</div>
<script type="text/javascript">
    $(".rib").focus(function(key) {

        $(".iban").val('');

        $(".rib").css({
            "border-top": "1px solid #F5C95B",
            "border-left": "1px solid #F5C95B",
            "border-right": "1px solid #F4DA96",
            "border-bottom": "1px solid #F4DA96"
        });

        $(".iban").css({
            "border-top": "1px solid #D7D7D7",
            "border-left": "1px solid #D7D7D7",
            "border-right": "1px solid #EBEBEB",
            "border-bottom": "1px solid #EBEBEB"
        });

        $('.iban').fadeTo('slow', 0.4, function() {});
        $('.ibanLegende').fadeTo('slow', 0.4, function() {});
        $('.rib').fadeTo('slow', 1, function() {});
        $('.ribLegende').fadeTo('slow', 1, function() {});
    });

    <?php if($information_accountCountry != 'FR') :?>
    	$('#showHideCodeZip').show();
    <?php endif;?>

    $(".iban").focus(function(key) {

        $(".rib").val('');

        $(".iban").css({
            "border-top": "1px solid #F5C95B",
            "border-left": "1px solid #F5C95B",
            "border-right": "1px solid #F4DA96",
            "border-bottom": "1px solid #F4DA96"
        });

        $(".rib").css({
            "border-top": "1px solid #D7D7D7",
            "border-left": "1px solid #D7D7D7",
            "border-right": "1px solid #EBEBEB",
            "border-bottom": "1px solid #EBEBEB"
        });

        $('.rib').fadeTo('slow', 0.4, function() {});
        $('.ribLegende').fadeTo('slow', 0.4, function() {});
        $('.iban').fadeTo('slow', 1, function() {});
        $('.ibanLegende').fadeTo('slow', 1, function() {});
    });

    $('#accountAdresse_bulle').css('height','40px');

    if (<?php echo $gold_depotPerso; ?> == '1') {
    	$("#accountDepotLimit").val('1');
    	$("#blockLimitDepotPerso").slideDown("fast");
    	$("#accountLimiteDepotPerso").val(<?php echo $gold_accountLimiteDeDepot; ?>);
	}else if (<?php echo $gold_depotPerso; ?> == '0') {
		$("#accountDepotLimit").val(<?php echo $gold_accountLimiteDeDepot; ?>);
	}

    if (<?php echo $gold_misePerso; ?> == '1') {
    	$("#accountMiseLimit").val('1');
    	$("#blockLimitMisePerso").slideDown("fast");
    	$("#accountLimiteMisePerso").val(<?php echo $gold_accountLimiteDeMise; ?>);
	}else if (<?php echo $gold_misePerso; ?> == '0') {
		$("#accountMiseLimit").val(<?php echo $gold_accountLimiteDeMise; ?>);
	}

	if ('<?php echo $choiceRIB_IBAN; ?>' == 'RIB') {
		$("#accountRib_0").attr('checked', true);
		jQuery.ajaxSetup({async:false});
    	$('#blockIBAN').slideUp("fast");
    	$('#blockRIB').slideDown("fast");
	}else if ('<?php echo $choiceRIB_IBAN; ?>' == 'IBAN') {
		$("#accountRib_1").attr('checked', true);
		jQuery.ajaxSetup({async:false});
    	$('#blockRIB').slideUp("fast");
    	$('#blockIBAN').slideDown("fast");
	}

    $("#accountDepotLimit").change(function() {
        $("#accountDepotLimit option:selected").each(function () {
        if (this.value == '1') {
        	$("#blockLimitDepotPerso").slideDown("fast");
		}else if (this.value != '1') {
			$("#blockLimitDepotPerso").slideUp("fast");
		}
        });
	});

    $("#accountMiseLimit").change(function() {
        $("#accountMiseLimit option:selected").each(function () {
        if (this.value == '1') {
        	$("#blockLimitMisePerso").slideDown("fast");
		}else if (this.value != '1') {
			$("#blockLimitMisePerso").slideUp("fast");
		}
        });
	});

    $("#accountCountry").change(function() {
        if($(this).val() != 'FR') {
            $("#showHideCodeZip").show();
            $('#content-search-accountCity-results').empty().hide();
        } else {
        	$("#showHideCodeZip").hide();
        }
    });

    if($('#accountBirthcountry').val() != 'FR') {
		$('#accountBirthregion').val('99');
	}

    $('#accountBirthcountry').change(function() {
    	if($(this).val() != 'FR') {
        	$('#accountBirthregion').val('99');
        	$('#content-search-accountBirthplace-results').empty().hide();
        }
    });

    $("#accountLastname").keyup(function(event) {
        if (this.value != '' && isValidString64($("#accountLastname").val())){
        	$("#accountLastname").removeClass("formInputVarcharErrorOnlyTicker");
        	$("#accountLastname").addClass("formInputVarcharSuccessOnlyTicker");
        }else{
            $("#accountLastname").removeClass("formInputVarcharSuccessOnlyTicker");
            $("#accountLastname").addClass("formInputVarcharErrorOnlyTicker");
        }
    });
    
    $('#accountLastname').click(function() {
  	  $('#accountLastname').keyup();
  	});

    $("#accountFirstname").keyup(function(event) {
        if (this.value != '' && isValidString64($("#accountFirstname").val())){
        	$("#accountFirstname").removeClass("formInputVarcharErrorOnlyTicker");
        	$("#accountFirstname").addClass("formInputVarcharSuccessOnlyTicker");
        }else{
            $("#accountFirstname").removeClass("formInputVarcharSuccessOnlyTicker");
            $("#accountFirstname").addClass("formInputVarcharErrorOnlyTicker");
        }
    });
    
  $('#accountFirstname').click(function() {
	  $('#accountFirstname').keyup();
  });

  $("#accountAdresse").keyup(function(event) {
      if (this.value != '' && isValidString64($("#accountAdresse").val())){
      	$("#accountAdresse").removeClass("formInputVarcharErrorOnlyTicker");
      	$("#accountAdresse").addClass("formInputVarcharSuccessOnlyTicker");
      }else{
          $("#accountAdresse").removeClass("formInputVarcharSuccessOnlyTicker");
          $("#accountAdresse").addClass("formInputVarcharErrorOnlyTicker");
      }
  });
  
  $('#accountAdresse').click(function() {
	  $('#accountAdresse').keyup();
  });

  $("#accountEmail").keyup(function(event) {

      if(isValidEmail($('#accountEmail').val())) {
      	$("#accountEmail").removeClass("formInputVarcharErrorOnlyTicker");
      	$("#accountEmail").addClass("formInputVarcharSuccessOnlyTicker");
      }
      else {
      	$("#accountEmail").removeClass("formInputVarcharSuccessOnlyTicker");
        $("#accountEmail").addClass("formInputVarcharErrorOnlyTicker");
      }
	});

	$("#accountPassword").keyup(function(event) {

		if(isValidPassword($('#accountPassword').val())) {
			$("#accountPassword").removeClass("formInputVarcharErrorOnlyTicker");
			$("#accountPassword").addClass("formInputVarcharSuccessOnlyTicker");
		} else {
	      	$("#accountPassword").removeClass("formInputVarcharSuccessOnlyTicker");
	      	$("#accountPassword").addClass("formInputVarcharErrorOnlyTicker");
		}
	});

	$("#accountConfirmation").keyup(function(event) {
	    if(isValidPassword($('#accountConfirmation').val()) ) {
	  		$("#accountConfirmation").removeClass("formInputVarcharErrorOnlyTicker");
			$("#accountConfirmation").addClass("formInputVarcharSuccessOnlyTicker");
	    }
	   	if ( $("#accountPassword").val() != '' && $("#accountConfirmation").val() != '' && ( $("#accountPassword").val() != $("#accountConfirmation").val() ) ) {
	        $("#accountConfirmation").removeClass("formInputVarcharSuccessOnlyTicker");
	        $("#accountConfirmation").addClass("formInputVarcharErrorOnlyTicker");
	  	}
	});

	  $('#accountLimiteDepotPerso').click(function() {
		  $('#accountLimiteDepotPerso').keyup();
	  });

	  $("#accountLimiteDepotPerso").keyup(function(event) {
	      if( isValidDeposit($('#accountLimiteDepotPerso').val()) && this.value !='' && this.value > <?php echo sfConfig::get('mod_account_limit_min_weekly_credit'); ?>  && this.value <= <?php echo sfConfig::get('mod_account_limit_weekly_credit'); ?>){
	      	$("#accountLimiteDepotPerso").removeClass("formInputVarcharErrorOnlyTicker");
	      	$("#accountLimiteDepotPerso").addClass("formInputVarcharSuccessOnlyTicker");
	      }else{
	          $("#accountLimiteDepotPerso").removeClass("formInputVarcharSuccessOnlyTicker");
	          $("#accountLimiteDepotPerso").addClass("formInputVarcharErrorOnlyTicker");
	      }
	  });

	  $('#accountLimiteMisePerso').click(function() {
		  $('#accountLimiteMisePerso').keyup();
	  });

	  $("#accountLimiteMisePerso").keyup(function(event) {
	      if( isValidDeposit($('#accountLimiteMisePerso').val()) && this.value !='' && this.value > <?php echo sfConfig::get('mod_account_limit_min_weekly_bets'); ?> && this.value <= <?php echo sfConfig::get('mod_account_limit_weekly_bets'); ?>){
	      	$("#accountLimiteMisePerso").removeClass("formInputVarcharErrorOnlyTicker");
	      	$("#accountLimiteMisePerso").addClass("formInputVarcharSuccessOnlyTicker");
	      }else{
	          $("#accountLimiteMisePerso").removeClass("formInputVarcharSuccessOnlyTicker");
	          $("#accountLimiteMisePerso").addClass("formInputVarcharErrorOnlyTicker");
	      }
	  });

    function verifWidgetText(widget) {
        var valueInWidget = $("#"+widget).val();
        if ( valueInWidget == '' ) {

            $("#"+widget).addClass("formInputVarcharError");

            if ( widget == 'accountConfirmation' ){
                $("#accountConfirmation"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Le mot de passe est obligatoire.') ?></p>');
            }
            if ( widget == 'accountDepotLimit' ){
                $("#accountDepotLimit"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('La limite de dépôt est obligatoire.') ?></p>');
            }
            if ( widget == 'accountMiseLimit' ){
                $("#accountMiseLimit"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('La limite de mise est obligatoire.') ?></p>');
            }

            $("#"+widget+'_bulle').fadeIn('fast');
            $("#accountLastname").focus();
            return(false);
        } else {
        	$("#"+widget).removeClass("formInputVarcharError");
        }

		if(widget == 'accountBirthplace') {
			if(check != 'undefined' && check['accountBirthplace'] == false) {
				$("#accountBirthplace").removeClass("formInputVarcharError");
				$("#accountBirthplace_bulle").addClass("formInputVarcharError");
                $("#accountBirthplace_bulle").fadeIn('fast');
                $("#accountBirthplace").focus();
				return(false);
			}
		}

        return(true);
    }

    function hideMessageErrorFromWidget(widget, widgetName) {
    	$(".formInputVarchar").removeClass("formInputVarcharError");
        $('#'+widgetName+'_bulle').fadeOut('fast');
    }

    $(".formInputSelect").keyup(function(key) {
        hideMessageErrorFromWidget(this, this.id);
    });
    $(".formInputSelect").focus(function(key) {
        $(this).addClass("formInputSelectSelected");
    });
    $(".formInputSelect").blur(function(key) {
        $(this).removeClass("formInputSelectSelected");
    });

    $(".formInputVarchar").keyup(function(key) {
        hideMessageErrorFromWidget(this, this.id);
    });
    $(".formInputVarchar").focus(function(key) {
    	$(this).removeClass("formInputVarcharSuccessOnlyTicker");
        $(this).addClass("formInputVarcharSelected");
    });
    $(".formInputVarchar").blur(function(key) {
        $(".formInputVarchar").removeClass("formInputVarcharSelected");
    });

    $("#accountAcceptConditions").click(function(key) {
        $('#accountAcceptConditions_bulle').fadeOut('fast');
    });

	/**
	 * Validation of form
	 */
$(function() {
    $("#buttonSubmit").click(function(){

        var isFormValid= true;

        if(!checkAge('<?php echo sfConfig::get('mod_account_registration_advanced_age'); ?>', $('#accountBirthdate_3').val(), $('#accountBirthdate_2').val(), $('#accountBirthdate_1').val())) {

    		$("#accountBirthdate_bulle").html("<p style=\"margin-left: 25px; margin-top: 20px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;\"><?php echo __('text_account_register_too_young'); ?></p>");
    		$("#accountBirthdate_bulle").show();
    		isFormValid= false;
        } else { $("#accountBirthdate_bulle").hide(); }

		if($('#accountCountry').val() != 'FR') {
			if ( !verifWidgetText('accountCodezip') ) {
	        	isFormValid= false;
	        } else if(!isValidZipcode($('#accountCodezip').val(), 'accountCodezip')) {

	        	isFormValid= false;
	        	$("#accountCodezip").addClass("formInputVarcharError");
	        	$("#accountCodezip").addClass("formInputVarcharErrorOnlyTicker");
				$("#accountCodezip").removeClass("formInputVarcharSuccessOnlyTicker");
                $("#accountCodezip_bulle").html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">'+"<?php echo __('text_register_error_zipcode_not_match_constraint') ?>"+'</p>');
	        	$("#accountCodezip_bulle").fadeIn('fast');
	            $("#accountLastname").focus();
	        } else {
	        	$("#accountCodezip").removeClass("formInputVarcharErrorOnlyTicker");
				$("#accountCodezip").addClass("formInputVarcharSuccessOnlyTicker");
	        }
		}


        if ( !verifWidgetText('accountCity') ) {
        	isFormValid= false;
        }else if(!isValidString64($("#accountCity").val())) {
			isFormValid= false;
        	$("#accountCity").addClass("formInputVarcharError");
        	$("#accountCity").addClass("formInputVarcharErrorOnlyTicker");
			$("#accountCity").removeClass("formInputVarcharSuccessOnlyTicker");
            $("#accountCity_bulle").html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">'+"<?php echo __('text_register_error_city_not_match_constraint') ?>"+'</p>');
        	$("#accountCity_bulle").fadeIn('fast');
            $("#accountLastname").focus();
		} else {
			$("#accountCity").removeClass("formInputVarcharErrorOnlyTicker");
			$("#accountCity").addClass("formInputVarcharSuccessOnlyTicker");
		}

        if ( !verifWidgetText('accountBirthplace') ) {
        	isFormValid= false;
        } else if(!isValidString64($("#accountBirthplace").val())) {
			isFormValid= false;
        	$("#accountBirthplace").addClass("formInputVarcharError");
        	$("#accountBirthplace").addClass("formInputVarcharErrorOnlyTicker");
			$("#accountBirthplace").removeClass("formInputVarcharSuccessOnlyTicker");
            $("#accountBirthplace_bulle").html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">'+"<?php echo __('text_register_error_city_not_match_constraint') ?>"+'</p>');
        	$("#accountBirthplace_bulle").fadeIn('fast');
            $("#accountLastname").focus();
		} else {
			$("#accountBirthplace").removeClass("formInputVarcharErrorOnlyTicker");
			$("#accountBirthplace").addClass("formInputVarcharSuccessOnlyTicker");
		}

        if ( !verifWidgetText('accountLastname') ) {
        	isFormValid= false;
        }else if(!isValidString64($("#accountLastname").val())) {
			isFormValid= false;
        	$("#accountLastname").addClass("formInputVarcharError");
        	$("#accountLastname").addClass("formInputVarcharErrorOnlyTicker");
			$("#accountLastname").removeClass("formInputVarcharSuccessOnlyTicker");
            $("#accountLastname_bulle").html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">'+"<?php echo __('text_register_error_last_name_not_match_constraint') ?>"+'</p>');
        	$("#accountLastname_bulle").fadeIn('fast');
            $("#accountLastname").focus();
		} else {
			$("#accountLastname").removeClass("formInputVarcharErrorOnlyTicker");
			$("#accountLastname").addClass("formInputVarcharSuccessOnlyTicker");
		}

        if ( !verifWidgetText('accountFirstname') ) {
        	isFormValid= false;
        } else if(!isValidString64($("#accountFirstname").val())) {
			isFormValid= false;
        	$("#accountFirstname").addClass("formInputVarcharError");
        	$("#accountFirstname").addClass("formInputVarcharErrorOnlyTicker");
			$("#accountFirstname").removeClass("formInputVarcharSuccessOnlyTicker");
            $("#accountFirstname_bulle").html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">'+"<?php echo __('text_register_error_first_name_not_match_constraint') ?>"+'</p>');
        	$("#accountFirstname_bulle").fadeIn('fast');
            $("#accountLastname").focus();
		} else {
			$("#accountFirstname").removeClass("formInputVarcharErrorOnlyTicker");
			$("#accountFirstname").addClass("formInputVarcharSuccessOnlyTicker");
		}

        if ( !verifWidgetText('accountAdresse') ) {
        	isFormValid= false;
        } else if(!isValidString64($("#accountAdresse").val())) {
			isFormValid= false;
        	$("#accountAdresse").addClass("formInputVarcharError");
        	$("#accountAdresse").addClass("formInputVarcharErrorOnlyTicker");
			$("#accountAdresse").removeClass("formInputVarcharSuccessOnlyTicker");
            $("#accountAdresse_bulle").html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">'+"<?php echo __('text_register_error_address_not_match_constraint') ?>"+'</p>');
        	$("#accountAdresse_bulle").fadeIn('fast');
            $("#accountLastname").focus();
		} else {
			$("#accountAdresse").removeClass("formInputVarcharErrorOnlyTicker");
			$("#accountAdresse").addClass("formInputVarcharSuccessOnlyTicker");
		}
    	<?php if($isUpgrade) : ?>
			<?php if($login_accountPassword == '') :?>
				if ( !verifWidgetText('accountPassword') )
		        	isFormValid= false;

		        if ( !verifWidgetText('accountConfirmation') )
		        	isFormValid= false;
				if ( $("#accountPassword").val() != '' ) {
		            if( isValidPassword($('#accountPassword').val()) ) {
		            	hideMessageErrorFromWidget($('#accountPassword'), $('#accountPassword').attr('id'));
		            }
		            else {
		                $("#accountPassword").addClass("formInputVarcharError");
		                $("#accountPassword"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">Votre mot de passe doit contenir au moins 5 caractères alphanumériques</p>');
		                $("#accountPassword"+'_bulle').fadeIn('fast');
		                isFormValid= false;
		            }
		        }

		        if ( $("#accountPassword").val() != '' && $("#accountConfirmation").val() != '' && ( $("#accountPassword").val() != $("#accountConfirmation").val() ) ) {
		            $("#accountConfirmation").addClass("formInputVarcharError");
		            $("#accountConfirmation"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">Le mot de passe de vérification ne correspond pas au mot de passe saisi précédemment.</p>');
		            $("#accountConfirmation"+'_bulle').fadeIn('fast');
		            isFormValid= false;
		        } else {
		        	hideMessageErrorFromWidget($('#accountConfirmation'), 'accountConfirmation');
		        }
			<?php endif; ?>
        <?php else : ?>

        if ( !verifWidgetText('accountPseudo') )
        	isFormValid= false;

        if ( !verifWidgetText('accountEmail') )
        	isFormValid= false;

        if ( !verifWidgetText('accountDepotLimit') )
        	isFormValid= false;

        if ( !verifWidgetText('accountMiseLimit') )
        	isFormValid= false;

        if ( !verifWidgetText('accountPassword') )
        	isFormValid= false;

        if ( !verifWidgetText('accountConfirmation') )
        	isFormValid= false;

		if( !isValidNicknameSize($('#accountPseudo').val())) {
        	$("#accountPseudo").removeClass("formInputVarcharSuccessOnlyTicker");
			$("#accountPseudo").addClass("formInputVarcharErrorOnlyTicker");
            $("#accountPseudo"+'_bulle').html('<p style="margin-left: 25px; margin-top: 5px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">Votre pseudo doit contenir au moins 5 caractères alphanumériques</p>');
            $("#accountPseudo"+'_bulle').fadeIn('fast');
			isFormValid= false;
        }
        else if(!isValidNicknameFormat($('#accountPseudo').val())) {
        	$("#accountPseudo").removeClass("formInputVarcharSuccessOnlyTicker");
			$("#accountPseudo").addClass("formInputVarcharErrorOnlyTicker");
            $("#accountPseudo"+'_bulle').html('<p style="margin-left: 25px; margin-top: 5px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __("text_register_error_pseudo_not_match_constraint") ?></p>');
            $("#accountPseudo"+'_bulle').fadeIn('fast');
			isFormValid= false;
        }
        else if(eval(isNicknameExist($('#accountPseudo').val())) == true) {

			$("#accountPseudo").removeClass("formInputVarcharSuccessOnlyTicker");
			$("#accountPseudo").addClass("formInputVarcharErrorOnlyTicker");
            $("#accountPseudo"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('text_register_pseudo_already_exist'); ?></p>');
            $("#accountPseudo"+'_bulle').fadeIn('fast');
			isFormValid= false;
    	} else {
    		$("#accountPseudo").removeClass("formInputVarcharErrorOnlyTicker");
			$("#accountPseudo").addClass("formInputVarcharSuccessOnlyTicker");
            $("#accountPseudo"+'_bulle').html('');
            $("#accountPseudo"+'_bulle').fadeOut('fast');
            hideMessageErrorFromWidget($("#accountPseudo"), 'accountPseudo');
    	}

        if ( $("#accountPassword").val() != '' ) {
            if( !isValidPassword($('#accountPassword').val()) ) {
                $("#accountPassword").addClass("formInputVarcharError");
                $("#accountPassword"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">Votre mot de passe doit contenir au moins 5 caractères alphanumériques</p>');
                $("#accountPassword"+'_bulle').fadeIn('fast');
                isFormValid= false;
            } else {
            	hideMessageErrorFromWidget($('#accountPassword'), $('#accountPassword').attr('id'));
			}
        }

        if ( $("#accountPassword").val() != '' && $("#accountConfirmation").val() != '' && ( $("#accountPassword").val() != $("#accountConfirmation").val() ) ) {
            $("#accountConfirmation").addClass("formInputVarcharError");
            $("#accountConfirmation"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">Le mot de passe de vérification ne correspond pas au mot de passe saisi précédemment.</p>');
            $("#accountConfirmation"+'_bulle').fadeIn('fast');
            isFormValid= false;
        }

        if ( $("#accountEmail").val() != '' ) {
            if( !isValidEmail($('#accountEmail').val()) ) {

                $("#accountEmail").addClass("formInputVarcharError");
                $("#accountEmail"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">L\'email est incorrect.</p>');
                $("#accountEmail"+'_bulle').fadeIn('fast');
                isFormValid= false;
            }
        }
		<?php endif ?>

        if ( $("#accountDepotLimit").val() == '1' ) {
            if(!isValidDeposit($('#accountLimiteDepotPerso').val()) || $('#accountLimiteDepotPerso').val() == '' || $('#accountLimiteDepotPerso').val() > <?php echo sfConfig::get('mod_account_limit_weekly_credit'); ?> || $('#accountLimiteDepotPerso').val() < <?php echo sfConfig::get('mod_account_limit_min_weekly_credit'); ?>){
    	   		$("#accountLimiteDepotPerso").addClass("formInputVarcharError");
                $("#accountLimiteDepotPerso"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">Votre limite de dépôt est incorrecte</p>');
                $("#accountLimiteDepotPerso"+'_bulle').fadeIn('fast');
                isFormValid= false;
            }
        } else if($("#accountDepotLimit").val() == 0 || $("#accountDepotLimit").val() > <?php echo sfConfig::get('mod_account_limit_weekly_credit'); ?> || $("#accountDepotLimit").val() < <?php echo sfConfig::get('mod_account_limit_min_weekly_credit'); ?> ) {
            $("#accountDepotLimit"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">Votre limite de dépôt est incorrecte</p>');
            $("#accountDepotLimit"+'_bulle').fadeIn('fast');
            isFormValid= false;
        }

        if ( $("#accountMiseLimit").val() == '1' ) {
    	   	if(!isValidDeposit($('#accountLimiteMisePerso').val())  && $('#accountLimiteDepotPerso').val() =='' && $('#accountLimiteDepotPerso').val() > <?php echo sfConfig::get('mod_account_limit_weekly_bets'); ?> || $('#accountLimiteDepotPerso').val() < <?php echo sfConfig::get('mod_account_limit_min_weekly_bets'); ?>){
    	     	$("#accountLimiteMisePerso").addClass("formInputVarcharError");
                $("#accountLimiteMisePerso"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">Votre limite de mise est incorrecte</p>');
                $("#accountLimiteMisePerso"+'_bulle').fadeIn('fast');
                isFormValid= false;
    	   	}
        } else if ( $("#accountMiseLimit").val() == 0 || $("#accountMiseLimit").val() > <?php echo sfConfig::get('mod_account_limit_weekly_bets'); ?> || $("#accountMiseLimit").val() < <?php echo sfConfig::get('mod_account_limit_min_weekly_bets'); ?> ) {
            $("#accountMiseLimit"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">Votre limite de mise est incorrecte</p>');
            $("#accountMiseLimit"+'_bulle').fadeIn('fast');
            isFormValid= false;
        }

        if ( $('#accountAcceptConditions:checked').val() == undefined ) {
            $('#accountAcceptConditions_bulle').fadeIn('fast');
            isFormValid= false;
        }

        if(isFormValid != false) {
        	document.formCreationCompteSimple.submit();
        } else {
        	$('#anchor').focus();
        	var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?><?php echo __('text_register_error')?></div>';
	        showNotification(data, "error", function(){});

            return false;
        }
    });
});
</script>
<div class="layoutIntAllBlanc">
    <div class="interface">
        <?php echo image_tag('moncompte/top.png', array('alt' => '', 'border' => '0', 'size' => '990x4')); ?>
        <p style="height: 40px;"></p>
        <?php include_component('interface', 'header', array('image' => '/images/account/create/titleSimple_'.strtolower($sf_user->getCulture()).'.png', 'title' => __('Retour accueil'), 'link' => url_for("@homepage") )) ?>
        <p style="height: 25px;"></p>
        <div class="gauche">
            <?php include_component('account', 'left', array('form' => 'simple')) ?>
        </div>
        <div class="droite">
        	<table style="border-collapse: collapse; border-spacing: 0px;">
        		<tr>
        			<td style="vertical-align: top; padding-top: 10px;">
        				<?php echo image_tag('/image/default/me/alert.png', array('class' => 'alert', 'size' => '12x12', 'alt' => __('label_me_alert'))); ?>
					</td>
        			<td style="vertical-align: top;">
        				<div style="font-family: Arial; color: #444444; padding: 0px; padding-left: 15px; padding-right: 10px; font-weight: bold; font-size: 12px;"><?php echo __('text_account_register_warnig_top_bold', array('%registerAdvanced%' => link_to(__('text_account_register_warnig_top_bold_link'), 'account/registerAdvanced', array('class' => 'registerGreenLink')))); ?>.</div>
        				<div style="font-family: Arial; color: #444444; padding: 0px; margin-top: 10px; padding-left: 15px; padding-right: 10px; font-size: 12px;"><?php echo __('text_account_register_warnig_bottom_regular'); ?></div>
        			</td>
        		</tr>
        	</table>
        	<br /><br />
                    <H1 class="titreWithBorder">
                        <?php echo __('account_register_interface_droite_titreWithBorder_text_1');?>
                    </H1>
                    <table border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 40px;">
                        <tr>
                            <td align="left" valign="middle">
                                <span class="standard">
                                    <?php echo __('account_register_interface_droite_font_standard_text'); ?>
                                </span>
                            </td>
                            <td align="left" valign="middle">
                                <div style="margin-left: 15px;">
                                    <a href="<?php echo url_for( array('module' => 'account', 'action' => 'loginFacebook') ) ?>">
                                        <?php echo image_tag('facebook/connect.png', array('alt' => '', 'border' => '0', 'size' => '107x25')); ?>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </table>
            <H1 class="titreWithBorder">
            	<?php echo __('account_register_interface_droite_titreWithBorder_text_2');?>
            </H1>
            <form id="formCreationCompteSimple" name="formCreationCompteSimple" method="post" action="" onsubmit="return false;">
                <?php include_component('interface', 'radio',           array('bloc' => 'information', 'width1' => '160', 'width2' => '240', 'marginLeftError' => '400', 'messageError' => __('account_register_accountCivilite_messageError_text'),       'blocName' => 'accountCivilite', 'blocLegende' => '', 'blocValue' => '', 'blocChoices' => array('M', 'Mme', 'Mlle'))) ?>
                <?php include_component('interface', 'simpleWidget',    array('bloc' => 'information',  'width1' => '160', 'width2' => '240', 'width3' => '', 'marginLeftError' => '410', 'messageError' => __('register_accountLastName_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountLastname', 'blocLegende' => __('account_register_accountLastName_legende_text'), 'blocValue' => $accountLastname, 'blocHelp' => __('account_register_accountLastName_help_text'))) ?>
                <?php include_component('interface', 'simpleWidget',    array('bloc' => 'information',  'width1' => '160', 'width2' => '240', 'width3' => '', 'marginLeftError' => '410', 'messageError' => __('register_accountFirstname_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountFirstname', 'blocLegende' => __('account_register_accountFirstname_legende_text'), 'blocValue' => $accountFirstname, 'blocHelp' => __('account_register_accountFirstname_help_text'))) ?>
                <?php include_component('interface', 'blockPseudo',    array('bloc' => 'information',  'width1' => '160', 'width2' => '204', 'width3' => '', 'marginLeftError' => '410', 'messageError' => __('register_accountPseudo_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountPseudo', 'blocLegende' => __('account_register_accountPseudo_legende_text'), 'blocValue' => $accountPseudo, 'blocHelp' => __('account_register_accountPseudo_help_text'))) ?>
                <?php include_component('interface', 'date',            array('bloc' => 'information',  'width1' => '160', 'width2' => '260', 'width3' => '', 'marginLeftError' => '410', 'messageError' => '', 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountBirthdate', 'blocLegende' => __('account_register_accountBirthdate_legende_text'), 'blocChoices1' => $blocChoices1, 'blocChoices2' => $blocChoices2, 'blocChoices3' => $blocChoices3, 'blocValue1' => $accountBirthdate_1, 'blocValue2' => $accountBirthdate_2, 'blocValue3' => $accountBirthdate_3, 'blocHelp' => __('account_register_accountBirthdate_help_text'))) ?>
                <?php include_component('interface', 'simpleWidget',    array('bloc' => 'information',  'width1' => '160', 'width2' => '240', 'width3' => '', 'marginLeftError' => '410', 'messageError' => __('register_accountEmail_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountEmail', 'blocLegende' => __('account_register_accountEmail_legende_text'), 'blocValue' => $accountEmail ,'blocHelp' => __('account_register_accountEmail_help_text'))) ?>
                <?php include_component('interface', 'simpleWidget',    array('bloc' => 'information',  'width1' => '160', 'width2' => '240', 'width3' => '', 'marginLeftError' => '410', 'messageError' => __('register_accountPassword_messageError_text'), 'blocType' => 'password', 'blocIcone' => '', 'blocName' => 'accountPassword', 'blocLegende' => __('account_register_accountPassword_legende_text'), 'blocValue' => $accountPassword, 'blocHelp' => __('account_register_accountPassword_help_text'))) ?>
                <?php include_component('interface', 'simpleWidget',    array('bloc' => 'information',  'width1' => '160', 'width2' => '240', 'width3' => '', 'marginLeftError' => '410', 'messageError' => __('register_accountConfirmation_messageError_text'), 'blocType' => 'password', 'blocIcone' => '', 'blocName' => 'accountConfirmation', 'blocLegende' => __('account_register_accountConfirmation_legende_text'), 'blocValue' => $accountConfirmation, 'blocHelp' => __('account_register_accountConfirmation_help_text'))) ?>
                <?php include_component('interface', 'captcha',         array('bloc' => 'gold',         'width1' => '160', 'width2' => '240', 'width3' => '', 'marginLeftError' => '410', 'messageError' => __('register_accountHumain_messageError_text'), 'blocType' => 'text', 'blocIcone' => '', 'blocName' => 'accountHumain', 'blocLegende' => __('account_register_accountHumain_legende_text'), 'blocValue' => '', 'blocHelp' => '')) ?>
				
                <?php echo image_tag('account/create/complex/separation4.png', array('alt' => '', 'border' => '0', 'size' => '666x33', 'style' => 'margin-top: 14,5px; margin-bottom: 15px;')); ?>
                
                <?php $cguLink = '<a href="'.$cguUrl.'" target="new">'.__('accountAcceptConditions_link_text').'</a>';?>
                <?php $rulesLink = '<a href="'.$rulesUrl.'" target="new">'.__('accountAcceptRules_link_text').'</a>';?>
                <?php $cguRulesText = __('account_registerAdvanced_accountAcceptConditions_legende_text_1').'<br />'; ?>
                <?php $cguRulesText .= '<ul style="margin-left: 15px;"><li>'.__('account_registerAdvanced_accountAcceptConditions_legende_text_2').' '.$cguLink.' '.__('account_registerAdvanced_accountAcceptConditions_legende_text_3').' '.$rulesLink.' '.__('account_registerAdvanced_accountAcceptConditions_legende_text_4').'</li>'; ?>
                <?php $cguRulesText .= '<li style="margin-top:5px;">'.__('account_registerAdvanced_accountAcceptConditions_legende_text_5').'</li></ul>'; ?>
                
                <?php include_component('interface', 'accept', array('bloc' => 'accept', 'marginLeftError' => '-234', 'blocName' => 'accountAcceptConditions', 'messageError' => __('account_registerAdvanced_accountAcceptConditions_messageError_text'), 'blocLegende' => $cguRulesText, 'blocValue' => '1', 'blocChecked' => '')) ?>
                <?php include_component('interface', 'accept', array('bloc' => 'accept', 'marginLeftError' => '440', 'blocName' => 'accountAcceptOffres', 'messageError' => '', 'blocLegende' => __('account_registerAdvanced_accountAcceptOffres_legende_text'), 'blocValue' => '1', 'blocChecked' => '')) ?>
                
                <div class="boutonSubmit" id="buttonSubmit" style="margin-top: 30px; margin-left: 210px; margin-bottom: 80px;">
                    <input type="image" src="/images/interface/boutonInscrire_<?php echo $sf_user->getCulture() ?>.png"
				                   name="Se connecter"
				                   value="Se connecter"
				                   class="c-submit" />
				</div>
			</form>
        </div>
		<div style="clear:both;"></div>
	</div>
</div>
<script type="text/javascript">

        $('#accountLastname').click(function() {
            $('#accountLastname').keyup();
        });

        $("#accountLastname").keyup(function(event) {
            if (this.value != '') {
            	$("#accountLastname").removeClass("formInputVarcharErrorOnlyTicker");
            	$("#accountLastname").addClass("formInputVarcharSuccessOnlyTicker");
            }else {
                $("#accountLastname").removeClass("formInputVarcharSuccessOnlyTicker");
                $("#accountLastname").addClass("formInputVarcharErrorOnlyTicker");
            }
        });

        $('#accountFirstname').click(function() {
        $(  '#accountFirstname').keyup();
        });

        $("#accountFirstname").keyup(function(event) {
            if (this.value != '') {
            	$("#accountFirstname").removeClass("formInputVarcharErrorOnlyTicker");
            	$("#accountFirstname").addClass("formInputVarcharSuccessOnlyTicker");
            }else {
                $("#accountFirstname").removeClass("formInputVarcharSuccessOnlyTicker");
                $("#accountFirstname").addClass("formInputVarcharErrorOnlyTicker");
            }
        });	

        $("#accountEmail").keyup(function(event) {
                var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if( rege.test($('#accountEmail').val()) ) {
                    $("#accountEmail").removeClass("formInputVarcharErrorOnlyTicker");
                	$("#accountEmail").addClass("formInputVarcharSuccessOnlyTicker");
                }
                else {
                	$("#accountEmail").removeClass("formInputVarcharSuccessOnlyTicker");
                    $("#accountEmail").addClass("formInputVarcharErrorOnlyTicker");
                }
        });		      

        $("#accountPassword").keyup(function(event) {
                  var rege = /^(.{5})+/;
                  if( rege.test($('#accountPassword').val()) ) {   				
                $("#accountPassword").removeClass("formInputVarcharErrorOnlyTicker");
            	$("#accountPassword").addClass("formInputVarcharSuccessOnlyTicker");
        }else {              
                $("#accountPassword").removeClass("formInputVarcharSuccessOnlyTicker");
                $("#accountPassword").addClass("formInputVarcharErrorOnlyTicker");
        	}
        });

          $("#accountConfirmation").keyup(function(event) {
              var rege = /^(.{5})/;
              if( rege.test($('#accountConfirmation').val()) ) {   				
            $("#accountConfirmation").removeClass("formInputVarcharErrorOnlyTicker");
        	$("#accountConfirmation").addClass("formInputVarcharSuccessOnlyTicker");
              }
        	  if ( $("#accountPassword").val() != '' && $("#accountConfirmation").val() != '' && ( $("#accountPassword").val() != $("#accountConfirmation").val() ) ) {
                  $("#accountConfirmation").removeClass("formInputVarcharSuccessOnlyTicker");
                  $("#accountConfirmation").addClass("formInputVarcharErrorOnlyTicker");
            	  }         
      		});
        
            /*
             * Fonctions for gestion widgets
             * Ne rien toucher ici si on ajoute un widget
             */
            function verifWidgetText(widget) {
                var valueInWidget = $("#"+widget).val();
                if ( valueInWidget == '' ) {

                    $("#"+widget).addClass("formInputVarcharErrorOnlyTicker");

                    if ( widget == 'accountConfirmation' )
                        $("#accountConfirmation"+'_bulle').html('<p style="margin-left: 25px; margin-top: 10px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Le mot de passe est obligatoire.') ?></p>');

                    if ( widget == 'accountEmail' ) {
                        $("#accountEmail"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Email est obligatoire.') ?></p>');
                    }

                    if ( widget == 'accountPseudo' ) {
                        $("#accountPseudo"+'_bulle').html('<p style="margin-left: 25px; margin-top: 5px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Le pseudo est obligatoire.') ?></p>');
                    }

                    if ( widget == 'accountPassword' ) {
                        $("#accountPassword"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Le mot de passe est obligatoire.') ?></p>');
                    }

                    $("#"+widget+'_bulle').fadeIn('fast');
                    $("#"+widget).focus();
                    
                    return(false);
                }
                return(true);
            }

            function hideMessageErrorFromWidget(widget, widgetName) {
                $(".formInputVarchar").removeClass("formInputVarcharError");
                $('#'+widgetName+'_bulle').fadeOut('fast');
            }

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

            $(".formInputVarcharPseudo").keyup(function(key) {
                hideMessageErrorFromWidget(this, this.id);
            });

            $(".formInputVarcharPseudo").focus(function(key) {
            	$(this).removeClass("formInputVarcharSuccessOnlyTickerPseudo");
                $(this).addClass("formInputVarcharSelectedPseudo");
            });

            $(".formInputVarcharPseudo").blur(function(key) {
                $(".formInputVarcharPseudo").removeClass("formInputVarcharSelectedPseudo");
            });

            $("#buttonSubmit").click(function(){

                var formValide = true;

                if ( !verifWidgetText('accountLastname') ) {
										document.getElementById('buttonSubmit').style.display = 'block';
										document.getElementById('patience').style.display='none';
										return(false);
									}else{$("#accountLastname").addClass("formInputVarcharSuccessOnlyTicker");}

                if ( !verifWidgetText('accountFirstname') )	 {
											document.getElementById('buttonSubmit').style.display = 'block';
											document.getElementById('patience').style.display='none';
											return(false);
										}else{$("#accountFirstname").addClass("formInputVarcharSuccessOnlyTicker");}

                if ( !verifWidgetText('accountPseudo') )		 {
												document.getElementById('buttonSubmit').style.display = 'block';
												document.getElementById('patience').style.display='none';
												return(false);
											}else{$("#accountPseudo").addClass("formInputVarcharSuccessOnlyTicker");}

                if(!checkAge('<?php echo sfConfig::get('mod_account_registration_simple_age'); ?>', $('#accountBirthdate_3').val(), $('#accountBirthdate_2').val(), $('#accountBirthdate_1').val())) {

            		$("#accountBirthdate_bulle").html("<p style=\"margin-left: 25px; margin-top: 20px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;\"><?php echo __('text_account_register_too_young'); ?></p>");
            		$("#accountBirthdate_bulle").show();
            		$("#accountBirthdate_1").focus();
					return false;
                } else { $("#accountBirthdate_bulle").hide(); }

                if ( !verifWidgetText('accountEmail') )	{
					document.getElementById('buttonSubmit').style.display = 'block';
					document.getElementById('patience').style.display='none';
					return(false);
				}else{$("#accountEmail").addClass("formInputVarcharSuccessOnlyTicker");}

                if ( !verifWidgetText('accountPassword') ) {
					document.getElementById('buttonSubmit').style.display = 'block';
					document.getElementById('patience').style.display='none';
					return(false);
				}else{$("#accountPassword").addClass("formInputVarcharSuccessOnlyTicker");}

                if ( !verifWidgetText('accountConfirmation') ) {
					document.getElementById('buttonSubmit').style.display = 'block';
					document.getElementById('patience').style.display='none';
					return(false);
				}else{$("#accountConfirmation").addClass("formInputVarcharSuccessOnlyTicker");}

                var validSize = /^(.{5})+/;
                var validFormat = new RegExp("^[0-9A-Za-zÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸàâäçéèêëîïôöùûüÿÆŒæœ€#$'()*+,./:;=?!@_ -]*$", "g");
        		if( !validSize.test($('#accountPseudo').val()) ) { 

                    $("#accountPseudo").removeClass("formInputVarcharSuccessOnlyTicker");
					$("#accountPseudo").addClass("formInputVarcharErrorOnlyTicker");
                    $("#accountPseudo"+'_bulle').html('<p style="margin-left: 25px; margin-top: 5px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">Votre pseudo doit contenir au moins 5 caractères alphanumériques</p>');
                    $("#accountPseudo"+'_bulle').fadeIn('fast');
                    $("#accountPseudo"+widget).focus();
					document.getElementById('buttonSubmit').style.display = 'block';
					document.getElementById('patience').style.display='none';
					return(false);
                } else if(!validFormat.test($('#accountPseudo').val())) {

                     $("#accountPseudo").removeClass("formInputVarcharSuccessOnlyTicker");
            		$("#accountPseudo").addClass("formInputVarcharErrorOnlyTicker");
                    $("#accountPseudo"+'_bulle').html('<p style="margin-left: 25px; margin-top: 5px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __("text_register_error_pseudo_not_match_constraint")?></p>');
                    $("#accountPseudo"+'_bulle').fadeIn('fast');
                    return(false);
                }
                    
                if ( $("#accountPassword").val() != '' ) {
                    var rege = /^(.{5})+/;
                    if( rege.test($('#accountPassword').val()) ) { 
                    }
                    else {
                        $("#accountPassword").removeClass("formInputVarcharSuccessOnlyTicker");
                        $("#accountPassword").addClass("formInputVarcharErrorOnlyTicker");
                        $("#accountPassword"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">Votre mot de passe doit contenir au moins 5 caractères alphanumériques</p>');
                        $("#accountPassword"+'_bulle').fadeIn('fast');
                        $("#accountPassword"+widget).focus();
                        document.getElementById('buttonSubmit').style.display = 'block';
                        document.getElementById('patience').style.display='none';
                        return(false);
                    }
                }

                if ( $("#accountPassword").val() != '' && $("#accountConfirmation").val() != '' && ( $("#accountPassword").val() != $("#accountConfirmation").val() ) ) {
                	$("#accountConfirmation").removeClass("formInputVarcharSuccessOnlyTicker");
                    $("#accountConfirmation").addClass("formInputVarcharErrorOnlyTicker");
                    $("#accountConfirmation"+'_bulle').html('<p style="margin-left: 25px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">Le mot de passe de vérification ne correspond pas au mot de passe saisi précédemment.</p>');
                    $("#accountConfirmation"+'_bulle').fadeIn('fast');
                    $("#accountConfirmation"+widget).focus();
                }

                if ( $("#accountEmail").val() != '' ) {
                    var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    if( rege.test($('#accountEmail').val()) ) {
                    }
                    else {
                    	$("#accountEmail").removeClass("formInputVarcharSuccessOnlyTicker");
                        $("#accountEmail").addClass("formInputVarcharErrorOnlyTicker");
                        $("#accountEmail"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;">L email est incorrect.</p>');
                        $("#accountEmail"+'_bulle').fadeIn('fast');
                        $("#accountEmail"+widget).focus();
                        document.getElementById('buttonSubmit').style.display = 'block';
                        document.getElementById('patience').style.display='none';
                        return(false);
                    }
                }

                if ( $('#accountAcceptConditions:checked').val() == undefined ) {
                    $('#accountAcceptConditions_bulle').fadeIn('fast');
                    return(false);
                }
                
                document.formCreationCompteSimple.submit();
    });
</script>
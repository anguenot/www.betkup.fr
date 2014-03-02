<div class="moncompte">
    <?php include_component('account', 'navigation', array()) ?>
    <a name="toppage"></a>
    <div class="interface">
        <?php echo image_tag('moncompte/top.png', array('alt' => '', 'border' => '0', 'size' => '990x4')); ?>
        <div>
            <div class="interface_gauche">
                <div class="enteteGauche">
                    <p class="titre">
                        <?php echo image_tag('moncompte/titremoncompte_' . $sf_user->getCulture() . '.png', array('alt' => '', 'border' => '0', 'size' => '349x45')); ?>
                    </p>
                    <?php include_component('account', 'menu', array('ongletActif' => $ongletActif, 'labelsOnglets' => $labelsOnglets)) ?>
                </div>
                <div class="corpsGauche">
                    <?php include_component('account', 'title', array('racine' => 'creditermoncompte', 'altImg' => 'Mes notifications')) ?>
					<div class="blocBlanc">
						<div class="margeGauche">
                            <div style="height: 27px;"></div>
								<?php include_component('account', "creditForm",
                   			    array(
                   			    	'credit_amountCreditPerso' => $credit_amountCreditPerso,
                   			    	'credit_card_digits' => $credit_card_digits,
                   			    	'credit_card_expire_2' => $credit_card_expire_2,
                   			    	'credit_card_expire_3' => $credit_card_expire_3,
                   			    	'credit_card_crypto' =>  $credit_card_crypto,

                   			)) ?>
                            <div style="height: 14px;"></div>
							<div align="left">
                                <div align="right" style="width: 420px;">
                                    <table border="0" cellpadding="0" cellspacing="20">
                                        <tr>
                                            <td>
                                                <?php include_component('interface', 'buttonText', array( 'name' => 'Retour', 'href' => url_for(array('module' => 'account', 'action' => 'transaction')) ) ) ?>
                                            </td>
                                            <td>
                                                <div class="boutonSubmit" id="submit-div">
                                                	<div id="hide-button-submit"></div>
                                                    <input type="image" src="/images/interface/boutonCrediter_FR.png"
                                                           name="<?php echo __('Créditer') ?>"
                                                           value="<?php echo __('Créditer') ?>"
                                                           class="c-submit"
                                                           id="buttonSubmit" />
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div style="height: 40px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="interface_droite">
                <p style="margin:10px;"></p>
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>
</div>
<script type="text/javascript">
function verifWidgetText(widget) {
    var valueInWidget = $("#"+widget).val();
    if ( valueInWidget == '' ) {
        $("#"+widget).addClass("formInputVarcharError");

        if ( widget == 'amountCreditSelect' )
            $("#amountCreditSelect"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Le montant est obligatoire.') ?></p>');

        if ( widget == 'crypto' )
            $("#crypto"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Le cryptogramme situé au dos de votre carte bancaire est obligatoire.') ?></p>');

        if ( widget == 'cardnumber' )
            $("#cardnumber"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Le numéro de carte est obligatoire.') ?></p>');

        $("#"+widget+'_bulle').fadeIn('fast');
        $("#"+widget).focus();
        return(false);
    }
    return(true);
}
function hideMessageErrorFromWidget(widgetName) {
	$('#'+widgetName).removeClass("formInputVarcharError");
    $('#'+widgetName+'_bulle').fadeOut('fast');
}
$(function() {
	<?php if($credit_amountCreditPerso == 1) : ?>
		$("#amountCreditSelect").val('1');
		$("#bockAmountCreditPerso").slideDown("fast");
		$("#amountCreditPerso").val('<?php echo sfConfig::get('mod_account_credit_min'); ?>');
	<?php endif; ?>

	$("#amountCreditSelect").change(function() {
	    $("#amountCreditSelect option:selected").each(function () {
	    if (this.value == '1') {
	    	$("#bockAmountCreditPerso").slideDown("fast");
		}else if (this.value != '1') {
			$("#bockAmountCreditPerso").slideUp("fast");
		}
	    });
	});
    
    $(".formInputVarchar").keyup(function(key) {
        hideMessageErrorFromWidget(this, this.id);
    });
    $(".formInputVarchar").focus(function(key) {
        $(this).addClass("formInputVarcharSelected");
    });
    $(".formInputVarchar").blur(function(key) {
        $(".formInputVarchar").removeClass("formInputVarcharSelected");
    });

    $("#buttonSubmit").dblclick(function() {
		$(this).trigger('click');
    });
    
    $("#buttonSubmit").click(function() {
		$('#hide-button-submit').show();
		$(this).fadeTo(0, 0.5);
        
    	var formValid = true;
        if ( !verifWidgetText('amountCreditSelect') ) {
        	formValid = false;
        }
        if ( $("#amountCreditSelect").val() != '' ) {
            if($("#amountCreditSelect").val() != '1'){
                var amountCreditVerif = $("#amountCreditSelect").val();
            }else {
            	var amountCreditVerif = $("#amountCreditPerso").val();
            }
            if( amountCreditVerif >= <?php echo sfConfig::get('mod_account_credit_min') ?> && amountCreditVerif <= <?php echo sfConfig::get('mod_account_credit_max') ?> ) {
            	hideMessageErrorFromWidget('amountCreditSelect');
            }
            else {
                $("#amountCreditSelect").addClass("formInputVarcharError");
                $("#amountCreditSelect"+'_bulle').html('<p style="margin-left: 20px; margin-top: 5px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('text_credit_limitation_error', array('%bet_min%' => sfConfig::get('mod_account_credit_min'), '%bet_max%' => sfConfig::get('mod_account_credit_max'))) ?></p>');
                $("#amountCreditSelect"+'_bulle').fadeIn('fast');
                $("#amountCreditSelect"+widget).focus();
                formValid = false;
            }
        }
        if ( !verifWidgetText('cardnumber') ) {
        	formValid = false;
        }
        if ( $("#cardnumber").val() != '' ) {
            var rege = /^([0-9]{3})+/;
            if( rege.test($('#cardnumber').val()) ) {
            	hideMessageErrorFromWidget('cardnumber');
            }
            else {
                $("#cardnumber").addClass("formInputVarcharError");
                $("#cardnumber"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Votre numéro de carte bancaire est incorrect') ?></p>');
                $("#cardnumber"+'_bulle').fadeIn('fast');
                $("#cardnumber"+widget).focus();
                formValid = false;
            }
        }
        if ( !verifWidgetText('crypto') ) {
        	formValid = false;
        }
        if ( $("#crypto").val() != '' ) {
            var rege = /^([0-9][0-9][0-9])$/;
            if( rege.test($('#crypto').val()) ) {
            	hideMessageErrorFromWidget('crypto');
            }
            else {
                $("#crypto").addClass("formInputVarcharError");
                $("#crypto"+'_bulle').html('<p style="margin-left: 25px; margin-top: 5px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Votre cryptogramme est incorrect') ?></p>');
                $("#crypto"+'_bulle').fadeIn('fast');
                $("#crypto"+widget).focus();
                formValid = false;
            }
        }

        if(formValid) {
        	document.formCredit.submit();
        } else {
        	$('#hide-button-submit').hide();
    		$(this).fadeTo(0, 1);
    		return false;
        }
    });
});
</script>
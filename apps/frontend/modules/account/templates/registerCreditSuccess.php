<div class="layoutIntAllBlanc">
    <div class="interface">
        <div align="center" class="account">
        <?php echo image_tag('moncompte/top.png', array('alt' => '', 'border' => '0', 'size' => '990x4')); ?>
            <p style="height: 40px;"></p>
        <?php echo image_tag('account/create/title.png', array('alt' => '', 'border' => '0', 'size' => '990x64')); ?>
            <p style="height: 25px;"></p>
            <div class="gauche">
                <?php include_component('account', 'left', array('form' => 'advanced')) ?>
            </div>
            <div class="droite">
            <?php echo image_tag('account/create/complex/header2.png', array('alt' => '', 'border' => '0', 'size' => '666x38', 'style' => 'margin-bottom: 40px;')); ?>
	        <?php include_component('account', "creditForm",
				            array(
                   			    	'credit_amountCreditPerso' => $credit_amountCreditPerso,
                   			    	'credit_card_digits' => $credit_card_digits,
                   			    	'credit_card_expire_2' => $credit_card_expire_2,
                   			    	'credit_card_expire_3' => $credit_card_expire_3,
                   			    	'credit_card_crypto' =>  $credit_card_crypto,

                   			))
	        ?>
                <div align="left">
                    <div align="right" style="width: 420px;">
                        <table border="0" cellpadding="0" cellspacing="20">
                            <tr>
                                <td>
                                    <a href="<?php echo $defaultUrl; ?>"><?php echo __('account_registerCredit_link_credit_later_text'); ?></a>
                                </td>
                                <td>
                                    <div class="boutonSubmit" id="buttonSubmit">
                                        <input type="image" src="/images/interface/boutonCrediter_FR.png"
                                               name="<?php echo __('Créditer') ?>"
                                               value="<?php echo __('Créditer') ?>"
                                               class="c-submit" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
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
});
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
    function hideMessageErrorFromWidget(widget, widgetName) {
        $(".formInputVarchar").removeClass("formInputVarcharError");
        $('#'+widgetName+'_bulle').fadeOut('fast');
    }
    $(".formInputVarchar").keyup(function(key) {
        hideMessageErrorFromWidget(this, this.id);
    });
    $(".formInputVarchar").focus(function(key) {
        $(this).addClass("formInputVarcharSelected");
    });
    $(".formInputVarchar").blur(function(key) {
        $(".formInputVarchar").removeClass("formInputVarcharSelected");
    });
    $("#buttonSubmit").click(function(){
        var formValide = true;
        if ( !verifWidgetText('amountCreditSelect') ) {
            return(false);
        }
        if ( $("#amountCreditSelect").val() != '' ) {
            if($("#amountCreditSelect").val() != '1'){
                var amountCreditVerif = $("#amountCreditSelect").val();
            }else {
            	var amountCreditVerif = $("#amountCreditPerso").val();
            }
            if( amountCreditVerif >= <?php echo sfConfig::get('mod_account_credit_min') ?> && amountCreditVerif <= <?php echo sfConfig::get('mod_account_credit_max') ?> ) {
            }
            else {
                $("#amountCreditSelect").addClass("formInputVarcharError");
                $("#amountCreditSelect"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('text_credit_limitation_error', array('%bet_min%' => sfConfig::get('mod_account_credit_min'), '%bet_max%' => sfConfig::get('mod_account_credit_max'))) ?></p>');
                $("#amountCreditSelect"+'_bulle').fadeIn('fast');
                $("#amountCreditSelect"+widget).focus();
                return(false);
            }
        }
        if ( !verifWidgetText('cardnumber') ) {
            return(false);
        }
        if ( $("#cardnumber").val() != '' ) {
            var rege = /^([0-9]{3})+/;
            if( rege.test($('#cardnumber').val()) ) {
            }
            else {
                $("#cardnumber").addClass("formInputVarcharError");
                $("#cardnumber"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Votre numéro de carte bancaire est incorrect') ?></p>');
                $("#cardnumber"+'_bulle').fadeIn('fast');
                $("#cardnumber"+widget).focus();
                return(false);
            }
        }
        if ( !verifWidgetText('crypto') ) {
            return(false);
        }
        if ( $("#crypto").val() != '' ) {
            var rege = /^([0-9][0-9][0-9])$/;
            if( rege.test($('#crypto').val()) ) {
            }
            else {
                $("#crypto").addClass("formInputVarcharError");
                $("#crypto"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Votre cryptogramme est incorrect') ?></p>');
                $("#crypto"+'_bulle').fadeIn('fast');
                $("#crypto"+widget).focus();
                return(false);
            }
        }
        document.formCredit.submit();
    });
</script>
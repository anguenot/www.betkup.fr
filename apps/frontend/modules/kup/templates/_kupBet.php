<script type="text/javascript">
function validateStakeSubmit() {
	$('#validateStakeForm').submit();
}
</script>
<div class="miser">
    <div style="margin-bottom: 10px; width: 652px; margin-left: auto; margin-right: auto;">
        <?php echo image_tag('/images/kup/view/mise/rootline2.png', array('size' => '652x39', 'style' => 'border: none;')) ?>
    </div>
</div>
<div style="width: 652px; margin-left: auto; margin-right: auto; padding-top:20px; margin-bottom: 20px;">
	<table class="bet-notice">
		<tr>
			<td style="vertical-align: middle;">
				<?php echo image_tag('/image/default/me/alert.png', array('class' => 'alert', 'size' => '12x12', 'alt' => __('label_me_alert')));?>
			</td>
			<td style="vertical-align: top;">
				<div style="font-family: Arial; color: #444444; padding: 0px; padding-left: 15px; padding-right: 10px; font-size: 12px;">
					<b><?php echo __('text_bet_prono_notice')?></b>
				</div>
			</td>
		</tr>
	</table>
</div>
<div class="stakeContener">
    <table class="stake-table">
        <tr>
            <td width="340" style="vertical-align: top; text-align: center;padding-left: 30px; ">
                <div>
                    <table class="stake-sub-table">
                        <tr>
                            <td width="200" align="right" height="60" valign="middle">
                                <div class="title"><?php echo __('text_bet_account_balance') ?> : </div></td>
                            <td style="padding-left: 10px;">
                                <span class="price orange"><?php echo $sf_user->getAttribute('credit', '0', 'subscriber'); ?> €</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="200" align="right" height="30" valign="middle">
                                <div class="title"><?php echo __('text_bet_needed_bet'); ?> : </div></td>
                            <td style="padding-left: 10px;">
                                <span class="price orange"><?php echo $kupData['stake']; ?> €</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td width="340" style="vertical-align: middle; text-align: center;">
                <?php if($sf_user->getAttribute('type', '', 'subscriber') != sfConfig::get("mod_kup_type_gambling_fr")) : ?>
                            <div style="margin-top: 20px; margin-left: 50px;">
                                <span class="legende"><?php echo __('text_bet_upgrade_account'); ?>
                                </span>
                                <div style="margin-top: 15px; width: 250px; margin-left: auto; margin-right: auto;">
                                    <a href="<?php echo (isset($roomData)) ? url_for(array('module' => 'account', 'action' => 'updateSimpleAccount', 'kup_uuid' => $kupData['uuid'], 'room_uuid' => $roomData['uuid'], 'parent_referer' => 'kup_bet')) :
                                    										 url_for(array('module' => 'account', 'action' => 'updateSimpleAccount', 'kup_uuid' => $kupData['uuid'], 'parent_referer' => 'kup_bet')); ?>" title="<?php echo __('text_bet_upgrade_account') ?>">
                                       <?php echo __('open_account_complet_to_bet'); ?>
                                    </a>
                                </div>
                            </div>
                <?php elseif($kupData['stake'] > 0 && $kupData['stake'] > $sf_user->getAttribute('credit', '0', 'subscriber')) : ?>
                <div style="margin-top: 20px; margin-left: 50px;">
                    <span class="legende"><?php echo __('text_bet_insufficient_balance'); ?> <br /><?php echo __('text_bet_credit_before') ?>
                    </span>
                    <div style="margin-top: 15px; width: 250px; margin-left: auto; margin-right: auto;">
                        <a href="<?php echo (isset($roomData)) ? url_for(array('module' => 'account', 'action' => 'credit', 'kup_uuid' => $kupData['uuid'], 'room_uuid' => $roomData['uuid'], 'parent_referer' => 'kup_bet')) :
                        										 url_for(array('module' => 'account', 'action' => 'credit', 'kup_uuid' => $kupData['uuid'], 'parent_referer' => 'kup_bet')); ?>" title="<?php echo __('text_bet_credit_account') ?>">
                            <?php echo image_tag('/images/interface/button/crediterOrange.png', array('size' => '103x34', 'style' => 'border: none;' ))?>
                        </a>
                    </div>
                </div>
                <?php else : ?>
                <form action="" id="validateStakeForm" method="post">
                    <div style="margin-top: 20px;">
                        <?php include_component('interface', 'simpleWidget', array(
                                'bloc' => 'information',
                                'width1' => '130',
                                'width2' => '130',
                                'widthGadget' => '120',
                                'width3' => '0',
                                'marginLeftError' => '0',
                                'messageError' => '',
                                'blocType' => 'password',
                                'blocIcone' => '',
                                'blocName' => 'betStakePassword',
                                'blocLegende' => __('label_form_create_room_password_field'),
                                'blocValue' => ''
                                )) ?>
                        <input type="hidden" name="information[betStakeValue]" value="<?php echo $kupData['stake']; ?>" />
                        <input type="hidden" name="information[betStakeKupUuid]" value="<?php echo $kupData['uuid']; ?>" />
                        <input type="hidden" name="information[betKupTitle]" value="<?php echo $kupData['title']; ?>" />
                        <input type="hidden" name="information[betkupStartDate]" value="<?php echo $kupData['startDate']; ?>" />
                        <input type="hidden" name="information[email]" value="<?php echo $userEmail; ?>" />
                        <input type="hidden" name="information[creditBefore]" value="<?php echo $userCreditBefore; ?>" />
                        <input type="hidden" name="information[predictionsIC]" value="<?php echo $predictions_ic; ?>" />
                        <input type="hidden" name="information[predictionsSE]" value="<?php echo $predictions_se; ?>" />
                        <input type="hidden" name="information[predictionsQ]" value="<?php echo $predictions_q; ?>" />
                        <?php if (isset($roomData)): ?>
                        <input type="hidden" name="information[betStakeRoomUuid]" value="<?php echo $roomData['uuid']; ?>" />
                        <?php endif; ?>
                        <div style="margin-top: 15px; width: 105px; margin-left: auto; margin-right: auto;">
                           <a href="javascript:void(0);" onclick="validateStakeSubmit();">
                            	<?php echo image_tag('/images/kup/view/statut/buttonMiser.png', array('size' => '105x36'))?>
                            </a>
                        </div>
                    </div>
                </form>
                <?php endif; ?>
            </td>
       </tr>
    </table>
</div>
<script type="text/javascript">
$(function() {
	$(".formInputVarchar").focus(function(key) {
    	$(this).removeClass("formInputVarcharSuccessOnlyTicker");
        $(this).addClass("formInputVarcharSelected");
    });

    $(".formInputVarchar").blur(function(key) {
        $(".formInputVarchar").removeClass("formInputVarcharSelected");
    });

    $(".formInputVarchar").trigger('focus');
});
</script>
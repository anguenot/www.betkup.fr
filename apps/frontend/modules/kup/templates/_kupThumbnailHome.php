<div class="<?php echo (isset($class)) ? $class : 'bloc' ?>"
     onclick="location.href='<?php echo $kupUrl; ?>'"
     style="cursor: pointer;position: relative; background-position:center; margin: 0px; padding: 0px; width: 235px; height: 180px; background: url('<?php if($data["ui"]["vignette_home_view"] != ""){echo $data["ui"]["vignette_home_view"];}else{ echo $data["background"];} ?>'); background-repeat: no-repeat;">
<?php if ( $data["picto"] !== "" ): ?>
    <div class="picto" style="position: absolute; right: -10px; top: -5px;">
        <img src="/images/kup/picto/<?php echo $data["picto"] ?>" border="0" alt="" />
    </div>
<?php endif ?>
<?php if ( true || $data["free"]): ?>
    <div class="freekup" style="position: absolute; left: 6px; top: 46px;">
        <?php if ($data['type'] == sfConfig::get('mod_kup_type_free')): ?>
        <img src="/images/kup/kupGratuite.png" border="0" alt="" />
        <?php elseif ($data['type'] == sfConfig::get('mod_kup_type_gambling_fr')): ?>
	        <?php if ($data['stake'] > 0): ?>
	        	<img src="/images/kup/kupPaying.png" border="0" alt="" />
	        <?php elseif ($data['stake'] == 0): ?>
	        	<img src="/images/kup/kupFreeRoll.png" border="0" alt="" />
	        <?php endif; ?>
        <?php endif; ?>
    </div>
<?php endif ?>
    <table style="width: 235px; border-spacing: 0px; border-collapse:collapse;">
        <tr>
            <td align="left" valign="middle" height="48px">
                <div style="margin: 0px; padding: 0px; height: 7px;"></div>
                <span class="titre">
                <?php echo __($data["title"]) ?>
                </span>
            </td>
        </tr>
    </table>
	<table style="width: 235px; border-spacing: 0px; border-collapse:collapse;">
		<tr>
			<td align="center" valign="bottom" height="32">
                <span class="gain">
                <?php if ($data['type'] == sfConfig::get('mod_kup_type_gambling_fr')): ?>
                <?php echo $data["jackpot"].'€'; ?>
                <?php elseif ($data['type'] == sfConfig::get('mod_kup_type_free')): ?>
		        <?php if(isset($data['isInRoom']) && $data['isInRoom'] == true) :?>
                	<?php if(count($roomUI) > 0) :?>
                		<?php if(isset($roomUI['kups']) && isset($roomUI['kups'][$data['uuid']]) && isset($roomUI['kups'][$data['uuid']]['prize_value'])) :?>
                			<?php echo $roomUI['kups'][$data['uuid']]['prize_value'].' €'?>
                		<?php else: ?>
                			Kup
                		<?php endif; ?>
                	<?php else:?>
                		Kup
                	<?php endif; ?>
                <?php else:?>
                	<?php echo __($data["ui"]["prizeValue"].'€') ?>
                <?php endif;?>
                <?php endif; ?>
			    </span>
			</td>
		</tr>
		<tr>
			<td align="center" valign="top" height="18">
			   <?php if ($data['type'] == sfConfig::get('mod_kup_type_free')): ?>
			   <?php if(isset($data['isInRoom']) && $data['isInRoom'] == true) :?>
			   <span class="gain_info">
			   		<?php if(count($roomUI) > 0) :?>
                		<?php if(isset($roomUI['kups']) && isset($roomUI['kups'][$data['uuid']]) && isset($roomUI['kups'][$data['uuid']]['prize_value'])) :?>
                			<?php echo image_tag('/images/kup/view/prize_to_win.png')?>
                		<?php else: ?>
                			<?php echo __('text_kup_for_glory')?>
                		<?php endif; ?>
                	<?php else:?>
                		<?php echo __('text_kup_for_glory')?>
                	<?php endif; ?>
			   </span>
			   <?php else:?>
			   <?php echo image_tag('/images/kup/view/prize_to_win.png')?>
			   <?php endif;?>
			   <?php elseif ($data['type'] == sfConfig::get('mod_kup_type_gambling_fr')): ?>
               <?php if ($data['stake'] > 0): ?>
               <span class="gain_info">
               <?php echo __('label_kup_guaranteed_price') ?>
               </span>
               <?php elseif ($data['stake'] == 0): ?>
               <span class="gain_info">
               <?php echo __('label_kup_amount_to_share') ?>
               </span>
               <?php endif; ?>
               <?php endif; ?>
			</td>
		</tr>
	</table>
	<div align="left" class="bottom" style="width: 235px; height: 81px; background: url('/images/kup/elementsKup.png');">
        <p style="height: 9px;"></p>
        <table style="width: 169px; border-spacing: 0px; border-collapse:collapse; margin-left: 47px;">
            <tr>
                <td width="101" height="15" align="left"><span class="duree">durée : <?php echo $data['length'] . ' j' ?></span></td>
                <td width="68" height="16" align="center">
                    <div style="height: 1px;"></div>
                    <span id="<?php echo $data["ui"]["kupName"] ?>_chrono" class="chrono"></span>
                  </td>
            </tr>
            <tr>
                <td width="100" height="16" align="left"><span class="mise">mise : <?php echo Util::coupe( __($data["stake"]), '7', '..' ) ?></span></td>
                <td width="70" height="16" align="center"><span class="mise" style="text-align: center;"><?php if(floor(($data["startDate"]/1000) - time()) > 0) : echo __('kup_bloc_time_before_start_text'); endif;?></span></td>
            </tr>
        </table>
        <div align="center" style="margin-top: 1px;">
        	<div class="bouton">
            <?php echo __($data["button"]) ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var refreshId_1 = setInterval(function() {

        var arrayResultat1 = returnChronoPART1('<?php echo $data["startDate"]; ?>', '<?php echo $data["status"]; ?>');

        if(arrayResultat1["chrono"] == 1) {

            if (arrayResultat1[0] >= "01") {
                if (arrayResultat1[0] >= "9") {
                    $('#<?php echo $data["ui"]["kupName"] ?>_chrono').delay(1000).text(arrayResultat1[0]+' '+'<?php echo __('chrono_day_text'); ?>');
                } else {
                    $('#<?php echo $data["ui"]["kupName"] ?>_chrono').delay(1000).text(arrayResultat1[0].substr(1,1)+' '+'<?php echo __('chrono_day_text'); ?>');
                }
            } else if (arrayResultat1[0] <= "01") {
                $('#<?php echo $data["ui"]["kupName"] ?>_chrono').delay(1000).text(arrayResultat1[1]+':'+arrayResultat1[2]+':'+arrayResultat1[3]);
            }
        } else if(arrayResultat1["chrono"] == 0) {

            if(arrayResultat1["opened"] == 1) {
                $('#<?php echo $data["ui"]["kupName"] ?>_chrono').delay(1000).text('<?php echo __('chrono_opened_text'); ?>');
            } else if(arrayResultat1["started"] == 1) {
                $('#<?php echo $data["ui"]["kupName"] ?>_chrono').delay(1000).text('<?php echo __('chrono_started_text'); ?>');
            } else if(arrayResultat1["ongoing"] == 1) {
                $('#<?php echo $data["ui"]["kupName"] ?>_chrono').delay(1000).text('<?php echo __('chrono_ongoing_text'); ?>');
            } else if(arrayResultat1["closed"] == 1 ) {
                $('#<?php echo $data["ui"]["kupName"] ?>_chrono').delay(1000).text('<?php echo __('chrono_closed_text'); ?>');
            } else if(arrayResultat1["settled"] == 1 ) {
                $('#<?php echo $data["ui"]["kupName"] ?>_chrono').delay(1000).text('<?php echo __('chrono_settled_text'); ?>');
            } else if(arrayResultat1["cancelled"] == 1 ) {
                $('#<?php echo $data["ui"]["kupName"] ?>_chrono').delay(1000).text('<?php echo __('chrono_cancelled_text'); ?>');
            }
        }
   }, 1000);
</script>
<script type="text/javascript">
if ($.browser.msie) {
	$('.kup .titre').css('font-size','140%');
}
</script>
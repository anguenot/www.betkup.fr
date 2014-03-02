<?php foreach ($kups as $kup): ?>
	<td class="sofunBatchTdDiv" align="left" valign="top">
		<div class="module_pronoNC" style="margin-bottom: 17px;">
			<div class="titre_onglet">
				<a href="">
					<?php echo image_tag('/kup/default/'. $kup["picto_mini"],array('size' => '20x20', 'style'=>'vertical-align:middle;')) ?>&nbsp;<?php echo $kup["category"] ?>
				</a>
			</div>
			<div class="contenu_haut">
				<div class="titre" title="<?php echo $kup["name"]?>">
					<?php echo Util::coupe($kup["name"], 18, '..') ?>
				</div>
				<div class="kup">
					<b><?php echo $kup["legend1"] ?></b>
				</div>
				<div class="mise">
					<?php echo __('kup_vignette_stake_text');?> : <b><?php echo $kup["legend2"] ?></b>
				</div>
				<div class="part">
					<?php echo __('kup_vignette_participants_text');?> : <b><?php echo $kup["legend3"] ?></b>
				</div>
				<div class="cagnotte">

		            <?php if ($kup['type'] == sfConfig::get('mod_kup_type_gambling_fr')): ?>

		            <?php echo __('kup_vignette_jackpot_text');?><b> <?php echo round($kup["jackpot"], 2); ?> €</b>

		            <?php elseif ($kup['type'] == sfConfig::get('mod_kup_type_free')): ?>
						<?php if(count($roomUI) > 0) :?>
                		<?php if(isset($roomUI['kups']) && isset($roomUI['kups'][$kup['uuid']]) && isset($roomUI['kups'][$kup['uuid']]['prize_value'])) :?>
                			<?php echo __('kup_home_prizes_value');?> : <b><?php echo round($roomUI['kups'][$kup['uuid']]['prize_value'], 2).' €'?></b>
                		<?php else: ?>
                			<?php echo __('kup_home_prizes_value');?> : <b><?php echo $kup["is_template"] == "1" ? round($kup["ui"]["prizeValue"], 2) : '-'; ?></b>
                		<?php endif; ?>
	                	<?php else:?>
	                		<?php echo __('kup_home_prizes_value');?> : <b><?php echo $kup["is_template"] == "1" ? round($kup["ui"]["prizeValue"], 2) : '-'; ?></b>
	                	<?php endif; ?>
                    <?php endif; ?>

				</div>
				<div id="<?php echo $kup["uuid"] ?>_chrono" class="chrono"></div>
			</div>
			<?php if ($sf_user->isAuthenticated()) : ?>
				<div class="has-estimated">
				<?php if ($kup['hasPredictions'] == true) : ?>
					<?php echo image_tag('/image/default/room/offline_prono/good.png', array('alt' => __('label_kup_has_estimated'), 'size' => '20x20')) ?>
				<?php else: ?>
					<?php echo image_tag('/image/default/room/offline_prono/wrong.png', array('alt' => __('label_kup_has_not_estimated'), 'size' => '20x20')) ?>
				<?php endif; ?>
				</div>
				<div class="has-bet">
				<?php if ($kup['hasBet'] == true) : ?>
					<?php echo image_tag('/image/default/room/offline_prono/good.png', array('alt' => __('label_kup_has_bet'), 'size' => '20x20')) ?>
				<?php else : ?>
					<?php echo image_tag('/image/default/room/offline_prono/wrong.png', array('alt' => __('label_kup_has_not_bet'), 'size' => '20x20')) ?>
				<?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="label-has-estimated">
				<?php echo __('kup_vignette_bet_text');?>
			</div>
			<div class="label-has-bet">
				<?php echo ucfirst(__('kup_vignette_stake_text'));?>
			</div>
			<div class="bouton">
				
				<?php if($kup['status'] == 4 || $kup['status'] == 5 || $kup['status'] == -1) :?>
        			<?php $kup_url = ((isset($room_uuid) && $room_uuid != 'me') ? url_for(array('module'=>'room', 'action'=>'kupRanking', 'room_uuid'=> $room_uuid, 'kup_uuid' => $kup['uuid'])).'?tab=ranking' : url_for(array('module' => 'kup', 'action' => 'ranking', 'uuid' => $kup['uuid']))) ?>
        		<?php else:?>
        			<?php $kup_url = ((isset($room_uuid) && $room_uuid != 'me') ? url_for(array('module'=>'room', 'action'=>'kup', 'room_uuid'=> $room_uuid, 'kup_uuid' => $kup['uuid'])).'?tab=predictions' : url_for(array('module' => 'kup', 'action' => 'view', 'uuid' => $kup['uuid']))) ?>
        		<?php endif;?>
				
				<a href="javascript:void(0)" onclick="folowLink_<?php echo $kup['uuid']?>();" title="<?php echo $kup['button'] ?>">
					<?php echo $kup['button'] ?>
				</a>
			</div>
		</div>
		<script type="text/javascript">
			function folowLink_<?php echo $kup['uuid']?>() {
				<?php if($parentModule != 'me' && isset($room_uuid) && $room_uuid != 'me' && $roomPrivacy != sfConfig::get('app_room_privacy_public') && $roomPrivacy != sfConfig::get('app_room_privacy_public_gambling_fr') ) :?>
					var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?><?php echo __('flash_error_room_kup_filter_message'); ?></div>';
				    showNotification(data, "error", function(){});
					return false;
				<?php else:?>
					document.location.href = '<?php echo $kup_url ?>';
				<?php endif;?>
			}

			$(function() {
                    var refreshId_1 = setInterval(function() {
                    var arrayResultat1 = returnChronoPART1('<?php echo $kup["startDate"]; ?>', '<?php echo $kup["status"]; ?>');

                        if(arrayResultat1["chrono"] == 1) {

                            if (arrayResultat1[0] >= "01") {
                                if (arrayResultat1[0] >= "9") {
                                    $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text(arrayResultat1[0]+' '+'<?php echo __('chrono_day_text'); ?>');
                                } else {
                                    $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text(arrayResultat1[0].substr(1,1)+' '+'<?php echo __('chrono_day_text'); ?>');
                                }
                            } else if (arrayResultat1[0] <= "01") {
                                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text(arrayResultat1[1]+':'+arrayResultat1[2]+':'+arrayResultat1[3]);
                            }
                        } else if(arrayResultat1["chrono"] == 0) {

                            if(arrayResultat1["opened"] == 1) {
                                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text('<?php echo __('chrono_opened_text'); ?>');
                            } else if(arrayResultat1["started"] == 1) {
                                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text('<?php echo __('chrono_started_text'); ?>');
                            } else if(arrayResultat1["ongoing"] == 1) {
                                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text('<?php echo __('chrono_ongoing_text'); ?>');
                            } else if(arrayResultat1["closed"] == 1 ) {
                                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text('<?php echo __('chrono_closed_text'); ?>');
                            } else if(arrayResultat1["settled"] == 1 ) {
                                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text('<?php echo __('chrono_settled_text'); ?>');
                            } else if(arrayResultat1["cancelled"] == 1 ) {
                                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text('<?php echo __('chrono_cancelled_text'); ?>');
                            }
                        }
                   }, 1000);
			});
		</script>
	</td>
<?php endforeach; ?>
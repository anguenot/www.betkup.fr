<div id="kups-<?php echo $uuid; ?>" class="kups" style="width: 710px;">
    <?php if( ($sf_params->get('module') != "me") && $isInsideRoom == 0  && !$sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_member')) ) : ?>
    <div style="padding-bottom: 20px; font-weight: bold;">
    	<?php echo image_tag('/image/default/me/alert.png', array('class' => 'alert', 'size' => '12x12', 'alt' => __('label_me_alert'))); ?>
        <?php echo __('label_rooms_home_kups_front'); ?>
    </div>
    <?php endif; ?>
    <div style="width: 710px; margin-left: auto; margin-right: auto;">
		<div id="kupsList-<?php echo $uuid; ?>" style="height: <?php if ($isInsideRoom == 0) { echo $containerHeight; } else { echo '213px';}?>; width: 704px; overflow: hidden; position:relative; left: 0;" class="kup-list-content"></div>
    </div>
</div>
<script type="text/javascript">
	$(function() {
		$('#kupsList-<?php echo $uuid; ?>').SofunBatch({
			id: 'roomKups_<?php echo $uuid; ?>',
			previousOffset: '<?php echo $previousOffset; ?>', 
			currentOffset: '<?php echo $currentOffset; ?>', 
			nextOffset: '<?php echo $nextOffset; ?>', 
			batchSize: '<?php echo $batchSize; ?>', 
			totalResults: '<?php echo $totalKups; ?>', 
			nbDisplay: '<?php echo $nbDisplay; ?>',
			nbLine: '<?php echo $nbLine; ?>',
			data: {'roomUI' : <?php echo json_encode($sf_data->getRaw('roomUI'))?>},
			elementHeight: '<?php echo $elementHeight; ?>',
			textPager: '<?php echo __('text_slider_kups'); ?>',
			imgPrev: '<?php echo image_tag('/images/kup/home/left.png', array('id'=>'newsfeedLeft','border'=>'0'))?>',
			imgNext: '<?php echo image_tag('/images/kup/home/right.png', array('id'=>'newsfeedRight','border'=>'0'))?>',
			imgLoading: '<?php echo image_tag('/images/wait.gif', array('size' => '16x16', 'style' => 'float:left;' )) ?>',
			ajaxSource: "<?php echo url_for(array('module' => 'kup', 'action' => 'KupsThumbnails', 'module_parent' => $parentModule, 'kup_status' => $kupStatus, 'uuid'=> $uuid, 'is_inside_room' => $isInsideRoom)) ?>"
		});
	});
</script>
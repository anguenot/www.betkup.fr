<?php use_javascript('loading.js') ?>
<?php use_javascript("hash-md5.js") ?>
<?php use_javascript("ajaxQueues.js") ?>
<?php use_javascript('sofunBatch-2.js');?>
<script type="text/javascript">
$(function() {
	$('#bandeRoomsWithKups').SofunBatch({
		id: 'room',
		previousOffset: '<?php echo $previousOffset; ?>', 
		currentOffset: '<?php echo $currentOffset; ?>', 
		nextOffset: '<?php echo $nextOffset; ?>', 
		batchSize: '<?php echo $batchSize; ?>', 
		totalResults: '<?php echo $totalRooms; ?>', 
		nbDisplay: '<?php echo $nbDisplay; ?>',
		nbLine: '<?php echo $nbLine; ?>',
		elementHeigh: '<?php echo $elementHeight; ?>',
		textPager: '<?php echo __('text_slider_kups'); ?>',
		imgPrev: '<?php echo image_tag('/images/kup/home/left.png', array('id'=>'newsfeedGauche','border'=>'0'))?>',
		imgNext: '<?php echo image_tag('/images/kup/home/right.png', array('id'=>'newsfeedGauche','border'=>'0'))?>',
		imgLoading: '<?php echo image_tag('/images/wait.gif', array('size' => '16x16', 'style' => 'float:left;' )) ?>',
		ajaxSource: "<?php echo url_for(array('module' => 'room', 'action' => 'roomsThumbnails', 'module_parent' => $sf_request->getParameter('module'), 'total' => $totalRooms)); ?>"
	});
});
</script>

<div style="width: 716px; margin-left: -5px;">
	<div id="bandeRoomsWithKups" style="height: 900px; width: 716px; overflow: hidden; position:relative;" class="kup-list-content"></div>
</div>
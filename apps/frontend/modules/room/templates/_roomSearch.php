<?php use_javascript('loading.js') ?>
<?php use_javascript('hash-md5.js') ?>
<?php use_javascript("ajaxQueues.js") ?>
<?php use_javascript('sofunBatch-2.js') ?>
<script type="text/javascript">
	$(function() {
		$('#bandeRooms').SofunBatch({
			id: 'roomSearch',
			previousOffset: '<?php echo $previousOffset; ?>', 
			currentOffset: '<?php echo $currentOffset; ?>', 
			nextOffset: '<?php echo $nextOffset; ?>', 
			batchSize: '<?php echo $batchSize; ?>', 
			totalResults: '<?php echo $totalRooms; ?>', 
			nbDisplay: '<?php echo $nbDisplay; ?>',
			nbLine: '<?php echo $nbLine; ?>',
			elementHeigh: '<?php echo $elementHeight; ?>',
			textPager: '<?php echo __('text_slider_kups'); ?>',
			imgPrev: '<?php echo image_tag('/images/kup/home/left.png', array('id'=>'newsfeedLeft','border'=>'0'))?>',
			imgNext: '<?php echo image_tag('/images/kup/home/right.png', array('id'=>'newsfeedRight','border'=>'0'))?>',
			ajaxSource: "<?php echo url_for(array('module' => 'room', 'action' => 'roomsThumbnailsSearch', 'total' => $totalRooms)); ?>"
		});
	});
</script>
<div class="room" style="width: 720px; margin-left: 20px; margin-top: 30px;">
	<div id="bandeRooms" style="width: 720px; height: 650px; overflow: hidden; position:relative;"></div>
</div>
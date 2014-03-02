<div id="contents">
	<div id="widget-container"></div>
</div>
<script type="text/javascript">
$(function() {
	<?php if(count($kupsData) > 0) :?>
	loadWidgetKupRanking();
	<?php endif;?>
});

function loadWidgetKupRanking() {

	var widgetXhr = $.ajax({
			'url' : '<?php echo url_for(array('module' => 'room', 'action' => 'widgetKups')) ?>',
			'type' : 'post',
			'dataType' : 'html',
			'data' : {
				'room_uuid' : '<?php echo $room_uuid?>',
				'urlToLink' : 'http://betkup.fr',
				'kupsData' : <?php echo json_encode($sf_data->getRaw('kupsData'))?>
			},
			'beforeSend' : function() {
				$('#widget-container').loadingModal();
			}
		});

	widgetXhr.done(function(datas) {
		$('#widget-container').loadingModal({'show': false});
		$('#widget-container').html(datas);
	});
}

</script>
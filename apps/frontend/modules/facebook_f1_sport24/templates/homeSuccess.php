<div id="contents">
	<table id="grid">
		<thead></thead>
		<tbody>
			<tr>
				<td id="grid-left">
					<div id="next-race-container">
						<div class="loading-content"></div>
					</div>
					<div id="ranking-container">
						<div class="loading-content"></div>
					</div>

				</td>
				<td id="grid-right">
					<div id="how-to-container">
						<div class="loading-content"></div>
					</div>
					<div id="betkup-promo-container">
						<div class="loading-content"></div>
					</div>
					<div id="news-container">
						<div class="loading-content"></div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script type="text/javascript">
$(function() {
	$('.loading-content', $('#how-to-container')).loadContent({
		'url' : '<?php echo url_for(array('module' => 'facebook_f1_sport24', 'action' => 'homeHowTo')); ?>',
    	'method' : 'GET',
    	'data' : {
        	"kup_uuid" : "<?php echo $kup_uuid ?>",
        	"room_uuid" : "<?php echo $room_uuid ?>"
        }
	}, "resizeCanvas()");
	$('.loading-content', $('#news-container')).loadContent({
		'url' : '<?php echo url_for(array('module' => 'facebook_f1_sport24', 'action' => 'homeNews')); ?>',
    	'method' : 'GET',
    	'data' : {
        	"kup_uuid" : "<?php echo $kup_uuid ?>",
        	"room_uuid" : "<?php echo $room_uuid ?>"
        }
	}, "resizeCanvas()");
	$('.loading-content', $('#next-race-container')).loadContent({
		'url' : '<?php echo url_for(array('module' => 'facebook_f1_sport24', 'action' => 'homeNextRace')); ?>',
    	'method' : 'POST',
    	'data' : {
        	"kup_uuid" : "<?php echo $kup_uuid ?>",
        	"room_uuid" : "<?php echo $room_uuid ?>",
        	"kup_data" : <?php echo json_encode($sf_data->getRaw('kupData')) ?>
        }
	}, "resizeCanvas()");
	$('.loading-content', $('#betkup-promo-container')).loadContent({
		'url' : '<?php echo url_for(array('module' => 'facebook_f1_sport24', 'action' => 'homePromo')); ?>',
    	'method' : 'GET',
    	'data' : {
        	"kup_uuid" : "<?php echo $kup_uuid ?>",
        	"room_uuid" : "<?php echo $room_uuid ?>"
        }
	}, "resizeCanvas()");
	$('.loading-content', $('#ranking-container')).loadContent({
		'url' : '<?php echo url_for(array('module' => 'facebook_f1_sport24', 'action' => 'homeRanking')); ?>',
    	'method' : 'GET',
    	'data' : {
        	"kup_uuid" : "<?php echo $kup_uuid ?>",
        	"room_uuid" : "<?php echo $room_uuid ?>"
        }
	}, "resizeCanvas()");
});
</script>
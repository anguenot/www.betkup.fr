<div class="row-fluid home-container">
	<div class="span1"></div>
	<div class="span6">
		<div class="row-fluid">
		<div class="span12 home-span">
			<div class="tdf-box-title">
				<h1>
					Prochaine étape
				</h1>
				<?php include_component('facebook_tdf', 'chrono', array('kupData' => $kupData, 'chronoId' => 'next-race'))?>
			</div>
			<div id="cycling-next-race-container" class="tdf-box-contents">
				<div class="loading-content"></div>
			</div>
		</div>
		</div>
		<div class="row-fluid">
		<div class="span12 home-span">
			<div class="tdf-box-title">
				<h1>
				Classement
				</h1>
			</div>
			<div id="cycling-ranking-container" class="tdf-box-contents">
				<div class="loading-content"></div>
			</div>
		</div>
		</div>
	</div>
	<div class="span4">
		<div class="row-fluid">
		<div class="span12 home-span">
			<div class="tdf-box-title">
				<h1>
					Comment jouer ?
				</h1>
			</div>
			<div class="tdf-box-contents">
				<?php include_component('facebook_tdf', 'homeBoxHowTo')?>
			</div>
		</div>
		</div>
		<div class="row-fluid">
		<div class="span12 home-span">
			<div class="tdf-box-title">
				<h1>
				Découvrir Betkup
				</h1>
				<?php echo image_tag('/image/default/sport24/betkup_hover.png', array('class' => 'news-logo', 'height' => '25'))?>
			</div>
			<?php include_component('facebook_tdf', 'homePromo')?>
		</div>
		</div>
		<div class="row-fluid">
		<div class="span12 home-span">
			<div class="tdf-box-title">
				<h1>
				Les actus
				</h1>
			</div>
			<div id="news-container" class="tdf-box-contents">
				<div class="loading-content"></div>
			</div>
		</div>
		</div>
	</div>
	<div class="span1"></div>
</div>
<div style="height: 100px;"></div>
<script type="text/javascript">
$(function() {
	$('.loading-content', $('#news-container')).loadContent({
		'url' : '<?php echo url_for(array('module' => 'facebook_tdf', 'action' => 'homeNews')); ?>'
	});

	$('.loading-content', $('#cycling-next-race-container')).loadContent({
		'url' : '<?php echo url_for(array('module' => 'facebook_tdf', 'action' => 'homeNextRace')); ?>',
		'data' : {
        	"kup_uuid" : "<?php echo $kup_uuid ?>",
        	"room_uuid" : "<?php echo $room_uuid ?>",
        	"kup_data" : <?php echo json_encode($sf_data->getRaw('kupData')) ?>
        }
	});

	$('.loading-content', $('#cycling-ranking-container')).loadContent({
		'url' : '<?php echo url_for(array('module' => 'facebook_tdf', 'action' => 'homeRanking')); ?>',
    	'method' : 'GET',
    	'data' : {
        	"kup_uuid" : "<?php echo $kup_uuid ?>",
        	"room_uuid" : "<?php echo $room_uuid ?>"
        }
	});
});
</script>
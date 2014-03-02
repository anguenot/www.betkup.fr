<?php use_stylesheet('f1.css')?>
<?php use_stylesheet('bet.css')?>
<?php use_javascript('jquery.urldecoder.min.js')?>
<?php use_javascript('/scroll/jquery.scroll.js')?>
<?php use_stylesheet('/scroll/css/scrollbar.css')?>
<?php use_javascript('loading.js')?>
<?php use_javascript('serialize-to-json.js')?>
<?php use_javascript('loading-contents-2.js'); ?>
<?php use_javascript('f1.js'); ?>
<div id="f1-rules">
	<div id="f1-grid-left" orientation="top">
		<div class="background-div">
			<div class="f1-title">
				<?php echo __('text_start_grid') ?>
				<div class="image-title-right">
					<?php echo image_tag('/image/default/f1/interface/start_f1.png', array('size' => '63x33', 'style' => 'margin-top: 2px;'))?>
				</div>
			</div>
			<div id="f1-ranking-view-contener-grid" class="f1-contener">
			</div>
			<?php if ($canSavePredictionsGrid) :?>
			<div class="prediction_btn">
				<input class="savePronostic f1-button" type="button" value="Pronostiquer !" onclick="animateDiv('f1-grid-left');"/>
			</div>
			<?php endif ?>
		</div>
	</div>
	<div id="f1-round-left" orientation="left">
		<div class="background-div">
		<div class="f1-title">
			<?php echo __('text_results_best_lap') ?>
			<div class="image-title-right">
				<?php echo image_tag('/image/default/f1/interface/chrono.png', array('size' => '28x40', 'style' => 'margin-top: -7px;'))?>	
			</div>
		</div>
		<div id="f1-ranking-view-contener-round">
		</div>
		</div>
	</div>
	<div id="f1-ranking-right" orientation="right">
		<div class="background-div">
			<div class="f1-title">
				<?php echo __('f1_text_race_ranking') ?>
				<div class="image-title-right">
					<?php echo image_tag('/image/default/f1/interface/podium_full.png', array('size' => '44x22', 'style' => 'margin-top: 2px;'))?>
				</div>
			</div>
			<div id="f1-ranking-view-contener-ranking" class="f1-contener">
			</div>
			<?php if ($canSavePredictionsRace) :?>
			<div class="prediction_btn">
				<input class="savePronostic f1-button" type="button" value="Pronostiquer !" onclick="animateDiv('f1-ranking-right');"/>
			</div>
			<?php endif ?>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function() {
	$('#f1-ranking-view-contener-ranking').loadContent({
		'url' : '<?php echo url_for('f1/homePredictionsRanking');?>',
    	'method' : 'GET',
    	'data' : {
        	'kup_uuid': '<?php echo $kup_uuid ?>', 
        	'room_uuid' : '<?php echo $room_uuid ?>', 
        	'kupData' : <?php echo json_encode($sf_data->getRaw('kupData')) ?>,
        	'kupRoundsData' : <?php echo json_encode($sf_data->getRaw('kupRoundsData')) ?>,
			'publish_url' : '<?php echo $urlToPublish; ?>',
			'roomUI' : <?php echo json_encode($sf_data->getRaw('roomUI')) ?>
        }
	});

	$('#f1-ranking-view-contener-grid').loadContent({
		'url' : '<?php echo url_for('f1/homePredictionsGrid');?>',
    	'method' : 'GET',
    	'data' : {
        	'kup_uuid': '<?php echo $kup_uuid ?>', 
        	'room_uuid' : '<?php echo $room_uuid ?>', 
        	'kupData' : <?php echo json_encode($sf_data->getRaw('kupData')) ?>,
        	'kupRoundsData' : <?php echo json_encode($sf_data->getRaw('kupRoundsData')) ?>,
			'publish_url' : '<?php echo $urlToPublish; ?>',
			'roomUI' : <?php echo json_encode($sf_data->getRaw('roomUI')) ?>
		}
	}); 

	$('#f1-ranking-view-contener-round').loadContent({
		'url' : '<?php echo url_for('f1/homePredictionsBestLap');?>',
    	'method' : 'GET',
    	'data' : {
        	'kup_uuid': '<?php echo $kup_uuid ?>', 
        	'room_uuid' : '<?php echo $room_uuid ?>', 
        	'kupData' : <?php echo json_encode($sf_data->getRaw('kupData')) ?>, 
        	'kupRoundsData' : <?php echo json_encode($sf_data->getRaw('kupRoundsData')) ?>,
			'publish_url' : '<?php echo $urlToPublish; ?>',
			'roomUI' : <?php echo json_encode($sf_data->getRaw('roomUI')) ?>
		}
	}); 
});

function revertDiv(id, callback) {
	$('#'+id).mergeAllWindow({'contener' : 'f1-rules', 'callback' : callback, 'data' : {
		'kup_uuid': '<?php echo $kup_uuid ?>', 
		'room_uuid' : '<?php echo $room_uuid ?>', 
		'kupData' : <?php echo json_encode($sf_data->getRaw('kupData')) ?>, 
		'kupRoundsData' : <?php echo json_encode($sf_data->getRaw('kupRoundsData')) ?>,
		'publish_url' : '<?php echo $urlToPublish; ?>',
		'roomUI' : <?php echo json_encode($sf_data->getRaw('roomUI')) ?>
	}});
}

function animateDiv(id) {
	var params, custom, defaults;

	defaults = {
		'contener' : 'f1-rules',
		'divToAnimate' : ['f1-grid-left', 'f1-round-left', 'f1-ranking-right']
	};
	if(id == 'f1-ranking-right') {
		custom = {
			'oldUrl' : '<?php echo url_for('f1/homePredictionsRanking');?>',
			'urlCallBack' : '<?php echo url_for('f1/predictionsRanking') ?>',
			'data' : {
				'kup_uuid': '<?php echo $kup_uuid ?>', 
				'room_uuid' : '<?php echo $room_uuid ?>', 
				'kupData' : <?php echo json_encode($sf_data->getRaw('kupData')) ?>, 
				'kupRoundsData' : <?php echo json_encode($sf_data->getRaw('kupRoundsData')) ?>,
				'publish_url' : '<?php echo $urlToPublish; ?>',
				'roomUI' : <?php echo json_encode($sf_data->getRaw('roomUI')) ?>
			}
		};
	} else if(id == 'f1-grid-left') {
		custom = {
			'oldUrl' : '<?php echo url_for('f1/homePredictionsGrid');?>',
			'urlCallBack' : '<?php echo url_for('f1/predictionsGrid');?>',
			'data' : {
				'kup_uuid': '<?php echo $kup_uuid ?>', 
				'room_uuid' : '<?php echo $room_uuid ?>', 
				'kupData' : <?php echo json_encode($sf_data->getRaw('kupData')) ?>, 
				'kupRoundsData' : <?php echo json_encode($sf_data->getRaw('kupRoundsData')) ?>,
				'publish_url' : '<?php echo $urlToPublish; ?>',
				'roomUI' : <?php echo json_encode($sf_data->getRaw('roomUI')) ?>
			}
		};
	}
	params = $.extend(custom, defaults);
	
	$('#'+id).removeAllOtherWindow(params);
}
</script>
<?php use_stylesheet('soccer/euroPredictions.css')?>
<?php use_javascript('loading.js')?>
<?php use_javascript('loading-contents-2.js')?>
<?php use_stylesheet('soccer/checkbox.css')?>
<?php use_javascript('jquery.checkbox.min.js')?>
<?php use_javascript('serialize-to-json.js')?>
<?php use_javascript('jquery.urldecoder.min.js')?>
<?php use_javascript('ajaxfileupload.js')?>
<?php use_stylesheet('soccer/selectmenu.css')?>

<div id="full-predictions-container">
	<div id="full-predictions-header">
		<div id="last-predictions">
			<?php if ($lastModified != NULL): ?>
                <div class="date"><?php echo __('label_kup_prediction_last_modified') . ' : ' . util::displayDateCompleteFromTimestampComplet($lastModified) ?></div>
            <?php else:?>
                <div class="date"><?php echo __('label_kup_prediction_none')?></div>
            <?php endif?>
		</div>
		<div id="progress-bar">
			<div id="euro-group-progress-bar" style="cursor: pointer;">
			<div class="progress-bar-number">1</div>
			Phase de groupes
			</div>
			<div id="euro-final-progress-bar" style="cursor: pointer;">
			<div class="progress-bar-number">2</div>
			Phase finale
			</div>
		</div>
	</div>
	<div style="height: 20px;"></div>
	<div id="full-predictions-tree">
		<div class="background"></div>
	</div>
</div>
<script type="text/javascript">
$(function() {
	<?php if($redirectToFinal) :?>
		loadEuroPredictions('<?php echo $urlPredictionsFinal ?>', 'final', 'undefined', 'GET');
	<?php else :?>
		loadEuroPredictions('<?php echo $urlPredictionsGroup ?>', 'group', 'undefined', 'POST');
	<?php endif;?>
	$('#euro-group-progress-bar').click(function() {
		document.location.href = '<?php echo $urlRedirectToView ?>';
		return false;
	});
	$('#euro-final-progress-bar').click(function() {
		loadEuroPredictions('<?php echo $urlPredictionsFinal ?>', 'final', 'undefined', 'GET');
	});
});

function loadEuroPredictions(url, cls, params, type) {
	if(typeof(params) == 'undefined' || params == 'undefined') {
		params = {
			'predictions_ic' : <?php echo json_encode($sf_data->getRaw('predictions_ic')) ?>,
			'kupGamesData' : {},
			'kupData' : <?php echo json_encode($sf_data->getRaw('kupData')) ?>
		};
	}
	if(typeof(type) == 'undefined' ) {
		type = 'GET';
	}
	$('#progress-bar').addClass(cls);
	if(cls == 'group') {
		$('#euro-group-progress-bar').addClass('active');
		$('#euro-final-progress-bar').removeClass('active');
	} else {
		$('#euro-final-progress-bar').addClass('active');
		$('#euro-group-progress-bar').removeClass('active');
	}
	
	$('.background', $('#full-predictions-tree')).loadContent({
		'url' : url,
    	'method' : type,
    	'data' : {
        	'kup_uuid': '<?php echo $kup_uuid?>',
			'kup_rounds_data': <?php echo json_encode($sf_data->getRaw('kupRoundsData')) ?>,
			'predictions_ic': params.predictions_ic,
			'kup_games_data': params.kupGamesData,
			'kupData' : params.kupData
        }
	});
	return false;
}
</script>
<?php use_stylesheet('f1-results.css')?>
<?php use_javascript('jquery.urldecoder.min.js')?>
<?php use_javascript('loading.js')?>
<?php use_javascript('serialize-to-json.js')?>
<?php use_javascript('/scroll/jquery.scroll.js')?>
<?php use_stylesheet('/scroll/css/scrollbar.css')?>
<?php use_javascript('loading-contents-2.js'); ?>
<?php use_javascript('f1.js'); ?>

<div id="results-contener">
	<div id="results-grid">
		<div class="background-div"></div>
	</div>
	<div id="results-ranking">
		<div class="background-div"></div>
	</div>
	<div id="results-best-lap">
		<div class="background-div"></div>
	</div>
	<div id="results-total">
		<div class="background-div"></div>
	</div>
</div>
<div style="height: 60px; width:100%;"></div>
<script type="text/javascript">

$(function(){
	loadAllContent();
});
function loadAllContent(filter) {
	if(typeof(filter) == 'undefined') {
		var filter = '';
	}
    $('.background-div', $('#results-grid')).loadContent({
        'url' : '<?php echo url_for('f1/resultsGrid');?>',
        'method' : 'GET',
        'queue' : true,
        'queueName' : 'betkup_f1_results',
        'data' : {
            'kup_uuid': '<?php echo $kup_uuid ?>',
            'room_uuid' : '<?php echo $room_uuid ?>',
            'kupData' : <?php echo json_encode($sf_data->getRaw('kupData')) ?>,
            'filter' : filter
        }
    }, "<?php echo $fnResizeCanvas != '' ? $fnResizeCanvas : 'loadFacebookGrid()' ?>");

    $('.background-div', $('#results-ranking')).loadContent({
		'url' : '<?php echo url_for('f1/resultsRanking');?>',
    	'method' : 'GET',
        'queue' : true,
        'queueName' : 'betkup_f1_results',
    	'data' : {
        	'kup_uuid': '<?php echo $kup_uuid ?>', 
        	'room_uuid' : '<?php echo $room_uuid ?>', 
        	'kupData' : <?php echo json_encode($sf_data->getRaw('kupData')) ?>,
        	'filter' : filter
        }
	}, "<?php echo $fnResizeCanvas != '' ? $fnResizeCanvas : 'loadFacebookRanking()' ?>" );


	$('.background-div', $('#results-best-lap')).loadContent({
		'url' : '<?php echo url_for('f1/resultsBestLap');?>',
    	'method' : 'GET',
        'queue' : true,
        'queueName' : 'betkup_f1_results',
    	'data' : {
        	'kup_uuid': '<?php echo $kup_uuid ?>', 
        	'room_uuid' : '<?php echo $room_uuid ?>', 
        	'kupData' : <?php echo json_encode($sf_data->getRaw('kupData')) ?>,
        	'filter' : filter
        }
	}, "<?php echo $fnResizeCanvas != '' ? $fnResizeCanvas : '' ?>");
	
	$('.background-div', $('#results-total')).loadContent({
		'url' : '<?php echo url_for('f1/resultsTotalPoint');?>',
    	'method' : 'GET',
        'queue' : true,
        'queueName' : 'betkup_f1_results',
        'executeQueue' : true,
    	'data' : {
        	'kup_uuid': '<?php echo $kup_uuid ?>', 
        	'room_uuid' : '<?php echo $room_uuid ?>', 
        	'kupData' : <?php echo json_encode($sf_data->getRaw('kupData')) ?>,
        	'filter' : filter
        }
	}, "<?php echo $fnResizeCanvas != '' ? $fnResizeCanvas : 'loadFacebookTotalPoints()' ?>");
}
</script>
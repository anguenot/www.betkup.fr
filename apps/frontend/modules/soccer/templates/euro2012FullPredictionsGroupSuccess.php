<form id="euro-group-form" action="" method="post">
	<table id="euro-group-table">
		<tbody>
			<?php $i=0; foreach($kupGamesData as $key => $kupGameData):?>
			<?php if($i==0 || $i==2) :?>
			<tr>
			<?php endif;?>
			<td>
				<div class="full-predictions-title">
					<h2>Groupe <?php echo $key ?></h2>
				</div>
				<table class="euro-group-table-row">
					<?php $j=0; foreach($kupGameData as $gameData) :?>
					<tr>
						<td class="<?php echo ($j%2==1) ? 'even': 'odd' ?>">
						<?php include_component('soccer', 'euro2012FullPredictionsGroupRow', array(
									'kupGameData' => $gameData,
									'predictions_ic'=> $predictions_ic,
									'isActive' => $isActive));?>
						</td>
					</tr>
					<?php $j++; endforeach;?>
				</table>
			</td>
			<?php if($i==1 || $i==3) :?>
			</tr>
			<?php endif;?>
			<?php $i++; endforeach;?>
		</tbody>
	</table>
	<?php if (!$hideButtons): ?>
	<div align="center" style="margin-top: 35px;">
    	<a href="javascript:clearPronostics();" style="text-align: right;">
			<?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/button_erase_pronostics.png', array('style' => 'margin: 5px;', 'class' => 'button', 'size' => '173x34', 'alt' => __('label_rugby_erase_pronostics'))) ?>
		</a>
		<a href="javascript:randomPronostics();" style="text-align: left;">
		    <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/button_fill_randomly.png', array('style' => 'margin: 5px;', 'class' => 'button', 'size' => '173x34', 'alt' => __('label_rugby_fill_randomly'))) ?>
		</a>
    </div>
	<div align="center" style="margin-top: 35px;">
    	<input type="image" src="/image/fr/kup/button_prediction_save.png" />
    </div>
    <div align="center" style="margin-top: 10px; margin-left: 100px; margin-right: 100px">
    	<b>Attention :</b> en cliquant sur "Enregister" vous allez générer un nouveau pronostic. Pour naviguer dans vos pronostics utilser la barre de navigation haute.
    </div>
	<?php else: ?>
    <div align="left" style="margin-top: 20px; width: 710px; height: 65px;">
    	<?php echo __('label_kup_predictions_none') ?>
    </div>
	<?php endif ?>
</form>
<script type="text/javascript">
$(function() {
	$('#euro-group-form').submit(function() {
		var params = {	
			'predictions_ic' : $(this).serializeObject(),
			'kupGamesData' : <?php echo json_encode($sf_data->getRaw('kupGamesData'))?>,
			'kupData' : <?php echo json_encode($sf_data->getRaw('kupData'))?>
		};
		$.ajax({
			url : '<?php echo url_for(array('module' => 'soccer', 'action' => 'isUserConnected'))?>',
			success : function(response) {
				if(response == 'true') {
					return loadEuroPredictions('<?php echo url_for(array('module' => 'soccer', 'action' => 'euro2012FullPredictionsFinal')) ?>', 'final', params, 'POST');
				} else {
					document.location.href = '<?php echo url_for(array('module' => 'account', 'action' => 'login', 'customRedirectUrl' => url_for(array('module' => 'kup', 'action' => 'view', 'uuid' => $kup_uuid)) )) ?>';
					return false;
				}
			}
		});
		return false;
	});

	$('.radio').checkbox({cls: 'radio'});
});

function clearPronostics() {
    //Reset Input
    $("input:not(:disabled)").each(function() {
        $(this).get(0).checked = false;
        $(this).change();
    });
    $('input[value="-1"]:not(:disabled)').attr('checked','checked');
}

function randomPronostics() {
    //Reset Input
    $("input:not(:disabled)").each(function() {
        $(this).get(0).checked = false;
        $(this).change();
    });
    //Set random checked radio
	for ( var int = 0; int < $('div.match-active').length; int++) {
        var nbInput = $('div.match-active:eq('+int+') table tr td input[name^="predictions"]').length;
        var randomInput = Math.ceil(Math.random()*(nbInput-1));
        if(randomInput == '0'){
        	randomInput = '1';
        }
        $('div.match-active:eq('+int+') table tr td input:eq('+(randomInput)+')').attr('checked','checked');
	}
}
</script>
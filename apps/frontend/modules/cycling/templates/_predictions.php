<?php use_stylesheet('cycling/predictions.css') ?>
<?php use_stylesheet('cycling/selectmenu.css') ?>
<div class="fix-margin">
	<div style="height: 10px;"></div>
	<?php if ($kupData['name'] != 'La grande Boucle'): ?>
	<div id="cycling-header-infos">
		<table id="cycling-header-infos-table">
			<tbody>
				<tr>
					<td class="td-margin"></td>
					<td class="td-text">
						<table>
							<tr>
								<td class="icon">
									<span class="icon-steps"></span>
								</td>
								<td>
									<p>
										<span class="underline">Etape : </span>
										<?php echo $kupRoundData['properties']['displayName']?>
									</p>
								</td>
							</tr>
						</table>
					</td>
					<td class="td-text">
						<table>
							<tr>
								<td class="icon">
									<span class="icon-departure"></span>
								</td>
								<td>	
									<p>
										<span class="underline">Départ : </span>
										<?php echo $kupRoundData['properties']['displayStart']?>
									</p>
								</td>
							</tr>
						</table>
					</td>
					<td class="td-text td-km">
						<table>
							<tr>
								<td class="icon">
									<span class="icon-distance"></span>
								</td>
								<td>	
									<p>
										<span class="underline">Km : </span>
										<?php echo $kupRoundData['properties']['displayDistance']?>
									</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="td-margin"></td>
					<td class="td-text">
						<table>
							<tr>
								<td class="icon">
									<span class="icon-<?php echo str_replace(' ', '-', $kupRoundData['properties']['displayType']); ?>"></span>
								</td>
								<td>	
									<p>
										<span class="underline">Type : </span>
										<?php echo $kupRoundData['properties']['displayType']?>
									</p>
								</td>
							</tr>
						</table>
					</td>
					<td class="td-text">
						<table>
							<tr>
								<td class="icon">
									<span class="icon-arival"></span>
								</td>
								<td>	
									<p>
										<span class="underline">Arrivé : </span>
										<?php echo $kupRoundData['properties']['displayEnd']?>
									</p>
								</td>
							</tr>
						</table>
					</td>
					<td class="td-text td-km"></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="height: 20px;"></div>
	<?php endif ?>
	<?php if (count($kupRoundsData) > 1 && $kupData['name'] == 'Étape par Étape'): ?>
	<div id="stage-choice">
		<select name="roundUUID" id="roundUUIDSelect" class="cycling-select">
			<option value="">Choisir une étape</option>
			<?php foreach ($kupRoundsData as $one) : ?>
			<option value="<?php echo $one['uuid']?>" <?php echo $one['uuid'] == $kupRoundData['uuid'] ? 'selected="selected"': '' ?>><?php echo $one['name']?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<?php endif ?>
	
	<form action="" method="post" name="cycling_form" id="cycling_form">
	
		<div id="cycling-jersey">
			<?php include_component('cycling', 'predictionJersey', array(
									'kupData' => $kupData, 
									'choices' => $racers, 
									'class' => 'racers', 
									'predictionsTdfMaillotJaune' => $predictionsTdfMaillotJaune,
									'predictionsTdfMaillotBlanc' => $predictionsTdfMaillotBlanc,
									'predictionsTdfMaillotVert' => $predictionsTdfMaillotVert,
									'predictionsTdfMaillotApois' => $predictionsTdfMaillotApois
			
			))?>
			<div style="height: 20px;"></div>
			<?php if (count($kupRoundData) > 0 && $kupRoundData['startDate'] > time() . '000'): ?>
	    	<input style="display: block; width: 101px; margin: 0px auto;" type="image" title="" src="/image/default/tdf/interface/save.png" />
	    	<?php endif ?>
	    	<div style="height: 20px;"></div>
		</div>
		<div id="cycling-podium">
			<?php include_component('cycling', 'predictionPodium', array(
									'podiumTitle' => ($kupData['name'] == 'La grande Boucle') ? 'Podium individuel à l\'issue du Tour de France' : 'Podium individuel à l\'issue de l\'étape', 
									'kupData' => $kupData, 
									'choices' => $racers, 
									'class' => 'racers', 
									'predictionsTdfPodiumIndividual' => $predictionsTdfPodiumIndividual
			))?>
			<div style="height: 50px;"></div>
			<?php if (count($kupRoundData) > 0 && $kupRoundData['startDate'] > time() . '000'): ?>
	    	<input style="display: block; width: 101px; margin: 0px auto;" type="image" title="" src="/image/default/tdf/interface/save.png" />
	    	<?php endif ?>
	    	<div style="height: 20px;"></div>
		</div>
		<div id="cycling-podium-team">
			<?php include_component('cycling', 'predictionPodiumTeam', array(
									'podiumTitle' => ($kupData['name'] == 'La grande Boucle') ? 'Podium par équipe à l\'issue du Tour de France' : 'Podium par équipe à l\'issue de l\'étape', 
									'kupData' => $kupData, 
									'choices' => $teams, 
									'class' => 'teams', 
									'predictionsTdfPodiumTeam' => $predictionsTdfPodiumTeam
			)) ?>
			<div style="height: 100px;"></div>	
			<?php if(isset($kupData['config']) && isset($kupData['config']['tb']) && $kupData['config']['tb'] != '' ) :?>
			<?php include_component('cycling', 'predictionQuestion', array(
									'kupData' => $kupData,
									'choices' => $racers,
									'predictionsTb' => $predictionsTb
			))?>
			<div style="height: 70px;"></div>
			<?php endif;?>
			<?php if (count($kupRoundData) > 0 && $kupRoundData['startDate'] > time() . '000'): ?>
			<div class="buttons">
				<a href="javascript:clearPronostics();" style="text-align: right;">
			        <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/button_erase_pronostics.png', array('style' => 'margin: 5px;', 'class' => 'button', 'size' => '173x34', 'alt' => __('label_rugby_erase_pronostics'))) ?>
			    </a>
			    <a href="javascript:randomPronostics();" style="text-align: left;">
			        <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/button_fill_randomly.png', array('style' => 'margin: 5px;', 'class' => 'button', 'size' => '173x34', 'alt' => __('label_rugby_fill_randomly'))) ?>
			    </a>
		    <div style="height: 20px;"></div>
	    	<input type="image" title="" src="<?php echo '/image/' . $sf_user->getCulture() . '/kup/button_prediction_save.png' ?>" />
	    	<?php endif ?>
	    	<div style="height: 50px;"></div>
	    </div>
		</div>
	    
    </form>
</div>
<script type="text/javascript">
$(function() {
	var textFormatting = function(text) {
		var newText = new Array();
		newText = text.split(' - ');
		if(newText.length > 1) {
    		if(newText[1] == 'F') {
    			return '<div style="width: 5px; height: 20px; line-height: 20px; background-color: #EA705A; color: #FFFFFF; text-align: center; float: left;"></div><span style="margin-left: 10px; display: inline; font-size: 14px;">'+newText[0]+'</span>';
    		} else {
    			return '<div style="width: 5px; height:20px; line-height: 20px; background-color: #B4C810; color: #FFFFFF; text-align: center; float: left;"></div><span style="margin-left: 10px; display: inline; font-size: 14px;">'+newText[0]+'</span>';
            }
		} else {
			return '<span style="display: inline; font-size: 14px;">'+text+'</span>';
		}
	};
	
	$("#roundUUIDSelect").selectmenu({
		style:'dropdown', 
		width: 180,
		menuWidth: 180,
		maxHeight: 200
	});

	$("#roundUUIDSelect").change(function() {
		<?php if($room_uuid != '') : ?>
		document.location.href = '<?php echo url_for(array('module' => 'room', 'action' => 'kupView', 'room_uuid' => $room_uuid, 'kup_uuid' => $kup_uuid))?>?roundUUID='+$(this).val();
		<?php else :?>
		document.location.href = '<?php echo url_for(array('module' => 'kup', 'action' => 'view', 'uuid' => $kup_uuid))?>?roundUUID='+$(this).val();
		<?php endif;?>
	});

	$('.cycling-prediction-select').selectmenu({
		style:'dropdown', 
		width: 190,
		menuWidth: 190,
		maxHeight: 200,
		icons: [{find: '.cycling-selectmenu-icon'}]
	});
	
});

function clearPronostics() {
    var arrayLabelByDefault = new Array;

    //Get all first select items
    for ( var int = 0; int < $('select[id^="predictions"]:not(:disabled)').length; int++) {
    	arrayLabelByDefault.push($('select[id^="predictions"]:not(:disabled)').eq(int).attr('id'));
    }

    //Set all new first select items
	for ( var int = 0; int < arrayLabelByDefault.length; int++) {
    	var backToZero = arrayLabelByDefault[int].split(':');
		$('select[id='+backToZero[0]+']:not(:disabled) option:selected').removeAttr('selected');
		$('select[id='+backToZero[0]+']:not(:disabled) option:eq(0)').attr('selected','');
		$('select[id='+backToZero[0]+']:not(:disabled)').selectmenu();
		$('select[id='+backToZero[0]+']:not(:disabled)').trigger('change');
	}
}

function randomPronostics() {
    var arrayLabelByDefault = new Array;

    //Get random select items
    for ( var int = 0; int < $('select[id^="predictions"]:not(:disabled)').length; int++) {
        var nbOption = $('select[id^="predictions"]:not(:disabled):eq('+int+') option').length;
        var randomOption = Math.ceil(Math.random()*nbOption);
        if(randomOption == '1'){
            randomOption = '2';
        }
    	arrayLabelByDefault.push($('select[id^="predictions"]:not(:disabled)').eq(int).attr('id')+':'+(randomOption-1));
    }

    //Set all new first select items
	for ( var int = 0; int < arrayLabelByDefault.length; int++) {
    	var randomValue = arrayLabelByDefault[int].split(':');
		$('select[id='+randomValue[0]+']:not(:disabled) option:selected').removeAttr('selected');
		$('select[id='+randomValue[0]+']:not(:disabled) option:eq('+randomValue[1]+')').attr('selected','');
		$('select[id='+randomValue[0]+']:not(:disabled)').selectmenu();
		$('select[id='+randomValue[0]+']:not(:disabled)').trigger('change');
	}
}
</script>


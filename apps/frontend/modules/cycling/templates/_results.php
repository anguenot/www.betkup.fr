<?php use_stylesheet('cycling/predictions.css')?>
<?php use_stylesheet('cycling/results.css')?>
<?php use_stylesheet('cycling/selectmenu.css')?>
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
<?php if (count($kupRoundsData) > 1): ?>
	<div id="stage-choice">
        <select name="roundUUID" id="roundUUIDSelect" class="cycling-select">
			<option value="">Choisir une étape</option>
			<?php foreach ($kupRoundsData as $one) : ?>
			<option value="<?php echo $one['uuid']?>" <?php echo $one['uuid'] == $kupRoundData['uuid'] ? 'selected="selected"': '' ?>>
                <?php echo $one['status'] == 'SCHEDULED' ? $one['name'].'#F#' : $one['name'].'#V#'; ?>
            </option>
			<?php endforeach; ?>
		</select>
	</div>
<?php endif ?>
<div style="height: 20px;"></div>
<div id="results-cycling-container">
	<div id="results-cycling-maillots">
		<div class="result-cycling-title">
			<h1>Résultats maillots :</h1>
		</div>
		<?php include_component('cycling', 'resultRow', array(
								'resultsData' => $resultsJersey,
								'comboLabel' => 'COMBO MAILLOT'))?>
	</div>
	<div id="results-cycling-podium-individual">
		<div class="result-cycling-title">
			<h1>Résultats podium individuel :</h1>
		</div>
		<?php include_component('cycling', 'resultRow', array(
								'resultsData' => $resultsPodiumIndividual, 
								'comboLabel' => 'COMBO PODIUM INDIVIDUEL'))?>
	</div>
	<div id="results-cycling-podium-team">
		<div class="result-cycling-title">
			<h1>Résultats podium par équipe :</h1>
		</div>
		<?php include_component('cycling', 'resultRow', array(
								'resultsData' => $resultsPodiumTeam, 
								'comboLabel' => 'COMBO PODIUM PAR EQUIPE'))?>
	</div>
	<div id="results-cycling-question">
	
	</div>
	<div id="results-cycling-total">
	
	</div>
</div>

<script type="text/javascript">
$(function() {
	var textFormatting = function(text) {
		var newText = new Array();
		newText = text.split('#');

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
        format: textFormatting,
		width: 230,
		menuWidth: 230,
		maxHeight: 200
	});

	$("#roundUUIDSelect").change(function() {
		<?php if(isset($customRoundUrl)): ?>
        document.location.href = '<?php echo $customRoundUrl ?>?roundUUID='+$(this).val();
        <?php elseif($room_uuid != '') : ?>
		document.location.href = '<?php echo url_for(array('module' => 'room', 'action' => 'kupResults', 'room_uuid' => $room_uuid, 'kup_uuid' => $kup_uuid))?>?roundUUID='+$(this).val();
		<?php else :?>
		document.location.href = '<?php echo url_for(array('module' => 'kup', 'action' => 'results', 'uuid' => $kup_uuid))?>?roundUUID='+$(this).val();
		<?php endif;?>
	});
});

</script>
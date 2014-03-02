<div class="result">
	<div class="round-select" align="left">
            <div style="float: right; margin-right:5px;">
            <?php if (count($kupRoundsData) > 0): ?>
                <form name="kupPredictionRound" method="get" action="">
                    <select id="roundUUIDSelect" class="formInputSelect" name="roundUUID" style="margin-top: 20px; width: 140px;" onChange="document.kupPredictionRound.submit();">
                    <?php foreach ( $kupRoundsData as $round ): ?>
                    <?php if ($roundUUID == $round['uuid']): ?>
                    	<option value="<?php echo $round['uuid'] ?>" selected="selected"><?php echo __($round['name']) ?></option>
                    <?php else: ?>
                    	<option value="<?php echo $round['uuid'] ?>"><?php echo __($round['name']) ?></option>
                    <?php endif ?>
                    <?php endforeach ?>
                    </select>
                </form>
            <?php endif ?>
            </div>
    </div>
    <?php if (count($kupGamesData) > 0): ?>
	<table>
		<thead>
			<tr>
				<th class="thead-1">
					<?php echo __('label_kup_result_event') ?>
				</th>
				<th class="thead-2">
					<?php echo __('label_kup_result_bet') ?>
				</th>
				<th class="thead-3">
				<?php echo __('label_kup_result_official_bet') ?>
				</th>
				<th class="thead-4">
					<?php echo __('label_kup_result_result_bet') ?>
				</th>
				<th class="thead-5">
					<?php echo __('label_kup_result_points') ?>
				</th>
				<th class="thead-6">
					<?php echo __('label_kup_result_percentage_correct_answer') ?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $kupGamesData as $key => $kupGameData ): ?>
		<?php if ($kupGameData['type'] == 'ic'): ?>
		<?php include_component('kup', 'resultRow', array(
            'type' => $kupGameData['choc'] == 'yes' ? 'choc' : '',
            'orange' => '',
            'titleType' => 'array',
            'title' => array(
                'equipe1' => $kupGameData['team1title'],
                'avatar1' => $kupGameData['team1avatar'],
                'equipe2' => $kupGameData['team2title'],
                'avatar2' => $kupGameData['team2avatar']),
            'pronostic' =>
				$kupGameData['prediction'] == 1 ? $kupGameData['team1title'] : (
				$kupGameData['prediction'] == 2 ? __('label_prediction_draw') : (
				$kupGameData['prediction'] == 3 ? $kupGameData['team2title'] : (
				$kupGameData['prediction'] == -1 ? __('label_no_prediction') : (
				$kupGameData['prediction'])))),
            'resultatOfficiel' => $kupGameData['winnerTitle'],
            'resultatPronostic' => $kupGameData['predictionResult'],
            'points' => isset($kupGameData['points']) && $kupGameData['points'] != '-'  ? $kupGameData['points'] . ' pts' : '-',
            'bonnesReponses' => '-',
			'index' => $key
		)) ?>
		<?php elseif ($kupGameData['type'] == 'se'): ?>
		<?php include_component('kup', 'resultRow', array(
	            'type' => $kupGameData['choc'] == 'yes' ? 'choc' : '',
	            'orange' => '',
	            'titleType' => 'array',
	            'title' => array(
	                'equipe1' => $kupGameData['team1title'],
	                'avatar1' => $kupGameData['team1avatar'],
	                'equipe2' => $kupGameData['team2title'],
	                'avatar2' => $kupGameData['team2avatar'],
		),
	            'pronostic' => $kupGameData['prediction'],
	            'resultatOfficiel' => $kupGameData['scoreTeam1'] . ' - ' . $kupGameData['scoreTeam2'],
	            'resultatPronostic' => $kupGameData['predictionResult'],
	            'points' => isset($kupGameData['points']) && $kupGameData['points'] != '-' ? $kupGameData['points'] . ' pts' : '-',
	            'bonnesReponses' => '-',
				'index' => $key
		)) ?>
		<?php elseif ($kupGameData['type'] == 'q'): ?>
		<?php include_component('kup', 'resultRow', array(
            'type' => $kupGameData['choc'] == 'yes' ? 'choc' : '',
            'orange' => $kupGameData['title'],
            'titleType' => 'string',
            'title' => $kupGameData['question'],
            'pronostic' => $kupGameData['predictionTitle'],
            'resultatOfficiel' => $kupGameData['answerTitle'],
            'resultatPronostic' => $kupGameData['predictionResult'],
            'points' => isset($kupGameData['points']) && $kupGameData['points'] != '-' ? $kupGameData['points'] . ' pts' : '-',
            'bonnesReponses' => '-',
			'index' => $key
		)) ?>
		<?php endif ?>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php else: ?>
	<div class="no-results" align="left">
	<a href="<?php echo (isset($kupViewUrl)) ? $kupViewUrl : url_for(array('module'=>'kup', 'action'=>'view', 'uuid' => $uuid)) ?>">
	<?php echo __('label_kup_results_none') ?>
	</a>
	</div>
	<?php endif ?>
</div>
<script type="text/javascript">
$(function() {
	$("#roundUUIDSelect").selectmenu({style:'dropdown',width: 140, menuWidth: 140});
});
</script>
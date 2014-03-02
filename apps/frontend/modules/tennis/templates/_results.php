<?php use_stylesheet('results.css')?>
<?php use_stylesheet('tennis/selectmenu.css')?>
<?php use_stylesheet('tennis/results.css')?>
<?php use_javascript('jquery.urldecoder.min.js')?>
<div class="result">
	<div align="left" style="margin-top: 0px; width: 720px; height: 45px;">
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
				<th>Resultats</th>
				<th width="170">Pronostic</th>
				<th width="70">Résultat pronostic</th>
				<th width="70">Points</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $kupGamesData as $key => $kupGameData ): ?>
			<?php include_component('tennis', 'resultRow', 
					array(	
			            'predictions' => '',
			            'resultSets' => $resultSets,
			            'predictionResults' => '',
						'index' => $key,
						'kupGameData' => $kupGameData
						)
					) ?>
		<?php endforeach;?>
		</tbody>
		<tfoot>
		</tfoot>
	</table>
	<?php else :?>
	<div align="left" style="margin-top: 20px; width: 710px; height: 65px;">
		<a href="<?php echo url_for(array('module'=>'kup', 'action'=>'view', 'uuid' => $uuid)) ?>">
			<?php echo __('label_kup_results_none') ?>
		</a>
	</div>
	<?php endif;?>
</div>
<script type="text/javascript">
$(function() {
	$('#roundUUIDSelect').selectmenu({
		style:'dropdown',
		width: 140, 
		menuWidth: 140
	});
});
</script>
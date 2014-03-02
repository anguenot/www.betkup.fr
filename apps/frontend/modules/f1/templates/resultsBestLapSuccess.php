<div class="title-results">
	<table>
		<tr>
			<td style="text-align: center;" width="80">
				<?php echo image_tag('/image/default/f1/interface/chrono.png', array('size' => '28x40'))?>
			</td>
			<td>
				<?php echo __('text_results_best_lap')?>
			</td>
		</tr>
	</table>
</div>
<table class="table-results-content">
	<thead>
		<tr>
			<th class="resultsTheader" width="50"></th>
			<th class="resultsTheader" width="245"><?php echo __('text_your_prediction')?></th>
			<th class="resultsTheader" width="245"><?php echo __('text_official_results')?></th>
			<th class="resultsTheader" width="90"><?php echo __('text_results')?></th>
			<th class="resultsTheader" width="90"><?php echo __('text_results_points')?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="2" class="left predictions">
				<table>
					<tr>
						<td width="45">
							<?php echo (isset($predictions['uuid'])) ? image_tag($predictions['helmet'], array('height' => '27')) : image_tag('/image/default/f1/interface/default_helmet.png', array('height' => '27'))?>
						</td>
						<td>
							<div title="<?php echo (isset($predictions['uuid'])) ? $predictions['driver'] : '' ?>">
								<b>
									<?php echo (isset($predictions['uuid'])) ? Util::coupe($predictions['driver'], 18, '..') : __('label_kup_no_predictions_saved') ?>
								</b>
							</div>
							<div title="<?php echo (isset($predictions['uuid'])) ? $predictions['team'] : '' ?>">
								<?php echo (isset($predictions['uuid'])) ? Util::coupe($predictions['team'], 28, '..') : '' ?>
							</div>
						</td>
					</tr>
				</table>
			</td>
			<td class="left results">
				<table>
					<tr>
						<td width="45">
							<?php echo (isset($results[0])) ? image_tag($results[0]['helmet'], array('height' => '27')) : image_tag('/image/default/f1/interface/default_helmet.png', array('height' => '27'))?>
						</td>
						<td>
							<div title="<?php echo (isset($results[0])) ? $results[0]['driver'] : '' ?>">
								<b>
									<?php echo (isset($results[0])) ? Util::coupe($results[0]['driver'], 18, '..') : __('label_kup_no_results') ?>
								</b>
							</div>
							<div title="<?php echo (isset($results[0])) ? $results[0]['team'] : '' ?>">
								<?php echo (isset($results[0])) ? Util::coupe($results[0]['team'], 28, '..') : '' ?>
							</div>
						</td>
					</tr>
				</table>
			</td>
			<td class="left">
				<?php echo(isset($predictions['uuid']) && isset($results[0]) && $results[0]['uuid'] == $predictions['uuid']) ? image_tag('/image/default/f1/results/right.png', array('size' => '26x24')) : image_tag('/image/default/f1/results/wrong.png', array('size' => '26x24')) ?>
			</td>
			<td>
				<span>
					<?php echo (isset($predictions['uuid']) && isset($predictions['results']['points'])) ? $predictions['results']['points'].' pts' : '-' ?>
				</span>
			</td>
		</tr>
	</tbody>
</table>
<div style="height: 20px; width:100%;"></div>
<table class="results-cycling-table">
	<thead>
		<tr>
			<th>Issue</th>
			<th width="180">Votre pronostic</th>
			<th width="180">Classement officiel</th>
			<th width="90">Resultats</th>
			<th width="90">Points</th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($resultsData) > 0) :?>
		
		<?php $i=0; foreach($resultsData as $data) :?>
			<tr>
				<td class="<?php echo $data['class'] != '' ? $data['class']: '' ?> border-right">
					<p>
						<?php echo $data['typeName']?>
					</p>
				</td>
				<td class="border-right">
					<?php if(isset($data['predictions']) && count($data['predictions']) > 0 ) :?>
					<table class="racer">
						<tr>
							<td>
								<?php echo image_tag("/image/default/tdf/flag/" . $data['predictions']['nationality'], array('height' => '20', 'width' => '20'))?>
							</td>
							<td>
								<h4>
								<?php echo $data['predictions']['driver']?>
								</h4>
							</td>
						</tr>
					</table>
					<?php else :?>
					<p>
						Aucun pronostics
					</p>
					<?php endif;?>
				</td>
				<td class="border-right">
					<table class="racer">
						<tr>
							<td>
								<?php echo image_tag("/image/default/tdf/flag/" . $data['nationality'], array('height' => '20', 'width' => '20'))?>
							</td>
							<td>
								<h4>
								<?php echo $data['driver']?>
								</h4>
							</td>
						</tr>
					</table>
				</td>
				<td class="border-right">
					<p>
					<?php if(isset($data['predictions']) && isset($data['predictions']['results'])) :?>
					<?php else :?>
						<span class="cycling-result-cross cycling-result-status"></span>
					<?php endif;?>
					</p>
				</td>
				<td>
					<p>
						<?php echo isset($data['predictions']) && isset($data['predictions']['results']) ? $data['predictions']['results']['points'] : '-' ?>
					</p>
				</td>
			</tr>
		<?php $i++; endforeach;?>
		<?php endif;?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">
				<h2>
				<?php echo $comboLabel ?>
				</h2>
			</td>
			<td></td>
			<td></td>
		</tr>
	</tfoot>
</table>
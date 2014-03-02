<div class="cycling-title">
	<div class="cycling-title-picto cycling-podium"></div>
	<h1>
		Podium individuel
	</h1>
</div>
<div class="cycling-container">
	<div class="cycling-podium-title">
		<h2>
			<?php echo $podiumTitle ?>
		</h2>
	</div>
	<table id="cycling-jersey-table">
		<tbody>
			<tr>
				<td>
					<?php include_component('cycling', 'predictionChoice', array(
											'prefix' => 'tdf', 
											'imgDefault' => '/image/default/tdf/jersey/maillot_default.png',
											'imgSize' => '87x103',
											'type' => 'podium_individual', 
											'value' => 'podium_individual_2', 
											'class' => $class, 
											'predictions' => isset($predictionsTdfPodiumIndividual['tdf_podium_individual_2']) ? $predictionsTdfPodiumIndividual['tdf_podium_individual_2'] : array(), 
											'choices' => $choices))?>
				</td>
				<td class="cycling-podium-1">
					<?php include_component('cycling', 'predictionChoice', array(
											'prefix' => 'tdf', 
											'imgDefault' => '/image/default/tdf/jersey/maillot_default.png',
											'imgSize' => '87x103',
											'type' => 'podium_individual', 
											'value' => 'podium_individual_1', 
											'class' => $class, 
											'predictions' => isset($predictionsTdfPodiumIndividual['tdf_podium_individual_1']) ? $predictionsTdfPodiumIndividual['tdf_podium_individual_1'] : array(), 
											'choices' => $choices))?>
				</td>
				<td>
					<?php include_component('cycling', 'predictionChoice', array(
											'prefix' => 'tdf', 
											'imgDefault' => '/image/default/tdf/jersey/maillot_default.png',
											'imgSize' => '87x103',
											'type' => 'podium_individual', 
											'value' => 'podium_individual_3', 
											'class' => $class, 
											'predictions' => isset($predictionsTdfPodiumIndividual['tdf_podium_individual_3']) ? $predictionsTdfPodiumIndividual['tdf_podium_individual_3'] : array(), 
											'choices' => $choices))?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
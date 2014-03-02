<div class="cycling-title">
	<div class="cycling-title-picto cycling-podium"></div>
	<h1>
		Podium par équipe
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
											'imgDefault' => '/image/default/tdf/team/maillot_default.png',
											'imgSize' => '173x121',
											'type' => 'podium_team', 
											'value' => 'podium_team_2',
											'class' => $class,
											'predictions' => isset($predictionsTdfPodiumTeam['tdf_podium_team_2']) ? $predictionsTdfPodiumTeam['tdf_podium_team_2'] : array(), 
											'choices' => $choices))?>
				</td>
				<td class="cycling-podium-1">
					<?php include_component('cycling', 'predictionChoice', array(
											'prefix' => 'tdf', 
											'imgDefault' => '/image/default/tdf/team/maillot_default.png',
											'imgSize' => '173x121',
											'type' => 'podium_team', 
											'value' => 'podium_team_1',
											'class' => $class, 
											'predictions' => isset($predictionsTdfPodiumTeam['tdf_podium_team_1']) ? $predictionsTdfPodiumTeam['tdf_podium_team_1'] : array() , 
											'choices' => $choices))?>
				</td>
				<td>
					<?php include_component('cycling', 'predictionChoice', array(
											'prefix' => 'tdf', 
											'imgDefault' => '/image/default/tdf/team/maillot_default.png',
											'imgSize' => '173x121',
											'type' => 'podium_team', 
											'value' => 'podium_team_3',
											'class' => $class, 
											'predictions' => isset($predictionsTdfPodiumTeam['tdf_podium_team_3']) ? $predictionsTdfPodiumTeam['tdf_podium_team_3'] : array(), 
											'choices' => $choices))?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
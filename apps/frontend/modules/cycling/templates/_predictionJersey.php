<div class="cycling-title">
	<div class="cycling-title-picto cycling-jersey"></div>
	<h1>
		Maillots
	</h1>
</div>
<div class="cycling-container">
	<table id="cycling-jersey-table">
		<tbody>
			<tr>
				<td colspan="2">
					<?php include_component('cycling', 'predictionChoice', array(
											'jersey' => '/image/default/tdf/jersey/maillot_jaune.png', 
											'title' =>  ($kupData['name'] == 'La grande Boucle') ? 'Maillot jaune<br /> à l\'issue du Tour de France' : 'Maillot jaune<br />à l\'issue de l\'étape', 
											'prefix' => 'tdf', 
											'type' => 'maillot_jaune',
											'value' => 'tdf_maillot_jaune', 
											'class' => $class, 
											'predictions' => $predictionsTdfMaillotJaune, 
											'choices' => $choices))?>
				</td>
			</tr>
			<tr>
				<td>
					<?php include_component('cycling', 'predictionChoice', array(
											'jersey' => '/image/default/tdf/jersey/maillot_blanc.png',
											'prefix' => 'tdf', 
											'title' => ($kupData['name'] == 'La grande Boucle') ? 'Maillot blanc<br /> à l\'issue du Tour de France' : 'Maillot blanc<br />à l\'issue de l\'étape', 
											'type' => 'maillot_blanc', 
											'value' => 'tdf_maillot_blanc',
											'class' => $class, 
											'predictions' => $predictionsTdfMaillotBlanc, 
											'choices' => $choices))?>
				</td>
				<td>
					<?php include_component('cycling', 'predictionChoice', array(
											'jersey' => '/image/default/tdf/jersey/maillot_vert.png',
											'prefix' => 'tdf', 
											'title' => ($kupData['name'] == 'La grande Boucle') ? 'Maillot vert<br /> à l\'issue du Tour de France' : 'Maillot vert<br />à l\'issue de l\'étape', 
											'type' => 'maillot_vert', 
											'value' => 'tdf_maillot_vert',
											'class' => $class, 
											'predictions' => $predictionsTdfMaillotVert, 
											'choices' => $choices))?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php include_component('cycling', 'predictionChoice', array(
											'jersey' => '/image/default/tdf/jersey/maillot_apoits.png',
											'prefix' => 'tdf', 
											'title' => ($kupData['name'] == 'La grande Boucle') ? 'Maillot à pois<br /> à l\'issue du Tour de France' : 'Maillot à pois<br />à l\'issue de l\'étape', 
											'type' => 'maillot_apois', 
											'value' => 'tdf_maillot_apois',
											'class' => $class, 
											'predictions' => $predictionsTdfMaillotApois, 
											'choices' => $choices))?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
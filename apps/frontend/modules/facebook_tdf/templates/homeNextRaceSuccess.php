<div class="br-small"></div>
<div class="row-fluid">
	<div class="span12">
		<h1 class="upper">
			<?php echo $kupData['name'] ?>
		</h1>
	</div>
</div>
<div class="row-fluid">
	<div class="span12 image-container">
		<?php echo image_tag(isset($kupData['ui']['vignette_kup_step']) ? $kupData['ui']['vignette_kup_step'] : '/image/default/sport24/race.png', array('size' => '418x232'))?>
	</div>
</div>
<div class="row-fluid race-infos">
	<div class="span6 ">
		<table>
			<tbody>
				<tr>
					<td>
						<h6>Date de l'étape</h6>
						<h3 class="colored">
							<?php echo (isset($kupRoundData['startDate'])) ? util::displayDateFormated($kupRoundData['startDate']) : ''; ?>
						</h3>
					</td>
				</tr>
				<tr>	
					<td>
						<h6>Distance à parcourir</h6>
						<h3 class="colored">
							<?php echo $kupRoundData['properties']['displayDistance'] ?> km
						</h3>
					</td>
				</tr>
				<tr>	
					<td>
						<h6>Type de terrain</h6>
						<h3 class="colored upper">
							<?php echo $kupRoundData['properties']['displayType'] ?>
						</h3>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="span6">
		<table>
			<tbody>
				<tr>
					<td>
						<h6>Départ</h6>
						<h3 class="colored upper">
							<?php echo $kupRoundData['properties']['displayStart'] ?>
						</h3>
					</td>
				</tr>
				<tr>
					<td>
						<h6>Arrivée</h6>
						<h3 class="colored upper">
							<?php echo $kupRoundData['properties']['displayEnd'] ?>
						</h3>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="br-small"></div>
<div class="button-box">
	<a class="button-link" href="<?php echo url_for(array('module' => 'facebook_tdf', 'action' => 'predictions')) ?>">
	Pronostiquer !
	</a>
</div>
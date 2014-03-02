<div class="header">
	<div class="header-fixed">
		<div id="header-logo"></div>
		<div id="header-logo-betkup"></div>
		<div class="tdf-progress-bar">
			<table id="tdf-progress-bar-text-table">
				<tbody>
					<tr>
						<td>Installer l'application</td>
						<td>Devenir fan</td>
						<td>Pronostiquer</td>
						<td>Revenir</td>
					</tr>
				</tbody>
			</table>
			<div class="progress progress-warning progress-striped">
				<div class="bar" style="width: <?php echo $progress ?>%;">
					<span><?php echo $progress ?>%</span>
				</div>
			</div>
			<table id="tdf-progress-bar-picto-table">
				<tbody>
					<tr>
						<td>
							<div class="<?php echo $progress >= 25 ? "progress-picto-selected" : "progress-picto" ?>"></div>
						</td>
						<td>
							<div class="<?php echo $progress >= 50 ? "progress-picto-selected" : "progress-picto" ?>"></div>
						</td>
						<td>
							<div class="<?php echo $progress >= 75 ? "progress-picto-selected" : "progress-picto" ?>"></div>
						</td>
						<td>
							<div class="<?php echo $progress >= 100 ? "progress-picto-selected" : "progress-picto" ?>"></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="header-social-box">
			<div class="fb-like" data-href="<?php echo sfConfig::get('app_facebook_betkup_page_url')?>" data-send="false" data-layout="button_count" data-width="200" data-show-faces="true" data-font="lucida grande"></div>
		</div>
		
	</div>
</div>
<?php include_component('facebook_tdf', 'menu') ?>
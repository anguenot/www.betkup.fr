<div id="header">
	<?php echo image_tag('/image/default/facebook_rg/logo.png', array('size' => '297x179', 'class' => 'header-logo'))?>
	<div id="dashboard">
		<table>
			<tbody>
				<tr>
					<td>
						<p class="left">Istaller l'application
						</p>
					</td>
					<td>
						<p class="right">Pronostiquer
						</p>
					</td>
					<td>
						<p class="right">Devenir fan
						</p>
					</td>
					<td>
						<p class="right">Revenir
						</p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div id="header-social-box">
	<div class="fb-like" data-href="<?php echo sfConfig::get('app_facebook_betkup_page_url') ?>" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
	</div>
	<?php include_component("facebook_rg", "menu")?>
	<?php echo image_tag('/image/default/facebook_rg/slogan.png', array('class' => 'slogan', 'size' => '444x75'))?>
</div>
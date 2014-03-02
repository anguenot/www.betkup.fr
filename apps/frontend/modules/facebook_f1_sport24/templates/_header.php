<div id="header">
	<?php echo image_tag('/image/default/sport24/logo_sport24.png', array('size' => '243x100', 'class' => 'header-logo'))?>
	
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
		<?php echo image_tag('/image/default/sport24/dashboard_'.$progression.'.png', array('size' => '400x41'))?>
	</div>
	<div id="header-sup-menu">
		<h2>
		<?php echo __('text_facebook_sport24_header_title')?>
		</h2>
		<p>
		<?php echo __('text_facebook_sport24_header_partnership')?>
			<a href="https://www.betkup.fr?PARTNER=1539351" target="_blank">
				<span class="header-hosted"></span>
			</a>
		</p>
	</div>
	<div id="header-social-box">
	<div class="fb-like" data-href="https://www.facebook.com/sport24fr" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
	</div>
	<?php include_component("facebook_f1_sport24", "menu")?>
</div>
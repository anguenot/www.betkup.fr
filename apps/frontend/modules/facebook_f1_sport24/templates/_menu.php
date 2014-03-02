<div id="menu">
	<ul>
		<li>
			<a <?php echo ($sf_params->get('action') == 'home') ? 'class="menu-selected"' : ''?> onclick="linkToUrl(this);" href="https://apps.facebook.com/<?php echo sfConfig::get('mod_facebook_f1_sport24_facebook_canvas_ns'); ?>/home">
				<?php echo __('text_menu_facebook_f1_home')?>
			</a>
		</li>
		<li>
			<a <?php echo ($sf_params->get('action') == 'predictions') ? 'class="menu-selected"' : ''?> onclick="linkToUrl(this);" href="https://apps.facebook.com/<?php echo sfConfig::get('mod_facebook_f1_sport24_facebook_canvas_ns'); ?>/predictions">
				<?php echo __('text_menu_facebook_f1_predictions')?>
			</a>
		</li>
		<li>
			<a <?php echo ($sf_params->get('action') == 'results') ? 'class="menu-selected"' : ''?> onclick="linkToUrl(this);" href="https://apps.facebook.com/<?php echo sfConfig::get('mod_facebook_f1_sport24_facebook_canvas_ns'); ?>/results">
				<?php echo __('text_menu_facebook_f1_results')?>
			</a>
		</li>
		<li>
			<a <?php echo ($sf_params->get('action') == 'ranking') ? 'class="menu-selected"' : ''?> onclick="linkToUrl(this);" href="https://apps.facebook.com/<?php echo sfConfig::get('mod_facebook_f1_sport24_facebook_canvas_ns'); ?>/ranking">
				<?php echo __('text_menu_facebook_f1_ranking')?>
			</a>
		</li>
		<li>
			<a <?php echo ($sf_params->get('action') == 'rules') ? 'class="menu-selected"' : ''?> onclick="linkToUrl(this);" href="https://apps.facebook.com/<?php echo sfConfig::get('mod_facebook_f1_sport24_facebook_canvas_ns'); ?>/rules">
				<?php echo __('text_menu_facebook_f1_rules')?>
			</a>
		</li>
	</ul>
</div>
<script type="text/javascript">
function linkToUrl(obj) {
	var link = $(obj).attr('href');
	top.location.href = link;

	return false;
}
</script>
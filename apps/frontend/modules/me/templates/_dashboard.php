<div class="dashboard">
	<?php echo image_tag('/image/' . $sf_user->getCulture(). '/me/dashboard.png', array('size' => '710x206')) ?>
	<div class="intro-header">
		<?php echo __('texte_me_intro_header'); ?>
	</div>
	<div class="intro-content">
		<?php echo __('texte_me_intro_content'); ?>
	</div>
	<?php echo image_tag('/image/default/me/dashboard_close.png', array('class' => 'close', 'onclick' => 'closeDashboard();', 'alt' => __('label_me_dashboard_close'), 'size' => '22x22')) ?>
	<div class="see-home">
		<a href="<?php echo url_for(array('module' => 'home')) ?>" onmouseover="activateLink(this);" onmouseout="deactivateLink(this);">
			<?php echo __('link_me_see_home'); ?>
			<?php echo image_tag('/image/default/me/dashboard_arrow.png', array('alt' => __('label_me_arrow'), 'size' => '27x15')) ?>
		</a>
	</div>
	<div class="how-to-play" onmouseover="activateLink(this);" onmouseout="deactivateLink(this);">
		<a href="<?php echo url_for('home/howto'); ?>">
			<?php echo __('link_me_how_to_play'); ?>
			<?php echo image_tag('/image/default/me/dashboard_arrow.png', array('alt' => __('label_me_arrow'), 'size' => '27x15')) ?>
		</a>
	</div>
	<div class="rid-todo">
            <div style="font-size: 12px; color: #888;">
                <?php echo __('link_me_get_rid_todo'); ?>
                <?php echo image_tag('/image/default/me/dashboard_arrow.png', array('alt' => __('label_me_arrow'), 'size' => '27x15')) ?>
            </div>
	</div>
</div>
<script type="text/javascript">
	function closeDashboard() {
		$('.dashboard').hide('fast');
	}
	function activateLink(link) {
		$('img', $(link)).get(0).src = '/image/default/me/dashboard_arrow_hover.png';
	}
	function deactivateLink(link) {
		$('img', $(link)).get(0).src = '/image/default/me/dashboard_arrow.png';
	}
</script>
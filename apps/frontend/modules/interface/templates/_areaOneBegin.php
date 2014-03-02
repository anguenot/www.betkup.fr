<div class="areaOne" style="background: none; width: 769px; margin-top: <?php echo $margintop ?>px; padding-bottom: 0px;">
	<?php if ( $displayTop ): ?>
		<?php if ( $header == 'grey' ): ?>
			<?php echo image_tag ( 'interface/area/areaOne_top_grey.png', array ('alt' => '', 'border' => '0', 'size' => '769x8' ) ) ?>
		<?php else: ?>
			<?php echo image_tag ( 'interface/area/areaOne_top.png', array ('alt' => '', 'border' => '0', 'size' => '769x8' ) ) ?>
		<?php endif ?>
	<?php endif ?>
	<div style="width: 769px; background: url('/images/interface/area/areaOne_background.png');">
		<div style="width: 748px; margin-left: <?php echo $marginleft ?>px;">
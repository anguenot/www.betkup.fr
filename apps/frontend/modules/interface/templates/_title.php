<?php if (isset($roomUI)) : ?>
	<div style="position: absolute; margin-left: -32px; margin-top: <?php echo $startY ?>px;">
		<!-- TODO -->
		<?php echo image_tag($roomUI["path-img-title"].'_'.$racine.'_'.$sf_user->getCulture().'.png', array('alt' => $altImg, 'border' => '0', 'size' => '384x48'));?>
	</div>
<?php else : ?>
	<div style="position: absolute; margin-left: -33px; margin-top: <?php echo $startY ?>px;">
		<?php echo image_tag('/image/'.$culture.'/title/'.$racine.'.png', array('alt' => $altImg, 'border' => '0', 'size' => '544x54'));?>
	</div>
<?php endif; ?>
<div style="height: <?php echo $height ?>px; clear: both;"></div>
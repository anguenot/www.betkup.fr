<a id="<?php echo $racine ?>"></a>
<?php if ( $area == "areaOne" ): ?>
	<?php if (isset($roomUI) && isset($roomUI['path-img-title-bg'])) : ?>
		<div style="position: absolute; margin-left: -32px; margin-top: <?php echo $startY ?>px;">
			<?php if(isset($roomUI['path-img-title-bg'])) :?>
				<div class="header-title" style="<?php echo (isset($roomUI['path-img-title-bg'])) ? "background: url('".$roomUI['path-img-title-bg']."') left no-repeat;": ""; ?>">
			    	<?php echo (isset($text)) ? $text: ''?>
			    </div>
			<?php elseif(isset($roomUI["path-img-title"])) :?>
				<?php echo image_tag($roomUI["path-img-title"].'_'.$racine.'_'.$sf_user->getCulture().'.png', array('alt' => $altImg, 'border' => '0', 'size' => '384x48'));?>
			<?php endif;?>
		</div>
		<div style="height: <?php echo $height ?>px; clear: both;"></div>
	<?php else : ?>
		<div style="position: absolute; margin-left: -33px; margin-top: <?php echo $startY ?>px;">
			<?php echo image_tag('/images/moncompte/title_'.$racine.'_'.$sf_user->getCulture().'.png', array('alt' => $altImg, 'border' => '0', 'size' => '544x54'));?>
		</div>
		<div style="height: <?php echo $height ?>px; clear: both;"></div>
	<?php endif; ?>
<?php else: ?>

	<div class="barre_titre">
    	<div class="gauche">
        <?php echo image_tag('moncompte/title_'.$racine.'_'.$sf_user->getCulture().'.png', array('alt' => $altImg, 'border' => '0', 'size' => '544x54'));?>
    	</div>
    	<div class="droite">
        	<a href="#toppage" title="top page">
            <?php echo image_tag('moncompte/ancretop.png', array('alt' => 'Top page', 'border' => '0', 'size' => '22x53'));?>
        	</a>
    	</div>
	</div>
	
<?php endif ?>
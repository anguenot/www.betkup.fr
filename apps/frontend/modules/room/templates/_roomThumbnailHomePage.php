<div class="bloc" onclick="window.location.href='<?php echo url_for(array('module'=>'room', 'action'=>'view', 'uuid'=>$id)) ?>'" align="center">

	<div class="bouton">
		<a href="javascript:void(0);"></a>
	</div>

	<div class="bloc-top">
		<span class="titre"><?php echo Util::coupe($name, 15, '..') ?></span>
		<span class="legende"><?php echo Util::coupe($author_nickname, 30, '..') ?></span>
	</div>
    
	<?php if ($official == 1) : ?>
            <div class="officialHomeRoom" ></div>
	<?php endif ?>

	<div class="bloc-content">
		<p class="vignetteTexte">
			<?php echo $description ?> 
		</p>
		<div class="vignetteImage">
		<?php if (isset($roomUI) && isset($roomUI["avatar-room"]) && $roomUI["avatar-room"] != '') {
        	echo image_tag($roomUI["avatar-room"] ,array('size'=>'212x130'));
        }else{ 
        	echo (isset($avatarList[$uuid])) ? image_tag($avatarList[$uuid] ,array('size'=>'212x130')) : image_tag(sfConfig::get('mod_room_avatar_default') ,array('size'=>'212x130'));
        }?>
		</div>
	</div>
	<div class="bloc-bottom">
		<div class="vignetteLegendeBack">
			<div class="bloc-picto" style="left: 34px; top: 8px;">
				<span class="legende"><?php echo $legendes["legend1"] ?></span>
			</div>
			<div class="bloc-picto" style="left: 34px; top: 25px;">
				<span class="legende"><?php echo $legendes["legend2"] ?></span>
			</div>
			<div class="bloc-picto" style="left: 34px; top: 42px;">
				<span class="legende"><?php echo $legendes["legend3"] ?></span>
			</div>
			<div class="bloc-picto" style="left: 137px; top: 8px;">
				<span class="legende"><?php echo $legendes["legend4"] ?></span>
			</div>
			<div class="bloc-picto" style="left: 137px; top: 25px;">
				<span class="legende"><?php echo $legendes["legend4"] ?></span>
			</div>
		</div>
		<div class="vignetteLegendeFront">
			<a href="<?php echo url_for(array('module'=>'room', 'action'=>'view', 'uuid'=>$id)) ?>">
			   <?php echo image_tag('/image/' . $sf_user->getCulture(). '/room/button_join.png', array('style' => 'margin: 17px auto;', 'size' => '103x34', 'alt' => __('label_room_join'))) ?>
			</a>
		</div>
	</div>
</div>
<?php if ($module!="room") { ?>
<script type="text/javascript">
	$('.room .bloc').css('margin-right','5.5px').css('margin-left','5.5px');
</script>
<?php } ?>
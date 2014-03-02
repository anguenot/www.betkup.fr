<style>
<?php foreach($choices as $choice) : ?>
body .<?php echo $choice['uuid'] ?> .ui-selectmenu-item-icon {
	background: url('/image/default/tdf/flag/<?php echo isset($choice['properties']['PACOI']) ? $choice['properties']['PACOI'].'.png' : '' ?>') center no-repeat;
}
<?php endforeach; ?>
body .default .ui-selectmenu-item-icon {
	background: url('/image/default/tdf/flag/default.png') center no-repeat;
}
</style>
<?php if($title != '') :?>
<div class="cycling-choice-title">
	<h2>
		<?php echo html_entity_decode($title) ?>
	</h2>
</div>
<?php endif;?>
<div class="cycling-choice-jersey">
	<div class="cycling-choice-jersey-image-container">
	<?php if(isset($jersey) && $jersey != '') :?>
		<?php echo image_tag($jersey, array('size' => $imgSize)) ?>
	<?php elseif($predictionJerseyImg != '') :?>
		<?php echo image_tag($predictionJerseyImg, array('size' => $imgSize)) ?>
	<?php else :?>
		<?php echo image_tag($imgDefault, array('size' => $imgSize))?>
	<?php endif; ?>
	</div>
	<div class="cycling-choice-jersey-background">
	
	</div>
</div>
<div class="cycling-choice-select">
	<select name="predictions_<?php echo $prefix.'_'.$type ?><?php echo ($value != '') ? '['.$value.']': '' ?>" id="predictions_<?php echo $prefix.'_'.$type ?><?php echo ($value != '') ? '_'.$value : '' ?>" class="cycling-select cycling-prediction-select">
		<option class="cycling-selectmenu-icon default" value="">
			<?php if($class == 'teams') :?>
				Choisir une équipe
			<?php else :?>
				Choisir un coureur
			<?php endif;?>
		</option>
		<option class="cycling-selectmenu-icon default" value="-1">
			Aucun
		</option>
		<?php foreach($choices as $choice) :?>
			<option class="cycling-selectmenu-icon <?php echo $choice['uuid'] ?>" value="<?php echo isset($choice['uuid']) ? $choice['uuid'] : '' ?>" <?php echo (isset($predictions[$prefix.'_'.$type]) && $predictions[$prefix.'_'.$type] == $choice['uuid']) ? 'selected="selected"': '' ?>>
				<?php echo $choice['name'] ?>
			</option>
		<?php endforeach;?>
	</select>
</div>
<?php if(!isset($jersey)) :?>
<div class="hidden-jersey">
	<?php echo image_tag($imgDefault, array('id' => 'jersey_'.$prefix.'_'.$type.'_default', 'size' => $imgSize))?>
<?php foreach ($jerseyList as $uuid => $jersey) :?>
	<?php echo image_tag($jersey, array('id' => 'jersey_'.$prefix.'_'.$type.'_'.$uuid, 'size' => $imgSize))?>
<?php endforeach;?>
</div>
<script type="text/javascript">
$(function () {
	$('#predictions_<?php echo $prefix.'_'.$type ?><?php echo ($value != '') ? '_'.$value : '' ?>').change(function() {
		loadJersey<?php echo $prefix.'_'.$type ?>($(this), $(this).val());
	});
});

function loadJersey<?php echo $prefix.'_'.$type ?>(obj, value) {
	var image;
	if(value == '-1' || value == '') {
		image = $('#<?php echo 'jersey_'.$prefix.'_'.$type ?>_default').clone();
	} else {
		image = $('#<?php echo 'jersey_'.$prefix.'_'.$type ?>_'+value).clone();
	}
	obj.parent().parent().find('.cycling-choice-jersey-image-container').empty().append(image);
}
</script>
<?php endif;?>
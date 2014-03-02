<?php if ( $displayLegende ): ?>
<div>
    <?php echo __('Recherche par Tags') ?>
</div>
<?php endif ?>

<div style="margin-top: 10px; height: 80px;">

    <?php foreach ($arrayDataTags as $tag): ?>
    
    	<?php if ( isset($reponse[$tag["name"]]) ): ?>
        	<?php include_component('interface', 'tag', array('tag' => $tag, 'actif' => ($reponse[$tag["name"]]==1?true:false) )) ?>
        <?php else: ?>
        	<?php include_component('interface', 'tag', array('tag' => $tag, 'actif' => false)) ?>
        <?php endif ?>
        
    <?php endforeach ?>
    
    <?php foreach ($arrayDataTags as $tag): ?>
    
    	<?php if ( isset($reponse[$tag["name"]]) ): ?>
			<input type="hidden" name="roomHomeSearchTags[<?php echo $tag["name"] ?>]" id="input_room_tag_<?php echo $tag["name"] ?>" value="<?php echo ($reponse[$tag["name"]]==1?'1':'') ?>">
		<?php else: ?>
        	<input type="hidden" name="roomHomeSearchTags[<?php echo $tag["name"] ?>]" id="input_room_tag_<?php echo $tag["name"] ?>" value="">
        <?php endif ?>
		
    <?php endforeach ?>
</div>
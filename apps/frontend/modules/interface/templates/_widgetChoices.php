<div class="interfaceWidgetChoices " id="interfaceWidgetChoices_<?php echo $data["id"] ?>" style="width: <?php echo $width ?>px;">
    <table class="title-choices">
    	<tr>
    		<td>
    			<div class="<?php echo $data["pic_class"] ?>"></div>
    		</td>
	    	<td>
			    <h2>
			    	<?php echo $data["title"] ?>
			    </h2>
		    </td>
	    </tr>
    </table>
    <div class="css-scrollbar simple" id="interfaceWidgetChoices_cellules_<?php echo $data["id"] ?>" style="<?php echo ($data["scrollbars"]!=''?'height: 116px;':'') ?>">
        <?php $cpt=0; foreach ($data["items"] as $key => $value): ?>
            <div class="room-sensible-cell <?php echo ($cpt == 0 ? 'celluleFirst' : '') ?>" style="cursor: pointer;" id="interfaceWidgetChoices_<?php echo $data["id"] ?>_cellule_<?php echo $key ?>">
                <?php if (isset( $value["image"] )): ?>
                    <div style="float: right;">
                    <?php echo image_tag($value["image"], array('alt' => '', 'border' => '0', 'size' => '25x18'));?>
                    </div>
                <?php endif ?>
                    <div style="padding: 5px 4px;">
                        <input type="checkbox" id="checkbox_<?php echo $data["id"] ?>_<?php echo $key ?>" class="checkbox <?php echo $data["id"] ?>" 
                        	name="<?php echo $data["id"]  ?>[<?php echo $key ?>]" <?php echo (in_array($data["id"].'_'.$key , $sf_data->getRaw('selectedDatas'))) ? 'checked="checked"' : ''; ?> value="1" />
                        <label for="checkbox_<?php echo $data["id"] ?>_<?php echo $key ?>" class="normal"><?php echo __($value["name"]) ?></label>
                    </div>
            </div>
        <?php $cpt++; endforeach ?>
    </div>
</div>
<script type="text/javascript">
$(function() {
    <?php if ( $data["scrollbars"] ): ?>
        $('#interfaceWidgetChoices_cellules_<?php echo $data["id"] ?>').scrollbar();
    <?php endif ?>
});
</script>
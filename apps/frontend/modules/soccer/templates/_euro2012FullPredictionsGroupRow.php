<div class="match match<?php echo ($kupGameData["isActive"]) ? '-active' : '-inactive'; ?>">
<table class="euro-prediction-row-table">
	<tr>
		<td class="euro-date" title="<?php echo $kupGameData["title"]?>">
			<?php echo Util::coupe($kupGameData["title"], 10, '')  ?>
		</td>
		<td class="title-euro-team title-euro-team-left">
            <div>
                <h3 class="euro-team euro-team-left" title="<?php echo $kupGameData["team1title"]?>">
                <?php echo Util::coupe($kupGameData["team1title"], 13, '..') ?>
                </h3>
            </div>
        </td>
	    <td class="avatar-euro-team avatar-euro-team-left">
	    	<?php echo image_tag($kupGameData["team1avatar"],array('border'=>'0', 'size' => '23x15'))?>
	    </td>
		<td class="euro-radio">
            <?php if (isset($predictions_ic[$kupGameData['id']]) && $predictions_ic[$kupGameData['id']] == '-1'): ?>
	     		<input type="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> style="display: none;" name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="-1" checked="checked" />
	        <?php else: ?>
	        	<input type="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> style="display: none;" name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="-1" />
	        <?php endif ?>
	        <?php if (isset($predictions_ic[$kupGameData['id']]) && $predictions_ic[$kupGameData['id']] == '1'): ?>
            	<input type="radio" class="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="1"  checked="checked" />
            <?php else: ?>
                <input type="radio" class="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="1" />
            <?php endif ?>
		</td>
		<td class="euro-radio">
        	<?php if (isset($predictions_ic[$kupGameData['id']]) && $predictions_ic[$kupGameData['id']] == '2'): ?>
	        	<input type="radio" class="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="2" checked="checked" />
            <?php else: ?>
            	<input type="radio" class="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="2" />
            <?php endif ?>
		</td>
		<td class="euro-radio">
        	<?php if (isset($predictions_ic[$kupGameData['id']]) && $predictions_ic[$kupGameData['id']] == '3'): ?>
	        	<input type="radio" class="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="3" checked="checked" />
            <?php else: ?>
            	<input type="radio" class="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="3" />
            <?php endif ?>
	    </td>
	    <td class="avatar-euro-team avatar-euro-team-right">
	    	<?php echo image_tag($kupGameData["team2avatar"],array('border'=>'0', 'size' => '23x15'))?>
	    </td>
	    <td class="title-euro-team title-euro-team-right">
	    	<div style="margin-left: 2px;">
	        	<h3 class="euro-team euro-team-right" title="<?php echo $kupGameData["team2title"] ?>">
	        	<?php echo Util::coupe($kupGameData["team2title"], 13, '..') ?>
	        	</h3>
	        </div>
	   	</td>
	</tr>
</table>
</div>
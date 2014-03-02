<table class="table-pronostic-row" border="0">
	<tr>
		<td class="pellet">
			<div>Q</div>
		</td>
		<td align="center">
			<b style="color:red;"><?php echo __('label_question_tie_breaker') ?></b>
			<br/>
			<b style="color:red;"><?php echo __(sfConfig::get('mod_tennis_tb_' . $kupData['config']['tb'])) ?></b> 
			<input type="text" name="predictions_tb[<?php echo $kupData['config']['tb'] ?>]"
				   value="<?php echo isset($predictions_tb[$kupData['config']['tb']]) ? $predictions_tb[$kupData['config']['tb']] : 0 ?>"
				   <?php echo ($kupData['status'] > 1 || $kupData['status'] == -1) ? 'disabled="disabled"' : ' ' ?> size="3" maxlength="3" />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>


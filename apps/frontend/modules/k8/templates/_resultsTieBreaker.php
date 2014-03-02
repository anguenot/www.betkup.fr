	<table class="table-pronostic-row" border="0">
		<tr>
			<td align="center">
				<?php echo __('label_question_tie_breaker') ?>
				<br/>
				<?php echo __(sfConfig::get('mod_k8_tb_' . $kupData['config']['tb'])) ?> 
			</td>
		</tr>
		<tr>
			<td align="center">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td align="center">
				Votre réponse : <b><?php echo $resultsTbPlayerAnswer ?></b>
			</td>
		</tr>
		<?php if ($kupData['status'] == -1 || $kupData['status'] > 3): ?>
		<tr>
			<td align="center">
				Résultat : <b><?php echo $resultsTbAnswer ?></b>
			</td>
		</tr>
		<?php endif ?>
	</table>


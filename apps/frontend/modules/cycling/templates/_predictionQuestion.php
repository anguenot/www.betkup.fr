<div class="cycling-predictions-question">
	<table class="cycling-predictions-question-table">
		<tbody>
			<tr>
				<td>
					<p>
					<?php echo __(sfConfig::get('mod_cycling_tb_' . $kupData['config']['tb'])) ?>
					</p>
				</td>
				<td class="question-select">
					<select class="cycling-select" id="predictions_tb_<?php echo $kupData['config']['tb'] ?>" name="predictions_tb[<?php echo $kupData['config']['tb'] ?>]" >
						<option value="-1">
							Choisir un coureur
						</option>
						<?php foreach ($choices as $choice) :?>
						<option class="cycling-selectmenu-icon <?php echo $choice['uuid'] ?>" 
								value="<?php echo isset($choice['uuid']) ? $choice['uuid'] : '' ?>" <?php echo (isset($predictions[$kupData['config']['tb']]) && $predictions[$kupData['config']['tb']] == $choice['uuid']) ? 'selected="selected"': '' ?>>
							<?php echo $choice['name'] ?>
						</option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
</div>
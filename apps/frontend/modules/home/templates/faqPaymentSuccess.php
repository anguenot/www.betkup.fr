<div class="questions">
	<table>
		<tbody>
			<tr>
				<td class="image"></td>
				<td class="text"><?php echo __('text_faq_edit_account_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_edit_account_answer', array('%br%' => '<br />', '%b%' => '<b>', '%/b%' => '</b>', '%click_here%' => link_to1(__('text_click_here_2'), 'https://www.betkup.fr/account/credit', array('target' => '_new'))))?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="questions">
	<table>
		<tbody>
			<tr>
				<td class="image"></td>
				<td class="text"><?php echo __('text_faq_withdraw_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_withdraw_answer', array('%br%' => '<br />', '%click_here%' => link_to1(__('text_click_here'), 'https://www.betkup.fr/account/status%23mesdocdeverif', array('target' => '_new'))))?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="questions">
	<table>
		<tbody>
			<tr>
				<td class="image"></td>
				<td class="text"><?php echo __('text_faq_deposit_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_deposit_answer')?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="questions">
	<table>
		<tbody>
			<tr>
				<td class="image"></td>
				<td class="text"><?php echo __('text_faq_cost_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_cost_answer')?>
					
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="questions">
	<table>
		<tbody>
			<tr>
				<td class="image"></td>
				<td class="text"><?php echo __('text_faq_deposit_type_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_deposit_type_answer', array('%br%' => '<br />'))?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="questions">
	<table>
		<tbody>
			<tr>
				<td class="image"></td>
				<td class="text"><?php echo __('text_faq_delay_retreats_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_delay_retreats_answer')?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="questions">
	<table>
		<tbody>
			<tr>
				<td class="image"></td>
				<td class="text"><?php echo __('text_faq_history_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_history_answer', array('%this_link%' => link_to1(__('text_this_link'), 'https://www.betkup.fr/account/transaction', array('target' => '_new'))))?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script type="text/javascript">
$(function() {
	$('.image', $('.questions')).click(function() {
		var question = $(this).parent().parent().parent().parent();
		
		if($(this).hasClass('open')) {
			question.find('.answer').hide();
			$(this).css('background', 'url(/image/default/faq/interface/btn_plus.png) center no-repeat');
			$(this).removeClass('open');
		} else {
			question.find('.answer').show();
			$(this).css('background', 'url(/image/default/faq/interface/btn_minus.png) center no-repeat');
			$(this).addClass('open');
		}
		return false;
	});
});
</script>
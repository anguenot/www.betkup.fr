<div class="questions">
	<table>
		<tbody>
			<tr>
				<td class="image"></td>
				<td class="text"><?php echo __('text_faq_personal_datas_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_personal_datas_answer', array('%br%' => '<br />'))?>
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
				<td class="text"><?php echo __('text_faq_limits_stake_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_limits_stake_answer')?>
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
				<td class="text"><?php echo __('text_faq_limit_bet_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
					<?php echo __('text_faq_limit_bet_answer')?>
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
				<td class="text"><?php echo __('text_faq_close_account_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
					<?php echo __('text_faq_close_account_answer')?>
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
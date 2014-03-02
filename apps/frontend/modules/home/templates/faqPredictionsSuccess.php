<div class="questions">
	<table>
		<tbody>
			<tr>
				<td class="image"></td>
				<td class="text"><?php echo __('text_faq_cancel_kup_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_cancel_kup_answer', array('%br%' => '<br />', '%b%' => '<b>', '%/b%' => '</b>'))?>
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
				<td class="text"><?php echo __('text_faq_modify_prediction_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_modify_prediction_answer')?>
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
				<td class="text"><?php echo __('text_faq_kup_start_prediction_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_kup_start_prediction_answer')?>
				
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
				<td class="text"><?php echo __('text_faq_participants_kup_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_participants_kup_answer')?>
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
				<td class="text"><?php echo __('text_faq_winner_kup_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_winner_kup_answer')?>
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
				<td class="text"><?php echo __('text_faq_ranking_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
				<?php echo __('text_faq_ranking_answer')?>
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
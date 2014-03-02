<div class="questions">
	<table>
		<tbody>
			<tr>
				<td class="image"></td>
				<td class="text"><?php echo __('text_faq_play_is_legal_question')?></td>
			</tr>
			<tr class="answer">
				<td colspan="2">
					<?php echo __('text_faq_play_is_legal_answer', array('%br%' => '<br />', '%link_more_infos%' => link_to(__('text_click_here'), 'https://www.betkup.fr/home/betTrust#bet_law', array('target' => '_new'))))?>
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
				<td class="text"><?php echo __('text_faq_min_prediction_question')?></td>
			</tr>
			<tr class="answer">
			<td colspan="2">
				<?php echo __('text_faq_min_prediction_answer')?>
			</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="questions">
	<table>
		<tr>
			<td class="image"></td>
			<td class="text"><?php echo __('text_faq_simple_account_question')?></td>
		</tr>
		<tr class="answer">
			<td colspan="2">
			<?php echo __('text_faq_simple_account_answer', array('%br%' => '<br />'))?>
			</td>
		</tr>
	</table>
</div>
<div class="questions">
	<table>
		<tr>
			<td class="image"></td>
			<td class="text"><?php echo __('text_faq_open_simple_account_question')?></td>
		</tr>
		<tr class="answer">
			<td colspan="2">
				<?php echo __('text_faq_open_simple_account_answer', array('%br%' => '<br />', '%link%' => link_to(__('text_this_link'), 'https://www.betkup.fr/account/register', array('target' => '_new'))))?>
			</td>
		</tr>
	</table>
</div>
<div class="questions">
	<table>
		<tr>
			<td class="image"></td>
			<td class="text"><?php echo __('text_faq_advanced_account_question')?></td>
		</tr>
		<tr class="answer">
			<td colspan="2">
			<?php echo __('text_faq_advanced_account_answer', array('%br%' => '<br />'))?>
			</td>
		</tr>
	</table>
</div>
<div class="questions">
	<table>
		<tr>
			<td class="image"></td>
			<td class="text"><?php echo __('text_faq_open_advanced_account_question')?></td>
		</tr>
		<tr class="answer">
			<td colspan="2">
				<?php echo __('text_faq_open_advanced_account_answer', array('%br%' => '<br />', '%link%' => link_to(__('text_this_link'), 'https://www.betkup.fr/account/registerAdvanced', array('target' => '_new'))))?>
			</td>
		</tr>
	</table>
</div>
<div class="questions">
	<table>
		<tr>
			<td class="image"></td>
			<td class="text">Pourquoi obtenir le statut de vérification ?</td>
		</tr>
		<tr class="answer">
			<td colspan="2">
				Betkup est une offre agréée ARJEL. Pour cette raison, nous nous sommes engagés à vérifier l'identité des joueurs souhaitant participer aux jeux d'argent. L'objectif de cette vérification est de garantir que les joueurs sont tous majeurs et qu'ils viennent bien pour le plaisir du jeu. Ainsi, une fois votre compte complet ouvert, nous vous demandons d'envoyer une copie de votre pièce d'identité en cours de validité accompagnée de votre RIB/IBAN afin de vérifier les informations saisies lors de votre inscription.
			</td>
		</tr>
	</table>
</div>
<div class="questions">
	<table>
		<tr>
			<td class="image"></td>
			<td class="text"><?php echo __('text_faq_documents_question')?></td>
		</tr>
		<tr class="answer">
			<td colspan="2">
			<?php echo __('text_faq_documents_answer', array('%br%' => '<br />', '%b%' => '<b>', '%/b%' => '</b>', '%this_link%' => link_to(__('text_this_link'), 'https://www.betkup.fr/account/status#mesdocdeverif', array('target' => '_new'))))?>
			</td>
		</tr>
	</table>
</div>
<div class="questions">
	<table>
		<tr>
			<td class="image"></td>
			<td class="text"><?php echo __('text_faq_city_question')?></td>
		</tr>
		<tr class="answer">
			<td colspan="2">
			<?php echo __('text_faq_city_answer', array('%br%' => '<br />'))?>
			</td>
		</tr>
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
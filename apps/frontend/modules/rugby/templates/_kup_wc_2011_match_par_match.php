<div class="regle">
	<div style="margin-left: 10px; margin-top: 20px; width: 670px;">
	<?php $rules1 = array('type' => '','title' => __('rugby_kup_wc_2011_match_par_match_ruleBloc_1_title'),'nbSubSection' => '1',
	Array('orange' => '','legende' => __('rugby_kup_wc_2011_match_par_match_ruleBloc_1_legende_1'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => __('rugby_kup_wc_2011_match_par_match_ruleBloc_1_score_1'))
	) ?>

	<?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>

	<?php $rules2 = array('type' => 'choc','title' => __('rugby_kup_wc_2011_match_par_match_ruleBloc_2_title'),'nbSubSection' => '2',
	Array('orange' => '','legende' => __('rugby_kup_wc_2011_match_par_match_ruleBloc_2_legende_1'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => __('rugby_kup_wc_2011_match_par_match_ruleBloc_2_score_1')),
	Array('orange' => '','legende' => __('rugby_kup_wc_2011_match_par_match_ruleBloc_2_legende_2'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => __('rugby_kup_wc_2011_match_par_match_ruleBloc_2_score_2'))
	) ?>

	<?php include_component('kup', 'rulesTable', array('rules' => $rules2)) ?>
	
	</div>
</div>

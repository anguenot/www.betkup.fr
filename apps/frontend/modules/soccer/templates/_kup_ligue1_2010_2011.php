<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => __('soccer_ligue1_2010_2011_ruleBloc_1_title'),'nbSubSection' => '3',
    	Array('orange' => '','legende' => __('soccer_ligue1_2010_2011_ruleBloc_1_legende_1'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => __('soccer_ligue1_2010_2011_ruleBloc_1_score_1')),
        Array('orange' => '','legende' => __('soccer_ligue1_2010_2011_ruleBloc_1_legende_2'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => __('soccer_ligue1_2010_2011_ruleBloc_1_score_2')),
        Array('orange' => '','legende' => __('soccer_ligue1_2010_2011_ruleBloc_1_legende_3'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => __('soccer_ligue1_2010_2011_ruleBloc_1_score_3')),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>
<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => 'Pour chaque match','nbSubSection' => '4',
    	Array('orange' => '','legende' => 'Vainqueur du match','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' =>  '5'),
        Array('orange' => '','legende' => __('rugby_kup_top14_2011_2012_ruleBloc_1_legende_2'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => __('rugby_kup_top14_2011_2012_ruleBloc_1_score_2')),
        Array('orange' => '','legende' => __('rugby_kup_top14_2011_2012_ruleBloc_1_legende_3'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => __('rugby_kup_top14_2011_2012_ruleBloc_1_score_3')),
    		Array('orange' => '','legende' => 'Ecart de points correctement pronostiqué','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
        ) ?>

        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>
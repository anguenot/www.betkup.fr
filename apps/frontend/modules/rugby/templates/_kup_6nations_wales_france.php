<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => 'Sur ce match','nbSubSection' => '8',
    	Array('orange' => '','legende' => 'Vainqueur du match','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' =>  '5'),
        Array('orange' => '','legende' => __('rugby_kup_top14_2011_2012_ruleBloc_1_legende_2'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => __('rugby_kup_top14_2011_2012_ruleBloc_1_score_2')),
        Array('orange' => '','legende' => __('rugby_kup_top14_2011_2012_ruleBloc_1_legende_3'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => __('rugby_kup_top14_2011_2012_ruleBloc_1_score_3')),
    	Array('orange' => '','legende' => 'Équipe première marqueuse d\'essai','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
    	Array('orange' => '','legende' => 'Premier marqueur d\'essai pour la France','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '30'),
    	Array('orange' => '','legende' => 'Nombre total de drops réussis pendant le match','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    	Array('orange' => '','legende' => 'Nombre total de pénalités réussies pendant le match','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    	Array('orange' => '','legende' => 'Ecart de points correctement pronostiqué','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
        ) ?>

        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>
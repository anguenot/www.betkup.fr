<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => 'Jusqu\'à la 19ème journée','nbSubSection' => '3',
    	Array('orange' => '','legende' => __('soccer_ligue1_2010_2011_ruleBloc_1_legende_1'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
        Array('orange' => '','legende' => __('soccer_ligue1_2010_2011_ruleBloc_1_legende_2'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
        Array('orange' => '','legende' => __('soccer_ligue1_2010_2011_ruleBloc_1_legende_3'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules2 = array('type' => '','title' => 'À partir de la 20ème journée','nbSubSection' => '3',
    Array('orange' => '','legende' => __('soccer_ligue1_2010_2011_ruleBloc_1_legende_1'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '30'),
    Array('orange' => '','legende' => __('soccer_ligue1_2010_2011_ruleBloc_1_legende_2'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
    Array('orange' => '','legende' => __('soccer_ligue1_2010_2011_ruleBloc_1_legende_3'),'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '40'),
) ?>
    <?php include_component('kup', 'rulesTable', array('rules' => $rules2)) ?>
</div>
</div>
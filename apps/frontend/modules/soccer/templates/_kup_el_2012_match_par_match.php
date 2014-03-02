<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => __('soccer_ligue1_2010_2011_ruleBloc_1_title'),'nbSubSection' => '3',
    	Array('orange' => '','legende' => 'Score exact final', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
    	Array('orange' => '','legende' => 'Vainqueur du match', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '3'),
        Array('orange' => '','legende' => 'Premier buteur du match','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>
<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => 'Critères','nbSubSection' => '2',
    	Array('orange' => '','legende' => '1N2', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '2'),
    	Array('orange' => '','legende' => 'Pour les matchs chocs, score en sets du match ', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10/2'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>
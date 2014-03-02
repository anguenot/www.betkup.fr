<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => 'Jusqu\'à la phase finale','nbSubSection' => '1',
    	Array('orange' => '','legende' => '1X2','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules2 = array('type' => '','title' => 'À partir de la phase finale','nbSubSection' => '3',
    Array('orange' => '','legende' => 'Vainqueur du match','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
    Array('orange' => '','legende' => 'Score exact du match','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
    Array('orange' => '','legende' => 'Premier buteur du match','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
) ?>
    <?php include_component('kup', 'rulesTable', array('rules' => $rules2)) ?>
</div>
</div>
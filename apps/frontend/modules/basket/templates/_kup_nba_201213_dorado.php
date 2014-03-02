<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">

    <?php $rules1 = array('type' => '','title' => 'Sur chaque match','nbSubSection' => '4',
        Array('orange' => '','legende' => '1/2','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
        Array('orange' => '','legende' => '+10','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '8'),
        Array('orange' => '','legende' => '+20','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '14'),
        Array('orange' => '','legende' => '+30','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '22')) ?>

    <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>

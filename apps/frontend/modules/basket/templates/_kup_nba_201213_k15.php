<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">

    <?php $rules1 = array('type' => '','title' => 'Pour tous les matchs','nbSubSection' => '2',
    Array('orange' => '','legende' => 'Bon prono sur victoire domicile', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Bon prono sur victoire extérieur', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '7'),
    ) ?>

    <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>

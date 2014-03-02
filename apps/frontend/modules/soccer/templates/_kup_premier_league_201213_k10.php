_kup_liga_201213_k10.php<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">

        <?php $rules1 = array('type' => '','title' => 'Pour tous les matchs','nbSubSection' => '3',
        Array('orange' => '','legende' => 'Bon prono sur victoire domicile', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '2'),
        Array('orange' => '','legende' => 'Bon prono sur match nul', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '3'),
        Array('orange' => '','legende' => 'Bon prono sur victoire extérieur', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '4'),
    ) ?>

        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>

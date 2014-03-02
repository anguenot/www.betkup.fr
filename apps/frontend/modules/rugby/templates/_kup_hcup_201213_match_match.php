<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => 'Sur tous les matchs de poules','nbSubSection' => '3',
        Array('orange' => '','legende' => 'Bon prono sur victoire domicile', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '4'),
        Array('orange' => '','legende' => 'Bon prono sur match nul', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
        Array('orange' => '','legende' => 'Bon prono sur victoire extérieur', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '6'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>

    <?php $rules2 = array('type' => '','title' => 'À partir de la phase finale','nbSubSection' => '5',
    Array('orange' => '','legende' => 'Bon prono sur victoire domicile', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '8'),
    Array('orange' => '','legende' => 'Bon prono sur match nul', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
    Array('orange' => '','legende' => 'Bon prono sur victoire extérieur', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '12'),
    Array('orange' => '','legende' => 'Nombre d\'essais pour l\'équipe à domicile ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
    Array('orange' => '','legende' => 'Nombre d\'essais pour l\'équipe à l\'extérieur ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
) ?>
    <?php include_component('kup', 'rulesTable', array('rules' => $rules2)) ?>
    </div>
</div>
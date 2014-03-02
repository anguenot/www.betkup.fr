<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">

    <?php $rules1 = array('type' => '','title' => 'Maillots','nbSubSection' => '2',
    array('orange' => '','legende' => 'Bon pronostic par maillot', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    array('orange' => '','legende' => 'Combo Maillot (4 maillots bons)', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    )?>
    
    <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    
    <?php $rules2 = array('type' => '','title' => 'Podium Individuel','nbSubSection' => '7',
    array('orange' => '','legende' => 'Coureur bien pronostiqué', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '25'),
    array('orange' => '','legende' => 'Coureur pronostiqué placé dans le top 3 (arrive dans les 3 premiers)', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    array('orange' => '','legende' => 'Coureur pronostiqué placé dans le top 10 (arrve entre 4ème et 10ème)', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
    array('orange' => '','legende' => 'Coureur pronostiqué placé dans le top 20 (arrive entre 11ème et 20ème)', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    array('orange' => '','legende' => 'Combo dans l\'ordre : Les 3 coureurs bien pronostiqués dans l\'ordre', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
    array('orange' => '','legende' => 'Combo dans le désordre : Podium pronostiqué mais dans le désordre', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    array('orange' => '','legende' => 'Combo 2 sur 3 : 2 sur 3 coureurs du Podium (ordre ou pas)', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
	) ?>
	<?php include_component('kup', 'rulesTable', array('rules' => $rules2)) ?>
	
	<?php $rules3 = array('type' => '','title' => 'Podium par Équipe','nbSubSection' => '5',
    array('orange' => '','legende' => 'Équipe bien placée', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '25'),
    array('orange' => '','legende' => 'Équipe dans le top 3 (arrive dans les 3 premiers)', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
   	array('orange' => '','legende' => 'Combo dans l\'ordre : podium bien pronostiqué dans l\'ordre', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
    array('orange' => '','legende' => 'Combo dans le désordre : Podium bien pronostiqué mais dans le désordre', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    array('orange' => '','legende' => 'Combo 2 sur 3 équipes : 2 sur 3 équipes dans dans le Top 3 (ordre ou pas)', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10')
    ) ?>
	<?php include_component('kup', 'rulesTable', array('rules' => $rules3)) ?>
   
    </div>
</div>

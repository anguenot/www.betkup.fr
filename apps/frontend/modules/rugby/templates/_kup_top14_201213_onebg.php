<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => 'Sur ce match :','nbSubSection' => '9',
    	Array('orange' => '','legende' => '1N2','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
        Array('orange' => '','legende' => 'Nombre d\'essais pour l\'équipe de gauche ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
        Array('orange' => '','legende' => 'Nombre d\'essais pour l\'équipe de droite ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
    	Array('orange' => '','legende' => 'Identité de l\'équipe première marqueuse d\'essai ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
    	Array('orange' => '','legende' => 'Écart de points entre les deux équipes à la fin du match ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '30'),
    	Array('orange' => '','legende' => 'Identité du premier marqueur d\'essai pour l\'équipe à domicile','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
    	Array('orange' => '','legende' => 'Identité du premier marqueur d\'essai pour l\'équipe à l\'extérieur','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
    	Array('orange' => '','legende' => 'Nombre total de pénalités réussies durant le match','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '30'),
    	Array('orange' => '','legende' => 'Nombre total de drops réussis durant le match','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '30'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>
</div>
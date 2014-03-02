<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => 'Pour chaque match :','nbSubSection' => '5',
    	Array('orange' => '','legende' => '1N2','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
        Array('orange' => '','legende' => 'Nombre d\'essais pour l\'équipe de gauche ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
        Array('orange' => '','legende' => 'Nombre d\'essais pour l\'équipe de droite ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    	Array('orange' => '','legende' => 'Identité de l\'équipe première marqueuse d\'essai ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
    	Array('orange' => '','legende' => 'Écart de points entre les deux équipes à la fin du match ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>
</div>
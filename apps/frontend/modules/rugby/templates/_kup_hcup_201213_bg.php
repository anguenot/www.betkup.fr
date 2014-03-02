<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => 'Pour chaque match :','nbSubSection' => '3',
    	Array('orange' => '','legende' => '1N2','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    	Array('orange' => '','legende' => 'Identité de l\'équipe première marqueuse d\'essai ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
    	Array('orange' => '','legende' => 'Nombre d\'essai dans le match ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>
</div>
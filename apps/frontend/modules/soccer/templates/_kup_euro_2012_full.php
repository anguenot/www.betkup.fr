<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => 'Barème','nbSubSection' => '5',
    	Array('orange' => '','legende' => '1N2 phase de poule', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '3'),
		Array('orange' => '','legende' => 'Équipe bien placée en 1/4', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
		Array('orange' => '','legende' => 'Équipe bien placée en demi', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
		Array('orange' => '','legende' => 'Équipe bien placée en finale', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '30'),
		Array('orange' => '','legende' => 'Équipe bien placée en vainqueur', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '50'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>
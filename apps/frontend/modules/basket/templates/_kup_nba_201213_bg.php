<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">

    <?php $rules1 = array('type' => '','title' => 'Sur ce match','nbSubSection' => '10',
        Array('orange' => '','legende' => '1/2','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
        Array('orange' => '','legende' => '+10','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '8'),
        Array('orange' => '','legende' => '+20','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '14'),
        Array('orange' => '','legende' => '+30','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '22'),

        Array('orange' => '','legende' => 'L\'Équipe à domicile ouvre le score ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
        Array('orange' => '','legende' => 'Quelle équipe mènera au score à la mi-temps ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '7'),
        Array('orange' => '','legende' => 'Dans quelle équipe sera le meilleur marqueur du match ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
        Array('orange' => '','legende' => 'Dans quelle équipe sera le meilleur intercepteur du match ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '7'),
        Array('orange' => '','legende' => 'Dans quelle équipe sera le meilleur contreur du match ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '7'),
        Array('orange' => '','legende' => 'Il y aura il plus de 180 pts inscrits durant ce match ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '7')) ?>

    <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>

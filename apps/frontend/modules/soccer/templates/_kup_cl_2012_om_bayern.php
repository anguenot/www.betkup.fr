<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">

    <?php $rules1 = array('type' => '','title' => 'Sur ce match','nbSubSection' => '8',
    Array('orange' => '','legende' => 'Score exact final', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
    Array('orange' => '','legende' => 'Vainqueur du match', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '6'),
    Array('orange' => '','legende' => 'Issue de la première mi-temps', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Issue deuxième mi-temps', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Èquipe qui marquera le premier but de la rencontre', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => '1/4 d\'heure dans lequel aura lieu l\'ouverture du score', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    Array('orange' => '','legende' => 'Rémy, joueur de l\'OM va-t-il marquer ?', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Franck Ribéry, joueur du Bayern va-t-il marquer ?', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    ) ?>

    <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>

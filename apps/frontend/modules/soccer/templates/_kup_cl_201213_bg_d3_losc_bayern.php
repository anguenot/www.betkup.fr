<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">

    <?php $rules1 = array('type' => '','title' => 'Sur ce match','nbSubSection' => '9',
    Array('orange' => '','legende' => 'Score exact', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
    Array('orange' => '','legende' => 'Vainqueur du match', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '6'),
    Array('orange' => '','legende' => 'Qui gagnera la première mi-temps ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Qui remportera la seconde mi-temps ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Équipe qui ouvrira le score ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Roux, joueur de Lille marquera-t-il pendant le match ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Ribery, joueur de Munich marquera-t-il pendant le match ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Combien de buts seront inscrits au cours des 90 minutes ?','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    Array('orange' => '','legende' => '1/4 d\'heure dans lequel aura lieu l\'ouverture du score', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    ) ?>

    <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>

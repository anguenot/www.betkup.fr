<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">

    <?php $rules1 = array('type' => '','title' => 'Sur ce match','nbSubSection' => '8',
    Array('orange' => '','legende' => 'Score exact final', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
    Array('orange' => '','legende' => 'Vainqueur du match', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '6'),
    Array('orange' => '','legende' => 'Issue de la première mi-temps', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Issue deuxième mi-temps', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Èquipe qui marquera le premier but de la rencontre', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Ailton José Almeida, joueur de l\'Apoel va-t-il marquer ?', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Karim Benzema, joueur du Real va-t-il marquer ?', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Nombre de buts d\'écarts à la fin de la rencontre ? ', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    ) ?>

    <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>

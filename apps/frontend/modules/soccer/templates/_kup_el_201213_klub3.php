<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">

        <?php $rules1 = array('type' => '','title' => 'Pour tous les matchs','nbSubSection' => '4',
        Array('orange' => '','legende' => 'Score exact final', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
        Array('orange' => '','legende' => 'Vainqueur du match', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
        Array('orange' => '','legende' => 'Quel sera le premier buteur du match ?', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
        Array('orange' => '','legende' => 'Nombre de buts d\'écart à la fin du match ?', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    ) ?>

        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>

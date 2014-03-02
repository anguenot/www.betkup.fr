<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">

    <?php $rules1 = array('type' => '','title' => 'Pour tous les matchs','nbSubSection' => '4',
    Array('orange' => '','legende' => 'Score exact', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    Array('orange' => '','legende' => 'Issue correcte', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    Array('orange' => '','legende' => 'Quel équipe ouvre le score', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
    Array('orange' => '','legende' => 'Il y aura-il des prolongations dans ce match ?', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
    ) ?>

    <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>

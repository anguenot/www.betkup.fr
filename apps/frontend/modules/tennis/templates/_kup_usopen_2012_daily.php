<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => 'Critères','nbSubSection' => '2',
    	Array('orange' => '','legende' => '1N2', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '2'),
    	Array('orange' => '','legende' => 'Pour les matchs chocs, score en sets du match ', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10/2'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
     <?php $rules2 = array('type' => '','title' => 'Détails barème score exact en jeux','nbSubSection' => '5',
     	Array('orange' => '','legende' => 'Nombre de sets disputés', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '20'),
    	Array('orange' => '','legende' => 'Issue correcte du set', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    	Array('orange' => '','legende' => 'Score exact du set', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '40'),
    	Array('orange' => '','legende' => 'Si toutes les issues de set sont bonnes (bonus 30)', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '30'),
    	Array('orange' => '','legende' => 'Si tout le score du match est exact (bonus 50)', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '50'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules2)) ?>
    </div>
    <div>Nombre de points maximum sur un score exact : </div>
    <div>280 points si le match est en 5 sets et que le score des 5 manches est exact (10 points pour le score en jeux, 20 points pour le nombre de sets + 40 points par set + 50 points de bonus)</div>
</div>
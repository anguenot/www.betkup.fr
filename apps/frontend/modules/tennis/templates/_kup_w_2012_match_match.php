<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
    <?php $rules1 = array('type' => '','title' => 'Avant les demi finales','nbSubSection' => '2',
    	Array('orange' => '','legende' => '1N2', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '3'),
    	Array('orange' => '','legende' => 'Pour les matchs chocs, score en sets du match ', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10/3'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    <?php $rules2 = array('type' => '','title' => 'À partir des demi finales ','nbSubSection' => '6',
    	Array('orange' => '','legende' => '1N2', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '5'),
    	Array('orange' => '','legende' => 'Nombre de sets disputés dans le match', 'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
        Array('orange' => '','legende' => 'Issue correct du set','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '10'),
        Array('orange' => '','legende' => 'Score exact du set','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '30'),
        Array('orange' => '','legende' => 'Si toutes les issues de set sont bonnes (bonus)','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '30'),
        Array('orange' => '','legende' => 'Si tout le score du match est exact (bonus)','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '50'),
        ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules2)) ?>
        <p>Nombre de points maximum sur un score exact : 230 points si le match est en 5 sets et que le score des 5 manches est exact (30 points par set + 30 points bonus + 50 points de bonus)</p>
    </div>
</div>
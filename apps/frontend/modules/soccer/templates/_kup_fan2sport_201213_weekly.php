<div class="regle">
    <div style="margin-left: 10px; margin-top: 20px; width: 670px;">
        <?php $rules1 = array('type' => '','title' => 'Pour chaque match','nbSubSection' => '3',
        Array('orange' => '','legende' => '1 bon score','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '3'),
        Array('orange' => '','legende' => 'Bonne équipe victorieuse / ou nul bien pronostiqué' ,'image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '6'),
        Array('orange' => '','legende' => 'Les 2 bon scores','image' => '/images/kup/view/regle/tabFlecheVerte.png','score' => '15'),
    ) ?>
        <?php include_component('kup', 'rulesTable', array('rules' => $rules1)) ?>
    </div>
</div>
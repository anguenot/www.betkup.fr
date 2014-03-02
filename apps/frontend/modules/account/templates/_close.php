<div class="boutonCloturer">
    <a href="<?php echo url_for(array('module' => 'account', 'action' => 'confirmCloseRequest')) ?>" title="<?php echo __('Demander la clôture de mon compte') ?>">
        <?php echo image_tag('moncompte/btcloturer_' . $sf_user->getCulture() . '.png', array('alt' => '', 'border' => '0', 'size' => '193x55')); ?>
    </a>
</div>
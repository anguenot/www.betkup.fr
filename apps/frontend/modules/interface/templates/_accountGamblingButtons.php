<div style="width: 390px; margin: 0 auto; ">
    <a href="<?php echo url_for(array(
                                     'module'  => 'account',
                                     'action'  => 'credit'
                                )) ?>"
       title="<?php echo __('Créditer mon compte') ?>"
       style="float: left;">
        <?php echo image_tag('/images/interface/boutonCrediterMyAccount_FR.png', array(
                                                                                      'title' => __('Créditer mon compte'),
                                                                                      'border' => '0'
                                                                                 )) ?>
    </a>
    <?php if ($sf_user->hasCredential('member_gambling_fr_verified')) : ?>
    <a href="<?php echo url_for(array(
                                     'module'  => 'account',
                                     'action'  => 'wire'
                                )) ?>"
       title="<?php echo __('Retirer mes gains') ?>"
       style="float: left; margin-left: 10px;">
        <?php echo image_tag('/images/interface/boutonRetirermesgains_fr.png', array(
                                                                                    'title'  => __('Retirer mes gains'),
                                                                                    'border' => '0'
                                                                               )) ?>
    </a>
    <?php else : ?>
    <?php echo image_tag('/images/account/transactions/virerOFF.png', array(
                                                                           'title'  => __('Retirer mes gains'),
                                                                           'border' => '0',
                                                                           'style'  => 'float: left; margin-left: 10px;'
                                                                      )) ?>
    <br/>
    <div style="clear: both; height: 10px;"></div>
    <p class="rappel" style="display: inline-block; width: 100%; text-align: center;">

        <a href="<?php echo url_for(array(
                                         'module'  => 'account',
                                         'action'  => 'status'
                                    )) ?>">
            <?php echo __('label_why_cannot_wire'); ?>
        </a>
    </p>
    <?php endif; ?>
</div>
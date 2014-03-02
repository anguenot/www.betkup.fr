<?php use_stylesheet('home/ready_to_play.css') ?>
<div id="box-ready-to-play">
    <div class="header-box">
        <?php echo __('text_home_box_title_ready_to_win') ?>
    </div>
    <div class="conatainer-box">
        <ul>
            <li>
                <a href="<?php echo url_for('me/index') ?>">
                    <span class="pic pic-my-betkup"></span>
                    <?php echo __('text_home_box_my_betkup') ?>
                    <span class="play"></span>
                </a>
            </li>
            <li>
                <a href="<?php echo url_for('kup/home') ?>">
                    <span class="pic pic-kups"></span>
                    <?php echo __('text_home_box_kups') ?>
                    <span class="play"></span>
                </a>
            </li>
            <li>
                <a href="<?php echo url_for('room/home') ?>">
                    <span class="pic pic-rooms"></span>
                    <?php echo __('text_home_box_rooms') ?>
                    <span class="play"></span>
                </a>
            </li>
            <li>
                <a href="<?php echo url_for('challenge/home') ?>">
                    <span class="pic pic-challenge"></span>
                    <?php echo __('text_home_box_challenges') ?>
                    <span class="play"></span>
                </a>
            </li>
        </ul>
        <?php if($sf_user->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_home_registration_account_type_simple')) : ?>
        <a href="<?php echo url_for('account/updateSimpleAccount') ?>" class="upgrade-account">
            <?php echo __('text_home_box_update_account') ?>
        </a>
        <?php else : ?>
        <a href="<?php echo url_for('account/credit') ?>" class="credit-account">
            <?php echo __('text_home_box_credit_account') ?>
        </a>
        <?php endif; ?>
    </div>
</div>
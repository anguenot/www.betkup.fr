<?php include_component('interface', 'flashMessage') ?>
<div class="logo_betkup">
    <?php echo image_tag('/image/default/header/logo_home_2.png', array(
                                                                       'alt'    => 'Home page',
                                                                       'border' => '0',
                                                                       'size'   => '320x214'
                                                                  ));?>
    <a href="<?php echo url_for("@homepage") ?>" title="Home page" style="display: block; position: absolute; width: 290px; height: 120px; top: 58px; left: 0;"></a>
</div>
<div class="top_infos">

    <?php if ($sf_user->IsAuthenticated()) : ?>

    <a href="<?php echo url_for('account/edit') ?>">
        <?php include_component('interface', 'userAvatar', array(
                                                                'avatarPath' => util::getAvatarForUser($sf_user->getAttribute('avatar', '', 'subscriber')),
                                                                'canvasSize' => '40x40',
                                                                'alt'        => 'Modifier mon avatar',
                                                                'class'      => 'avatar-infos'
                                                           )) ?>
    </a>
    <div class="text-infos">
        <p class="bienvenue">
            <span style="color: #B2B2B2;"><?php echo __('label_header_welcome_member') ?></span>
            <a href="<?php echo url_for('account/edit');?>"><?php echo $userFirstName ?> <?php echo $userLastName ?></a>
            <span style="color: #B2B2B2;">&nbsp;A.K.A.&nbsp;</span>
            <a href="<?php echo url_for('account/edit');?>"><?php echo $userNickname ?></a>
            [ <a href="<?php echo url_for(array('module' => 'account', 'action' => 'logout')) ?>">
            <?php echo __('label_header_member_logout') ?>
        </a> ]
        </p>
        <?php if ($sf_user->hasCredential('member_gambling_fr')) : ?>
        <p class="bienvenue" style="float: right;">
            <span class="orange">
            <?php echo $userCredit ?> €
                </span>
            <a href="<?php echo url_for(array(
                                             'module' => 'account', 'action'  => 'transaction'
                                        )) ?>">
                <?php echo __('label_header_member_credit') ?>
            </a>
            /
            <span class="orange">
            <?php echo $userBets ?> €
            </span>
            <a href="<?php echo url_for(array('module' => 'me', 'action' => 'index')) ?>">
                <?php echo __('label_header_member_placed') ?>
            </a>
            [<a href="<?php echo url_for(array('module' => 'account', 'action' => 'credit')) ?>">
            <?php echo __('créditer') ?>
        </a>]
        </p>
        <?php else : ?>
        <p class="rappel"><a href="<?php echo url_for(array(
                                                           'module'  => 'account',
                                                           'action'  => 'updateSimpleAccount'
                                                      )) ?>">
            <?php echo __('open_account_complet_to_bet'); ?>
        </a>
        </p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<?php if (!$sf_user->IsAuthenticated()) : ?>
<div class="top_free">
    <?php echo __('label_header_free')?>
</div>
<?php endif; ?>
<div class="top_onglets">

    <?php if ($sf_user->IsAuthenticated()) : ?>

    <?php if ($sf_params->get('module') == "account" && $sf_params->get('action') == "edit"): ?>
        <a href="<?php echo url_for(array(
                                         'module' => 'account', 'action'  => 'edit'
                                    )) ?>" title="Mon compte"><?php echo image_tag('account/menu/myaccountOn_' . strtolower($sf_user->getCulture()) . '.png', array(
                                                                                                                                                                   'alt'    => 'Mon compte',
                                                                                                                                                                   'border' => '0'
                                                                                                                                                              )) ?></a>
        <?php else: ?>
        <a href="<?php echo url_for(array(
                                         'module' => 'account', 'action'  => 'edit'
                                    )) ?>" title="Mon compte"><?php echo image_tag('account/menu/myaccountOff_' . strtolower($sf_user->getCulture()) . '.png', array(
                                                                                                                                                                    'alt'    => 'Mon compte',
                                                                                                                                                                    'border' => '0'
                                                                                                                                                               )) ?></a>
        <?php endif ?>


    <?php if ($sf_params->get('module') == "account" && $sf_params->get('action') == "transaction"): ?>
        <a href="<?php echo url_for(array(
                                         'module' => 'account', 'action'  => 'transaction'
                                    )) ?>" title="Mes crédits"><?php echo image_tag('account/menu/mescreditsOn_' . strtolower($sf_user->getCulture()) . '.png', array(
                                                                                                                                                                     'alt'    => 'Mes crédits',
                                                                                                                                                                     'border' => '0',
                                                                                                                                                                     'size'   => '116x46'
                                                                                                                                                                ));?></a>
        <?php else: ?>
        <a href="<?php echo url_for(array(
                                         'module' => 'account', 'action'  => 'transaction'
                                    )) ?>" title="Mes crédits"><?php echo image_tag('account/menu/mescreditsOff_' . strtolower($sf_user->getCulture()) . '.png', array(
                                                                                                                                                                      'alt'    => 'Mes crédits',
                                                                                                                                                                      'border' => '0',
                                                                                                                                                                      'size'   => '116x46'
                                                                                                                                                                 ));?></a>
        <?php endif ?>

    <?php if ($sf_params->get('module') == "account" && $sf_params->get('action') == "prediction"): ?>
        <a href="<?php echo url_for(array(
                                         'module' => 'account', 'action'  => 'prediction'
                                    )) ?>" title="Mes gains"><?php echo image_tag('account/menu/mesgainsOn_' . strtolower($sf_user->getCulture()) . '.png', array(
                                                                                                                                                                 'alt'    => 'Mes gains',
                                                                                                                                                                 'border' => '0',
                                                                                                                                                                 'size'   => '123x46'
                                                                                                                                                            ));?></a>
        <?php else: ?>
        <a href="<?php echo url_for(array(
                                         'module' => 'account', 'action'  => 'prediction'
                                    )) ?>" title="Mes gains"><?php echo image_tag('account/menu/mesgainsOff_' . strtolower($sf_user->getCulture()) . '.png', array(
                                                                                                                                                                  'alt'    => 'Mes gains',
                                                                                                                                                                  'border' => '0',
                                                                                                                                                                  'size'   => '123x46'
                                                                                                                                                             ));?></a>
        <?php endif ?>

    <?php else : ?>
    <ul id="menu">
        <li><a href="<?php echo url_for(array('module' => 'account', 'action' => 'register')) ?>">
            <img src="/images/header/bouton_inscrire_<?php echo strtolower($sf_user->getCulture()) ?>.png" alt="" style="border: none;"/>
        </a>
        </li>
        <li>
            <img src="/images/header/ou_<?php echo strtolower($sf_user->getCulture()) ?>.png" alt="" style="border: none;"/>
        </li>
        <li>
            <img id="boutonConnexionPopup" src="/images/header/bouton_login_<?php echo strtolower($sf_user->getCulture()) ?>.png" alt="" style="border: none;"/>
        </li>
        <?php if (!$sf_user->isAuthenticated()): ?>
        <li><img src="/images/header/slash.png" alt="" style="border: none;"/></li>
        <li>
            <a style="width: 107px; height: 25px; display: block;" href="<?php echo url_for(array(
                                                                                                 'module'  => 'account',
                                                                                                 'action'  => 'loginFacebook'
                                                                                            )) ?>" onclick="loadingButton(this);">
                <?php echo image_tag('facebook/connect.png', array(
                                                                  'alt'  => '', 'border' => '0',
                                                                  'size' => '107x25'
                                                             )); ?>
                <span class="login-loading-button"></span>
            </a>
        </li>
        <?php endif ?>
    </ul>
    <?php include_component('header', 'popup', array()) ?>
    <?php endif; ?>
</div>

<div class="top_facebookjaime">
    <div class="fb-like" data-href="<?php echo sfConfig::get('app_facebook_betkup_page_url') ?>" data-send="false" data-layout="button_count" data-width="250" data-show-faces="false"></div>
</div>
<?php if (sfConfig::get('app_profile') == 'free') { ?>
<script type="text/javascript">
    $('a[href="<?php echo url_for(array(
                                       'module' => 'account', 'action'  => 'transaction'
                                  )) ?>"]').attr('title', '<?php echo addslashes(__('a_title_real_money_bets_unavailable_text'))?>');
    $('a[href="<?php echo url_for(array(
                                       'module' => 'account', 'action'  => 'transaction'
                                  )) ?>"]').tipsy({fade:true, gravity:'n'}).attr("href", "#");

    $('a[href="<?php echo url_for(array(
                                       'module' => 'account', 'action'  => 'updateSimpleAccount'
                                  )) ?>"]').attr('title', '<?php echo addslashes(__('a_title_real_money_bets_unavailable_text'))?>');
    $('a[href="<?php echo url_for(array(
                                       'module' => 'account', 'action'  => 'updateSimpleAccount'
                                  )) ?>"]').tipsy({fade:true, gravity:'n'}).attr("href", "#");
</script>
<?php } ?>
<?php if ($sf_user->IsAuthenticated()) { ?>
<script type="text/javascript">
    $('.top_onglets').css('margin-left', '127px').css('width', '365');
</script>
<?php } ?>
<script type="text/javascript">
    $(function () {

    });

    function loadingButton(obj) {

        var objWidth, objHeight;

        $(obj).css({
            'position':'relative'
        });

        $(obj).find('.login-loading-button').show();
    }
</script>
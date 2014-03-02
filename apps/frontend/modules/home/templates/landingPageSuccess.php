<div id="betkup-description" style="display: none;">
    <p>
        <?php echo __('text_description_seo_betkup_landing_page') ?>
    </p>
</div>
<div id="landing-container">
<div id="landing-header">
    <h1>
        <?php if ($referer == 'facebook') : ?>
        <?php echo __('text_landing_page_header_title', array('%referer%' => '<span class="header-img-facebook"></span>')) ?>
        <?php else : ?>
        <?php echo __('text_landing_page_header_title', array('%referer%' => '<span class="header-default-text">' . $referer . '</span>')) ?>
        <?php endif; ?>
    </h1>

    <p>
        <?php echo __('text_landing_page_welcome_header') ?>
    </p>
</div>
<div class="br-small"></div>

<div id="discover-container">
    <table>
        <tbody>
        <tr>
            <td class="large">
                <h1 class="title">
                    <?php echo __('text_landing_page_discover_betkup') ?>
                </h1>

                <div class="br-small"></div>
                <ul class="discover-list-infos">
                    <li class="list-kups">
                        <span class="thumbnail thumbnail-kups"></span>
                        <?php echo __('text_landing_page_kups_infos') ?>
                    </li>
                    <li class="list-rooms">
                        <span class="thumbnail thumbnail-room"></span>
                        <?php echo __('text_landing_page_rooms_infos') ?>
                    </li>
                    <li class="list-prizes">
                        <span class="thumbnail thumbnail-prizes"></span>
                        <?php echo __('text_landing_page_prizes_infos') ?>
                    </li>
                    <li class="list-jackpot">
                        <span class="thumbnail thumbnail-jackpot"></span>
                        <?php echo __('text_landing_page_jackpot_infos') ?>
                    </li>
                </ul>
                <div class="discover-buttons-container">
                    <table>
                        <tbody>
                        <tr>
                            <td>
                                <span class="right">
                                    <?php echo __('text_landing_page_bold_free') ?>
                                </span>
                                <a href="<?php echo url_for('account/register') ?>" class="discover-subscribe">
                                    <?php echo __('text_landing_page_register') ?>
                                </a>
                            </td>
                            <td>
                                <span class="right">
                                    <?php echo __('text_landing_page_bold_free') ?>
                                </span>
                                <a href="<?php echo url_for('account/loginFacebook') ?>" class="discover-connect">
                                    <?php echo __('text_landing_page_connect') ?>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </td>
            <td class="left">
                <div class="image-link">
                    <a id="video-pop-up-landing" href="https://www.youtube.com/watch?v=4EV-6M1ylHI" title="<?php echo __('text_landing_page_image_teaser_description') ?>" class="video-link" target="_blank">
                            <span class="invisible">
                                <?php echo __('text_landing_page_image_teaser_description') ?>
                            </span>
                    </a>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="br-big"></div>
    <div class="br-small"></div>
    <div class="discover-infos">
        <div class="box-kups-winners">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#box-container-winners">
                        <span class="list-img img-winner"></span>
                        <?php echo __('text_landing_page_winers_tab') ?>
                    </a>
                </li>
                <li>
                    <a href="#box-container-kups">
                        <span class="list-img img-kups"></span>
                        <?php echo __('text_landing_page_kups_tab') ?>
                    </a>
                </li>
            </ul>
            <div class="layout-tabs-container">
                <div class="box-container" id="box-container-winners">
                    <div class="br-small"></div>
                    <?php include_component('home', 'landingWinners', array('winnersData' => $winnersData)) ?>
                </div>
                <div class="box-container" id="box-container-kups">
                    <div class="br-small"></div>
                    <?php include_component('home', 'landingKups', array('kupsData' => $kupsData)) ?>
                </div>
            </div>
        </div>
        <div class="box-security">
            <h3>
                <span class="img-play"></span>
                    <span>
                        <?php echo __('text_landing_page_play_legal') ?>
                    </span>
            </h3>

            <div class="box-security-container">
                <a class="betTrust invisible" href="<?php echo url_for('home/betTrust') ?>">
                    <?php echo __('text_landing_page_why_betkup') ?>
                </a>

                <p class="left">
                    <?php echo __('text_landing_page_payment_secure') ?>
                </p>

                <p class="right">
                    <?php echo __('text_landing_page_federation_thief') ?>
                </p>
            </div>
        </div>
    </div>
    <div class="br-big"></div>
    <div class="br-big"></div>
</div>
<div id="play-container">
    <h1 class="title">
        <?php echo __('text_landing_page_you_to_play') ?>
    </h1>

    <div class="br-big"></div>
    <table>
        <tbody>
        <tr>
            <td>
                <div class="play-box">
                    <div class="br-big"></div>
                    <h3>
                        <?php echo __('text_landing_page_simple_account') ?>
                    </h3>

                    <div class="br-big"></div>
                    <ul>
                        <li>
                            <?php echo __('text_landing_page_free') ?>
                        </li>
                        <li>
                            <?php echo __('text_landing_page_2_minute') ?>
                        </li>
                        <li>
                            <?php echo __('text_landing_page_kup_free_only') ?>
                        </li>
                        <li>
                            <?php echo __('text_landing_page_win_prizes') ?>
                        </li>
                        <li class="disable">
                                <span class="text">
                                    <?php echo __('text_landing_page_bonus_betkup') ?>
                                </span>
                            <span class="ticker"></span>
                        </li>
                        <li class="disable">
                                <span class="text">
                                    <?php echo __('text_landing_page_challenge_win_jackpot') ?>
                                </span>
                            <span class="ticker"></span>
                        </li>
                    </ul>
                    <div class="br-big"></div>
                    <div class="buttons-container">
                        <a class="play-register" href="<?php echo url_for('account/register') ?>">
                            <?php echo __('text_landing_page_register') ?>
                        </a>
                        <a class="play-connect" href="<?php echo url_for('account/loginFacebook') ?>">
                            <?php echo __('text_landing_page_connect') ?>
                        </a>
                    </div>
                    <div class="br-big"></div>
                </div>
            </td>
            <td>
                <div class="play-box">
                    <div class="br-big"></div>
                    <h3>
                        <?php echo __('text_landing_page_gambling_account') ?>
                    </h3>

                    <div class="br-big"></div>
                    <ul>
                        <li>
                            <?php echo __('text_landing_page_free') ?>
                        </li>
                        <li>
                            <?php echo __('text_landing_page_5_minutes') ?>
                        </li>
                        <li>
                            <?php echo __('text_landing_page_free_gambling_account') ?>
                        </li>
                        <li>
                            <?php echo __('text_landing_page_win_prizes_money') ?>
                        </li>
                        <li class="enable">
                                <span class="text">
                                    <?php echo __('text_landing_page_bonus_betkup') ?>
                                </span>
                            <span class="ticker"></span>
                        </li>
                        <li class="enable">
                                <span class="text">
                                    <?php echo __('text_landing_page_challenge_win_jackpot') ?>
                                </span>
                            <span class="ticker"></span>
                        </li>
                    </ul>
                    <div class="br-big"></div>
                    <div class="buttons-container">
                        <a class="play-register" href="<?php echo url_for('account/registerAdvanced') ?>">
                            <?php echo __('text_landing_page_register') ?>
                        </a>
                        <a class="play-connect" href="<?php echo url_for('account/loginFacebook') ?>">
                            <?php echo __('text_landing_page_connect') ?>
                        </a>
                    </div>
                    <div class="br-big"></div>
                </div>
                <div class="play-offer">
                    <div class="double-money"></div>
                    <h2>
                        <?php echo __('text_landing_page_50_free') ?>
                    </h2>

                    <p>
                        <?php echo __('text_landing_page_first_deposit') ?>
                    </p>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="br-big"></div>
</div>
<div class="br-big"></div>
</div>
<script type="text/javascript">
    $(function () {

        $('#video-pop-up-landing').click(function () {
            $.fancybox({
                'padding':0,
                'autoScale':false,
                'transitionIn':'none',
                'transitionOut':'none',
                'title':$(this).attr('title'),
                'width':640,
                'height':360,
                'href':$(this).attr('href').replace(new RegExp("watch\\?v=", "i"), 'v/') + '&autoplay=1',
                'type':'swf',
                'hideOnOverlayClick':false,
                'swf':{
                    'wmode':'transparent',
                    'allowfullscreen':'true'
                }
            });
            return false;
        });

        // Display default active tab.
        var defaultTab;
        defaultTab = $('li.active', $('.nav-tabs')).find('a').attr('href');
        $('div.box-container', $('.layout-tabs-container')).hide();
        $(defaultTab, $('.layout-tabs-container')).show();

        $('a', $('.nav-tabs')).click(function () {
            var href = $(this).attr('href');

            $('li', $('.nav-tabs')).removeClass('active');
            $(this).parent('li').addClass('active');

            $('div.box-container', $('.layout-tabs-container')).hide();
            $(href, $('.layout-tabs-container')).show();

            return false;
        });

    });
</script>
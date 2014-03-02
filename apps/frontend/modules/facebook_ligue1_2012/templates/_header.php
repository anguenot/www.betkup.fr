<div id="header">
    <div class="header-fixed">
        <div id="header-logo"></div>
        <a href="https://www.betkup.fr" target="_blank">
            <span id="header-logo-betkup"></span>
        </a>

        <?php if ($action != 'landingPage') : ?>
        <div class="l1-progress-bar">
            <table id="l1-progress-bar-text-table">
                <tbody>
                <tr>
                    <td>Installer l'application</td>
                    <td>Devenir fan</td>
                    <td>Pronostiquer</td>
                    <td>Revenir</td>
                </tr>
                </tbody>
            </table>
            <div class="progress progress-striped">
                <div class="bar" style="width: <?php echo $progress ?>%;">
                    <span><?php echo $progress ?>%</span>
                </div>
            </div>
            <table id="l1-progress-bar-picto-table">
                <tbody>
                <tr>
                    <td>
                        <div class="<?php echo $progress >= 25 ? "progress-picto-selected" : "progress-picto" ?>"></div>
                    </td>
                    <td>
                        <div class="<?php echo $progress >= 50 ? "progress-picto-selected" : "progress-picto" ?>"></div>
                    </td>
                    <td>
                        <div class="<?php echo $progress >= 75 ? "progress-picto-selected" : "progress-picto" ?>"></div>
                    </td>
                    <td>
                        <div class="<?php echo $progress >= 100 ? "progress-picto-selected" : "progress-picto" ?>"></div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <div class="header-social-box">
            <div class="fb-like" data-href="<?php echo sfConfig::get('app_facebook_betkup_page_url')?>" data-send="false" data-layout="button_count" data-width="200" data-show-faces="true" data-font="lucida grande"></div>
        </div>
    </div>
</div>
<?php if ($action != 'landingPage') : ?>
<?php include_component('facebook_ligue1_2012', 'menu') ?>
<?php endif; ?>
<div class="row-fluid menu-bar">
    <div class="span1"></div>
    <div class="span10">
        <ul class="menu">
            <li>
                <a href="<?php echo url_for('@facebook_ligue1_2012_home') ?>" class="<?php echo $sf_params->get('action') == 'home' ? 'selected' : '' ?>">Accueil</a>
            </li>
            <li>
                <a href="<?php echo url_for('@facebook_ligue1_2012_predictions') ?>" class="<?php echo $sf_params->get('action') == 'predictions' ? 'selected' : '' ?>">Pronostics</a>
            </li>
            <li>
                <a href="<?php echo url_for('@facebook_ligue1_2012_club') ?>" class="<?php echo $sf_params->get('action') == 'club' ? 'selected' : '' ?>">
                    <span class="textClub">Mon club</span>
                    <?php echo image_tag($clubLogo, array('size' => '35x35')) ?>
                </a>
            </li>
            <li>
                <a href="<?php echo url_for('@facebook_ligue1_2012_results') ?>" class="<?php echo $sf_params->get('action') == 'results' ? 'selected' : '' ?>">Résultats</a>
            </li>
            <li>
                <a href="<?php echo url_for('@facebook_ligue1_2012_ranking') ?>" class="<?php echo $sf_params->get('action') == 'ranking' ? 'selected' : '' ?>">Classement</a>
            </li>
            <li>
                <a href="<?php echo url_for('@facebook_ligue1_2012_rules') ?>" class="<?php echo $sf_params->get('action') == 'rules' ? 'selected' : '' ?>">Lots/Règles</a>
            </li>
        </ul>
    </div>
    <div class="span1"></div>
</div>
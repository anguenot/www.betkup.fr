<div class="row-fluid">
    <div class="span1"></div>
    <div class="span10">
        <div class="kup-header-container">
            <?php include_component('kup', 'kupHeader', array('kupData' => $kupData)) ?>
        </div>
        <div class="br-big"></div>
        <h1 class="catchphrase">
            <b><?php echo $username ?></b> a joué sur l'application Pronos Ligue 1 de Betkup ! <br />Viens défendre les couleurs de ton
            club de coeur, <b>1 jeu FIFA 2013</b> à gagner par journée et plus de <b>9000€</b> en jeu.
            <br /><br />
            <a class="button-link" href="<?php echo $siteUrl ?>" style="font-size: 30px;" target="_blank">
                Pronostiquer !
            </a>
        </h1>
        <div class="br-big"></div>
        <div class="br-big"></div>
        <div class="row-fluid boxes-container">
            <div class="span12 box-infos">
                <div class="home-box">
                    <div class="home-box-header">
                        <span class="home-title-promo-betkup"></span>

                        <h2>Découvrir l'APP facebook Ligue1</h2>
                    </div>
                    <div class="home-box-content" id="ligue1-promo-box">
                        <?php echo image_tag('/image/default/facebook_ligue1_2012/interface/ligue1_promo.jpeg', array('style' => 'width:100%;')) ?>
                        <div class="promo-button">
                            <a class="button-link" style="font-size: 30px;" href="<?php echo $siteUrl ?>" target="_blank">
                                Jouer et gagner !
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="br-big"></div>
    </div>
    <div class="span1"></div>
</div>
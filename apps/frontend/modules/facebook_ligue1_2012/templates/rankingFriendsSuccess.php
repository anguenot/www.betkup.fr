<div class="row-fluid">
    <div class="span6">
        <div class="ranking-box-container">
            <div class="ranking-header">
                <span class="home-title-ranking"></span>

                <h2>
                    Classement des amis
                </h2>
            </div>
            <div class="ranking-content">
                <div class="loading-content" id="loading-ranking-individual-content"></div>
            </div>
        </div>
        <div class="br-big"></div>
        <!--
        <div class="ranking-box-container">
            <div class="ranking-header">
                <span class="home-title-last-game"></span>

                <h2>
                    Tableau d'honneur dernière journée
                </h2>
            </div>
            <div class="ranking-content"></div>
        </div>
        -->
    </div>
    <div class="span6">
        <div class="ranking-box-container">
            <div class="ranking-header">
                <span class="home-title-friends"></span>

                <h2>
                    Mes amis n'ayant pas l'application
                </h2>
            </div>
            <div class="ranking-content">
                <div class="loading-content" id="loading-friends-content"></div>
                <div class="br-small"></div>
                <div class="button">
                    <a href="javascript:void(0);" onclick="sendRequestViaMultiFriendSelector()">
                        Défier plus d'amis !
                    </a>
                    <a href="javascript:void(0);" onclick="facebookWallPublish()">
                        Publier sur mon Wall !
                    </a>
                </div>
            </div>
        </div>
        <div class="br-big"></div>
        <div class="ranking-box-container">
            <div class="ranking-header">
                <span class="home-title-prizes"></span>

                <h2>
                    Lots
                </h2>
            </div>
            <div class="ranking-content">
                <div class="br-small"></div>
                <?php echo image_tag('/image/default/facebook_ligue1_2012/prizes/prizes.png', array('size' => '358x132')) ?>
                <div class="br-small"></div>
                <div class="button">
                    <a href="<?php echo url_for('facebook_ligue1_2012_rules') ?>">
                        En savoir plus
                    </a>
                </div>
            </div>
        </div>
        <div class="br-big"></div>
        <div class="ranking-box ranking-box-promo">
            <div class="ranking-header">
                <span class="home-title-promo-betkup"></span>

                <h2>Découvrir betkup</h2>
            </div>
            <div class="ranking-content" id="betkup-promo-box">
                <?php echo image_tag('/image/default/facebook_ligue1_2012/interface/betkup_promo.jpeg', array('style' => 'width:100%;')) ?>
                <div class="promo-button">
                    <a class="betkup-facebook" href="<?php echo sfConfig::get('app_facebook_betkup_page_url')?>" target="_blank">
                        &nbsp;
                    </a>
                    <a class="button-link" href="https://www.betkup.fr" target="_blank">
                        Découvrir
                    </a>
                    <a class="betkup-twitter" href="https://twitter.com/betkup" target="_blank">
                        &nbsp;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="br-big"></div>
<script type="text/javascript">
    $(function () {
        $('#loading-friends-content').loadContent({
            'url':'<?php echo url_for(array(
                                           'module'  => 'facebook_ligue1_2012',
                                           'action'  => 'homeFriendsToInvite'
                                      )); ?>',
            'method':'POST',
            data:{
                'access_token':'<?php echo $sf_data->getRaw('access_token') ?>'
            }
        }, "resizeCanvas()");
        loadRanking(0, 11);
    });

    function loadRanking(offset, batchSize) {
        $('#loading-ranking-individual-content').loadContent({
            'url':'<?php echo url_for(array(
                                           'module'  => 'facebook_ligue1_2012',
                                           'action'  => 'rankingBoxFriends'
                                      )); ?>',
            'method':'POST',
            data:{
                'access_token':'<?php echo $sf_data->getRaw('access_token') ?>',
                'offset' : offset,
                'batchSize' : batchSize,
                'kup_uuid' : '',
                'room_uuid' : ''
            }
        }, "resizeCanvas()");
    }
</script>
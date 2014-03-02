<div class="row-fluid">
    <div class="span1"></div>
    <div class="span10">
        <div class="club-header">
            <?php echo image_tag($clubHeader, array('size' => '809x120')) ?>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <div class="club-infos">
                    <div class="club-box club-box-infos">
                        <div class="club-box-header">
                            <span class="club-title-infos"></span>

                            <h2>
                                Fiche de club
                            </h2>
                        </div>
                        <div class="club-box-content">
                            <h2>
                                <b>Nom du club :</b> <?php echo $club[0]['ui']['name'] ?>
                            </h2>

                            <div class="club-logo">
                                <?php echo image_tag($club[0]['ui']['avatar_big'], array('size' => '80x80')) ?>
                            </div>
                            <h2>
                                <b>Nombre de membres :</b> <?php echo $club[0]['numberOfMembers'] ?>
                            </h2>

                            <h2>
                                <b>Nombre de points :</b> <?php echo $club[0]['rankingPoints'] ?>
                            </h2>

                            <h2>
                                <b>Classement actuel :</b> N/C
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="br-big"></div>
                <div class="club-ranking">
                    <div class="club-box club-box-ranking">
                        <div class="club-box-header">
                            <span class="club-title-ranking"></span>

                            <h2>
                                Le 11 titulaire
                            </h2>
                        </div>
                        <div class="club-box-content">
                            <div id="loading-content-ranking"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="club-box-friends">
                    <div class="club-box club-box-friends">
                        <div class="club-box-header">
                            <span class="club-title-friends"></span>

                            <h2>
                                Inviter des amis dans mon club
                            </h2>
                        </div>
                        <div class="club-box-content">
                            <div id="loading-content"></div>
                        </div>
                        <div class="button">
                            <a href="javascript:void(0);" onclick="sendRequestViaMultiFriendSelector()">
                                Inviter des amis !
                            </a>
                            <a href="javascript:void(0);" onclick="facebookWallPublish()">
                                Publier sur mon Wall !
                            </a>
                        </div>
                    </div>
                </div>
                <div class="br-big"></div>
                <div class="club-box club-box-feed">
                    <div class="club-box-header">
                        <span class="club-title-feed"></span>

                        <h2>
                            Flux infos mon club
                        </h2>
                    </div>
                    <div class="club-box-feed-content" id="loading-content-feed"></div>
                </div>
                <div class="br-big"></div>
                <div class="club-box club-box-promo">
                    <div class="club-box-header">
                        <span class="home-title-promo-betkup"></span>

                        <h2>Découvrir betkup</h2>
                    </div>
                    <div class="club-box-content" id="betkup-promo-box">
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
    </div>
    <div class="span1"></div>
</div>
<div class="br-big"></div>
<div class="row-fluid">
    <div class="span1"></div>
    <div class="span10">
        <div class="club-box">
            <div class="club-box-header">
                <span class="club-title-wall"></span>

                <h2>
                    Wall de club
                </h2>
            </div>
            <div class="club-box-content">
                <div class="club-box-comments">
                    <div class="fb-comments" data-href="<?php echo $commentUrl ?>" data-num-posts="10" data-width="809"></div>
                </div>
            </div>

        </div>
    </div>
    <div class="span1"></div>
</div>
<div class="br-big"></div>
<div class="br-big"></div>
<script type="text/javascript">
    $(function () {
        $('#loading-content').loadContent({
            'url':'<?php echo url_for(array(
                                           'module'  => 'facebook_ligue1_2012',
                                           'action'  => 'clubFriends'
                                      )); ?>',
            'method':'POST',
            data:{
                'access_token': <?php echo json_encode($sf_data->getRaw('access_token')) ?>
            }
        }, "resizeCanvas()");

        $('#loading-content-ranking').loadContent({
            'url':'<?php echo url_for(array(
                                           'module'  => 'facebook_ligue1_2012',
                                           'action'  => 'clubRankingBox'
                                      )); ?>',
            'method':'POST',
            data:{
                'club_uuid' : '<?php echo $club[0]['uuid'] ?>'
            }
        }, "resizeCanvas()");

        $('#loading-content-feed').loadContent({
            'url':'<?php echo url_for(array(
                                           'module'  => 'facebook_ligue1_2012',
                                           'action'  => 'clubBoxFeed'
                                      )); ?>',
            'method':'POST',
            data:{
                'club_name' : '<?php echo $club_name ?>'
            }
        }, "resizeCanvas()");
    });

    function sendRequestToRecipients(facebookId) {
        FB.ui({
            method:'apprequests',
            message:'<?php echo $publishMessageFacebook ?>',
            to:facebookId
        }, function (response) {
            if(response.request != '') {
                alert('Requête envoyée ou déjà envoyée.');
            }
        });
    }

    function sendRequestViaMultiFriendSelector() {
        FB.ui({
            method:'apprequests',
            message:'<?php echo $publishMessageFacebook ?>'
        }, function (response) {
            if(response != 'undefined' && response != null) {
                alert('Requêtes envoyées.');
            }
        });
    }

    function facebookWallPublish() {
        FB.ui({
            method: 'feed',
            link: '<?php echo $publishLink ?>',
            name: '<?php echo $publishTitle ?>',
            description: '<?php echo $publishDescription ?>'
        })
    }
</script>
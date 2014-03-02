<div class="row-fluid">
    <div class="span1"></div>
    <div class="span5">
        <div class="home-box">
            <div class="home-box-header">
                <span class="home-title-next-game"></span>

                <h2>
                    Prochaine journée
                </h2>
                <?php include_component('facebook_tdf', 'chrono', array(
                                                                       'kupData'  => isset($kupData) ? $kupData : array(),
                                                                       'chronoId' => 'next-race'
                                                                  ))?>
            </div>
            <div class="home-box-content" id="home-next-match">
                <div id="loading-content-next-match"></div>
            </div>
        </div>
        <div class="home-box">
            <div class="home-box-header">
                <span class="home-title-ranking"></span>

                <h2>
                    Classement Club
                </h2>
            </div>
            <div class="home-box-content" id="home-club-ranking">
                <div id="loading-content-club-ranking"></div>
            </div>
            <div class="button">
                <a href="<?php echo url_for('facebook_ligue1_2012_ranking') ?>">
                    Voir tous les classements
                </a>
            </div>
        </div>
    </div>
    <div class="span5">
        <div class="home-box">
            <div class="home-box-header">
                <span class="home-title-how-to"></span>

                <h2>Comment jouer ?</h2>
            </div>
            <?php include_component('facebook_ligue1_2012', 'homeHowTo') ?>
        </div>

        <div class="home-box">
            <div class="home-box-header">
                <span class="home-title-my-ranking"></span>

                <h2>Mes classements</h2>
            </div>
            <div class="home-box-content">
                <div id="loading-content-box-my-ranking"></div>
            </div>
            <div class="button">
                <a href="<?php echo url_for('facebook_ligue1_2012_ranking') ?>">
                    Voir les classements
                </a>
            </div>
        </div>
        <div class="home-box">
            <div class="home-box-header">
                <span class="home-title-leaders"></span>

                <h2>Les leaders</h2>
            </div>
            <div class="home-box-content">
                <div id="loading-content-box-leader"></div>
            </div>
            <div class="button">
                <a href="<?php echo url_for('facebook_ligue1_2012_ranking') ?>">
                    Voir les classements
                </a>
            </div>
        </div>

        <div class="home-box">
            <div class="home-box-header">
                <span class="home-title-friends"></span>

                <h2>Mes amis</h2>
            </div>
            <?php include_component('facebook_ligue1_2012', 'homeFriends') ?>
        </div>

        <div class="home-box">
            <div class="home-box-header">
                <span class="home-title-promo-betkup"></span>

                <h2>Découvrir betkup</h2>
            </div>
            <?php include_component('facebook_ligue1_2012', 'homeBetkupPromo') ?>
        </div>
    </div>
    <div class="span1"></div>
</div>
<script type="text/javascript">
    $(function () {

    <?php if ($sf_user->getAttribute('clubId', '', 'subscriber') != '') : ?>

            $('#loading-content-next-match').loadContent({
                'url':'<?php echo url_for(array(
                                               'module'  => 'facebook_ligue1_2012',
                                               'action'  => 'homeNextMatch'
                                          )); ?>',
                'method':'POST',
                data:{
                    'access_token': <?php echo json_encode($sf_data->getRaw('access_token')) ?>,
                    'kup_uuid':'<?php echo isset($kup_uuid) ? $kup_uuid : '0'  ?>',
                    'room_uuid':'<?php echo isset($room_uuid) ? $room_uuid : '0' ?>'
                }
            }, "resizeCanvas()");

            $('#loading-content-box-my-ranking').loadContent({
                'url':'<?php echo url_for(array(
                                               'module'  => 'facebook_ligue1_2012',
                                               'action'  => 'homeBoxMyRanking'
                                          )); ?>',
                'method':'POST',
                data:{}
            }, "resizeCanvas()");

            $('#loading-content-ranking').loadContent({
                'url':'<?php echo url_for(array(
                                               'module'  => 'facebook_ligue1_2012',
                                               'action'  => 'homeFriendsRanking'
                                          )); ?>',
                'method':'POST',
                data:{
                    'room_uuid':'<?php echo isset($room_uuid) ? $room_uuid : '0' ?>'
                }
            }, "resizeCanvas()");

            $('#loading-content').loadContent({
                'url':'<?php echo url_for(array(
                                               'module'  => 'facebook_ligue1_2012',
                                               'action'  => 'homeFriendsToInvite'
                                          )); ?>',
                'method':'POST',
                data:{
                    'access_token': <?php echo json_encode($sf_data->getRaw('access_token')) ?>
                }
            }, "resizeCanvas()");

            $('#loading-content-club-ranking').loadContent({
                'url':'<?php echo url_for(array(
                                               'module'  => 'facebook_ligue1_2012',
                                               'action'  => 'homeClubRanking'
                                          )); ?>',
                'method':'POST',
                'queue' : true,
                'queueName' : 'app_ligue1_home_club_ranking_leader',
                data:{}
            }, "resizeCanvas()");

            $('#loading-content-box-leader').loadContent({
                'url':'<?php echo url_for(array(
                                               'module'  => 'facebook_ligue1_2012',
                                               'action'  => 'homeBoxLeader'
                                          )); ?>',
                'method':'POST',
                'queue' : true,
                'queueName' : 'app_ligue1_home_club_ranking_leader',
                'executeQueue': true,
                data:{}
            }, "resizeCanvas()");

    <?php endif; ?>
    });

    function sendRequestToRecipients(facebookId) {
        FB.ui({
            method:'apprequests',
            message:'<?php echo isset($publishMessageFacebook) ? $publishMessageFacebook : '' ?>',
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
            filters:['app_non_users'],
            message:'<?php echo isset($publishMessageFacebook) ? $publishMessageFacebook : '' ?>'
        }, function (response) {
            if(response != 'undefined' && response != null) {
                alert('Requêtes envoyées.');
            }
        });
    }

    function facebookWallPublish() {
        FB.ui({
            method:'feed',
            link:'<?php echo $publishLink ?>',
            name:'<?php echo $publishTitle ?>',
            description:'<?php echo $publishDescription ?>'
        })
    }
</script>
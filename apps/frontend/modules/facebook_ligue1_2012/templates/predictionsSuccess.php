<div class="row-fluid">
    <div class="span1"></div>
    <div class="span10">
        <div class="predictions-container">
            <div class="predictions-header">
                <span class="home-title-next-game"></span>

                <h2>
                    Pronostics
                </h2>
                <?php include_component('facebook_tdf', 'chrono', array(
                                                                       'kupData'  => $kupData,
                                                                       'chronoId' => 'next-race'
                                                                  ))?>
            </div>
            <h1 class="kup-title">
                <?php echo $kupData['title'] ?>
            </h1>
            <div class="predictions-participation">
                <div class="predictions-content">
                    <div class="participation">
                        <?php if ($kupData['is_participant'] == 'true') : ?>
                        <div class="is-participant"></div>
                        <p>Participation validée</p>
                        <?php else: ?>
                        <div class="not-participant"></div>
                        <p>Participation non validée</p>
                        <?php endif; ?>
                    </div>
                    <?php include_component('soccer', 'predictions', array(
                                                                          'kup_uuid'     => $kup_uuid,
                                                                          'room_uuid'    => $room_uuid,
                                                                          'kupData'      => $kupData,
                                                                          'redirect_url' => url_for('@facebook_ligue1_2012_predictions_save?is_saved=1')
                                                                     )) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="span1"></div>
</div>
<div class="br-big"></div>
<div class="row-fluid">
    <div class="span1"></div>
    <div class="span5">
        <div class="predictions-box">
            <div class="predictions-box-header">
                <span class="home-title-promo-betkup"></span>

                <h2>Découvrir betkup</h2>
            </div>
            <div class="predictions-box-content" id="betkup-promo-box">
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
        <div class="br-big"></div>
        <div class="predictions-box-prizes">
            <div class="predictions-box-header">
                <span class="predictions-title-prizes"></span>

                <h2>
                    Lots
                </h2>
            </div>
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
    <div class="span5">
        <div class="predictions-box-feed">
            <div class="predictions-box-header">
                <span class="predictions-title-feed"></span>

                <h2>
                    Flux Ligue 1
                </h2>
            </div>
            <div class="predictions-box-feed-content" id="box-feed-content"></div>
        </div>
    </div>
    <div class="span1"></div>
</div>
<div class="br-big"></div>
<script type="text/javascript">
    var timer;
    $(function () {
        $('#box-feed-content').loadContent({
            'url':'<?php echo url_for(array(
                                           'module'  => 'facebook_ligue1_2012',
                                           'action'  => 'predictionsBoxFeed'
                                      )); ?>',
            'method':'GET',
            data:{}
        });

    <?php if ($is_saved == 1) : ?>
            timer = setInterval("facebookWallPublish()", 600);
            <?php endif; ?>
    });

    function facebookWallPublish() {
        if (isFBLoaded) {
            FB.ui({
                method:'feed',
                link:'<?php echo $publishLink ?>',
                name:'<?php echo $publishTitle ?>',
                description:'<?php echo $publishDescription ?>',
                properties: <?php echo json_encode($sf_data->getRaw('publishProperties')) ?>
            });
            clearInterval(timer);
        }
    }

</script>
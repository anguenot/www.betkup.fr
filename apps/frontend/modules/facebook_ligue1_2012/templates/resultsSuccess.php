<div class="row-fluid">
    <div class="span1"></div>
    <div class="span10">
        <div class="results-box">
            <div class="results-box-header">
                <h2>Résultats</h2>
            </div>
            <div class="results-box-contents">
                <div class="br-small"></div>
                <?php if (count($kupsData) > 0): ?>
                <form action="" method="post" id="select-kups-form">
                    <label for="select-kups">Choisir une journée : </label>
                    <select name="kup_uuid" id="select-kups">
                        <?php foreach ($kupsData as $kupData) : ?>
                        <option value="<?php echo $kupData['uuid'] ?>" <?php echo $kupData['uuid'] == $kup_uuid ? 'selected="selected"' : '' ?>>
                            <?php echo $kupData['name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <?php endif; ?>
                <div class="br-small"></div>
                <div class="results-contents">
                    <?php include_component(
                    'soccer', 'results',
                    array(
                         'kup_uuid'  => $kup_uuid,
                         'room_uuid' => $room_uuid,
                         'kupData'   => $kupData
                    )) ?>
                </div>
                <div class="br-small"></div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <div class="results-box">
                    <div class="results-box-header">
                        <span class="home-title-promo-betkup"></span>

                        <h2>Découvrir betkup</h2>
                    </div>
                    <div class="results-box-content" id="betkup-promo-box">
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
            <div class="span6">
                <div class="results-box results-box-prizes">
                    <div class="results-box-header">
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
        </div>

    </div>
    <div class="span1"></div>
</div>
<div class="br-big"></div>
<script type="text/javascript">
    $(function () {

        $('#select-kups').selectmenu({
            style:'dropdown',
            width:200,
            menuWidth:200
        });

        $('#select-kups').change(function () {

            $('.results-box-contents').loadingModal();
            $('#select-kups-form').submit();
        });
    });
</script>
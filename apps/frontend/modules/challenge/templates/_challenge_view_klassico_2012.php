<?php use_stylesheet('challenge/challenge.css') ?>
<?php use_stylesheet('challenge/klassico.css') ?>
<div style="margin-left: 8px;">
    <?php include_component('room', 'header', array('data'=> $dataRoom, 'roomUI' => $roomUI)) ?>
</div>
<?php include_component('room', 'tabsHome', array(
                                                 'numTab'  => '1', 'id' => '1', 'roomUI' => $roomUI,
                                                 'tabs'    => $dataTabs
                                            )) ?>
<?php include_component('interface', 'areaOneBegin') ?>
<div style="height: 30px;"></div>
<div style="width: 730px; height: 90px; margin-left: -11px; margin-top: -20px; background: url('/challenge/klassico_2012/image/sprite_challenge_klassico.png');"></div>
<div style="width: 730px; margin-left: -11px; margin-top: 20px;">
    <div class="span7">
        <div class="blazon">
            <p>1</p>
        </div>
        <p class="header-text">
            <?php echo __('text_challenge_klassico_infos_1') ?>
        </p>
        <a href="#" class="plus-button-focus">
            <span class="plus"></span>
        </a>
        <br/>

        <div class="arrow-down"></div>
        <br/>

        <div class="kups">
            <table class="kups-table">
                <tbody>
                <tr>
                    <td style="width: 150px;">
                        <div class="kup-pic pic-om-psg"></div>
                    </td>
                    <td>
                        <h2>OM - PSG</h2>

                        <p><span class="pic-bet"></span><?php echo __('text_klassico_stake') ?> : <b>5 €</b></p>

                        <p title="minimum garanti"><span class="pic-mg"></span><?php echo __('text_klassico_mg') ?> : <b>300 €</b></p>

                        <p>20 <?php echo __('text_klassico_winners') ?></p>

                        <div class="button-container">
                            <a class="prediction-button" href="<?php echo url_for(array('module' => 'kup', 'action' => 'view', 'uuid' => '201212015')) ?>"></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 150px;">
                        <div class="kup-pic pic-barca-real"></div>
                    </td>
                    <td>
                        <h2>BARCA - REAL</h2>

                        <p><span class="pic-bet"></span><?php echo __('text_klassico_stake') ?> : <b>4 €</b></p>

                        <p title="minimum garanti"><span class="pic-mg"></span><?php echo __('text_klassico_mg') ?> : <b>200 €</b></p>

                        <p>20 <?php echo __('text_klassico_winners') ?></p>

                        <div class="button-container">
                            <a class="prediction-button" href="<?php echo url_for(array('module' => 'kup', 'action' => 'view', 'uuid' => '20124002')) ?>"></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 150px;">
                        <div class="kup-pic pic-milan-inter"></div>
                    </td>
                    <td>
                        <h2>MILAN - INTER</h2>

                        <p><span class="pic-bet"></span><?php echo __('text_klassico_stake') ?> : <b>2 €</b></p>

                        <p title="minimum garanti"><span class="pic-mg"></span><?php echo __('text_klassico_mg') ?> : <b>100 €</b></p>

                        <p>20 <?php echo __('text_klassico_winners') ?></p>

                        <div class="button-container">
                            <a class="prediction-button" href="<?php echo url_for(array('module' => 'kup', 'action' => 'view', 'uuid' => '20125002')) ?>"></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 150px;">
                        <div class="kup-pic pic-kross-klassico"></div>
                    </td>
                    <td>
                        <h2>KROSS KLASSICO</h2>

                        <p><span class="pic-bet"></span><?php echo __('text_klassico_stake') ?> : <b>0 €</b></p>

                        <p title="minimum garanti"><span class="pic-mg"></span><?php echo __('text_klassico_mg') ?> : <b>200 €</b></p>

                        <p>30 <?php echo __('text_klassico_winners') ?></p>

                        <div class="button-container">
                            <a class="prediction-button" href="<?php echo url_for(array('module' => 'kup', 'action' => 'view', 'uuid' => '1104')) ?>"></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 150px;">
                        <div class="kup-pic pic-k8-klassico"></div>
                    </td>
                    <td>
                        <h2>K8 KLASSICO</h2>
                        <p><span class="pic-bet"></span><?php echo __('text_klassico_stake') ?> : <b>5 €</b></p>

                        <p title="minimum garanti"><span class="pic-mg"></span>MG : <b>0 €</b></p>

                        <p>5 <?php echo __('text_klassico_winners') ?></p>

                        <div class="button-container">
                            <a class="prediction-button" href="<?php echo url_for(array('module' => 'kup', 'action' => 'view', 'uuid' => '20124003')) ?>"></a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="span5">
        <div class="blazon">
            <p>2</p>
        </div>
        <p class="header-text">
            <?php echo __('text_challenge_klassico_infos_2') ?>
        </p>
        <br/>

        <div class="arrow-down"></div>
        <br/>

        <div class="winnings">
            <div class="jackpot"></div>
            <table class="repartition-table">
                <thead>
                <tr>
                    <th colspan="2">
                        <?php echo __('text_klassico_jackpot_repartition') ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="even">
                    <td>
                        <?php echo image_tag('/images/room/right/kup_0.png') ?>
                        1er
                    </td>
                    <td>
                        <b>100€</b>
                    </td>
                </tr>
                <tr class="odd">
                    <td>
                        <?php echo image_tag('/images/room/right/kup_1.png') ?>
                        2eme
                    </td>
                    <td>
                        <b>60€</b>
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <?php echo image_tag('/images/room/right/kup_2.png') ?>
                        3eme
                    </td>
                    <td>
                        <b>40€</b>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="more-infos" class="footer-infos">
        <a href="#" class="plus-button-link" style="margin-left: 10px;">
            <span class="plus"></span>
            <span><?php echo __('text_room_home_more_infos') ?></span>
        </a>

        <div id="more-infos-container">
            <?php echo __('text_klassico_infos_container') ?>
        </div>
    </div>
    <div style="height: 40px;"></div>
</div>
<?php include_component('interface', 'areaOneEnd') ?>
<script type="text/javascript">
    $(function () {
        $('.plus-button-link').click(function () {
            if ($('#more-infos').hasClass('open')) {
                $('#more-infos').removeClass('open');
                $('#more-infos-container').hide();
            } else {
                $('#more-infos').addClass('open');
                $('#more-infos-container').show();
            }
            return false;
        });

        $('.plus-button-focus').click(function() {
            $('.plus-button-link').trigger('click');
            $('body').animate({scrollTop: $('#more-infos').offset().top},400,'easeInOutCubic');
            return false;
        });
    });
</script>
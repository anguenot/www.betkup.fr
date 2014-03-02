<div class="blocKup" style="background: url('<?php echo $imgBackground ?>');">
    <div class="titre <?php echo $cssTitleBloc ?>" style="overflow: hidden; height: 20px;">
        <?php if (isset($kup['roomUUID']) && $kup['roomUUID'] != 740) : ?>
        <a href="<?php echo url_for(array(
                                         'module'  => 'room',
                                         'action' => 'view',
                                         'uuid'    => $kup['roomUUID']
                                    )) ?>">
            <span class="picto-mini-room"></span>
            <span title="<?php echo $kup['roomName'] ?>">
                <?php echo Util::coupe((($isChallenge) ? $kup['roomName'] : 'Room ' . $kup['roomName']), 25, '..')?>
            </span>
        </a>
        <?php else : ?>
        <a href="<?php echo url_for(array(
                                         'module'        => 'kup',
                                         'action'        => 'home',
                                         'selectedDatas' => array(
                                             $typeSport,
                                             'STAKE_ALL',
                                             'status_IN_PROGRESS',
                                             'status_IN_COMMING',
                                             'SORTING_START_DATE'
                                         )
                                    )) ?>">
            <span class="picto-mini-room" style="background: url('/kup/default/<?php echo $kup['picto_mini'] ?>') center no-repeat;"></span>
            <span title="<?php echo $kup['rubrique'] ?>">
                <?php echo $kup["rubrique"] ?>
            </span>
        </a>
        <?php endif;?>
    </div>
    <div style="clear:both;"></div>
    <div class="identity" style="cursor: pointer;" onclick="document.location.href = '<?php echo $urlToKupView ?>';">
        <?php if (isset($kup['ui']['with_text']) && $kup['ui']['with_text'] == 1) : ?>
        <h1 class="titleKup" style="font-size: <?php echo isset($kup['ui']['font_size']) && isset($kup['ui']['font_size']['small_box']['title']) ? $kup['ui']['font_size']['small_box']['title'] : '' ?>;
                font-family: '<?php echo isset($kup['ui']['font_family']) ? $kup['ui']['font_family'] : 'Arial' ?>', Helvetica, Arial, sans-serif;
                color: <?php echo isset($kup['ui']['color']) ? $kup['ui']['color'] : '' ?>;">
            <?php echo $kup['title'] ?>
        </h1>
        <p class="descKup" style="font-size: <?php echo isset($kup['ui']['font_size']) && isset($kup['ui']['font_size']['small_box']['description']) ? $kup['ui']['font_size']['small_box']['description'] : '' ?>;
                font-family: Arial, sans-serif;
                color: <?php echo isset($kup['ui']['color']) ? $kup['ui']['color'] : '' ?>;">
            <?php echo $kup['description'] ?>
        </p>
        <?php endif; ?>
    </div>
    <div class="tools" style="cursor: pointer;" onclick="document.location.href = '<?php echo $urlToKupView ?>';">
        <?php if ($kup['is_participant']) : ?>
        <div class="kup-is-participant"></div>
        <?php endif;?>
        <table style="width: 100%; border-spacing: 0; border-collapse:collapse;">
            <tr>
                <td width="50%" valign="top">
                    <a class="toolsItems" href="javascript:void(0);" title="Cagnotte">
                        <?php echo image_tag('kup/home/tools_cagnotte.png', array(
                                                                                 'align' => 'absmiddle',
                                                                                 'alt'   => 'Cagnotte',
                                                                                 'size'  => '21x16'
                                                                            )) ?><?php if ($kup["type"] == sfConfig::get('mod_kup_type_free')): ?><?php echo __('kup_home_prizes_value'); ?>
                        :<?php else: ?><?php echo __('kup_blocKup_jackpot_text'); ?><?php endif ?>
                        <span class="dataValue colored"><?php echo $kup['type'] == sfConfig::get('mod_kup_type_free') ? ($kup['is_template'] == 1 ? round($kup["ui"]["prizeValue"], 2) . ' €' : '-') : round($kup['jackpot'], 2) . ' €' ?></span></a>
                    <a class="toolsItems" href="javascript:void(0);" title="Durée"><?php echo image_tag('kup/home/tools_duree.png', array(
                                                                                                                                         'align' => 'absmiddle',
                                                                                                                                         'alt'   => 'Durée',
                                                                                                                                         'size'  => '21x16'
                                                                                                                                    )) ?><?php echo __('kup_blocKup_time_text');?>
                        <span class="dataValue"> <?php echo $kup['length'] ?> j</span></a>
                    <a class="toolsItems" href="javascript:void(0);" title="Participants"><?php echo image_tag('kup/home/tools_participant.png', array(
                                                                                                                                                      'align' => 'absmiddle',
                                                                                                                                                      'alt'   => 'Participants',
                                                                                                                                                      'size'  => '21x16'
                                                                                                                                                 )) ?>
                        <span class="dataValue"><?php echo $kup["legend3"] ?></span> <?php echo __('kup_blocKup_participants_text');?>
                    </a>
                </td>
                <td width="50%" valign="top">
                    <a class="toolsItems" href="javascript:void(0);" title="Mise"><?php echo image_tag('kup/home/tools_mise.png', array(
                                                                                                                                       'align' => 'absmiddle',
                                                                                                                                       'alt'   => 'Mise',
                                                                                                                                       'size'  => '21x16'
                                                                                                                                  )) ?><?php echo __('kup_blocKup_stake_text');?>
                        <span class="dataValue"> <?php echo $kup['stake'] ?> €</span></a>
                    <a class="toolsItems" href="javascript:void(0);" title="Evenements"><?php echo image_tag('kup/home/tools_evenements.png', array(
                                                                                                                                                   'align' => 'absmiddle',
                                                                                                                                                   'alt'   => 'Evenements',
                                                                                                                                                   'size'  => '21x16'
                                                                                                                                              )) ?><?php echo $kup['ui']['events'] == (isset($kup["ui"]["events"])) ? $kup["ui"]["events"] : '' ?></a>
                    <a class="toolsItems" href="javascript:void(0);" title="Vainqueurs"><?php echo image_tag('/images/kup/view/tabs-puce2-on.png', array(
                                                                                                                                                        'align' => 'absmiddle',
                                                                                                                                                        'alt'   => 'Vainqueurs',
                                                                                                                                                        'size'  => '21x16'
                                                                                                                                                   )) ?>
                        <span class="dataValue"><?php echo util::getNumberOfWinnersFor($kup['repartition']) ?></span> <?php echo __('kup_blocKup_winner_text');?>
                    </a>
                </td>
            </tr>
        </table>
    </div>
    <div class="right">
        <div class="timer75"><span id="<?php echo $kup["uuid"] ?>_chrono" class="chrono"></span>

            <p class="more"><?php if (floor(($kup["startDate"] / 1000) - time()) > 0) : echo __('kup_blocKup_beforeClose_text'); endif; ?></p>
        </div>
        <div class="bouton">
            <a href="<?php echo $urlToKupView; ?>" title="">
                <?php echo __($kup["button"]) ?>
            </a>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
<script type="text/javascript">
    var refreshId_1 = setInterval(function () {

        var arrayResultat1 = returnChronoPART1('<?php echo $kup["startDate"]; ?>', '<?php echo $kup["status"]; ?>');

        if (arrayResultat1["chrono"] == 1) {

            if (arrayResultat1[0] >= "01") {
                if (arrayResultat1[0] >= "9") {
                    $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text(arrayResultat1[0] + ' ' + '<?php echo __('chrono_day_text'); ?>');
                } else {
                    $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text(arrayResultat1[0].substr(1, 1) + ' ' + '<?php echo __('chrono_day_text'); ?>');
                }
            } else if (arrayResultat1[0] <= "01") {
                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text(arrayResultat1[1] + ':' + arrayResultat1[2] + ':' + arrayResultat1[3]);
            }
        } else if (arrayResultat1["chrono"] == 0) {

            if (arrayResultat1["opened"] == 1) {
                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text('<?php echo __('chrono_opened_text'); ?>');
            } else if (arrayResultat1["started"] == 1) {
                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text('<?php echo __('chrono_started_text'); ?>');
            } else if (arrayResultat1["ongoing"] == 1) {
                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text('<?php echo __('chrono_ongoing_text'); ?>');
            } else if (arrayResultat1["closed"] == 1) {
                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text('<?php echo __('chrono_closed_text'); ?>');
            } else if (arrayResultat1["settled"] == 1) {
                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text('<?php echo __('chrono_settled_text'); ?>');
            } else if (arrayResultat1["cancelled"] == 1) {
                $('#<?php echo $kup["uuid"] ?>_chrono').delay(1000).text('<?php echo __('chrono_cancelled_text'); ?>');
            }
        }
    }, 1000);
</script>
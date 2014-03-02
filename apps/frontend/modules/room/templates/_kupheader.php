<?php if ($sf_request->getAttribute('roomUI', "")) {
    $roomUI = $sf_request->getAttribute('roomUI', "");
} ?>
<?php $isMise = '0'; ?>
<?php if (isset($roomUI) && isset($roomUI["array_kup_perso_prizes"]) && ($roomUI["array_kup_perso_prizes"] != "")) {
    foreach ($roomUI["array_kup_perso_prizes"] as $row) {
        if ($row == $kupData["uuid"]) {
            $isMise = '1';
        }
    }
}?>

<div id="room_kup_header" style="<?php if (isset($roomUI) && isset($roomUI["kup-header-bg"]) && $roomUI["kup-header-bg"] != "") {
    echo 'background-image: url(' . $roomUI["kup-header-bg"] . ')';
}?>">

    <div class="part1">
        <?php if ($dataRoom['official'] != '0') : ?>
        <div id="badge" class="badge"></div>
        <?php endif; ?>
        <div id="nomRoom" style="<?php if (isset($roomUI) && isset($roomUI["header-author-font-color"]) && $roomUI["header-author-font-color"] != "") {
            echo 'color:' . $roomUI["header-author-font-color"] . ';';
        }?>">
            <?php if (strlen($dataRoom["name"]) > 20) {
            $roomName = substr($dataRoom["name"], 0, 20) . '...';
            echo $roomName;
        }
        else {
            echo $dataRoom["name"];
        }?>
        </div>
        <div id="membres" style="<?php if (isset($roomUI) && isset($roomUI["header-author-font-color"]) && $roomUI["header-author-font-color"] != "") {
            echo 'color:' . $roomUI["header-author-font-color"] . ';';
        }?>"><?php echo $dataRoom["numberOfMembers"] ?> membres
        </div>
        <div id="nom">
            <table style="border-collapse:collapse; border-spacing: 0;">
                <tr>
                    <td align="left" valign="middle"><?php echo image_tag($dataRoom["authorPicture"], array(
                                                                                                           'size' => '25x25',
                                                                                                           'style'=> 'margin-right:5px;'
                                                                                                      ));?></td>
                    <td align="left" valign="middle" style="<?php if (isset($roomUI) && isset($roomUI["header-author-font-color"]) && $roomUI["header-author-font-color"] != "") {
                        echo 'color:' . $roomUI["header-author-font-color"] . ';';
                    }?>"><span class="auteur"><?php echo $dataRoom["author_nickname"] ?></span></td>
                </tr>
            </table>
        </div>
        <div id="accueil"><a href="<?php echo url_for(array(
                                                           'module' => 'room', 'action'=> 'view',
                                                           'uuid'   => $dataRoom["id"]
                                                      )) ?>"><?php echo __('label_room_kup_header_home') ?></a>
        </div>

        <div id="menu">
            <div style="float: left;">
                <p>
                    <?php echo image_tag('kup/picto/rugby.png', array(
                                                                     'alt'    => '',
                                                                     'align'  => 'absmiddle',
                                                                     'border' => '0',
                                                                     'size'   => '*x24'
                                                                ));?>
                    <?php echo $kupData["rubrique"]; ?>
                </p>
            </div>
            <div style="float: right; margin-right: 0px;">
                <div class="fb-like" data-href="<?php echo $siteUrl . url_for(array(
                                                                                   'module'   => 'room',
                                                                                   'action'   => 'kup',
                                                                                   'room_uuid'=> $dataRoom["uuid"],
                                                                                   'kup_uuid' => $kupData["uuid"]
                                                                              )) ?>" data-send="true" data-layout="button_count" data-width="100" data-show-faces="false"></div>
            </div>
            <div style="float: right;">
                <a href="<?php echo $siteUrl . url_for(array(
                                                            'module'   => 'room', 'action'=> 'kup',
                                                            'room_uuid'=> $dataRoom["uuid"],
                                                            'kup_uuid' => $kupData["uuid"]
                                                       )) ?>" class="twitter-share-button" data-text="<?php echo __('Venez relever la Kup &quot;%kupTitle%&quot; sur @Betkup, le 1er site de paris sportifs communautaire.', array('%kupTitle%'=> $kupData["title"]))?>" data-count="horizontal">Tweet</a>
                <script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
            </div>
        </div>
    </div>
    <div class="part2" style="background: url('<?php echo (isset($kupData['ui'])) ? $kupData['ui']['vignette_kup_view'] : ''; ?>') center no-repeat">
        <div class="leftContent">
            <?php if (isset($kupData['ui']['with_text']) && $kupData['ui']['with_text'] == 1) : ?>
            <h1 class="titleKup" style="font-size: <?php echo isset($kupData['ui']['font_size']) && isset($kupData['ui']['font_size']['big_box']['title']) ? $kupData['ui']['font_size']['big_box']['title'] : '' ?>;
                font-family: '<?php echo isset($kupData['ui']['font_family']) ? $kupData['ui']['font_family'] : 'Arial' ?>', Helvetica, Arial, sans-serif;
                color: <?php echo isset($kupData['ui']['color']) ? $kupData['ui']['color'] : '' ?>;">
                <?php echo $kupData['title'] ?>
            </h1>
            <p class="descKup" style="font-size: <?php echo isset($kupData['ui']['font_size']) && isset($kupData['ui']['font_size']['big_box']['description']) ? $kupData['ui']['font_size']['big_box']['description'] : '' ?>;
                font-family: Arial, sans-serif;
                color: <?php echo isset($kupData['ui']['color']) ? $kupData['ui']['color'] : '' ?>;">
                <?php echo $kupData['description'] ?>
            </p>
            <?php endif; ?>
            <p class="more-infos">
                <?php echo link_to(__('kup_box_know_more_text'), '/room/' . $dataRoom["uuid"] . '/kup/' . $kupData["uuid"] . '/rules?tab=rules')?>
            </p>
        </div>
        <div class="rightContent">
            <table style="padding:0; border-spacing: 0; border-collapse: collapse; width: 100%;">
                <tr>
                    <td width="50%" valign="top">
                        <?php echo image_tag('kup/home/tools_cagnotte.png', array(
                                                                                 'align' => 'absmiddle',
                                                                                 'alt'   => 'Cagnotte',
                                                                                 'size'  => '21x16'
                                                                            )) ?>
                        <?php if ($kupData['type'] == sfConfig::get('mod_room_kup_type_free')): ?>
                        <?php if (isset($roomUI) && isset($roomUI["kups"]) && isset($roomUI["kups"][$kupData['uuid']]['prize_value'])) : ?>
                            <span class="dataValueTop">
                                <?php echo __('kup_home_prizes_value');?> :
                            </span>
                            <br/>
                            <?php include_component('kup', 'jackpot', array('amount' => $roomUI["kups"][$kupData['uuid']]['prize_value'])) ?>
                            <?php else : ?>
                            <span class="dataValueTop">
                                <?php echo __('kup_home_prizes_value');?> :
                            </span>
                            <br/>
                            <?php if (($module == "room") && ($isMise == '0')) {
                                echo image_tag('kup/view/no_prize.png', array('size'=> '120x44'));
                            }
                            elseif (($module == "room") && ($isMise == '1')) {
                                echo image_tag('kup/view/img_prize.png', array('size'=> '120x44'));
                            } ?>
                            <?php endif; ?>
                        <?php elseif ($kupData['type'] == sfConfig::get('mod_room_kup_type_gambling_fr')): ?>
                        <span class="dataValueTop">
                            <?php echo __('kup_blocKup_jackpot_text');?></span><br/>
                        <?php include_component('kup', 'jackpot', array('amount' => $kupData["jackpot"])) ?>
                        <?php endif  ?>
                    </td>
                    <td width="50%" valign="top"><?php echo image_tag('kup/home/tools_chrono.png', array(
                                                                                                        'align' => 'absmiddle',
                                                                                                        'alt'   => 'Temps avant clôture',
                                                                                                        'size'  => '16x22'
                                                                                                   )) ?>
                        <span
                            class="dataValueTop"><?php echo __('kup_box_time_before_start_text');?>
                        </span>

                        <div class="chapeauLargeChrono"
                             style="margin: 0px; background-position: top; position: relative;">
                            <div class="chrono"
                                 style="color: white; width: 152px; text-align: left; position: absolute; margin-top: 5px;">
                                <table style="padding:0; border-spacing: 0; border-collapse: 0;">
                                    <tr>
                                        <td>
                                            <div class="chrono1" id="nextRaceChrono01Part_1"></div>
                                        </td>
                                        <td>
                                            <div class="chrono2" id="nextRaceChrono01Part_2"></div>
                                        </td>
                                        <td>
                                            <div class="chrono3" id="nextRaceChrono01Part_3"></div>
                                        </td>
                                        <td>
                                            <div class="chrono4" id="nextRaceChrono01Part_4"></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><?php echo image_tag('kup/home/tools_kupopen.png', array(
                                                                                             'align' => 'absmiddle',
                                                                                             'alt'   => 'Ouverture/fermeture',
                                                                                             'size'  => '21x16'
                                                                                        )) ?><span
                        class="dataValue"><?php echo $kupData["legend1"]; ?> </span>
                    </td>
                    <td valign="top"><?php echo image_tag('kup/home/tools_duree.png', array(
                                                                                           'align' => 'absmiddle',
                                                                                           'alt'   => 'Durée',
                                                                                           'size'  => '21x16'
                                                                                      )) ?>
                        <span class="dataValue"><?php echo $kupData['length'];?></span> jours
                    </td>
                </tr>
                <tr>
                    <td valign="top" title="Type de kup">
                        <?php echo image_tag('kup/home/tools_kup.png', array(
                                                                            'align' => 'absmiddle',
                                                                            'alt'   => 'Type de kup',
                                                                            'size'  => '18x16'
                                                                       )) ?>
                        <span class="dataValue"><?php echo $kupType; ?></span>
                    </td>
                    <td valign="top"><?php echo image_tag('kup/home/tools_mise.png', array(
                                                                                          'align' => 'absmiddle',
                                                                                          'alt'   => 'Mise',
                                                                                          'size'  => '21x16'
                                                                                     )) ?>
                        mise : <span class="dataValue"><?php echo $kupData["stake"]; ?> €</span>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><?php echo image_tag('kup/home/tools_participant.png', array(
                                                                                                 'align' => 'absmiddle',
                                                                                                 'alt'   => 'Participants',
                                                                                                 'size'  => '21x16'
                                                                                            )) ?>
                        <span class="dataValue"><?php echo $kupData["legend3"]; ?> </span>
                        participants
                    </td>
                    <td valign="top"><?php echo image_tag('kup/home/tools_evenements.png', array(
                                                                                                'align' => 'absmiddle',
                                                                                                'alt'   => 'Evenements',
                                                                                                'size'  => '21x16'
                                                                                           )) ?>
                        <span class="dataValue" style="font-weight: normal;"><?php echo (isset($kupData["ui"]["events"])) ? $kupData["ui"]["events"] : ''; ?> </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="margin-top: -10px;padding-left: 70px;font-size: 10px; font-family: Arial; font-style: italic;"><?php echo __('text_notation_kup_header_indication', array(
                                                                                                                                                                                                    '%link%' => link_to(__('text_notation_kup_header_indication_link'), url_for(array(
                                                                                                                                                                                                                                                                                     'module'    => 'room',
                                                                                                                                                                                                                                                                                     'action'    => 'kupRules',
                                                                                                                                                                                                                                                                                     'kup_uuid'  => $kupData["uuid"],
                                                                                                                                                                                                                                                                                     'room_uuid' => $dataRoom["uuid"]
                                                                                                                                                                                                                                                                                )) . '?tab=rules')
                                                                                                                                                                                               ))?></td>
                </tr>
            </table>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(function () {
        var refreshId_1 = setInterval(function () {
            var arrayResultat1 = returnChronoPART1('<?php echo $kupData["startDate"]; ?>', '<?php echo $kupData["status"] ?>');
            $('#nextRaceChrono01Part_1').html(arrayResultat1[0]);
            $('#nextRaceChrono01Part_2').html(arrayResultat1[1]);
            $('#nextRaceChrono01Part_3').html(arrayResultat1[2]);
            $('#nextRaceChrono01Part_4').html(arrayResultat1[3]);
        }, 1000);
    });
</script>
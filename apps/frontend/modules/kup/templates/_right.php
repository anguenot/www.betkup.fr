<div class="rightroom">
<?php if (isset($module) && $module == "kup" && isset($action) && $action != "home") : ?>
<div style="height: 27px;"></div>
<?php endif;?>





<?php if ($sf_user->isAuthenticated() && sfContext::getInstance()->getActionName() != 'home' && $module != 'challenge'): ?>
<div class="statut2">
    <?php echo image_tag('/images/room/right/statut_header.png', array(
                                                                      'style' => 'position: absolute; margin-left: 14px; margin-top: -6px;',
                                                                      'border'=> '0'
                                                                 ))?>
    <div style="height: 40px;"></div>
    <div align="left" style="width: 200px; margin: 0px auto;">
        <?php if (!$sf_user->hasCredential('kup_participant')): ?>
        <?php echo image_tag('/images/kup/view/statut/participationNonValidee.png', array('border'=> '0')) ?>
        <?php else: ?>
        <?php echo image_tag('/images/kup/view/statut/participationValidee.png', array('border'=> '0')) ?>
        <?php endif ?>
        <?php if (isset($kupData) && $kupData['hasPredictions'] == "1"): ?>
        <div style="width: 200px; height: 29px; background: url('/images/kup/view/statut/pronostic.png');">
            <div class="rightroom_texte">
                <span class="texte"><?php echo __('label_kup_predictions_saved') ?></span>
            </div>
        </div>
        <?php else: ?>
        <div style="width: 200px; height: 29px; background: url('/images/kup/view/statut/noPronostic.png');">
            <div class="rightroom_texte">
                <span class="texte"><?php echo __('label_kup_no_predictions_saved') ?></span>
            </div>
        </div>
        <?php endif ?>
        <?php if (isset($kupData) && $kupData['type'] == sfConfig::get('mod_kup_type_gambling_fr')): ?>
        <?php if (isset($kupData) && $kupData['hasBet'] == "1"): ?>
            <div style="width: 200px; height: 29px; background: url('/images/kup/view/statut/mise.png');">
                <div class="rightroom_texte">
                    <span class="texte"><?php echo "Mise placée" ?></span>
                </div>
            </div>
            <?php else: ?>
            <div style="width: 200px; height: 29px; background: url('/images/kup/view/statut/noMise.png');">
                <div class="rightroom_texte">
                    <span class="texte"><?php echo "Mise non placée" ?></span>
                </div>
            </div>
            <?php endif ?>
        <img src="/images/kup/view/statut/end.png" border="0"/>
        <?php if (isset($kupData) && $kupData['hasBet'] == "0" && $kupData['status'] < 3 && $kupData['status'] != -1): ?>
            <div align="center" style="margin-right: 10px;">
                <?php if (isset($module) && $module == "kup") : ?>
                <a href="<?php echo url_for(array(
                                                 'module'  => 'kup', 'action' => 'bet',
                                                 'uuid'    => $kupData['uuid']
                                            )) ?>">
                    <?php echo image_tag('/images/kup/view/statut/buttonMiser.png', array(
                                                                                         'border' => '0',
                                                                                         'size'   => '105x36'
                                                                                    ))?>
                </a>
                <?php else: ?>
                <a href="<?php echo url_for(array(
                                                 'module'    => 'room', 'action' => 'kupBet',
                                                 'kup_uuid'  => $kupData['uuid'],
                                                 'room_uuid' => $room_uuid
                                            )) ?>">
                    <?php echo image_tag('/images/kup/view/statut/buttonMiser.png', array(
                                                                                         'border' => '0',
                                                                                         'size'   => '105x36'
                                                                                    ))?>
                </a>
                <?php endif ?>
            </div>
            <?php endif ?>
        <?php endif ?>
    </div>
</div>
<?php endif ?>







<?php if (isset($kupData["ui"]["box_prizes"])) : ?>
    <?php if (isset($module) && $module == "kup" && (isset($action)) && $action != "" && (isset($kupData["ui"]['isPrizes'])) && $kupData["ui"]['isPrizes'] == "1") : ?>
    <div class="box_right_room" align="center" style="position: relative;">
        <?php echo image_tag($kupData["ui"]['box_prizes'], array('width' => '230')); ?>
        <div style="position: absolute; bottom: 15px; width: 100%;"
             align="center">
            <?php echo image_tag($kupData["ui"]['box_prizes_button'], array('width' => '130px')); ?>
        </div>
    </div>
        <?php endif; ?>
    <?php endif; ?>
<?php if (isset($roomUI) && isset($roomUI["kups"]) && isset($roomUI["kups"][$kupData['uuid']])) : ?>
    <?php if ($roomUI["kups"][$kupData['uuid']]['isCustom'] == 1) : ?>
    <div class="box_right_room box_right_room_custom" align="center" style="position: relative;">
        <div class="bg-top"></div>
        <div class="bg-middle">
            <div class="right-box-title" style="background: url('<?php echo $roomUI["kups"][$kupData['uuid']]['box-prize-title-bg'] ?>') center no-repeat;">
                <?php echo __('LOTS')?>
            </div>
            <div style="padding-top: 50px; padding-left: 10px; width: 219px; text-align: center;">
                <?php echo image_tag($roomUI["kups"][$kupData['uuid']]['box-prizes'], array(
                                                                                           'class'  => 'img-prize',
                                                                                           'size'   => $roomUI["kups"][$kupData['uuid']]['box-prizes-size']
                                                                                      ))?>
                <div style="height: 10px;"></div>
                <?php if (isset($roomUI["kups"][$kupData['uuid']]['total-prizes']) && $roomUI["kups"][$kupData['uuid']]['total-prizes'] > 0) : ?>
                <table class="prizes-table">
                    <?php for ($i = 1; $i <= $roomUI["kups"][$kupData['uuid']]['total-prizes']; $i++) : ?>
                    <tr>
                        <?php if(file_exists(sfConfig::get('sf_web_dir').'/images/room/right/kup_'.($i-1).'.png')) : ?>
                        <td class="positions-image">
                            <?php echo image_tag('/images/room/right/kup_'.($i-1).'.png', array('size'=>'12x14'))?>
                        </td>
                        <td class="positions-label">
                        <?php else : ?>
                        <td class="positions-label" colspan="2">
                        <?php endif; ?>
                            <h4>
                                <?php echo isset($roomUI["kups"][$kupData['uuid']]['prizes-' . $i . '-positions']) ? $roomUI["kups"][$kupData['uuid']]['prizes-' . $i . '-positions'] : $i . '<sup>e</sup>'?>
                            </h4>
                        </td>
                        <td class="prize-label">
                            <p><?php echo __($roomUI["kups"][$kupData['uuid']]['prizes-' . $i . '-label']);?></p>
                        </td>
                    </tr>
                    <?php endfor;?>
                </table>
                <?php endif;?>
            </div>
            <div style="height: 20px;"></div>
        </div>
        <div class="bg-bottom"></div>
    </div>
        <?php else : ?>
    <div class="box_right_room" align="center" style="position: relative;">
        <?php echo image_tag($roomUI["kups"][$kupData['uuid']]['box_prizes'], array('width' => '230')); ?>
        <div style="position: absolute; bottom: 15px; width: 100%;"
             align="center">
            <?php echo image_tag($roomUI["kups"][$kupData['uuid']]['box_prizes_button'], array('width' => '130px')); ?>
        </div>
    </div>
        <?php endif; ?>
    <?php endif; ?>
<?php if (isset($module) && $module == 'kup' && isset($kupData["ui"]["img_box_right"]) && $kupData["ui"]["img_box_right"] != '') : ?>
<div class="box_bg_top"></div>
<div class="box_bg_middle">
    <?php echo image_tag('/images/room/right/header_box_prizes.png', array(
                                                                          'size'  => '168x48',
                                                                          'style' => 'position: absolute; margin-left:60px; margin-top: -10px; ',
                                                                          'border'=> '0'
                                                                     ))?>
    <div style="height: 50px;"></div>
    <div align="center" style="margin-left: 0px; margin-top: 12px;">
        <?php if (isset($kupData["ui"]["img_box_right_size"])) : ?>
        <?php echo image_tag($kupData["ui"]["img_box_right"], array('size' => $kupData["ui"]["img_box_right_size"])); ?>
        <?php else : ?>
        <?php echo image_tag($kupData["ui"]["img_box_right"], array('width' => '130px')); ?>
        <?php endif; ?>
    </div>
    <div align="left" style="width: 200px; margin-left: 10px; margin-top: 12px;">
        <?php if (isset($kupData["ui"]["prize_1_label"])) : ?>
        <p>
            <strong><?php echo isset($kupData["ui"]["prize_1_label_prefix"]) ? __($kupData["ui"]["prize_1_label_prefix"], array('%br%' => '<br />')) : __('label_kup_first') ?></strong>
            - <?php echo __($kupData["ui"]["prize_1_label"], array('%br%' => '<br />')); ?>
        </p>
        <?php endif ?>
        <?php if (isset($kupData["ui"]["prize_2_label"])) : ?>
        <p>
            <strong><?php echo isset($kupData["ui"]["prize_2_label_prefix"]) ? __($kupData["ui"]["prize_2_label_prefix"], array('%br%' => '<br />')) : __('label_kup_second') ?></strong>
            - <?php echo __($kupData["ui"]["prize_2_label"], array('%br%' => '<br />')); ?>
        </p>
        <?php endif ?>
        <?php if (isset($kupData["ui"]["prize_3_label"])) : ?>
        <p>
            <strong><?php echo isset($kupData["ui"]["prize_3_label_prefix"]) ? __($kupData["ui"]["prize_3_label_prefix"], array('%br%' => '<br />')) : __('label_kup_third') ?></strong>
            - <?php echo __($kupData["ui"]["prize_3_label"], array('%br%' => '<br />')); ?>
        </p>
        <?php endif ?>
        <?php if (isset($kupData["ui"]["prize_4_label"])) : ?>
        <p>
            <strong><?php echo isset($kupData["ui"]["prize_4_label_prefix"]) ? __($kupData["ui"]["prize_4_label_prefix"], array('%br%' => '<br />')) : __('label_kup_forth') ?></strong>
            - <?php echo __($kupData["ui"]["prize_4_label"], array('%br%' => '<br />')); ?>
        </p>
        <?php endif ?>
        <?php if (isset($kupData["ui"]["prize_5_label"])) : ?>
        <p>
            <strong><?php echo isset($kupData["ui"]["prize_5_label_prefix"]) ? __($kupData["ui"]["prize_5_label_prefix"], array('%br%' => '<br />')) : __('label_kup_fifth') ?></strong>
            - <?php echo __($kupData["ui"]["prize_5_label"], array('%br%' => '<br />')); ?>
        </p>
        <?php endif;?>
        <?php if (isset($kupData["ui"]["prize_6_label"])) : ?>
        <p>
            <strong><?php echo isset($kupData["ui"]["prize_6_label_prefix"]) ? __($kupData["ui"]["prize_6_label_prefix"], array('%br%' => '<br />')) : '' ?></strong>
            - <?php echo __($kupData["ui"]["prize_6_label"], array('%br%' => '<br />')); ?>
        </p>
        <?php endif;?>
        <?php if (isset($kupData["ui"]["prize_7_label"])) : ?>
        <p>
            <strong><?php echo isset($kupData["ui"]["prize_7_label_prefix"]) ? __($kupData["ui"]["prize_7_label_prefix"], array('%br%' => '<br />')) : '' ?></strong>
            - <?php echo __($kupData["ui"]["prize_7_label"], array('%br%' => '<br />')); ?>
        </p>
        <?php endif;?>
        <?php if (isset($kupData["ui"]["prize_8_label"])) : ?>
        <p>
            <strong><?php echo isset($kupData["ui"]["prize_8_label_prefix"]) ? __($kupData["ui"]["prize_8_label_prefix"], array('%br%' => '<br />')) : '' ?></strong>
            - <?php echo __($kupData["ui"]["prize_8_label"], array('%br%' => '<br />')); ?>
        </p>
        <?php endif;?>
        <?php if (isset($kupData["ui"]["prize_9_label"])) : ?>
        <p>
            <strong><?php echo isset($kupData["ui"]["prize_9_label_prefix"]) ? __($kupData["ui"]["prize_9_label_prefix"], array('%br%' => '<br />')) : '' ?></strong>
            - <?php echo __($kupData["ui"]["prize_9_label"], array('%br%' => '<br />')); ?>
        </p>
        <?php endif;?>
        <?php if (isset($kupData["ui"]["prize_10_label"])) : ?>
        <p>
            <strong><?php echo isset($kupData["ui"]["prize_10_label_prefix"]) ? __($kupData["ui"]["prize_10_label_prefix"], array('%br%' => '<br />')) : '' ?></strong>
            - <?php echo __($kupData["ui"]["prize_10_label"], array('%br%' => '<br />')); ?>
        </p>
        <?php endif;?>
    </div>
    <div style="height: 20px;"></div>
    <div style="width: 130px; margin: 0px auto;">
        <?php if (isset($kupData["ui"]["box_prizes_button"])) : ?>
        <?php echo image_tag($kupData["ui"]['box_prizes_button'], array('width' => '130px')); ?>
        <?php endif ?>
    </div>
</div>
<div class="box_bg_bottom"></div>

    <?php endif ?>

<?php if (isset($kupData) && $kupData['type'] == sfConfig::get('mod_kup_type_gambling_fr') && sfContext::getInstance()->getActionName() != 'home') : ?>
<div class="box_bg_top"></div>
<div class="box_bg_middle">
    <?php echo image_tag('/images/room/right/header_box_gain.png', array(
                                                                        'size'  => '168x48',
                                                                        'style' => 'position: absolute; margin-left:60px; margin-top: -10px; ',
                                                                        'border'=> '0'
                                                                   ))?>
    <div style="height: 50px;"></div>

    <?php if ($kupData['guaranteedPrice'] > 0) : ?>
    <div class="box_gain_guarantee_bg">
        <div class="box_gain_guarantee_amount">
            <?php echo $kupData['guaranteedPrice']?>€
        </div>
        <div class="box_gain_guarantee_text">
            Minimum garanti
        </div>
    </div>
    <div class="box_separation_line"></div>
    <?php endif; ?>
    <div class="box_repartition">
        <div class="box_win_picto"></div>
        <table>
            <thead>
            <tr>
                <th colspan="3">Répartition des gains</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($repartitions as $key => $repartition) : ?>
            <tr>
                <td width="90" style="border-right: 1px solid white; background-color: <?php echo ($key % 2 == 1) ? '#787878; color: #FFFFFF;' : '#F4F4F4;'; ?>">
                    <table style="width: 89px;">
                        <tbody style="border: none;">
                        <tr>
                            <td width="28" style="border-top: none;">
                                <?php if ($key <= 2) : ?>
                                <?php echo image_tag('/images/room/right/kup_' . $key . '.png', array('size' => '12x14')) ?>
                                <?php endif;?>
                            </td>
                            <td style="border-top: none;">
                                <?php echo $repartition['title']?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td style="border-right: 1px solid white; background-color: <?php echo ($key % 2 == 1) ? '#787878; color: #FFFFFF;' : '#F4F4F4;'; ?>">
                    <?php echo $repartition['description']?>
                </td>
                <td style="background-color: <?php echo ($key % 2 == 1) ? '#787878; color: #FFFFFF;' : '#F4F4F4;'; ?>">
                    <?php echo round($kupData["jackpot"]*intval($repartition['description']) / 100, 1) ?>€













                </td>
            </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <div class="box_separation_line"></div>
    <div class="box_more_info">
        <a href="<?php echo (isset($room_uuid)) ? url_for(array(
                                                               'module'    => 'room',
                                                               'action'    => 'kupRules',
                                                               'kup_uuid'  => $kupData['uuid'],
                                                               'room_uuid' => $room_uuid
                                                          )) . '?tab=rules' : url_for(array(
                                                                                           'module'  => 'kup',
                                                                                           'action'  => 'rules',
                                                                                           'uuid'    => $kupData['uuid']
                                                                                      )) ?>">En
            savoir plus</a>
    </div>
</div>
<div class="box_bg_bottom"></div>
    <?php endif;?>

<?php if (sfContext::getInstance()->getActionName() == 'home' || !$sf_user->isAuthenticated() || $module == 'challenge'): ?>
<div class="box_bg_top"></div>
<div class="box_bg_middle">
    <?php echo image_tag('/image/fr/kup/right/comment_ca_marche.png', array(
                                                                           'style' => 'position: absolute; margin-left: -3px; margin-top: -10px;',
                                                                           'border'=> '0'
                                                                      ))?>
    <div style="height: 40px;"></div>
    <table class="right-how-to-table">
        <tr>
            <td class="td-pellet">
                <div class="pellet">1</div>
            </td>
            <td>
                <span class="how_does_it_work"><?php echo __('kup_right_how_does_it_work_text_1')?></span>
            </td>
        </tr>
        <tr>
            <td class="td-pellet">
                <div class="pellet">2</div>
            </td>
            <td>
                <span class="how_does_it_work"><?php echo __('kup_right_how_does_it_work_text_2')?></span>
            </td>
        </tr>
        <tr>
            <td class="td-pellet">
                <div class="pellet">3</div>
            </td>
            <td>
                <span class="how_does_it_work"><?php echo __('kup_right_how_does_it_work_text_3')?></span>
            </td>
        </tr>
        <tr>
            <td class="td-pellet">
                <div class="pellet">4</div>
            </td>
            <td>
                <span class="how_does_it_work"><?php echo __('kup_right_how_does_it_work_text_4')?></span>
            </td>
        </tr>
        <tr>
            <td class="td-pellet">
                <div class="pellet">5</div>
            </td>
            <td>
                <span class="how_does_it_work"><?php echo __('kup_right_how_does_it_work_text_5')?></span>
            </td>
        </tr>
    </table>
    <div style="height: 15px;"></div>
    <table class="right-how-to-table-links">
        <tr>
            <td class="td-picto">
                <div class="picto"></div>
            </td>
            <td>
                <a href="<?php echo url_for(array(
                                                 'module' => 'home', 'action'  => 'howto'
                                            )) ?>" class="link-how_does_it_work">
                    <?php echo __('kup_right_how_does_it_work_text_6')?>
                </a>
            </td>
        </tr>
        <tr>
            <td class="td-picto">
                <div class="picto"></div>
            </td>
            <td>
                <a href="<?php echo url_for(array(
                                                 'module' => 'kup', 'action'  => 'home'
                                            ))?>" class="link-how_does_it_work">
                    <?php echo __('kup_right_how_does_it_work_text_7')?>
                </a>
            </td>
        </tr>
    </table>

</div>
<div class="box_bg_bottom"></div>

<div class="box_bg_top">
    <h1 class="title-teaser-video">
        Teaser vidéo :
    </h1>
</div>
<div class="box_bg_middle">
    <a class="teaser-betkup" href="javascript:void(0);" onclick="$('#video-pop-up').trigger('click');">
        <?php echo image_tag('/image/default/footer/teaser_betkup.png', array('size' => '205x114')) ?>
    </a>
</div>
<div class="box_bg_bottom"></div>
    <?php endif ?>

<?php if ($canInvite == '1' && sfContext::getInstance()->getActionName() != 'home' && sfContext::getInstance()->getModuleName() != 'challenge') : ?>
<div style="height: 10px;"></div>
<a href="<?php echo $urlInvite; ?>" style="margin-left: 10px;">
    <?php echo image_tag('/image/' . $sf_user->getCulture() . '/invite/button_invite.png', array('size' => '200x40'));?>
</a>
<div style="height: 10px;"></div>
    <?php endif; ?>

</div>
<script type="text/javascript">
    <?php if (isset($module) && $module == "kup" && isset($action) && $action != "home") { ?>
    //$('.statut2').css('margin-top','20px');
        <?php } ?>
    <?php if (isset($module) && $module == "room") { ?>
    //$('.statut2').css('margin-top','5px');
        <?php } ?>
</script>

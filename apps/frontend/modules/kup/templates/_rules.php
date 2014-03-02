<?php include_component('account', 'title', array(
                                                 'racine'  => 'regleskup',
                                                 'altImg'  => __('label_kup_rules'),
                                                 'area'    => 'areaOne'
                                            )) ?>
<?php if ($sf_request->getAttribute('roomUI', "")) {
    $roomUI = $sf_request->getAttribute('roomUI', "");
} ?>
<?php if (isset($kupData["ui"]["rules_view_template"]) && ($kupData["ui"]["rules_view_template"] != "")) { ?>
<?php $includeRules = explode(",", $kupData["ui"]["rules_view_template"]) ?>
<?php } ?>
<div class="regle">
    <div class="rules-container">
        <span class="title_rules_general"><?php echo __('kup_rules_title_1');?></span>

        <p class="text_rules_general"><?php echo __('kup_rules_text_1');?></p>
        <?php if (isset($kupData["ui"]["nbRules"]) && ($kupData["ui"]["nbRules"] != "")) { ?>
        <?php echo image_tag('/images/kup/view/regle/interligne.png', array(
                                                                           'class'  => 'rules-line-separators',
                                                                           'style'  => 'margin-bottom: 7px;'
                                                                      )) ?>
        <div>
            <div class="rules-margin">
                <table style="border-spacing: 8px;" class="table_rules">
                    <tr>
                        <td></td>
                        <td>
                            <span class="title_rules_perso"><?php echo __('kup_rules_' . $includeRules[1] . '_title'); ?></span>
                        </td>
                    </tr>
                    <?php for ($i = 1; $i <= $kupData["ui"]["nbRules"]; $i++) : ?>
                    <tr>
                        <td style="vertical-align: top;">
                            <img src="/images/kup/view/regle/puce<?php echo $i;?>.png" border="0" style="float: left; padding-right: 10px;">
                        </td>

                        <td>
                            <p class="text_rules_perso">
                                <?php echo __('kup_rules_' . $includeRules[1] . '_text_' . $i); ?>
                            </p>
                        </td>
                    </tr>
                    <?php endfor;?>
                    <?php if ($kupData["type"] == sfConfig::get('mod_kup_type_gambling_fr')) : ?>
                    <tr>
                        <td style="vertical-align: top;">
                            <img src="/images/kup/view/regle/puce<?php echo $i;?>.png"
                                 border="0" style="float: left; padding-right: 10px;">
                        </td>
                        <td>
                            <p class="text_rules_perso">
                                <b><?php echo __('text_rules_kup_gambling_notice')?></b>
                            </p>
                            <ul>
                                <li><?php echo ($module == 'kup') ? __('text_rules_kup_minimum_warranty') : __('text_rules_room_kup_minimum_warranty') ?>
                                    :
                                    <b><?php echo ($kupData["guaranteedPrice"] > 0) ? $kupData["guaranteedPrice"] . ' €' : 'NA'; ?></b>
                                </li>
                                <li><?php echo ($module == 'kup') ? __('text_rules_kup_stake') : __('text_rules_room_kup_stake') ?>
                                    : <b><?php echo $kupData["stake"]?> €</b></li>
                                <li><?php echo ($module == 'kup') ? __('text_rules_kup_repartition') : __('text_rules_room_kup_repartition') ?>
                                    :
                                    <b><?php echo $repartitions['title'] ?></b><br/><span style="display: block; text-indent: 30px;"><?php echo $repartitions['description'] ?></span>
									<span style="text-indent: 0px; display: block; margin-left: 30px;">
										<?php echo  __('text_rules_kup_repartition_notice', array(
                                                                                                 '%b%'           => '<b>',
                                                                                                 '%/b%'          => '</b>',
                                                                                                 '%repartition%' => '<b>' . $repartitionRule . '</b>'
                                                                                            )) ?>
									</span>
                                </li>
                                <li><?php echo __('text_rules_kup_rake') ?> :
									<span style="text-indent: 0px; display: block; margin-left: 30px;">
										(Le <?php echo date('d/m/Y à H\hi\m')?>
                                        ) <b><?php echo ($kupData["rake_percentage"] * 100) ?> %</b>
									</span>
                                </li>
                            </ul>
                            <br/><br/>

                            <p class="text_rules_perso">
                                <?php echo __('text_rules_kup_warrning_sliding_scale', array(
                                                                                            '%b%'    => '<b>',
                                                                                            '%/b%'   => '</b>',
                                                                                            '%link%' => link_to(__('text_rules_kup_sliding_scale_link'), url_for(array(
                                                                                                                                                                      'module'  => 'home',
                                                                                                                                                                      'action'  => 'betTrust'
                                                                                                                                                                 )) . '#bet_transparency')
                                                                                       )) ?>
                            </p>
                            <?php if ($kupData["guaranteedPrice"] > 0) : ?>
                            <br/><br/>
                            <p class="text_rules_perso">
                                <?php echo __('text_rules_kup_minimum_warranty_precision', array(
                                                                                                '%b%'  => '<b>',
                                                                                                '%/b%' => '</b>'
                                                                                           )) ?>
                            </p>
                            <?php endif;?>
                        </td>
                    </tr>
                    <?php endif;?>

                    <tr>
                        <td></td>
                        <?php if ($module == "kup") { ?>
                        <?php if (isset($kupData["ui"]["isPrizes"]) && $kupData["ui"]["isPrizes"] == "1") { ?>
                            <td><?php echo image_tag('/images/kup/view/regle/puceLink.png', array('style'=> 'vertical-align:middle;'))?>
                                <?php echo link_to(__('kup_regle_learn_all_rules_text'), $kupData["ui"]["document_path"] . '/rules.pdf', array(
                                                                                                                                              'class' => 'orange',
                                                                                                                                              'target'=> '_blank'
                                                                                                                                         ))?>
                            </td>
                            <?php } ?>
                        <?php
                    }
                    elseif ($module == "room") {
                        ?>
                        <?php $isRulesPdfPersoKup = "0"; ?>
                        <?php if (isset($roomUI["array_kup_perso_rules_pdf"]) && ($roomUI["array_kup_perso_rules_pdf"] != "")) {
                            foreach ($roomUI["array_kup_perso_rules_pdf"] as $row) {
                                if ($row == $kup_uuid) {
                                    $isRulesPdfPersoKup = "1";
                                }
                            }
                        } ?>
                        <?php if ($isRulesPdfPersoKup == "1") { ?>
                            <td><?php echo image_tag('/images/kup/view/regle/puceLink.png', array('style'=> 'vertical-align:middle;'))?>
                                <?php echo link_to(__('kup_regle_learn_all_rules_text'), $roomUI["path_document_kup_perso_rules"] . '/' . $kup_uuid . '.pdf', array(
                                                                                                                                                                   'class' => 'orange',
                                                                                                                                                                   'target'=> '_blank'
                                                                                                                                                              ))?>
                            </td>
                            <?php } ?>
                        <?php } ?>
                    </tr>
                </table>
            </div>
        </div>
        <?php echo image_tag('/images/kup/view/regle/interligne.png', array(
                                                                           'class'  => 'rules-line-separators',
                                                                           'style'  => 'margin-bottom: 7px;'
                                                                      )) ?>
        <?php }?>
    </div>

</div>
<?php if (isset($roomUI)) : ?>
<?php if (isset($roomUI["array_kup_perso_prizes"]) && isset($roomUI["path_img_kup_perso_prizes"]) && ($roomUI["array_kup_perso_prizes"] != "")) : ?>
    <?php $isPrizesPersoKup = "0"; ?>
    <?php foreach ($roomUI["array_kup_perso_prizes"] as $row) : ?>
        <?php if ($row == $kup_uuid) : ?>
            <?php $isPrizesPersoKup = "1"; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php if ($isPrizesPersoKup == "1") : ?>
        <?php include_component('account', 'title', array(
                                                         'racine'  => 'prize',
                                                         'altImg'  => __('label_kup_prize'),
                                                         'area'    => 'areaOne'
                                                    )); ?>
        <div class="rules-prize-perso">
            <?php echo image_tag($roomUI["path_img_kup_perso_prizes"] . '/' . $kup_uuid . '.png', array('class' => 'rules-prize-perso-picture')); ?>
        </div>
        <?php endif; ?>
    <?php else : ?>
    <?php if (isset($roomUI['kups']) && isset($roomUI['kups'][$kup_uuid])) : ?>
        <?php if (isset($roomUI['kups'][$kup_uuid]['path_img_kup_perso_prizes'])) : ?>
            <?php include_component('account', 'title', array(
                                                             'racine'  => 'prize',
                                                             'altImg'  => __('label_kup_prize'),
                                                             'area'    => 'areaOne'
                                                        )) ?>
                <div class="rules-prize-perso">
                    <?php for ($i = 1; $i <= $roomUI['kups'][$kup_uuid]['total-prizes']; $i++) : ?>
                        <div class="box-prizes">
                            <div class="image-container">
                                <?php if(file_exists(sfConfig::get('sf_web_dir') . $roomUI['kups'][$kup_uuid]["path_img_kup_perso_prizes"] . '/' . $roomUI['kups'][$kup_uuid]['img_prize_' . $i])) : ?>
                                <?php echo image_tag($roomUI['kups'][$kup_uuid]["path_img_kup_perso_prizes"] . '/' . $roomUI['kups'][$kup_uuid]['img_prize_' . $i], array()); ?>
                                <?php endif; ?>
                            </div>
                            <div class="text-container">
                                <p>
                                    <?php echo isset($roomUI['kups'][$kup_uuid]['prizes-' . $i . '-label-details']) ? $roomUI['kups'][$kup_uuid]['prizes-' . $i . '-label-details'] : ''?>
                                </p>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php else : ?>
<?php if (isset($kupData["ui"]["isPrizes"]) && ($kupData["ui"]["isPrizes"] == "1") && (isset($module)) && ($module != "room")) { ?>
    <?php include_component('account', 'title', array(
                                                     'racine'  => 'prize',
                                                     'altImg'  => __('label_kup_prize'),
                                                     'area'    => 'areaOne'
                                                )) ?>
    <div class="rules-table-container">
        <?php if (isset($kupData["ui"]["img_prizes"])) : ?>
        <?php echo image_tag($kupData["ui"]["img_prizes"]) ?>
        <?php endif ?>
        <?php if (isset($kupData["ui"]['custom_rules']) && isset($kupData["ui"]['custom_rules']['binding_map']) && count($kupData["ui"]['custom_rules']['binding_map']) > 0): ?>
        <?php foreach ($kupData["ui"]['custom_rules']['binding_map'] as $title => $bindingMap) : ?>
            <div style="height: 30px;"></div>
            <h2 style="text-align: center; font: bold 24px Arial, sans-serif; color: #575756;">
                <?php echo __($title) ?>
            </h2>
            <div style="height: 30px;"></div>
            <table style="width: 100%; border-spacing: 0; border-collapse: collapse;">
                <?php if (count($bindingMap) > 0) : ?>
                <?php $i = 0;
                foreach ($bindingMap as $binding) : ?>
                    <?php if ($i == 0) : ?>
                        <tr>
                    <?php endif; ?>
                    <td style="text-align: center; width: 25%;">
                        <?php if (isset($kupData["ui"]["custom_rules"]) && isset($kupData["ui"]['custom_rules']["bindings"]) && isset($kupData["ui"]['custom_rules']["bindings"][$binding])) : ?>
                        <table style="width: 100%; border-spacing: 0; border-collapse: collapse;">
                            <tr>
                                <td>
                                    <?php if (isset($kupData["ui"]['custom_rules']["bindings"][$binding]['image'])) : ?>
                                    <?php echo image_tag($kupData["ui"][$kupData["ui"]['custom_rules']["bindings"][$binding]['image']], 'size=150x120') ?>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php if (isset($kupData["ui"]['custom_rules']["bindings"][$binding]['prefix'])) : ?>
                                    <h1>
                                        <?php echo __($kupData["ui"][$kupData["ui"]['custom_rules']["bindings"][$binding]['prefix']]) ?>
                                    </h1>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0 4px;">
                                    <?php if (isset($kupData["ui"]['custom_rules']["bindings"][$binding]['label'])) : ?>
                                    <p class="text_rules_perso" style="text-align: center;">
                                        <?php echo str_replace('%br%', '', __($kupData["ui"][$kupData["ui"]['custom_rules']["bindings"][$binding]['label']])); ?>
                                    </p>
                                    <?php endif ?>
                                </td>
                            </tr>
                        </table>
                        <?php endif; ?>
                    </td>
                    <?php if ($i == 3) : ?>
                        </tr>
                   <?php $i = 0; endif; ?>
                    <?php $i++; endforeach; ?>
                <?php endif; ?>
            </table>
            <?php endforeach; ?>
        <?php else : ?>
        <table style="border-spacing: 10px;">
            <tr>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_1"])) : ?>
                    <?php echo image_tag($kupData["ui"]["img_prize_1"], 'size=150x120') ?>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_2"])) : ?>
                    <?php echo image_tag($kupData["ui"]["img_prize_2"], 'size=150x120') ?>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_3"])) : ?>
                    <?php echo image_tag($kupData["ui"]["img_prize_3"], 'size=150x120') ?>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_4"])) : ?>
                    <?php echo image_tag($kupData["ui"]["img_prize_4"], 'size=150x120') ?>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_1"])) : ?>
                    <h1><?php echo $kupData['repartition'] < 5 ? __('label_kup_first') : ''; ?></h1>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_2"])) : ?>
                    <h1><?php echo $kupData['repartition'] < 5 ? __('label_kup_second') : ''; ?></h1>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_3"])) : ?>
                    <h1><?php echo $kupData['repartition'] < 5 ? __('label_kup_third') : ''; ?></h1>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_4"])) : ?>
                    <h1><?php echo $kupData['repartition'] < 5 ? __('label_kup_forth') : ''; ?></h1>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <?php if (isset($kupData["ui"]["img_prize_1"])) : ?>
                    <p class="text_rules_perso"><?php echo __($kupData["ui"]["prize_1_label"]); ?></p>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_2"])) : ?>
                    <p class="text_rules_perso"><?php echo __($kupData["ui"]["prize_2_label"]); ?></p>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_3"])) : ?>
                    <p class="text_rules_perso"><?php echo __($kupData["ui"]["prize_3_label"]); ?></p>
                    <?php endif ?>
                </td>
                <td align="right">
                    <?php if (isset($kupData["ui"]["img_prize_4"])) : ?>
                    <p class="text_rules_perso"><?php echo __($kupData["ui"]["prize_4_label"]); ?></p>
                    <?php endif ?>
                </td>
            </tr>
        </table>
        <table style="border-spacing: 10; margin-top: 10px;">
            <tr>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_5"])) : ?>
                    <?php echo image_tag($kupData["ui"]["img_prize_5"], 'size=150x120') ?>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_6"])) : ?>
                    <?php echo image_tag($kupData["ui"]["img_prize_6"], 'size=150x120') ?>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_7"])) : ?>
                    <?php echo image_tag($kupData["ui"]["img_prize_7"], 'size=150x120') ?>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_8"])) : ?>
                    <?php echo image_tag($kupData["ui"]["img_prize_8"], 'size=150x120') ?>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_5"])) : ?>
                    <h1><?php echo $kupData['repartition'] < 5 ? __('label_kup_fifth') : ''; ?></h1>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_6"])) : ?>
                    <h1><?php echo $kupData['repartition'] < 5 ? __('label_kup_second') : ''; ?></h1>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_7"])) : ?>
                    <h1><?php echo $kupData['repartition'] < 5 ? __('label_kup_third') : ''; ?></h1>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_8"])) : ?>
                    <h1><?php echo $kupData['repartition'] < 5 ? __('label_kup_forth') : ''; ?></h1>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <?php if (isset($kupData["ui"]["img_prize_5"])) : ?>
                    <p class="text_rules_perso"><?php echo __($kupData["ui"]["prize_5_label"]); ?></p>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_6"])) : ?>
                    <p class="text_rules_perso"><?php echo __($kupData["ui"]["prize_6_label"]); ?></p>
                    <?php endif ?>
                </td>
                <td align="center">
                    <?php if (isset($kupData["ui"]["img_prize_7"])) : ?>
                    <p class="text_rules_perso"><?php echo __($kupData["ui"]["prize_7_label"]); ?></p>
                    <?php endif ?>
                </td>
                <td align="right">
                    <?php if (isset($kupData["ui"]["img_prize_8"])) : ?>
                    <p class="text_rules_perso"><?php echo __($kupData["ui"]["prize_8_label"]); ?></p>
                    <?php endif ?>
                </td>
            </tr>
        </table>
        <?php endif; ?>
    </div>
    <?php } ?>
<?php endif; ?>
<?php if (isset($kupData["ui"]["rules_view_template"]) && ($kupData["ui"]["rules_view_template"] != "")) : ?>
<?php include_component('account', 'title', array(
                                                 'racine'  => 'bareme',
                                                 'altImg'  => __('label_kup_bareme'),
                                                 'area'    => 'areaOne'
                                            )) ?>
<?php if (isset($kupData['ui']['questions']['custom_rules'])) : ?>
    <div class="regle">
        <div class="rules-block">
            <?php include_component('kup', 'rulesTable', array(
                                                              'title'     => __('text_label_on_this_match'),
                                                              'questions' => $kupData['ui']['questions']
                                                         )) ?>
        </div>
    </div>
    <?php else : ?>
    <?php include_component($includeRules[0], $includeRules[1], array('kupData' => $kupData)) ?>
    <?php endif; ?>
<?php endif; ?>
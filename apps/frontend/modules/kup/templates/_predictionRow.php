<div class="date"><?php echo $kupGameData["title"] ?></div>
<?php if ($kupGameData["type"] == "ic" || $kupGameData["type"] == "se"): ?>
<div class="match match<?php echo ($isActive) ? '-active' : '-inactive'; ?>">
    <?php if ($kupGameData["choc"] == "yes"): ?>
    <?php echo image_tag('/images/kup/view/pronostic/choc.png', array(
                                                                     'style' => 'position: absolute; margin-left: -2px; margin-top: -2px;',
                                                                     'border'=> '0'
                                                                )) ?>
    <?php endif ?>
    <table class="table-pronostic-row">
        <tr>
            <td class="pellet">
                <?php echo (isset($offset)) ? "<div>" . ($offset + 1) . "</div>" : '' ?>
            </td>
            <td class="title-team title-team-left">
                <div style="margin-right: 2px;">
                    <span class="team"><?php echo $kupGameData["team1title"] ?></span>
                </div>
            </td>
            <td class="avatar-team avatar-team-left">
                <?php echo image_tag($kupGameData["team1avatar"], array(
                                                                       'border' => '0',
                                                                       "width"  => "48"
                                                                  ))?>
            </td>
            <?php if ($kupGameData["type"] == "ic"): ?>
            <td class="tdRadio tdRadio-left">
                <?php if (!$isKn) : ?>
                <p>1</p>
                <?php endif;?>
                <?php if (isset($predictions_ic[$kupGameData['id']]) && $predictions_ic[$kupGameData['id']] == '-1'): ?>
                <input type="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> style="visibility: hidden;" name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="-1" checked="checked"/>
                <?php else: ?>
                <input type="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> style="visibility: hidden;" name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="-1"/>
                <?php endif ?>
                <?php if (isset($predictions_ic[$kupGameData['id']]) && $predictions_ic[$kupGameData['id']] == '1'): ?>
                <input type="radio" class="left-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="1" checked="checked"/>
                <?php else: ?>
                <input type="radio" class="left-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="1"/>
                <?php endif ?>
            </td>
            <td class="tdRadio tdRadio-center">
                <?php if (!$isKn) : ?>
                <p>X</p>
                <?php endif;?>
                <?php if (!util::startswith($kupGameData['id'], 'TAB') && !util::startswith($kupGameData['id'], 'bb')): ?>
                <?php if (isset($predictions_ic[$kupGameData['id']]) && $predictions_ic[$kupGameData['id']] == '2'): ?>
                    <input type="radio" class="center-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="2" checked="checked"/>
                    <?php else: ?>
                    <input type="radio" class="center-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="2"/>
                    <?php endif ?>
                <?php endif ?>
            </td>
            <td class="tdRadio tdRadio-right">
                <?php if (!$isKn) : ?>
                <p>2</p>
                <?php endif;?>
                <?php if (isset($predictions_ic[$kupGameData['id']]) && $predictions_ic[$kupGameData['id']] == '3'): ?>
                <input type="radio" class="right-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="3" checked="checked"/>
                <?php else: ?>
                <input type="radio" class="right-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="3"/>
                <?php endif ?>
            </td>
            <?php else: ?>
            <?php ?>
            <td width="85" align="center">
                <select <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> id="predictions_se_<?php echo $kupGameData["id"] ?>_1" name="predictions_se[<?php echo $kupGameData["id"] ?>_1]" class="formInputSelect" style="width: 80px;">
                    <?php if (isset($predictions_se[$kupGameData['id'] . '_1']) && $predictions_se[$kupGameData['id'] . '_1'] == '0'): ?>
                    <option value="0" selected="selected"><?php echo '-'; ?></option>
                    <?php else: ?>
                    <option value="0"><?php echo '-'; ?></option>
                    <?php endif ?>
                    <?php for ($i = 0; $i <= 20; $i++): ?>
                    <?php if (isset($predictions_se[$kupGameData['id'] . '_1']) && $predictions_se[$kupGameData['id'] . '_1'] == $i): ?>
                        <option value="<?php echo $i ?>" selected="selected"><?php echo $i ?></option>
                        <?php else: ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php endif ?>
                    <?php endfor ?>
                </select>
            </td>
            <td width="10" align="center"> -</td>
            <td width="85" align="center">
                <select <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> id="predictions_se_<?php echo $kupGameData["id"] ?>_2" name="predictions_se[<?php echo $kupGameData["id"] ?>_2]" class="formInputSelect" style="width: 80px;">
                    <?php if (isset($predictions_se[$kupGameData['id'] . '_2']) && $predictions_se[$kupGameData['id'] . '_2'] == '0'): ?>
                    <option value="0" selected="selected"><?php echo '-'; ?></option>
                    <?php else: ?>
                    <option value="0"><?php echo '-'; ?></option>
                    <?php endif ?>
                    <?php for ($i = 0; $i <= 20; $i++): ?>
                    <?php if (isset($predictions_se[$kupGameData['id'] . '_2']) && $predictions_se[$kupGameData['id'] . '_2'] == $i): ?>
                        <option value="<?php echo $i ?>" selected="selected"><?php echo $i ?></option>
                        <?php else: ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php endif ?>
                    <?php endfor ?>
                </select>
            </td>
            <?php endif ?>
            <td class="avatar-team avatar-team-right">
                <?php echo image_tag($kupGameData["team2avatar"], array(
                                                                       'border' => '0',
                                                                       "width"  => "48"
                                                                  ))?>
            </td>
            <td class="title-team title-team-right">
                <div style="margin-left: 2px;">
                    <span class="team"><?php echo $kupGameData["team2title"] ?></span>
                </div>
            </td>
            <td class="interogations">
                <?php if ($isActive) : ?>
                <a href="javascript:void(0);" class="interogation-question"
                   id="img_prono_interrogation_<?php echo $kupGameData['id'] ?>"
                   title="<?php echo $questionText ?>">
                </a>
                <a href="javascript:void(0);" class="interogation-points"
                   id="img_prono_interrogation_points_<?php echo $kupGameData['id'] ?>"
                   title="<?php echo $pointsText ?>">
                </a>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    $(function () {

        $("#predictions_se_<?php echo $kupGameData["id"] ?>_1").selectmenu({style:'dropdown', width:80, menuWidth:'80'});
        $("#predictions_se_<?php echo $kupGameData["id"] ?>_2").selectmenu({style:'dropdown', width:80, menuWidth:'80'});
        $('#img_prono_interrogation_<?php echo $kupGameData["id"]; ?>').tipsy({fade:true, gravity:'s', html:true});
        $('#img_prono_interrogation_points_<?php echo $kupGameData["id"]; ?>').tipsy({fade:true, gravity:'s', html:true});
    });
</script>
<?php else: ?>
<div class="match" style="<?php echo ($kupGameData["type"] == "q" ? "background: url('/images/kup/view/pronostic/backgroundWinner.png');" : "") ?>">
    <?php if ($kupGameData["choc"] == "yes"): ?>
    <?php echo image_tag('/images/kup/view/pronostic/choc.png', array('style'=> 'position: absolute; margin-left: -2px; margin-top: -2px;')) ?>
    <?php endif ?>
    <table style="height: 58px; width: 100%; border-spacing: 0px; border-collapse:collapse;">
        <tr>
            <td width="329" align="left" valign="middle">
                <div style="margin-left: 15px; margin-right: 37px; vertical-align: middle;">
                    <span class="orange"><?php echo $kupGameData["orange"] ?></span>
                    <span class="team"><?php echo $kupGameData["question"] ?></span>
                </div>
            </td>
            <td width="295" align="left">
                <div style="margin-right: 2px;text-align: center; ">
                    <select <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> id="predictions_q_<?php echo $kupGameData["id"] . '_' . $kupGameData['questionId'] ?>" name="predictions_q[<?php echo $kupGameData["id"] . '_' . $kupGameData['questionId'] ?>]" class="formInputSelect" style="width: 180px;">
                        <option value="-1"><?php echo __('label_select_choose') ?></option>
                        <?php foreach ($kupGameData["choices"] as $key => $value): ?>
                        <?php if (isset($predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']]) && $predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']] == $key): ?>
                            <option value="<?php echo $key ?>" selected="selected"><?php echo __($value) ?></option>
                            <?php else: ?>
                            <option value="<?php echo $key ?>"><?php echo __($value) ?></option>
                            <?php endif ?>
                        <?php endforeach ?>
                    </select>
                </div>
            </td>
            <td width="55" class="interogations">
                <?php if ($isActive) : ?>
                <a href="javascript:void(0);" class="interogation-question"
                   id="img_prono_interrogation_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>"
                   title="<?php echo $questionText ?>">
                </a>
                <a href="javascript:void(0);" class="interogation-points"
                   id="img_prono_interrogation_points_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>"
                   title="<?php echo $pointsText ?>">
                </a>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    $(function () {
        $("#predictions_q_<?php echo $kupGameData["id"] . '_' . $kupGameData['questionId'] ?>").selectmenu({style:'dropdown', width:180, menuWidth:'180'});
        $('#img_prono_interrogation_<?php echo $kupGameData['id'];?>_<?php echo $kupGameData['questionId']; ?>').tipsy({fade:true, gravity:'s', html:true});
        $('#img_prono_interrogation_points_<?php echo $kupGameData['id'];?>_<?php echo $kupGameData['questionId']; ?>').tipsy({fade:true, gravity:'s', html:true});
    });
</script>
<?php endif ?>
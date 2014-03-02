<?php if ($kupGameData["type"] == "se") : ?>
<div class="basket-row basket-se-row-<?php echo $isActive ? 'active' : 'inactive' ?>">
    <div class="match-title">
        <?php echo $kupGameData["title"] ?>
    </div>
    <table class="match-prediction">
        <tr>
            <td class="team-left">
                <span class="avatar">
                    <?php echo image_tag($kupGameData["team1avatar"], array(
                                                                           'border'  => '0',
                                                                           "height"  => "60"
                                                                      ))?>
                </span>
            </td>
            <td class="prediction-cursor" rowspan="2">
                <table class="slider-infos">
                    <tr>
                        <td class="score red">
                            <span class="separator"></span>
                            <span class="text">
                                +30
                            </span>
                        </td>
                        <td class="score yellow">
                            <span class="separator"></span>
                            <span class="text">
                                +20
                            </span>
                        </td>
                        <td class="score green">
                            <span class="separator"></span>
                            <span class="text">
                                +10
                            </span>
                        </td>
                        <td class="score">
                            <span class="separator"></span>
                            <span class="text">
                                1
                            </span>
                        </td>
                        <td class="score">
                            <span class="separator"></span>
                            <span class="text">
                                2
                            </span>
                        </td>
                        <td class="score green">
                            <span class="separator"></span>
                            <span class="text">
                                +10
                            </span>
                        </td>
                        <td class="score yellow">
                            <span class="separator"></span>
                            <span class="text">
                                +20
                            </span>
                        </td>
                        <td class="score red">
                            <span class="separator"></span>
                            <span class="text">
                                +30
                            </span>
                        </td>
                        <td class="score">
                            <span class="separator"></span>
                        </td>
                    </tr>
                </table>
                <div class="slider-container">
                    <div id="slider_<?php echo $kupGameData["id"] ?>" class="slider slider-<?php echo $isActive ? 'active' : 'inactive' ?>"></div>
                </div>
                <input type="hidden" <?php echo (!$isActive) ? 'disabled="disabled"' : '' ?> id="predictions_ic_<?php echo $kupGameData["id"] ?>" name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="<?php echo (isset($predictions_ic[$kupGameData['id']]) && ($predictions_ic[$kupGameData['id']] == '1' || $predictions_ic[$kupGameData['id']] == '3')) ? $predictions_ic[$kupGameData['id']] : '1' ?>">
                <input type="hidden" <?php echo (!$isActive) ? 'disabled="disabled"' : '' ?> id="predictions_q_<?php echo $kupGameData["id"] ?>_<?php echo sfConfig::get('mod_basket_slider_question') ?>" name="predictions_q[<?php echo $kupGameData["id"] ?>_<?php echo sfConfig::get('mod_basket_slider_question') ?>]" value="<?php echo (isset($predictions_q[$kupGameData['id'] . '_' . sfConfig::get('mod_basket_slider_question')]) && ($predictions_q[$kupGameData['id'] . '_'.sfConfig::get('mod_basket_slider_question')] != '0')) ? $predictions_q[$kupGameData['id'] . '_'.sfConfig::get('mod_basket_slider_question')] : '0' ?>">

                <div class="text-info">
                    <p>
                        <?php echo __('text_prediction_basket_cursor') ?>
                    </p>
                </div>
            </td>
            <td class="team-right">
                <div>
                    <span class="avatar">
                        <?php echo image_tag($kupGameData["team2avatar"], array(
                                                                               'border'  => '0',
                                                                               "height"  => "50"
                                                                          ))?>
                     </span>
                </div>
            </td>
            <td class="actions" rowspan="2">
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
        <tr>
            <td class="team-left">
                <span>
                <?php echo $kupGameData["team1title"] ?>
                </span>
            </td>
            <td class="team-right">
                <span>
                <?php echo $kupGameData["team2title"] ?>
                </span>
            </td>
        </tr>
    </table>
</div>
<?php elseif ($kupGameData["type"] == "ic") : ?>
<div class="basket-row basket-row-<?php echo $isActive ? 'active' : 'inactive' ?>">
    <div class="match-title">
        <?php echo $kupGameData["title"] ?>
    </div>
    <table class="match-prediction">
        <tr>
            <td class="team-ic-left">
                <table style="margin-left: 2px; width: 100%;">
                    <tr>
                        <td class="team">
                            <?php echo $kupGameData["team1title"] ?>
                        </td>
                        <td class="team-img">
                            <?php echo image_tag($kupGameData["team1avatar"], array(
                                                                                   'border' => '0',
                                                                                   "height"  => "50"
                                                                              ))?>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="predictions-ic">
                <table class="table-predictions-ic">
                    <tr>
                        <td class="tdRadio tdRadio-left">
                            <?php if (isset($predictions_ic[$kupGameData['id']]) && $predictions_ic[$kupGameData['id']] == '-1'): ?>
                            <input type="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> style="visibility: hidden;" name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="-1" checked="checked"/>
                            <?php else: ?>
                            <input type="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> style="visibility: hidden;" name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="-1"/>
                            <?php endif ?>
                            <?php if (isset($predictions_ic[$kupGameData['id']]) && $predictions_ic[$kupGameData['id']] == '1'): ?>
                            <input type="radio" class="ic-left-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="1" checked="checked"/>
                            <?php else: ?>
                            <input type="radio" class="ic-left-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="1"/>
                            <?php endif ?>
                        </td>
                        <td class="tdRadio tdRadio-right">
                            <?php if (isset($predictions_ic[$kupGameData['id']]) && $predictions_ic[$kupGameData['id']] == '3'): ?>
                            <input type="radio" class="ic-right-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="3" checked="checked"/>
                            <?php else: ?>
                            <input type="radio" class="ic-right-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="3"/>
                            <?php endif ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="team-ic-right">
                <table style="margin-right: 2px; width: 100%;">
                    <tr>
                        <td class="team-img">
                            <div>
                                <?php echo image_tag($kupGameData["team2avatar"], array(
                                                                                   'border' => '0',
                                                                                   "height"  => "55"
                                                                              ))?>
                            </div>
                        </td>
                        <td class="team">
                            <?php echo $kupGameData["team2title"] ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="actions">
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

<?php
elseif ($kupGameData["type"] == "q" && $kupGameData['questionId'] != sfConfig::get('mod_basket_slider_question')) : ?>
<div class="basket-row basket-row-<?php echo $isActive ? 'active' : 'inactive' ?>">
    <div class="match-title">
        <?php echo $kupGameData["title"] ?>
    </div>
    <table class="predictions-questions">
        <tr>
            <td class="question-text">
                <?php echo $kupGameData["question"] ?>
            </td>
            <td class="predictions-q">
                <table class="table-predictions-q">
                    <?php if(count($kupGameData["choices"]) == 2) : ?>
                    <tr>
                        <?php $i=0; foreach ($kupGameData["choices"] as $key => $value): ?>
                            <?php if($i==0) : ?>
                            <td class="tdRadio tdRadio-left">
                                <?php if (isset($predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']]) && $predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']] == '-1'): ?>
                                <input type="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> style="visibility: hidden;position: absolute; z-index: -1;" name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="-1" checked="checked"/>
                                <?php else: ?>
                                <input type="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> style="visibility: hidden;position: absolute; z-index: -1;" name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="-1"/>
                                <?php endif ?>
                                <?php if (isset($predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']]) && $predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']] == $key): ?>
                                <input type="radio" class="q-left-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>" checked="checked"/>
                                <?php else: ?>
                                <input type="radio" class="q-left-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>"/>
                                <?php endif ?>
                            </td>
                            <?php elseif($i==1) : ?>
                            <td class="tdRadio tdRadio-right">
                                <?php if (isset($predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']]) && $predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']] == $key): ?>
                                <input type="radio" class="q-right-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>" checked="checked"/>
                                <?php else: ?>
                                <input type="radio" class="q-right-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>"/>
                                <?php endif ?>
                            </td>
                            <?php endif; ?>
                        <?php $i++; endforeach; ?>
                    </tr>
                    <?php elseif(count($kupGameData["choices"]) == 3) : ?>
                    <tr>
                        <?php $i=0; foreach ($kupGameData["choices"] as $key => $value): ?>
                        <?php if($i==0) : ?>
                        <td class="tdRadio tdRadio-left">
                            <?php if (isset($predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']]) && $predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']] == '-1'): ?>
                            <input type="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> style="visibility: hidden; position: absolute; z-index: -1;" name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="-1" checked="checked"/>
                            <?php else: ?>
                            <input type="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> style="visibility: hidden; position: absolute; z-index: -1;" name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="-1"/>
                            <?php endif ?>
                            <?php if (isset($predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']]) && $predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']] == $key): ?>
                            <input type="radio" class="q2-left-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>" checked="checked"/>
                            <?php else: ?>
                            <input type="radio" class="q2-left-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>"/>
                            <?php endif ?>
                        </td>
                        <?php elseif($i==1) : ?>
                        <td class="tdRadio tdRadio-center">
                            <?php if (isset($predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']]) && $predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']] == strval($key)): ?>
                            <input type="radio" class="q2-center-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>" checked="checked"/>
                            <?php else: ?>
                            <input type="radio" class="q2-center-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>"/>
                            <?php endif ?>
                        </td>
                        <?php elseif($i==2) : ?>
                        <td class="tdRadio tdRadio-right">
                            <?php if (isset($predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']]) && $predictions_q[$kupGameData['id']. '_' . $kupGameData['questionId']] == $key): ?>
                            <input type="radio" class="q2-right-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>" checked="checked"/>
                            <?php else: ?>
                            <input type="radio" class="q2-right-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>"/>
                            <?php endif ?>
                        </td>
                        <?php endif; ?>
                        <?php $i++; endforeach; ?>
                    </tr>
                    <?php endif; ?>
                </table>
            </td>
            <td class="actions">
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


<?php endif; ?>
<script type="text/javascript">
    $(function () {
        $('#img_prono_interrogation_<?php echo $kupGameData["id"]; ?>').tipsy({fade:true, gravity:'s', html:true});
        $('#img_prono_interrogation_points_<?php echo $kupGameData["id"]; ?>').tipsy({fade:true, gravity:'s', html:true});

            <?php if ($kupGameData["type"] == "se") : ?>
            $("#slider_<?php echo $kupGameData["id"] ?>").slider({
                disabled: <?php echo (!$isActive) ? 'true' : 'false' ?>,
                value:getDefaultValueFor<?php echo $kupGameData["id"] ?>(),
                min:1,
                max:10,
                step:1,
                slide:function (event, ui) {
                    if (ui.value < 2) {
                        return false;
                    }
                    if (ui.value > 9) {
                        return false;
                    }
                    var uiValue = formatRandomSliderValue(ui.value);

                    $('#predictions_ic_<?php echo $kupGameData["id"] ?>').val(uiValue['sliderTeam']);
                    $('#predictions_q_<?php echo $kupGameData["id"] ?>_<?php echo sfConfig::get('mod_basket_slider_question') ?>').val(uiValue['sliderQ']);
                }
            });
            <?php endif; ?>
    });

    <?php if ($kupGameData["type"] == "se") : ?>
    function getDefaultValueFor<?php echo $kupGameData["id"] ?>() {

        var prediction = $('#predictions_ic_<?php echo $kupGameData["id"] ?>').val(),
            question = $('#predictions_q_<?php echo $kupGameData["id"] ?>_<?php echo sfConfig::get('mod_basket_slider_question') ?>').val();

        return formatSliderValues(prediction, question);
    }

    function formatSliderValues(prediction, question) {

        var defaultValue = 5;

        // Team 1 win
        if (prediction == 1) {
            defaultValue = 5;
            if (question == 10) {
                defaultValue = 4;
            }
            else if (question == 20) {
                defaultValue = 3;
            } else if (question == 30) {
                defaultValue = 2;
            }
        }
        // Team 2 win
        else if (prediction == 3) {
            defaultValue = 6;
            if (question == 10) {
                defaultValue = 7;
            }
            else if (question == 20) {
                defaultValue = 8;
            } else if (question == 30) {
                defaultValue = 9;
            }
        }
        return defaultValue;
    }

    <?php endif; ?>
</script>
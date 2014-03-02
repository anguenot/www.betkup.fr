<?php if ($kupGameData["type"] == "ic" || $kupGameData["type"] == "se") : ?>
<div class="basket-row basket-se-row-<?php echo $isActive ? 'active' : 'inactive' ?>">
    <div class="match-title">
        <?php echo $kupGameData["title"] ?>
    </div>
    <div class="match-info">
        <h2>
            <b>Match :</b> <?php echo $kupGameData["team1title"] ?>
            / <?php echo $kupGameData["team2title"] ?>
        </h2>
        <br/>

        <h2>
            <b>Date
                :</b> <?php echo Util::displayDateCompleteFromTimestampComplet($kupData['startDate']) ?>
        </h2>

        <div class="teams-avatars">
            <?php echo image_tag($kupGameData["team1avatar"], array('height' => '80')) ?>
            <div class="thumb-vs-team"></div>
            <?php echo image_tag($kupGameData["team2avatar"], array('height' => '80')) ?>
        </div>
    </div>
</div>
<?php elseif ($kupGameData["type"] == "q") : ?>
<?php if (isset($kupGameData['choices']) && count($kupGameData['choices']) < 4) : ?>
    <div class="basket-player-row basket-player-row-<?php echo $isActive ? 'active' : 'inactive' ?>">
        <table class="table-player-row-q">
            <tr>
                <td class="question-text">
                    <span>
                        <?php echo $kupGameData["question"] ?>
                    </span>
                </td>
                <td class="question-choices">
                    <table class="table-predictions-player-q">
                        <?php if (count($kupGameData["choices"]) == 2) : ?>
                        <tr>
                            <?php $i = 0; foreach ($kupGameData["choices"] as $key => $value): ?>
                            <?php if ($i == 0) : ?>
                                <td class="tdRadio tdRadio-left">
                                    <?php if (isset($predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']]) && $predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']] == '-1'): ?>
                                    <input type="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> style="visibility: hidden;position: absolute; z-index: -1;" name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="-1" checked="checked"/>
                                    <?php else: ?>
                                    <input type="radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> style="visibility: hidden;position: absolute; z-index: -1;" name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="-1"/>
                                    <?php endif ?>
                                    <?php if (isset($predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']]) && $predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']] == $key): ?>
                                    <input type="radio" class="q-left-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>" checked="checked"/>
                                    <?php else: ?>
                                    <input type="radio" class="q-left-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>"/>
                                    <?php endif ?>
                                </td>
                                <?php elseif ($i == 1) : ?>
                                <td class="tdRadio tdRadio-right">
                                    <?php if (isset($predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']]) && $predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']] == $key): ?>
                                    <input type="radio" class="q-right-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>" checked="checked"/>
                                    <?php else: ?>
                                    <input type="radio" class="q-right-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_q[<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>]" value="<?php echo $key ?>"/>
                                    <?php endif ?>
                                </td>
                                <?php endif; ?>
                            <?php $i++; endforeach; ?>
                        </tr>
                        <?php endif; ?>
                    </table>
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
                    <script type="text/javascript">
                        $(function () {
                            $('#img_prono_interrogation_<?php echo $kupGameData["id"] . '_' . $kupGameData['questionId']; ?>').tipsy({fade:true, gravity:'s', html:true});
                            $('#img_prono_interrogation_points_<?php echo $kupGameData["id"] . '_' . $kupGameData['questionId']; ?>').tipsy({fade:true, gravity:'s', html:true});
                        });
                    </script>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    <?php elseif ($kupGameData['type'] == 'q' && isset($kupGameData['choices']) && count($kupGameData['choices']) >= 4) : ?>
    <div class="basket-slider-q-row basket-slider-q-row-<?php echo $isActive ? 'active' : 'inactive' ?>">
        <table class="match-prediction">
            <tr>
                <td class="prediction-cursor">
                    <div style="float: right; padding-right: 10px;">
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
                    </div>
                    <div class="text-info">
                        <p>
                            <?php echo $kupGameData['question'] ?>
                        </p>
                    </div>
                    <table class="slider-infos">
                        <tr>
                            <?php $i = 0; foreach ($kupGameData['choices'] as $kupGameDataChoices) : ?>
                            <td class="question-slider">
                                <div>
                                    <?php if ($i < (count($kupGameData['choices']) - 1)) : ?>
                                    <span class="separator"></span>
                                    <?php else : ?>
                                    <span class="separator-hidden"></span>
                                    <?php endif; ?>
                                    <span class="question-slider-text">
                                    <?php echo $kupGameDataChoices ?>
                                    </span>
                                </div>
                            </td>
                            <?php $i++; endforeach; ?>
                        </tr>
                    </table>

                    <select style="display: none;" id="slider-choices-list-for-<?php echo $kupGameData['id'].'-'.$kupGameData['questionId'] ?>">
                        <?php foreach ($kupGameData['choices'] as $key => $kupGameDataChoices) : ?>
                        <option value="<?php echo $key ?>">
                            <?php echo $kupGameDataChoices ?>
                        </option>
                        <?php endforeach ?>
                    </select>

                    <div class="slider-container">
                        <div class="slider"></div>
                    </div>
                    <input type="hidden" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> id="predictions_q_<?php echo $kupGameData["id"] ?>_<?php echo $kupGameData['questionId'] ?>" name="predictions_q[<?php echo $kupGameData["id"] ?>_<?php echo $kupGameData['questionId'] ?>]" value="<?php echo (isset($predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']]) && ($predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']] != '0')) ? $predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']] : '-1' ?>">
                </td>
            </tr>
        </table>
    </div>
    <div style="clear: both;"></div>
    <script type="text/javascript">
        $(function () {
            $('#img_prono_interrogation_<?php echo $kupGameData["id"] . '_' . $kupGameData['questionId']; ?>').tipsy({fade:true, gravity:'s', html:true});
            $('#img_prono_interrogation_points_<?php echo $kupGameData["id"] . '_' . $kupGameData['questionId']; ?>').tipsy({fade:true, gravity:'s', html:true});

            $(".slider").slider({
                disabled: <?php echo (!$isActive) ? 'true' : 'false' ?>,
                value: getDefaultValueFor<?php echo $kupGameData["id"] ?>(),
                min:1,
                max:9,
                step:1,
                slide:function (event, ui) {
                    if (ui.value < 2) {
                        return false;
                    }
                    else if (ui.value == 3) {
                        return false;
                    }
                    else if (ui.value == 5) {
                        return false;
                    }
                    else if (ui.value == 7) {
                        return false;
                    }
                    else if (ui.value > 8) {
                        return false;
                    }
                    var uiValue = formatRandomSliderValue<?php echo $kupGameData['id'].$kupGameData['questionId'] ?>(ui.value);

                    $('#predictions_q_<?php echo $kupGameData["id"] ?>_<?php echo $kupGameData['questionId'] ?>').val(uiValue);
                }
            });

            function formatRandomSliderValue<?php echo $kupGameData['id'].$kupGameData['questionId'] ?>(randomSlider) {

                var formatedQuestionValue = 0;
                    choicesList = [];

                $('#slider-choices-list-for-<?php echo $kupGameData['id'].'-'.$kupGameData['questionId'] ?> option').each(function() {
                    choicesList.push($(this).val());
                });

                if(randomSlider == 2) {
                    formatedQuestionValue = 0;
                } else if(randomSlider == 4) {
                    formatedQuestionValue = 1;
                } else if(randomSlider == 6) {
                    formatedQuestionValue = 2;
                } else if(randomSlider == 8) {
                    formatedQuestionValue = 3;
                }

                formatedQuestion = choicesList[formatedQuestionValue];

                console.log(choicesList);
                return formatedQuestion;
            }

            function getDefaultValueFor<?php echo $kupGameData["id"] ?>() {
                var question = $('#predictions_q_<?php echo $kupGameData["id"] ?>_<?php echo $kupGameData['questionId'] ?>').val();

                return formatSliderValues(question);
            }

            function formatSliderValues(question) {

                console.log(question);

                var choicesList = [],
                    returnValue = '-1',
                    formatedReturnValue = "2";

                $('#slider-choices-list-for-<?php echo $kupGameData['id'].'-'.$kupGameData['questionId'] ?> option').each(function() {
                    choicesList.push($(this).val());
                });

                for(var i=0; i < choicesList.length; i++) {
                    if(question == choicesList[i]) {
                        returnValue = i;
                        break;
                    }
                }
                if(returnValue == 0) {
                    formatedReturnValue = 2;
                } else if(returnValue == 1) {
                    formatedReturnValue = 4;
                } else if(returnValue == 2) {
                    formatedReturnValue = 6;
                } else if(returnValue == 3) {
                    formatedReturnValue = 8;
                }

                console.log(formatedReturnValue);
                return formatedReturnValue;
            }
        });
    </script>
    <?php endif; ?>
<?php endif; ?>
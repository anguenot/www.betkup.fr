<?php if ($kupGameData["type"] == "ic" || $kupGameData["type"] == "se"): ?>
<div class="date"><?php echo $kupGameData["title"] ?></div>
<div class="match match<?php echo ($isActive) ? '-active' : '-inactive'; ?>">
    <table class="table-pronostic-row">
        <tr>
            <td class="avatar-team avatar-team-left">
                <?php echo image_tag($kupGameData["team1avatar"], array(
                                                                       'border' => '0',
                                                                       "size"   => "50x35"
                                                                  ))?>
            </td>
            <td class="title-team title-team-left" style="width: 200px;">
                <div style="margin-right: 2px;">
                    <span class="team"><?php echo $kupGameData["team1title"] ?></span>
                    <?php if (isset($kupGameData['properties']) && isset($kupGameData['properties']['first_entry_seed_position']) && $kupGameData['properties']['first_entry_seed_position'] != '') : ?>
                    <span class="seed">(<?php echo $kupGameData['properties']['first_entry_seed_position'] ?>
                        )</span>
                    <?php endif;?>
                </div>
            </td>
            <?php if ($kupGameData["type"] == "ic"): ?>
            <td class="tdRadio tdRadio-left">
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
                -
            </td>
            <td class="tdRadio tdRadio-right">
                <?php if (isset($predictions_ic[$kupGameData['id']]) && $predictions_ic[$kupGameData['id']] == '3'): ?>
                <input type="radio" class="right-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="3" checked="checked"/>
                <?php else: ?>
                <input type="radio" class="right-radio" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_ic[<?php echo $kupGameData["id"] ?>]" value="3"/>
                <?php endif ?>
            </td>
            <?php else: ?>
            <td width="85" align="center">
                <select id="predictions_se_<?php echo $kupGameData["id"] ?>_1" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_se[<?php echo $kupGameData["id"] ?>_1]" class="formInputSelect tennisSmall tennisSelect" style="width: 80px;">
                    <?php if (isset($predictions_se[$kupGameData['id'] . '_1']) && $predictions_se[$kupGameData['id'] . '_1'] == '0'): ?>
                    <option value="0" selected="selected"><?php echo '-'; ?></option>
                    <?php else: ?>
                    <option value="0"><?php echo '-'; ?></option>
                    <?php endif ?>
                    <?php for ($i = 0; $i <= 3; $i++): ?>
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
                <select id="predictions_se_<?php echo $kupGameData["id"] ?>_2" <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> name="predictions_se[<?php echo $kupGameData["id"] ?>_2]" class="formInputSelect tennisSmall tennisSelect" style="width: 80px;">
                    <?php if (isset($predictions_se[$kupGameData['id'] . '_2']) && $predictions_se[$kupGameData['id'] . '_2'] == '0'): ?>
                    <option value="0" selected="selected"><?php echo '-'; ?></option>
                    <?php else: ?>
                    <option value="0"><?php echo '-'; ?></option>
                    <?php endif ?>
                    <?php for ($i = 0; $i <= 3; $i++): ?>
                    <?php if (isset($predictions_se[$kupGameData['id'] . '_2']) && $predictions_se[$kupGameData['id'] . '_2'] == $i): ?>
                        <option value="<?php echo $i ?>" selected="selected"><?php echo $i ?></option>
                        <?php else: ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php endif ?>
                    <?php endfor ?>
                </select>
            </td>
            <?php endif ?>
            <td class="title-team title-team-right" style="width: 200px;">
                <div style="margin-left: 2px;">
                    <span class="team"><?php echo $kupGameData["team2title"] ?></span>
                    <?php if (isset($kupGameData['properties']) && isset($kupGameData['properties']['second_entry_seed_position']) && $kupGameData['properties']['second_entry_seed_position'] != '') : ?>
                    <span class="seed">(<?php echo $kupGameData['properties']['second_entry_seed_position'] ?>
                        )</span>
                    <?php endif;?>
                </div>
            </td>
            <td class="avatar-team avatar-team-right">
                <?php echo image_tag($kupGameData["team2avatar"], array(
                                                                       'border' => '0',
                                                                       "size"   => "50x35"
                                                                  ))?>
            </td>
            <td class="interogations" style="width: 40px;">
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

        $('#img_prono_interrogation_<?php echo $kupGameData["id"]; ?>').tipsy({fade:true, gravity:'s', html:true});
    });
</script>
<?php else: ?>
<div class="match <?php echo ($kupGameData["type"] == "q" ? "question" : "")?>">
    <table style="height: 58px; border-spacing: 0px; border-collapse:collapse;">
        <tr>
            <td width="329" align="left" valign="middle">
                <div style="margin-left: 15px; margin-right: 37px; vertical-align: middle;">
                    <p class="team">Combien de sets seront disputés pendant ce match ?</p>
                </div>
            </td>
            <td width="295" align="left">
                <div style="margin-left: 40px;">
                    <select <?php echo (!$isActive) ? 'disabled="disabled"' : ''; ?> id="predictions_q_<?php echo $kupGameData["id"] . '_' . $kupGameData['questionId'] ?>" name="select_sets" class="formInputSelect tennisSelect tennisBig">
                        <option value="-1">Choisir</option>
                        <?php foreach ($sets as $key => $value): ?>
                        <?php if ($predictionsNumberSets == $key): ?>
                            <option value="<?php echo $key ?>" selected="selected"><?php echo __($value) ?></option>
                            <?php else: ?>
                            <option value="<?php echo $key ?>"><?php echo __($value) ?></option>
                            <?php endif ?>
                        <?php endforeach ?>
                    </select>
                </div>
            </td>
            <td width="55" align="center">
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
    <div style="height: 10px;"></div>
    <table class="sets-container" id="sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>">
        <tbody>
        <tr>
            <td>
                <table class="sets-table">
                    <tbody>
                    <tr class="team1">
                        <th>
                            <?php echo $kupGameData["team1title"]?>
                        </th>
                        <?php if (isset($predictions_q) && isset($predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']]) && isset($predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']][0])) : ?>
                        <?php $i = 0;
                        foreach ($predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']][0] as $predictions_q_team1) : ?>
                            <td <?php echo (!$isActive) ? 'class="sets-cursors-disabled"' : '' ?>>
                                <input class="sets-inputs default-text" type="text" maxlength="3" value="<?php echo $predictions_q_team1 ?>"
                                       id="predictions_q_<?php echo $kupGameData["id"] ?>_<?php echo $kupGameData['questionId'] ?>'_0_<?php echo $i ?>"
                                       name="predictions_q['<?php echo $kupGameData["id"] ?>_<?php echo $kupGameData['questionId'] ?>'][0][<?php echo $i ?>]"
                                    <?php echo (!$isActive) ? 'disabled="disabled"' : '' ?>
                                    />

                                <div class="sets-cursors">
                                    <div class="cursor-background">
                                        <a class="cursor-up" href="javascript:void(0);"></a>
                                    </div>
                                    <div class="sets-cursors-spacer"></div>
                                    <div class="cursor-background">
                                        <a class="cursor-down" href="javascript:void(0);"></a>
                                    </div>
                                </div>
                            </td>
                            <?php $i++; endforeach; ?>
                        <?php endif;?>
                    </tr>
                    <tr class="team2">
                        <th>
                            <?php echo $kupGameData["team2title"]?>
                        </th>
                        <?php if (isset($predictions_q) && isset($predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']]) && isset($predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']][1])) : ?>
                        <?php $i = 0;
                        foreach ($predictions_q[$kupGameData['id'] . '_' . $kupGameData['questionId']][1] as $predictions_q_team2) : ?>
                            <td <?php echo (!$isActive) ? 'class="sets-cursors-disabled"' : '' ?>>
                                <input class="sets-inputs default-text" type="text" maxlength="3" value="<?php echo $predictions_q_team2 ?>"
                                       id="predictions_q_<?php echo $kupGameData["id"] ?>_<?php echo $kupGameData['questionId'] ?>'_1_<?php echo $i ?>"
                                       name="predictions_q['<?php echo $kupGameData["id"] ?>_<?php echo $kupGameData['questionId'] ?>'][1][<?php echo $i ?>]"
                                    <?php echo (!$isActive) ? 'disabled="disabled"' : '' ?> />

                                <div class="sets-cursors">
                                    <div class="cursor-background">
                                        <a class="cursor-up" href="javascript:void(0);"></a>
                                    </div>
                                    <div class="sets-cursors-spacer"></div>
                                    <div class="cursor-background">
                                        <a class="cursor-down" href="javascript:void(0);"></a>
                                    </div>
                                </div>
                            </td>
                            <?php $i++; endforeach; ?>
                        <?php endif;?>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td width="55" align="center">
                <?php if ($isActive) : ?>
                <a href="javascript:void(0);" class="interogation-question"
                   id="img_prono_interrogation_sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>"
                   title="<?php echo $questionText ?>">
                </a>
                <a href="javascript:void(0);" class="interogation-points"
                   id="img_prono_interrogation_sets_points_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>"
                   title="<?php echo $pointsText ?>">
                </a>
                <?php endif; ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(function () {
        if ($('#predictions_q_<?php echo $kupGameData["id"] . '_' . $kupGameData['questionId'] ?>').val() == -1) {
            $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>').hide();
        } else {
            $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>').show();

            <?php if ($isActive) : ?>
                $('.cursor-up', $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>')).click(function () {
                    var element = $(this).parent().parent().parent().find('input[type=text]');
                    var start = element.val();
                    addOneSetFor<?php echo $kupGameData['id'] . $kupGameData['questionId'] ?>(element, start);
                });
                $('.cursor-down', $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>')).click(function () {
                    var element = $(this).parent().parent().parent().find('input[type=text]');
                    var start = element.val();
                    removeOneSetFor<?php echo $kupGameData['id'] . $kupGameData['questionId'] ?>(element, start);
                });
                <?php endif;?>
        }

        $('#img_prono_interrogation_<?php echo $kupGameData['id'];?>_<?php echo $kupGameData['questionId']; ?>').tipsy({fade:true, gravity:'s', html:true});
        $('#img_prono_interrogation_points_<?php echo $kupGameData['id'];?>_<?php echo $kupGameData['questionId']; ?>').tipsy({fade:true, gravity:'s', html:true});

        $('#predictions_q_<?php echo $kupGameData["id"] . '_' . $kupGameData['questionId'] ?>').change(function () {
            if (parseInt($(this).val()) > 0) {
                $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>').show();
            } else {
                $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>').hide();
            }
            addPredictionSet<?php echo $kupGameData['id'] . $kupGameData['questionId'] ?>($(this).val());
        });
    });

    function addOneSetFor<?php echo $kupGameData['id'] . $kupGameData['questionId'] ?>(element, start) {
        var increment = parseInt(start, 10) + 1;
        if (increment > 100) {
            increment = 100;
        }
        element.val(increment);
    }
    function removeOneSetFor<?php echo $kupGameData['id'] . $kupGameData['questionId'] ?>(element, start) {
        var increment = parseInt(start, 10) - 1;
        if (increment < 0) {
            increment = 0;
        }
        element.val(increment);
    }

    function insertTdElement<?php echo $kupGameData['id'] . $kupGameData['questionId'] ?>(i, team1, team2) {
        var link, sets, inputTeam1, inputTeam2, cursorDiv, cursorUp, cursorDown, spacer, defaultSearchText = 0;
        inputTeam1 = $(document.createElement('input')).addClass('sets-inputs').attr({
            'type':'text',
            'maxlength':'3',
            'value':'0',
            'id':'predictions_q_<?php echo $kupGameData["id"] ?>_<?php echo $kupGameData['questionId'] ?>_0_' + i,
            'name':'predictions_q[<?php echo $kupGameData["id"] ?>_<?php echo $kupGameData['questionId'] ?>][0][' + i + ']'
        });

        inputTeam2 = $(document.createElement('input')).addClass('sets-inputs').attr({
            'type':'text',
            'maxlength':'3',
            'value':'0',
            'id':'predictions_q_<?php echo $kupGameData["id"] ?>_<?php echo $kupGameData['questionId'] ?>_1_' + i,
            'name':'predictions_q[<?php echo $kupGameData["id"] ?>_<?php echo $kupGameData['questionId'] ?>][1][' + i + ']'
        });
        tdSets1 = $(document.createElement('td'));
        tdSets2 = tdSets1.clone();
        cursorDiv = $(document.createElement('div')).addClass('sets-cursors');
        spacer = $(document.createElement('div')).addClass('sets-cursors-spacer');

        cursorUp = $(document.createElement('div')).addClass('cursor-background');
        link = $(document.createElement('a')).addClass('cursor-up').attr('href', 'javascript:void(0);');
        link.appendTo(cursorUp);
        cursorDown = $(document.createElement('div')).addClass('cursor-background');
        link = $(document.createElement('a')).addClass('cursor-down').attr('href', 'javascript:void(0);');
        link.appendTo(cursorDown);

        cursorUp.appendTo(cursorDiv);
        spacer.appendTo(cursorDiv);
        cursorDown.appendTo(cursorDiv);

        <?php if (!$isActive) : ?>
            inputTeam1.attr('disabled', 'disabled');
            inputTeam2.attr('disabled', 'disabled');
            tdSets1.addClass('sets-cursors-disabled');
            tdSets2.addClass('sets-cursors-disabled');
            <?php endif;?>

        inputTeam1.appendTo(tdSets1);
        cursorDiv.appendTo(tdSets1);
        inputTeam2.appendTo(tdSets2);
        cursorDiv.clone().appendTo(tdSets2);

        team1.append(tdSets1);
        team2.append(tdSets2);
    }

    function addPredictionSet<?php echo $kupGameData['id'] . $kupGameData['questionId'] ?>(number) {

        var link, team1, team2, sets, inputTeam1, inputTeam2, cursorDiv, cursorUp, cursorDown, spacer, defaultSearchText = 0;
        team1 = $('.team1', $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>'));
        team2 = $('.team2', $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>'));

        team1.find('td').remove();
        team2.find('td').remove();

        for (var i = 1; i <= number; i++) {
            insertTdElement<?php echo $kupGameData['id'] . $kupGameData['questionId'] ?>(i, team1, team2);
        }
        if ($('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>').find('.sets-table').find('td').hasClass('sets-cursors-disabled')) {
        } else {
            $('.cursor-up', $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>')).click(function () {
                var element = $(this).parent().parent().parent().find('input[type=text]');
                var start = element.val();
                addOneSetFor<?php echo $kupGameData['id'] . $kupGameData['questionId'] ?>(element, start);
            });
            $('.cursor-down', $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>')).click(function () {
                var element = $(this).parent().parent().parent().find('input[type=text]');
                var start = element.val();
                removeOneSetFor<?php echo $kupGameData['id'] . $kupGameData['questionId'] ?>(element, start);
            });
        }

        $('input[type=text]', $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>')).addClass('default-text').val(defaultSearchText);
        $('input[type=text]', $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>')).live('focus', function () {
            if ($(this).val() == defaultSearchText) {
                $(this).removeClass('default-text');
                $(this).val('');
            }
        });
        $('input[type=text]', $('#sets_<?php echo $kupGameData['id'] . '_' . $kupGameData['questionId'] ?>')).blur(function () {
            if ($(this).val() == '') {
                $(this).addClass('default-text');
                $(this).val(defaultSearchText);
            }
        });
    }
</script>
<?php endif ?>
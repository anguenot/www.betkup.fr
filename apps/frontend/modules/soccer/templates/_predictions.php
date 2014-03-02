<div class="prediction" align="left">
    <div class="view">
        <div style="margin: 0; display: block;">
            <?php echo isset($kupData['ui']['header-kup-custom']) ? image_tag($kupData['ui']['header-kup-custom']) : "" ?>
        </div>
        <div class="header" align="left" style="height: 65px; <?php echo $sf_user->isAuthenticated() ? "background: url('/images/kup/view/pronostic/disquette.png');" : "background: none;" ?>">
        <div style="float: left; margin-left: 30px; margin-top: 23px; font: bold 12px Arial, sans-serif;">
            <?php if ($lastModified != NULL): ?>
                <?php $date = util::displayDateCompleteFromTimestampComplet($lastModified); ?>
                <?php if($sf_user->getAttribute('is_draft', '0', 'predictionsSave') &&
                    $kup_uuid == $sf_user->getAttribute('kup_uuid', '', 'predictionsSave')) : ?>
                    <h2 style="color: #E65E1B; padding: 5px; background: rgba(255, 195, 112, 0.6); font: bold 12px Arial, sans-serif;">
                        <?php echo __('text_predictions_draft_with_last_modification', array(
                                                                                            '%br%' => '<br />',
                                                                                            '%span%' => '<span style="font: normal 12px Arial, sans-serif;">',
                                                                                            '%/span%' => '</span>',
                                                                                            '%link_date%' => link_to(substr($date, 0, strlen($date) - 7), $sf_request->getUri().'?empty_draft=1', array(
                                                                                                                                                                                                       'class' => 'draft-pronos',
                                                                                                                                                                                                       'style' => 'font: bold 12px Arial, sans-serif; color: #9f4113;'
                                                                                                                                                                                                  ))
                                                                                       )) ?>
                    </h2>
                <?php else : ?>
                        <h2 class="date" style="padding: 5px; font: bold 12px Arial, sans-serif;" title="<?php echo $date ?>">
                            <?php echo __('label_kup_prediction_last_modified') . ' : ' . substr($date, 0, strlen($date) - 7) ?>
                        </h2>
                <?php endif; ?>
            <?php else : ?>
                <?php if($sf_user->getAttribute('is_draft', '0', 'predictionsSave') &&
                    $kup_uuid == $sf_user->getAttribute('kup_uuid', '', 'predictionsSave')) : ?>
                    <h2 style="color: #E65E1B; padding: 5px; background: rgba(255, 195, 112, 0.6); font: bold 12px Arial, sans-serif;">
                        <?php echo __('text_predictions_draft_simple') ?>
                    </h2>
                <?php else : ?>
                    <h2 style="padding: 5px; font: bold 12px Arial, sans-serif;">
                        <?php echo $sf_user->isAuthenticated() ? __('label_kup_prediction_none') : "" ?>
                    </h2>
                <?php endif; ?>
            <?php endif; ?>
            </div>
            <div style="float: right; margin-top: 20px;">
                <?php if (count($kupRoundsData) > 1): ?>
                <form name="kupPredictionRound" method="get" action="">
                    <select id="roundUUIDSelect" class="formInputSelect" name="roundUUID" style="margin-top: 20px;" onChange="document.kupPredictionRound.submit();">
                        <?php foreach ($kupRoundsData as $round): ?>
                        <?php if ($roundUUID == $round['uuid']): ?>
                            <option value="<?php echo $round['uuid'] ?>" selected="selected"><?php echo ($round['name'] == 'Round') ? __($name . '_' . $round['name']) : __($round['name']) ?><?php echo (is_numeric($round['name'])) ? __('text_prediction_round') : ''; ?><?php echo ($round['status'] == 'TERMINATED') ? ' - F' : ' - O'; ?></option>
                            <?php else: ?>
                            <option value="<?php echo $round['uuid'] ?>"><?php echo ($round['name'] == 'Round') ? __($name . '_' . $round['name']) : __($round['name']) ?><?php echo (is_numeric($round['name'])) ? __('text_prediction_round') : ''; ?><?php echo ($round['status'] == 'TERMINATED') ? ' - F' : ' - O'; ?></option>
                            <?php endif ?>
                        <?php endforeach ?>
                    </select>
                </form>
                <?php endif ?>
            </div>
        </div>
        <div class="content" style="padding-left: 2px;">
            <div style="margin: 0px; padding: 0px; height: 10px;"></div>
            <form id="kupPredictionSave" name="kupPredictionSave" action="" method="post">
                <?php foreach ($kupGamesData as $kupGameData): ?>
                <?php include_component('kup', 'predictionRow',
                    array(
                         'kupGameData'   => $kupGameData,
                         'kupData'       => $kupData,
                         'sport'         => 'soccer',
                         'predictions_ic'=> $predictions_ic,
                         'predictions_se'=> $predictions_se,
                         'predictions_q' => $predictions_q,
                         'name'          => $name,
                         'isActive'      => $kupGameData['isActive']
                    )) ?>
                <?php endforeach ?>
                <?php if (count($kupGamesData) > 0 && $hideButtons) : ?>
                <?php elseif (count($kupGamesData) > 0): ?>
                <div align="center" style="margin-top: 35px;">
                    <a href="javascript:clearPronostics();" style="text-align: right;">
                        <?php echo image_tag('/image/' . $sf_user->getCulture() . '/rugby/button_erase_pronostics.png', array(
                                                                                                                             'style'  => 'margin: 5px;',
                                                                                                                             'class'  => 'button',
                                                                                                                             'size'   => '173x34',
                                                                                                                             'alt'    => __('label_rugby_erase_pronostics')
                                                                                                                        )) ?>
                    </a>
                    <a href="javascript:randomPronostics();" style="text-align: left;">
                        <?php echo image_tag('/image/' . $sf_user->getCulture() . '/rugby/button_fill_randomly.png', array(
                                                                                                                          'style'  => 'margin: 5px;',
                                                                                                                          'class'  => 'button',
                                                                                                                          'size'   => '173x34',
                                                                                                                          'alt'    => __('label_rugby_fill_randomly')
                                                                                                                     )) ?>
                    </a>
                </div>
                <div align="center" style="margin-top: 35px;">
                    <input type="image" title="" src="<?php echo '/image/' . $sf_user->getCulture() . '/kup/button_prediction_save.png' ?>"/>
                </div>
                <?php
            else: ?>
                <div align="left" style="margin-top: 20px; width: 710px; height: 65px;">
                    <?php echo __('label_kup_predictions_none') ?>
                </div>
                <?php endif ?>
            </form>
        </div>
        <div style="height: 40px;"></div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        var textFormatting = function (text) {
            var newText = new Array();
            newText = text.split(' - ');
            if (newText.length > 1) {
                if (newText[1] == 'F') {
                    return '<div style="width: 5px; height: 20px; line-height: 20px; background-color: #EA705A; color: #FFFFFF; text-align: center; float: left;"></div><span style="margin-left: 10px; display: inline; font-size: 14px;">' + newText[0] + '</span>';
                } else {
                    return '<div style="width: 5px; height:20px; line-height: 20px; background-color: #B4C810; color: #FFFFFF; text-align: center; float: left;"></div><span style="margin-left: 10px; display: inline; font-size: 14px;">' + newText[0] + '</span>';
                }

            } else {
                return '<span style="display: inline; font-size: 14px;">' + text + '</span>';
            }
        };

        $("#roundUUIDSelect").selectmenu({
            style:'dropdown',
            format:textFormatting,
            width:170,
            menuWidth:170
        });
    });

    function clearPronostics() {
        //Reset Input
        $("input:not(:disabled)").each(function () {
            $(this).get(0).checked = false;
            $(this).change();
        });

        $('input[value="-1"]:not(:disabled)').attr('checked', 'checked');

        var arrayLabelByDefault = new Array;

        //Get all first select items
        for (var int = 0; int < $('select[id^="predictions"]:not(:disabled)').length; int++) {
            arrayLabelByDefault.push($('select[id^="predictions"]:not(:disabled)').eq(int).attr('id'));
        }

        //Set all new first select items
        for (var int = 0; int < arrayLabelByDefault.length; int++) {
            var backToZero = arrayLabelByDefault[int].split(':');
            $('select[id=' + backToZero[0] + ']:not(:disabled) option:selected').removeAttr('selected');
            $('select[id=' + backToZero[0] + ']:not(:disabled) option:eq(0)').attr('selected', '');
            $('select[id=' + backToZero[0] + ']:not(:disabled)').selectmenu();
        }
    }

    function randomPronostics() {
        var arrayLabelByDefault = new Array;

        //Get random select items
        for (var int = 0; int < $('select[id^="predictions"]:not(:disabled)').length; int++) {
            var nbOption = $('select[id^="predictions"]:not(:disabled):eq(' + int + ') option').length;
            var randomOption = Math.ceil(Math.random() * nbOption);
            if (randomOption == '1') {
                randomOption = '2';
            }
            arrayLabelByDefault.push($('select[id^="predictions"]:not(:disabled)').eq(int).attr('id') + ':' + (randomOption - 1));
        }

        //Set all new first select items
        for (var int = 0; int < arrayLabelByDefault.length; int++) {
            var randomValue = arrayLabelByDefault[int].split(':');
            $('select[id=' + randomValue[0] + ']:not(:disabled) option:selected').removeAttr('selected');
            $('select[id=' + randomValue[0] + ']:not(:disabled) option:eq(' + randomValue[1] + ')').attr('selected', '');
            if (randomValue[0].indexOf("predictions_se") != -1) {
                $('select[id=' + randomValue[0] + ']:not(:disabled)').selectmenu();
            } else if (randomValue[0].indexOf("predictions_q") != -1) {
                $('select[id=' + randomValue[0] + ']:not(:disabled)').selectmenu();
            }
        }

        //Reset Input
        $("input:not(:disabled)").each(function () {
            $(this).get(0).checked = false;
            $(this).change();
        });

        //Set random checked radio
        for (var int = 0; int < $('div.match-active').length; int++) {
            var nbInput = $('div.match-active:eq(' + int + ') table tr td input[name^="predictions"]').length;
            var randomInput = Math.ceil(Math.random() * (nbInput - 1));
            if (randomInput == '0') {
                randomInput = '1';
            }
            $('div.match-active:eq(' + int + ') table tr td input:eq(' + (randomInput) + ')').attr('checked', 'checked');
        }
    }
</script>
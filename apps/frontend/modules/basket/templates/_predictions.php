<?php use_stylesheet('basket/predictions.css') ?>
<?php use_stylesheet('ui-lightness/jquery-ui-1.8.14.custom.css') ?>
<?php use_stylesheet('basket/checkbox.css') ?>
<?php use_javascript('jquery.checkbox.min.js') ?>

<div class="prediction" align="left">
    <div class="view basket-view">
        <div class="header" align="left" style="height: 65px; <?php echo $sf_user->isAuthenticated() ? "background: url('/images/kup/view/pronostic/disquette.png');" : "background: none;" ?>">
            <div style="float: left; margin-left: 30px; margin-top: 23px; font: bold 12px Arial, sans-serif;">
                <?php if ($lastModified != NULL): ?>
                <?php $date = util::displayDateCompleteFromTimestampComplet($lastModified); ?>
                <?php if ($sf_user->getAttribute('is_draft', '0', 'predictionsSave')
                    && $kup_uuid == $sf_user->getAttribute('kup_uuid', '', 'predictionsSave')
                ) : ?>
                    <h2 style="color: #E65E1B; padding: 5px; background: rgba(255, 195, 112, 0.6); font: bold 12px Arial, sans-serif;">
                        <?php echo __('text_predictions_draft_with_last_modification', array(
                                                                                            '%br%'        => '<br />',
                                                                                            '%span%'      => '<span style="font: normal 12px Arial, sans-serif;">',
                                                                                            '%/span%'     => '</span>',
                                                                                            '%link_date%' => link_to(substr($date, 0, strlen($date) - 7), $sf_request->getUri() . '?empty_draft=1', array(
                                                                                                                                                                                                         'class' => 'draft-pronos',
                                                                                                                                                                                                         'style' => 'font: bold 12px Arial, sans-serif; color: #9f4113;'
                                                                                                                                                                                                    ))
                                                                                       )) ?>
                    </h2>
                    <?php else : ?>
                    <h2 class="date" style="padding: 5px; font: bold 12px Arial, sans-serif;" title="<?php echo $date ?>">
                        <?php echo __('label_kup_prediction_last_modified') . ' : ' . substr($date, 0, strlen($date) - 6) ?>
                    </h2>
                    <?php endif; ?>
                <?php else : ?>
                <?php if ($sf_user->getAttribute('is_draft', '0', 'predictionsSave')
                    && $kup_uuid == $sf_user->getAttribute('kup_uuid', '', 'predictionsSave')
                ) : ?>
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
            <div style="margin: 0; padding: 0; height: 10px;"></div>
            <div id="content-predictions-rows">
                <form id="kupPredictionSave" name="kupPredictionSave" action="" method="post">
                    <?php foreach ($kupGamesData as $kupGameData): ?>
                    <?php include_component('basket', 'predictionRow',
                        array(
                             'kupGameData'   => $kupGameData,
                             'kupData'       => $kupData,
                             'sport'         => 'basket',
                             'predictions_ic'=> $predictions_ic,
                             'predictions_q' => $predictions_q,
                             'name'          => $name,
                             'isActive'      => $kupGameData['isActive']
                        ))  ?>
                    <?php endforeach ?>

                    <?php if (count($kupGamesData) > 0 && $hideButtons) : ?>
                    <?php elseif (count($kupGamesData) > 0): ?>
                    <div align="center" style="margin-top: 35px;">
                        <a href="javascript:clearPronostics();" style="text-align: right;">
                        <span class="clear-predictions">
                            <?php echo __('text_delete_predictions') ?>
                        </span>
                        </a>
                        <a href="javascript:randomPronostics();" style="text-align: left;">
                        <span class="random-predictions">
                            <?php echo __('text_random_predictions') ?>
                        </span>
                        </a>
                    </div>
                    <div align="center" style="margin-top: 35px;">
                        <input type="submit" title="<?php echo __('text_save_predictions') ?>" class="save-prediction-submit" value="<?php echo __('text_save_predictions') ?>"/>
                    </div>
                    <?php
                else: ?>
                    <div align="left" style="margin-top: 20px; width: 710px; height: 65px;">
                        <?php echo __('label_kup_predictions_none') ?>
                    </div>
                    <?php endif ?>
                </form>
            </div>
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

        $('.ic-left-radio', $('#content-predictions-rows')).checkbox({cls:'basket-ic-left-radio'});
        $('.ic-right-radio', $('#content-predictions-rows')).checkbox({cls:'basket-ic-right-radio'});

        $('.q-left-radio', $('#content-predictions-rows')).checkbox({cls:'basket-q-left-radio'});
        $('.q-right-radio', $('#content-predictions-rows')).checkbox({cls:'basket-q-right-radio'});

        $('.q2-left-radio', $('#content-predictions-rows')).checkbox({cls:'basket-q2-left-radio'});
        $('.q2-center-radio', $('#content-predictions-rows')).checkbox({cls:'basket-q2-center-radio'});
        $('.q2-right-radio', $('#content-predictions-rows')).checkbox({cls:'basket-q2-right-radio'});
    });

    function clearPronostics() {
        //Reset Input
        $("input:not(:disabled)").each(function () {
            $(this).get(0).checked = false;
            $(this).change();
        });
        $('input[value="-1"]:not(:disabled)').attr('checked', 'checked');

        // Reset the slider
        var resetValue = formatRandomSliderValue(5);
        for (var i = 0; i < $('div.basket-se-row-active').length; i++) {

            $(".slider", $('div.basket-se-row-active:eq('+i+')')).slider("value", 5);
            $('input[name^="predictions_ic"]', $('div.basket-se-row-active:eq('+i+')')).val(resetValue['sliderTeam']);
            $('input[name^="predictions_q"]', $('div.basket-se-row-active:eq('+i+')')).val(resetValue['sliderQ']);
        }
    }

    function formatRandomSliderValue(randomSlider) {

        var returnValue = [];

        if (randomSlider >= 2 && randomSlider <= 9) {
            if (randomSlider >= 2 && randomSlider <= 5) {
                returnValue['sliderTeam'] = 1;
            } else if (randomSlider >= 6 && randomSlider <= 9) {
                returnValue['sliderTeam'] = 3;
            }
            var val = 0;
            if (randomSlider == 2 || randomSlider == 9) {
                val = 30;
            } else if (randomSlider == 3 || randomSlider == 8) {
                val = 20;
            } else if (randomSlider == 4 || randomSlider == 7) {
                val = 10;
            }
            returnValue['sliderQ'] = val;
        }

        return returnValue;
    }

    function randomPronostics() {

        // Randomize the slider
        for (var i = 0; i < $('div.basket-se-row-active').length; i++) {
            var sliderTeam, sliderQ, randomSlider = Math.ceil(Math.random() * 8);

            if (randomSlider < 2) {
                randomSlider = 2;
            } else if (randomSlider > 9) {
                randomSlider = 9
            }

            $(".slider-active", $('div.basket-se-row-active:eq('+i+')')).slider("value", randomSlider);
            var randomValue = formatRandomSliderValue(randomSlider);
            sliderTeam = randomValue['sliderTeam'];
            sliderQ = randomValue['sliderQ'];

            $('div.basket-se-row-active:eq(' + i + ') table tr td input[name^="predictions_ic"]').val(sliderTeam);
            $('div.basket-se-row-active:eq(' + i + ') table tr td input[name^="predictions_q"]').val(sliderQ);
        }

        //Reset Input
        $("input:not(:disabled)").each(function () {
            $(this).get(0).checked = false;
            $(this).change();
        });

        //Set random checked radio
        for (var int = 0; int < $('div.basket-row-active').length; int++) {
            var nbInput = $('div.basket-row-active:eq(' + int + ') table tr td table tr td input[name^="predictions"]').length;
            var randomInput = Math.ceil(Math.random() * (nbInput - 1));
            if (randomInput == '0') {
                randomInput = '1';
            }
            $('div.basket-row-active:eq(' + int + ') table tr td table tr td input:eq(' + (randomInput) + ')').attr('checked', 'checked');
        }
    }
</script>
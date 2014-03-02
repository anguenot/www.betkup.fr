<?php use_stylesheet('tennis/predictions.css') ?>
<?php use_stylesheet('tennis/checkbox.css') ?>
<?php use_stylesheet('tennis/selectmenu.css') ?>
<?php use_javascript('jquery.checkbox.min.js') ?>
<?php use_javascript('jquery.urldecoder.min.js') ?>
<?php use_javascript('loading.js') ?>
<?php use_javascript('ajaxfileupload.js') ?>

<div class="prediction">
    <div class="header" align="left" style="width: 710px; height: 65px; background: url('/images/kup/view/pronostic/disquette.png');">
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
                    <?php echo __('label_kup_prediction_none') ?>
                </h2>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <div id="header-tennis">
        <div class="logo-rg"></div>
    </div>
    <div class="content-tennis">
        <form id="kupPredictionSave" name="kupPredictionSave" action="" method="post">
            <input type="hidden" value="<?php echo $kup_uuid ?>" id="kup_uuid" name="kup_uuid"/>

            <div id="content-prediction-row">
                <div id="bottom-tennis">
                    <div id="predictions-rows">
                        <?php foreach ($kupGamesData as $key => $kupGameData): ?>
                        <?php include_component('tennis', 'predictionRow',
                            array(
                                 'offset'           => $key,
                                 'kupData'          => $kupData,
                                 'sport'            => 'tennis',
                                 'kupGameData'      => $kupGameData,
                                 'predictions_ic'   => $predictions_ic,
                                 'predictions_se'   => $predictions_se,
                                 'predictions_q'    => $predictions_q,
                                 'name'             => $name,
                                 'isActive'         => $kupGameData['isActive'],
                                 'selectSmall'      => 50,
                                 'selectBig'        => 140,
                                 'predictionModule' => 'tennis'
                            )) ?>
                        <?php endforeach ?>
                        <?php if (isset($kupData['config']['tb'])): ?>
                        <?php include_component('tennis', 'predictionsTieBreaker', array('kupData'       => $kupData,
                                                                                        'predictions_tb' => $predictions_tb
                                                                                   )) ?>
                        <?php endif ?>
                    </div>
                    <div style="height:10px;"></div>
                </div>
            </div>
            <?php if (count($kupGamesData) > 0 && $kupData['status'] < 3 && $kupData['status'] != -1): ?>

            <div align="center" style="margin-top: 35px;">
                <input type="image" title="" src="/image/fr/kup/button_prediction_save.png"/>
            </div>
            <?php endif ?>
        </form>
        <div style="height:30px;"></div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".tennisSmall").selectmenu({transferClasses:true, style:'dropdown', width:'50', menuWidth:'50'});
        $(".tennisBig").selectmenu({transferClasses:true, style:'dropdown', width:'100', menuWidth:'100'});

        $('.left-radio', $('#content-prediction-row')).checkbox({cls:'tennis-radio'});
        $('.right-radio', $('#content-prediction-row')).checkbox({cls:'tennis-radio'});
    });
</script>
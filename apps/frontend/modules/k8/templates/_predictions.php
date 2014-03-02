<?php use_stylesheet('k8.css')?>
<?php use_stylesheet('jquery.checkbox.css')?>
<?php use_javascript('jquery.checkbox.min.js')?>
<?php use_javascript('jquery.urldecoder.min.js')?>
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
	<div class="content-k8">
		<form id="kupPredictionSave" name="kupPredictionSave" action=""
			method="post">
			<div id="content-prediction-row">
				<div id="header-k8" style="background: url(<?php echo isset($kupData['ui']['predictions_view_template_header']) ? $kupData['ui']['predictions_view_template_header'] : '/image/default/k8/interface/header_k8.png' ?>) no-repeat;"></div>
				<div id="bottom-k8">
					<div id="predictions-rows">
					<?php foreach ( $kupGamesData as $key => $kupGameData ): ?>
					<?php include_component('kup', 'predictionRow',
					array(
		            			'offset' => $key,	
		            			'kupGameData' => $kupGameData,
		            			'predictions_ic'=> $predictions_ic,
		            		  	'predictions_se'=> $predictions_se,
		            		  	'predictions_q'=> $predictions_q,
		            		  	'name' => $name,
		            			'isActive' => $kupGameData['isActive'],
								'isKn' => true
					)) ?>
					<?php endforeach ?>
					<?php if (isset($kupData['config']['tb'])): ?>
					<?php include_component('k8', 'predictionsTieBreaker', array('kupData' => $kupData, 'predictions_tb' => $predictions_tb)) ?>
					<?php endif ?>
					</div>
					<div style="height: 50px;"></div>
				</div>
			</div>
			<?php if (count($kupGamesData) > 0): ?>
			<div align="center" style="margin-top: 25px;">
				<a href="javascript:clearPronostics();" style="text-align: right;">
				<?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/button_erase_pronostics.png', array('style' => 'margin: 5px;', 'class' => 'button', 'size' => '173x34', 'alt' => __('label_rugby_erase_pronostics'))) ?>
				</a> <a href="javascript:randomPronostics();"
					style="text-align: left;"> <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/button_fill_randomly.png', array('style' => 'margin: 5px;', 'class' => 'button', 'size' => '173x34', 'alt' => __('label_rugby_fill_randomly'))) ?>
				</a>
			</div>
			<div align="center" style="margin-top: 35px;">
				<input type="image" title=""
					src="<?php echo '/image/' . $sf_user->getCulture() . '/k8/interface/button_prediction_k8_save.png' ?>" />
			</div>
			<?php else :?>
			<div align="left"
				style="margin-top: 20px; width: 710px; height: 65px;">
				<?php echo __('label_kup_predictions_none') ?>
			</div>
			<?php endif ?>
		</form>
	</div>
	<div id="big-pen"></div>
</div>
<script type="text/javascript">
	$(function() {
		$('.left-radio', $('#content-prediction-row')).checkbox({cls: 'left-radio'});
		$('.center-radio', $('#content-prediction-row')).checkbox({cls: 'center-radio'});
		$('.right-radio', $('#content-prediction-row')).checkbox({cls: 'right-radio'});
	});

    function clearPronostics() {
        //Reset Input
        $("input:not(:disabled)").each(function() {
            $(this).get(0).checked = false;
            $(this).change();
        });

        $('input[value="-1"]:not(:disabled)').attr('checked','checked');

        var arrayLabelByDefault = new Array;

        //Get all first select items
        for ( var int = 0; int < $('select[id^="predictions"]:not(:disabled)').length; int++) {
        	arrayLabelByDefault.push($('select[id^="predictions"]:not(:disabled)').eq(int).attr('id'));
        }

        //Set all new first select items
    	for ( var int = 0; int < arrayLabelByDefault.length; int++) {
        	var backToZero = arrayLabelByDefault[int].split(':');
    		$('select[id='+backToZero[0]+']:not(:disabled) option:selected').removeAttr('selected');
    		$('select[id='+backToZero[0]+']:not(:disabled) option:eq(0)').attr('selected','');
    		$('select[id='+backToZero[0]+']:not(:disabled)').selectmenu();
		}
    }

    function randomPronostics() {
        var arrayLabelByDefault = new Array;

        //Get random select items
        for ( var int = 0; int < $('select[id^="predictions"]:not(:disabled)').length; int++) {
            var nbOption = $('select[id^="predictions"]:not(:disabled):eq('+int+') option').length;
            var randomOption = Math.ceil(Math.random()*nbOption);
            if(randomOption == '1'){
                randomOption = '2';
            }
        	arrayLabelByDefault.push($('select[id^="predictions"]:not(:disabled)').eq(int).attr('id')+':'+(randomOption-1));
        }

        //Set all new first select items
    	for ( var int = 0; int < arrayLabelByDefault.length; int++) {
        	var randomValue = arrayLabelByDefault[int].split(':');
    		$('select[id='+randomValue[0]+']:not(:disabled) option:selected').removeAttr('selected');
    		$('select[id='+randomValue[0]+']:not(:disabled) option:eq('+randomValue[1]+')').attr('selected','');
    		if(randomValue[0].indexOf("predictions_se") != -1){
    			$('select[id='+randomValue[0]+']:not(:disabled)').selectmenu();
    		}else if(randomValue[0].indexOf("predictions_q") != -1){
    			$('select[id='+randomValue[0]+']:not(:disabled)').selectmenu();
    		}
		}

        //Reset Input
        $("input:not(:disabled)").each(function() {
            $(this).get(0).checked = false;
            $(this).change();
        });

        //Set random checked radio
    	for ( var int = 0; int < $('div.match-active').length; int++) {
            var nbInput = $('div.match-active:eq('+int+') table tr td input[name^="predictions"]').length;
            var randomInput = Math.ceil(Math.random()*(nbInput-1));
            if(randomInput == '0'){
            	randomInput = '1';
            }
            $('div.match-active:eq('+int+') table tr td input:eq('+(randomInput)+')').attr('checked','checked');
    	}
    }
</script>

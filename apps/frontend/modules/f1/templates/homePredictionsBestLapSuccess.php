<script type="text/javascript">
$(function() {
	var isOpen = false, leftSize = 0;

	var resetDriverList = function() {
		$('#rider-list').find('.rider-list-tr').css('left', '0');
	};

	var closePopup = function() {
		if(isOpen === true) {
			$('#popup-best-lap').hide();
			$('#select-right').removeClass("select-right-hover").addClass('select-right');
			$('#select-right').html('<?php echo image_tag('/image/default/f1/interface/arrow_down.png', array('size' => '15x9'))?>');
			isOpen = false;
			resetDriverList();
			leftSize = 0;
		}
	};
	var openPopup = function() {
		if(isOpen === false) {
			isOpen = true;
			$('#popup-best-lap').show();
			$('#select-right').removeClass('select-right').addClass("select-right-hover");
			$('#select-right').html('<?php echo image_tag('/image/default/f1/interface/arrow_up_hover.png', array('size' => '15x9'))?>');
		} else {
			closePopup();
		}
	};
	$('#select-right').click(openPopup);

	var nextDriver = function() {
		var predictionWidth = $('.prediction:first').width(),
			predictionHeight = $('.prediction:first').height(),
			n = $('.prediction').length,
			maxLeft = n*predictionWidth,
			minLeft = 0,
			delay = 600;

		leftSize += predictionWidth;

		if(leftSize < maxLeft) {
			$('#rider-list').find('.rider-list-tr').animate({
				'left' : '-='+predictionWidth
			}, delay, function() {});
		} else {
			$('#rider-list').find('.rider-list-tr').animate({
				'left' : '-=20'
			}, 200, function() {
				$('#rider-list').find('.rider-list-tr').animate({
					'left' : '+=20'
				}, 200, function() {});
			});
		}
		if(leftSize >= maxLeft) {
			leftSize = maxLeft-predictionWidth;
		}
	};

	var previousDriver = function() {
		var predictionWidth = $('.prediction:first').width(),
			predictionHeight = $('.prediction:first').height(),
			n = $('.prediction').length,
			maxLeft = n*predictionWidth,
			minLeft = 0,
			delay = 600;

		if(leftSize > minLeft) {
			$('#rider-list').find('.rider-list-tr').animate({
				'left' : '+='+predictionWidth
			}, delay, function() {});
		} else {
			$('#rider-list').find('.rider-list-tr').animate({
				'left' : '+=20'
			}, 200, function() {
				$('#rider-list').find('.rider-list-tr').animate({
					'left' : '-=20'
				}, 200, function() {});
			});
		}
		leftSize -= predictionWidth;
		if(leftSize < 0) {
			leftSize = minLeft;
		}
	};

	$('.nextBtn').click(nextDriver);
	$('.previousBtn').click(previousDriver);

	var savePediction = function(obj) {
		var driverId = $(obj).attr('id'),
			driverName = $(obj).parent().parent().parent().find('.driver-name').html(),
			driverTeam = $(obj).parent().parent().parent().find('.driver-team').html().split(' : '),
			driverHelmet = $(obj).parent().parent().parent().find('.helmet-picture').clone(),
			_data, tdHandler = $(obj).parent().parent().parent().parent().parent().parent().parent();

		$('#select-left > #picture-handler').html('');
		$('#select-left > #name-handler > .driver').html('');
		$('#select-left > #name-handler > .team').html('');

		driverHelmet.appendTo('#select-left > #picture-handler');
		$('#select-left > #name-handler > .driver').append(driverName);
		$('#select-left > #name-handler > .team').append(driverTeam[1]);
		$('#prediction').val(driverId);

		_data = $('#select-best-lap-form').serializeObject();
		_data['kupData'] = <?php echo json_encode($sf_data->getRaw('kupData'))?>;
		_data['kupRoundsData'] = <?php echo json_encode($sf_data->getRaw('kupRoundsData'))?>;
		_data['roomUI'] = <?php echo json_encode($sf_data->getRaw('roomUI'))?>;
		
		var xhr = $.ajax({
			url : '<?php echo url_for('f1/homePredictionsBestLap') ?>',
			data : _data,
			type : 'POST',
            dataType : 'json'
		});

		xhr.done(function(response) {

            // Unauthorized (typically user not logged in)
            if (response.cerror == '400') {
                document.location.href = response.redirect_url;
                return false;
            }

            <?php if(isset($kupData) && isset($kupData['type']) && $kupData['type'] == sfConfig::get('mod_f1_kup_type_gambling_fr')) : ?>
				<?php if(isset($kupData) && isset($kupData['room_uuid']) && $kupData['room_uuid'] != '') : ?>
					document.location.href = '<?php echo url_for(array('module' => 'room', 'action' => 'kupBet', 'kup_uuid' => $kupData['uuid'], 'room_uuid' => $kupData['room_uuid'], 'hasPreds' => 1)) ?>';
				<?php else : ?>
					document.location.href = '<?php echo url_for(array('module' => 'kup', 'action' => 'bet', 'uuid' => $kupData['uuid'], 'hasPreds' => 1)) ?>';
				<?php endif; ?>
			<?php else : ?>
				closePopup();
				if($('#selected-driver-component').html().length > 0) {
					tdHandler.parent().append('<td class="prediction">'+$('#selected-driver-component').html()+'</td>');
				}
				$('#selected-driver-component').html(tdHandler.html());
				tdHandler.remove();
			<?php endif; ?>
			
			var notice = 'error',
				data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?><?php echo str_replace("'", "\'", __('flash_notice_kup_predictions_saved_failed')) ?></div>';

			if(response.cerror == '202') {
				data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_success.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?><?php echo str_replace("'", "\'",__('flash_notice_kup_predictions_saved_success')) ?></div>';
				notice = 'notice';
			}
	        showNotification(data, notice, function(){});
	        publishFacebook(response.messagePublish, response.predictionFacebook);
		});

		return false;
	};

	$('.btn-save').click(function() {
		savePediction($(this));
	});


	this._close = function() {
		closePopup();
	};

	$('.btn-cancel').click(function() {
		closePopup();
	});
});

function publishFacebook(msg, propertiesPublish) {
	
	FB.ui({ method: 'feed', 
        	link: "<?php echo $urlToPublish ?>",
        	properties: html_entity_decode(JSON.stringify(propertiesPublish)),
        	picture: 'https://www.betkup.fr<?php echo $kupData['ui']['vignette_edition_kup'] ?>',
        	description: htmlentities(msg)
    });
    
    return false;
}
</script>
<div id="best-lap-contener">
	<div id="last-prediction">
        <div style="text-indent: 0;">
            <?php if ($lastModified != NULL): ?>
            <?php $date = util::displayDateCompleteFromTimestampComplet($lastModified); ?>
            <?php if($sf_user->getAttribute('best_lap_is_draft', '0', 'predictionsSave') &&
                     $kup_uuid == $sf_user->getAttribute('kup_uuid', '', 'predictionsSave')) : ?>
                <h2 style="color: #E65E1B; padding: 5px; background: rgba(255, 195, 112, 0.6); font: bold 11px Arial, sans-serif;">
                    <?php echo __('text_predictions_draft_with_last_modification', array(
                                                                                        '%br%' => '<br />',
                                                                                        '%span%' => '<span style="font: normal 11px Arial, sans-serif;">',
                                                                                        '%/span%' => '</span>',
                                                                                        '%link_date%' => link_to(substr($date, 0, strlen($date) - 7), url_for(array('module' => 'kup',
                                                                                                                                                                   'action' => 'view',
                                                                                                                                                                   'uuid' => $kup_uuid)).'?empty_draft=1',
                                                                                            array(
                                                                                                 'class' => 'draft-pronos',
                                                                                                 'style' => 'font: bold 11px Arial, sans-serif; color: #9f4113;'
                                                                                            ))
                                                                                   )) ?>
                </h2>
                <?php else : ?>
                <h2 class="date" style="padding: 5px; font: bold 11px Arial, sans-serif;" title="<?php echo $date ?>">
                    <?php echo __('label_kup_prediction_last_modified') . ' : ' . substr($date, 0, strlen($date) - 7) ?>
                </h2>
                <?php endif; ?>
            <?php else : ?>
            <?php if($sf_user->getAttribute('best_lap_is_draft', '0', 'predictionsSave') &&
                     $kup_uuid == $sf_user->getAttribute('kup_uuid', '', 'predictionsSave')) : ?>
                <h2 style="color: #E65E1B; padding: 5px; background: rgba(255, 195, 112, 0.6); font: bold 11px Arial, sans-serif;">
                    <?php echo __('text_predictions_draft_simple') ?>
                </h2>
                <?php else : ?>
                <h2 style="padding: 5px; font: bold 11px Arial, sans-serif;">
                    <?php echo __('label_kup_prediction_none') ?>
                </h2>
                <?php endif; ?>
            <?php endif; ?>
        </div>
	</div>
	<div id="select-prediction">
		<div id="select-left">
			<div id="selected-driver-component">
				<?php (isset($predictions) && count($predictions) > 0) ? include_component('f1', 'bestLapPopupDriver', array('driver' => $predictions, 'uuid' => $kup_uuid)) : ''?>
			</div>
			<div id="picture-handler">
				<?php echo (isset($predictions['helmet'])) ? image_tag($predictions['helmet'], array('class' => 'helmet-picture', 'width' => '40')) : image_tag('/image/default/f1/interface/default_helmet.png', array('class' => 'helmet-picture', 'width' => '40'));?>
			</div>
			<div id="name-handler">
				<div class="driver">
					<b>
						<?php echo (isset($predictions['driver'])) ? $predictions['driver'] : 'Choisir un pilote';?>
					</b>
				</div>
				<div class="team">
					<?php echo (isset($predictions['team'])) ? $predictions['team'] : '';?>
				</div>
			</div>
			<form id="select-best-lap-form" method="post">
                <input id="kup_uuid" type="hidden" value="<?php echo $kup_uuid;?>" name="kup_uuid" />
				<input id="prediction" type="hidden" value="<?php echo (isset($predictions['uuid'])) ? $predictions['uuid'] : '';?>" name="prediction" />
			</form>
		</div>
		<a href="javascript:void(0);" id="select-right" class="select-right">
			<?php echo image_tag('/image/default/f1/interface/arrow_down.png', array('size' => '15x9'))?>
		</a>
	</div>
	<div id="buttons">
	</div>

	<div id="popup-best-lap">
		<table>
			<tbody>
				<tr>
					<td style="width: 10px;"></td>
					<td>
						<div class="div-btn">
							<a href="javascript:void(0);" class="popup-button">
								<?php echo image_tag('/image/default/f1/interface/previous_btn_popup.png', array('class' => 'previousBtn', 'size' => '26x25')); ?>
							</a>
						</div>
					</td>
					<td>
						<div id="popup-best-lap-contener">
							<table id="rider-list">
							<thead></thead>
							<tbody>
							<tr class="rider-list-tr">
							<?php foreach($drivers as $driver) :?>
								<td class="prediction">
								<?php include_component('f1', 'bestLapPopupDriver', array('driver' => $driver, 'uuid' => $kup_uuid, 'canSavePredictionsRace' => $canSavePredictionsRace))?>
								</td>
							<?php endforeach;?>
							</tr>
							</tbody>
							</table>
						</div>
					</td>
					<td>
						<div class="div-btn">
							<a href="javascript:void(0);" class="popup-button">
								<?php echo image_tag('/image/default/f1/interface/next_btn_popup.png', array('class' => 'nextBtn','size' => '26x25')); ?>
							</a>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
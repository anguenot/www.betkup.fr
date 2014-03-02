<div id="f1-grid-title"><?php echo (isset($kupData)) && isset($kupData['title']) ? $kupData['title'] : ''; ?></div>
<div id="f1-grid-description"><?php echo (isset($kupData)) && isset($kupData['description']) ? $kupData['description'] : ''; ?></div>
<div id="f1-grid-contener">
	<table class="default-f1-table">
		<thead>
			<tr>
				<th width="420">Placez les pilotes sur la ligne d’arrivée</th>
				<th width="30"></th>
				<th colspan="2" width="260">Votre pronostic</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="td-left">
					<ul id="f1-prediction-choices">
					<?php foreach($drivers as $key => $driver) :?>
						<li id="<?php echo $driver['uuid']; ?>" class="f1-widget-choice">
							<div class="cursors">
								<?php echo image_tag('/image/default/f1/interface/handle_cursor.png', array('size' => '14x14'))?>
							</div>
							<div class="div-top">
								<div class="car"><?php echo (isset($driver['car'])) ? image_tag($driver['car'], array('size' => '100x28')) : '';?></div>
							</div>
							<div class="div-bottom">
								<div class="info-grid" title="<?php echo $driver['driver'];?>"><b><?php echo (isset($driver['driver'])) ? Util::coupe($driver['driver'], 14, '..') : ''?></b></div>
								<div class="info-grid" title="<?php echo $driver['team'];?>"><?php echo (isset($driver['team'])) ? Util::coupe($driver['team'], 18, '..') : ''?></div>
							</div>
						</li>
					<?php endforeach;?>
					</ul>
				</td>
				<td>
				<?php for($i=1; $i <= $maxDisplay; $i++) :?>
					<div class="podium-number"><?php echo $i; ?><sup>e</sup></div>
				<?php endfor;?>
				</td>
				<td>
				<form id="f1-prediction-form">
					<div id="f1-prediction-list">
						<?php for($i=1; $i <= $maxDisplay; $i++) :?>
							<div id="podium-<?php echo $i;?>" class="f1-widget">
								<?php if(isset($predictions[$i-1]) && isset($predictions[$i-1]['team']) &&
										isset($predictions[$i-1]['uuid']) && isset($predictions[$i-1]['driver']) &&
										isset($predictions[$i-1]['car'])) :?>
									<input type="hidden" value="<?php echo $predictions[$i-1]['uuid']; ?>" name="predictions[podium_<?php echo $i; ?>]" />
									<li id="<?php echo $predictions[$i-1]['uuid']; ?>" class="f1-widget-choice" style="margin:0px;">
										<div class="cursors">
											<a href="javascript:void(0);" onclick="cancelChoice(this)">
												<?php echo image_tag('/image/default/f1/interface/handle_close.png', array('size' => '12x12'))?>
											</a>
										</div>
										<div class="div-top">
											<div class="car"><?php echo (isset($predictions[$i-1]['car'])) ? image_tag($predictions[$i-1]['car'], array('size' => '100x28')) : '';?></div>
										</div>
										<div class="div-bottom">
											<div class="info-grid" title="<?php echo $predictions[$i-1]['driver']?>"><b><?php echo (isset($predictions[$i-1]['driver'])) ? Util::coupe($predictions[$i-1]['driver'], 14, '..') : ''?></b></div>
											<div class="info-grid" title="<?php echo $predictions[$i-1]['team']?>"><?php echo (isset($predictions[$i-1]['team'])) ? Util::coupe($predictions[$i-1]['team'], 18, '..') : ''?></div>
										</div>
									</li>
								<?php else :?>
								<input type="hidden" value="" name="predictions[podium_<?php echo $i; ?>]" />
								<?php endif;?>
							</div>
						<?php endfor;?>
					</div>
					<input id="kup_uuid" type="hidden" value="<?php echo $kup_uuid;?>" name="kup_uuid" />
				</form>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script type="text/javascript">
$(function() {
	$('#f1-prediction-choices').parent().scrollbar();

	$('.f1-widget', $('#f1-prediction-list')).droppable({
		activeClass: "f1-widget-active",
		accept: 'li.f1-widget-choice',
		drop: function( event, ui ) {
			moveChoice(ui.draggable, $(this));
		}
	});

	$('#f1-prediction-choices').droppable({
		activeClass: "f1-choice-active",
		accept: '#f1-prediction-list li.f1-widget-choice',
		drop: function( event, ui ) {
			moveChoice( ui.draggable, $(this));
		}
	});

	$('.f1-widget-choice').draggable({
		revert: 'invalid',
		containment: '#f1-ranking-contener',
		helper: "clone",
		cursor: "move",
		start : function() {
        	$(this).fadeTo(0, '1');
        },
        drag : function() {
        	$(this).fadeTo(0, '0.4');
        },
        stop : function() {
        	$(this).fadeTo(0, '1');
        }
	});
});

function savePredictions() {
	var _data = $('#f1-prediction-form').serializeObject();
	_data['kupData'] = <?php echo json_encode($sf_data->getRaw('kupData'))?>;
	_data['kupRoundsData'] = <?php echo json_encode($sf_data->getRaw('kupRoundsData'))?>;
	_data['roomUI'] = <?php echo json_encode($sf_data->getRaw('roomUI'))?>;

	var xhr = $.ajax({
		url : '<?php echo url_for('f1/predictionsGrid') ?>',
		data : _data,
		type : 'POST',
	    dataType : 'json'
	});

	xhr.done(function(response) {

        // Unauthorized (typically user not logged in)
        if (response.cerror == '400') {
            document.location.href = response.redirect_url;
            return;
        }

        var notice = 'error',
	 	data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?><?php echo str_replace("'", "\'", __('flash_notice_kup_predictions_saved_failed')) ?></div>';

		if(response.cerror == '202') {
			data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_success.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?><?php echo str_replace("'", "\'",__('flash_notice_kup_predictions_saved_success')) ?></div>';
			notice = 'notice';
		}
	    showNotification(data, notice, function(){});
 
		<?php if(isset($kupData) && isset($kupData['type']) && $kupData['type'] == sfConfig::get('mod_f1_kup_type_gambling_fr')) : ?>
			<?php if(isset($kupData) && isset($kupData['roomUUID']) && $kupData['roomUUID'] != '' && $kupData['roomUUID'] != '740') : ?>
				document.location.href = '<?php echo url_for(array('module' => 'room', 'action' => 'kupBet', 'kup_uuid' => $kupData['uuid'], 'room_uuid' => $kupData['roomUUID'], 'hasPreds' => 1)) ?>';
			<?php else : ?>
				document.location.href = '<?php echo url_for(array('module' => 'kup', 'action' => 'bet', 'uuid' => $kupData['uuid'], 'hasPreds' => 1)) ?>';
			<?php endif; ?>
		<?php else : ?>
			revertDiv('f1-grid-left', function() {
				publishFacebook(response.messagePublish, response.predictionFacebook);
			});
		<?php endif; ?>
	});

	return false;
}

function replaceChoice(item, contener) {
	if(item.parent().attr('id') == 'f1-prediction-choices') {
		contener.find('li').css('margin-left', '10px').css('margin-bottom', '5px').css('float', 'left');
		contener.find('li').appendTo(item.parent());
	} else {
		item.parent().find('input[type=hidden]').val(contener.find('li').attr('id'));
		contener.find('li').appendTo(item.parent());
	}


	fitToContener(item, contener);
}

function moveChoice(item, contener) {

	if(contener.attr('id') == 'f1-prediction-choices') {
		item.parent().find('input[type=hidden]').val('');
		item.find('.cursors').html('<?php echo image_tag('/image/default/f1/interface/handle_cursor.png', array('size' => '14x14'))?>');
		item.css('margin-left', '10px').css('margin-bottom', '5px').css('float', 'left').appendTo(contener);
	} else if(contener.length && contener.parent().attr('id') == 'f1-prediction-list') {
		replaceChoice(item, contener);
	} else {
		fitToContener(item, contener);
	}
}

function fitToContener(item, contener) {
	item.css('margin', '0px').appendTo(contener);
	item.parent().find('input[type=hidden]').val(item.attr('id'));

	var cursorCloseLink = '<a href="javascript:void(0);" onclick="cancelChoice(this)"><?php echo image_tag('/image/default/f1/interface/handle_close.png', array('size' => '12x12'))?></a>';
	item.find('.cursors').html(cursorCloseLink);
}

function cancelChoice(obj) {
	var item = $(obj).parent().parent(),
		contener = $('#f1-prediction-choices');

	item.parent().find('input[type=hidden]').val('');
	item.find('.cursors').html('<?php echo image_tag('/image/default/f1/interface/handle_cursor.png', array('size' => '14x14'))?>');
	item.css('margin-left', '10px').css('margin-bottom', '5px').css('float', 'left').appendTo(contener);
}

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
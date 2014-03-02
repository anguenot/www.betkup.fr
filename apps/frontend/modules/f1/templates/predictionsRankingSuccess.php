<script type="text/javascript">
$(function() {

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
		url : '<?php echo url_for('f1/predictionsRanking') ?>',
		data : _data,
		type : 'POST',
        dataType: 'json'
	});

	xhr.done(function(response) {

		 // Unauthorized (typically user not logged in)
        if (response.cerror == '400') {
            document.location.href = response.redirect_url;
            return;
        }
        
        <?php if(isset($kupData) && isset($kupData['type']) && $kupData['type'] == sfConfig::get('mod_f1_kup_type_gambling_fr')) : ?>
	        <?php if(isset($kupData) && isset($kupData['room_uuid']) && $kupData['room_uuid'] != '') : ?>
				document.location.href = '<?php echo url_for(array('module' => 'room', 'action' => 'kupBet', 'kup_uuid' => $kupData['uuid'], 'room_uuid' => $kupData['room_uuid'], 'hasPreds' => 1)) ?>';
			<?php else : ?>
				document.location.href = '<?php echo url_for(array('module' => 'kup', 'action' => 'bet', 'uuid' => $kupData['uuid'], 'hasPreds' => 1)) ?>';
			<?php endif; ?>
		<?php else : ?>
			revertDiv('f1-ranking-right', function() {
				publishFacebook(response.messagePublish, response.predictionFacebook);
			});
		<?php endif; ?>

		var notice = 'error',
			data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?><?php echo str_replace("'", "\'", __('flash_notice_kup_predictions_saved_failed')) ?></div>';

		if(response.cerror == '202') {
			data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_success.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?><?php echo str_replace("'", "\'",__('flash_notice_kup_predictions_saved_success')) ?></div>';
			notice = 'notice';
		}
		
        showNotification(data, notice, function(){});
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
<div id="f1-ranking-title"><?php echo (isset($kupData)) && isset($kupData['title']) ? $kupData['title'] : ''; ?></div>
<div id="f1-ranking-description"><?php echo (isset($kupData)) && isset($kupData['description']) ? $kupData['description'] : ''; ?></div>
<div id="f1-ranking-contener">
	<table>
		<thead>
			<tr>
				<th width="440">Placez les pilotes sur la ligne d’arrivée</th>
				<th width="35"></th>
				<th width="225">Votre pronostic</th>
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
						<div class="helmet-picture">
							<?php echo image_tag($driver['helmet'], array('height' => '30px')); ?>
						</div>
						<div class="infos-driver">
							<div title="<?php echo $driver['driver'];?>"><b><?php echo Util::coupe($driver['driver'], 13, '..')?></b></div>
							<div title="<?php echo $driver['team'];?>"><?php echo Util::coupe($driver['team'], 13, '..')?></div>
						</div>
					</li>
				<?php endforeach;?>
				</ul>
				</td>
				<td>
				<?php for($i=1; $i < 11; $i++) :?>
					<div class="podium-number"><?php echo $i; ?><sup>e</sup></div>
				<?php endfor;?>
				</td>
				<td>
				<form id="f1-prediction-form">
					<div id="f1-prediction-list">
						<?php for($i=1; $i < 11; $i++) :?>
							<div id="podium-<?php echo $i;?>" class="f1-widget">
								<?php if(isset($predictions[$i-1]) && isset($predictions[$i-1]['team']) &&
										isset($predictions[$i-1]['uuid']) && isset($predictions[$i-1]['driver']) &&
										isset($predictions[$i-1]['helmet'])) :?>
									<input type="hidden" value="<?php echo $predictions[$i-1]['uuid']; ?>" name="predictions[podium_<?php echo $i; ?>]" />
									<li id="<?php echo $predictions[$i-1]['uuid']; ?>" class="f1-widget-choice" style="margin:0px;">
										<div class="cursors">
											<a href="javascript:void(0);" onclick="cancelChoice(this)">
												<?php echo image_tag('/image/default/f1/interface/handle_close.png', array('size' => '12x12'))?>
											</a>
										</div>
										<div class="helmet-picture">
											<?php echo image_tag($predictions[$i-1]['helmet'], array('height' => '30px')); ?>
										</div>
										<div class="infos-driver">
											<div title="<?php echo $predictions[$i-1]['driver'];?>"><b><?php echo Util::coupe($predictions[$i-1]['driver'], 13, '..')?></b></div>
											<div title="<?php echo $predictions[$i-1]['team'];?>"><?php echo Util::coupe($predictions[$i-1]['team'], 13, '..')?></div>
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

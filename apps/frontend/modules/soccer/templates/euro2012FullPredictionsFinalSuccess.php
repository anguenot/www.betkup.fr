<form id="euro-final-form" method="post" action="">
	<table id="euro-prediction-final-table">
		<thead>
			<tr>
				<th class="full-predictions-title">
					<h1>1/4 Finale</h1>
				</th>
				<th class="full-predictions-title">
					<h1>1/2 Finale</h1>
				</th>
				<th class="full-predictions-title">
					<h1>Finale</h1>
				</th>
				<th class="full-predictions-title">
					<h1>Vainqueur</h1>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<?php for($j=0; $j<4; $j++) :?>
				<td>
				<?php if($j==0) :?>
				<?php $k=0; $i=0; foreach($candidates as $round => $datas): ?>
					<div class="cell-quarter-container">
						<?php foreach($datas as $key => $team) :?>
						<div class="euro-final-team team-<?php echo $key?>">
							<?php if(count($team) == 1) :?>
							<?php foreach($team[0] as $teamId => $teamData) :?>
							<table class="euro-quarter-final-cell-table">
								<tbody>
									<tr>
										<td class="team-name">
											<h2 title="<?php echo $teamData['name']?>">
												<?php echo Util::coupe($teamData['name'], 12, '..') ?>
											</h2>
										</td>
										<td class="team-avatar"><?php echo image_tag($teamData['avatar'], array('size' => '23x15'))?>
										</td>
										<td class="team-input">
											<input id="<?php echo $teamData['uuid']?>"
											type="hidden" value="<?php echo $teamData['uuid']?>"
											name="predictions_full[round][<?php echo $k ?>]"> <?php $k++; ?>
											<input id="<?php echo $teamData['uuid'] ?>" type="radio"
											<?php if (isset($predictions_full) && (
														(isset($predictions_full[8]) && $predictions_full[8]['uuid'] == $teamData['uuid']) || 
														(isset($predictions_full[9]) &&$predictions_full[9]['uuid'] == $teamData['uuid']) ||
														(isset($predictions_full[10]) &&$predictions_full[10]['uuid'] == $teamData['uuid']) ||
														(isset($predictions_full[11]) &&$predictions_full[11]['uuid'] == $teamData['uuid']))) :?>
											 checked="checked"
											<?php endif;?>
											<?php echo (isset($kupData['status']) && $kupData['status'] != 1) ? ' disabled="disabled" ': ''?>
											class="radio radio_<?php echo $i?>"
											value="<?php echo $teamData['uuid'] ?>"
											name="predictions_full[quarter_final][<?php echo $round ?>]">
										</td>
									</tr>
								</tbody>
							</table>
							<?php endforeach;?>
							<?php elseif(count($team) > 1) :?>
							<table class="euro-quarter-final-cell-table">
								<tbody>
									<tr>
										<td class="team-select" colspan="2">
											<?php foreach($team as $teamId => $teams) :?>
												<?php foreach ($teams as $teamData):?>
													 <input type="hidden" class="<?php echo $teamData['uuid'] ?> name" value="<?php echo $teamData['name']?>">
													 <input type="hidden" class="<?php echo $teamData['uuid'] ?> avatar" value="<?php echo $teamData['avatar']?>">
													 <input type="hidden" class="<?php echo $teamData['uuid'] ?> uuid" value="<?php echo $teamData['uuid']?>">
												<?php endforeach;?>
											<?php endforeach;?>
										 	<?php $a=1; foreach($team as $teamId => $teams) :?>
										 	<?php foreach($teams as $teamData): ?>
											<?php if($a==1) :?>
											 		<input type="hidden" value="<?php echo $teamData['uuid']?>"
															name="predictions_full[round][<?php echo $k ?>]" /><?php $k++?>
											 	<select class="euro-select" <?php echo (isset($kupData['status']) && $kupData['status'] != 1) ? ' disabled="disabled" ': ''?>>
											<?php endif;?>
													<option title="<?php echo $teamData['name'] ?>"
														<?php echo (isset($predictions_full['quarter_final'][$round]) && $predictions_full['quarter_final'][$round] == $teamData['uuid']) ? 'selected="selected"' : ''?>
														value="<?php echo $teamData['uuid']?>">
														<?php echo Util::coupe($teamData['name'], 12, '..')?>
													</option>
											<?php if($a == count($team)) :?>
												</select>
										</td>
										<td class="team-input">
											<input id="<?php echo $teamData['uuid'] ?>"
											<?php if (isset($predictions_full) && (
														(isset($predictions_full[8]) && $predictions_full[8]['uuid'] == $teamData['uuid']) || 
														(isset($predictions_full[9]) && $predictions_full[9]['uuid'] == $teamData['uuid']) ||
														(isset($predictions_full[10]) && $predictions_full[10]['uuid'] == $teamData['uuid']) ||
														(isset($predictions_full[11]) && $predictions_full[11]['uuid'] == $teamData['uuid']))) :?>
											 checked="checked"
											<?php endif;?>
											<?php echo (isset($kupData['status']) && $kupData['status'] != 1) ? ' disabled="disabled" ': ''?>
											type="radio" class="radio radio_<?php echo $i?>"
											value="<?php echo $teamData['uuid'] ?>"
											name="predictions_full[quarter_final][<?php echo $round ?>]">
										</td>
										<?php endif;?> 
										<?php endforeach;?>
										<?php $a++; endforeach;?>
									</tr>
								</tbody>
							</table>
							<?php endif;?>
						</div>
						<?php endforeach;?>
					</div> 
					<?php $i++; endforeach;?> 
					<?php elseif($j==1) :?> 
					<?php for($i=0; $i<4; $i++) :?>
					<div class="euro-half-container">
						<div id="euro_half_<?php echo $i?>"
							class="euro-final-team team-<?php echo ($i%2==1) ? 'second' : 'first'?>">
							<?php if (isset($predictions_full[8 + $i]) && isset($predictions_full[8 + $i]['uuid'])): ?>
							<table class="euro-quarter-final-cell-table">
								<tbody>
									<tr>
										<td class="team-name">
											<h2 title="<?php echo $predictions_full[8 + $i]['name']?>">
												<?php echo Util::coupe($predictions_full[8 + $i]['name'], 12, '..') ?>
											</h2>
										</td>
										<td class="team-avatar"><?php echo image_tag($predictions_full[8 + $i]['avatar'], array('size' => '23x15'))?>
										</td>
										<td class="team-input">
										<input
											id="<?php echo $predictions_full[8 + $i]['uuid'] ?>"
											<?php echo ($predictions_full[12]['uuid'] == $predictions_full[8 + $i]['uuid'] || 
														$predictions_full[13]['uuid'] == $predictions_full[8 + $i]['uuid']) ? 'checked="checked"' : ''?>
											type="radio" class="radio radio_<?php echo ($i<2) ? '4' : '5' ?>"
											value="<?php echo $predictions_full[8 + $i]['uuid'] ?>"
											<?php echo (isset($kupData['status']) && $kupData['status'] != 1) ? ' disabled="disabled" ': ''?>
											name="predictions_full[half_final][<?php echo ($i<2) ? '0' : '1'?>]">
										</td>
									</tr>
								</tbody>
							</table>
							<?php endif ?>
						</div>
					</div> 
					<?php endfor;?> 
					<?php elseif($j==2) :?> 
					<?php for($i=0; $i<2; $i++) :?>
					<div class="euro-final-container">
						<div id="euro_final_<?php echo $i?>"
							class="euro-final-team team-<?php echo ($i%2==1) ? 'second' : 'first'?>">
							<?php if (isset($predictions_full[12 + $i]) && isset($predictions_full[12 + $i]['uuid'])): ?>
							<table class="euro-quarter-final-cell-table">
								<tbody>
									<tr>
										<td class="team-name">
											<h2 title="<?php echo $predictions_full[12 + $i]['name']?>">
												<?php echo Util::coupe($predictions_full[12 + $i]['name'], 12, '..') ?>
											</h2>
										</td>
										<td class="team-avatar"><?php echo image_tag($predictions_full[12 + $i]['avatar'], array('size' => '23x15'))?>
										</td>
										<td class="team-input">
										<input
											id="<?php echo $predictions_full[12 + $i]['uuid'] ?>"
											<?php echo ($predictions_full[12 + $i]['uuid'] == $predictions_full[14]['uuid']) ? 'checked="checked"' : ''?>
											type="radio" class="radio radio_6"
											value="<?php echo $predictions_full[12 + $i]['uuid'] ?>"
											<?php echo (isset($kupData['status']) && $kupData['status'] != 1) ? ' disabled="disabled" ': ''?>
											name="predictions_full[final]">
										</td>
									</tr>
								</tbody>
							</table>
							<?php endif ?>
						</div>
					</div> <?php endfor;?> <?php elseif($j==3) :?>
					<div id="euro_winner" class="euro-final-team team-first">
						<?php if (isset($predictions_full[14]) && isset($predictions_full[14]['uuid'])): ?>
						<table class="euro-quarter-final-cell-table">
							<tbody>
								<tr>
									<td class="team-name">
										<h2 title="<?php echo $predictions_full[14]['name']?>">
											<?php echo Util::coupe($predictions_full[14]['name'], 12, '..') ?>
										</h2>
									</td>
									<td class="team-avatar"><?php echo image_tag($predictions_full[14]['avatar'], array('size' => '23x15'))?>
									</td>
									<td class="team-input">
									<input
										id="<?php echo $predictions_full[14]['uuid'] ?>" 
										type="radio"
										checked="checked"
										class="radio radio_7"
										<?php echo (isset($kupData['status']) && $kupData['status'] != 1) ? ' disabled="disabled" ': ''?>
										value="<?php echo $predictions_full[14]['uuid'] ?>"
										name="predictions_full[winner]">
								</tr>
							</tbody>
						</table>
						<?php endif ?>
					</div> <?php endif;?></td>
				<?php endfor;?>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tfoot>
	</table>
	<div align="center" style="margin-top: 35px;">
		<?php if(isset($kupData['status']) && $kupData['status'] == 1) :?>
		<input type="hidden" value="<?php echo $kup_uuid?>" name="kup_uuid"> <input
			type="image" title=""
			src="<?php echo '/image/' . $sf_user->getCulture() . '/kup/button_prediction_save.png' ?>" />
		<?php endif; ?>
	</div>
</form>
<div>
<table id="results-full-pronos">
	<thead>
		<tr>
			<th colspan="4">Resultats :</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?php echo $quarterPoints ?> points
			</td>
			<td>
				<?php echo $halfPoints ?> points
			</td>
			<td>
				<?php echo $finalPoints ?> points
			</td>
			<td>
				<?php echo $winnerPoints ?> points
			</td>
			
		</tr>
	</tbody>
</table>
</div>

<script type="text/javascript">
$('.radio').checkbox({cls: 'radio-final'});
$('.euro-select').selectmenu({style:'dropdown', width: 120, menuWidth: '120'});
$(function() {
	$('.radio').live('change', function() {
		changeRadio($(this));
	});

	$('.euro-select').live('change', function() {
		var radio = $(this).parent().parent().find('.radio');
		radio.trigger('change');
		radio.attr("checked",true);
	});
	
	$('#euro-final-form').submit(function() {
		var datas = $(this).serializeObject();
		$.ajax({
			url : '<?php echo url_for(array('module' => 'soccer', 'action' => 'isUserConnected'))?>',
			success : function(response) {
				if(response == 'true') {
					$(this).ajaxSubmit({
						url: '<?php echo url_for(array('module' => 'soccer', 'action' => 'euro2012FullPredictionsFinalSave')) ?>',
						type: 'post',
						dataType : 'json',
						data: datas,
						beforeSubmit: function() {
							$('#euro-prediction-final-table').loadingModal();
						},
						success: function(pDatas) {
							$('#euro-prediction-final-table').loadingModal({'show' : false});
							// Unauthorized (typically user not logged in)
					        if (pDatas.cerror == '400') {
					            document.location.href = pDatas.redirect_url;
					            return false;
					        }
							var notice = 'error',
						 		data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?><?php echo str_replace("'", "\'", __('flash_notice_kup_predictions_saved_failed')) ?></div>';

							if(pDatas.cerror == '202') {
								data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_success.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?><?php echo str_replace("'", "\'",__('flash_notice_kup_predictions_saved_success')) ?></div>';
								notice = 'notice';
							}
					    	showNotification(data, notice, function(){});
						}
					}); 
				} else {
					document.location.href = '<?php echo url_for(array('module' => 'account', 'action' => 'login', 'customRedirectUrl' => url_for(array('module' => 'kup', 'action' => 'view', 'uuid' => $kup_uuid)) )) ?>';
					return false;
				}
			}
		});
		return false;
	});

	
});

function changeRadio(obj) {
	
	var table, select, radio, teamUUID;

	table = obj.parent().parent().parent().parent().clone();
	select = obj.parent().parent().find('.euro-select');
	
	if(typeof(select) != 'undefined' && select.length > 0) {
		var teamId, tdName, tdAvatar, titleName, imageAvatar, nameValue, nameValueTitle, avatarValue;
	
		teamId = select.val();

		//Update the value of the input to match the teamID 
		obj.val(teamId);
		
		$('.'+teamId).each(function() {
			if($(this).hasClass('name')) {
				nameValue = coupe($(this).val(), 12, '..');
				nameValueTitle = $(this).val();
			}
			if($(this).hasClass('avatar')) {
				avatarValue = $(this).val();
			}
		});

		tdName = $(document.createElement('td')).addClass('team-name');
		titleName = $(document.createElement('h2')).attr('title', nameValueTitle).html(nameValue);
		titleName.appendTo(tdName);
		tdAvatar = $(document.createElement('td')).addClass('team-avatar');
		imageAvatar = $(document.createElement('img')).attr({
			'src' : avatarValue,
			'width' : 23,
			'height' : 15
		});
		imageAvatar.appendTo(tdAvatar);

		tdAvatar.prependTo(table.find('.team-select').parent());
		tdName.prependTo(table.find('.team-select').parent());
		table.find('.team-select').remove();
	}

	if(obj.hasClass('radio_0')) {
		var teamUUID = obj.val();
		radio = $(document.createElement('input')).attr({'type' : 'radio', 'value' : teamUUID,  'name' : 'predictions_full[half_final][0]'})
			.attr('checked', false).addClass('radio radio_4');
		table.find('.team-input').html(radio);
		$('#euro_half_0').html(table);
		
	} else if(obj.hasClass('radio_1')) {
		var teamUUID = obj.val();
		radio = $(document.createElement('input')).attr({'type' : 'radio', 'value' : teamUUID, 'name' : 'predictions_full[half_final][1]'})
			.attr('checked', false).addClass('radio radio_5');
		table.find('.team-input').html(radio);
		$('#euro_half_2').html(table);
		
	} else if(obj.hasClass('radio_2')) {
		var teamUUID = obj.val();
		radio = $(document.createElement('input')).attr({'type' : 'radio', 'value' : teamUUID, 'name' : 'predictions_full[half_final][0]'})
			.attr('checked', false).addClass('radio radio_4');
		table.find('.team-input').html(radio);
	
		$('#euro_half_1').html(table);
		
	} else if(obj.hasClass('radio_3')) {
		var teamUUID = obj.val();
		radio = $(document.createElement('input')).attr({'type' : 'radio', 'value' : teamUUID, 'name' : 'predictions_full[half_final][1]'})
			.attr('checked', false).addClass('radio radio_5');
		table.find('.team-input').html(radio);
		
		$('#euro_half_3').html(table);
		
	} else if(obj.hasClass('radio_4')) {
		var teamUUID = obj.val();
		radio = $(document.createElement('input')).attr({'type' : 'radio', 'value' : teamUUID, 'name' : 'predictions_full[final]'})
			.attr('checked', false).addClass('radio radio_6');
		table.find('.team-input').html(radio);
		
		$('#euro_final_0').html(table);
		
	} else if(obj.hasClass('radio_5')) {
		var teamUUID = obj.val();
		radio = $(document.createElement('input')).attr({'type' : 'radio', 'value' : teamUUID, 'name' : 'predictions_full[final]'})
			.attr('checked', false).addClass('radio radio_6');
		table.find('.team-input').html(radio);
		
		$('#euro_final_1').html(table);
		
	} else if(obj.hasClass('radio_6')) {
		teamUUID = obj.val();
		radio = $(document.createElement('input')).attr({'type' : 'radio', 'value' : teamUUID, 'name' : 'predictions_full[winner]'})
		.attr('checked', true).addClass('radio radio_7');
		table.find('.team-input').html(radio);
		$('#euro_winner').html(table);
	}
	$('.radio').checkbox({cls: 'radio-final'});
}

function coupe(string, length, escaper) {
	var newString;
	if(string.length > length) {
		newString = string.substr(0, length);
		newString = newString+escaper;
		return newString;
	} else {
		return string;
	}
}
</script>

<script type="text/javascript">
$(function() {
	$('#form_invite_email_send').submit(function() {

		var mailBody = $('#form_invite_email_message_body').val();
		
		$.ajax({
			url:'<?php echo url_for(array('module'=>'invite', 'action'=>'sendMail')) ?>',
			type:'post',
			dataType:'html',
			data: {"mailBody": mailBody, "room_uuid": "<?php echo $room_uuid; ?>", "kup_uuid" : "<?php echo $kup_uuid; ?>"},
			success:function(message, textStatus) {
				var flashDiv = '', flashType;

				if(message == '202') {
					flashDiv = '<div style=\"vertical-align: middle; padding: 10px;\"><?php echo image_tag('/images/interface/ticker_success.png', array('size' => '15x15', 'style'=>'padding-right:10px;')); echo str_replace("'", "\'", __('flash_notice_invites_sent_sucess')); ?>.</div>';	        
					flashType = 'success';
				} else if(message == 'error') {
					flashDiv = '<div style="vertical-align: middle; padding: 10px;\"><?php echo image_tag('/images/interface/ticker_error.png', array('size' => '15x15', 'style'=>'padding-right:10px;')); echo str_replace("'", "\'", __('flash_notice_invites_sent_failure')); ?>.</div>';	        
					flashType = 'error';
				}
				if(flashDiv != '') {
					showNotification(flashDiv, flashType, function(){});
				}
			},
			beforeSend:function(XMLHttpRequest){
				  $('#inviteModule').loadingModal({show: true});
			},
			complete:function(XMLHttpRequest, textStatus){
				  $('#inviteModule').loadingModal({show: false});
			}
		});

		return false;
	});
});
</script>
<div style="margin-top: 5px; width: 580px; margin-left: auto; margin-right: auto; text-align: center;">
	<?php include_component('invite', 'facebookShare', array('url' => $url)) ?>
</div>
<div style="margin-top: 5px; width: 580px; margin-left: auto; margin-right: auto; text-align: center;">
    <?php echo image_tag('/image/' . $sf_user->getCulture(). '/invite/or.png', array('alt' => '', 'id' => '', 'size' => '280x50', 'style' => '')) ?>
</div>
<div id="loading-div1" style="margin: 0px; position: absolute; margin-left: 540px; margin-top: 12px; height:150px;">
	<?php image_tag('/images/interface/wait.gif', array('size' => '16x16', 'style' => 'border: none;')) ?>
</div>
<div style="width: 570px; padding-left: 10px;">
	<table style="width: 570px;">
		<tr>
			<td style="text-align: left; vertical-align: top; width: 280px;">
				<table>
					<tr>
						<td style="text-align: left; vertical-align: top;">
							<span style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold; font-style: normal; color: #282828;">
								<?php echo __("text_invite_email_add_adress"); ?>
							</span>
						</td>
					</tr>
					<tr>
						<td style="text-align: left; vertical-align: top; width: 280px;">
							<div class="adresse_manuellement">
								<table>
									<tr>
										<td style="text-align: left; vertical-align: top;">
											<form name="form_invite_email_manual" method="post" style="margin: 0px; padding: 0px;" onSubmit="return false;">
												<input class="email" type="text" name="" id="invite_button_email_manual" value ="" style="margin: 0px; padding: 0px; margin-top: 4px;" />
											</form>
										</td>
										<td style="text-align: left; vertical-align: top;">
											<?php echo image_tag('/image/' . $sf_user->getCulture(). '/invite/email_button_add.png', array('alt' => __('label_invite_add_button'), 'id' => 'invite_button_add_manual', 'size' => '66x28', 'style' => 'margin-top: 4px; cursor: pointer; margin-left: 5px;')) ?>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<div style="margin-top: 5px; width: 280px; text-align: center;">
											    <?php echo image_tag('/image/' . $sf_user->getCulture(). '/invite/or.png', array('alt' => '', 'id' => '', 'size' => '280x50', 'style' => '')) ?>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align: left; vertical-align: top;">
											<div id="invite_emails_import" class="import"></div>
											<div style="width: 45px; height: 15px; position: absolute; margin-left: 250px; margin-top: -200px; z-index: 1000;"><?php echo image_tag('/images/invite/arrow.png', array('size' => '45x15')) ?></div>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</td>
			<td style="text-align: left; vertical-align: top; width: 280px;">
				<div id="invite_emails_to"></div>
			</td>
	</table>
	<form name="form_invite_email_send" id="form_invite_email_send" action="" method="post" style="margin: 0px; padding: 0px;">
		<div style="margin: 0px; padding: 0px; width: 545px; margin-top: 15px;">
			<span style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold; font-style: normal; color: #282828;">
				<?php echo __("text_invite_email_pesonalize_message"); ?>
			</span>
			<?php if($room_data['privacy'] == sfConfig::get('mod_invite_privacy_room_private')
                     || $room_data['privacy'] == sfConfig::get('mod_invite_privacy_room_private_gambling_fr')) :?>
				<p style="color: #FF0000; margin-top: 10px; margin-bottom: 10px;">
					<?php echo __("text_invite_email_warning"); ?>
				</p>
			<?php endif;?>
			<div style="margin: 0px; padding: 0px; margin-top: 4px; border: 1px solid #d7d7d7; position: relative; width: 550px;">
				<div style="background-color: #f2f2f2; height: 60px;">
					<div style="margin: 0px; padding: 0px; height: 9px;"></div>
					<table style="margin: 0px; padding: 0px; margin-left: 14px;">
						<tr>
							<td style="vertical-align: middle; text-align: left;">
								<span style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold; font-style: normal; color: #6a6a6a;">De :</span>
							</td>
							<td style="vertical-align: middle; text-align: left; width: 30px;"></td>
							<td style="vertical-align: middle; text-align: left;">
							<span style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold; font-style: normal; color: #282828;">
								<?php echo $sf_user->getAttribute('firstName', '', 'subscriber') ?>
								<?php echo $sf_user->getAttribute('lastName', '', 'subscriber') ?>
							</span>
							</td>
						</tr>
					</table>
				</div>
				<div style="margin: 0px; padding: 0px;">
					<textarea name="form_invite_email_message_body" id="form_invite_email_message_body" style="font-family: Arial, sans-serif; font-size: 12px; font-weight: normal; font-style: normal; color: #6a6a6a; margin: 0px; margin-left: 10px; margin-top: 10px; margin-bottom: 10px; width: 530px; height: 250px; border: 0px solid red;"><?php echo $textDefault ?></textarea>
				</div>
			</div>
			<div style="margin-top: 7px; width: 550px; text-align: right;">
				<input type="image" src="/image/<?php echo $sf_user->getCulture(); ?>/invite/email_button_send.png" id="invite_email_button_send" value="Test send" />
			</div>
		</div>
	</form>
</div>
<div style="height: 20px;"></div>
<div style="clear: both;"></div>
<script type="text/javascript">
$(function(){
	  $("#invite_button_add_manual").click(function(){
			jQuery.ajax({
				url:'<?php echo url_for(array('module'=>'invite', 'action'=>'emailsAdd', 'param'=>'addManual')) ?>/email/'+$("#invite_button_email_manual").val(),
				type:'get',
				dataType:'html',
				cache: false,
				success:function(data, textStatus){
					jQuery('#invite_emails_to').html(data);
				},
				beforeSend:function(XMLHttpRequest){
					document.getElementById("loading-div1").style.display='block';
				},
				complete:function(XMLHttpRequest, textStatus){
					document.getElementById("loading-div1").style.display='none';
					$('#invite_email_add').scrollbar();
				}
			});
	  });
	});
$(document).ready(function() {
	jQuery.ajax({
		url:'<?php echo url_for(array('module'=>'invite', 'action'=>'emailsAdd', 'param'=>'email')) ?>',
		type:'get',
		dataType:'html',
		cache: false,
		success:function(data, textStatus){
			jQuery('#invite_emails_to').html(data);
		},
		beforeSend:function(XMLHttpRequest){
			document.getElementById("loading-div1").style.display='block';
		},
		complete:function(XMLHttpRequest, textStatus){
			document.getElementById("loading-div1").style.display='none';
			$('#invite_email_add').scrollbar();
		}
	});
	jQuery.ajax({
		url:'<?php echo url_for(array('module'=>'invite', 'action'=>'emailsGet', 'param'=>'')) ?>',
		type:'get',
		dataType:'html',
		cache: false,
		success:function(data, textStatus){
			$('#invite_emails_import').html(data);
		},
		beforeSend:function(XMLHttpRequest){
			document.getElementById("loading-div1").style.display='block';
		},	
		complete:function(XMLHttpRequest, textStatus){
			document.getElementById("loading-div1").style.display='none';
			$('#invite_emails_import_listing').scrollbar();
		}
	});
});
</script>
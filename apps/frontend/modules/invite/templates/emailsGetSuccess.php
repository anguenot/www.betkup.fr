<form name="form_invite_email_import" id="form_invite_email_import" method="post" style="margin: 0px; padding: 0px;" onSubmit="return false;">
<?php if ($param == ""): ?>
		<span style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold; font-style: normal; color: #282828; ">
			Importez votre carnet d'adresse :
		</span>
		<div style="margin: 0px; padding: 0px; margin-top: 5px;">
			<?php echo image_tag('/image/' . $sf_user->getCulture(). '/invite/email_button_import.png', array('alt' => __('label_invite_email_button_import'), 'id' => 'invite_email_button_import', 'size' => '92x27', 'style' => 'cursor: pointer;')) ?>
		</div>
		<script type="text/javascript">
		$(function() {
			  	var dataSerialized = $("#form_invite_email_import").serialize();
				jQuery.ajax({
					url:'<?php echo url_for(array('module'=>'invite', 'action'=>'emailsGet', 'param'=>'provider')) ?>/other/'+dataSerialized,
					type:'get',
					dataType:'html',
					cache: false,
					success:function(data, textStatus){
						$('#invite_emails_import').html(data);
					},
					beforeSend:function(XMLHttpRequest){
						$('#loading-div1').show();
					},
					complete:function(XMLHttpRequest, textStatus){
						$('#loading-div1').hide();
						$('#invite_emails_import_listing').scrollbar();
					}
				});
			});
			</script>
<?php endif ?>
<?php if ($param == "provider" or $error): ?>
		<table>
		<tr>
		<td align="left" valign="middle">
		<span style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold; font-style: normal; color: #282828; ">
			Importez votre carnet d'adresse :
		</span>
		</td>
		</tr>
		</table>
		<div style="border: 1px solid #fac650; margin-top: 4px;">
			<div id="loading-div2" align="center" style="margin: 0px; position: absolute; margin-left: 240px; margin-top: 6px; display: none;">
				<?php echo image_tag('/images/interface/wait.gif', array('size' => '14x14', 'style' => 'border: none;')) ?>
            </div>
			<div style="margin: 0px; padding: 0px; width: 200px; margin-top: 10px; margin-left: 12px;">
				<table style="margin: 0px; padding: 0px;">
                <?php foreach ( array('gmail', 'yahoo', 'hotmail') as $provider ): ?>
				<tr>
				    <td align="center" valign="middle" width="24">
                    <?php if ($invite_import_service == $provider): ?>
                        <input type="radio" name="invite_import_service" value="<?php echo $provider ?>" checked="checked" />
                    <?php else: ?>
                        <input type="radio" name="invite_import_service" value="<?php echo $provider ?>" />
                    <?php endif ?>
                    </td>
				    <td>
				    <?php echo image_tag('/image/default/invite/picto_' . $provider . '.png', array('alt' => __('label_invite_picto_' . $provider), 'id' => 'invite_picto_' . $provider, 'size' => '144x34', 'style' => '')) ?>
                    </td>
				</tr>
                <?php endforeach ?>
				</table>
			</div>
			<?php if ( $error ): ?>
			<div class="send_list_email_error" align="left" style="width: 220px; margin-left: 15px; margin-top: 8px;">
				<?php echo htmlspecialchars_decode($error) ?>
			</div>
            <?php endif ?>
			<div style="margin: 0px; padding: 0px; width: 230px; margin-left: 17px; margin-top: 15px;">
				<span style="font-family: Arial; font-size: 12px; font-weight: bold; text-decoration: none; color: #575757;">E-MAIL</span>
				<input class="email" style="width: 220px; height: 26px; border: 1px solid #d4d4d4; background-color: #f2f2f2; margin-top: 2px;" type="text" name="invite_import_email" id="invite_import_email" value="<?php echo $invite_import_email ?>" />
			</div>

			<div style="margin: 0px; padding: 0px; width: 230px; margin-left: 17px; margin-top: 10px;">
				<span style="font-family: Arial; font-size: 12px; font-weight: bold; text-decoration: none; color: #575757;">MOT DE PASSE</span>
				<input class="email" style="width: 220px; height: 26px; border: 1px solid #d4d4d4; background-color: #f2f2f2; margin-top: 2px;" type="password" name="invite_import_password" id="invite_import_password" value="<?php echo $invite_import_password ?>" />
			</div>

			<div style="margin: 0px; padding: 0px; width: 230px; margin-left: 87px; margin-top: 10px; margin-bottom: 10px;">
				<?php echo image_tag('/image/' . $sf_user->getCulture(). '/invite/email_button_import.png', array('alt' => __('label_invite_email_button_import'), 'id' => 'invite_email_button_import', 'size' => '92x27', 'style' => 'cursor: pointer;')) ?>
			</div>
		</div>

		<script type="text/javascript">
			$(function() {
			  $("#invite_email_button_import").click(function() {
				  	var dataSerialized = $("#form_invite_email_import").serialize();
					$.ajax({
						url:'<?php echo url_for(array('module'=>'invite', 'action'=>'emailsGet', 'param'=>'import')) ?>/other/'+dataSerialized,
						type:'get',
						dataType:'html',
						cache: false,
						success:function(data, textStatus){
							$('#invite_emails_import').html(data);
						},
						beforeSend:function(XMLHttpRequest){
							$("#loading-div2").show();
						},
						complete:function(XMLHttpRequest, textStatus){
							$("#loading-div2").hide();
							$('#invite_emails_import_listing').scrollbar();
						}
					});
			  });
			});
		</script>
<?php endif ?>

<?php if ( $param == "import" && !$error ): ?>

		<table>
			<tr>
				<td align="left" valign="middle">
					<span style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold; font-style: normal; color: #282828; ">
						Importez votre carnet d'adresse :
					</span>
				</td>
				<td align="right" valign="middle">
					<span id="invite_import_retour_provider" style="cursor: pointer;">Fermer</span>
				</td>
			</tr>
		</table>

		<div id="invite_emails_import_listing" style="border: 1px solid #fac650; margin-top: 4px; height: 270px;overflow: auto;">

			<?php if ( isset($emails) && $emails != "" ): ?>
				<div style="margin: 0px; padding: 0px;">
				<?php $cpt=1; foreach ( $emails as $email ): ?>
					<input type="hidden" name="invite_import_hidden_<?php echo $cpt ?>" value="<?php echo $email ?>" id="invite_import_hidden_<?php echo $cpt ?>">
					<div class="send_list_email_import" id="invite_import_blocForHidden_<?php echo $cpt ?>">
						<?php echo Util::coupe($email, 20, '..') ?>
						<?php echo image_tag('/image/default/invite/invite_email_add.png', array('alt' => __('label_invite_email_del'), 'size' => '26x26', 'id' => 'invite_button_add_manual_'.$cpt, 'style' => 'cursor: pointer; float: right; margin-right: 4px;')) ?>
					</div>
				<?php $cpt++; endforeach ?>
				<div style="clear: both;"></div>
				</div>
		    <?php else: ?>
				<div style="margin: 0px; padding: 0px; margin-top: 4px; margin-bottom: 15px; position: relative; width: 550px;">
					<div style="clear: both;"></div>
				</div>
			<?php endif ?>
		</div>
<?php endif ?>

</form>

<script type="text/javascript">
	$(function(){
	  $("#invite_import_retour_provider").click(function(){
			$.ajax({
				url:'<?php echo url_for(array('module'=>'invite', 'action'=>'emailsGet', 'param'=>'')) ?>',
				type:'get',
				dataType:'html',
				cache: false,
				success:function(data, textStatus){
					$('#invite_emails_import').html(data);
				},
				beforeSend:function(XMLHttpRequest){
					$('#loading-div1').show();
				},
				complete:function(XMLHttpRequest, textStatus){
					$('#loading-div1').hide();
				}
			});
	  });
	});
<?php $cpt=1; foreach ( $emails as $email ): ?>
	$(function() {
	  $("#invite_import_blocForHidden_<?php echo $cpt ?>").click(function() {
		$.ajax({
			url:'<?php echo url_for(array('module'=>'invite', 'action'=>'emailsAdd', 'param'=>'addManual')) ?>/email/'+$("#invite_import_hidden_<?php echo $cpt ?>").val(),
			type:'get',
			dataType:'html',
			cache: false,
			success:function(data, textStatus){
				$('#invite_emails_to').html(data);
			},
			beforeSend:function(XMLHttpRequest){
				$('#loading-div1').show();
			},
			complete:function(XMLHttpRequest, textStatus){
				$('#loading-div1').hide();
				$("#invite_import_blocForHidden_<?php echo $cpt ?>").remove();
				$('#invite_email_add').scrollbar();
			}
		});
	  });
	});
<?php $cpt++; endforeach ?>
</script>
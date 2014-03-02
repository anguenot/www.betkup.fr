<table>
<tr>
<td align="left" valign="middle">
	<span style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold; font-style: normal; color: #282828; ">
		<?php echo ( (isset($emails) && $emails!='')? __('text_invite_email_send_list') : __('text_invite_email_no_recipient')) ?>
	</span>
</td>
<td align="left" valign="middle" style="padding-left: 10px;">
	<?php if ( isset($error) && $error != "" ): ?>
		<div class="send_list_email_error"><?php echo htmlspecialchars_decode($error) ?></div>
	<?php endif ?>
</td>
</tr>
</table>

<?php if ( isset($emails) && $emails != "" ): ?>
<div id="invite_email_add" style="margin: 0px; padding: 0px; margin-top: 4px; margin-bottom: 15px; border: 1px solid #fac650; position: relative; width: 270px; height: 371px; overflow: auto;">

<?php $cpt=1; foreach ( $emails as $email ): ?>
	<div class="send_list_email" id="invite_div_del_manual_<?php echo $cpt; ?>">
		<?php echo Util::coupe($email, 20, '..') ?>
		<?php echo image_tag('/image/default/invite/invite_email_croix.png', array('alt' => __('label_invite_email_del'), 'size' => '26x26', 'id' => 'invite_button_del_manual_'.$cpt, 'style' => 'float: right; margin-right: 4px;')) ?>
	</div>
<?php $cpt++; endforeach ?>
<?php if($cpt == 1) :?>
	<div style="font-size: 10px; color: #6a6a6a; font-style: italic; width: 270px; margin-top: 20px; text-align: center;"><?php echo __('text_invite_email_no_user_add')?></div>
<?php endif;?>
</div>
<?php else: ?>
<div style="margin: 0px; padding: 0px; margin-top: 4px; margin-bottom: 15px; position: relative; width: 270px;">
	<div style="clear: both;"></div>
</div>
<?php endif ?>

<script type="text/javascript">

	<?php $cpt=1; foreach ( $emails as $email ): ?>
		$("#invite_div_del_manual_<?php echo $cpt; ?>").click(function() {
			jQuery.ajax({
				type:'get',
				dataType:'html',
				cache: false,
				success:function(data, textStatus){
					jQuery('#invite_emails_to').html(data);
				},
				beforeSend:function(XMLHttpRequest){
					$("#loading-div1").show();
				},
				complete:function(XMLHttpRequest, textStatus){
					$("#loading-div1").hide();
					$('#invite_email_add').scrollbar();
				},
				url:'<?php echo url_for(array('module'=>'invite', 'action'=>'emailsAdd', 'param'=>'delManual', 'email'=>$email)) ?>'
			});
	  	});
	<?php $cpt++; endforeach ?>

</script>
<div style="margin-top: 5px; width: 580px; margin-left: auto; margin-right: auto; text-align: center;">
	<?php include_component('invite', 'facebookShare', array('url' => $url)) ?>
</div>
<div style="margin-top: 5px; width: 580px; margin-left: auto; margin-right: auto; text-align: center;">
    <?php echo image_tag('/image/' . $sf_user->getCulture(). '/invite/or.png', array('alt' => '', 'id' => '', 'size' => '280x50', 'style' => '')) ?>
</div>
<div style="margin: 0px; padding: 0px; width: 580px; margin-left: auto; margin-right: auto; text-align: center;">
	<form name="formInviteLink" method="post">
	    <p align="center"><b><?php echo __('label_invite_copy_link_below') ?></b></p>
	    <div style="display: block; height: 30px;"></div>
		<input type="text" READONLY name="formInviteLink[url]" id="formInviteLink_url" value="<?php echo $url; ?>" style="text-align: center; margin: 0px; padding: 0px; padding-left: 0px; border: none; background-color: #f0f0f0; margin-top: 9px; width: 400px; height: 28px;">
	</form>
</div>
<div style="height: 200px;"></div>
<div style="clear: both;"></div>
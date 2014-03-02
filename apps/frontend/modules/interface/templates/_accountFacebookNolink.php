<div style="width: 400px; text-align: center;">
<?php echo __('account_facebook_nolink_message'); ?>
	<div align="center" style="margin: 20px;">
		<a
			href="<?php echo url_for(array('module' => 'account', 'action' => 'linkToFacebook')) ?>">
			<?php echo image_tag('facebook/connect.png', array('alt' => '', 'border' => '0', 'size' => '107x25')); ?>
		</a>
	</div>
</div>

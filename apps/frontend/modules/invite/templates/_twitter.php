<div style="margin-top: 5px; width: 580px; margin-left: auto; margin-right: auto; text-align: center;">
	<?php include_component('invite', 'facebookShare', array('url' => $url)) ?>
</div>
<div style="margin-top: 5px; width: 580px; margin-left: auto; margin-right: auto; text-align: center;">
    <?php echo image_tag('/image/' . $sf_user->getCulture(). '/invite/or.png', array('alt' => '', 'id' => '', 'size' => '280x50', 'style' => '')) ?>
</div>
<div style="margin: 0px; padding: 0px; width: 580px; margin-left: auto; margin-right: auto; text-align: center;">
	<div style="width: 580px; height: 50px; background: url('/image/default/invite/background_twitter.png') center no-repeat;">
		<form name="formTwitter" method="post">
			<input type="text" READONLY name="formTwitter[text]" id="formTwitter_text" value="<?php echo $message; ?>" style="border: none; background-color: #f0f0f0; margin: 0px; padding: 0px; margin-left:30px; margin-top: 9px; padding-left:5px; width: 340px; height: 28px;">
		</form>
	</div>
	<a rel="nofollow" target="_blank" href="http://twitter.com/home?status=<?php echo $message; ?> - <?php echo $url; ?>">
		<?php echo image_tag('/image/' . $sf_user->getCulture(). '/invite/button_publish_twitter.png', array('alt' => '', 'id' => '', 'size' => '166x34', 'style' => 'margin-top: 25px;')) ?>
	</a>
</div>
<div style="height: 200px;"></div>
<div style="clear: both;"></div>
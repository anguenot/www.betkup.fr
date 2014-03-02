<script type="text/javascript">
$(function() {
	var likeButton = '<div class="fb-like" data-href="<?php echo $url; ?>" data-send="true" data-width="500" data-show-faces="false" data-action="recommend"></div>';
	$('#facebook-buttons').html(likeButton);
	FB.XFBML.parse(document.getElementById('facebook-buttons'));
});
</script>

<div style="margin-top: 5px; width: 580px; margin-left: auto; margin-right: auto;  text-align: center;">
	<?php include_component('invite', 'facebookShare', array('url' => $url)) ?>
</div>
<div style="margin-top: 5px; width: 580px; margin-left: auto; margin-right: auto;  text-align: center;">
    <?php echo image_tag('/image/' . $sf_user->getCulture(). '/invite/or.png', array('alt' => '', 'id' => '', 'size' => '280x50', 'style' => '')) ?>
</div>
	<div id="facebook-buttons" style="margin-top: 5px;" align="center">
    </div>
    <div style="display: block; height: 30px;"></div>
	
	<?php if($sf_user->getAttribute('facebookId', '', 'subscriber') == '') :?>
		<div style="width: 400px; margin-left: auto; margin-right: auto;">
			<?php include_component('interface', 'accountFacebookNolink') ?>
		</div>
	<?php endif;?>
<div class="footer"></div>
<div style="clear: both;"></div>
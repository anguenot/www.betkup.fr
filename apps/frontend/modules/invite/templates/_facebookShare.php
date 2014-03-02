<script type="text/javascript">

function fbs_click() {
	FB.ui({ method: 'feed',
			display: 'iframe',
        	link: '<?php echo $url ?>'
    });
    
    return false;
}
</script>
<a rel="nofollow" href="javascript:void(0);" class="fb_share_button" onclick="javascript:return fbs_click()">
    <?php echo image_tag('/image/' . $sf_user->getCulture(). '/invite/button_publish_facebook.png', array('alt' => __('label_invite_button_publish'), 'id' => 'invite_button_publish', 'size' => '247x36', 'style' => '')) ?>
</a>
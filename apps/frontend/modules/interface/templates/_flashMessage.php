<?php if ($sf_user->hasFlash('error') && $sf_user->getFlash('error') != ''): ?>
<script type="text/javascript">
	$(document).ready(function() {
        var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?><?php echo $sf_user->getFlash('error') ?></div>';
	        showNotification(data, "error", function(){
			});
		});
</script>
<?php $sf_user->setFlash('error', null) ?>
<?php endif ?>

<?php if ($sf_user->hasFlash('notice') && $sf_user->getFlash('notice') != ''): ?>
<script type="text/javascript">
	$(document).ready(function() {
        var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_success.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?><?php echo $sf_user->getFlash('notice') ?></div>';
	        showNotification(data, "success", function(){
			});
		});
</script>
<?php $sf_user->setFlash('notice', null) ?>
<?php endif ?>

<div id="notification" class="notification">
	<span id="notification-text"></span>
</div>

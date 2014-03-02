<?php if(count($notifications) > 0) :?>
	<?php include_component('interface', 'notificationsPopup', array('notifications' => $notifications)) ?>
<?php endif; ?>
<div class="moncompte me">
<?php include_component('account', 'navigation', array()) ?>
	<div class="my-betkup" style="width: 769px;">
	<?php include_component('me', 'right', array('status' => $status, 'percentage' => $percentage)) ?>
		<div class="view">
		<?php include_component('interface', 'areaOneBegin', array('margintop' => 4)) ?>
		<?php echo image_tag('/image/' . $sf_user->getCulture(). '/me/title_myboard.png', array('class' => 'title-me', 'size' => '350x62', 'alt' => __('label_me_myboard_title'))) ?>
		<?php if (count($status) < 5) : ?>
		<?php include_component('me', 'dashboard', array('status' => $status)); ?>
		<?php endif; ?>
		<?php include_component('account', 'title', array('racine' => 'myKups', 'altImg' => __('title_me_kups'), 'area' => 'areaOne', 'height' => 50)) ?>

		<?php if ($totalKups > 0 && $isOnlyClosedKups == false && $isOnlyOpenKups == false) : ?>
			<div style="height: 60px; margin-left: 360px;">
			<?php include_component('me', 'selectKupStatus'); ?>
			</div>
			<?php include_component('kup', 'kupsRoom', array('parentModule' => 'me', 'kupStatus' => $kupStatus, 'uuid' => 'me', 'totalKups' => $totalKups ));
			elseif($isOnlyClosedKups == true && $isOnlyOpenKups == false && $totalKups > 0) : ?>
			<table style="border-collapse: collapse; border-spacing: 0px; vertical-align: middle; margin-top: 20px; margin-bottom: 20px;">
				<tr>
					<td style="padding-left: 85px; vertical-align: middle;">
						<?php echo image_tag('/image/default/me/alert.png', array('class' => 'alert', 'size' => '12x12', 'alt' => __('label_me_alert'))); ?>
					</td>
					<td style="width: 250px; vertical-align: middle;">
					<span class="only-kup-closed">
						<?php echo __('text_me_only_closed_kup'); ?>
					</span>
					</td>
					<td><a href="<?php echo url_for(array('module'=>'kup', 'action'=>'home')) ?>">
						<?php echo image_tag('/image/' . $sf_user->getCulture(). '/kup/button_search.png', array('size' => '200x41', 'alt' => __('label_kup_search'))) ?>
					</a>
					</td>
				</tr>
			</table>
			<?php include_component('kup', 'kupsRoom', array('parentModule' => 'me', 'kupStatus' => $kupStatus, 'uuid' => 'me', 'totalKups' => $totalKups ));

			elseif($isOnlyClosedKups == false && $isOnlyOpenKups == true && $totalKups > 0) : ?>
				<?php include_component('kup', 'kupsRoom', array('parentModule' => 'me', 'kupStatus' => $kupStatus, 'uuid' => 'me', 'totalKups' => $totalKups ));
			else : ?>
			<div class="no-element">
			<?php echo image_tag('/image/default/me/alert.png', array('class' => 'alert', 'size' => '12x12', 'alt' => __('label_me_alert'))) ?>
			<?php echo __('texte_me_no_kup'); ?>
				<br /><br />
				<a href="<?php echo url_for(array('module'=>'kup', 'action'=>'home')) ?>">
					<?php echo image_tag('/image/' . $sf_user->getCulture(). '/kup/button_search.png', array('size' => '200x41', 'alt' => __('label_kup_search'))) ?>
				</a>
			</div>
			<?php endif; ?>
			<br />
			<?php include_component('account', 'title', array('racine' => 'myRooms', 'altImg' => __('title_me_rooms'), 'area' => 'areaOne', 'height' => 60)) ?>
			<?php if ($totalRooms > 0) : ?>
				<?php include_component('room', 'myRooms', array('totalRooms' => $totalRooms, 'elementHeight' => '325')); ?>
			<div class="vide"></div>
			<?php else : ?>
			<div class="no-element">
			<?php echo image_tag('/image/default/me/alert.png', array('class' => 'alert', 'size' => '12x12', 'alt' => __('label_me_alert'))) ?>
			<?php echo __('texte_me_no_room'); ?>
				<br /> <br /> <br />
				<a href="<?php echo url_for(array('module'=>'room', 'action'=>'search')) ?>">
					<?php echo image_tag('/image/' . $sf_user->getCulture(). '/room/button_search.png', array('style' => 'margin-right: 20px;', 'size' => '200x41', 'alt' => __('label_room_search'))) ?>
				</a>
				<a href="<?php echo url_for(array('module'=>'room', 'action'=>'create')) ?>">
					<?php echo image_tag('/image/' . $sf_user->getCulture(). '/room/button_create.png', array('size' => '200x41', 'alt' => __('label_room_create'))) ?>
				</a>
			</div>
			<div class="no-element-supplement"></div>
			<?php endif; ?>
			<div style="height: 45px; display: block;"></div>
			<?php include_component('interface', 'areaOneEnd') ?>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function() {

    $("select#kupsStatusSelect").change(function() {
		var totalKups = 0;
		$.ajax({
			url: "<?php echo url_for(array('module' => 'me', 'action' => 'getTotalKups')) ?>/kup_status/"+$(this).val(),
			async: false,
		  	success: function(data) {
		  		totalKups = data;
		  	}
		});

    	$('#kupsList-me').empty().SofunBatch({
    		id: 'genericKups_me',
    		previousOffset: '<?php echo $previousOffset; ?>',
    		currentOffset: '<?php echo $currentOffset; ?>',
    		nextOffset: '<?php echo $nextOffset; ?>',
    		batchSize: '<?php echo $batchSize; ?>',
    		totalResults: totalKups,
    		nbDisplay: '<?php echo $nbDisplay; ?>',
    		nbLine: '<?php echo $nbLine; ?>',
    		textPager: '<?php echo __('text_slider_kups'); ?>',
    		imgPrev: '<?php echo image_tag('/images/kup/home/left.png', array('id'=>'newsfeedGauche','border'=>'0'))?>',
    		imgNext: '<?php echo image_tag('/images/kup/home/right.png', array('id'=>'newsfeedGauche','border'=>'0'))?>',
    		imgLoading: '<?php echo image_tag('/images/wait.gif', array('size' => '16x16', 'style' => 'float:left;' )) ?>',
    		ajaxSource: "<?php echo url_for(array('module' => 'kup', 'action' => 'KupsThumbnails', 'uuid'=> 'me', 'is_inside_room' => 0)) ?>/kup_status/"+$(this).val()
    	});
    });
});
</script>
<?php if ($roomUI != '') : ?>
<?php use_stylesheet('roomPerso.css') ?>
<script type="text/javascript">
		<?php if ($roomUI['isBgPerso'] == '1') : ?>
	$("body").css("background", "url('<?php echo $roomUI['body-bg-img']; ?>') center top <?php echo $roomUI['body-bg-color']; ?>");
		<?php endif; ?>
		<?php if ($roomUI['isHeaderPerso'] == '1') : ?>
	$(".logo_betkup").removeClass('logo_betkup').addClass('logo_betkup_hosted');
	$(".logo_betkup_hosted").html("<a title='Home page' href='/'><img  border='0'  src='<?php echo $roomUI['header-hosted-logo']; ?>' alt='Home page'></a>");
	$('.mainHeader').after('<div class="header_logo"><?php echo image_tag($roomUI['header-room-logo'], array('size' => (isset($roomUI['header-room-logo-size'])) ? $roomUI['header-room-logo-size'] : '439x90'))?></div>');
		<?php endif; ?>
	$(function () {
		$('#badge').hide();
		<?php if ($roomUI['isHeaderPerso'] == '1') : ?>
			$('img[src="/images/moncompte/button_mybetkup.png"]').attr('src', '/images/moncompte/button_mybetkup_room_perso.png');
			$('.top_facebookjaime').hide();
			<?php endif; ?>
		<?php if ($roomUI['isPicBottomLeft'] == '1') : ?>
			$('.mainFooter').before('<div style="left:0%; top:55%; position: absolute;"><?php echo image_tag($roomUI['body-bg-img-bottom-left'])?></div>');
			<?php endif; ?>
		<?php if ($roomUI['isPicBottomRight'] == '1') : ?>
			$('.container').append('<div style="position: absolute; bottom:0; right:0;"><?php echo image_tag($roomUI['body-bg-img-bottom-right'])?></div>');
			<?php endif; ?>
		<?php if ($roomUI['isRoomNameColorPerso'] == '1') : ?>
			$('.nomRoom').css('color', '<?php echo $roomUI['header-author-font-color']; ?>');
			<?php endif; ?>
	});
</script>
<?php endif; ?>
<div class="moncompte">
	<?php include_component('account', 'navigation', array()) ?>
	<div class="room">
		<table id="room_table">
			<tr>
				<td style="vertical-align: top; width: 760px;">
					<div class="view" style="margin-top: 4px;">
						<div class="" style="margin-left: 10px;">
							<?php include_component('room', 'header', array('data' => $dataRoom)) ?>
						</div>

						<?php include_component('room', 'tabs', array('numTab' => '1', 'id' => '1', 'tabs' => $dataTabs, 'tab' => $tab)) ?>
						<?php include_component('interface', 'areaOneBegin', array('displayTop' => false)) ?>
						<div style="height: 25px;"></div>

						<?php include_component('interface', 'title', array('culture' => $sf_user->getCulture(), 'racine' => 'room_members', 'altImg' => __('label_room_members'), 'startY' => '0')) ?>
						<?php include_component('room', 'members', array()) ?>
						<div>
							<div style="height: 300px; width: 100%;"></div>
						</div>
						<div style="height: 15px;"></div>
						<?php include_component('interface', 'areaOneEnd') ?>
					</div>
				</td>
				<td style="vertical-align: top; width: 220px;">
					<div style="padding-left: 5px; padding-top: 7px;">
						<?php if ($roomUI != ''): ?>
						<?php include_component('room', 'right', array('dataRoom' => $dataRoom, 'roomUI' => $roomUI)) ?>
						<?php else: ?>
						<?php include_component('room', 'right', array('dataRoom' => $dataRoom)) ?>
						<?php endif?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<script type="text/javascript">
	$.ajax({
		type:'get',
		dataType:'html',
		success:function (data, textStatus) {
			jQuery('#room_members_kups_list').html(data);
		},
		beforeSend:function (XMLHttpRequest) {
			document.getElementById("loading-div1").style.display = 'block';
		},
		complete:function (XMLHttpRequest, textStatus) {
			document.getElementById("loading-div1").style.display = 'none';
		},
		url:'<?php echo url_for(array('module' => 'room', 'action' => 'listPlayers', 'uuid' => $uuid, 'kup' => '')) ?>'
	});
	$(function () {
		$("select#selectRoomMembersKups").change(function () {
			jQuery.ajax({
				type:'get',
				dataType:'html',
				success:function (data, textStatus) {
					jQuery('#room_members_kups_list').html(data);
				},
				beforeSend:function (XMLHttpRequest) {
					document.getElementById("loading-div1").style.display = 'block';
				},
				complete:function (XMLHttpRequest, textStatus) {
					document.getElementById("loading-div1").style.display = 'none';
				},
				url:'<?php echo url_for(array('module' => 'room', 'action' => 'listPlayers', 'uuid' => $uuid)) ?>/kup/' + $(this).val()
			});
		})
	});
</script>
<?php if ($sf_request->getAttribute('roomUI', "")) {$roomUI = $sf_request->getAttribute('roomUI', "");} ?>
<?php if (isset($roomUI)) {?>
<?php use_stylesheet('roomPerso.css') ?>
<script type="text/javascript">
	<?php if (isset($roomUI['isHeaderPerso']) && $roomUI['isBgPerso'] == '1') { ?>
        $("body").css("background","url('<?php echo $roomUI['body-bg-img']; ?>') center top <?php echo $roomUI['body-bg-color']; ?> repeat-x");
    <?php } ?>
    <?php if (isset($roomUI['isHeaderPerso']) && $roomUI['isHeaderPerso'] == '1') { ?>
        $(".logo_betkup").removeClass('logo_betkup').addClass('logo_betkup_hosted');
       	$(".logo_betkup_hosted").html("<a title='Home page' href='/'><img  border='0'  src='<?php echo $roomUI['header-hosted-logo']; ?>' alt='Home page'></a>");
        $('.mainHeader').after('<div class="header_logo"><?php echo image_tag($roomUI['header-room-logo'], array('size' => (isset($roomUI['header-room-logo-size'])) ? $roomUI['header-room-logo-size']:'439x90'))?></div>');
    <?php } ?>
    $(function () {
        <?php if (isset($roomUI['isHeaderPerso']) && $roomUI['isHeaderPerso'] == '1') : ?>
	        $('img[src="/images/moncompte/button_mybetkup.png"]').attr('src','/images/moncompte/button_mybetkup_room_perso.png');
	        $('.top_facebookjaime').hide();
	    <?php endif; ?>
        <?php if(isset($roomUI['isPicBottomLeft']) &&$roomUI['isPicBottomLeft'] == '1') : ?>
            $('.container').append('<div style="margin-left: -210px; bottom: 20px; position: absolute;"><?php echo image_tag($roomUI['body-bg-img-bottom-left'])?></div>');
        <?php endif; ?>
        <?php if (isset($roomUI['isPicBottomRight']) && $roomUI['isPicBottomRight'] == '1') : ?>
        	$('.container').append('<div style="position: absolute; bottom: 20px; right: 0px; margin-right: -160px;"><?php echo image_tag($roomUI['body-bg-img-bottom-right'])?></div>');
        <?php endif; ?>
        <?php if(isset($roomUI['isPicTopLeft']) && $roomUI['isPicTopLeft'] == '1' && isset($roomUI['body-bg-img-top-left'])) :?>
        	$('.container').append('<div style="margin-left: -210px; top: 100px; position: absolute;"><?php echo image_tag($roomUI['body-bg-img-top-left'])?></div>');
		<?php endif;?>
        <?php if (isset($roomUI['isRoomNameColorPerso']) && $roomUI['isRoomNameColorPerso'] == '1') : ?>
        	$('.nomRoom').css('color','<?php echo $roomUI['header-author-font-color']; ?>');
        <?php endif; ?>
    });
</script>
<?php }?>
<div class="moncompte">
	<?php include_component('account', 'navigation', array()) ?>
	<div class="room">
    	<table id="room_table">
        	<tr>
            	<td style="vertical-align: top; width: 760px;">
					<div class="view">
						<div class="" style="margin: 0px; margin-left: 5px; margin-bottom: 10px;">
							<?php include_component('room', 'kupheader', array ('dataRoom'=>$dataRoom, 'kupData' => $kupData)) ?>
						</div>
						<?php include_component('kup', 'tabs', array('numTab' => '1', 'id' => '1', 'tabs' => $dataKupTabs, 'tab' => $tab)) ?>
						<?php include_component('interface', 'areaOneBegin', array('displayTop' => false)) ?>
							<div>
								<?php include_component('kup', 'rules', array('uuid' => $kup_uuid, 'kupData' => $kupData, 'module' => $module, 'roomUI' => $roomUI)) ?>
							</div>
						<?php include_component('interface', 'areaOneEnd') ?>
					</div>
				</td>
				<td style="vertical-align: top; width: 220px;">
					<div style="padding-left: 5px; padding-top: 7px;">
						<?php if (isset($roomUI)): ?>
						<?php include_component('kup', 'right', array('kupData' => $kupData, 'roomUI' => $roomUI, 'room_uuid' => $room_uuid, 'canInvite' => $canInvite)) ?>
						<?php else: ?>
						<?php include_component('kup', 'right', array('kupData' => $kupData, 'room_uuid' => $room_uuid, 'canInvite' => $canInvite)) ?>
						<?php endif ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$("#selectRoomViewTypeKups").selectmenu({style:'dropdown', width: 140, menuWidth: 140});
	});
</script>
<?php if ($sf_request->getAttribute('roomUI', "")) {$roomUI = $sf_request->getAttribute('roomUI', "");} ?>
<?php if (isset($roomUI)) {?>
<?php use_stylesheet('roomPerso.css') ?>
<script type="text/javascript">
    <?php if ($roomUI['isBgPerso'] == '1') { ?>
        $("body").css("background","url('<?php echo $roomUI['body-bg-img']; ?>') center top <?php echo $roomUI['body-bg-color']; ?> repeat-x");
    <?php } ?>
    <?php if ($roomUI['isHeaderPerso'] == '1') { ?>
        $(".logo_betkup").removeClass('logo_betkup').addClass('logo_betkup_hosted');
        $(".logo_betkup_hosted").html("<a title='Home page' href='/'><img  border='0'  src='<?php echo $roomUI['header-hosted-logo']; ?>' alt='Home page'></a>");
        $('.mainHeader').after('<div class="header_logo"><?php echo image_tag($roomUI['header-room-logo'], array('size' => (isset($roomUI['header-room-logo-size'])) ? $roomUI['header-room-logo-size']:'439x90'))?></div>');
    <?php } ?>

    $(function () {
        <?php if ($roomUI['isHeaderPerso'] == '1') { ?>
            $('img[src="/images/moncompte/button_mybetkup.png"]').attr('src','/images/moncompte/button_mybetkup_room_perso.png');
            $('.top_facebookjaime').hide();
        <?php } ?>
        <?php if ($roomUI['isPicBottomLeft'] == '1') { ?>
            $('.mainFooter').before('<div style="left:0%; top:55%; position: absolute;"><?php echo image_tag($roomUI['body-bg-img-bottom-left'])?></div>');
        <?php } ?>
        <?php if ($roomUI['isPicBottomRight'] == '1') { ?>
        $('.container').append('<div style="position: absolute; bottom:0; right:0;"><?php echo image_tag($roomUI['body-bg-img-bottom-right'])?></div>');
        <?php } ?>
        <?php if ($roomUI['isRoomNameColorPerso'] == '1') { ?>
        $('.nomRoom').css('color','<?php echo $roomUI['header-author-font-color']; ?>');
        <?php }  ?>
    });
</script>
<?php }?>
<div class="moncompte">
<?php include_component('account', 'navigation', array()) ?>
	<div class="room">
    	<table id="room_table" style="margin-top: -2px;">
        	<tr>
            	<td style="vertical-align: top; width: 760px;">
					<div class="view" style="margin-top: 4px;">
						<div class="" style="margin-left: 10px;">
							<?php include_component('room', 'header', array ('data'=>$roomData)) ?>
						</div>
						<?php if ( $sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_administrator')) ): ?>
					    <?php include_component('room', 'tabs', array('numTab' => '3', 'id' => '3', 'tabs' => $dataTabs, 'tab' => $tab)) ?>
					    <?php endif ?>
						<?php include_component('interface', 'areaOneBegin', array('displayTop' => false)) ?>
						<div style="height: 25px;"></div>
					    <?php include_component('account', 'title', array('racine' => 'invite_friends', 'altImg' => __('label_room_invite_friends'), 'area' => 'areaOne')) ?>
					    <div id="invite"></div>
					     <div style="height: 200px;"></div>
						<?php include_component('interface', 'areaOneEnd') ?>
					</div>
				</td>
				<td style="vertical-align: top; width: 220px;">
					<div style="padding-left: 5px; padding-top: 7px;">
						<?php  if (isset($roomUI)) { include_component('room', 'right', array('roomUI' => $roomUI, 'dataRoom'=> $roomData)); }else{ include_component('room', 'right', array('dataRoom'=>$roomData)); }?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<script type="text/javascript">
$(function () {
	$.ajax({
		  type: "GET",
		  url: "<?php echo url_for(array('module' => 'invite', 'action' => 'index', 'room_uuid' => $roomUuid, 'room_data' => $roomData)) ?>",
		  success: function(data) {
			  $('#invite').html(data);
		  }
	});
});
</script>

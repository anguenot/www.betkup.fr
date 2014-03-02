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
		<table id="room_table" style="margin-top: -2px;">
	    	<tr>
	        	<td style="vertical-align: top; width: 760px;">
		            <div class="view" style="margin-top: 4px;">
		                <div class="" style="margin-left: 10px;">
		                    <?php include_component('room', 'header', array ('data'=>$dataRoom)) ?>
		                </div>
		                <?php include_component('room', 'tabs', array('numTab' => '1', 'id' => '1', 'tabs' => $dataTabs, 'tab' => $tab)) ?>
		                <?php include_component('interface', 'areaOneBegin', array('displayTop' => false)) ?>
		                <div style="height: 50px;"></div>
		                    <div>
		                        <table>
		                            <tr>
		                                <td style="padding-left: 15px; vertical-align: middle;">
		                                    <?php echo image_tag('/image/default/me/alert.png', array('class' => 'alert', 'size' => '12x12', 'alt' => __('label_me_alert'))); ?>
		                                </td>
		                                <td style="padding-left: 10px; vertical-align: middle;">
		                                    <span class="only-kup-closed"><?php echo __('text_kups_choose_and_configure'); ?></span>
		                                </td>
		                            </tr>
		                        </table>
		                    </div>
		                    <div style="height: 15px;"></div>
		                        <?php echo image_tag('/image/' . $sf_user->getCulture(). '/room/kups_header.png', array('alt' => __('label_room_kups_header'), 'size' => '710x78')) ?>
		                    <div>
		                        <table style="border-collapse:collapse; border-spacing: 0; width: 710px;">
		                            <tr>
		                                <td style="text-align: center; vertical-align: middle;">
		                                    <div id="loading-div1" style="margin: 0px;"><?php echo image_tag('/images/interface/wait_big.gif', array('size' => '220x19')); ?></div>
		                                </td>
		                            </tr>
		                        </table>
		                    </div>
		                    <div id="room_kups_manage" style="width: 715px;"></div>
		                <div style="height: 50px;"></div>
		                <?php include_component('interface', 'areaOneEnd') ?>
		            </div>
	            </td>
	            <td style="vertical-align: top; width: 220px;">
					<div style="padding-left: 5px; padding-top: 7px;">
	            		<?php if (isset($roomUI)): ?>
		                <?php include_component('room', 'right', array('dataRoom'=> $dataRoom, 'roomUI' => $roomUI)) ?>
			            <?php else: ?>
			               	<?php include_component('room', 'right', array('dataRoom'=> $dataRoom)) ?>
			            <?php endif ?>
		           </div>
	            </td>
            </tr>
    	</table>
	</div>
</div>
<script type="text/javascript">
$(function() {
	$.ajax({
		type:'get',
		dataType:'html',
		success:function(data, textStatus){
			jQuery('#room_kups_manage').html(data);
		},
		beforeSend:function(XMLHttpRequest){
			$('#loading-div1').show();
		},
		complete:function(XMLHttpRequest, textStatus){
			$('#loading-div1').hide();
		},
		url:'<?php echo url_for(array('module'=>'room', 'action'=>'editKups', 'uuid'=> $uuid)) ?>'
	});
});
</script>
<?php if (isset($roomUI) && $roomUI != '') :?>
<?php use_stylesheet('roomPerso.css', 'first') ?>
<script type="text/javascript">
$(function () {    
<?php if (isset($roomUI['isBgPerso']) && $roomUI['isBgPerso'] == '1') : ?>
        $("body").css("background","url('<?php echo $roomUI['body-bg-img']; ?>') center top <?php echo $roomUI['body-bg-color']; ?> repeat-x");
    <?php endif ?>
    <?php if (isset($roomUI['isHeaderPerso']) && $roomUI['isHeaderPerso'] == '1') : ?>
        $(".logo_betkup").removeClass('logo_betkup').addClass('logo_betkup_hosted');
        $(".logo_betkup_hosted").html('<a title="Home page" href="/"><img  border="0"  src="<?php echo $roomUI['header-hosted-logo']; ?>" alt="Home page"></a>');
        $('.mainHeader').after('<div class="header_logo"><?php echo image_tag($roomUI['header-room-logo'], array('size' => (isset($roomUI['header-room-logo-size'])) ? $roomUI['header-room-logo-size']:'439x90'))?></div>');
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
<?php endif;?>
<div class="moncompte">
    <?php include_component('account', 'navigation', array()) ?>
        <div class="room">
            <table id="room_table">
                <tr>
                    <td style="vertical-align: top; width: 760px;">
                        <div class="view" style="margin-top: 4px; width: 760px;">
                            <div class="" style="margin-left: 8px;">
                            <?php include_component('room', 'header', array ('data'=>$dataRoom)) ?>
                            </div>
                            <?php include_component('room', 'tabsHome', array('numTab' => '3', 'id' => '3', 'roomUI' => $roomUI, 'tabs' => $dataTabs)) ?>
                            <?php include_component('interface', 'areaOneBegin') ?>
                            <div style="height: 30px;"></div>
                            
                            <div style="margin-left: -30px;">
	                            <div class="header-howto" style="border: none;<?php echo (isset($roomUI) && isset($roomUI['path-img-title-room-kups-ranking'])) ? "background: transparent url('".$roomUI['path-img-title-room-kups-ranking']."') left no-repeat;": "background: transparent url('/image/default/room/title_room_kups_ranking.png') left no-repeat;"; ?>">
							    		<?php echo __('CLASSEMENT GENERAL')?>
							    </div>
                            </div>
                            <div style="height: 20px;"></div>
                            <div id="room-kups-general-ranking"></div>
                            <div style="height: 50px;"></div>

                            <?php include_component('interface', 'areaOneEnd') ?>
                        </div>
                    </td>
                    <td style="vertical-align: top; width: 220px;">
                        <div style="padding-left: 5px; padding-top: 7px;">
                        <?php if (isset($roomUI) && $roomUI != '') { 
                        	include_component('room', 'right', array('needAdvancedAccount' => $needAdvancedAccount, 'roomUI' => $roomUI, 'dataRoom'=> $dataRoom,'uuid' => $dataRoom['uuid'], 'kups' => $kupsData)); 
                        } else { 
                        	include_component('room', 'right', array('needAdvancedAccount' => $needAdvancedAccount, 'dataRoom'=>$dataRoom));
                        }?>
                        </div>
                    </td>
                </tr>
            </table>
	</div>
</div>
<script type="text/javascript">
$(function() {
	loadGeneralRanking(0, 10);
});

function loadGeneralRanking(offset, batchSize) {
	var generalXhr = $.ajax({
			'url' : '<?php echo url_for(array('module' => 'room', 'action' => 'roomKupsGeneralRanking'))?>',
			'dataType' : 'html',
			'type' : 'post',
			'data' : {
				'room_uuid' : '<?php echo $room_uuid ?>',
				'offset' : offset,
				'batchSize' : batchSize,
				'room_data' : <?php echo json_encode($sf_data->getRaw('dataRoom'))?>
			},
			'beforeSend' : function() {
				$('#room-kups-general-ranking').loadingModal();
			}
		});

	generalXhr.done(function(datas) {
		$('#room-kups-general-ranking').loadingModal({'show' : false});
		$('#room-kups-general-ranking').html(datas);
	});
}

</script>
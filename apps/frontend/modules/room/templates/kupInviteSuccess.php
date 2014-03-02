<?php if (isset($roomUI)) :?>
<?php use_stylesheet('roomPerso.css') ?>
<?php endif; ?>
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
<div class="moncompte">
<?php include_component('account', 'navigation', array()) ?>
	<div class="room">
    	<table id="room_table">
        	<tr>
            	<td style="vertical-align: top; width: 760px;">
					<div class="view" style="margin-top: 4px;">
						<div style="margin: 0px; margin-left: 0px; margin-bottom: 17px;">
							<?php include_component('room', 'kupheader', array ('dataRoom'=> $roomData, 'kupData' => $kupData)) ?>
						</div>
						<?php include_component('kup', 'tabs', array('numTab' => '1', 'id' => '1', 'tabs' => $dataKupTabs, 'tab' => $tab)) ?>
						<?php include_component('interface', 'areaOneBegin', array('displayTop' => false)) ?>
						<div style="height: 26px;"></div>

						<?php if($tabInvite != 1) :?>
						<div style="margin-left: 540px; background: url('/images/interface/background/link.png') no-repeat; padding-left: 10px;">
							<a href="<?php echo url_for(array('module' => 'room', 'action' => 'kup', 'room_uuid' => $roomUuid, 'kup_uuid' => $kupUuid)); ?>" class="orange12">
								<?php echo __('text_kupinvite_back_to_prono'); ?>
							</a>
						</div>
						<div style="height: 26px;"></div>
			            <?php endif;?>

			            <?php if($tabInvite != 1) :?>
			            <div class="miser">
						    <div style="margin-bottom: 10px; width: 652px; margin-left: auto; margin-right: auto;">
						        <?php echo image_tag('/images/kup/view/mise/rootline3.png', array('size' => '652x39', 'style' => 'border: none;')) ?>
						    </div>
						</div>
						<?php else :?>
						<div style="margin-left:-31px;">
							<?php echo image_tag('/image/'.$sf_user->getCulture().'/invite/title_bar_challenge_friends.png', array('size' => '380x48', 'style' => 'border: none;')) ?>
							<div style="height: 20px;"></div>
						</div>
						<?php endif;?>
						<div style="height: 26px;"></div>
					    <div id="invite"></div>
					     <div style="height: 200px;"></div>
						<?php include_component('interface', 'areaOneEnd') ?>
					</div>
				</td>
				<td style="vertical-align: top; width: 220px;">
					<div style="padding-left: 5px; padding-top: 7px;">
						<?php if (isset($roomUI)): ?>
						<?php include_component('kup', 'right', array('kupData' => $kupData, 'roomUI' => $roomUI,'room_uuid' => $roomUuid, 'canInvite' => $canInvite)) ?>
						<?php else: ?>
						<?php include_component('kup', 'right', array('kupData' => $kupData, 'room_uuid' => $roomUuid, 'canInvite' => $canInvite)) ?>
						<?php endif ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<a href="javascript:void(0);" id="trigger_fb_publish" onclick="InvitePublishFacebook();"></a>
<script type="text/javascript">

<?php if(isset($is_room_kup_invite) && $is_room_kup_invite == 1 && $tabInvite != 1 && $sf_user->getAttribute('facebookId', '', 'subscriber') != '' && ($sf_user->getAttribute('predictions_ic', '', 'predictionsSave') != '' || $sf_user->getAttribute('predictions_se', '', 'predictionsSave') != '')) : ?>

var timer = setInterval("autoPublish()", 1000);
function autoPublish() {
	if(isFBLoaded) {
		clearInterval(timer);
		$('#trigger_fb_publish').trigger('click');
	}
}
function InvitePublishFacebook() {
	FB.ui({ method: 'feed', 
    	link: "<?php echo $urlShareFacebook ?>",
    	properties: <?php echo json_encode($sf_data->getRaw('publishProperties'))?>,
    	picture : 'https://www.betkup.fr<?php echo $publishImage ?>',
    	description: "<?php echo html_entity_decode($publishMsg) ?>"
    });
	return false;
}
<?php endif; ?>

$(function () {
	$.ajax({
	  	type: "GET",
	  	url: "<?php echo url_for(array('module' => 'invite', 'action' => 'index', 'room_uuid' => $roomUuid, 'kup_uuid' => $kupUuid)) ?>",
	  	success: function(data) {
			$('#invite').html(data);
	  	}
	});
});
</script>
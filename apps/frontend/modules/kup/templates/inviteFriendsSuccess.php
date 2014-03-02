<div class="moncompte">
	<?php include_component('account', 'navigation', array()) ?>
	<div class="room">
    	<table id="room_table">
        	<tr>
            	<td style="vertical-align: top; width: 760px;">
					<div class="view" style="margin-top: 15px;">
						<div class="" style="margin: 0px; margin-left: 0px; margin-bottom: 17px;">
			            	<?php include_component('kup', 'kupHeader', array('kupData' => $kupData)) ?>
						</div>
						<?php if($notInFlow == 1) :?>
							<?php include_component('kup', 'tabs', array('numTab' => '5', 'id' => '1', 'tabs' => $dataTabs)) ?>
						<?php else :?>
							<?php include_component('kup', 'tabs', array('numTab' => '1', 'id' => '1', 'tabs' => $dataTabs)) ?>
						<?php endif;?>
						<?php include_component('interface', 'areaOneBegin', array('displayTop' => false)) ?>
			            <div style="height: 26px;"></div>

						<?php if($notInFlow == 0) :?>
						<div style="margin-left: 540px; background: url('/images/interface/background/link.png') no-repeat; padding-left: 10px;">
							<a href="<?php echo url_for(array('module' => 'kup', 'action' => 'view', 'uuid' => $kupUuid)); ?>" class="orange12">
								<?php echo __('text_kupinvite_back_to_prono'); ?>
							</a>
						</div>
						<div style="height: 26px;"></div>
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
						<?php include_component('kup', 'right', array('kupData' => $kupData, 'kupNotInFlow' => $notInFlow)) ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<a href="javascript:void(0);" id="trigger_fb_publish" onclick="InvitePublishFacebook();"></a>
<script type="text/javascript">
<?php if($notInFlow == 0 && $kupUuid != 0 && $sf_user->getAttribute('facebookId', '', 'subscriber') != '' && ($sf_user->getAttribute('predictions_ic', '', 'predictionsSave') != '' || $sf_user->getAttribute('predictions_se', '', 'predictionsSave') != '')) : ?>

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
    	properties: html_entity_decode("<?php echo $publishProperties;?>"),
    	picture : 'https://www.betkup.fr<?php echo $kupData['ui']['vignette_edition_kup'] ?>',
       	description: html_entity_decode("<?php echo $publishMsg; ?>")
	});

	return false;
}

<?php endif; ?>
$(function () {	
	$.ajax({
		  type: "GET",
		  url: "<?php echo url_for(array('module' => 'invite', 'action' => 'index', 'kup_uuid' => $kupUuid, 'kup_data' => $kupData)) ?>",
		  success: function(data) {
			  $('#invite').html(data);
		  }
	});
});

$(window).bind("load",function(){
	var heightRightRoom = parseInt($('.rightroom').css('height'));
	var heightView = parseInt($('.view').css('height'));
	var heightDiff = heightRightRoom-heightView;

	if(heightDiff >= '0'){
		var goodHeight = heightDiff+90;
		$('#areaOneEnd_bottom').css('height',goodHeight);
	}
});
</script>

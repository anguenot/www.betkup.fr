<div class="row-fluid predictions-container">
	<div class="span1"></div>
	<div class="span10 span-prediction">
		<div class="next-lap">
			<div class="tdf-box-title">
				<h1>
				Prochaine course</h1>
				<?php include_component('facebook_tdf', 'chrono', array('kupData' => $kupData, 'chronoId' => 'next-race'))?>	
			</div>
			<div class="tdf-box-contents">
				<h1>
					<?php echo $kupData['name']?>
				</h1>
				<p class="step-date">
					<?php echo (isset($kupData['startDate'])) ? util::displayDateFormated($kupData['startDate']) : ''; ?>
				</p>
			</div>
		</div>
		<div class="predictions-lap">
			<div class="tdf-box-title">
				<h1>Vos pronostics</h1>
			</div>
			<div class="tdf-box-contents">
				<?php include_component('cycling', 'predictions', array(
										'kupData' => $kupData, 
										'kup_uuid' => $kup_uuid, 
										'room_uuid' => $room_uuid, 
										'redirect_url' => url_for('@facebook_tdf_predictions_save?is_saved=1'))) ?>
			</div>
		</div>
	</div>
	<div class="span1"></div>
</div>
<a href="javascript:void(0);" onclick="multiFriendSelector();" id="sendRequests">&nbsp;</a>
<?php if($is_saved) :?>
<script type="text/javascript">
var predictionsTimer;
$(function() {
	predictionsTimer = setInterval("inviteFriends()", 400);
});

function inviteFriends() {
	if(isFBLoaded) {
		$('#sendRequests').trigger('click');
	}
}

function multiFriendSelector() {
	if(isFBLoaded) {
		FB.ui({method: 'apprequests',
			title: html_entity_decode("<?php echo $titleInviteRequest ?>"),
	    	message: html_entity_decode("<?php echo $messageInviteRequest?>")
	  	}, function() {publishFacebook();});
	  	clearInterval(predictionsTimer);
	}
}
function publishFacebook() {
	if(isFBLoaded) {

		FB.ui({ method: 'feed', 
	        	link: "<?php echo $urlToPublish ?>",
	        	picture: 'https://www.betkup.fr<?php echo $kupData['ui']['vignette_edition_kup'] ?>',
	        	properties: <?php echo json_encode($sf_data->getRaw('publishProperties'))?>,
	        	description: html_entity_decode('<?php echo $publishMessage ?>')
	    });
	}
    return false;
}


</script>
<?php endif; ?>
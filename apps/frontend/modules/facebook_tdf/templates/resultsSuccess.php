<div class="row-fluid">
	<div class="span1"></div>
	<div class="span10 span-results">
		<div class="br-big"></div>
		<div class="fix-margin">
			<?php include_component('cycling', 'results', array(
                                    'room_uuid' => $room_uuid,
                                    'roomKups' => $roomKups,
                                    'customRoundUrl' => url_for('@facebook_tdf_results'))) ?>
		</div>
	</div>
	<div class="span1"></div>
</div>
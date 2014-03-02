<table class="ranking-table">
	<tbody>
		<tr>
			<td>
				<div id="ranking-view">
				<?php include_component('facebook_f1_sport24', 'ranking',
				array(
					'kup_uuid' => $kup_uuid,
					'room_uuid' => $room_uuid,
					'rankingData' => $rankingData,
					'offset' => $offset,
					'batchSize' => $batchSize,
					'kupData' => $kupData,
					'friendsOnly' => false,
					'nbPlayers' => $rankingData['totalMembers'],
					'memberPosition' => $rankingData['memberPosition'],
					'tabActive' => $selectedTab,
					'isRoomRanking' => $isRoomRanking))
				?>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div id="general"></div>
				<div id="ranking-wall"></div>
			</td>
		</tr>
	</tbody>
</table>
<script type="text/javascript">
$(function() {
	var fbComments = '<div class="fb-comments" data-href="<?php echo $urlFbCommentRanking;?>" data-num-posts="10" data-width="730"></div>';
	$('#ranking-wall').html(fbComments);
	FB.XFBML.parse(document.getElementById('ranking-wall'));
});
</script>

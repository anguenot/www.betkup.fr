<table>
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
					'friendsOnly' => true,
					'nbPlayers' => $rankingData['totalFriends'],
					'memberPosition' => $rankingData['friendsMemberPosition'],
					'tabActive' => $selectedTab,
					'isRoomRanking' => $isRoomRanking))
				?>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div id="friends"></div>
				<div id="ranking-wall"></div>
			</td>
		</tr>
	</tbody>
</table>

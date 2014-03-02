<table class="room-kups-general-ranking-table">
	<thead>
		<tr>
			<th colspan="3" class="table-player">
			Joueur</th>
			<th class="table-point">
			Nb de points</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0; foreach ($roomRanking as $ranking): ?>
		<?php if(isset($ranking['position'])) :?>
		<tr class="<?php echo $i%2 == 1 ? 'odd' : 'even' ?>">
			<td class="member-position">
				<?php echo isset($ranking['position']) ? $ranking['position'] : '-'?>
			</td>
			<td class="member-avatar">

                <?php include_component('interface', 'userAvatar', array(
                                                                        'alt'        => isset($ranking['member']['nickName']) ? $ranking['member']['nickName'] : '-',
                                                                        'avatarPath' => $ranking['member']['avatarBig'],
                                                                        'canvasSize' => '50x50',
                                                                        'wAnimateTo' => '150',
                                                                        'hAnimateTo' => '150',
                                                                        'class' => 'ranking-room-kup-avatar',
                                                                        'id' => $ranking['position']
                                                                   )) ?>
			</td>
			<td class="member-nickname">
				<?php echo isset($ranking['member']['nickName']) ? $ranking['member']['nickName'] : '-'?>
			</td>
			<td class="member-point">
				<?php echo isset($ranking['value']) ? $ranking['value'].' pts' : '-'?>
			</td>
		</tr>
		<?php endif; ?>
		<?php $i++; endforeach;?>
	</tbody>
</table>
<a class="member-position-link" href="javascript:void(0);">
	Accéder à mon classement
</a>
<div class="pager">
<?php if($totalRanking > $batchSize) :?>
	<?php include_component('interface', 'pagination', array(
			'totalKups' => $totalRanking,
			'offset' => $offset,
			'batchSize' => $batchSize,
			'functionKupsLoad' => 'loadGeneralRanking'
	))?>
<?php endif;?>
</div>

<script type="text/javascript">
$(function() {
	$('.member-position-link').click(function() {
	loadGeneralRanking('<?php echo $offsetMemberRanking ?>', '<?php echo $batchSize?>');
	});
});
</script>
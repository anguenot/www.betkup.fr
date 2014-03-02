<div id="ranking">
	<div class="title-box">
	<h2 class="title2">
	<?php echo __('title_facebook_f1_ranking')?>
	</h2>
	</div>
	<div class="content-box content-box-left">
		<table>
			<thead></thead>
			<tbody>
				<tr>
					<td class="td-box-top">
						<div class="ranking-box-top box-left">
							<h2>
							<?php echo __('text_facebook_sport24_home_ranking_general')?>
							</h2>
							<div class="ranking-div">
								<h3>
								<?php echo isset($generalRanking['memberPosition']) ? $generalRanking['memberPosition'].'<sup>e</sup>' : '-'?>
								</h3>
								<p>
								<?php echo __('text_facebook_sport24_home_ranking_on')?>
								<?php echo isset($generalRanking['totalMembers']) ? $generalRanking['totalMembers'] : '-'?>
								</p>
							</div>
						</div>
					</td>
					<td class="td-box-top">
						<div class="ranking-box-top box-right">
							<h2>
							<?php echo __('text_facebook_sport24_home_ranking_friends')?>
							</h2>
							<div class="ranking-div">
								<h3>
								<?php echo isset($friendsRanking['friendsMemberPosition']) ? $friendsRanking['friendsMemberPosition'].'<sup>e</sup>' : '-'?></h3>
								<p>
								<?php echo __('text_facebook_sport24_home_ranking_on')?>
								<?php echo isset($friendsRanking['totalFriends']) ? $friendsRanking['totalFriends'] : '-'?>
								</p>
							</div>
						</div>
					</td>
				</tr>
				<tr> 
					<td colspan="2" class="td-ranking-box">
						<div class="ranking-box">
							<h2>
							<?php echo __('text_facebook_sport24_home_ranking_my_friends')?>
							</h2>
							<table>
								<thead></thead>
								<tbody>
									<tr>
									    <?php foreach ($friendsRanking as $kupRankingData): ?>
     									<?php if (isset($kupRankingData['member'])): ?>
										<td>
											<div class="box-rank">
												<h4><?php echo $kupRankingData['position'] ?><sup><?php echo $kupRankingData['position'] == 1 ? 'er' : 'ème' ?></sup></h4>
												<p><?php echo image_tag($kupRankingData['member']['avatarSmall'] != '' ? $kupRankingData['member']['avatarSmall'] : '/image/default/member/avatar/default_small.png', array('alt' => '', 'size'=>'40x40') ) ?></p>
												<p><?php echo $kupRankingData['value'] ?></p>
											</div>
										</td>
										<?php endif ?>
										<?php endforeach ?>
										<td>
											<div class="box-rank challenge-box">
												<h4>&nbsp;</h4>
												<p><?php echo image_tag('/image/fr/sport24/avatar/default_fb_avatar.jpg', array('alt' => '', 'size'=>'40x40') ) ?></p>
												<p>
												<a href="javascript:void(0);" onclick="sendRequestViaMultiFriendSelector();">
												<?php echo __('text_facebook_sport24_home_ranking_challenge_friends')?>
												</a>
												</p>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<a href="<?php echo url_for(array('module' => 'facebook_f1_sport24', 'action' => 'ranking'))?>">
							<?php echo __('text_facebook_sport24_home_ranking_all_ranking')?>
							</a>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="button-box">
		<a href="javascript:void(0);" onclick="sendRequestViaMultiFriendSelector();">
		<?php echo __('text_facebook_sport24_home_ranking_invite_friends')?>
		</a>
	</div>
</div>
<script type="text/javascript">
function sendRequestViaMultiFriendSelector() {
	
	FB.ui({method: 'apprequests',
		title: html_entity_decode("<?php echo $titleInviteRequest ?>"),
    	message: html_entity_decode("<?php echo $messageInviteRequest?>")
  	}, requestCallback);
}

function requestCallback() {

}
</script>
<div class="footer">
	<div class="row-fluid row-footer">
		<div class="span1"></div>
		<div class="span3">
			<table>
				<tbody>
					<tr>
						<td>
							<div class="footer-play"></div>
						</td>
						<td>
							<a href="javascript:void(0);" onclick="sendRequestViaMultiFriendSelector();">
								Inviter des amis
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="span3">
			<div class="fb-like" data-href="<?php echo sfConfig::get('app_facebook_betkup_page_url')?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true" data-font="lucida grande"></div>
		</div>
		<div class="span2">
			<table>
				<tbody>
					<tr>
						<td>
							<div class="footer-play"></div>
						</td>
						<td>
							<a href="https://www.facebook.com/betkup/app_46468144668" target="_blank">Feedback</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="span2">
			<table>
				<tbody>
					<tr>
						<td>
							<div class="footer-play"></div>
						</td>
						<td>
							<a href="<?php echo sfConfig::get('app_facebook_betkup_page_url')?>" target="_blank">Forum</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="span1"></div>
	</div>
</div>
<script type="text/javascript">
function sendRequestViaMultiFriendSelector() {
	if(isFBLoaded) {
		FB.ui({method: 'apprequests',
			title: html_entity_decode("<?php echo $titleInviteRequest ?>"),
	    	message: html_entity_decode("<?php echo $messageInviteRequest?>")
	  	}, function() {});
	}
}
</script>
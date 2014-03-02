<div id="footer">
	<table>
		<tbody>
			<tr>
				<td>
					<a href="javascript:void(0);" onclick="sendRequestViaMultiFriendSelector();">
						Inviter des amis
					</a>
				</td>
				<td>
					<div class="fb-like" data-href="https://www.facebook.com/sport24fr" data-send="false" data-layout="button_count" data-width="80" data-show-faces="false"></div>
				</td>
				<td>
					<a href="https://www.facebook.com/betkup" target="_blank">
						Feedback
					</a>
				</td>
				<td>
					<a href="https://www.facebook.com/sport24fr" target="_blank">
						Forum
					</a>
				</td>
			</tr>
		</tbody>
	</table>
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
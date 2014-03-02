<script type="text/javascript">
function loadFacebookTotalPoints() {
	/*
	var test = '<div class="fb-like" data-href="<?php echo $urlFacebook; ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>';
	$('#total-point-facebook').append(test);
	FB.XFBML.parse(document.getElementById('total-point-facebook'));
	*/
}
</script>
<div id="results-total-point">
	<table>
		<tr>
			<td>TOTAL</td>
			<td><span><?php echo $totalPoints; ?> points</span></td>
			<td id="total-point-facebook">
			</td>
		</tr>
	</table>
</div>
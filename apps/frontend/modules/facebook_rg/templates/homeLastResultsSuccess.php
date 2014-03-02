<div id="last-results">
	<div class="title-box">
		<h2 class="title2">
		<?php echo __('text_last_results_title')?>
		</h2>
	</div>
	<div class="content-box content-box-left">
		<table class="last-result-table">
			<thead>
				<tr>
					<th class="left">
						<h3><?php echo $kupData['name']?></h3>
					</th>
					<th class="right">
						<form id="last_results_filter_form">
							<select id="last_results_filter" name="last_results_filter">
								<option value="0" selected="selected">
								<?php echo __('text_last_results_general')?>
								</option>
								<option value="1">
								<?php echo __('text_last_results_friends')?>
								</option>
							</select>
						</form>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr class="title-challenge">
					<td class="left">
						<h3>
						<?php echo __('text_last_results_challenge')?>
						</h3>
					</td>
					<td class="right">
						<h3>
						<?php echo __('text_last_results_points')?>
						</h3>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div id="tr-last-results"></div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="height: 10px;"></div>
</div>
<script type="text/javascript">
$(function() {
	var offset = 0, batchSize = 4;

	$('#last_results_filter').selectmenu({
		style:'dropdown', 
		width: 160,
		menuWidth: 160
	});
	
	$('#last_results_filter').change(function() {
		loadLastResults(offset, batchSize);
	});
	loadLastResults(offset, batchSize);
});
function loadLastResults(offset, batchSize) {
	var filter = $('#last_results_filter_form').serializeObject();
	
	$('#tr-last-results').loadContent({
		'url' : '<?php echo url_for(array('module' => 'facebook_f1_sport24', 'action' => 'lastResults'))?>',
    	'method' : 'GET',
    	'data' : {
        	"kup_uuid" : "<?php echo $kup_uuid?>", 
        	"room_uuid" : "<?php echo $room_uuid?>", 
        	"offset" : offset,
        	"batchSize" : batchSize,
        	"filter" : filter
        }
	});
}
</script>
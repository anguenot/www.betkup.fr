<?php use_stylesheet('tennis/count-down.css')?>
<div class="prediction" align="left">
    <div class="view" style="width: 710px;">
		<div id="count-down" >
			<table id="count-down-table">
				<tr>
					<td>
					</td>
					<td>
						<p>
							Le programme sera connu en fin de journée. Revenez pronostiquer avant :	
						</p>
					</td>
				</tr>
			</table>
			<div id="count-down-chrono">
				<div id="chrono">
					<table>
						<thead>
							<tr>
								<th id="chrono-count-down-1">00</th>
								<th id="chrono-count-down-2">00</th>
								<th id="chrono-count-down-3">00</th>
								<th id="chrono-count-down-4">00</th>
							</tr>
						</thead>
						<tbody>
							<tr class="line-infos">
								<td>jours</td>
								<td>h</td>
								<td>m</td>
								<td>s</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function() {
	var refreshId_1 = setInterval(function() {
	    var arrayResultat1 = returnChronoPART1('<?php echo $kupData['startDate']; ?>', '<?php echo $kupData['status'] ?>');
	    $('#chrono-count-down-1').html(arrayResultat1[0]);
	    $('#chrono-count-down-2').html(arrayResultat1[1]);
	    $('#chrono-count-down-3').html(arrayResultat1[2]);
	    $('#chrono-count-down-4').html(arrayResultat1[3]);
	}, 1000);
});
</script>
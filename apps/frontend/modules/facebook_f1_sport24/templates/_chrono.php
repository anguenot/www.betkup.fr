<div id="chrono">
	<table>
		<thead>
			<tr>
				<th id="chrono-<?php echo $chronoId?>-1">00</th>
				<th id="chrono-<?php echo $chronoId?>-2">00</th>
				<th id="chrono-<?php echo $chronoId?>-3">00</th>
				<th id="chrono-<?php echo $chronoId?>-4">00</th>
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
<script type="text/javascript">
$(function() {
	var refreshId_1 = setInterval(function() {
	    var arrayResultat1 = returnChronoPART1('<?php echo $kupData["startDate"]; ?>', '<?php echo $kupData["status"] ?>');
	    $('#chrono-<?php echo $chronoId?>-1').html(arrayResultat1[0]);
	    $('#chrono-<?php echo $chronoId?>-2').html(arrayResultat1[1]);
	    $('#chrono-<?php echo $chronoId?>-3').html(arrayResultat1[2]);
	    $('#chrono-<?php echo $chronoId?>-4').html(arrayResultat1[3]);
	}, 1000);
});
</script>
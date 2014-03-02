<div class="chrono">
 	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td><div class="chrono1" id="nextRaceChronoPart1"></div></td>
		<td><div class="chrono2" id="nextRaceChronoPart2"></div></td>
		<td><div class="chrono3" id="nextRaceChronoPart3"></div></td>
		<td><div class="chrono4" id="nextRaceChronoPart4"></div></td>
		</tr>
	</table>
</div>
<script language="Javascript">
var refreshId_1 = setInterval(function() {
    var arrayResultat = returnChronoPART1('<?php echo $date ?>');
    $('#nextRaceChronoPart1').delay(1000).text(arrayResultat[0]);
    $('#nextRaceChronoPart2').delay(1000).text(arrayResultat[1]);
    $('#nextRaceChronoPart3').delay(1000).text(arrayResultat[2]);
    $('#nextRaceChronoPart4').delay(1000).text(arrayResultat[3]);
}, 1000);
</script>
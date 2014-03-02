<div class="moncompte">
	<?php include_component('account', 'navigation', array()) ?>
	<div class="room">
    	<table id="room_table">
       		<tr>
            	<td style="vertical-align: top; width: 760px;">
					<div class="view" style="margin-top: 15px;">
						<div style="margin: 0px; margin-left: 0px; margin-bottom: 17px;">
			            	<?php include_component('kup', 'kupHeader', array('kupData' => $kupData)) ?>
						</div>
						<?php include_component('kup', 'tabs', array('numTab' => '1', 'id' => '1', 'tabs' => $dataTabs)) ?>
						<?php include_component('interface', 'areaOneBegin', array('displayTop' => false)) ?>
			            	<div style="height: 26px;"></div>
			                <?php include_component('kup', 'kupBet',
			                    array('kupData' => $kupData,
			                		  'predictions_ic' => $predictions_ic,
			                          'predictions_se' => $predictions_se,
			                	      'predictions_q' => $predictions_q,
			                          )); ?>
			                <div style="height: 200px;"></div>
						<?php include_component('interface', 'areaOneEnd') ?>
					</div>
				</td>
				<td style="vertical-align: top; width: 220px;">
					<div style="padding-left: 5px; padding-top: 7px;">
						<?php include_component('kup', 'right', array('kupData' => $kupData)); ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<script type="text/javascript">
$(function() {
	var heightRightRoom = parseInt($('.rightroom').css('height'));
	var heightView = parseInt($('.view').css('height'));
	var heightDiff = heightRightRoom-heightView;

	if(heightDiff >= '0'){
		var goodHeight = heightDiff+90;
		$('#areaOneEnd_bottom').css('height',goodHeight);
	}
});
</script>
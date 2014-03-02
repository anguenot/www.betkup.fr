<div class="moncompte">
	<?php include_component('account', 'navigation', array()) ?>
	<div class="room">
    	<table id="room_table">
        	<tr>
            	<td style="vertical-align: top; width: 760px;">
					<div class="view" style="margin-top: 15px;">
						<div class="" style="margin: 0px; margin-left: 0px; margin-bottom: 17px;">
							<?php include_component('kup', 'kupHeader', array('kupData' => $kupData)) ?>
						</div>
						<?php include_component('kup', 'tabs', array('numTab' => '1', 'id' => '1', 'tabs' => $dataTabs, 'tab' => $tab)) ?>
						<?php include_component('interface', 'areaOneBegin', array('displayTop' => false)) ?>
							<div style="height: 30px;"></div>
							<?php include_component(
								$predictions_view_module, $predictions_view_component,
							    array(
							    	'kup_uuid' => $uuid,
							    	'kupData' => $kupData,
								)) ?>
							<div style="height: 60px;"></div>
						<?php include_component('interface', 'areaOneEnd') ?>
					</div>
				</td>
				<td style="vertical-align: top; width: 220px;">
					<div style="padding-left: 5px; padding-top: 7px;">
						<?php include_component('kup', 'right', array('kupData' => $kupData)) ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<table style="border-spacing: 0px; border-collapse: collapse;">
	<?php foreach ($kupsData as $kups):?>
		<tr>
			<?php include_component('kup', 'kupThumbnail', array('parentModule' => $parentModule, 'kups' => $kups, 'isInsideRoom' => $isInsideRoom, 'nbLine' => $nbLine, 'nbDisplay' => $nbDisplay, 'room_uuid' => $uuid, 'roomUI'=> $roomUI)); ?>
		</tr>
	<?php endforeach; ?>
</table>
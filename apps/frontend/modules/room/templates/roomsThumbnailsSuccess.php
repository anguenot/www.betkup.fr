<table style="border-spacing: 0px; border-collapse: collapse;">
	<?php foreach ($roomData as $rooms):?>
		<tr>
			<?php include_component('room', 'roomThumbnail', array('parentModule' => $parentModule, 'rooms' => $rooms, 'nbLine' => $nbLine, 'nbDisplay' => $nbDisplay, 'roomUI'=> $roomUI)); ?>
		</tr>
	<?php endforeach; ?>
</table>
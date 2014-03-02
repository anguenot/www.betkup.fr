<table style="border-spacing: 0px; border-collapse: collapse;">
	<?php foreach ($roomData as $rooms) :?>
		<tr>
			<?php include_component('room', 'roomThumbnailSearch', array('roomData' => $rooms)); ?>
		</tr>
	<?php endforeach; ?>
</table>
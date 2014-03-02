<h3><?php echo __('text_search_room', array('%rooms%' => $displayRooms, '%total%' => $totalRooms)) ?></h3>
<br />
<table style="border-spacing: 0px; border-collapse: collapse;">
	<?php foreach ($roomData as $rooms) :?>
		<tr>
			<?php include_component('room', 'roomThumbnailSearch', array('roomData' => $rooms)); ?>
		</tr>
	<?php endforeach; ?>
</table>
<?php if($totalRooms > $batchSize) :?>
<div class="paging">
<table>
	<tbody>
		<tr>
			<?php if($offset > 0) :?>
			<td>
				<a class="first" href="javascript:void(0);" onclick="loadRooms('0', '<?php echo $batchSize ?>')"></a>
			</td>
			<td>
				<a class="back" href="javascript:void(0);" onclick="loadRooms('<?php echo ($offset-$batchSize)?>', '<?php echo $batchSize ?>')"></a>
			</td>
			<?php endif; ?>
			<?php for($i=0; $i<$pagerSize; $i++) :?>
				<?php 
				$prev = 2;
				$next = 3;
				if($offset == 0) {
					$next = 5;
				} elseif($offset/$batchSize == 1) {
					$next = 4;
				} ?>
				<?php if($i == round($offset/$batchSize)-$next) :?>
				<td>
					<a class="points" href="javascript:void(0);"></a>
				</td>
				<?php elseif($i >= round($offset/$batchSize)-$prev && $i < round($offset/$batchSize)+$next):  ?>
				<td>
					<a class="page <?php echo ($i == round($offset/$batchSize)) ? 'page-on' : 'page-off' ?>" href="javascript:void(0);" onclick="loadRooms('<?php echo ($i*$batchSize) ?>', '<?php echo $batchSize ?>')">
					<?php echo $i+1?>
					</a>
				</td>
				<?php elseif($i==round($offset/$batchSize)+$next) :?>
				<td>
					<a class="points" href="javascript:void(0);"></a>
				</td>
				<?php endif;?>
			<?php endfor;?>
			<?php if($offset <= (($pagerSize - 1)*$batchSize)) :?>
			<td>
				<a class="next" href="javascript:void(0);" onclick="loadRooms('<?php echo ($offset+$batchSize)?>', '<?php echo $batchSize ?>')"></a>
			</td>
			<td>
				<a class="last" href="javascript:void(0);" onclick="loadRooms('<?php echo floor(($pagerSize - 1)*$batchSize)?>', '<?php echo $batchSize ?>')"></a>
			</td>
			<?php endif; ?>
		</tr>
	</tbody>
</table>
</div>
<?php endif;?>
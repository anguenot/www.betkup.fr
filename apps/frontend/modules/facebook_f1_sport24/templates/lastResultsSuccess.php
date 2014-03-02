<?php if($offset > 0) :?>
<div class="arrow-container">
	<a href="javascript:void(0);" id="arrow-up" class="arrow">
		<?php echo image_tag('/image/default/f1/interface/arrow_up.png', array('size' => '15x9'))?>
	</a>
</div>
<?php endif;?>
<div id="reusults-container">
	<table>
		<tbody>
			<?php foreach($challengers as $challenger) :?>
			<tr class="line">
				<td class="avatar">
				<?php echo isset($challenger['avatar']) && $challenger['avatar'] != '' ? 
					image_tag($challenger['avatar'], array('size' => '30x30')) : 
					image_tag('/image/default/member/avatar/default_small.png', array('size' => '30x30'))?>
				</td>
				<td class="picto">
					<table class="table-picto">
						<tr>
							<td>
								<?php echo image_tag('/image/default/sport24/start_picto.png', array('size' => '40x21'))?>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo image_tag('/image/default/sport24/podium_picto.png', array('size' => '40x21'))?>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo image_tag('/image/default/sport24/chrono_picto.png', array('size' => '14x20'))?>
							</td>
						</tr>
					</table>
				</td>
				<td class="challenge">
					<div class="line-results">
						<p>
						<?php echo __('text_last_results_qualifications')?>
						</p>
					</div>
					<div class="line-results">
						<p>
						<?php echo __('text_last_results_gp')?>
						</p>
					</div>
					<div class="line-results">
						<p>
						<?php echo __('text_last_results_best_lap')?>
						</p>
					</div>
				</td>
				<td class="points">
					<div class="line-results">
						<p><?php echo $challenger['qualifications']?>pts</p>
					</div>
					<div class="line-results">
						<p><?php echo $challenger['gp']?>pts</p>
					</div>
					<div class="line-results">
						<p><?php echo $challenger['best-lap']?>pts</p>
					</div>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>
<?php if($offset < ($totalChallengers-$batchSize)) :?>
<div class="arrow-container">
	<a href="javascript:void(0);" id="arrow-down" class="arrow">
		<?php echo image_tag('/image/default/f1/interface/arrow_down.png', array('size' => '15x9'))?>
	</a>
</div>
<?php endif;?>
<script type="text/javascript">
$(function() {
	$('#arrow-up').click(function() {
		loadLastResults('<?php echo $offset-$batchSize ?>', '<?php echo $batchSize?>');
	});
	
	$('#arrow-down').click(function() {
		loadLastResults('<?php echo $offset+$batchSize ?>', '<?php echo $batchSize?>');
	});
});
</script>
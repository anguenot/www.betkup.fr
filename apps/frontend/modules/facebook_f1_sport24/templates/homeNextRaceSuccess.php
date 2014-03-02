<div id="next-race">
	<div class="title-box">
	<h2 class="title2">
		<?php echo __('title_facebook_f1_next_race')?>
	</h2>
	<?php include_component('facebook_f1_sport24', 'chrono', array('kupData' => $kupData, 'chronoId' => 'next-race'))?>
	</div>
	<div class="content-box content-box-left">
		<table>
			<thead>
				<tr>
					<th colspan="2">
						<h2>
						<?php echo (isset($kupData['name'])) ? strtoupper($kupData['name']) : '';?>
						</h2>
						<div class="social-box">
							<div class="fb-like" data-href="<?php echo $urlLike;?>" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td rowspan="5" class="circuit">
					<?php echo image_tag('/image/default/sport24/race.png', array("size" => "250x170"))?>
					</td>
					<td class="border-bottom">
						<p>
						<?php echo __('text_facebook_f1_next_race_date')?>
						</p>
						<h4>
						<?php echo (isset($kupData['startDate'])) ? util::displayDateFormated($kupData['startDate']) : ''; ?>
						</h4>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="border-bottom">
						<p>
						<?php echo __('text_facebook_f1_next_race_name')?>
						</p>
						<h4><?php echo __($kupData['name']) ?></h4>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="border-bottom">
						<p>
						<?php echo __('text_facebook_f1_next_race_round')?>
						</p>
						<h4>57</h4>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<p>
						<?php echo __('text_facebook_f1_next_race_size')?>
						</p>
						<h4>5,412km</h4>
					</td>
				</tr>
			</tbody>
		</table>
		<div style="height: 40px;"></div>
		<div class="button-box">
			<a href="<?php echo url_for(array('module' => 'facebook_f1_sport24', 'action' => 'predictions'))?>">
			<?php echo __('link_facebook_f1_next_race_predictions')?>
			</a>
		</div>
	</div>
	<div style="height: 10px;"></div>
</div>
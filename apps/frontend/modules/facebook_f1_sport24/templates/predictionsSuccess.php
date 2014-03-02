<div id="contents">
	<div style="height: 10px;"></div>
	<div id="predictions-module">
		<div class="title-box">
			<h2 class="title2">
				<?php echo __('title_facebook_f1_next_race')?>
			</h2>
			<?php include_component('facebook_f1_sport24', 'chrono', array('kupData' => $kupData, 'chronoId' => 'next-race'))?>
		</div>
		<div style="height: 20px;"></div>
		<div id="kup-name">
			<table>
				<tbody>
					<tr>
						<td>
						<?php echo (isset($kupData['ui']['flag'])) ? image_tag($kupData['ui']['flag'], array('size' => '46x33')) : '' ?>
						
						</td>
						<td>
							<h2>
							<?php echo $kupData['name'] ?>
							</h2>
						</td>
						<td>
							<h4>
							<?php echo (isset($kupData['startDate'])) ? util::displayDateFormated($kupData['startDate']) : ''; ?>
							</h4>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="height: 20px;"></div>
		<div class="title-box">
			<h2 class="title2">
				<?php echo __('title_facebook_f1_your_predictions')?>
			</h2>
		</div>
		
		<?php include_component('f1', 'predictions',
		    array(
		    	'kup_uuid' => $kup_uuid,
		    	'room_uuid' => $room_uuid,
		    	'kupData' => $kupData,
		    	'roomUI' => $roomUI,
		    	'urlToPublish' => 'https://apps.facebook.com/'.sfConfig::get('mod_facebook_f1_sport24_facebook_canvas_ns').'/predictions'
			)
		);
		?>
	</div>
	<div style="height: 10px;"></div>
	<div id="prediction-promo">
		<div class="title-box">
		<h2 class="title2">
		<?php echo __('text_facebook_f1_sport24_title_betkup_promo')?>
		</h2>
		<?php echo image_tag('/image/default/sport24/betkup_hover.png', array('class' => 'news-logo', 'height' => '25'))?>
		</div>
		<div id="promo-container">
		<a href="https://www.betkup.fr?PARTNER=1539351" target="_blank">
			<?php echo image_tag('/image/'.$sf_user->getCulture().'/sport24/home_promo/box_promo_large.png', array('size' => '719x110'))?>
		</a>
		</div>
	</div>
	<div style="height: 10px;"></div>
	<div id="rules">
		<div class="title-box">
			<h2 class="title2">
				<?php echo __('title_facebook_f1_predictions_rules_title')?>
			</h2>
		</div>
		<?php if(isset($includeRules)) :?>
		<?php include_component($includeRules[0], $includeRules[1], array('kupData' => $kupData)) ?>
		<?php endif;?>
	</div>
</div>
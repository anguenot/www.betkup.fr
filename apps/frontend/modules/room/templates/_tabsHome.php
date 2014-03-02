<?php $rawTabs = $sf_data->getRaw('tabs'); ?>
<div class="room_tabbar">
	<div style="margin: 0px; padding: 0px; height: 4px;"></div>
	<table style="border-collapse:collapse; border-spacing: 0;">
		<tr>
			<?php if(isset($rawTabs["tab1"])) :?>
			<td style="text-align: left; vertical-align: top; width: <?php echo ($numTab==1 ? '146px':'142px') ?>; height: 46px;">
				<div class="<?php echo ($numTab==1 ? 'tabs-on' : 'tabs-off') ?>"
				onclick="document.location.href='<?php echo url_for($rawTabs["tab1"]["link"]) ?>'">
					<table style="border-collapse:collapse; border-spacing: 0; height: 46px; margin: 0px auto 0px auto;">
						<tr>
							<td style="text-align: center; vertical-align: middle; width: 35px;">
								<?php echo image_tag('/image/default/room/tabbar/home_'.($numTab==1?'on':'off').'.png', array('class' => 'tab-image', 'alt' => __('label_room_tabbar_item1'), 'size' => '21x19')) ?>
							</td>
							<td style="text-align: left; vertical-align: middle;">
								<a href="<?php echo url_for($rawTabs["tab1"]["link"]) ?>" class="<?php echo ($numTab==1?'on':'off') ?>">
									<?php echo $rawTabs["tab1"]["label"] ?>
								</a>
							</td>
						</tr>
					</table>
				</div>
			</td>
			<?php endif; ?>
			<?php if(isset($rawTabs["tab2"])) :?>
				<?php if(isset($roomUI) && isset($roomUI['isChallenge']) && $roomUI['isChallenge'] == 1) :?>
				<?php else :?>
				<td style="text-align: left; vertical-align: top; width: <?php echo ($numTab==2 ? '146px':'142px') ?>; height: 46px;">
					<div class="<?php echo ($numTab==2 ? 'tabs-on' : 'tabs-off') ?>"
					onclick="document.location.href='<?php echo url_for($rawTabs["tab2"]["link"]) ?>'">
						<table style="border-collapse:collapse; border-spacing: 0; height: 46px; margin: 0px auto 0px auto;">
							<tr>
								<td style="text-align: center; vertical-align: middle; width: 35px;">
									<?php echo image_tag('/image/default/room/tabbar/kup_'.($numTab==2?'on':'off').'.png', array('class' => 'tab-image', 'alt' => __('label_room_tabbar_item2'), 'size' => '18x20')) ?>
								</td>
								<td style="text-align: left; vertical-align: middle;">
									<a href="<?php echo url_for($rawTabs["tab2"]["link"]) ?>" class="<?php echo ($numTab==2?'on':'off') ?>">
										<?php echo $rawTabs["tab2"]["label"] ?>
									</a>
								</td>
							</tr>
						</table>
					</div>
				</td>
				<?php endif;?>
			<?php endif;?>
			<?php if(isset($rawTabs["tab3"])) :?>
			<td style="text-align: left; vertical-align: top; width: <?php echo ($numTab==3 ? '146px':'142px') ?>; height: 46px;">
				<div class="<?php echo ($numTab==3 ? 'tabs-on' : 'tabs-off') ?>"
				onclick="document.location.href='<?php echo url_for($rawTabs["tab2"]["link"]) ?>'">
					<table style="border-collapse:collapse; border-spacing: 0; height: 46px; margin: 0px auto 0px auto;">
						<tr>
							<td style="text-align: center; vertical-align: middle; width: 35px;">
								<?php echo image_tag('/image/default/room/tabbar/kup_'.($numTab==3?'on':'off').'.png', array('class' => 'tab-image', 'alt' => __('label_room_tabbar_item2'), 'size' => '18x20')) ?>
							</td>
							<td style="text-align: left; vertical-align: middle;">
								<a href="<?php echo url_for($rawTabs["tab3"]["link"]) ?>" class="<?php echo ($numTab==3?'on':'off') ?>">
									<?php echo $rawTabs["tab3"]["label"] ?>
								</a>
							</td>
						</tr>
					</table>
				</div>
			</td>
			<?php endif;?>
		</tr>
	</table>
</div>
<script type="text/javascript">
$(function() {
	$('.tabs-off').hover(function() {
		var src = $(this).find('.tab-image').attr('src');
		var splitSrc = src.split('_');
		var srcPrefix = splitSrc[0];
		$(this).find('.tab-image').attr('src', srcPrefix+'_on.png');
		$(this).find('a').css('color', '#6A6A69');
		
	}, function() {
		var src = $(this).find('.tab-image').attr('src');
		var splitSrc = src.split('_');
		var srcPrefix = splitSrc[0];
		$(this).find('.tab-image').attr('src', srcPrefix+'_off.png');
		$(this).find('a').css('color', '#F28A31');
	});
});
</script>
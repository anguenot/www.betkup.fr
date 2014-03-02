<?php $rawTabs = $sf_data->getRaw('tabs'); ?>
<div class="room_tabbar" style="margin: 0px; padding: 0px; width: 769px; height: 50px; background: url('/image/default/room/tabbar/background_item<?php echo $numTab ?>.png');">
	<div style="margin: 0px; padding: 0px; height: 4px;"></div>
	<table style="border-collapse:collapse; border-spacing: 0; margin-left: 13px;">
	<tr>
	<td align="center" valign="middle" width="141" height="38">
		<table style="border-collapse:collapse; border-spacing: 0;">
		<tr>
			<td align="left" valign="middle" width="22">
				<?php echo image_tag('/image/default/room/tabbar/picto_item1_'.($numTab==1?'on':'off'), array('alt' => __('label_room_tabbar_item1'), 'size' => '18x21')) ?>
			</td>
			<td align="center" valign="middle">
				<a href="<?php echo url_for($rawTabs["tab1"]["link"] ) ?>" class="<?php echo ($numTab==1?'on':'off') ?>"><?php echo $rawTabs["tab1"]["libelle"] ?></a>
			</td>
		</table>
	</td>
	<td align="center" valign="middle" width="141" height="38">
		<table style="border-collapse:collapse; border-spacing: 0;">
		<tr>
			<td align="left" valign="middle" width="22">
				<?php echo image_tag('/image/default/room/tabbar/picto_item2_'.($numTab==2?'on':'off'), array('alt' => __('label_room_tabbar_item2'), 'size' => '18x21')) ?>
			</td>
			<td align="center" valign="middle">
				<a href="<?php echo url_for($rawTabs["tab2"]["link"] ) ?>" class="<?php echo ($numTab==2?'on':'off') ?>"><?php echo $rawTabs["tab2"]["libelle"] ?></a>
			</td>
		</table>
	</td>
	<td align="center" valign="middle" width="141" height="38">
		<table style="border-collapse:collapse; border-spacing: 0;">
		<tr>
			<td align="left" valign="middle" width="22">
				<?php echo image_tag('/image/default/room/tabbar/picto_item3_'.($numTab==3?'on':'off'), array('alt' => __('label_room_tabbar_item3'), 'size' => '18x21')) ?>
			</td>
			<td align="center" valign="middle">
				<a href="<?php echo url_for($rawTabs["tab3"]["link"] ) ?>" class="<?php echo ($numTab==3?'on':'off') ?>"><?php echo $rawTabs["tab3"]["libelle"] ?></a>
			</td>
		</table>
	</td>
	</tr>
	</table>
</div>
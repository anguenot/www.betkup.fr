<?php $rawTabs = $sf_data->getRaw('tabs') ?>
<?php if ($sf_request->getAttribute('roomUI', "")) {$roomUI = $sf_request->getAttribute('roomUI', "");} ?>
<?php if (isset($roomUI) && $roomUI['isPictoPerso'] == '1') { $picto_path = $roomUI['path-img-picto']; }else{ $picto_path = '/image/default/kup/tabbar'; }; ?>
<?php if (isset($roomUI) && $roomUI['isPictoPerso'] == '1') { ?>
<style type="text/css">
.kup_tabbar a.off {
	color : <?php echo $roomUI['tab-picto-text-color']; ?>; 
}
</style>
<?php }; ?>
<div class="kup_tabbar" style="margin: 0px; padding: 0px; width: 769px; height: 50px; background: url('/image/default/kup/tabbar/background_item<?php echo $numTab ?>.png');">
	<div style="margin: 0px; padding: 0px; height: 4px;"></div>
	<table style="border-collapse:collapse; border-spacing: 0; margin-left: 13px;">
	<tr>
	<td align="center" valign="middle" width="141" height="38">
		<table style="border-collapse:collapse; border-spacing: 0;">
		<tr>
			<td align="left" valign="middle" width="22">
				<?php echo image_tag($picto_path.'/picto_item1_'.($numTab==1?'on':'off'), array('alt' => __('label_kup_tabbar_item1'), 'size' => '18x21')) ?>
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
				<?php echo image_tag($picto_path.'/picto_item2_'.($numTab==2?'on':'off'), array('alt' => __('label_kup_tabbar_item2'), 'size' => '18x21')) ?>
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
				<?php echo image_tag($picto_path.'/picto_item3_'.($numTab==3?'on':'off'), array('alt' => __('label_kup_tabbar_item3'), 'size' => '18x21')) ?>
			</td>
			<td align="center" valign="middle">
				<a href="<?php echo url_for($rawTabs["tab3"]["link"] ) ?>" class="<?php echo ($numTab==3?'on':'off') ?>"><?php echo $rawTabs["tab3"]["libelle"] ?></a>
			</td>
		</table>
	</td>
	<td align="center" valign="middle" width="141" height="38">
		<table style="border-collapse:collapse; border-spacing: 0;">
		<tr>
			<td align="left" valign="middle" width="22">
				<?php echo image_tag($picto_path.'/picto_item5_'.($numTab==4?'on':'off'), array('alt' => __('label_kup_tabbar_item4'), 'size' => '18x21')) ?>
			</td>
			<td align="center" valign="middle">
				<a href="<?php echo url_for($rawTabs["tab4"]["link"] ) ?>" class="<?php echo ($numTab==4?'on':'off') ?>"><?php echo $rawTabs["tab4"]["libelle"] ?></a>
			</td>
		</table>
	</td>
	<?php if(isset($rawTabs["tab5"])) :?>
	<td align="center" valign="middle" width="141" height="38">
		<table style="border-collapse:collapse; border-spacing: 0;">
		<tr>
			<td align="left" valign="middle" width="22">
				<?php echo image_tag($picto_path.'/picto_item4_'.($numTab==5?'on':'off'), array('alt' => __('label_kup_tabbar_item5'), 'size' => '18x21')) ?>
			</td>
			<td align="center" valign="middle">
				<a href="<?php echo url_for($rawTabs["tab5"]["link"] ) ?>" class="<?php echo ($numTab==5?'on':'off') ?>"><?php echo $rawTabs["tab5"]["libelle"] ?></a>
			</td>
		</table>
	</td>
	<?php endif;?>
	</tr>
	</table>
</div>
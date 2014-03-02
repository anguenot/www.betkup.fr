<?php echo image_tag('/image/' . $sf_user->getCulture(). '/room/members_header.png', array('alt' => __('label_room_members_header'), 'size' => '708x49')) ?>
<table style="border-collapse:collapse; border-spacing: 0; margin-bottom: 20px;">
<?php $cpt=0; foreach ( $sf_data->getRaw('data') as $member ): ?>
	<tr>
	<td align="left" valign="top">
		<div class="room_members" style="width: 240px; height: 52px; background-color: <?php echo ($cpt%2==0?'#f4f4f4':'#e2e1e1') ?>; border-right: 2px solid white; border-bottom: 2px solid white;">
			<?php echo image_tag($member["avatar"], array('alt' => __('label_room_members_avatar'), 'size' => '40x40', 'style'=>'float: left; margin: 6px; margin-right: 10px;')) ?>
			<div class="room_members_name"><?php echo $member["member_name"] ?></div>
		</div>
	</td>
	<td width="260" align="left" valign="top">
		<div class="room_members" style="width: 240px; height: 52px; background-color: <?php echo ($cpt%2==0?'#f4f4f4':'#e2e1e1') ?>; border-right: 2px solid white; border-bottom: 2px solid white;">				
			<div class="room_members_<?php echo $member["member_statut_style"] ?>"><?php echo $member["member_statut"] ?></div>
		</div>
	</td>
	<td align="left" valign="middle">
		<a href="">
			<?php echo image_tag($member["link_image"], array('alt' => __('label_room_members_button_01'), 'size' => '193x29', 'style'=>'margin: 0px; padding: 0px;')) ?>
		</a>
	</td>
	</tr>
<?php $cpt++; endforeach ?>
</table>
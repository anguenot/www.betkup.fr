<div class="layoutIntAllBlanc">
	<div class="interface">
	<?php echo image_tag('moncompte/top.png', array('alt' => '', 'border' => '0', 'size' => '990x4')); ?>
		<p style="height: 40px;"></p>
		<?php include_component('interface', 'header', array('image' => '/image/'.$sf_user->getCulture().'/home/howto/title_how_to_play_'.strtolower($sf_user->getCulture()).'.png', 'title' => __('account_how_to_play_link_go_to_home_label'), 'link' => url_for("@homepage") )) ?>
		<div style="margin-left: auto; margin-right: auto; width: 816px;">
			<table style="border-spacing: 15px;" >
				<tr>
					<td width="45%"><?php echo image_tag('/image/'.$sf_user->getCulture().'/home/howto/bg_box_player_alone.png')?>
					</td>
					<td width="10%"><?php echo image_tag('/image/'.$sf_user->getCulture().'/home/howto/img_choice.png')?>
					</td>
					<td width="45%"><?php echo image_tag('/image/'.$sf_user->getCulture().'/home/howto/bg_box_my_group.png')?>
					</td>
				</tr>
				<tr>
					<td width="45%">
						<div style="background-image: url('/image/<?php echo $sf_user->getCulture(); ?>/home/howto/bg_box_discover_kup.png'); background-repeat: no-repeat; height: 260px; width: 340px;">
							<div style="position: absolute; padding-top: 65px; width: 340px;">
								<table style="width: 100%; border-spacing: 0; border-collapse: collapse;">
									<tr>
										<td style="width: 22px;">
											<?php echo image_tag('/image/default/home/howto/green_ticker.png',array('style'=>'margin-left: 17px; margin-bottom: 11px; margin-right: 8px;','border'=>'0'))?>
										</td>
										<td>
											<span class="how_does_it_work"><?php echo __('account_how_to_play_discover_kups_label_1')?></span>
										</td>
									</tr>
									<tr>
										<td style="width: 22px;"><?php echo image_tag('/image/default/home/howto/green_ticker.png',array('style'=>'margin-left: 17px; margin-bottom: 11px; margin-right: 8px;','border'=>'0'))?>
										</td>
										<td>
											<span class="how_does_it_work"><?php echo __('account_how_to_play_discover_kups_label_2')?></span>
										</td>
									</tr>
									<tr>
										<td style="width: 22px;"><?php echo image_tag('/image/default/home/howto/green_ticker.png',array('style'=>'margin-left: 17px; margin-bottom: 11px; margin-right: 8px;','border'=>'0'))?>
										</td>
										<td>
											<span class="how_does_it_work"><?php echo __('account_how_to_play_discover_kups_label_3')?></span>
										</td>
									</tr>
									<tr>
										<td style="width: 22px;"><?php echo image_tag('/image/default/home/howto/green_ticker.png',array('style'=>'margin-left: 17px; margin-bottom: 11px; margin-right: 8px;','border'=>'0'))?>
										</td>
										<td>
											<span class="how_does_it_work"><?php echo __('account_how_to_play_discover_kups_label_4')?></span>
										</td>
									</tr>
								</table>
							</div>
							<div style="position: absolute; padding-top: 200px; width: 340px; text-align: center;">
								<?php echo link_to(image_tag('/image/'.$sf_user->getCulture().'/home/howto/button_find_kup.png',array('border'=>'0','id'=>'searchkup')),url_for(array('module' => 'kup', 'action' => 'home')));?>
							</div>
						</div>
					</td>
					<td width="10%"></td>
					<td width="45%">
						<div style="background-image: url('/image/<?php echo $sf_user->getCulture(); ?>/home/howto/bg_box_create_room.png'); background-repeat: no-repeat; height: 260px; width: 340px;">
							<div style="position: absolute; padding-top: 65px; width: 340px;">
								<table style="width: 100%; border-spacing: 0; border-collapse: collapse;">
									<tr>
										<td style="width: 22px;">
                                            <?php echo image_tag('/image/default/home/howto/green_ticker.png',array('style'=>'margin-left: 17px; margin-bottom: 11px; margin-right: 8px;','border'=>'0'))?>
										</td>
										<td>
                                            <span class="how_does_it_work">
                                                <?php echo __('account_how_to_play_create_room_label_1')?>
                                            </span>
										</td>
									</tr>
									<tr>
										<td style="width: 22px;">
                                            <?php echo image_tag('/image/default/home/howto/green_ticker.png',array('style'=>'margin-left: 17px; margin-bottom: 11px; margin-right: 8px;','border'=>'0'))?>
										</td>
										<td>
                                            <span class="how_does_it_work">
                                            <?php echo __('account_how_to_play_create_room_label_2')?>
										    </span>
										</td>
									</tr>
									<tr>
										<td style="width: 22px;">
                                            <?php echo image_tag('/image/default/home/howto/green_ticker.png',array('style'=>'margin-left: 17px; margin-bottom: 11px; margin-right: 8px;','border'=>'0'))?>
										</td>
										<td>
                                            <span class="how_does_it_work">
                                            <?php echo __('account_how_to_play_create_room_label_3')?>
										    </span>
										</td>
									</tr>
									<tr>
										<td style="width: 22px;">
                                            <?php echo image_tag('/image/default/home/howto/green_ticker.png',array('style'=>'margin-left: 17px; margin-bottom: 11px; margin-right: 8px;','border'=>'0'))?>
										</td>
										<td>
                                            <span class="how_does_it_work">
                                            <?php echo __('account_how_to_play_create_room_label_4')?>
										    </span>
										</td>
									</tr>
								</table>
							</div>
							<div style="position: absolute; padding-top: 200px; width: 340px; text-align: center;">
								<?php echo link_to(image_tag('/image/'.$sf_user->getCulture().'/home/howto/button_create_room.png',array('border'=>'0','id'=>'createRoom')),url_for(array('module' => 'room', 'action' => 'create')));?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td align="center" width="45%">
						<div style="background-image: url('/image/<?php echo $sf_user->getCulture(); ?>/home/howto/bg_box_discover_public_room.png'); background-repeat: no-repeat; height: 260px; width: 340px;">
							<div style="position: absolute; padding-top: 65px; width: 340px;">
								<table style="width: 100%; border-spacing: 0; border-collapse: collapse;">
									<tr>
										<td>
                                            <?php echo image_tag('/image/default/home/howto/green_ticker.png',array('style'=>'margin-left: 17px; margin-bottom: 11px; margin-right: 8px;','border'=>'0'))?>
										</td>
										<td><span class="how_does_it_work"><?php echo __('account_how_to_play_discover_public_room_label_1')?>
										</span>
										</td>
									</tr>
									<tr>
										<td>
                                            <?php echo image_tag('/image/default/home/howto/green_ticker.png',array('style'=>'margin-left: 17px; margin-bottom: 11px; margin-right: 8px;','border'=>'0'))?>
										</td>
										<td><span class="how_does_it_work"><?php echo __('account_how_to_play_discover_public_room_label_2')?>
										</span>
										</td>
									</tr>
									<tr>
										<td>
                                            <?php echo image_tag('/image/default/home/howto/green_ticker.png',array('style'=>'margin-left: 17px; margin-bottom: 11px; margin-right: 8px;','border'=>'0'))?>
										</td>
										<td><span class="how_does_it_work"><?php echo __('account_how_to_play_discover_public_room_label_3')?>
										</span>
										</td>
									</tr>
									<tr>
										<td>
                                            <?php echo image_tag('/image/default/home/howto/green_ticker.png',array('style'=>'margin-left: 17px; margin-bottom: 11px; margin-right: 8px;','border'=>'0'))?>
										</td>
										<td><span class="how_does_it_work"><?php echo __('account_how_to_play_discover_public_room_label_4')?>
										</span>
										</td>
									</tr>
								</table>
							</div>
							<div style="position: absolute; padding-top: 200px; width: 340px; text-align: center;">
								<?php echo link_to(image_tag('/image/'.$sf_user->getCulture().'/home/howto/button_find_room.png',array('border'=>'0','id'=>'searchRoom')),url_for(array('module' => 'room', 'action' => 'search')));?>
							</div>
						</div>
					</td>
					<td align="center" width="10%"></td>
					<td align="center" width="45%">
						<div style="background-image: url('/image/<?php echo $sf_user->getCulture(); ?>/home/howto/bg_box_retrieve_room.png'); background-repeat: no-repeat; height: 260px; width: 340px;">
							<div style="position: absolute; padding-top: 77px; padding-left: 60px;">
								<form name="formRoomTag"
                                    action="<?php echo url_for(array('module' => 'room', 'action' => 'search')) ?>"
                                    method="post">
									<table style="margin: 0px; padding: 0px; margin-top: 6px;">
										<tr>
											<td>
                                                <div id="formRoomTagLabel" style="margin-bottom: 5px;">
											    <?php echo __('account_how_to_play_retrieve_room_form_label')?></div>
											</td>
										</tr>
										<tr>
											<td>
                                                <input type="text" name="roomHomeSearchText" class="inputSearchRoomHome" style="border-top: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7; border-right: 1px solid #EBEBEB; border-bottom: 1px solid #EBEBEB; width: 200px; height: 27px; margin-right: 12px;" />
											</td>
										</tr>
									</table>
									<div style="position: absolute; padding-top: 41px; padding-left: 10px;">
										<a href="javascript:void(0);" onClick="document.formRoomTag.submit();">
										<?php echo image_tag('/image/'.$sf_user->getCulture().'/home/howto/button_find_room.png',array("border"=>"0")) ?>
                                        </a>
									</div>
								</form>
							</div>
						</div>
					</td>
				</tr>
				<tr>
                <td colspan="3"></td>
                </tr>
				<tr>
					<td colspan="3" style="text-align: center;">
						<a href="<?php echo url_for(array('module' => 'account', 'action' => 'register'))?>">
							<?php echo image_tag('/images/interface/boutonInscrireFleche_fr.png', array('size' => '156x63'))?>
						</a>
					</td>
				</tr>
                <tr>
                <td colspan="3"></td>
                </tr>
				<tr>
					<td colspan="3">
						<div id="box_what_is_a_kup" style="position: relative;"></div>
						<div id="box_what_is_a_kup_undeployed">
							<div id="button_plus" class="button_plus"></div>
							<div class="title_box">
							<?php echo __('account_how_to_play_box_what_is_a_kup_title')?>
							</div>
						</div>
						<div id="box_what_is_a_kup_deployed">
							<div>
								<div id="button_less" class="button_less"></div>
								<div class="title_box">
								<?php echo __('account_how_to_play_box_what_is_a_kup_title')?>
								</div>
							</div>
							<div class="text_box">
								<div>
								<?php echo __('account_how_to_play_box_what_is_a_kup_text')?>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<div id="box_what_is_a_room" style="position: relative;"></div>
						<div id="box_what_is_a_room_undeployed">
							<div id="button_plus" class="button_plus"></div>
							<div class="title_box">
							<?php echo __('account_how_to_play_box_what_is_a_room_title')?>
							</div>
						</div>
						<div id="box_what_is_a_room_deployed">
							<div>
								<div id="button_less" class="button_less"></div>
								<div class="title_box">
								<?php echo __('account_how_to_play_box_what_is_a_room_title')?>
								</div>
							</div>
							<div class="text_box">
								<div>
								<?php echo __('account_how_to_play_box_what_is_a_room_text')?>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<div id="box_howto_win" style="position: relative;"></div>
						<div id="box_howto_win_undeployed">
							<div id="button_plus" class="button_plus"></div>
							<div class="title_box">
							<?php echo __('account_how_to_play_box_howto_win_title')?>
							</div>
						</div>
						<div id="box_howto_win_deployed">
							<div>
								<div id="button_less" class="button_less"></div>
								<div class="title_box">
								<?php echo __('account_how_to_play_box_howto_win_title')?>
								</div>
							</div>
							<div class="text_box">
								<div>
								<?php echo __('account_how_to_play_box_howto_win_text', array('%br%' => '<br />'))?>
								</div>
							</div>
						</div>
					</td>
				</tr>
			  </table>
			<div style="height: 40px;"></div>
		</div>
		<div style="clear: both;"></div>
	</div>
</div>
<script type="text/javascript">
	$("div#box_what_is_a_kup_deployed").hide();
	$("div#box_what_is_a_room_deployed").hide();
	$("div#box_howto_win_deployed").hide();
	$('div#box_what_is_a_kup_undeployed div#button_plus').click(function(){
		$("div#box_what_is_a_kup_deployed").show();
		$("div#box_what_is_a_kup_undeployed").hide();
	});
	$('div#box_what_is_a_kup_deployed div#button_less').click(function(){
		$("div#box_what_is_a_kup_undeployed").show();
		$("div#box_what_is_a_kup_deployed").hide();
	});
	$('div#box_what_is_a_room_undeployed div#button_plus').click(function(){
		$("div#box_what_is_a_room_deployed").show();
		$("div#box_what_is_a_room_undeployed").hide();
	});
	$('div#box_what_is_a_room_deployed div#button_less').click(function(){
		$("div#box_what_is_a_room_undeployed").show();
		$("div#box_what_is_a_room_deployed").hide();
	});
	$('div#box_howto_win_undeployed div#button_plus').click(function(){
		$("div#box_howto_win_deployed").show();
		$("div#box_howto_win_undeployed").hide();
	});
	$('div#box_howto_win_deployed div#button_less').click(function(){
		$("div#box_howto_win_undeployed").show();
		$("div#box_howto_win_deployed").hide();
	});
</script>
<div class="rightroom">
	<?php if(isset($roomUI) && isset($roomUI['isChallenge']) && $roomUI['isChallenge'] == 1) :?>
	<div class="statut2">
		<?php echo image_tag('/images/room/right/statut_header.png',array('style'=>'position: absolute; margin-left: 14px; margin-top: -6px;','border'=>'0'))?>
		<div style="height: 40px;"></div>
		<div align="left" style="width: 200px; margin: 0px auto;">
		    <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('room_member') ): ?>
		    	<?php echo image_tag('/images/kup/view/statut/participationValidee.png',array('border'=>'0'))?>
		    	<p>
		    	Vous prenez donc part au challenge ! Bonne chance et bon pronos ;-).
		    	</p>
		    <?php else: ?>
		    	<?php echo image_tag('/images/kup/view/statut/participationNonValidee.png',array('border'=>'0'))?>
		    	<p>
			    	Pour valider votre participation, prenez part à au moins une kup du jour sur l'évènement.
			    </p>
		    <?php endif; ?>
			
		</div>
	</div>
	<?php else: ?>
	<?php if (isset($dataRoom)): ?>
	<?php if ( ($dataRoom['privacy'] == sfConfig::get('mod_room_privacy_private') || $dataRoom['privacy'] == sfConfig::get('mod_room_privacy_private_gambling_fr')) && !($sf_user->hasCredential($sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_member'))) || $sf_user->hasCredential($sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_administrator'))))): ?>
	<div class="private">
		<div class="title">
			<?php echo __('ROOM PRIVEE') ?>
		</div>
		<div class="message">
			<?php if ($dataRoom['privacy'] == sfConfig::get('mod_room_privacy_private')): ?>
			<?php echo __('Cette Room est privee et son acces est protege par un mot de passe.') ?>
			<?php elseif ($dataRoom['privacy'] == sfConfig::get('mod_room_privacy_private_gambling_fr')):?>
			<?php echo __('Cette Room est privee et son acces est protege par un mot de passe pour les joueurs ayant un compte complet.') ?>
			<?php endif ?>
		</div>
		<?php if (($dataRoom['privacy'] == sfConfig::get('mod_room_privacy_private_gambling_fr') && $sf_user->hasCredential('member_gambling_fr')) || $dataRoom['privacy'] == sfConfig::get('mod_room_privacy_private')): ?>
		<div align="center">
			
			<!-- <a
				href="<?php echo url_for(array('module' => 'room', 'action' => 'view', 'uuid' => intval($dataRoom['id']))) ?>">
				<?php echo image_tag('/images/room/right/private_button_access.png', array('size' => '161x34','style' => 'margin-right: 5px; border: none;'))?>
			</a>
			 -->
			<?php echo image_tag('/images/room/right/private_intersection.png', array('size' => '187x35','style' => 'margin-right: 5px; border: none;'))?>
		</div>
		<div class="legende">
			<?php echo __('Vous avez le mot de passe ?') ?>
		</div>
		<script type="text/javascript">
					function joinRoomSubmit() {
						$('#joinRoom').submit();
					}
				</script>
		<form name="joinRoom" id="joinRoom" method="post"
			action="<?php echo url_for(array('module' => 'room', 'action' => 'join', 'uuid' => intval($dataRoom['id']))) ?>">
			<div class="input">
				<input class="input" type="password" name="password" value="" />
                <input type="hidden" name="room_type" value="<?php echo $dataRoom['privacy'] ?>"/>
			</div>
			<div class="join">
				<a href="javascript:void(0);" onclick="joinRoomSubmit();"> <?php echo image_tag('/images/room/right/private_button_join.png', array('size' => '103x34', 'style' => 'boreder: none;'))?>
				</a>
			</div>
		</form>
		<?php else: ?>
			<div class="join">
				<?php if ($sf_user->isAuthenticated()): ?>
				<a
					href="<?php echo url_for(array('module' => 'account', 'action' => 'updateSimpleAccount')) ?>">
					<?php echo image_tag('/images/interface/boutonInscrireFleche_fr.png', array('size' => '110x44','style' => 'border: none;'))?>
				</a>
				<?php else: ?>
				<a
					href="<?php echo url_for(array('module' => 'account', 'action' => 'registerAdvanced')) ?>">
					<?php echo image_tag('/images/interface/boutonInscrireFleche_fr.png', array('size' => '110x44','style' => 'border: none;'))?>
				</a>
				<?php endif ?>
			</div>
		<?php endif?>

	</div>

	<?php endif ?>

	<?php if ( ($dataRoom['privacy'] == sfConfig::get('mod_room_privacy_public') || $dataRoom['privacy'] == sfConfig::get('mod_room_privacy_public_gambling_fr')) && !($sf_user->hasCredential($sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_member'))) || $sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_administrator')))): ?>

	<div class="public-box">
		<div class="bg-top"></div>
		<div class="bg-middle">
			<div class="bg-top-green"></div>

			<table class="table-public-box-title">
				<tr>
					<td><?php echo image_tag('/image/default/room/lock_open.png', array('size' => '49x33'))?>
					</td>
					<td>
						<div class="title">
							<?php echo __('ROOM PUBLIQUE') ?>
						</div>
					</td>
				</tr>
			</table>

			<?php if ($dataRoom['privacy'] == sfConfig::get('mod_room_privacy_public')): ?>
			<div class="message">
				<?php echo __('Cette Room est publique et accessible a tous.') ?>
			</div>
			<?php elseif ($dataRoom['privacy'] == sfConfig::get('mod_room_privacy_public_gambling_fr')): ?>
			<div class="message">
				<?php echo __('Cette Room est publique et accessible a tous les joueurs ayant un compte complet.') ?>
			</div>
			<?php endif ?>

			<?php if (($dataRoom['privacy'] == sfConfig::get('mod_room_privacy_public_gambling_fr')) || $dataRoom['privacy'] == sfConfig::get('mod_room_privacy_public')): ?>
			<table class="table-public-box-infos">
				<tr>
					<td width="15"><?php echo image_tag('/image/default/room/ticker_infos_green.png', array('size' => '12x12'))?>
					</td>
					<td>
						<div class="message-info">
							<?php echo __('text_right_box_room_infos')?>
						</div>
					</td>
				</tr>
			</table>
			<div class="join">
				
				<a href="<?php echo $joinUrl; ?>">
					<?php echo image_tag('/images/room/right/private_button_join.png', array('size' => '103x34','style' => 'border: none;'))?>
				</a>
			</div>
			<?php else: ?>
			<div class="join">
				<?php if ($sf_user->isAuthenticated()): ?>
				<a
					href="<?php echo url_for(array('module' => 'account', 'action' => 'updateSimpleAccount')) ?>">
					<?php echo image_tag('/images/interface/boutonInscrireFleche_fr.png', array('size' => '110x44','style' => 'border: none;'))?>
				</a>
				<?php else: ?>
				<a
					href="<?php echo url_for(array('module' => 'account', 'action' => 'registerAdvanced')) ?>">
					<?php echo image_tag('/images/interface/boutonInscrireFleche_fr.png', array('size' => '110x44','style' => 'border: none;'))?>
				</a>
				<?php endif ?>
			</div>
			<?php endif ?>
			<div style="height: 10px;"></div>
		</div>
		<div class="bg-bottom"></div>
	</div>
	<div style="height: 10px;"></div>
	<?php endif ?>

	<?php if ( ($dataRoom['privacy'] == sfConfig::get('mod_room_privacy_private') || $dataRoom['privacy'] == sfConfig::get('mod_room_privacy_private_gambling_fr')) && $sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_member')) && !$sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_administrator'))): ?>

	<div class="statut1">

		<?php echo image_tag('/images/room/right/statut_header.png', array('style' => 'position: absolute; margin-left: 14px; margin-top: -6px;', 'size' => '211x48'))?>
		<div class="message">
			<?php echo __('Vous etes membre de cette Room. Si vous ne participez a aucune de ses Kups vous pouvez la quitter.') ?>
		</div>
		<div align="center">
			<a
				href="<?php echo url_for(array('module' => 'room', 'action' => 'leave', 'uuid' => intval($dataRoom['id']))) ?>">
				<?php echo image_tag('/images/room/right/statut_button_quit.png', array('size' => '164x35', 'style' => 'border: none;'))?>
			</a>
		</div>

	</div>

	<?php endif ?>

	<?php if ( ($dataRoom['privacy'] == sfConfig::get('mod_room_privacy_public') || $dataRoom['privacy'] == sfConfig::get('mod_room_privacy_public_gambling_fr')) && $sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_member')) && !$sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_administrator'))): ?>
	<div class="statut2">
		<?php echo image_tag('/images/room/right/statut_header.png', array('size' => '211x48','style' => 'position: absolute; margin-left: 14px; margin-top: -6px; border: none;'))?>
		<div class="message">
			<?php echo __('Vous etes membre de cette Room. Vous pouvez quitter cette Room ou y inviter des amis.') ?>
		</div>
		<div align="center">
			<a
				href="<?php echo url_for(array('module' => 'room', 'action' => 'leave', 'uuid' => intval($dataRoom['id']))) ?>">
				<?php echo image_tag('/images/room/right/statut_button_quit.png', array('size' => '164x35', 'style' => 'border: none;'))?>
			</a> <a
				href="<?php echo url_for(array('module' => 'room', 'action' => 'invite', 'room_uuid' => intval($dataRoom['id']))) ?>">
				<?php echo image_tag('/images/room/right/statut_button_invite.png', array('size' => '165x35', 'style' => 'margin-top: 24px; border: none;'))?>
			</a>
		</div>
	</div>
	<?php endif ?>

	<?php if ( $sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_administrator'))): ?>
	<div class="statut3">
		<?php echo image_tag('/images/room/right/statut_header.png', array('size' => '211x48','style' => 'position: absolute; margin-left: 14px; margin-top: -6px; border: none;'))?>
		<div class="message">
			<?php echo __('Vous etes le createur et l\'administrateur de cette Room. Vous pouvez personnaliser la Room, lancer une Kup ou inviter des amis.') ?>
		</div>
		<div align="center">
			<a
				href="<?php echo url_for(array('module' => 'room', 'action' => 'edit', 'uuid' => intval($dataRoom['id']))) ?>">
				<?php echo image_tag('/images/room/right/statut_button_personnaliser.png', array('size' => '165x34', 'style' => 'border: none;'))?>
			</a> <a
				href="<?php echo url_for(array('module' => 'room', 'action' => 'kups', 'uuid' => intval($dataRoom['id']))) ?>">
				<?php echo image_tag('/images/room/right/statut_button_start.png', array('size' => '165x35', 'style' => 'margin-top: 24px; border:none;'))?>
			</a> <a
				href="<?php echo url_for(array('module' => 'room', 'action' => 'invite', 'room_uuid' => intval($dataRoom['id']))) ?>">
				<?php echo image_tag('/images/room/right/statut_button_invite.png', array('size' => '165x35', 'style' => 'margin-top: 24px; border: none;'))?>
			</a>
		</div>
	</div>
	<?php endif ?>

	<?php endif ?>

	<?php if ( !isset($roomUI) || (isset($roomUI) && !isset($roomUI['show-buttons-right'])) || (isset($roomUI) && isset($roomUI['show-buttons-right']) && $roomUI['show-buttons-right'] != false ) ): ?>
	<div class="homeRoom">
		<div align="center">
			<?php if ($sf_params->get('module') != 'me') : ?>
			<a
				href="<?php echo url_for(array('module' => 'room', 'action' => 'search')) ?>">
				<?php echo image_tag('/images/room/searchRoom.png', array('size' => '200x41', 'style' => 'border: none;'))?>
			</a> <a
				href="<?php echo url_for(array('module' => 'room', 'action' => 'create')) ?>">
				<?php echo image_tag('/images/room/createRoom.png', array('style' => 'margin-top: 15px; border:none;', 'size' => '200x41'))?>
			</a>
			<?php endif; ?>
		</div>

        <?php if (!$sf_user->isAuthenticated()) : ?>
            <div style="height: 20px;"></div>
            <div class="box_bg_top">
                <h1 class="title-teaser-video">
                    Teaser vidéo :
                </h1>
            </div>
            <div class="box_bg_middle">
                <a class="teaser-betkup" href="javascript:void(0);" onclick="$('#video-pop-up').trigger('click');">
                    <?php echo image_tag('/image/default/footer/teaser_betkup.png', array('size' => '205x114')) ?>
                </a>
            </div>
            <div class="box_bg_bottom"></div>
        <?php endif; ?>
	</div>
	<?php endif ?>

<?php if (isset($roomUI)) : ?>
	<?php if (isset($roomUI['show-box-how-work']) && $roomUI['show-box-how-work'] == "1") : ?>
		<?php if(isset($roomUI['isCustomBoxWork']) && $roomUI['isCustomBoxWork'] == '1') :?>
			<div class="box_right_room box_right_room_custom" align="center" style="position: relative;">
				<div class="bg-top"></div>
				<div class="bg-middle">
					<div class="how-to-box-title" style="background: url('<?php echo $roomUI['box-how-work'] ?>') center no-repeat;">
					<?php echo __('home_slidedeck_slide_1_title')?>
					</div>
					<div style="padding-top: 50px; padding-left: 10px; width: 219px; text-align: left;">
						<table style="border-spacing: 5px">
							<tr>
								<td><?php echo image_tag($roomUI['path-img-list'].'/01.png', array('size'=>'26x26','alt'=>'list img 01'))?>
								</td>
								<td class="box_how_to_work_table_text"><?php echo __('room_view_right_box_how_to_work_small_text_1');?>
								</td>
							</tr>
							<tr>
								<td><?php echo image_tag($roomUI['path-img-list'].'/02.png', array('size'=>'26x26','alt'=>'list img 02'))?>
								</td>
								<td class="box_how_to_work_table_text"><?php echo __('room_view_right_box_how_to_work_small_text_2');?>
								</td>
							</tr>
							<tr>
								<td><?php echo image_tag($roomUI['path-img-list'].'/03.png', array('size'=>'26x26','alt'=>'list img 03'))?>
								</td>
								<td class="box_how_to_work_table_text"><?php echo __('room_view_right_box_how_to_work_small_text_3');?>
								</td>
							</tr>
						</table>
					</div>
					<div style="height: 20px;"></div>
				</div>
				<div class="bg-bottom"></div>
			</div>
			<?php else :?>
			<div class="box_right_room" align="center" style="position: relative;">
			<?php echo image_tag($roomUI['box-how-work'], array('width' => '230')); ?>
			<?php if ($roomUI['size-box-how-work'] == "small") : ?>
			<div style="position: absolute; top: 40%; width: 90%; right: 0;"
				align="left">
				<table style="border-spacing: 5px">
					<tr>
						<td><?php echo image_tag($roomUI['path-img-list'].'/01.png', array('size'=>'26x26','alt'=>'list img 01'))?>
						</td>
						<td class="box_how_to_work_table_text"><?php echo __('room_view_right_box_how_to_work_small_text_1');?>
						</td>
					</tr>
					<tr>
						<td><?php echo image_tag($roomUI['path-img-list'].'/02.png', array('size'=>'26x26','alt'=>'list img 02'))?>
						</td>
						<td class="box_how_to_work_table_text"><?php echo __('room_view_right_box_how_to_work_small_text_2');?>
						</td>
					</tr>
					<tr>
						<td><?php echo image_tag($roomUI['path-img-list'].'/03.png', array('size'=>'26x26','alt'=>'list img 03'))?>
						</td>
						<td class="box_how_to_work_table_text"><?php echo __('room_view_right_box_how_to_work_small_text_3');?>
						</td>
					</tr>
				</table>
			</div>
			<?php elseif ($roomUI['size-box-how-work'] == "big") : ?>
			<div style="position: absolute; top: 30%; width: 95%; right: 0;"
				align="left">
				<table style="border-spacing: 10px; padding: 0px">
					<tr>
						<td><?php echo image_tag($roomUI['path-img-list'].'/01.png', array('size'=>'26x26','alt'=>'list img 01'))?>
						</td>
						<td class="box_how_to_work_table_text"><?php echo __('room_view_right_box_how_to_work_big_text_1');?>
						</td>
					</tr>
					<tr>
						<td><?php echo image_tag($roomUI['path-img-list'].'/02.png', array('size'=>'26x26','alt'=>'list img 02'))?>
						</td>
						<td class="box_how_to_work_table_text"><?php echo __('room_view_right_box_how_to_work_big_text_2');?>
							<br> <?php echo link_to($roomUI['box-how-work-link'],$roomUI['box-how-work-link'],'class=box_how_work_link'); ?>
						</td>
					</tr>
					<tr>
						<td><?php echo image_tag($roomUI['path-img-list'].'/03.png', array('size'=>'26x26','alt'=>'list img 03'))?>
						</td>
						<td class="box_how_to_work_table_text"><?php echo __('room_view_right_box_how_to_work_big_text_3');?>
						</td>
					</tr>
					<tr>
						<td><?php echo image_tag($roomUI['path-img-list'].'/04.png', array('size'=>'26x26','alt'=>'list img 04'))?>
						</td>
						<td class="box_how_to_work_table_text"><?php echo __('room_view_right_box_how_to_work_big_text_4');?>
						</td>
					</tr>
				</table>
			</div>
			<?php endif; ?>
			</div>
		<?php endif;?>
	<?php endif;?>
	
	<?php if ($roomUI['show-box-prizes'] == "1") : ?>
		<?php if(isset($roomUI['isBoxPrizesCustom']) && $roomUI['isBoxPrizesCustom'] == "1") : ?>
		<div class="box_right_room box_right_room_custom" align="center" style="position: relative;">
			<div class="bg-top"></div>
			<div class="bg-middle">
				<div class="right-box-title" style="background: url('<?php echo $roomUI['box-prize-title-bg'] ?>') center no-repeat;">
					<?php echo __('LOTS')?>
				</div>
				<div style="padding-top: 50px; padding-left: 10px; width: 219px; text-align: center;">
					<?php echo image_tag($roomUI['img-box-prizes'], array('class' => 'img-prize', 'size' => $roomUI['img_box-prizes-size']))?>
					<div style="height: 10px;"></div>
					<?php if(isset($roomUI['total-prizes']) && $roomUI['total-prizes'] > 0) :?>
					<table class="prizes-table">
						<?php for($i=1; $i<= $roomUI['total-prizes']; $i++) :?>
						<tr>
                            <?php if(file_exists(sfConfig::get('sf_web_dir').'/images/room/right/kup_'.($i-1).'.png')) : ?>
							<td class="positions-image">
								<?php echo image_tag('/images/room/right/kup_'.($i-1).'.png', array('size'=>'12x14'))?>
							</td>
                            <td class="positions-label">
                            <?php else : ?>
                            <td class="positions-label" colspan="2">
                            <?php endif; ?>
								<h4>
									<?php echo isset($roomUI['prizes-'.$i.'-positions']) ? $roomUI['prizes-'.$i.'-positions'] : $i.'<sup>e</sup>'?>
								</h4>
							</td>
							<td class="prize-label">
								<p><?php echo __($roomUI['prizes-'.$i.'-label']);?></p>
							</td>
						</tr>
						<?php endfor;?>
					</table>
					<?php endif;?>
				</div>
				<div style="height: 20px;"></div>
			</div>
			<div class="bg-bottom"></div>
		</div>
		<?php else :?>
		<div class="box_right_room" align="center" style="position: relative;">
			<?php echo image_tag($roomUI['box-prizes'], array('width' => '230')); ?>
			<div style="position: absolute; bottom: 5px; width: 100%;"
				align="center">
				<?php if ((isset($idLongerKup)) && ($idLongerKup != '0')) : ?>
					<?php echo link_to(image_tag($roomUI['box-prizes-button'],array('width' => '130px')), array('module'=>'room', 'action'=>'kupRules', 'room_uuid'=> $uuid, 'kup_uuid' => $idLongerKup, 'tab' => 'rules')); ?>
				<?php else :?>
					<?php echo image_tag($roomUI['box-prizes-button'],array('width' => '130px'));?>
				<?php endif;?>
			</div>
		</div>
		<?php endif;?>
	<?php endif;?>
	
	<?php if (isset($roomUI['show-box-prizes-2']) && $roomUI['show-box-prizes-2'] == "1") : ?>
		<div class="box_right_room" align="center" style="position: relative;">
			<?php echo image_tag($roomUI['box-prizes-2'], array('width' => '230')); ?>
			<div style="position: absolute; bottom: 5px; width: 100%;"
				align="center">
				<?php if ((isset($idLongerKup)) && ($idLongerKup != '0')) : ?>
					<?php echo link_to(image_tag($roomUI['box-prizes-button-2'],array('width' => '130px')), array('module'=>'room', 'action'=>'kupRules', 'room_uuid'=> $uuid, 'kup_uuid' => $roomUI['box-prizes-kup-uuid-2'], 'tab' => 'rules'));?>
				<?php else :?>
					<?php echo image_tag($roomUI['box-prizes-button-2'],array('width' => '130px'));?>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
	
	<?php if ($roomUI['show-box-news'] == "1") : ?>
		<?php use_javascript('googleApiRssReader.js') ?>
		<div class="box_right_room" align="center" style="position: relative; height: 320px;">
			<?php echo image_tag($roomUI['box-news'], array('width' => '230')); ?>
			<div style="position: absolute; width: 90%; top: 60px; right: 10px;" align="center">
				<div class="post_results" id="post_results">
					<input id="rss_nb_news" type="hidden" value="3">
					<input id="rss_url"type="hidden" value="<?php echo $roomUI['box-news-rss']; ?>">
					<div class="loading_rss">
						<?php echo image_tag('/image/default/room/wait.gif', array('size' => '16x16', 'alt' => 'Chargement...', 'style' => 'border:none;'))?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<?php if ($roomUI['show-box-facebook'] == "1") : ?>
	<div class="box_right_room" align="center"
		style="position: relative; height: 360px;">
		<?php echo image_tag($roomUI['box-facebook'], array('width' => '230')); ?>
		<div
			style="position: absolute; top: 60px; width: 100%; padding-left: 3px;"
			align="center">
			<div id="fb-root"></div>
			<script src="https://connect.facebook.net/fr_FR/all.js#xfbml=1"></script>
			<fb:like-box xmlns:fb="http://www.facebook.com/2008/fbml"
				href="<?php echo $roomUI['box-facebook-page'];?>" width="200"
				height="300" show_faces="true" border_color="" stream="false"
				header="false"></fb:like-box>
		</div>
	</div>
	<?php endif; ?>
<?php endif;?>
<?php endif;?>
</div>
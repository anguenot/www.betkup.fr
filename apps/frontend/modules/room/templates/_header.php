<?php if ($sf_request->getAttribute('roomUI', "")) {$roomUI = $sf_request->getAttribute('roomUI', "");} ?>
<div id="module_blockHeader" style="<?php if(isset($roomUI) && isset($roomUI["header-bg"]) ){echo 'background-image: url('.$roomUI["header-bg"].')';}?>">
        
        <?php if($data['official'] != '0') : ?>
            <div id="badge" class="badge" ></div>
        <?php endif; ?>
            
        <div id="nomRoom" class="nomRoom">
		<?php if(strlen($data["name"]) > 35){$teamName = substr($data["name"], 0, 35).'...';echo $teamName;}else{echo $data["name"];}?>
	</div>
	<div id="nom">
            <table>
                <tr>
                    <td align="left" valign="middle"><?php echo image_tag($data["authorPicture"], array('size'=>'30x30'))?></td>
                    <td align="left" valign="middle" style="<?php if (isset($roomUI) && isset($roomUI["header-author-font-color"])){echo 'color:'.$roomUI["header-author-font-color"].';';}?>"><?php echo $data["author_nickname"] ?></td>
                </tr>
            </table>
	</div>
	<div id="bouton_edit">
	<?php if ($sf_user->hasCredential(sfConfig::get('mod_room_security_betkup_administrator'))): ?>
        <a href="<?php echo url_for(array('module'=>'room', 'action'=>'edit', 'uuid'=>$data["id"] )) ?>">
            <img src="/images/room/module/blockHeaderRoom/btn_edit.png" />
        </a>
    <?php endif ?>
    </div>
    <div id="bouton_del">
    <?php if ($sf_user->hasCredential(sfConfig::get('xxx_mod_room_security_betkup_administrator'))): ?>
    	<a href="<?php echo url_for(array('module'=>'room', 'action'=>'delete', 'uuid'=>$data["id"] )) ?>">
    		<img src="/images/room/module/blockHeaderRoom/btn_del.png" />
   		 </a>
    <?php endif ?>
    </div>
    <?php if($action!="view"):?>
    <div id="accueil">
	    <?php echo link_to(__('label_room_kup_header_home'),array('module'=>'room', 'action'=>'view', 'uuid'=>$data["id"]),array('class','orangeUnderlineMedium'))?>
	</div>
    <?php endif ?>
    <div id="contenuBH">
        <div id="imageKup"><?php if (isset($roomUI) && isset($roomUI["avatar-room"])){echo image_tag($roomUI["avatar-room"], array('size'=>'213x131'));}else{echo (isset($avatarList[$data["id"]])) ? image_tag($avatarList[$data["id"]], array('size'=>'213x131')) : image_tag(sfConfig::get('mod_room_avatar_default'), array('size'=>'213x131'));} ?></div>
        <div id="parag"><?php if(strlen($data["description"]) > 180){echo substr($data["description"], 0, 180).'...';}else{echo $data["description"];}?></div>
        <?php if(isset($roomUI) && isset($roomUI["isChallenge"]) && $roomUI["isChallenge"] == 1 ) :?>
	        <div id="room_publique"><?php echo image_tag('kup/home/tools_kup.png', array('align'=>'absmiddle', 'alt'=>__('room_header_img_kup_alt'), 'size'=>'21x16', 'style'=>'padding-right:10px;') ) ?><?php echo $data["legendes"]["legend3"] ?></div>
	        <div id="jeu"><?php echo image_tag('kup/home/tools_mise.png', array('align'=>'absmiddle', 'alt'=>__('room_header_img_mise_alt'), 'size'=>'21x16', 'style'=>'padding-right:10px;') ) ?>
                <?php echo isset($roomUI['jackpot_at_stake']) ? $roomUI['jackpot_at_stake'].'€' : $data["legendes"]["legend2"] ?>
            </div>
	        <div id="members"><?php echo image_tag('kup/home/tools_participant.png', array('align'=>'absmiddle', 'alt'=>__('room_header_img_participants_alt'), 'size'=>'21x16', 'style'=>'padding-right:10px;') ) ?><?php echo $data["legendes"]["legend4"] ?></div>
        <?php else :?>
	        <div id="room_publique"><?php echo image_tag('kup/home/tools_lock_'.$data["privacy"].'.png', array('align'=>'absmiddle', 'alt'=>__('room_header_img_privacy_alt'), 'size'=>'21x16', 'style'=>'padding-right:10px;') ) ?><?php echo $data["legendes"]["legend1"] ?></div>
	        <div id="jeu"><?php echo image_tag('kup/home/tools_mise.png', array('align'=>'absmiddle', 'alt'=>__('room_header_img_mise_alt'), 'size'=>'21x16', 'style'=>'padding-right:10px;') ) ?><?php echo $data["legendes"]["legend2"] ?></div>
	        <div id="members"><?php echo image_tag('kup/home/tools_participant.png', array('align'=>'absmiddle', 'alt'=>__('room_header_img_participants_alt'), 'size'=>'21x16', 'style'=>'padding-right:10px;') ) ?><?php echo $data["legendes"]["legend4"] ?></div>
	        <div id="OpenKups"><?php echo image_tag('kup/home/tools_kup.png', array('align'=>'absmiddle', 'alt'=>__('room_header_img_kup_alt'), 'size'=>'21x16', 'style'=>'padding-right:10px;') ) ?><?php echo $data["legendes"]["legend3"] ?></div>
        <?php endif;?>
        <div id="social">
            <div style="width: 415px; height: 25px;">
                <div style="float: right;">
                	<div class="fb-like" data-href="<?php echo $siteUrl.url_for(array('module'=>'room', 'action'=>'view', 'uuid'=>$data["id"])) ?>" data-send="true" data-layout="button_count" data-width="100" data-show-faces="false"></div>
                </div>
                <div style="float: right; margin-right: 5px;">
                	<a href="<?php echo $siteUrl.url_for(array('module'=>'room', 'action'=>'view', 'uuid'=>$data["id"])) ?>" class="twitter-share-button" data-text="<?php echo __('Venez voir la Room &quot;%roomTitle%&quot; sur @Betkup, le 1er site de paris sportifs communautaire.',array('%roomTitle%'=>$data["name"]))?>" data-count="horizontal">Tweet</a><script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
                </div>
            </div>
        </div>
    </div>
</div>
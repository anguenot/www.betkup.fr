<?php if (count($rankingData) > 0): ?>
<form action="" method="post" name="frmClassementList" class="frmClassementList" >
    <table style="width:730px; border-collapse: separate; border-spacing: 0px;">
        <tr>
            <th width="30">&nbsp;</th>
            <th style="text-align: center;" width="180"><?php echo __('label_kup_ranking_player_name') ?></th>
            <th style="text-align: center;" width="93"><?php echo __('label_kup_ranking_nb_points') ?></th>
            <?php if(!$isRoomRanking) :?>
            <th style="text-align: center;" width="85"><?php echo __('label_kup_ranking_correct_predictions') ?></th>
            <th style="text-align: center;" width="180"><?php echo __('label_kup_first_prediction') ?></th>
        	<?php endif;?>
        </tr>
        <?php foreach ($rankingData as $rankingData): ?>
     	<?php if (isset($rankingData['member'])): ?>
        <tr class="<?php echo (($rankingData['position'] % 2) ? 'pair' : 'impair') . ($sf_user->getAttribute('email', '', 'subscriber') == $rankingData['member']['email'] ? ' selected' : '') ?>">
            <td class="num"><?php echo $rankingData['position'] ?></td>
            <td class="gamer" style="text-align: left;">
            	<div class="<?php echo $rankingData['position'] <= 1 ? 'winner' : 'gamer' ?>"></div>
            	<?php echo image_tag($rankingData['member']['avatarSmall'] != '' ? $rankingData['member']['avatarSmall'] : '/image/default/member/avatar/default_small.png', array('alt' => '', 'size'=>'40x40') ) ?>
            	<?php echo $rankingData['member']['nickName'] ?></td>
            <td><?php echo $rankingData['value']?></td>
            <?php if(!$isRoomRanking) :?>
            <td>
            	<?php echo $rankingData['correctPredictions']?><br />
            </td>	
            <td>
	            <?php if (isset($kupData) && isset($kupData['status']) && ($kupData['status'] == -1 || $kupData['status'] >= 3)): ?>
	            <i><?php echo util::displayDateCompleteFromTimestampComplet($rankingData['firstPrediction'])?></i>
	            <?php else: ?>
	            -
	            <?php endif;?>
            </td>
            <?php endif;?>
        </tr>
        <?php endif; ?>
        <?php endforeach ?>
    </table>
    <div class="tabClassementBottom">
    	<a href="javascript:void(0);" onclick="loadRanking('<?php echo ceil($memberPosition/$batchSize)?>', '<?php echo $batchSize?>');">
    		<?php echo __('kup_ranking_link_go_to_ranking_label') ?>
    	</a>
    </div>
    <div class="ranking-pagination">
    	<?php include_component('interface', 'pagination', array('offset' => $offset, 'batchSize' => $batchSize, 'totalKups' => $nbPlayers, 'functionKupsLoad' => 'loadRanking'))?>
    </div>
    <div style="clear:both"></div>
</form>
<?php else: ?>
<div style="height: 45px;"></div>
<a href="<?php echo url_for(array('module'=>$module, 'action'=>$action, 'kup_uuid' => $kup_uuid,  'room_uuid' => $room_uuid)) ?>">
<?php echo __('label_kup_ranking_none') ?>
</a>
<div style="height: 45px;"></div>
<?php endif ?>
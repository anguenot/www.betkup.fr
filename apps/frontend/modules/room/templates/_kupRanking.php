<?php if (count($kupsRankingData) > 0): ?>
<form action="" method="post" name="frmClassementList" class="frmClassementList" >
    <!--  div class="affine">
        <?php echo __('label_kup_ranking_adjust_ranking') ?>
        <select name="frmClassementList_affine">
            <option value="0"><?php echo __('label_kup_ranking_general') ?></option>
        </select>
    </div -->
    <table style="width:730px; border-collapse: separate; border-spacing: 0px;">
        <tr>
            <th width="25">&nbsp;</th>
            <th style="text-align: center;"><?php echo __('label_kup_ranking_player_name') ?></th>
            <th style="text-align: center;" width="60"><?php echo __('label_kup_ranking_nb_points') ?></th>
            <th style="text-align: center;" width="60"><?php echo __('label_kup_ranking_correct_predictions') ?></th>
           	<?php if (isset($kupData['config']['tb'])): ?>
            <th style="text-align: center;" width="75"><?php echo __('label_kup_ranking_question_tiebreaker') ?></th>
            <?php endif ?>
            <th style="text-align: center;" width="160"><?php echo __('label_kup_first_prediction') ?></th>
            <th style="text-align: center;" width="100"><?php echo __('label_kup_ranking_possible_winnings') ?></th>
        </tr>
        <?php foreach ($kupsRankingData as $kupRankingData): ?>
        <tr class="<?php echo (($kupRankingData['position'] % 2) ? 'pair' : 'impair') . ($sf_user->getAttribute('email', '', 'subscriber') == $kupRankingData['member']['email'] ? ' selected' : '') ?>">
            <td class="num"><?php echo $kupRankingData['position'] ?></td>
            <td class="gamer">
            	<div class="<?php echo $kupRankingData['position'] <= $kupData['nbWinners'] ? 'winner' : 'gamer' ?>"></div>

                <?php include_component('interface', 'userAvatar', array(
                                                                        'alt'        => 'Avatar',
                                                                        'avatarPath' => $kupRankingData['member']['avatarBig'],
                                                                        'canvasSize' => '40x40',
                                                                        'wAnimateTo' => '150',
                                                                        'hAnimateTo' => '150',
                                                                        'class' => 'ranking-room-kup-avatar',
                                                                        'id' => $kupRankingData['position']
                                                                   )) ?>

                <?php echo $kupRankingData['member']['nickName'] ?></td>
            <td><?php echo $kupRankingData['value']?></td>
            <td>
            	<?php echo $kupRankingData['correctPredictions']?><br />
            </td>
            <?php if (isset($kupData['config']['tb'])): ?>
            <td><?php echo ($kupData['status'] == -1 || $kupData['status'] >= 3) ? $kupRankingData['tieBreakerQuestionAnswer'] : '-' ?></td>
            <?php endif ?>
            <!-- td><?php echo image_tag('kup/classement/equal.png', array('alt' => '', 'size'=>'29x50') ) ?></td-->
            <td>
            <?php if ($kupData['status'] == -1 || $kupData['status'] >= 3): ?>
            <i><?php echo util::displayDateCompleteFromTimestampComplet($kupRankingData['firstPrediction'])?></i>
            <?php else: ?>
            -
            <?php endif;?>
            </td>
            <td class="num">
            <?php if ($kupData['type'] == 'GAMBLING_FR'): ?>
            	<?php if($kupData['status'] == 5 && $sf_user->getAttribute('email', '', 'subscriber') == $kupRankingData['member']['email']) :?>
            	<a href="javascript:void(0);" class="publish_jackpot" onclick="publishFacebook()">
            		<?php echo $kupRankingData['winnings']?> €
            	</a>
            	<?php else: ?>
            		<?php echo $kupRankingData['winnings']?> €
            	<?php endif;?>
            <?php else: ?>
            -
            <?php endif;?>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    <div class="tabClassementBottom">
    	<?php echo link_to(__('kup_ranking_link_go_to_ranking_label'),array('module'=>'room', 'action'=>'kupRanking', 'room_uuid' => $room_uuid, 'kup_uuid'=>$uuid,'tab'=>'ranking','offset' =>$offsetMemberRanking))?>
    </div>
    <div class="tabClassementBottomPage">
    	<div style="margin-top: 10px;">
        <?php if ($offset > 0): ?>
        <?php if (!isset($room_uuid)): ?>
        <?php if($supToMiddle == '1' || $supToLast == '1' || ($nbPageRemaining != $nbPage)):?>
        	<?php echo link_to(image_tag('kup/classement/pageFirst.png',array('alt' => '', 'size'=>'19x19')),array('module'=>'room', 'action'=>'kupRanking', 'room_uuid' => $room_uuid, 'kup_uuid'=>$uuid,'tab'=>'ranking', 'offset' => '0'))?>
		<?php endif;?>
        <a href="<?php echo url_for(array('module'=>'room', 'action'=>'kupRanking', 'room_uuid' => $room_uuid, 'kup_uuid'=>$uuid,'tab'=>'ranking', 'offset' => intval($offset)-intval($batch))) ?>" title=""><?php echo image_tag('kup/classement/pageBack.png', array('alt' => '', 'size'=>'19x19') ) ?></a>
        <?php else: ?>
        <?php if($supToMiddle == '1' || $supToLast == '1' || ($nbPageRemaining != $nbPage)):?>
        	<?php echo link_to(image_tag('kup/classement/pageFirst.png',array('alt' => '', 'size'=>'19x19')),array('module'=>'room', 'action'=>'kupRanking', 'kup_uuid' => $uuid,  'room_uuid' => $room_uuid, 'tab' => 'ranking', 'offset' => intval($offset)+intval($batch)))?>
		<?php endif;?>
        <a href="<?php echo url_for(array('module'=>'room', 'action'=>'kupRanking', 'kup_uuid' => $uuid, 'room_uuid' => $room_uuid, 'tab' => 'ranking', 'offset' => intval($offset)-intval($batch))) ?>" title=""><?php echo image_tag('kup/classement/pageBack.png', array('alt' => '', 'size'=>'19x19') ) ?></a>
        &nbsp;&nbsp;
        <?php endif ?>
        <?php endif ?>

        <?php if($supToFirst == '1'):?>
	        <?php for ($i = 1; $i <= $nbPage; $i++):?>
		        <?php if($i <= ($numActualPage+2)):?>
			    	<?php if (!isset($room_uuid)): ?>
			       		<?php echo button_to($i,array('module'=>'room', 'action'=>'kupRanking', 'room_uuid' => $room_uuid, 'kup_uuid'=>$uuid,'tab'=>'ranking', 'offset' => ($batch*($i-1))),array('class'=>'paginate'))?>
			       	<?php else: ?>
			       		<?php echo button_to($i,array('module'=>'room', 'action'=>'kupRanking', 'kup_uuid' => $uuid,  'room_uuid' => $room_uuid, 'tab' => 'ranking', 'offset' => ($batch*($i-1))),array('class'=>'paginate'))?>
			        <?php endif ?>
			<?php endif;?>
			<?php endfor;?>
			<?php if(!($nbPage <= '3')): ?>
			<?php echo image_tag('kup/classement/pagePoints.png', array('alt' => '', 'size'=>'19x19')); ?>
			<?php endif;?>
		<?php elseif($supToMiddle == '1'):?>
		        <?php if (!isset($room_uuid)): ?>
		        		<?php echo image_tag('kup/classement/pagePoints.png', array('alt' => '', 'size'=>'19x19') ) ?>
		        		<?php echo button_to(($numActualPage-2),array('module'=>'room', 'action'=>'kupRanking', 'room_uuid' => $room_uuid, 'kup_uuid'=>$uuid,'tab'=>'ranking', 'offset' => ($batch*($numActualPage-3))),array('class'=>'paginate'))?>
						<?php echo button_to(($numActualPage-1),array('module'=>'room', 'action'=>'kupRanking', 'room_uuid' => $room_uuid, 'kup_uuid'=>$uuid,'tab'=>'ranking', 'offset' => ($batch*($numActualPage-2))),array('class'=>'paginate'))?>
		       			<?php echo button_to($numActualPage,array('module'=>'room', 'action'=>'kupRanking', 'room_uuid' => $room_uuid, 'kup_uuid'=>$uuid,'tab'=>'ranking', 'offset' => ($batch*($numActualPage-1))),array('class'=>'paginate'))?>
			      		<?php echo button_to(($numActualPage+1),array('module'=>'room', 'action'=>'kupRanking', 'room_uuid' => $room_uuid, 'kup_uuid'=>$uuid,'tab'=>'ranking', 'offset' => ($batch*($numActualPage))),array('class'=>'paginate'))?>
			    		<?php echo button_to(($numActualPage+2),array('module'=>'room', 'action'=>'kupRanking', 'room_uuid' => $room_uuid, 'kup_uuid'=>$uuid,'tab'=>'ranking', 'offset' => ($batch*($numActualPage+1))),array('class'=>'paginate'))?>
		       			<?php echo image_tag('kup/classement/pagePoints.png', array('alt' => '', 'size'=>'19x19') ) ?>
		       		<?php else: ?>
		      			<?php echo image_tag('kup/classement/pagePoints.png', array('alt' => '', 'size'=>'19x19') ) ?>
		      			<?php echo button_to(($numActualPage-2),array('module'=>'room', 'action'=>'kupRanking', 'kup_uuid' => $uuid,  'room_uuid' => $room_uuid, 'tab' => 'ranking', 'offset' => ($batch*($numActualPage-3))),array('class'=>'paginate'))?>
						<?php echo button_to(($numActualPage-1),array('module'=>'room', 'action'=>'kupRanking', 'kup_uuid' => $uuid,  'room_uuid' => $room_uuid, 'tab' => 'ranking', 'offset' => ($batch*($numActualPage-2))),array('class'=>'paginate'))?>
			        	<?php echo button_to($numActualPage,array('module'=>'room', 'action'=>'kupRanking', 'kup_uuid' => $uuid,  'room_uuid' => $room_uuid, 'tab' => 'ranking', 'offset' => ($batch*($numActualPage-1))),array('class'=>'paginate'))?>
			       		<?php echo button_to(($numActualPage+1),array('module'=>'room', 'action'=>'kupRanking', 'kup_uuid' => $uuid,  'room_uuid' => $room_uuid, 'tab' => 'ranking', 'offset' => ($batch*($numActualPage))),array('class'=>'paginate'))?>
			       		<?php echo button_to(($numActualPage+2),array('module'=>'room', 'action'=>'kupRanking', 'kup_uuid' => $uuid,  'room_uuid' => $room_uuid, 'tab' => 'ranking', 'offset' => ($batch*($numActualPage+1))),array('class'=>'paginate'))?>
			     		<?php echo image_tag('kup/classement/pagePoints.png', array('alt' => '', 'size'=>'19x19') ) ?>
		     		<?php endif ?>
        <?php elseif($supToLast == '1'):?>
	        <?php if (!isset($room_uuid)): ?>
				<?php if(!($nbPage <= '3')){echo image_tag('kup/classement/pagePoints.png', array('alt' => '', 'size'=>'19x19'));} ?>
				<?php for ($i = ($numActualPage-2); $i <= $nbPage; $i++):?>
					<?php if($i != '0'):?>
					  		<?php echo button_to($i,array('module'=>'room', 'action'=>'kupRanking', 'room_uuid' => $room_uuid, 'kup_uuid'=>$uuid,'tab'=>'ranking', 'offset' => ($batch*($i-1))),array('class'=>'paginate'))?>
					<?php endif;?>
				<?php endfor;?>
				<?php else: ?>
				<?php if($nbPage!='2'){echo image_tag('kup/classement/pagePoints.png', array('alt' => '', 'size'=>'19x19'));} ?>
				<?php for ($i = ($numActualPage-2); $i <= $nbPage; $i++):?>
					<?php if($i != '0'):?>
						<?php echo button_to($i,array('module'=>'room', 'action'=>'kupRanking', 'kup_uuid' => $uuid,  'room_uuid' => $room_uuid, 'tab' => 'ranking', 'offset' => ($batch*($i-1))),array('class'=>'paginate'))?>
					<?php endif;?>
				<?php endfor;?>
			<?php endif;?>
        <?php endif;?>

        <?php if (count($kupsRankingData) >= $batch): ?>
        <?php if (!isset($room_uuid)): ?>
        <?php if($nbPageRemaining != '0'):?>
        	<a href="<?php echo url_for(array('module'=>'room', 'action'=>'kupRanking', 'room_uuid' => $room_uuid, 'kup_uuid'=>$uuid,'tab'=>'ranking', 'offset' => intval($offset)+intval($batch))) ?>" title=""><?php echo image_tag('kup/classement/pageNext.png', array('alt' => '', 'size'=>'19x19') ) ?></a>
        <?php endif;?>
        <?php if($supToMiddle == '1' || $supToFirst == '1' || $nbPageRemaining != '0'):?>
        	<?php echo link_to(image_tag('kup/classement/pageLast.png',array('alt' => '', 'size'=>'19x19','style'=>'margin:0; padding:0;')),array('module'=>'room', 'action'=>'kupRanking', 'room_uuid' => $room_uuid, 'kup_uuid'=>$uuid,'tab'=>'ranking', 'offset' => ($batch*($nbPage-1))))?>
		<?php endif;?>
        <?php else: ?>
        <?php if($nbPageRemaining != '0'):?>
       	<a href="<?php echo url_for(array('module'=>'room', 'action'=>'kupRanking', 'kup_uuid' => $uuid,  'room_uuid' => $room_uuid, 'tab' => 'ranking', 'offset' => intval($offset)+intval($batch))) ?>" title=""><?php echo image_tag('kup/classement/pageNext.png', array('alt' => '', 'size'=>'19x19') ) ?></a>
        <?php endif;?>
        <?php if($supToMiddle == '1' || $supToFirst == '1' || $nbPageRemaining != '0'):?>
        	<?php echo link_to(image_tag('kup/classement/pageLast.png',array('alt' => '', 'size'=>'19x19')),array('module'=>'room', 'action'=>'kupRanking', 'kup_uuid' => $uuid,  'room_uuid' => $room_uuid, 'tab' => 'ranking', 'offset' => ($batch*($nbPage-1))))?>
		<?php endif;?>
        <?php endif ?>
        <?php endif ?>
        </div>
    </div>
    <div style="clear:both"></div>
</form>
<script type="text/javascript">
	$('input[value="<?php echo $numActualPage;?>"]').addClass('pageSelect');

	function publishFacebook() {
		FB.ui({ method: 'feed', 
	        	link: "<?php echo $urlForFacebook ?>",
	        	properties: <?php echo json_encode($sf_data->getRaw('properties')) ?>,
	        	description: "<?php echo $description ?>"
	    });
	    
	    return false;
	}
</script>
<?php else: ?>
<div style="height: 45px;"></div>
<a href="<?php echo url_for(array('module'=>'room', 'action'=>'kup', 'kup_uuid' => $uuid,  'room_uuid' => $room_uuid)) ?>">
<?php echo __('label_kup_ranking_none') ?>
</a>
<div style="height: 45px;"></div>
<?php endif ?>
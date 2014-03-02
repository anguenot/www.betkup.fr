<?php foreach ($rooms as $room): ?>
<td class="sofunBatchTdDiv" align="left" valign="top">
<div class="room-with-kups">
	<a href="<?php echo url_for(array('module'=>'room', 'action'=>'view', 'uuid'=>$room["uuid"])) ?>" style="display: block; position: absolute; left: 0; top: 0; z-index: 10; width: 308px; height: 80px;"></a>
    <div class="room-vignette">     
        <span class="titre"><?php echo Util::coupe($room["name"], 7, '..') ?></span>
        <span class="legende"><?php echo Util::coupe($room["author_nickname"], 20, '..') ?></span>
        <div class="bloc-image">
        <?php if (isset($roomUI["avatar-room"]) && $roomUI["avatar-room"] != '') {
        	echo image_tag($roomUI["avatar-room"] ,array('size'=>'114x70'));
        }else{
        	echo (isset($avatarList[$room["uuid"].'_thumb'])) ? image_tag($avatarList[$room["uuid"].'_thumb'] ,array('size'=>'114x70')) : image_tag(sfConfig::get('mod_room_avatar_default') ,array('size'=>'114x70'));
        }?>
        </div>
        <?php if ($room['official'] == '1'): ?>
        	<?php echo image_tag('/images/room/home/officiel.png', array('size' => '23x70', 'style' =>'position: absolute; left: 265px; top: -5px;'))?>
        <?php endif ?>
        <div class="bloc-bottom">
            <div class="bloc-picto">
            	<table>
	            	<tr>
		            	<td style="text-align: center;" class="bloc-image-picto">
		            	<?php if($room['privacy'] == sfConfig::get('app_room_privacy_public')) :?>
		            	<?php echo image_tag('/image/default/me/public.png', array('size' => '13x14'));?>
		            	<?php else :?>
		            	<?php echo image_tag('/image/default/me/private.png', array('size' => '10x14'));?>
		            	<?php endif;?>
		            	</td>
		            	<td>
		                	<span class="legende"><?php echo $room["legendes"]["legend1"] ?></span>
		                </td>
	                </tr>
                </table>
            </div>
            <div class="bloc-picto">
            	<table>
	            	<tr>
		            	<td style="text-align: center;" class="bloc-image-picto">
            				<?php echo image_tag('/image/default/me/facebook.png', array('size' => '11x11'));?>
                		</td>
                		<td>
                			<span class="legende"><?php echo $room["legendes"]["legend4"] ?></span>
                		</td>
                	</tr>
                </table>
            </div>
            <div class="bloc-picto">
            	<table>
	            	<tr>
		            	<td style="text-align: center;" class="bloc-image-picto">
            				<?php echo image_tag('/image/default/me/kup.png', array('size' => '12x14'));?>
                		</td>
                		<td>
                			<span class="legende"><?php echo $room["legendes"]["legend2"] ?></span>
                		</td>
                	</tr>
                </table>
            </div>
            <div class="bloc-picto">
            	<table>
	            	<tr>
		            	<td style="text-align: center;" class="bloc-image-picto">
            				<?php echo image_tag('/image/default/me/players.png', array('size' => '15x15'));?>
                		</td>
                		<td>
                			<span class="legende"><?php echo $room["legendes"]["legend4"] ?></span>
                		</td>
	                </tr>
                </table>
            </div>
            <div class="bloc-picto">
            	<table>
	            	<tr>
		            	<td style="text-align: center;" class="bloc-image-picto">
		            		<?php echo image_tag('/image/default/me/money.png', array('size' => '17x11'));?>
		                </td>
		                <td>
		                	<span class="legende"><?php echo $room["legendes"]["legend3"] ?></span>
		                </td>
	                </tr>
                </table>
   	        </div>
        </div>
        
        <?php if ($sf_user->getAttribute('email', '', 'subscriber') == $room["author_email"]): ?>
		<a href="<?php echo url_for(array('module'=>'room', 'action'=>'edit', 'uuid'=>$room['uuid'])) ?>" class="admin">
		<?php echo image_tag('/image/' . $sf_user->getCulture(). '/room/me/admin.png', array('alt' => __('label_me_room_admin_link'), 'size' => '58x21')) ?>
		</a>
		<?php endif; ?>
    </div>
	<?php if ($room['numberOfKups'] > 0) : ?>
		<?php include_component('kup', 'kupsRoom', array(
                                                        'parentModule' => $parentModule,
                                                        'elementHeight' => 187,
                                                        'batchSize' => '2',
                                                        'nbLine' => '1',
                                                        'nbDisplay' => '2',
                                                        'uuid' => $room["uuid"],
                                                        'totalKups' => $room['numberOfKups'],
                                                        'isInsideRoom' => 1 )) ?>
    <?php else : ?>
	<div class="no-kups">
            <?php echo image_tag('/image/default/me/alert.png', array('class' => 'alert', 'size' => '12x12', 'alt' => __('label_me_alert'))) ?>
            <?php echo __('text_me_no_kup_in_room'); ?>
	</div>
	<?php endif; ?>
</div>
</td>
<?php endforeach;?>

<div class="moncompte">
    <?php include_component('account', 'navigation', array()) ?>
    <div class="room">
    	<table id="room_table" style="margin-top: -2px;">
        	<tr>
            	<td style="vertical-align: top; width: 760px;">
			        <div class="view">
			            <?php include_component('interface', 'areaOneBegin', array('margintop' => 4)) ?>
			
			            <div style="margin: 0px; height: 20px; "></div>
			
			            <div style="margin: 0px; padding: 0px; width: 716px; height: 66px; background: url('/images/room/header2.png');">
			            <div style="position: absolute; margin: 0px; padding: 0px; margin-left: 585px; margin-top: 22px;">
			                <div style="height: 16px; padding-left: 9px; background: url('/images/interface/background/link.png') no-repeat;">
			                    <a href="<?php echo url_for(array('module' => 'room', 'action' => 'view', 'uuid' => $uuid)) ?>" class="orange12">
			                        <?php echo __("label_back_to_room_user_home") ?>
			                    </a>
			                </div>
			            </div>
			            </div>
			
			            <div style="margin-left: 30px; margin-bottom: 35px; width: 651px; height: 38px; background: url('/image/<?php echo $sf_user->getCulture() ?>/room/room_create_step2.png');"></div>
			
			            <div style="margin: 0px; padding: 0px; width: 711px; margin-bottom: 30px;">
			                <div style="height: 25px;"></div>
			
			                    <div>
			                        <table>
			                            <tr>
			                                <td style="padding-left: 15px; vertical-align: middle;">
			                                    <?php echo image_tag('/image/default/me/alert.png', array('class' => 'alert', 'size' => '12x12', 'alt' => __('label_me_alert'))); ?>
			                                </td>
			                                <td style="padding-left: 10px; vertical-align: middle;">
			                                    <span class="only-kup-closed"><?php echo __('text_kups_choose_and_configure'); ?></span>
			                                </td>
			                            </tr>
			                        </table>
			                    </div>
			
			                    <div style="height: 25px;"></div>
			
			                    <?php echo image_tag('/image/' . $sf_user->getCulture(). '/room/kups_header.png', array('alt' => __('label_room_kups_header'), 'size' => '710x78')) ?>
			
			                <div>
			                    <table style="width: 710px; border-collapse:collapse; border-spacing: 0; text-align: center; vertical-align: middle;">
			                        <tr>
			                            <td style="text-align: center; vertical-align: middle;">
			                                <div id="loading-div1" style="margin: 0px;"><?php echo image_tag('/images/interface/wait_big.gif'); ?></div>
			                            </td>
			                        </tr>
			                    </table>
			                </div>
			                
			                <div id="room_kups_manage" style="width: 709px;"></div>
			                
			            </div>
			
			            <div style="height: 20px;"></div>
			            <div align="center">
			                <a href="<?php echo url_for(array('module' => 'room', 'action' => 'createInvite', 'uuid' => $uuid)); ?>">
			                    <?php echo image_tag('/images/interface/button/nextStep.png'); ?>
			                </a>
			            </div>
			            <div style="height: 65px;"></div>
			            <?php include_component('interface', 'areaOneEnd') ?>
			        </div>
				</td>
				<td style="vertical-align: top; width: 220px;">
					<div style="padding-left: 5px; padding-top: 7px;">
						<?php include_component('room', 'right') ?>
					</div>
				</td>
			</tr>
		</table>
    </div>
</div>
<script type="text/javascript">
$(function() {
    $.ajax({
        url:'<?php echo url_for(array('module'=>'room', 'action'=>'editKups', 'uuid'=> $uuid)) ?>',
        type:'get',
        dataType:'html',
        success:function(data, textStatus){
                $('#room_kups_manage').html(data);
        },
        beforeSend:function(XMLHttpRequest){
                $("#loading-div1").show();
        },
        complete:function(XMLHttpRequest, textStatus){
                $("#loading-div1").hide();
        }
    });
});
</script>
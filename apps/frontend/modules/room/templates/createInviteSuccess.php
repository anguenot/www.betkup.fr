<script type="text/javascript">
$(function () {
	$.ajax({
		  type: "GET",
		  url: "<?php echo url_for(array('module' => 'invite', 'action' => 'index', 'room_uuid' => $roomUuid, 'room_data' => $roomData)) ?>",
		  success: function(data) {
			  $('#view').html(data);
		  }
	});
});
</script>
<div class="moncompte">
    <?php include_component('account', 'navigation', array()) ?>
    <div class="room">
    	<table id="room_table" style="margin-top: -2px;">
        	<tr>
            	<td style="vertical-align: top; width: 760px;">
    		<?php include_component('interface', 'areaOneBegin', array('margintop' => 4)) ?>
	        <div style="margin: 0px; height: 20px; "></div>
            <div style="margin: 0px; padding: 0px; width: 716px; height: 66px; background: url('/images/room/header2.png');">
            <div style="position: absolute; margin: 0px; padding: 0px; margin-left: 585px; margin-top: 22px;">
                <div style="height: 16px; padding-left: 9px; background: url('/images/interface/background/link.png') no-repeat;">
                    <a href="<?php echo url_for(array('module' => 'room', 'action' => 'view', 'uuid' => $room_uuid)) ?>" class="orange12">
			        	<?php echo __("label_back_to_room_user_home") ?>
			        </a>
                </div>
            </div>
            </div>
            <div style="margin-left: 30px; margin-bottom: 35px; width: 651px; height: 38px; background: url('/image/<?php echo $sf_user->getCulture() ?>/room/room_create_step3.png');"></div>
	        
        	<div id="view"></div>
	        
			<div style="height: 20px;"></div>
	        <div style="width: 300px; margin-left: auto; margin-right: auto; text-align: center;">
	        	<a href="<?php echo url_for(array('module' => 'room', 'action' => 'view', 'uuid' => $room_uuid)); ?>">
	            	<?php echo image_tag('/image/'.$sf_user->getCulture().'/room/button_go_to_room.png', array('size' => '200x40')); ?>
	           	</a>
	       	</div>
	        <div style="height: 65px;"></div>
        	<?php include_component('interface', 'areaOneEnd') ?>
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
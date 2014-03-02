<div class="moncompte">
	<?php include_component('account', 'navigation', array()) ?>
	<div class="room">
		<table id="room_table" style="margin-top: -2px;">
	    	<tr>
	        	<td style="vertical-align: top; width: 760px;">
					<div class="view">
						<?php include_component('interface', 'areaOneBegin', array('margintop' => 4, 'marginleft' => 13)) ?>
						<div style="margin-left: 20px;">
							<?php echo image_tag('/image/default/room/room_search_header.png', array('size' => '274x85', 'style' => 'border: none;'))?>
							<?php include_component('account', 'title', array('racine' => 'room_front', 'altImg' => 'Rooms a la une', 'area' => 'areaOne')) ?>
						</div>
						<?php include_component('room', 'roomHome'); ?>
						<script type="text/javascript">
		
			            $(".bloc-content").mouseover(function() {
			                $(".vignetteTexte",$(this).parent()).fadeIn('fast');
			                $(".vignetteLegendeBack", $(this).parent()).fadeOut('fast');
			            });
		
			            $(".bloc").mouseleave(function() {
			                $(".vignetteTexte",$(this)).fadeOut("fast");
			                $(".vignetteLegendeBack", $(this).parent()).fadeIn('fast');
			            });
						</script>
						<div style="margin-left: 20px; margin-top:-40px;">
						<?php include_component('account', 'title', array('racine' => 'rechercherUneRoom', 'altImg' => __('label_title_search_rooms'), 'area' => 'areaOne')) ?>
						<?php include_component('room', 'search', array('version' => 'blanc')) ?>
						</div>
						<div style="height: 50px;"></div>
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
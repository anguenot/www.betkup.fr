<div class="room" align="center">
    <div class="header">
        <div class="link">
            <a href="<?php echo url_for(array('module' => 'room', 'action' => 'index')) ?>"><?php echo __('Voir toutes les rooms') ?></a>
        </div>
    </div>
    <div class="content">
        <div style="margin: 0px; padding: 0px; height: 15px;"></div>
            <div align="center" style="margin-left: 38px; margin-right: 40px;">
                <div id="masqueRooms" style="padding-top: 5px; position:relative;width:905px; height: 260px; overflow:hidden;">
                    <div id="bandeRooms" style="position:relative; left:0px;">
                        <table id="tabRooms" style="padding:0; border-spacing: 0; border-collapse: 0; height: 260px;">
                            <tr>
                            <?php foreach ($roomsData as $data): ?>
                                <td style="width:227,5px;" align="center" valign="middle">
                                    <?php include_component('room', 'roomThumbnailHomePage', $data) ?>
                                </td>
                            <?php endforeach ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

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

        <div class="footer">
            <a href="javascript:void(0);" onClick="moveRooms('l');" id="kupHomeLeftButton" style="margin-right: -4px;">
                <?php echo image_tag('/images/kup/home/left.png',array('id'=>'newsfeedGauche','border'=>'0'))?>
            </a>
             <a href="javascript:void(0);" onClick="moveRooms('r');" id="kupHomeLeftButton">
                <?php echo image_tag('/images/kup/home/right.png',array('id'=>'newsfeedGauche','border'=>'0'))?>
            </a>
            <div align="center">
                <a href="<?php echo url_for(array('module' => 'room', 'action' => 'search')) ?>">
                	<?php echo image_tag('/images/room/bloc/searchRoom.png',array('border'=>'0','id'=>'searchRoom','style'=>'margin-left: 47px;'))?>
                </a>
                <a href="<?php echo url_for(array('module' => 'room', 'action' => 'create')) ?>">
                	<?php echo image_tag('/images/room/bloc/createRoom.png',array('id'=>'createRoom','border'=>'0'))?>
                </a>
            </div>
        </div>
    </div>

    <script>
		tweenRooms = null;
		function moveRooms(sens){
			if (tweenRooms && tweenRooms.isPlaying) {
				return;
			}
			
			var currentLeft = parseInt($("div#bandeRooms").css('left'));
			var currentRight = parseInt($("div#bandeRooms").css('right'));
		    var maxWidth = parseInt($("#bandeRooms table").css('width'));
		    var unitWidth = parseInt($("#bandeRooms table tr td").css('width'));
		    
			var end = null;
			if (sens == 'l') {
				if (currentLeft >= 0) {
					end = (4*unitWidth) - maxWidth;
					tweenRooms = new Tween($("#bandeRooms").get(0).style, "left", Tween.regularEaseOut, currentLeft, end, 0.5, "px");
					tweenRooms.start();
					return;
				}
				end = currentLeft + unitWidth;
			} else {
				if ((maxWidth - Math.abs(currentLeft) - 4*unitWidth) < unitWidth) {
					//return;
				}
				end = currentLeft - unitWidth;
			}
			
			if((sens == 'r') && (maxWidth - Math.abs(currentLeft) - 4*unitWidth) < unitWidth) {
				end = "0";
				tweenRooms = new Tween($("#bandeRooms").get(0).style, "left", Tween.regularEaseOut, currentLeft, end, 0.5, "px");
				tweenRooms.start();
				return;
			}
			
			tweenRooms = new Tween($("#bandeRooms").get(0).style, "left", Tween.regularEaseOut, currentLeft, end, 0.5, "px");
			tweenRooms.start();
		}
		
		setInterval(function() {
			$(this).click(moveRooms('r'));
		}, 15000);
	</script>
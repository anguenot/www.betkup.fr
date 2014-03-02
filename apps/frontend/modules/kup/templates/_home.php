<?php $LARG = "940" ?>
<?php $HAUT = "180" ?>
<div class="kup" align="center">
    <div class="header">
        <div class="link">
            <a href="<?php echo url_for(array('module' => 'kup', 'action' => 'index')) ?>"><?php echo __('Voir toutes les kups') ?></a>
        </div>
    </div>
    <div class="content">
        <div style="margin: 0px; padding: 0px; height: 7px;"></div>
        <div align="left" style="margin-left: 10px;">
            <div id="masqueLogos" style="position:relative;width: <?php echo $LARG ?>px;height:<?php echo $HAUT ?>px;overflow:hidden; padding-top: 5px;">
                <div id="bandeLogos" style="position:relative;left:0px;">
                    <table style="padding: 0px; height: <?php echo $HAUT ?>px; border-spacing: 0px; border-collapse:collapse;" id="tabLogos">
                        <tr>
                            <?php foreach ($kupsData as $data): ?>
                                <td width="235" align="center" valign="middle" >
                                    <?php include_component('kup', 'kupThumbnailHome', array('data' => $data)) ?>
                                </td>
                            <?php endforeach ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div style="margin: 0px; padding: 0px; height: 4px;"></div>
    </div>
    <div class="footer">
        <table style="width: 910px; border-spacing: 0px; border-collapse:collapse;">
            <tr>
                <td align="right" valign="middle">
                    <table style="border-spacing: 0px; border-collapse:collapse;">
                        <tr>
                            <td>
                                <a href="javascript:void(0);" onClick="moveLogos('l');" id="kupHomeLeftButton">
                                    <?php echo image_tag('/images/kup/home/left.png',array('id'=>'newsfeedGauche','border'=>'0'))?>
                                </a>
                            </td>
                            <td>
                                <a href="javascript:void(0);" onClick="moveLogos('r');" id="kupHomeLeftButton">
                                	<?php echo image_tag('/images/kup/home/right.png',array('id'=>'newsfeedGauche','border'=>'0'))?>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="vide"></div>
</div>
<script type="text/javascript">
var tweenKups = null;
function moveLogos(sens) {
	if (tweenKups && tweenKups.isPlaying) {
		return;
	}
	
	var currentLeft = parseInt($("#bandeLogos").css('left'));
	var currentRight = parseInt($("#bandeLogos").css('right'));
	var maxWidth = parseInt($("#tabLogos").width());
	var unitWidth = parseInt($("#bandeLogos table tr td").css('width'));

	var end = null;
	if (sens == 'l') {
		if (currentLeft == 0) {
			end = (4*unitWidth) - maxWidth;
			tweenKups = new Tween($("#bandeLogos").get(0).style, "left", Tween.regularEaseOut, currentLeft, end, 0.5, "px");
			tweenKups.start();
			return;
		}
		end = currentLeft + unitWidth;
	} else {
		end = currentLeft - unitWidth;
	}
	
	if ((sens == 'r') && (maxWidth - Math.abs(currentLeft) - 4*unitWidth) < unitWidth) {
		end = "0";
		tweenKups = new Tween($("#bandeLogos").get(0).style, "left", Tween.regularEaseOut, currentLeft, end, 0.5, "px");
		tweenKups.start();
		return;
	}
	tweenKups = new Tween($("#bandeLogos").get(0).style, "left", Tween.regularEaseOut, currentLeft, end, 0.5, "px");
	tweenKups.start();
}
</script>
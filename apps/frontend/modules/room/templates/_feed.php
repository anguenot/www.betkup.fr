<?php $LARG = 430 ?>
<?php $HAUT = 138 ?>
<div class="datas">
    <table style="border-spacing: 0;">
		<tr>
			<td align="left" valign="top" colspan="2">
				<div style="width: 361px; height: 50px;">
					<div class="header_table_select" align="right">
					<?php include_component('interface', 'select', array(
                            'bloc' => 'home_kup_select',
                            'width1' => '0',
                            'width2' => '140',
                            'width3' => '0',
                            'widthGadget' => '100',
                            'marginLeftError' => '0',
                            'messageError' => '',
                            'blocType' => 'text',
                            'blocIcone' => '',
                            'blocName' => 'homeKupSelect',
                            'blocLegende' => '',
                            'blocValue' => '',
							'blocFirstRow' => '',
                        	'blocChoices' => $kupsNames,
                            'blocHelp' => ''))
					?>
					</div>
				</div>
			</td>
		</tr>
		<tr>
            <td align="left" valign="top">
                <div id="masqueNews" style="height:<?php echo $HAUT ?>px; overflow:hidden;">
                    <div id="bandeNews" style="left: 0px; top: 0px;">
                        <table style="border-spacing: 0;" id="tabNews">
                            <tr>
                                <td>
                                <?php foreach ($feedData as $data): ?>
                                    <div class="row">
                                        <div class="cellule1 <?php echo $data["cellColor"] ?>">
                                            <img src="/image/default/feed/<?php echo $data["picto"] ?>" border="0" alt="">
                                        </div>
                                        <div class="cellule2 <?php echo $data["cellColor"] ?>">
                                        <?php if ($data["avatar"] != "") { ?>
                                            <img src="<?php echo $data["avatar"] ?>" border="0" width="24" height="24">
                                            <?php  } else { ?>
                                            <img src="/image/default/member/avatar/default_small.png" border="0" width="24" height="24">
                                            <?php  }?>
                                            <p><?php echo __($data["title"]) ?></p>
                                        </div>
                                        <div class="cellule3 <?php echo $data["cellColor"] ?>">
                                            <p><?php echo $data["ago"] ?></p>
                                        </div>
                                    </div>
                                    <div style="clear: both; margin: 0px; padding: 0px; height: 2px;"></div>
                                    <?php endforeach ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td align="left" valign="top">
                <table style="border-spacing: 0;">
                    <tr>
                        <td height="69" align="left" valign="top">
                            <a href="javascript:void(0);" onClick="moveNews('d');" id="kupHomeLeftButton">
                                <img src="/images/home/boutonTop.png" border="0" />
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td height="69" align="left" valign="bottom">
                            <a href="javascript:void(0);" onClick="moveNews('u');" id="kupHomeLeftButton">
                                <img src="/images/home/boutonBottom.png" border="0" />
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<?php $LARG = $HAUT; ?>
<script>
    function moveNews(sens){
        DIV = document.getElementById("bandeNews");
        LEFT = DIV.style.top;
        LEFT = parseInt(LEFT.replace("px", ""));
        WIDTH = document.getElementById("tabNews").height;
        if( WIDTH <= <?php echo $LARG ?> ) {

        }
        else {
            if(sens == "u") {
                limite = WIDTH - <?php echo $LARG ?>;
                if(LEFT-<?php echo $LARG ?> < -limite){ fin = -limite; }
                else { fin = LEFT-<?php echo $LARG ?> }

                fin = fin + 50;

                t1 = new Tween(DIV.style,"top",Tween.regularEaseOut,LEFT,fin,1.5,"px");
                t1.start();
            }
            else {
                limite = 0;
                if(LEFT+<?php echo $LARG ?> > limite){ fin = limite; }
                else { fin = LEFT+<?php echo $LARG ?> }

                t1 = new Tween(DIV.style,"top",Tween.regularEaseOut,LEFT,fin,1.5,"px");
                t1.start();
            }
        }
    }
</script>
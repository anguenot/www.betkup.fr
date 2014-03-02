<?php $LARG = 430 ?>
<?php $HAUT = 138 ?>
<div class="datas">
	<table style="border-spacing: 0;">
		<tr>
			<td align="left" valign="top" colspan="2">
				<div style="position: relative; width: 100%; height: 50px;">
					<div class="header_table_select" align="right">
					<?php
					include_component('interface', 'select', array(
                            'bloc' => 'home_ranking_select',
                            'width1' => '0',
                            'width2' => '140',
                            'width3' => '0',
                            'widthGadget' => '100',
                            'marginLeftError' => '386',
                            'messageError' => '',
                            'blocType' => 'text',
                            'blocIcone' => '',
                            'blocName' => 'homeRankingSelect',
                            'blocLegende' => '',
							'blocFirstRow' => '',
                            'blocValue' => '',		
                        	'blocChoices' => $kupsNames,
                            'blocHelp' => ''))
					?>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">
				<div id="masqueClassement" style="position: relative; height:<?php echo $HAUT ?>px; overflow:hidden;">
					<div id="bandeClassement"
						style="position: relative; left: 0px; top: 0px;">
						<table style="border-spacing: 0;" id="tabClassement">
							<tr>
								<td>
								<?php foreach ($rankingData as $data): ?>
									<div class="row">
										<div class="cellule1 <?php echo $data["cellColor"] ?>">
											<p>
												<?php echo __($data["position"]) ?>
											</p>
										</div>
										<div class="cellule2 <?php echo $data["cellColor"] ?>">
											<img
												src="/image/default/ranking/<?php echo $data["progression"] ?>"
												border="0" alt="">
										</div>
										<div class="cellule3 <?php echo $data["cellColor"] ?>">
											<?php if ($data["photo"] != "") { ?>
											<img src="<?php echo $data["photo"] ?>" border="0" width="24"
												height="24">
											<?php  } else { ?>
											<img src="/image/default/member/avatar/default_small.png"
												border="0" width="24" height="24">
											<?php  }?>
											<p>
												<?php echo __($data["nickName"]) ?>
											</p>
										</div>
										<div class="cellule4 <?php echo $data["cellColor"] ?>">
											<p>
												<?php echo __($data["points"]) ?>
											</p>
										</div>
									</div>
									<div
										style="clear: both; margin: 0px; padding: 0px; height: 2px;"></div>
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
						<td height="69" align="left" valign="top"><a
							href="javascript:void(0);" onClick="moveClassement('d');"
							id="kupHomeTopButton"> <img src="/images/home/boutonTop.png"
								border="0"> </a>
						</td>
					</tr>
					<tr>
						<td height="69" align="left" valign="bottom"><a
							href="javascript:void(0);" onClick="moveClassement('u');"
							id="kupHomeBottomButton"> <img src="/images/home/boutonBottom.png"
								border="0"> </a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</div>

<?php $LARG = $HAUT; ?>

<script>
    function moveClassement(sens){

        DIV = document.getElementById("bandeClassement");

        LEFT = DIV.style.top;
        LEFT = parseInt(LEFT.replace("px", ""));
        WIDTH = document.getElementById("tabClassement").height;

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
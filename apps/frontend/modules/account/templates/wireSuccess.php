<div class="moncompte">
	<div class="moncompte_onglets_navigation">
		<a href="#" title="My Betkup"> <?php echo image_tag('moncompte/button_mybetkup.png', array('alt' => 'My Betkup', 'border' => '0', 'size' => '163x57')); ?>
		</a><a href="#" title="Kups"> <?php echo image_tag('moncompte/button_kups.png', array('alt' => 'Kups', 'border' => '0', 'size' => '157x57')); ?>
		</a><a href="#" title="Rooms"> <?php echo image_tag('moncompte/button_rooms.png', array('alt' => 'Rooms', 'border' => '0', 'size' => '154x57')); ?>
		</a><!-- a href="#" title="Community"> <?php echo image_tag('moncompte/button_community.png', array('alt' => 'Community', 'border' => '0', 'size' => '156x57')); ?>
		</a  -->
	</div>
	<a name="toppage"></a>
	<div class="interface">
	<?php echo image_tag('moncompte/top.png', array('alt' => '', 'border' => '0', 'size' => '990x4')); ?>
		<div>
			<div class="interface_gauche">
				<div class="enteteGauche">
					<p class="titre">
					<?php echo image_tag('moncompte/titremoncompte_' . $sf_user->getCulture() . '.png', array('alt' => '', 'border' => '0', 'size' => '349x45')); ?>
					</p>
					<?php include_component('account', 'menu', array('ongletActif' => $ongletActif, 'labelsOnglets' => $labelsOnglets)) ?>
				</div>
				<div class="corpsGauche">
				<?php include_component('account', 'title', array('racine' => 'retirermesgains', 'altImg' => 'Mes notifications')) ?>
					<div class="blocBlanc">
						<div class="margeGauche">
							<div style="height: 27px;"></div>
							<form name="formCredit" id="formCredit" method="post" action=""
								onsubmit="return false;">
								<?php
								include_component('interface', 'simpleWidget', array(
                                    'bloc' => 'wire',
                                    'width1' => '264',
                                    'width2' => '100',
                                    'width3' => '',
                                    'widthGadget' => '100',
                                    'marginLeftError' => '386',
                                    'messageError' => __('XX'),
                                    'blocType' => 'text',
                                    'blocIcone' => '',
                                    'blocName' => 'soldeCompte',
                                    'blocLegende' => __('Solde du compte :'),
                                    'blocValue' => $transferable_member_credit . ' €',
                                    'blocHelp' => '',
                                    'option' => 'READONLY'))
								?>
								<?php
								include_component('interface', 'simpleWidget', array(
                                    'bloc' => 'wire',
                                    'width1' => '264',
                                    'width2' => '100',
                                    'width3' => '',
                                    'widthGadget' => '200',
                                    'marginLeftError' => '386',
                                    'messageError' => __('Le montant du retrait est obligatoire'),
                                    'blocType' => 'text',
                                    'blocIcone' => '',
                                    'blocName' => 'montantRetrait',
                                    'blocLegende' => __('Je retire :'),
                                    'blocValue' => '',
                                    'blocHelp' => '€ &nbsp;&nbsp;Entre ' . sfConfig::get('mod_account_credit_wire_min') . ' et ' . $transferable_member_credit . ' Euros',
                                    'option' => ''))
								?>
								<div style="height: 14px;"></div>
								<div align="left">
									<div align="right" style="width: 478px;">
										<table border="0" cellpadding="0" cellspacing="20">
											<tr>
												<td>
													<?php include_component('interface', 'buttonText', array('name' => 'Retour', 'href' => url_for(array('module' => 'account', 'action' => 'transaction')))) ?>
												</td>
												<td>
													<div class="boutonSubmit" id="buttonSubmit">
														<input type="image"
															src="/images/interface/boutonRetirermesgains_fr.png"
															name="<?php echo __('Retirer mes gains') ?>"
															value="<?php echo __('Retirer mes gains') ?>"
															class="c-submit" />
													</div>
												</td>
											</tr>
										</table>
									</div>
								</div>
                                <input type="hidden" name="creditBefore" value="<?php echo $member_credit; ?>"/>
                                <input type="hidden" name="email" value="<?php echo $userEmail; ?>"/>
							</form>
							<div style="height: 40px;"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="interface_droite">
				<p style="margin: 10px;"></p>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</div>
<script type="text/javascript">
    function verifWidgetText(widget) {
        var valueInWidget = $("#"+widget).val();
        if ( valueInWidget == '' ) {
            $("#"+widget).addClass("formInputVarcharError");

            if ( widget == 'montantRetrait' )
                $("#montant"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Le montant du retrait est obligatoire.') ?></p>');

            if ( widget == 'numeroCompte' )
                $("#numeroCompte"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Le numéro de compte est obligatoire.') ?></p>');

            $("#"+widget+'_bulle').fadeIn('fast');
            $("#"+widget).focus();
            return(false);
        }
        return(true);
    }

    function hideMessageErrorFromWidget(widget, widgetName) {
        $(".formInputVarchar").removeClass("formInputVarcharError");
        $('#'+widgetName+'_bulle').fadeOut('fast');
    }

$(function() {
    $(".formInputVarchar").keyup(function(key) {
        hideMessageErrorFromWidget(this, this.id);
    });
    $(".formInputVarchar").focus(function(key) {
        $(this).addClass("formInputVarcharSelected");
    });
    $(".formInputVarchar").blur(function(key) {
        $(".formInputVarchar").removeClass("formInputVarcharSelected");
    });
    $("#buttonSubmit").click(function(){

        var formValide = true;

        // Test montant only number
        if ( $("#montantRetrait").val() != '' ) {
            if( $('#montantRetrait').val() >= <?php echo sfConfig::get('mod_account_credit_wire_min') ?> && $('#montantRetrait').val() <= <?php echo $transferable_member_credit ?>) {
            }
            else {
                $("#montantRetrait").addClass("formInputVarcharError");
                $("#montantRetrait"+'_bulle').html('<p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo __('Votre montant est incorrect.') ?></p>');
                $("#montantRetrait"+'_bulle').fadeIn('fast');
                $("#montantRetrait"+widget).focus();
                return(false);
            }
        }
        document.formCredit.submit();
    });
});
</script>

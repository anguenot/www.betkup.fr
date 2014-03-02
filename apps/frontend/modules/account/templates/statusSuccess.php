<div class="moncompte">
	<?php include_component('account', 'navigation', array()) ?>
	<a id="toppage"></a>
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
					<div class="fieldsetTabLimit">
						<fieldset>
							<legend><?php echo image_tag('moncompte/balance.png'); ?></legend>
							<p><?php echo __('account_tab_limit_fieldset_text_1'); ?></p>
							<p><?php echo __('account_tab_limit_fieldset_text_2'); ?></p><br />
							<p><?php echo __('account_tab_limit_fieldset_text_3'); ?></p>
							<p><?php echo __('account_tab_limit_fieldset_text_4'); ?></p>
						</fieldset>
					</div>
					<?php if ($account_type == 'GAMBLING_FR') { ?>
					<div class="sommaire">
						<ul>
							<li><a href="#mesdocdeverif"><?php echo __('account_status_interface_gauche_sommaire_mesdocdeverif_text'); ?></a>
							</li>
							<li><a href="#moncodeactivation"><?php echo __('account_status_interface_gauche_sommaire_moncodeactivation_text'); ?></a>
							</li>
							<li><a href="#meslimitesdejeu"><?php echo __('account_status_interface_gauche_sommaire_meslimitesdejeu_text'); ?></a>
							</li>
						</ul>
					</div>
					<?php include_component('account', 'title', array('racine' => 'mesdocdeverif', 'altImg' => 'Mes documents de vérification')) ?>
					<form name="formAccountLimites1" id="formAccountLimites1"
						method="post" action="<?php echo url_for('account/uploads') ?>"
						enctype="multipart/form-data">
                        <input type="hidden" name="email" value="<?php echo $member_email; ?>"/>
						<div class="blocBlanc">
							<div  style="width: 710px; height: 590px; backgrossund: url('/images/account/limite/background.png');">
								<div class="margeGauche">
									<div style="height: 28px;"></div>
									<H1><?php echo __('account_status_formAccountLimites_margeGauche_title_1'); ?></H1>
									<img src="/images/account/limite/piecesAfournir.png" border="0"
										style="margin-bottom: 12px;" alt="Pieces à fournir" />
									<H1><?php echo __('account_status_formAccountLimites_margeGauche_title_2'); ?></H1>
									<table cellspacing="0" cellpadding="0" border="0"
										style="margin-top: 14px;">
										<tr>
											<td width="230">
												<div class="sendDocTitle"><?php echo __('account_status_formAccountLimites_sendDocTitle_title_1'); ?></div>
												<div class="sendDocTexte"><?php echo __('account_status_formAccountLimites_sendDocTexte_text_1'); ?></div></td>
											<td width="230">
												<div class="sendDocTitle"><?php echo __('account_status_formAccountLimites_sendDocTitle_title_2'); ?></div>
												<div class="sendDocTexte"><?php echo __('account_status_formAccountLimites_sendDocTexte_text_2'); ?></div></td>
											<td width="230">
												<div class="sendDocTitle"><?php echo __('account_status_formAccountLimites_sendDocTitle_title_3'); ?></div>
												<div class="sendDocTexte"><?php echo __('account_status_formAccountLimites_sendDocTexte_text_3'); ?></div></td>
										</tr>
									</table>
									<img src="/images/account/limite/lePlusSimple.png" border="0" style="margin-bottom: 4px;" />
									<H1><?php echo __('account_status_formAccountLimites_margeGauche_title_3'); ?></H1>
									<div style="height: 12px;"></div>
									
									<table style="width:550px;">
										<tr>
											<td colspan="2"><div class="moduleEnvoiIdentite"><?php echo __('account_status_formAccountLimites_moduleEnvoiIdentite_title_1'); ?><?php echo ($idFilename!=''?'(ENVOYE)':'(1MB MAX)') ?></div></td>
										</tr>
										<tr>
											<td style="width: 370px; height: 40px; vertical-align: middle;">	
												<div style="margin-top: 7px; margin-left: 30px; background-color: #F5F5F5; border-top: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7; border-right: 1px solid #EBEBEB; border-bottom: 1px solid #EBEBEB; width: 332px; height: 28px;">
													<div style="margin-top: 5px; margin-left: 5px;">
														<input type="file" name="limites[identity]" />
													</div>
												</div>
											</td>
											<td style="height: 40px; vertical-align: middle;">
												<?php if ( $idFilename != "" ): ?>
													<table>
														<tr>
															<td style="vertical-align: middle;">
																<?php echo image_tag('/images/account/limite/checkOk.png', array('size' => '30x30', 'style' => 'float: left; border: none;'))?>
															</td>
															<td style="vertical-align: middle;">
																<?php echo __('text_status_documents_ok')?>
															</td>
														</tr>
													</table>
												<?php else: ?>
													<?php echo image_tag('/images/account/limite/checkOk.png', array('size' => '30x30', 'style' => 'float: left; border: none;'))?>
												<?php endif ?>
											</td>
										</tr>
									</table>
									<div style="height: 20px;"></div>
									<table style="width:550px;">
										<tr>
											<td colspan="2"><div class="moduleEnvoiIdentite"><?php echo __('account_status_formAccountLimites_moduleEnvoiIdentite_title_2'); ?><?php echo ($ribFilename!=''?'(ENVOYE)':'(1MB MAX)') ?></div></td>
										</tr>
										<tr>
											<td style="width: 370px; height: 40px; vertical-align: middle;">
												<div style="margin-top: 7px; margin-left: 30px; background-color: #F5F5F5; border-top: 1px solid #D7D7D7; border-left: 1px solid #D7D7D7; border-right: 1px solid #EBEBEB; border-bottom: 1px solid #EBEBEB; width: 332px; height: 28px;">
													<div style="margin-top: 5px; margin-left: 5px;">
														<input type="file" name="limites[rib]" />
													</div>
												</div>
											</td>
											<td style="height: 40px; vertical-align: middle;">
												<?php if ( $ribFilename != "" ): ?>
													<table>
														<tr>
															<td style="vertical-align: middle;">
																<?php echo image_tag('/images/account/limite/checkOk.png', array('size' => '30x30', 'style' => 'float: left; border: none;'))?>
															</td>
															<td style="vertical-align: middle;">
																<?php echo __('text_status_documents_ok')?>
															</td>
														</tr>
													</table>
												<?php else: ?>
													<?php echo image_tag('/images/account/limite/checkKo.png', array('size' => '30x30', 'style' => 'float: left; border: none;'))?>
												<?php endif ?>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
                        <div style="width: 580px; padding-top: 10px;" align="center">
                            <a href="javascript:document.formAccountLimites1.submit();">
                                <img src="/images/interface/boutonSave2_FR.png" border="0" alt="Save" />
                            </a>
                        </div>
                        <div style="height: 10px;"></div>
						</form>
						<?php include_component('account', 'title', array('racine' => 'moncodeactivation', 'altImg' => 'Mon code d\'activation')) ?>
						<div class="blocBlanc">
						<?php if (!$sf_user->hasCredential('member_gambling_fr_verified')): ?>
						<form name="formAccountLimites2" id="formAccountLimites2" method="post" action="">
						<input type="hidden" name="email" value="<?php echo $member_email; ?>"/>
						<?php
						include_component('interface', 'simpleWidget', array(
                                    'bloc' => 'limites',
                                    'width1' => '250',
                                    'width2' => '240',
                                    'width3' => '',
                                    'marginLeftError' => '400',
                                    'messageError' => __('account_status_activationKey_messageError_text'),
                                    'blocType' => 'text',
                                    'blocIcone' => '',
                                    'blocName' => 'activationKey',
                                    'blocLegende' => __('account_status_activationKey_legende_text'),
                                    'blocValue' => ''))
						?>
						<div style="width: 580px; padding-top: 10px;" align="center">
						<a href="javascript:document.formAccountLimites2.submit();">
						<img src="/images/interface/boutonSave2_FR.png" border="0" alt="Save" />
						</a>
						</div>
						<div style="height: 10px;"></div>
						</form>
						<?php else: ?>
						<?php include_component('interface', 'widget', array('blocType' => 'text', 'blocIcone' => 'cadenas', 'blocName' => 'activationKey', 'blocLegende' => 'COMPTE ACTIF', 'blocValue' => '')) ?>
						<?php endif ?>
						</div>
						<?php include_component('account', 'title', array('racine' => 'meslimitesdejeu', 'altImg' => __('account_status_meslimitesdejeu_altImg_text') )) ?>
                        <form name="formAccountLimites3" id="formAccountLimites3" method="post" action="">
                        <input type="hidden" name="email" value="<?php echo $member_email; ?>"/>
						<div class="blocBlanc">
						<?php
						include_component('interface', 'simpleWidget', array(
                                'bloc' => 'limites',
                                'width1' => '250',
                                'width2' => '240',
                                'width3' => '',
                                'marginLeftError' => '400',
                                'messageError' => __('account_status_maxAmountBetWeekly_messageError_text'),
                                'blocType' => 'text',
                                'blocIcone' => '',
                                'blocName' => 'maxAmountBetWeekly',
                                'blocLegende' => __('account_status_maxAmountBetWeekly_legende_text'),
                                'blocValue' => $maxAmountBetWeekly,
                                'blocHelp' => __('account_status_maxAmountBetWeekly_help_text')))
						?>
						<?php
						include_component('interface', 'simpleWidget', array(
                                'bloc' => 'limites',
                                'width1' => '250',
                                'width2' => '240',
                                'width3' => '',
                                'marginLeftError' => '400',
                                'messageError' => __('account_status_maxAmountCreditWeekly_messageError_text'),
                                'blocType' => 'text',
                                'blocIcone' => '',
                                'blocName' => 'maxAmountCreditWeekly',
                                'blocLegende' => __('account_status_maxAmountCreditWeekly_legende_text'),
                                'blocValue' => $maxAmountCreditWeekly,
                                'blocHelp' => __('account_status_maxAmountCreditWeekly_help_text')))
						?>
						<?php
						include_component('interface', 'simpleWidget', array(
                                'bloc' => 'limites',
                                'width1' => '250',
                                'width2' => '240',
                                'width3' => '',
                                'marginLeftError' => '400',
                                'messageError' => __('account_status_maxAmountAutomaticWire_messageError_text'),
                                'blocType' => 'text',
                                'blocIcone' => '',
                                'blocName' => 'maxAmountAutomaticWire',
                                'blocLegende' => __('account_status_maxAmountAutomaticWire_legende_text'),
                                'blocValue' => $maxAmountAutomaticWire,
                                'blocHelp' => __('account_status_maxAmountAutomaticWire_help_text')))
						?>
						<?php
						include_component('interface', 'select', array(
                                'bloc' => 'limites',
                                'width1' => '250',
                                'width2' => '240',
                                'widthGadget' => '230',
                                'blocType' => 'radio',
                                'blocIcone' => 'crayon',
                                'blocName' => 'autoExclusion',
                                'blocLegende' => __('account_status_autoExclusion_legende_text'),
                                'blocValue' => $autoExclusion,
                                'blocChoices' => array(
                                    '0' => __('account_status_autoExclusion_choice_0_text'),
                                    '7' => __('account_status_autoExclusion_choice_7_text'),
                                    '14' => __('account_status_autoExclusion_choice_14_text'),
                                    '1095' => __('account_status_autoExclusion_choice_definitive_text'))
						));
						?>
						</div>
						<div style="width: 580px; padding-top: 20px;" align="center">
							<a href="javascript:document.formAccountLimites3.submit();">
								<img src="/images/interface/boutonSave2_FR.png" border="0" alt="Save" />
							</a>
						</div>
						<div style="height: 10px;"></div>
					</form>
					<?php } else { ?>
					<div class="blocBlanc">
						<div style="margin: 20px;">
							<p style="margin-bottom: 1em;"><b><?php echo __('account_tab_limit_title'); ?></b></p>
							<p><?php echo __('account_tab_limit_text_1'); ?></p>
							<p style="margin-bottom: 1em;"><?php echo __('account_tab_limit_text_2'); ?></p>
							<p style="margin-bottom: 1em;"><?php echo __('account_tab_limit_text_3'); ?></p>
							<p style="margin-bottom: 1em;"><?php echo __('account_tab_limit_text_4'); ?></p>
							<p class="rappel"><a href="<?php echo url_for(array('module' => 'account', 'action' => 'updateSimpleAccount')) ?>"><?php echo __('open_account_complet_to_bet'); ?></a></p>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="interface_droite">
				<p style="margin: 10px;"></p>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</div>
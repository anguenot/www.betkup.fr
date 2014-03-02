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

					<div class="sommaire">
						<ul>
							<li><a href="#moncomptebetkup">Mon compte Betkup</a></li>
							<li><a href="#mesinfosperso">Mes informations personnelles</a></li>
							<li><a href="#cloturermoncompte">Clôturer mon compte</a></li>
						</ul>
					</div>
					<?php include_component('account', 'title', array('racine' => 'moncomptebetkup', 'altImg' => 'Mon compte Betkup')) ?>
					<div
						style="font-family: Arial; font-size: 12px; color: #4c4d4f; text-align: left; margin-left: 30px;">
						<?php echo __('me_last_login_time'); ?>
						:
						<?php echo util::displayDateCompleteFromTimestampComplet($lastLogin) ?>
					</div>
					<div class="blocBlanc">
					<?php include_component('account', 'myaccount', array('formName' => 'account', 'monComptePseudo' => $member_data["nickName"])) ?>
					</div>

					<?php include_component('account', 'title', array('racine' => 'mesinfosperso', 'altImg' => 'Mes informations personnelles')) ?>
					<div class="blocBlanc">
					<?php

					$countryIso = (isset($member_data["address_country"]) ? $member_data["address_country"] : '') ;
					include_component('account', 'info', array(
							'formName' => 'infos',
                            'monComptePrenom' => (isset($member_data["fisrtName"]) ? $member_data["fisrtName"] : ''),
                            'monCompteNom' => (isset($member_data["lastName"]) ? $member_data["lastName"] : ''),
                            'monCompteAdresse' => (isset($member_data["address_street"]) ? $member_data["address_street"] : ''),
                            'monCompteCodepostal' => (isset($member_data["address_zip"]) ? $member_data["address_zip"] : ''),
                            'monCompteVille' => (isset($member_data["address_city"]) ? $member_data["address_city"].' ('.$member_data["address_zip"].')' : ''),
                            'monComptePays' => (isset($countryIso) ? $countryIso : ''),
                            'monCompteDateNaissance' => (isset($member_data["birthDate"]) ? Util::displayDateChiffreFromTimestampComplet($member_data["birthDate"], false) : ''),
                            'monCompteDepartementNaissance' => (isset($member_data["birth_area"]) ? $member_data["birth_area"] : ''),
                            'monCompteVilleNaissance' => (isset($member_data["birth_place"]) ? $member_data["birth_place"] : ''),
                            'monCompteDateCreationCompte' => (isset($member_data["created"]) ? Util::displayDateChiffreFromTimestampComplet($member_data["created"]) : ''),
							'monCompteCivility' => $title,
							'monCompteDateAcceptationCGU' => (isset($member_data["policyAcceptanceDate"]) ? Util::displayDateChiffreFromTimestampComplet($member_data["policyAcceptanceDate"]) : '')
					))
					?>
					</div>
					<?php if ($sf_user->hasCredential('member_gambling_fr')): ?>

					<?php include_component('account', 'title', array('racine' => 'bank', 'altImg' => 'Mes informations personnelles')) ?>
					<div class="blocBlanc">
					<?php
					include_component('account', 'bank', array(
								'formName' => 'bank',
                                'monCompteRibBank' => (isset($member_data["rib_bank"]) ? $member_data["rib_bank"] : ''),
                                'monCompteRibBranch' => (isset($member_data["rib_branch"]) ? $member_data["rib_branch"] : ''),
                                'monCompteRibNumber' => (isset($member_data["rib_number"]) ? $member_data["rib_number"] : ''),
                                'monCompteRibKey' => (isset($member_data["rib_key"]) ? $member_data["rib_key"] : ''),
                                'monCompteIbanNumber' => (isset($member_data["iban_number"]) ? $member_data["iban_number"] : ''),
                                'monCompteIbanSwift' => (isset($member_data["iban_swift"]) ? $member_data["iban_swift"] : ''),
                                'monCompteMaxAmountCreditWeekly' => (isset($member_data["max_amount_credit_weekly"]) ? $member_data["max_amount_credit_weekly"] : ''),
                                'monCompteMaxAmountBetWeekly' => (isset($member_data["max_amount_bet_weekly"]) ? $member_data["max_amount_bet_weekly"] : ''),
					));
					?>
					</div>
					<?php endif ?>
					<?php include_component('account', 'title', array('racine' => 'cloturermoncompte', 'altImg' => 'Clôturer mon compte')) ?>
					<div class="blocBlanc">
					<?php include_component('account', 'close', array()) ?>
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

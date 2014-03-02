<form id="editInfosForm" action="" method="post">
<?php include_component('interface', 'editingRadioWidget', array( 'class' => 'edit_'.$formName, 'blocIcone' => 'crayon', 'width1' => '222', 'width2' => '240', 'marginLeftError' => '400', 'widthGadget' => '224', 'blocName' => 'monCompteCivility', 'blocLegende' => __('info_monCompteCivility_legende_text'), 'blocValue' => $monCompteCivility, 'blocChoices' => array('M', 'Mme', 'Mlle') )) ?>
<?php include_component('interface', 'editingFieldWidget', array( 'class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'monComptePrenom', 'blocLegende' => __('info_monComptePrenom_legende_text'), 'blocValue' => $monComptePrenom )) ?>
<?php include_component('interface', 'editingFieldWidget', array( 'class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'monCompteNom', 'blocLegende' => __('info_monCompteNom_legende_text'), 'blocValue' => $monCompteNom )) ?>

<?php if ( $sf_user->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr') ): ?>
    <?php include_component('interface', 'editingFieldWidget', array( 'class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'monCompteAdresse', 'blocLegende' => __('info_monCompteAdresse_legende_text'), 'blocValue' => $monCompteAdresse )) ?>
    <?php include_component('interface', 'countriesEdit', array( 'class' => 'edit_'.$formName, 'bloc' => 'information', 'blocIcone' => 'crayon', 'width1' => '222', 'width2' => '240', 'marginLeftError' => '400', 'messageError' => __('info_accountCountry_messageError_text'), 'blocName' => 'accountCountry', 'blocLegende' => __('info_accountCountry_legende_text'), 'blocValue' => $monComptePays, 'blocChoices' => $countries, 'blocFirstRow' => '', 'widthGadget' => '224')) ?>
    <?php include_component('interface', 'editingFieldWidget', array( 'class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'monCompteVille', 'blocLegende' => __('info_monCompteVille_legende_text'), 'blocValue' => $monCompteVille )) ?>
    <div id="showHideCodezip">
    	<?php include_component('interface', 'editingFieldWidget', array( 'class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'monCompteCodepostal', 'blocLegende' => __('info_monCompteCodepostal_legende_text'), 'blocValue' => $monCompteCodepostal )) ?>
	</div>

<?php endif ?>

<div style="text-align: left; height: 28px;">
	<div id="<?php echo $formName; ?>_widget_edit">
		<a class="account-button" href="javascript:void(0);" id="<?php echo $formName; ?>_button">
			<?php echo __('Modifier vos informations')?>
		</a>
	</div>
	<div id="<?php echo $formName?>_widget_save" style="display: none; margin-left:225px;">
		<a class="account-button-save <?php echo $formName; ?>_save" href="javascript:void(0);" id="<?php echo $formName; ?>_button">
			<?php echo __('Enregistrer')?>
		</a>
		<?php //echo image_tag('/images/interface/boutonSave_FR.png', array('size' => '88x24', 'style' => 'border: none; cursor: pointer;', 'id' => $formName.'_save', 'alt' => 'Save'))?>
		
			<?php echo image_tag('/images/interface/boutonAnnuler_FR.png', array('size' => '58x23', 'style' => 'border: none; cursor: pointer;', 'id' => $formName.'_cancel', 'alt' => 'Cancel'))?>
	</div>
</div>

<?php include_component('interface', 'editingFieldWidget', array( 'blocType' => 'text', 'blocIcone' => 'cadenas', 'blocName' => 'monCompteCreation', 'blocLegende' => __('info_monCompteCreation_legende_text'), 'blocValue' => $monCompteDateAcceptationCGU )) ?>
<?php include_component('interface', 'editingFieldWidget', array( 'blocType' => 'text', 'blocIcone' => 'cadenas', 'blocName' => 'monCompteDateNaissance', 'blocLegende' => __('info_monCompteDateNaissance_legende_text'), 'blocValue' => $monCompteDateNaissance )) ?>

<?php if ( $sf_user->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr') ): ?>
    <?php include_component('interface', 'editingFieldWidget', array( 'blocType' => 'text', 'blocIcone' => 'cadenas', 'blocName' => 'monCompteDepartementNaissance', 'blocLegende' => __('info_monCompteDepartementNaissance_legende_text'), 'blocValue' => $monCompteDepartementNaissance )) ?>
	<?php include_component('interface', 'editingFieldWidget', array( 'blocType' => 'text', 'blocIcone' => 'cadenas', 'blocName' => 'monCompteVilleNaissance', 'blocLegende' => __('info_monCompteVilleNaissance_legende_text'), 'blocValue' => $monCompteVilleNaissance )) ?>
    <?php include_component('interface', 'editingFieldWidget', array( 'blocType' => 'text', 'blocIcone' => 'cadenas', 'blocName' => 'monCompteDateCreationCompte', 'blocLegende' => __('info_monCompteDateCreationCompte_legende_text'), 'blocValue' => $monCompteDateCreationCompte )) ?>
<?php endif ?>
<input type="hidden" value="editInfosForm" name="formName" id="formName" />
<input type="hidden" class="oldEmail" name="oldEmail" value="<?php echo $userEmail; ?>"/>
<input type="hidden" class="oldFirstName" name="oldFirstName" value="<?php echo $userFirstName; ?>"/>
<input type="hidden" class="oldLastName" name="oldLastName" value="<?php echo $userLastName; ?>"/>
<input type="hidden" class="oldNickName" name="oldNickName" value="<?php echo $userNickName; ?>"/>
<input type="hidden" class="oldTitle" name="oldTitle" value="<?php echo $userTitle; ?>"/>
<input type="hidden" class="oldAddress" name="oldAddress" value="<?php echo $userAddress; ?>"/>
<input type="hidden" class="oldZip" name="oldZip" value="<?php echo $userZip; ?>"/>
<input type="hidden" class="oldCountry" name="oldCountry" value="<?php echo $userCountry; ?>"/>
<input type="hidden" class="oldCity" name="oldCity" value="<?php echo $userCity; ?>"/>

<input type="hidden" class="oldCountryId" name="oldCountryId" value="<?php echo $oldCountryId; ?>" />
</form>
<p style="height: 10px;"></p>

<script type="text/javascript">
	$(function() {
		<?php if ( $sf_user->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr') ):?>
			<?php if($monComptePays == 'FR') :?>
				$('#showHideCodezip').hide();
			<?php else :?>
				$('#showHideCodezip').show();
			<?php endif; ?>

		$('#accountCountry_gadget').change(function() {
			if($(this).val() == 'FR') {
				$('#showHideCodezip').hide();
			} else {
				$('#showHideCodezip').show();
				$('#content-search-monCompteVille-results').empty().hide();
			}
		});
		<?php endif; ?>

		$('#<?php echo $formName; ?>_button').click(function() {
			<?php if ( $sf_user->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr') ):?>
				if($('#accountCountry_gadget').val() == 'FR') {
					$('#showHideCodezip').hide();
				} else {
					$('#showHideCodezip').show();
				}
			<?php endif; ?>

			$('.edit_<?php echo $formName ?>_span').fadeOut('fast', function() {
				$('.edit_<?php echo $formName ?>_input').fadeIn('fast');
			});

			$("#<?php echo $formName; ?>_widget_edit").fadeOut('fast', function() {
				$("#<?php echo $formName; ?>_widget_save").fadeIn('fast');
			});
		});

		$("#<?php echo $formName; ?>_cancel").click(function() {
			<?php if ( $sf_user->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr') ):?>
				if($('#accountCountry_gadget').val() == 'FR') {
					$('#showHideCodezip').hide();
				} else {
					$('#showHideCodezip').show();
				}
			<?php endif; ?>

			cancelRestoreValues();

			$('.edit_<?php echo $formName ?>_input').fadeOut('fast', function() {
				$('.edit_<?php echo $formName ?>_span').fadeIn('fast');
			});

			$("#<?php echo $formName; ?>_widget_save").fadeOut('fast', function() {
				$("#<?php echo $formName; ?>_widget_edit").fadeIn('fast');
			});
		});

		$(".<?php echo $formName; ?>_save").click(function() {
			if(!isValidString64($("#monComptePrenom_gadget").val())) {
				var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?>'+"<?php echo __('text_register_error_first_name_not_match_constraint')?>"+'</div>';
    	        showNotification(data, "error", function(){});
			} else if(!isValidString64($("#monCompteNom_gadget").val())) {
				var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?>'+"<?php echo __('text_register_error_last_name_not_match_constraint')?>"+'</div>';
    	        showNotification(data, "error", function(){});
			} else if($("input[name='edit[monCompteCivility]']:checked").val() == '') {
				var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?>'+"<?php echo __('account_registerAdvanced_accountCivilite_messageError_text')?>"+'</div>';
    	        showNotification(data, "error", function(){});
			}
			<?php if ( $sf_user->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr') ): ?>
			else if(!isValidString64($("#monCompteAdresse_gadget").val())) {
				var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?>'+"<?php echo __('text_register_error_address_not_match_constraint')?>"+'</div>';
    	        showNotification(data, "error", function(){});
			} else if(!isValidString64($("#monCompteVille_gadget").val())) {
				var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?>'+"<?php echo __('text_register_error_city_not_match_constraint')?>"+'</div>';
    	        showNotification(data, "error", function(){});
			} else if(!isValidZipcode($("#monCompteCodepostal_gadget").val(), "monCompteCodepostal")) {
				var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?>'+"<?php echo __('text_register_error_zipcode_not_match_constraint')?>"+'</div>';
    	        showNotification(data, "error", function(){});
			}
			<?php endif; ?>
			else {

			var data = $('#editInfosForm').serialize();
			var jxhr = $.ajax({
					url: '<?php echo url_for(array('module' => 'account', 'action' => 'editField')) ?>',
					data: $.url.decode(data),
					traditional: true,
					dataType: 'json',
					type: 'post'
				});

				jxhr.done(function(response, status, xhr) {

                    if ( response['http_code'] == '202' ) {

                        // Update text with new value
                        $("#monCompteCivility_span").html(response.query.title);
                      	$("#monComptePrenom_span").html( response.query.monComptePrenom );
						$("#monCompteNom_span").html( response.query.monCompteNom );
						<?php if ( $sf_user->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr') ): ?>
							$("#monCompteAdresse_span").html( response.query.monCompteAdresse );
							$("#monCompteVille_span").html( response.query.monCompteVille );
							$("#accountCountry_span").html(response.query.countryName);
							$("#monCompteCodepostal_span").html(response.query.monCompteCodepostal);
						<?php endif; ?>
						updateOldValues(response);
                        // We hide the save/cancel buttons
                        $('.edit_<?php echo $formName ?>_input').fadeOut('fast', function() {
            				$('.edit_<?php echo $formName ?>_span').fadeIn('fast');
            			});

            			$("#<?php echo $formName; ?>_widget_save").fadeOut('fast', function() {
            				$("#<?php echo $formName; ?>_widget_edit").fadeIn('fast');
            			});
                    }
                    else {
                    	var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?>'+response["msg"]+'</div>';
            	        showNotification(data, "error", function(){});
                    }
				});
			}
    	});
	});

	function cancelRestoreValues() {
		$("#monCompteCivility_gadget").val($('.oldTitle').val());
		$("#monComptePrenom_gadget").val($('.oldFirstName').val());
		$("#monCompteNom_gadget").val($('.oldLastName').val() );
		<?php if ( $sf_user->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr') ): ?>
			$("#monCompteAdresse_gadget").val( $('.oldAddress').val() );
			$("#monCompteVille_gadget").val( $('.oldCity').val() );
			$("#accountCountry_gadget").val($('.oldCountryId').val());
			$("#monCompteCodepostal_gadget").val($('.oldZip').val());
		<?php endif;?>
	}

	function updateOldValues(response) {

		$("#monCompteCivility_gadget").val(response.query.title);
		$("#monComptePrenom_gadget").val(response.query.monComptePrenom );
		$("#monCompteNom_gadget").val(response.query.monCompteNom );

		<?php if ( $sf_user->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr') ): ?>
			$("#monCompteAdresse_gadget").val( response.query.monCompteAdresse );
			$("#monCompteVille_gadget").val( response.query.monCompteVille );
			$("#accountCountry_gadget").val(response.query.countryId);
			$("#monCompteCodepostal_gadget").val(response.query.monCompteCodepostal);
		<?php endif; ?>

		$('.oldTitle').val(response.query.titleEn);
		$('.oldFirstName').val(response.query.monComptePrenom);
		$('.oldLastName').val(response.query.monCompteNom);

		<?php if ( $sf_user->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr') ): ?>
			$('.oldAddress').val(response.query.monCompteAdresse);
			$('.oldZip').val(response.query.monCompteCodepostal);
			$('.oldCountryId').val(response.query.countryId);
			$('.oldCountry').val(response.query.countryName);
			$('.oldCity').val(response.query.monCompteVille);
		<?php endif; ?>
	}
</script>
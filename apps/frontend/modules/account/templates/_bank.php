<form id="editBankForm" action="" method="post">
<div style="border-bottom: 1px solid #EFEFEF; width: 475px; margin-left: 20px; margin-top: 10px; font-family: Arial; font-size: 12px; font-weight: normal; color: #6A6A69;">
	RIB :
</div>
<?php include_component('interface', 'editingFieldWidget', array('class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'ribBank', 'blocLegende' => __('BANQUE'), 'blocValue' => $monCompteRibBank)) ?>
<?php include_component('interface', 'editingFieldWidget', array('class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'ribBranch', 'blocLegende' => __('GUICHET'), 'blocValue' => $monCompteRibBranch)) ?>
<?php include_component('interface', 'editingFieldWidget', array('class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'ribNumber', 'blocLegende' => __('NUMERO DE COMPTE'), 'blocValue' => $monCompteRibNumber)) ?>
<?php include_component('interface', 'editingFieldWidget', array('class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'ribKey', 'blocLegende' => __('CLE'), 'blocValue' => $monCompteRibKey)) ?>
<div
	style="border-bottom: 1px solid #EFEFEF; width: 475px; margin-left: 20px; margin-top: 10px; font-family: Arial; font-size: 12px; font-weight: normal; color: #6A6A69;">IBAN
:</div>
<?php include_component('interface', 'editingFieldWidget', array('class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'ibanNumber', 'blocLegende' => __('NUMBER'), 'blocValue' => $monCompteIbanNumber)) ?>
<?php include_component('interface', 'editingFieldWidget', array('class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'ibanSwift', 'blocLegende' => __('BIC/SWIFT'), 'blocValue' => $monCompteIbanSwift)) ?>

<div
	style="border-bottom: 1px solid #EFEFEF; width: 475px; margin-left: 20px; margin-top: 10px; font-family: Arial; font-size: 12px; font-weight: normal; color: #6A6A69;">LIMITES
:</div>
<?php include_component('interface', 'editingFieldWidget', array('class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'maxAmountBetWeekly', 'blocLegende' => __('LIMITE DE DEPOT'), 'blocHelp' => '€ max par semaine', 'blocValue' => $monCompteMaxAmountCreditWeekly)) ?>
<?php include_component('interface', 'editingFieldWidget', array('class' => 'edit_'.$formName, 'blocType' => 'text', 'blocIcone' => 'crayon', 'blocName' => 'maxAmountCreditWeekly', 'blocLegende' => __('LIMITE DE MISE'), 'blocHelp' => '€ max par semaine', 'blocValue' => $monCompteMaxAmountBetWeekly)) ?>

<div style="text-align: left; margin-left: 225px; height: 28px;">
<div id="<?php echo $formName; ?>_widget_edit"><a
	href="javascript:void(0);" id="<?php echo $formName; ?>_button"> <?php echo image_tag('/image/'.$sf_user->getCulture().'/account/edit_info_button.png', array('size' => '189x27'))?>
</a></div>
<div id="<?php echo $formName?>_widget_save" style="display: none;"><?php echo image_tag('/images/interface/boutonSave_FR.png', array('size' => '88x24', 'style' => 'border: none; cursor: pointer;', 'id' => $formName.'_save', 'alt' => 'Save'))?>
<?php echo image_tag('/images/interface/boutonAnnuler_FR.png', array('size' => '58x23', 'style' => 'border: none; cursor: pointer;', 'id' => $formName.'_cancel', 'alt' => 'Cancel'))?>
</div>
</div>
<input type="hidden" value="editBankForm" name="formName" id="formName" />
<input type="hidden" name="email" value="<?php echo $userEmail; ?>"/>
</form>
<p style="height: 10px;"></p>
<script type="text/javascript">
	$(function() {
		$('#<?php echo $formName; ?>_button').click(function() {
			$('.edit_<?php echo $formName ?>_span').fadeOut('fast', function() {
				$('.edit_<?php echo $formName ?>_input').fadeIn('fast');
			});

			$("#<?php echo $formName; ?>_widget_edit").fadeOut('fast', function() {
				$("#<?php echo $formName; ?>_widget_save").fadeIn('fast');
			});
		});

		$("#<?php echo $formName; ?>_cancel").click(function() {
			$('.edit_<?php echo $formName ?>_input').fadeOut('fast', function() {
				$('.edit_<?php echo $formName ?>_span').fadeIn('fast');
			});

			$("#<?php echo $formName; ?>_widget_save").fadeOut('fast', function() {
				$("#<?php echo $formName; ?>_widget_edit").fadeIn('fast');
			});
		});

		$("#<?php echo $formName; ?>_save").click(function() {
            var data = $('#editBankForm').serialize();
			var jxhr = $.ajax({
					url: '<?php echo url_for(array('module' => 'account', 'action' => 'editField')) ?>',
						data: $.url.decode(data),
						dataType: 'json',
						type: 'post'
			});

			jxhr.done(function(response, status, xhr) {

            	if ( response['http_code'] == '202' ) {

                    // Update text with new value
                    $("#ribBank_span").html( response.query.ribBank );
					$("#ribBranch_span").html( response.query.ribBranch );
					$("#ribNumber_span").html( response.query.ribNumber );
					$("#ribKey_span").html( response.query.ribKey );

					$("#ibanNumber_span").html(response.query.ibanNumber);
					$("#ibanSwift_span").html(response.query.ibanSwift);

					$("#maxAmountBetWeekly_span").html(response.query.maxAmountBetWeekly);
					$("#maxAmountCreditWeekly_span").html(response.query.maxAmountCreditWeekly);

                    // We hide the save/cancel buttons
                    $('.edit_<?php echo $formName ?>_input').fadeOut('fast', function() {
		            	$('.edit_<?php echo $formName ?>_span').fadeIn('fast');
		            });

		            $("#<?php echo $formName; ?>_widget_save").fadeOut('fast', function() {
		            	$("#<?php echo $formName; ?>_widget_edit").fadeIn('fast');
		            });
           		} else {
                    var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?>'+response.msg+'</div>';
                    showNotification(data, "error", function(){});
                }
			});
    	});
	});
</script>
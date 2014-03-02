<div id="<?php echo $blocName ?>_bulle" class="widgetError" style="margin-left: <?php echo $marginLeftError ?>px;">
    <p class="widgetError"><?php echo $messageError ?></p>
</div>
<div style="margin-top: 4px; margin-bottom: 10px;">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width ?>" align="right" height="28">
                <span style="font-family: Arial; font-size: 12px; font-weight: bold; color: #6A6A69;"><?php echo $blocLegende ?></span>
            </td>
            <td width="252" align="left" height="28" valign="middle">
                <div id="<?php echo $blocName ?>_txt" class="<?php echo $blocName ?>_crayon" style="width: 230px; float: left; margin-left: 20px; line-height: 25px; height: 25px; cursor: pointer;">
                    <span id="<?php echo $blocName ?>_span" style="line-height: 28px; font-family: Arial; font-size: 12px; font-weight: normal; color: #6A6A69;"><?php echo $blocValue ?></span>
                </div>
                <div id="<?php echo $blocName ?>_input" style="position: absolute; float: left; margin-left: 10px; <?php echo ($blocIcone != "") ? 'display: none;' : '';?>">
                	<form action="" method="post" id="<?php echo $blocName ?>_form">
	                	<input type="<?php echo $blocType ?>" id="<?php echo $blocName ?>_gadget" name="<?php echo $blocName ?>" value="<?php echo $blocValue ?>" style="padding-left: 7px; font-family: Arial; font-size: 12px; font-weight: normal; text-decoration: none; color: #8A8A8A; background-color: #F4F4F4; width: 224px; height: 24px; border-top: 2px solid #F5C95B; border-left: 2px solid #F5C95B; border-right: 2px solid #F4DA96; border-bottom: 2px solid #F4DA96;">
	                	<input type="hidden" value="editAccountForm" name="formName" id="formName" />
                        <input type="hidden" class="oldEmail" name="oldEmail" value="<?php echo $userEmail; ?>"/>
                        <input type="hidden" class="oldFirstName" name="oldFirstName" value="<?php echo $userFirstName; ?>"/>
                        <input type="hidden" class="oldLastName" name="oldLastName" value="<?php echo $userLastName; ?>"/>
                        <input type="hidden" class="oldNickName" name="oldNickName" value="<?php echo $userNickName; ?>"/>
                        <input type="hidden" class="oldTitle" name="oldTitle" value="<?php echo $userTitle; ?>"/>
                        <input type="hidden" class="oldAddress" name="oldAddress" value="<?php echo $userAddress; ?>"/>
                        <input type="hidden" class="oldZip" name="oldZip" value="<?php echo $userZip; ?>"/>
                        <input type="hidden" class="oldCountry" name="oldCountry" value="<?php echo $userCountry; ?>"/>
                        <input type="hidden" class="oldCity" name="oldCity" value="<?php echo $userCity; ?>"/>
                	</form>
                </div>
            </td>
            <td align="left" height="28">
                <div>
                    <?php if ($blocIcone == "crayon"): ?>
                        <img id="<?php echo $blocName ?>_img" class="<?php echo $blocName ?>_crayon <?php echo $blocName ?>_crayonClik" src="/images/interface/crayon.png" border="0" style="cursor: pointer; float: left;" alt="Editer">
                    <?php else: ?>
                        <?php if ($blocIcone == "cadenas"): ?>
                            <img id="<?php echo $blocName ?>_img" class="<?php echo $blocName ?>_crayon <?php echo $blocName ?>_crayonClik" src="/images/interface/cadenas.png" border="0" style="cursor: pointer;" alt="Locked">
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <div style="width: 200px;">
                    <span class="help" id="<?php echo $blocName ?>_help"><?php echo (isset($blocHelp)?$blocHelp:'') ?></span>
                    <img id="<?php echo $blocName ?>_save" src="/images/interface/boutonSave_FR.png" border="0" class="widgetSave" alt="Save">
                    <img id="<?php echo $blocName ?>_cancel" src="/images/interface/boutonAnnuler_FR.png" border="0" class="widgetCancel" alt="Cancel">
                </div>
            </td>
        </tr>
    </table>
</div>

<?php if ($blocIcone == "crayon"): ?>

    <script type="text/javascript">
        $(function() {
        $(".<?php echo $blocName ?>_crayon").hover(function(){
            $('#<?php echo $blocName ?>_img').attr("src","/images/interface/crayonOn.png");
        });

        $(".<?php echo $blocName ?>_crayonClik").hover(function(){
            $('#<?php echo $blocName ?>_img').attr("src","/images/interface/crayonClick.png");
        });

        $(".<?php echo $blocName ?>_crayon").mouseleave(function(){
            $('#<?php echo $blocName ?>_img').attr("src","/images/interface/crayon.png");
        });

        $(".<?php echo $blocName ?>_crayonClik").mouseleave(function(){
            $('#<?php echo $blocName ?>_img').attr("src","/images/interface/crayon.png");
        });

        $(".<?php echo $blocName ?>_crayonClik").click(function(){
            $('#<?php echo $blocName ?>_span').fadeOut('fast',function(){
                $('#<?php echo $blocName ?>_input').fadeIn('fast');
            });
            $('#<?php echo $blocName ?>_img').fadeOut('fast',function(){
                $('#<?php echo $blocName ?>_help').fadeOut('fast',function(){
                    $('#<?php echo $blocName ?>_save').fadeIn('fast',function(){
                        $('#<?php echo $blocName ?>_cancel').fadeIn('fast');
                    });
                });
            });
        });

        $("#<?php echo $blocName ?>_cancel").click(function(){

        	$("#<?php echo $blocName ?>"+'_gadget').val($('.oldNickName').val());

            // On fait disparaitre le input pour faire apparaitre le texte
            $('#<?php echo $blocName ?>_input').fadeOut('fast',function(){
                $('#<?php echo $blocName ?>_span').fadeIn('fast');
            });

            // On cache les 2 boutons
            $('#<?php echo $blocName ?>_cancel').fadeOut('fast',function(){
                $('#<?php echo $blocName ?>_save').fadeOut('fast',function(){
                    $('#<?php echo $blocName ?>_img').fadeIn('fast',function(){
                        $('#<?php echo $blocName ?>_help').fadeIn('fast');
                    });
                });
            });

        });

        // On enregistre
        $("#<?php echo $blocName ?>_save").click(function(){

            if ( !isValidNicknameFormat($('#<?php echo $blocName ?>_gadget').val())) {
            	var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?>'+"<?php echo __('text_register_error_pseudo_not_match_constraint')?>"+'</div>';
    	        showNotification(data, "error", function(){});

            } else if(!isValidNicknameFormat($('#<?php echo $blocName ?>_gadget').val())) {
            	var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?>'+"<?php echo __('text_register_error_pseudo_not_match_constraint')?>"+'</div>';
    	        showNotification(data, "error", function(){});
            } else if(eval(isExistNickName($('#<?php echo $blocName ?>_gadget').val(), "<?php echo url_for(array('module' => 'account', 'action' => 'existsNickname')) ?>"))) {
            	var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?>'+"<?php echo __('text_register_pseudo_already_exist')?>"+'</div>';
    	        showNotification(data, "error", function(){});
            } else {
                var data = $('#<?php echo $blocName ?>_form').serialize();
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
                      	$("#<?php echo $blocName ?>"+'_span').html( response.query.monComptePseudo );

                        // Update old values
                        $('.oldNickName').val(response.query.monComptePseudo);
                        $("#<?php echo $blocName ?>"+'_gadget').val(response.query.monComptePseudo);

                        // We hide the save/cancel buttons
                        $('#<?php echo $blocName ?>_input').fadeOut('fast',function(){
                            $('#<?php echo $blocName ?>_span').fadeIn('fast');
                        });

                        $('#<?php echo $blocName ?>_cancel').fadeOut('fast',function(){
                            $('#<?php echo $blocName ?>_save').fadeOut('fast',function(){
                                $('#<?php echo $blocName ?>_img').fadeIn('fast');
                            });
                        });
                    }
                    else if(response['http_code'] == '400') {
                    	var data = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('interface/ticker_error.png', array('style' => 'padding-right:10px;', 'size' => '15x15')); ?>'+response.msg+'</div>';
            	        showNotification(data, "error", function(){});
                    }
				});
            }
        });
    });
</script>
<?php endif ?>
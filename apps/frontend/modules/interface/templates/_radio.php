<div id="<?php echo $blocName ?>_bulle" style="z-index: 100; position: absolute; margin-top: -18px; margin-left: <?php echo $marginLeftError ?>px; width: 229px; height: 66px; background: url('/images/interface/bulle.png'); display: none; ">
    <p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo $messageError ?></p>
</div>
<div id="<?php echo $blocName ?>_contener" <?php if (!isset($noMargin)) : ?> style="margin-top: 4px; margin-bottom: 19px;"<?php endif; ?>>
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width1 ?>" align="right" height="28">
                <span style="font-family: Arial; font-size: 12px; font-weight: bold; color: #6A6A69;">
                	<?php echo $blocLegende ?>
                </span>
            </td>
            <td width="<?php echo $width2 ?>" align="left" height="28" valign="middle">
                <table class="<?php echo $blocName ?>--container" border="0" cellpadding="0" cellspacing="0" style="margin-left: <?php if (isset($marginLeft)) : ?><?php echo $marginLeft; ?><?php else : ?>25<?php endif; ?>px;">
                <?php foreach ( $blocChoices as $key => $choice ): ?>
                	<tr>
                        <td style="width: 10px; height: 20px; vertical-align: middle; text-align: center;" id="<?php echo $blocName ?>_radio">
                        <?php if (isset($activeImage) && isset($inactiveImage)) : ?>
                        	<img class="mock-radio" src="<?php if ($choice == $blocValue) : ?><?php echo $activeImage; ?><?php else : ?><?php echo $inactiveImage; ?><?php endif; ?>" onclick="radioMockClick<?php echo $blocId; ?>(this)" id="<?php echo $blocName ?>_<?php echo $key ?>--mock" style="margin-right: 4px;" />
                            <input type="radio" id="<?php echo $blocName ?>_<?php echo $key ?>" name="<?php echo $bloc ?>[<?php echo $blocName ?>]" <?php echo ($choice==$blocValue?'checked':'') ?> value="<?php echo $choice ?>" style="display: none;<?php if (!isset($noMargin)) : ?> padding-left: 7px;<?php endif; ?>" class="formInputRadio formInputRadio-<?php echo $blocName; ?>">
                        <?php else : ?>
                            <input type="radio" id="<?php echo $blocName ?>_<?php echo $key ?>" name="<?php echo $bloc ?>[<?php echo $blocName ?>]" <?php echo ($choice==$blocValue?'checked':'') ?> value="<?php echo $choice ?>" <?php if (!isset($noMargin)) : ?>style="padding-left: 7px;"<?php endif; ?> class="formInputRadio">
                        <?php endif; ?>
                    	</td>
                    	<?php if (!isset($noLabel)) : ?>
                        <td>
	                        <label for="<?php echo $blocName ?>_<?php echo $key ?>" style="font: normal 12px Arial; color: #6A6A69; margin-left: 5px;">
	                        <?php echo __($choice) ?>
	                        </label>
                        </td>
                    	<?php endif; ?>
                    </tr>
                <?php endforeach ?>
                </table>
            </td>
            <td align="left" height="28">
                <?php if (isset($blocHelp)): ?>
                    <div style="margin-top: 6px; margin-left: 15px;">
                        <span class="help" id="<?php echo $blocName ?>_help" style="display: none;"><?php echo $blocHelp ?></span>
                    </div>
                <?php endif ?>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
   	$(function(){
        $("#<?php echo $blocName ?>_contener").hover(function() {
            $("#<?php echo $blocName; ?>_help").fadeIn(500);
        }, function() {
            if ($("#<?php echo $blocName; ?>").is(":focus")) {}else{$("#<?php echo $blocName; ?>_help").fadeOut(500);}  
    	});
    
	<?php if (isset($blocActions)) : ?>
		<?php foreach ( $blocChoices as $key => $choice ): ?>
			<?php if ( $blocActions[$key] != '' ): ?>
				$("#<?php echo $blocName ?>_<?php echo $key ?>").click(function () {
					$("#<?php echo $blocActions[0] ?>").fadeIn();
				});
			<?php else: ?>
				$("#<?php echo $blocName ?>_<?php echo $key ?>").click(function () {
					$("#<?php echo $blocActions[0] ?>").fadeOut();
				});
			<?php endif ?>
		<?php endforeach ?>
	<?php endif; ?>
        
	<?php foreach ( $blocChoices as $key => $choice ): ?>
		<?php if ( $key == '0' ): ?>
			$("#<?php echo $blocName ?>_<?php echo $key ?>").click(function () {
				jQuery.ajaxSetup({async:false});
	        	$('#blockIBAN').slideUp("fast");
	        	$('#blockRIB').slideDown("fast");
			});
		<?php else: ?>
			$("#<?php echo $blocName ?>_<?php echo $key ?>").click(function () {
				jQuery.ajaxSetup({async:false});
	        	$('#blockRIB').slideUp("fast");
	        	$('#blockIBAN').slideDown("fast");
			});
		<?php endif ?>
	<?php endforeach ?>
    });  
    <?php if (isset($activeImage) && isset($inactiveImage)) : ?>
        function radioMockClick<?php echo $blocId ?>(button) {
            var data = button.id.split('--');
            var trueButton = $('#' + data[0]);
            var check = (button.src.indexOf('<?php echo $inactiveImage; ?>') > 0);
            
            otherButtons = $(".formInputRadio-<?php echo $blocName ?>");
            for (var i = 0; i < otherButtons.size(); i++) {
                otherButtons.get(i).checked = false;
                otherButtons.eq(i).change();
            };
            if (check) {
                trueButton.get(0).checked = true;
                trueButton.change();
            } else {
                trueButton.get(0).checked = false;
                trueButton.change();
            }
        }
        
        $(function() {
            $(".formInputRadio-<?php echo $blocName ?>").change(function() {
                var button = $("#" + $(this).get(0).id + "--mock").get(0);
                if ($(this).get(0).checked) {
                    button.src = '<?php echo $activeImage; ?>';
                } else {
                    button.src = '<?php echo $inactiveImage; ?>';
                }
            })
        })
    <?php endif; ?>
</script>
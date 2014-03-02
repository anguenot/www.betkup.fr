<?php use_javascript('json2.js')?>

<div id="<?php echo $blocName ?>_bulle" class="widgetError" style="margin-left: <?php echo $marginLeftError ?>px;">
    <p class="widgetError"><?php echo $messageError ?></p>
</div>
<div style="margin-top: 4px; margin-bottom: 10px;">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width ?>" align="right" height="28">
                <span style="font-family: Arial; font-size: 12px; font-weight: bold; color: #6A6A69;"><?php echo $blocLegende ?></span>
            </td>
            <td width="<?php echo $width2 ?>" align="left" height="28" valign="top">
                
                <div id="<?php echo $blocName ?>_txt" class="<?php echo $class ?>_span" style="width: 230px; float: left; margin-left: 20px; line-height: 25px; height: 25px;">
                    <span id="<?php echo $blocName ?>_span" style="line-height: 28px; font-family: Arial; font-size: 12px; font-weight: normal; color: #6A6A69;"><?php echo $countries[$blocValue] ?></span>
                </div>
                
                <div id="<?php echo $blocName ?>_input" class="<?php echo $class ?>_input" style="width: 240px; margin-left: 10px; <?php echo ($blocIcone != "") ? 'display: none;' : ''; ?> ">
                    
                <select id="<?php echo $blocName ?>_gadget" name="<?php echo $bloc ?>[<?php echo $blocName ?>]" class="formInputSelect" style="padding-left: 7px; font-family: Arial; font-size: 12px; font-weight: normal; text-decoration: none; color: #8A8A8A; background-color: #F4F4F4; width: 224px; height: 24px;">

                    <?php if ( $blocFirstRow != '' ): ?>
                        <option value="0"><?php echo $blocFirstRow ?></option>
                    <?php endif ?>

                    <?php foreach ( $blocChoices as $key => $choice ): ?>

                        <?php if ( $blocValue != '' ): ?>
                            <option value="<?php echo $key ?>" <?php echo ($key==$blocValue?'selected':'') ?>><?php echo $choice ?></option>
                        <?php else: ?>

                            <?php if ( $blocValueDefault != '' ): ?>
                                <option value="<?php echo $key ?>" <?php echo ($key==$blocValueDefault?'selected':'') ?>><?php echo $choice ?></option>
                            <?php else: ?>
                                <option value="<?php echo $key ?>"><?php echo $choice ?></option>
                            <?php endif ?>

                        <?php endif ?>
                    <?php endforeach ?>

                </select>
                </div>
            </td>
            <td align="left" height="28">
                <div>
                    
                    <?php if ($blocIcone == "cadenas"): ?>
                    	<img id="<?php echo $blocName ?>_img" class="<?php echo $blocName ?>_crayon <?php echo $blocName ?>_crayonClik" src="/images/interface/cadenas.png" border="0" title="Editable" alt="Locked">
                    <?php endif ?>
                </div>
                <div style="width: 200px;">
                    <?php if (isset($blocHelp)): ?>
                        <span class="help"><?php echo $blocHelp ?></span>
                    <?php endif ?>
                    <img id="<?php echo $blocName ?>_save" src="/images/interface/boutonSave_FR.png" border="0" class="widgetSave" alt="Save">
                    <img id="<?php echo $blocName ?>_cancel" src="/images/interface/boutonAnnuler_FR.png" border="0" class="widgetCancel" alt="Cancel">
                </div>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
	$(function() {
		$('#<?php echo $blocName ?>_gadget').selectmenu({
			style:'dropdown', 
			width: 240,
			menuWidth: 240
		});
	});
</script>
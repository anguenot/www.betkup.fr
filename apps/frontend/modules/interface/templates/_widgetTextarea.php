<div id="<?php echo $blocName ?>_bulle" class="widgetError" style="margin-left: <?php echo $marginLeftError ?>px;">
    <p class="widgetError"><?php echo $messageError ?></p>
</div>
<div style="margin-top: 4px; margin-bottom: 19px;">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width1 ?>" align="right" height="28" valign="top">
                <span style="font-family: Arial; font-size: 12px; <?php echo ($bloc == 'gold' ? 'font-weight: normal;' : 'font-weight: bold;') ?> color: #6A6A69;"><?php echo $blocLegende ?></span>
            </td>
            <td width="<?php echo $width2 ?>" align="<?php echo $col2_align ?>" height="28" valign="top">
                <div id="<?php echo $blocName ?>_input" style="margin-left: 15px;">
                    <textarea <?php echo (isset($maxSize)) ? 'maxlength="'.$maxSize.'"': '';?> <?php echo (isset($lengthcut)) ? 'lengthcut="'.$lengthcut.'"': '' ?> id="<?php echo $blocName ?>" name="<?php echo $bloc ?>[<?php echo $blocName ?>]" class="formFile" style="background-color: #F4F4F4; 
                              padding: 7px; 
                              font-family: Arial;
                              font-size: 14px;
                              font-weight: normal;
                              text-decoration: none;
                              color: #8A8A8A; 
                              border: 1px solid #D7D7D7; 
                              width: <?php echo $widthGadget ?>px; 
                              height: <?php echo $heightGadget ?>px;" 
                              <?php echo $option ?>
                              ><?php echo $blocValue ?></textarea>
                </div>
            </td>
            <td style="text-align: left; vertical-align: middle;" height="28">
                <div style="width: <?php echo $width3 ?>px; margin-left: 7px;">
                    <?php if (isset($blocHelp)): ?>
                        <span class="help" style="<?php echo ($displayHelp ? 'display: block;' : 'display: none;') ?>" id="<?php echo $blocName ?>_help"><?php echo $blocHelp ?></span>
                    <?php endif ?>
                    <img id="<?php echo $blocName ?>_save" src="/images/interface/boutonSave_FR.png" border="0" class="widgetSave" alt="Save">
                    <img id="<?php echo $blocName ?>_cancel" src="/images/interface/boutonAnnuler_FR.png" border="0" class="widgetCancel" alt="Cancel">
                </div>
            </td>
        </tr>
    </table>
</div>
<?php if (isset($blocHelp) && !$displayHelp): ?>
    <script type="text/javascript">
        $("#<?php echo $blocName; ?>").focus(function () {
            $("#<?php echo $blocName; ?>_help").fadeIn(500);
        }).mouseenter(function () {
            $("#<?php echo $blocName; ?>_help").fadeIn(500);
        }).blur(function () {
            $("#<?php echo $blocName; ?>_help").fadeOut(500);
        }).mouseleave(function () {
            if ($("#<?php echo $blocName; ?>").is(":focus")) {}else{$("#<?php echo $blocName; ?>_help").fadeOut(500);}
        });
    </script>
    <?php

 endif ?>
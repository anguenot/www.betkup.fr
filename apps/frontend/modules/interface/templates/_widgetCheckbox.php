<div id="<?php echo $blocName ?>_bulle" style="z-index: 100; position: absolute; margin-top: -18px; margin-left: <?php echo $marginLeftError ?>px; width: 229px; height: 66px; background: url('/images/interface/bulle.png'); display: none; ">
    <p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo $messageError ?></p>
</div>
<div id="<?php echo $blocName; ?>_contener" style="margin-top: 4px; margin-bottom: 19px;">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width1 ?>" align="right" height="28" valign="top">
                <div style="margin: 0px; margin-top: 6px;">
                    <span style="font-family: Arial; font-size: 12px; font-weight: bold; color: #6A6A69;"><?php echo $blocLegende ?></span>
                </div>
            </td>
            <td width="<?php echo $width2 ?>" align="left" height="28" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" style="margin: 0px; margin-left: 14px;">
                <?php foreach ( $blocChoices as $key => $choice ): ?>
                    <tr>
                        <td width="16" align="left" valign="middle"><input type="checkbox" id="<?php echo $blocName ?>" name="<?php echo $bloc ?>[<?php echo $blocName ?>][]" value="<?php echo $choice ?>" <?php echo (in_array($choice, $sf_data->getRaw('blocValue'))?'checked':'') ?> style="padding-left: 7px;" class="formInputRadio"></td>
                        <td><span style="line-height: 28px; font-family: Arial; font-size: 12px; font-weight: normal; color: #6A6A69; margin-right: 25px;"><?php echo __($choice) ?></span></td>
                    </tr>
                <?php endforeach ?>
                </table>
            </td>
            <td align="left" height="28" valign="top">
                <div style="width: 200px; margin-top: 6px; margin-left: 15px;">
                    <?php if (isset($blocHelp)): ?>
                    <span class="help" id="<?php echo $blocName; ?>_help" style="display: none;"><?php echo $blocHelp ?></span>
                    <?php endif ?>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php if(isset($blocName)) : ?>
<script type="text/javascript">

$(function() {
    $("#<?php echo $blocName; ?>_contener").hover(function() {
        $("#<?php echo $blocName; ?>_help").fadeIn(500);
    }, function() {
        if ($("#<?php echo $blocName; ?>").is(":focus")) {}else{$("#<?php echo $blocName; ?>_help").fadeOut(500);}  
    });
});

 </script>
<?php endif; ?>

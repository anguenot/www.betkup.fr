<div id="<?php echo $blocName ?>_bulle" style="z-index: 100; position: absolute; margin-top: -10px; margin-left: <?php echo $marginLeftError ?>px; width: 229px; height: 66px; background: url('/images/interface/bulle.png'); display: none; ">
    <p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo $messageError ?></p>
</div>
<div style="margin-top: 4px; margin-bottom: 19px;">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width1 ?>" align="right" height="50">
                <span style="font-family: Arial; font-size: 12px; font-weight: bold; color: #6A6A69;"><?php echo $blocLegende ?></span>
            </td>
            <td width="<?php echo $width2 ?>" align="right" height="50" valign="middle">
                <div id="<?php echo $blocName ?>_textarea" style="float: left; margin-left: 10px;">
                    <textarea id="<?php echo $blocName ?>" name="<?php echo $bloc ?>[<?php echo $blocName ?>]" style="height: 50px; width: <?php echo $width2 ?>px; padding-top: 5px; font-size: 12px" class="formInputVarchar"><?php echo $blocValue ?></textarea>
                </div>
            </td>
            <td align="left" height="50">
                <div style="margin-left: 15px;">
                    <?php if (isset($blocHelp)): ?>
                        <span class="help" style="display: none;" id="<?php echo $blocName ?>_help"><?php echo $blocHelp ?></span>
                    <?php endif ?>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php if (isset($blocHelp)): ?>
 <script type="text/javascript">
     $(function(){
         $("#<?php echo $blocName; ?>").focus(function () {
             $("#<?php echo $blocName; ?>_help").fadeIn(500);
        }).mouseenter(function () {
             $("#<?php echo $blocName; ?>_help").fadeIn(500);
        }).blur(function () {
             $("#<?php echo $blocName; ?>_help").fadeOut(500);
        }).mouseleave(function () {
                if ($("#<?php echo $blocName; ?>").is(":focus")) {}else{$("#<?php echo $blocName; ?>_help").fadeOut(500);}
        });
     });
 </script>
 <?php endif ?>
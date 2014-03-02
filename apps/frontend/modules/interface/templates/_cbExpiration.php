<div id="<?php echo $blocName ?>_bulle" style="z-index: 100; position: absolute; margin-top: -18px; margin-left: <?php echo $marginLeftError ?>px; width: 229px; height: 66px; background: url('/images/interface/bulle.png'); display: none; ">
    <p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo $messageError ?></p>
</div>
<div style="margin-top: 4px; margin-bottom: 19px;">
    <table style="border-spacing: 0;">
        <tr>
            <td width="<?php echo $width1 ?>" align="right" height="28">
                <span style="font-family: Arial; font-size: 12px; font-weight: bold; color: #6A6A69;"><?php echo $blocLegende ?></span>
            </td>
            <td width="<?php echo $width2 ?>" align="left" height="28" valign="middle">
                <table style="margin-left: 10px;">
                    <tr>
                        <td width="80px" id="<?php echo $blocName ?>_2_td">
                            <select id="<?php echo $blocName ?>_2" name="<?php echo $bloc ?>[<?php echo $blocName ?>_2]" class="formInputSelect">
                            <?php foreach ( Util::getCBExpirationMonths() as $key => $choice ): ?>
                                <option value="<?php echo $choice ?>" <?php echo ($choice==$blocValue2?'selected':'') ?>><?php echo $choice ?></option>
                            <?php endforeach ?>
                            </select>
                        </td>
                        <td width="80px" id="<?php echo $blocName ?>_3_td">
                            <select id="<?php echo $blocName ?>_3" name="<?php echo $bloc ?>[<?php echo $blocName ?>_3]" class="formInputSelect">
                            <?php foreach ( Util::getCBExpirationYears() as $key => $choice ): ?>
                                <option value="<?php echo $choice ?>" <?php echo ($choice==$blocValue3 ? "selected" : "") ?>><?php echo $choice ?></option>
                            <?php endforeach ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </td>
            <td align="left" height="28">
                <div style="width: <?php echo $width3 ?>px; margin-left: 10px;">
                    <?php if (isset($blocHelp)): ?>
                        <span class="help" style="display: none" id="<?php echo $blocName ?>_help"><?php echo $blocHelp ?></span>
                    <?php endif ?>
                </div>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
$(function(){
<?php for ($i = 1; $i < 4; $i++) { ?>
$("#<?php echo $blocName.'_'.$i; ?>").selectmenu({
	style:'dropdown', 
	width: 80,
	menuWidth: 80
});
<?php }?>
});
</script>
<?php if (isset($blocHelp)): ?>
 <script type="text/javascript">
<?php for ($i = 1; $i < 4; $i++) { ?>
$("#<?php echo $blocName.'_'.$i; ?>_td").focusin(function () {
     $("#<?php echo $blocName; ?>_help").fadeIn(500);
}).focusout(function () {
	$("#<?php echo $blocName; ?>_help").fadeOut(500);
});
<?php }?>
</script>
<?php endif ?>
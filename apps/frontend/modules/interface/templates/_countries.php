<div id="<?php echo $blocName ?>_bulle" class="widgetError" style="margin-left: <?php echo $marginLeftError ?>px;">
    <p class="widgetError"><?php echo $messageError ?></p>
</div>
<div style="margin-top: 4px; margin-bottom: 19px;">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width1 ?>" align="right" height="28">
                <span style="font-family: Arial; font-size: 12px; font-weight: bold; color: #6A6A69;"><?php echo $blocLegende ?></span>
            </td>
            <td width="<?php echo $width2 ?>" align="right" height="28" valign="middle">
				<table style="margin-left: 10px;">
					<tr>
						<td width="150px" style="margin-left: 10px;" id="<?php echo $blocName ?>_td">
						<select id="<?php echo $blocName ?>" name="<?php echo $bloc ?>[<?php echo $blocName ?>]" class="formInputSelect" style="width: <?php echo $width2 ?>px;" data-iconpos="noicon">

								<?php if ( $blocFirstRow != '' ): ?>
								<option value="0">
									<?php echo $blocFirstRow ?>
								</option>
								<?php endif ?>

								<?php foreach ( $blocChoices as $key => $choice ): ?>

								<?php if ( $blocValue != '' ): ?>
								<option value="<?php echo $key ?>"
								<?php echo ($key==$blocValue?'selected':'') ?>>
									<?php echo $choice ?>
								</option>
								<?php else: ?>

								<?php if ( $blocValueDefault != '' ): ?>
								<option value="<?php echo $key ?>"
								<?php echo ($key==$blocValueDefault?'selected':'') ?>>
									<?php echo $choice ?>
								</option>
								<?php else: ?>
								<option value="<?php echo $key ?>">
									<?php echo $choice ?>
								</option>
								<?php endif ?>

								<?php endif ?>

								<?php endforeach ?>

						</select></td>
					</tr>
				</table></td>
            <td align="left" height="28">
                <div style="width: <?php echo $width3 ?>px; margin-left: 15px;">
                    <?php if ( isset($blocHelp) ): ?>
                        <span class="help" style="display: none;" id="<?php echo $blocName ?>_help"><?php echo $blocHelp ?></span>
                    <?php endif ?>
                </div>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
$(function(){
$("#<?php echo $blocName ;?>").selectmenu({
	style:'dropdown', 
	width: 245,
	menuWidth: 245
});
});
</script>
<?php if (isset($blocHelp)): ?>
 <script type="text/javascript">
 $("#<?php echo $blocName; ?>_td").live('focusin mouseover', function() {
     $("#<?php echo $blocName; ?>_help").fadeIn(500);
}).live('focusout mouseleave', function() {
	$("#<?php echo $blocName; ?>_help").fadeOut(500);
});
 </script>
<?php endif ?>

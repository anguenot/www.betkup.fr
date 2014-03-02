<div id="<?php echo $blocName ?>_bulle" class="widgetError" style="margin-left: <?php echo $marginLeftError ?>px;">
    <p class="widgetError"><?php echo $messageError ?></p>
</div>
<div style="<?php if (!isset($noMargin)) : ?>margin-top: 4px; margin-bottom: 19px;<?php else : ?>float: left;<?php endif; ?> width: <?php echo $width1 + $width2 + $width3; ?>px;">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width1 ?>" align="right" height="28">
                <span style="font-family: Arial; font-size: 12px; font-weight: bold; color: #6A6A69;"><?php echo $blocLegende ?></span>
            </td>
			<td width="<?php echo $width2 ?>" align="left" height="28" valign="middle">
				<table <?php echo (!isset($noMargin)) ? 'style="margin-left: 10px;"': ''; ?>>
					<tr>
						<td width="150px" id="<?php echo $blocName ?>_td">
						<select id="<?php echo $blocName; ?>" name="<?php echo $bloc ?>[<?php echo $blocName ?>]" class="formInputSelect" style="width: <?php echo $width2 ?>px; margin-left: 10px;">

								<?php if ( isset($blocFirstRow) &&  $blocFirstRow != '' && isset($blocFirstValue)): ?>
									<option value="<?php if((isset($blocFirstRow)) && ($blocFirstRow != "")){ echo $blocFirstValue; }else{ echo "0";}?>">
										<?php echo __($blocFirstRow) ?>
									</option>
								<?php endif ?>
								
								<?php foreach ( $blocChoices as $key => $choice ): ?>

									<?php if ( $blocValue != '' ): ?>
										<option value="<?php echo $key ?>" <?php echo ($key == $blocValue ? 'selected="selected"' : '') ?>>
											<?php echo __($choice) ?>
										</option>
									<?php elseif ( $blocValueDefault != '' ): ?>
										<option value="<?php echo $key ?>" <?php echo ($key == $blocValueDefault ? 'selected="selected"' : '') ?>>
											<?php echo __($choice) ?>
										</option>
									<?php else: ?>
										<option value="<?php echo $key ?>">
											<?php echo __($choice) ?>
										</option>
									<?php endif; ?>

								<?php endforeach; ?>
						</select>
						</td>
					</tr>
				</table>
			</td>
            <td align="left" height="28">
                <div style="width: <?php echo $width3 ?>px;<?php if (!isset($noMargin)) : ?> margin-left: 15px;<?php endif; ?>">
                    <?php if ( isset($blocHelp) ): ?>
                        <span class="help" style="display: none;" id="<?php echo $blocName ?>_help"><?php echo $blocHelp ?></span>
                    <?php endif ?>
                </div>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
	$(function() {
		$("#<?php echo $blocName;?>").selectmenu({
			style:'dropdown', 
			width: '<?php echo $width2 ?>',
			menuWidth: '<?php echo $width2 ?>'
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

<div id="<?php echo $blocName ?>_bulle" class="widgetError" style="margin-left: <?php echo $marginLeftError ?>px;">
    <p class="widgetError"><?php echo $messageError ?></p>
</div>
<div style="margin-top: 4px; margin-bottom: 10px;">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width ?>" align="right" height="28">
                <span style="font-family: Arial; font-size: 12px; font-weight: bold; color: #6A6A69;"><?php echo $blocLegende ?></span>
            </td>
            <td width="252" align="left" height="28" valign="top">
                <div id="<?php echo $blocName ?>_txt" class="<?php echo $class ?>_span" style="width: 230px; float: left; margin-left: 20px; line-height: 25px; height: 25px;">
                    <span id="<?php echo $blocName ?>_span" style="line-height: 28px; font-family: Arial; font-size: 12px; font-weight: normal; color: #6A6A69;"><?php echo $blocValue ?></span>
                </div>
               	<div id="<?php echo $blocName ?>_input" class="<?php echo $class ?>_input" style="position: absolute; float: left; margin-left: 10px; <?php echo ($blocIcone != "") ? 'display: none;' : ''; ?>">
	                <?php include_component('interface', 'radio', array('bloc' => 'edit', 'width1' => '0', 'width2' => '240', 'marginLeftError' => '0', 'messageError' => __('account_registerAdvanced_accountCivilite_messageError_text'), 'blocName' => 'monCompteCivility', 'blocLegende' => '', 'blocValue' => $blocValue, 'blocChoices' => array('M', 'Mme', 'Mlle'))) ?>
	            </div>
            </td>
            <td align="left" height="28">
                <div>
                    <?php if ($blocIcone == "cadenas"): ?>
                    	<img id="<?php echo $blocName ?>_img" class="<?php echo $blocName ?>_crayon <?php echo $blocName ?>_crayonClik" src="/images/interface/cadenas.png" border="0" title="Locked" alt="Locked">
                    <?php endif ?>
                </div>
            </td>
        </tr>
    </table>
</div>
<div id="content-search-<?php echo $blocName; ?>-results" class="content-search-city-results" style="margin-left: 230px; margin-top:10px;">
</div>
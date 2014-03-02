<div id="<?php echo $blocName ?>_bulle" class="widgetError_accept" style="margin-left: <?php echo $marginLeftError ?>px;">
    <p class="widgetError"><?php echo $messageError ?></p>
</div>
<div style="margin-top: 0px; margin-bottom: 10px;">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="20" height="18" style="vertical-align: top;" >
                <input id="<?php echo $blocName ?>" type="checkbox" name="<?php echo $blocName ?>" value="<?php echo $blocValue ?>" <?php echo $blocChecked ?>>
            </td>
            <td style="vertical-align: top;">
                <div style="font-family: Arial; font-size: 12px; font-weight: normal; color: #6A6A69;"><?php echo html_entity_decode($blocLegende); ?></div>
            </td>
        </tr>
    </table>
</div>
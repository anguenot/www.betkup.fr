<div id="<?php echo $blocName ?>_bulle" style="z-index: 100; position: absolute; margin-top: -18px; margin-left: <?php echo $marginLeftError ?>px; width: 229px; height: 66px; background: url('/images/interface/bulle.png'); display: none; ">
    <p style="margin-left: 25px; margin-top: 12px; font-family: Arial; font-size: 10px; font-weight: normal; color: #DC2D32;"><?php echo $messageError ?></p>
</div>
<div style="margin-top: 4px; margin-bottom: 10px;">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="<?php echo $width1 ?>" align="right" height="28">
                <p style="margin: 0px; padding: 0px; height: 14px;"></p>
                <span style="font-family: Arial; font-size: 12px; font-weight: bold; color: #6A6A69;"><?php echo $blocLegende ?></span>
            </td>
            <td width="500" align="left" height="28" valign="middle">
                <div id="<?php echo $blocName ?>_input" style="margin-left: 10px;">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><div class="legende ribLegende">&nbsp; <?php echo __('Banque') ?></div></td>
                            <td><div class="legende ribLegende">&nbsp; <?php echo __('Guichet') ?></div></td>
                            <td><div class="legende ribLegende">&nbsp; <?php echo __('Compte') ?></div></td>
                            <td><div class="legende ribLegende">&nbsp; <?php echo __('Clé') ?></div></td>
                        </tr>
                        <tr>
                            <td><input type="text" id="<?php echo $blocName ?>_1" name="<?php echo $bloc ?>[<?php echo $blocName ?>_1]" value="<?php echo $blocValue[0] ?>" class="formInputVarchar1 rib"></td>
                            <td><input type="text" id="<?php echo $blocName ?>_2" name="<?php echo $bloc ?>[<?php echo $blocName ?>_2]" value="<?php echo $blocValue[1] ?>" class="formInputVarchar2 rib"></td>
                            <td><input type="text" id="<?php echo $blocName ?>_3" name="<?php echo $bloc ?>[<?php echo $blocName ?>_3]" value="<?php echo $blocValue[2] ?>" class="formInputVarchar3 rib"></td>
                            <td><input type="text" id="<?php echo $blocName ?>_4" name="<?php echo $bloc ?>[<?php echo $blocName ?>_4]" value="<?php echo $blocValue[3] ?>" class="formInputVarchar4 rib"></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>
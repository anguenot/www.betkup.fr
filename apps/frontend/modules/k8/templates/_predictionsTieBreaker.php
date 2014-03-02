    <table class="table-pronostic-row" border="0">
        <tr>
            <td class="pellet">
                <div>Q</div>
            </td>
            <td align="center">
                <b><?php echo __('label_question_tie_breaker') ?></b>
                <br/>
                <b><?php echo __(sfConfig::get('mod_k8_tb_' . $kupData['config']['tb'])) ?></b>
                <input type="text" name="predictions_tb[<?php echo $kupData['config']['tb'] ?>]"
                       value="<?php echo isset($predictions_tb[$kupData['config']['tb']]) ? $predictions_tb[$kupData['config']['tb']] : 0 ?>"
                    <?php echo ($kupData['status'] > 1 || $kupData['status'] == -1) ? 'disabled="disabled"' : ' ' ?> size="5" maxlength="5" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
    </table>


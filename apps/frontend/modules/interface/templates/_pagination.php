<?php if ($totalKups > $batchSize) : ?>
<div class="paging">
    <table class="paging-table">
        <tbody>
        <tr>
            <?php if ($offset > 0) : ?>
            <td>
                <a class="first" href="javascript:void(0);" onclick="<?php echo $functionKupsLoad?>('0', '<?php echo $batchSize ?>')"></a>
            </td>
            <td>
                <a class="back" href="javascript:void(0);" onclick="<?php echo $functionKupsLoad?>('<?php echo ($offset - $batchSize)?>', '<?php echo $batchSize ?>')"></a>
            </td>
            <?php endif; ?>
            <?php for ($i = 0; $i < $pagerSize; $i++) : ?>
            <?php
            $prev = 2;
            $next = 3;
            if ($offset == 0) {
                $next = 5;
            }
            elseif ($offset / $batchSize == 1) {
                $next = 4;
            } ?>
            <?php if ($i == round($offset / $batchSize) - $next) : ?>
                <td>
                    <a class="points" href="javascript:void(0);"></a>
                </td>
                <?php elseif ($i >= round($offset / $batchSize) - $prev && $i < round($offset / $batchSize) + $next): ?>
                <td>
                    <a class="page <?php echo ($i == round($offset / $batchSize)) ? 'page-on' : 'page-off' ?>" href="javascript:void(0);" onclick="<?php echo $functionKupsLoad?>('<?php echo ($i * $batchSize) ?>', '<?php echo $batchSize ?>')">
                        <?php echo $i + 1?>
                    </a>
                </td>
                <?php
            elseif ($i == round($offset / $batchSize) + $next) : ?>
                <td>
                    <a class="points" href="javascript:void(0);"></a>
                </td>
                <?php endif; ?>
            <?php endfor;?>
            <?php if ($offset <= (($pagerSize - 1) * $batchSize)) : ?>
            <td>
                <a class="next" href="javascript:void(0);" onclick="<?php echo $functionKupsLoad?>('<?php echo ($offset + $batchSize)?>', '<?php echo $batchSize ?>')"></a>
            </td>
            <td>
                <a class="last" href="javascript:void(0);" onclick="<?php echo $functionKupsLoad?>('<?php echo floor(($pagerSize - 1) * $batchSize)?>', '<?php echo $batchSize ?>')"></a>
            </td>
            <?php endif; ?>
        </tr>
        </tbody>
    </table>
</div>
<?php endif; ?>
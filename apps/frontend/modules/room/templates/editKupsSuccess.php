<table style="border-collapse:collapse; border-spacing: 0; padding: 0px">
    <tr>
        <td align="left" valign="top" width="380" id="left_manage_bloc">
            <?php if(isset($availableKups)) :?>
                <?php foreach ( $availableKups as $kup ): ?>
                    <?php include_component('kup', 'preview', array('kup'=>$kup, 'availableStakes'=>$availableStakes, 'availableJackpotRepartitions'=>$availableJackpotRepartitions)) ?>
                <?php endforeach ?>
            <?php endif; ?>
        </td>
        <td align="left" valign="top" id="right_manage_bloc">
            <?php if(isset($roomKups)) :?>
                <?php foreach ( $roomKups as $kup ): ?>
                    <?php include_component('kup', 'preview', array('kup'=>$kup, 'availableStakes'=>$availableStakes, 'availableJackpotRepartitions'=>$availableJackpotRepartitions)); ?>
                <?php endforeach ?>
            <?php endif; ?>
        </td>
    </tr>
</table>
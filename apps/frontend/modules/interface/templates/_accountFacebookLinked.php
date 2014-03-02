<div
    style="width: 460px; height: 130px; text-align: center; background-color: #e4e8f1; border: 1;"
    align="center">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="110px;">
                <a href="http://www.facebook.com/profile.php?id=<?php echo $sf_user->getAttribute('facebookId', '', 'subscriber') ?>" target="_blank">
                    <img
                        style="padding: 5px; height: 120px; width: 100px;"
                        src="https://graph.facebook.com/<?php echo $sf_user->getAttribute('facebookId', '', 'subscriber') ?>/picture?type=normal"
                        border="0" />
                </a>
            </td>
            <td
                style="padding: 5px; padding-top: 15px; vertical-align: top; width: 230px;"><span
                    style="font-size: 14px; color: #3a71b1; font-weight: bold;">
                <?php echo $sf_user->getAttribute('facebookName', '', 'subscriber') ?></span>
            </td>
            <td
                style="vertical-align: bottom; width: 120px; vertical-align: bottom; padding: 5px;">
                <a
                    href="<?php echo url_for(array('module' => 'account', 'action' => 'unlinkFromFacebook')) ?>">
                        <?php echo image_tag('interface/boutonDeconnexion.png') ?>
                </a>
            </td>
        </tr>
    </table>
</div>

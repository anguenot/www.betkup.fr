<div class="oneComment">
    <div class="avatar"><img alt="avatar" src="<?php echo $avatar ?>" height="50" width="50" /></div>
    <div class="identity">
        <p class="name"><?php echo $nom ?></p>
        <p class="infos"><?php echo $datecomment ?><br/><?php echo $heurecomment ?></p>
    </div>
    <div class="comment">
        <div class="zoneComment">
            <?php if ($responseAt != ''): ?>
                <b>@ <?php echo $responseAt ?>: </b>
            <?php endif ?>
            <?php echo $comment ?>
        </div>
        <p class="response">
            <a href="#ancre-blocMessage" onclick="document.frmWallMessage.frmWallMessage_message.focus();" title="répondre">répondre</a>
        </p>
    </div>
    <div style="clear:both"></div>
</div>
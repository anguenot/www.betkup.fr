<div class="friends-to-invite-container box-wrap">
    <?php foreach ($friends as $friend) : ?>
    <div class="friend-box" title="<?php echo $friend['name'] ?>">
        <a href="javascript:void(0);" onclick="sendRequestToRecipients(<?php echo $friend['uid'] ?>)">
            <?php echo image_tag($friend['pic_square'], array('size' => '50x50')) ?>
        </a>
        <a href="javascript:void(0);" class="friend-name" onclick="sendRequestToRecipients(<?php echo $friend['uid'] ?>)">
            <?php echo $friend['name'] ?>
        </a>
        <a href="javascript:void(0);" class="friend-challenge-text" onclick="sendRequestToRecipients(<?php echo $friend['uid'] ?>)">
            Défier
        </a>
    </div>
    <?php endforeach; ?>
</div>
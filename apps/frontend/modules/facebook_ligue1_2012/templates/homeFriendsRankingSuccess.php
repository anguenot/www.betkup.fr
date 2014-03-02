<div class="friends-ranking-container box-wrap">
    <?php foreach ($friendsRanking['entries'] as $friend) : ?>
    <div class="friend-ranking-box" title="<?php echo $friend['member']['firstName'] . ' ' . $friend['member']['lastName'] ?>">
        <a href="javascript:void(0);">
            <?php echo image_tag(str_replace('http://', 'https://', $friend['member']['avatarSmall']), array('size' => '50x50')) ?>
        </a>
        <a href="javascript:void(0);" class="friend-name">
            <?php echo util::getNicknameFor($friend['member']) ?>
        </a>

        <h3>
            <?php echo $friend['position'] ?>e
        </h3>
    </div>
    <?php endforeach; ?>
</div>
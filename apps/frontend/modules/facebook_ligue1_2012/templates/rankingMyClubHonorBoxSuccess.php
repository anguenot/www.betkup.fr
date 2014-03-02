<div class="honor-bg">
    <table>
        <tbody>
        <tr>
            <?php if (isset($rankingDay['entries']) && count($rankingDay['entries']) > 0) : ?>
            <?php foreach ($rankingDay['entries'] as $key => $ranking) : ?>
                <td>
                    <?php if ($key == 0) : ?>
                    <div class="podium-separator-1"></div>
                    <?php elseif ($key == 2) : ?>
                    <div class="podium-separator-2"></div>
                    <?php endif; ?>
                    <div class="ranking-honor-member">
                        <a href="https://facebook.com/<?php echo $ranking['member']['facebookId'] ?>" target="_blank">
                            <?php echo image_tag(str_replace('http://', 'https://', $ranking['member']['avatarSmall']), array('size' => '50x50')) ?>
                            <br/>
                        <span>
                        <?php echo util::getNicknameFor($ranking['member']) ?>
                        </span>
                        </a>
                    </div>
                </td>
                <?php endforeach; ?>
            <?php endif; ?>
        </tr>
        </tbody>
    </table>
    <div class="podium-bg">

    </div>
</div>
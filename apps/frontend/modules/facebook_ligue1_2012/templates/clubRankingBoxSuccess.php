<div class="club-ranking-box">
    <table class="club-ranking-box-table">
        <thead>
        <tr>
            <th style="width: 80px;">Position</th>
            <th>Joueur</th>
            <th>Points</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rankings['entries'] as $i => $ranking) : ?>
        <tr class="<?php echo ($i % 2 == 1) ? 'odd' : 'even' ?>
                    <?php echo $sf_user->getAttribute('facebookId', '', 'subscriber') == $ranking['member']['facebookId'] ? 'selected' : '' ?>">
            <td class="separator">
                <?php echo $ranking['position']; ?><sup>e</sup>
            </td>
            <td class="separator player">
                <a href="https://www.facebook.com/<?php echo $ranking['member']['facebookId'] ?>" target="_blank">
                    <?php echo image_tag(str_replace('http://', 'https://', $ranking['member']['avatarSmall']), array('size' => '50x50')); ?>
                    <span class="facebook-logo">&nbsp;</span>
                    <?php echo util::getNicknameFor($ranking['member']) ?>
                </a>
            </td>
            <td>
                <?php echo $ranking['value'] ?> pts
            </td>
        </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
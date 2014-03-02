<div class="home-club-ranking-container">
    <table class="home-club-ranking-table">
        <thead>
        <tr>
            <th>pos</th>
            <th>Club</th>
            <th>Points</th>
            <th>Supporters</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($clubs as $i => $club) : ?>
        <tr class="<?php echo ($i % 2 == 1) ? 'odd' : 'even' ?> <?php echo ($club['ui']['betkup_room_name'] == $sf_user->getAttribute('clubBindingName', '', 'subscriber')) ? 'selected' : '' ?>">
            <td class="club-position">
                <?php echo $i + 1 ?><sup>e</sup>
            </td>
            <td class="club-infos">
                <div class="club-infos nobr">
                    <a href="<?php echo url_for(array('module'   => 'facebook_ligue1_2012',
                                                     'action'    => 'club',
                                                     'club_uuid' => $club['uuid']
                                                )) ?>">
                        <?php echo image_tag($club['ui']['avatar_small'], array('size' => '40x40')) ?>
                        <?php echo $club['ui']['name'] ?>
                    </a>
                </div>
            </td>
            <td class="club-points">
                <?php echo $club['rankingPoints'] ?> pts
            </td>
            <td class="club-supporters">
                <?php echo $club['numberOfMembers'] ?> supporters
            </td>
        </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="home-leader-box">
    <table class="home-leader-box-table">
        <thead>
        <tr>
            <th>Au général</th>
            <th>Dernière journée</th>
            <th>Club</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <a href="https://www.facebook.com/<?php echo $rankingGeneral['entries'][0]['member']['facebookId'] ?>" target="_blank">
                    <span class="fb-picture">
                        <?php echo image_tag(str_replace('http://', 'https://', $rankingGeneral['entries'][0]['member']['avatarBig'])) ?>
                    </span>
                    <span>
                        <?php echo isset($rankingGeneral['entries'][0]) ? util::getNicknameFor($rankingGeneral['entries'][0]['member']) : 'N/C' ?>
                    </span>

                    <span>
                        <?php echo isset($rankingGeneral['entries'][0]) ? $rankingGeneral['entries'][0]['position'] . ' e' : 'N/C' ?>
                    </span>
                </a>
            </td>
            <td>
                <?php if (isset($rankingDay['entries']) && count($rankingDay['entries']) > 0) : ?>
                <a href="https://www.facebook.com/<?php echo $rankingDay['entries'][0]['member']['facebookId'] ?>" target="_blank">
                    <span class="fb-picture">
                        <?php echo image_tag(str_replace('http://', 'https://', $rankingDay['entries'][0]['member']['avatarBig'])) ?>
                    </span>
                    <span>
                        <?php echo isset($rankingDay['entries'][0]) ? util::getNicknameFor($rankingDay['entries'][0]['member']) : 'N/C' ?>
                    </span>

                    <span>
                        <?php echo isset($rankingDay['entries'][0]) ? $rankingDay['entries'][0]['position'] . ' e' : 'N/C' ?>
                    </span>
                </a>
                <?php else : ?>
                <span>
                        N/C
                    </span>
                <?php endif; ?>
            </td>
            <td>
                <a href="<?php echo url_for(array(
                                                 'module'    => 'facebook_ligue1_2012',
                                                 'action'    => 'club',
                                                 'club_uuid' => $rankingClub['uuid']
                                            )) ?>">
                    <?php echo image_tag($rankingClub['ui']['avatar_big'], array('size' => '75x75')) ?>
                    <span>
                    <?php echo isset($rankingClub['ui']) ? $rankingClub['ui']['name'] : 'N/C' ?>
                </span>

                <span>
                    1 e
                </span>
                </a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
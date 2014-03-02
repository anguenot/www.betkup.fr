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
                <?php if (isset($rankingGeneral['entries']) && count($rankingGeneral['entries']) > 0) : ?>
                <a class="home-my-ranking-table-bg td-bg-general" href="<?php echo url_for(array(
                                                                                                'module'    => 'facebook_ligue1_2012',
                                                                                                'action'    => 'ranking'
                                                                                           )) ?>">
                    <span class="ranking-big">
                        <?php echo isset($rankingGeneral['entries'][0]) ? $rankingGeneral['entries'][0]['position'] . ' e' : 'N/C' ?>
                    </span>
                    <span class="small">
                        Sur <b><?php echo $rankingGeneral['totalMembers'] ?></b> pronostiqueurs
                    </span>
                </a>
                <?php else : ?>
                <span class="ranking-big">
                        N/C
                </span>
                <?php endif; ?>
            </td>
            <td>
                <?php if (isset($rankingDay['entries']) && count($rankingDay['entries']) > 0) : ?>
                <a class="home-my-ranking-table-bg td-bg-day" href="https://www.facebook.com/<?php echo $rankingDay['entries'][0]['member']['facebookId'] ?>" target="_blank">
                    <span class="ranking-big">
                        <?php echo isset($rankingDay['entries'][0]) ? $rankingDay['entries'][0]['position'] . ' e' : 'N/C' ?>
                    </span>
                    <span class="small">
                        Sur <b><?php echo $rankingDay['totalMembers'] ?></b> pronostiqueurs
                    </span>
                </a>
                <?php else : ?>
                <span class="ranking-big">
                        N/C
                </span>
                <?php endif; ?>
            </td>
            <td>
                <a class="home-my-ranking-table-bg td-bg-club" href="<?php echo url_for(array(
                                                                                             'module'    => 'facebook_ligue1_2012',
                                                                                             'action'    => 'ranking'
                                                                                        )) ?>">
                    <span class="club-text-content">
                        <span class="ranking-big">
                           <?php echo isset($rankingClub['entries'][0]) ? $rankingClub['entries'][0]['position'] . ' e' : 'N/C' ?>
                        </span>
                        <span class="small">
                            Sur <b><?php echo $rankingClub['totalMembers'] ?></b> supporters du club
                        </span>
                    </span>

                    <div class="club-logo" style="width:100px; height:100px; opacity:0.4; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $clubLogo ?>',sizingMethod='scale')alpha(opacity=40);">
                        <?php echo image_tag($clubLogo, array(
                                                             'size'   => '100x100',
                                                             'style'  => 'filter: alpha(opacity=40);'
                                                        )) ?>
                    </div>
                </a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
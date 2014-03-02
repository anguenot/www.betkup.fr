<div class="moncompte">
    <?php include_component('account', 'navigation', array()) ?>
    <div id="challenge">
        <table id="room_table" style="margin-top: -2px;">
            <tr>
                <td style="vertical-align: top; width: 760px;">
                    <div class="view" style="margin-top: 4px;">
                        <?php include_component('interface', 'areaOneBegin') ?>

                        <div style="height: 20px;"></div>
                        <?php foreach ($dataKups as $data) : ?>
                        <?php include_component('challenge', 'homeThumbnail', array('challenges' => $data)) ?>
                        <?php endforeach;?>

                        <div style="height: 20px;"></div>
                        <?php if (count($dataEvents) > 0) : ?>
                        <?php foreach ($dataEvents as $data) : ?>
                            <?php include_component('challenge', 'homeThumbnail', array('challenges' => $data)) ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (count($dataPromos) > 0) : ?>
                        <div style="height: 20px;"></div>
                        <?php echo image_tag('/image/default/challenge/title_promos.png', array(
                                                                                               'size'  => '539x47',
                                                                                               'style' => 'margin-left: -30px;'
                                                                                          )) ?>
                        <div style="height: 10px;"></div>
                        <?php foreach ($dataPromos as $data) : ?>
                            <?php include_component('challenge', 'homeThumbnail', array('challenges' => $data)) ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <div style="height: 20px;"></div>
                        <?php echo image_tag('/image/default/challenge/title_challenges.png', array(
                                                                                                   'size'  => '539x47',
                                                                                                   'style' => 'margin-left: -30px;'
                                                                                              ))?>
                        <div style="height: 10px;"></div>
                        <?php foreach ($dataChallenges as $data) : ?>
                        <?php include_component('challenge', 'homeThumbnail', array('challenges' => $data)) ?>
                        <?php endforeach;?>

                        <div style="height: 50px;"></div>
                        <?php include_component('interface', 'areaOneEnd') ?>
                    </div>
                </td>
                <td style="vertical-align: top; width: 220px;">
                    <div style="padding-left: 5px; padding-top: 7px;">
                        <?php include_component('kup', 'right') ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
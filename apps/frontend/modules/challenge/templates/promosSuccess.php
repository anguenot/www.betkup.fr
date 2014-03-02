<div class="moncompte">
    <?php include_component('account', 'navigation', array()) ?>
    <div id="challenge">
        <table id="room_table" style="margin-top: -2px;">
            <tr>
                <td style="vertical-align: top; width: 760px;">
                    <div class="view" style="margin-top: 4px;">
                        <?php include_component('interface', 'areaOneBegin') ?>
                        <div style="height: 20px;"></div>
                        <div id="breadcrumb">
                            <a href="<?php echo url_for(array(
                                                             'module' => 'challenge',
                                                             'action' => 'home'
                                                        ))?>">Challenges</a>
                            <span class="breadcrumb-separator"> > </span>
                            <a class="selected" href="<?php echo url_for(array(
                                                                              'module' => 'challenge',
                                                                              'action' => 'promos',
                                                                              'uuid'   => $uuid
                                                                         ))?>">Promos</a>
                        </div>
                        <div style="height: 30px;"></div>
                        <?php include_component($componentModule, $componentName) ?>
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


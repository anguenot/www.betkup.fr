<div class="links">
    <?php if (!isset($room_uuid)) : ?>
    <a href="<?php echo url_for(array('module'=>'kup', 'action'=>'predictionKnockout', 'uuid'=> $kupData['uuid'])) ?>">
        <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/fixtures_title.png', array('size' => '415x38', 'alt' => __('label_rugby_fixtures'))) ?>
    </a>
   <?php else: ?>
   <a href="<?php echo url_for(array('module'=>'room', 'action'=>'kupPredictionKnockout', 'kup_uuid'=> $kupData['uuid'], 'room_uuid' => $room_uuid)) ?>">
   <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/fixtures_title.png', array('size' => '415x38', 'alt' => __('label_rugby_fixtures'))) ?>
       </a>
   <?php endif ?>
</div>

<form action="" method="post" id="fixtures-form">
<div class="fixtures-container">
    <?php foreach($fixturesData as $fixture => $matches) : ?>
        <table style="padding:0; border-spacing: 0; border-collapse: 0; width: 350px; float: left; margin-right: 10px; margin-bottom: 10px;">
            <thead>
                <tr>
                    <th colspan="7" class="fixture-title"><?php echo $fixture; ?></th>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 10px; border-bottom: 1px solid #e5e5e5;"><td colspan="9"></td></tr>
        <?php $i = 0; ?>
        <?php foreach($matches as $match) : ?>
            <tr>
                <td width="120" class="date hour <?php if ($i%2 == 0) : ?>even<?php else : ?>odd<?php endif; ?>"><?php echo $match['date']; ?></td>
                <td width="80" class="first-country <?php if ($i%2 == 0) : ?>even<?php else : ?>odd<?php endif; ?>">
                    <?php echo __($match['team1Title']); ?>
                </td>
                <td width="33" style="padding: 0;" class="<?php if ($i%2 == 0) : ?>even<?php else : ?>odd<?php endif; ?>">
                    <?php echo image_tag($match['team1_avatar'], array('size' => '33x28', 'alt' => __($match['first_country']))) ?>
                </td>
                <td width="40" class="pronostics <?php if ($i%2 == 0) : ?>even<?php else : ?>odd<?php endif; ?>">
                    <?php include_component('interface', 'radio', array('bloc' => 'match[' . $match['id'] . ']', 'blocId' => $match['id'], 'blocName' => $match['id'], 'noMargin' => true, 'noLabel' => true, 'activeImage' => '/image/default/rugby/checkbox_checked.png', 'inactiveImage' => '/image/default/rugby/checkbox_unchecked.png', 'width1' => '0', 'width2' => '50', 'height' => '28', 'marginLeft' => '0', 'marginLeftError' => '0', 'messageError' => '', 'blocLegende' => '',

                    'blocValue' => (isset($fixtures_ic[$match['id']]) ? $fixtures_ic[$match['id']] : ''), 'blocChoices' => array('1', '2', '3'))) ?>
                </td>
                <td width="33" style="padding: 0;" class="<?php if ($i%2 == 0) : ?>even<?php else : ?>odd<?php endif; ?>">
                    <?php echo image_tag($match['team2_avatar'], array('size' => '33x28', 'alt' => __($match['second_country']))) ?>
                </td>
                <td class="second-country <?php if ($i%2 == 0) : ?>even<?php else : ?>odd<?php endif; ?>">
                    <?php echo __($match['team2Title']); ?>
                </td>
                <td width="35" class="<?php if ($i%2 == 0) : ?>even<?php else : ?>odd<?php endif; ?>">
                    <?php echo image_tag('/image/default/rugby/button_help.png', array('size' => '14x13', 'alt' => __('label_rugby_help'))) ?>
                    <?php echo image_tag('/image/default/rugby/button_graphic.png', array('size' => '14x13', 'alt' => __('label_rugby_graphic'))) ?>
                </td>
            </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</div>
</form>
<div style="clear: both;"></div>

<script type="text/javascript">
    function clearPronostics() {
        $("input", $(".pronostics")).each(function() {
            $(this).get(0).checked = false;
            $(this).change();
        });
    }

    function randomPronostics() {
        var buttons = $("input", $(".pronostics"));
        for (var i = 0; i < buttons.size() / 3; i++) {
            var choice = Math.round(Math.random() * 3);
            if (choice == 1) {
                buttons.get(3*i).checked = true;
                buttons.get(3*i + 1).checked = false;
                buttons.get(3*i + 2).checked = false;
            } else if (choice == 2) {
                buttons.get(3*i).checked = false;
                buttons.get(3*i + 1).checked = true;
                buttons.get(3*i + 2).checked = false;
            } else {
                buttons.get(3*i).checked = false;
                buttons.get(3*i + 1).checked = false;
                buttons.get(3*i + 2).checked = true;
            }
            buttons.eq(3*i).change();
            buttons.eq(3*i + 1).change();
            buttons.eq(3*i + 2).change();
        }
    }
</script>

<?php if ($kupData['status'] < 3 && $kupData['status'] != -1): ?>
<div class="bottom-links">
    <a href="javascript:clearPronostics();" style="text-align: right;">
        <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/button_erase_pronostics.png', array('style' => 'margin-right: 5px;', 'class' => 'button', 'size' => '173x34', 'alt' => __('label_rugby_erase_pronostics'))) ?>
    </a>
    <a href="javascript:randomPronostics();" style="text-align: left;">
        <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/button_fill_randomly.png', array('style' => 'margin-left: 5px;', 'class' => 'button', 'size' => '173x34', 'alt' => __('label_rugby_fill_randomly'))) ?>
    </a>
    <div style="clear: both;"></div>
    <div style="height: 20px;"></div>
    <div align="center" style="width: 100%; text-align: center; padding-left: 25%;">
        <a href="javascript:$('#fixtures-form').get(0).submit();">
            <?php echo image_tag('/image/' . $sf_user->getCulture(). '/rugby/button_goto_table.png', array('size' => '161x34', 'alt' => __('label_rugby_goto_table'))) ?>
        </a>
    </div>
</div>
<?php endif ?>
<div style="clear: both;"></div>
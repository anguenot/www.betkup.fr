<div class="" style="margin-left: 8px;">
    <?php include_component('room', 'header', array('data'=> $dataRoom)) ?>
</div>
<?php include_component('room', 'tabsHome', array(
                                                 'numTab'  => '1', 'id' => '1',
                                                 'tabs'    => $dataTabs
                                            )) ?>
<?php include_component('interface', 'areaOneBegin') ?>
<div style="height: 30px;"></div>
<div
    style="margin-left: 15px; width: 682px; height: 156px; background: url(<?php echo (isset($roomUI) && isset($roomUI['room_welcome_background'])) ? $roomUI['room_welcome_background'] : '/image/default/room/welcome.png' ?> ) center no-repeat;">
    <table
        style="width: 670px; border-collapse: collapse; border-spacing: 0px;">
        <tr>
            <td width="120" style="vertical-align: top; padding-top: 5px; text-indent: 20px; font-family: Verdana; font-size: 12px; color: #FFFFFF;">
                <?php echo __('text_room_home_welcome')?>
            </td>
            <td style="vertical-align: top; padding-top: 30px; font: 12px Verdana, sans-serif; color: #6A6A69;">
                <?php if (isset($roomUI) && isset($roomUI['text_room_welcome_text']) && $roomUI['text_room_welcome_text'] != '') : ?>
                <?php echo __($roomUI['text_room_welcome_text'], array(
                                                                      '%br%'     => '<br />',
                                                                      '%b%'      => '<b>',
                                                                      '%/b%'     => '</b>',
                                                                      '%author%' => $dataRoom['author_nickname'],
                                                                      '%name%'   => $dataRoom['name']
                                                                 )) ?>
                <?php else : ?>
                <?php echo __('text_room_home_welcome_description', array(
                                                                         '%br%'     => '<br />',
                                                                         '%b%'      => '<b>',
                                                                         '%/b%'     => '</b>',
                                                                         '%author%' => $dataRoom['author_nickname'],
                                                                         '%name%'   => $dataRoom['name']
                                                                    ))?>

                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>
<?php if (isset($roomUI) && isset($roomUI['path-bonus-box'])) : ?>
<div id="room-bonus-box" style="background: url('<?php echo $roomUI['path-bonus-box']?>') center no-repeat;
    <?php echo isset($roomUI['path-bonus-box-width']) ? 'width: '.$roomUI['path-bonus-box-width'].'px;' : '' ?>
    <?php echo isset($roomUI['path-bonus-box-height']) ? 'height: '.$roomUI['path-bonus-box-height'].'px;' : '' ?>
    <?php echo isset($roomUI['path-bonus-box-margin']) ? 'margin: '.$roomUI['path-bonus-box-margin'] : '' ?>">

    <div id="room-bonus-box-scotch" style="background: url('<?php echo (isset($roomUI['path-bonus-box-scotch'])) ? $roomUI['path-bonus-box-scotch'] : ''?>') center no-repeat;"></div>
    <div id="room-bonus-box-icon-top">
        <?php echo (isset($roomUI['path-bonus-box-icon-top'])) ? image_tag($roomUI['path-bonus-box-icon-top'], array('size' => '33x25')) : ""?>
    </div>
    <div id="room-bonus-box-amount">
        <?php echo (isset($roomUI['path-bonus-amount'])) ? image_tag($roomUI['path-bonus-amount'], array('size' => '74x68')) : ""?>
    </div>

    <?php if(!isset($roomUI['path-bonus-no-text']) || (isset($roomUI['path-bonus-no-text']) && $roomUI['path-bonus-no-text'] != 1)) : ?>
    <h2>Offre Exclusive !</h2>
    <p class="text-bonnus">
        <?php echo (isset($roomUI['text_room_bonus_text'])) ? __($roomUI['text_room_bonus_text'], array(
                                                                                                       '%br%'    => '<br />',
                                                                                                       '%span%'  => '<span style="color: #DB291A;"><b>',
                                                                                                       '%/span%' => '</b></span>'
                                                                                                  )) : '' ?>
    </p>
    <?php endif; ?>
    <a class="more-infos <?php echo isset($roomUI['path-bonus-box-more-infos-link-class']) ? $roomUI['path-bonus-box-more-infos-link-class'] : '' ?>" href="#room-home-more-infos">
        <?php echo __('link_footer_know_more')?>
    </a>
</div>
<?php endif; ?>
<div style="width: 100%; height: 10px;">&nbsp;</div>
<div style="">

</div>
<div style="width: 100%; height: 50px;">&nbsp;</div>
<?php include_component('room', 'kupsHomeFront', array(
                                                      'titre'    => __('label_home_kups_front'),
                                                      'roomUuid' => $dataRoom['uuid'],
                                                      'kupsData' => $filteredKupsData,
                                                      'roomUI'   => $roomUI
                                                 )) ?>

<div style="margin-left: -30px;">
    <div class="header-howto" style="border: none;<?php echo (isset($roomUI) && isset($roomUI['path-img-title-kup'])) ? "background: transparent url('" . $roomUI['path-img-title-kup'] . "') left no-repeat;" : "background: transparent url('/image/default/room/header_question.png') left no-repeat;"; ?>">
        <?php echo __('text_room_view_howto')?>
    </div>
</div>
<div style="width: 100%; height: 50px;">&nbsp;</div>
<div id="room-how-to">
    <div id="room-how-to-contener">
        <div id="room-howto-left">
            <div class="room-howto-number number-1">1</div>
            <h2>
                <?php echo __('text_room_home_create_account')?>
            </h2>
            <ul>
                <li><?php echo __('text_room_home_clicks')?></li>
                <li><?php echo __('text_room_home_register_free')?></li>
            </ul>
        </div>
        <div class="checked-ticker ticker-1"></div>
        <div id="room-howto-center">
            <div class="room-howto-number number-2">2</div>
            <h2>
                <?php echo __('text_room_home_join_room')?>
            </h2>
            <ul>
                <li><?php echo __('text_room_home_public_room_clic')?></li>
                <li><?php echo __('text_room_home_private_room_clic')?></li>
            </ul>
        </div>
        <div class="checked-ticker ticker-2"></div>
        <div id="room-howto-right">
            <div class="room-howto-number number-3">3</div>
            <h2>
                <?php echo __('text_room_home_participate_kups')?>
            </h2>
            <ul>
                <li><?php echo __('text_room_home_predictions_kups')?></li>
                <li><?php echo __('text_room_home_gambling_kups')?></li>
                <li><?php echo __('text_room_home_free_kups')?></li>
            </ul>
        </div>
    </div>
    <div style="width: 100%; height: 20px;">&nbsp;</div>

    <div id="pictures-list">
        <ul>
            <li id="picture-1"><?php echo image_tag('/image/default/room/room_home_picture_1.png', array('size' => '188x148'))?>
            </li>
            <li id="picture-2"><?php echo image_tag('/image/default/room/room_home_picture_2.png', array('size' => '194x148'))?>
            </li>
            <li id="picture-3"><?php echo image_tag('/image/default/room/room_home_picture_3.png', array('size' => '169x171'))?>
            </li>
        </ul>
    </div>
</div>
<div style="width: 100%; height: 50px;">&nbsp;</div>
<div id="room-home-buttons">
    <a href="<?php echo $joinUrl?>"> <?php echo image_tag('/image/' . $sf_user->getCulture() . '/room/button_join_room.png', array('size' => '170x68'))?>
    </a>
</div>
<div style="width: 100%; height: 50px;">&nbsp;</div>
<div id="room-home-more-infos">
    <?php if (isset($roomUI) && isset($roomUI['more-infos-answer'])) : ?>
    <table>
        <tbody>
        <tr>
            <td class="image image-anchor"></td>
            <td class="text"><?php echo __('text_room_home_more_infos')?></td>
        </tr>
        <tr id="more-info-answer" class="answer">
            <td colspan="2"><?php echo __($roomUI['more-infos-answer'], array('%br%' => '<br />'))?>
            </td>
        </tr>
        </tbody>
    </table>
    <?php endif;?>
</div>
<div style="width: 100%; height: 50px;">&nbsp;</div>
<?php include_component('interface', 'areaOneEnd') ?>
<script type="text/javascript">
    $(function () {
        var handleAnswer = function (obj, question) {
            if (obj.hasClass('open')) {
                question.find('.answer').hide();
                obj.css('background', 'url(/image/default/faq/interface/btn_plus.png) center no-repeat');
                obj.removeClass('open');
            } else {
                question.find('.answer').show();
                obj.css('background', 'url(/image/default/faq/interface/btn_minus.png) center no-repeat');
                obj.addClass('open');
            }
        };
        $('.more-infos').click(function () {
            var question = $('.image-anchor').parent().parent().parent().parent();
            handleAnswer($('.image-anchor'), question);
        });
        $('.image', $('#room-home-more-infos')).click(function () {
            var question = $(this).parent().parent().parent().parent();

            handleAnswer($(this), question);
            return false;
        });
        $("#selectRoomViewTypeKups").selectmenu({style:'dropdown', width:140, menuWidth:140});
        $('div.rightroom').css('margin-left', '0px').css('position', 'inherit');
    });
</script>
<?php if ($sf_request->getAttribute('roomUI', "")) {
    $roomUI = $sf_request->getAttribute('roomUI', "");
} ?>
<?php if (isset($roomUI)) { ?>
<?php use_stylesheet('roomPerso.css') ?>
<script type="text/javascript">
        <?php if ($roomUI['isBgPerso'] == '1') { ?>
    $("body").css("background", "url('<?php echo $roomUI['body-bg-img']; ?>') center top <?php echo $roomUI['body-bg-color']; ?>");
        <?php } ?>
        <?php if ($roomUI['isHeaderPerso'] == '1') { ?>
    $(".logo_betkup").removeClass('logo_betkup').addClass('logo_betkup_hosted');
    $(".logo_betkup_hosted").html("<a title='Home page' href='/'><img  border='0'  src='<?php echo $roomUI['header-hosted-logo']; ?>' alt='Home page'></a>");
    $('.mainHeader').after('<div class="header_logo"><?php echo image_tag($roomUI['header-room-logo'], array('size' => (isset($roomUI['header-room-logo-size'])) ? $roomUI['header-room-logo-size'] : '439x90'))?></div>');
        <?php } ?>
    $(function () {
        $('#badge').hide();
        <?php if ($roomUI['isHeaderPerso'] == '1') { ?>
            $('img[src="/images/moncompte/button_mybetkup.png"]').attr('src', '/images/moncompte/button_mybetkup_room_perso.png');
            $('.top_facebookjaime').hide();
            <?php } ?>
        <?php if ($roomUI['isPicBottomLeft'] == '1') { ?>
            $('.mainFooter').before('<div style="left:0%; top:55%; position: absolute;"><?php echo image_tag($roomUI['body-bg-img-bottom-left'])?></div>');
            <?php } ?>
        <?php if ($roomUI['isPicBottomRight'] == '1') { ?>
            $('.container').append('<div style="position: absolute; bottom:0; right:0;"><?php echo image_tag($roomUI['body-bg-img-bottom-right'])?></div>');
            <?php } ?>
        <?php if ($roomUI['isRoomNameColorPerso'] == '1') { ?>
            $('.nomRoom').css('color', '<?php echo $roomUI['header-author-font-color']; ?>');
            <?php }  ?>
    });
</script>
<?php } ?>
<div class="moncompte">
    <?php include_component('account', 'navigation', array()) ?>
    <div class="room">
        <table id="room_table" style="margin-top: -2px;">
            <tr>
                <td style="vertical-align: top; width: 760px;">
                    <div class="view" style="margin-top: 4px;">
                        <div class="" style="margin-left: 10px;">
                            <?php include_component('room', 'header', array('data'=> $dataRoom)) ?>
                        </div>
                        <?php include_component('room', 'tabs', array(
                                                                     'numTab'  => '1', 'id' => '1',
                                                                     'tabs'    => $dataTabs,
                                                                     'tab'     => $tab
                                                                )) ?>
                        <?php include_component('interface', 'areaOneBegin', array('displayTop' => false)) ?>
                        <div style="height: 25px;"></div>
                        <form name="editRoom" action="" id="editRoom" method="post" ENCTYPE="multipart/form-data">
                            <div style="margin: 0px; padding: 0px; margin-top: 10px;">

                                <?php include_component('interface', 'widgetDownload', array(
                                                                                            'bloc'            => 'information',
                                                                                            'largeur1'        => '220',
                                                                                            'largeur2'        => '220',
                                                                                            'width3'          => '230',
                                                                                            'widthGadget'     => '231',
                                                                                            'heightGadget'    => '20',
                                                                                            'marginLeftError' => '400',
                                                                                            'messageError'    => __('label_form_create_room_avatar_error'),
                                                                                            'blocType'        => 'text',
                                                                                            'blocIcone'       => '',
                                                                                            'blocName'        => 'roomPicture',
                                                                                            'blocLegende'     => __('label_form_create_room_avatar_field'),
                                                                                            'blocValue'       => $information['roomPicture'],
                                                                                            'blocHelp'        => __('label_form_create_room_avatar_legend'),
                                                                                            'displayHelp'     => false,
                                                                                            'formId'          => 'editRoom'
                                                                                       )) ?>
                                <?php include_component('interface', 'radio', array(
                                                                                   'bloc'            => 'information',
                                                                                   'largeur1'        => '220',
                                                                                   'largeur2'        => '256',
                                                                                   'width2'          => '280',
                                                                                   'width3'          => '230',
                                                                                   'marginLeftError' => '400',
                                                                                   'messageError'    => __('label_form_create_room_access_error'),
                                                                                   'blocName'        => 'roomAccess',
                                                                                   'blocLegende'     => __('label_form_create_room_access_field'),
                                                                                   'blocValue'       => (isset($information ['roomAccess']) ? $information ['roomAccess'] : ''),
                                                                                   'blocChoices'     => $roomAccessPolicies,
                                                                                   'blocHelp'        => __('label_form_create_room_access_legend'),
                                                                                   'displayHelp'     => true,
                                                                                   'blocActions'     => array(
                                                                                       'div_roomPassword',
                                                                                       'div_roomPassword',
                                                                                       '', ''
                                                                                   )
                                                                              )) ?>
                                <?php include_component('interface', 'simpleWidget', array(
                                                                                          'bloc'            => 'information',
                                                                                          'largeur1'        => '220',
                                                                                          'largeur2'        => '220',
                                                                                          'width3'          => '230',
                                                                                          'widthGadget'     => '220',
                                                                                          'marginLeftError' => '400',
                                                                                          'messageError'    => __('label_form_create_room_password_error'),
                                                                                          'blocType'        => 'password',
                                                                                          'blocIcone'       => '',
                                                                                          'blocName'        => 'roomPassword',
                                                                                          'blocLegende'     => __('label_form_create_room_password_field'),
                                                                                          'blocValue'       => (isset($information ['roomPassword']) ? $information ['roomPassword'] : ''),
                                                                                          'blocHelp'        => '',
                                                                                          'displayHelp'     => true,
                                                                                          'display'         => ($information['roomAccess'] == sfConfig::get('mod_room_privacy_private') || $information['roomAccess'] == sfConfig::get('mod_room_privacy_private_gambling_fr') ? true : false),
                                                                                     )) ?>

                                <?php include_component('interface', 'widgetTextarea', array(
                                                                                            'bloc'            => 'information',
                                                                                            'largeur1'        => '220',
                                                                                            'largeur2'        => '220',
                                                                                            'width1'          => '220',
                                                                                            'width2'          => '252',
                                                                                            'width3'          => '230',
                                                                                            'widthGadget'     => '220',
                                                                                            'heightGadget'    => '100',
                                                                                            'marginLeftError' => '400',
                                                                                            'messageError'    => '',
                                                                                            'blocIcone'       => '',
                                                                                            'blocName'        => 'roomDescription',
                                                                                            'blocLegende'     => __('label_form_create_room_description_field'),
                                                                                            'blocValue'       => (isset($information ['roomDescription']) ? $information ['roomDescription'] : ''),
                                                                                            'blocHelp'        => __('label_form_create_room_description_help'),
                                                                                            'displayHelp'     => true,
                                                                                       )) ?>
                                <?php include_component('interface', 'widgetCheckbox', array(
                                                                                            'bloc'            => 'information',
                                                                                            'largeur1'        => '220',
                                                                                            'largeur2'        => '256',
                                                                                            'width1'          => '220',
                                                                                            'width2'          => '252',
                                                                                            'marginLeftError' => '400',
                                                                                            'messageError'    => '',
                                                                                            'blocName'        => 'roomType',
                                                                                            'blocLegende'     => __('label_form_create_room_types_field'),
                                                                                            'blocValue'       => (isset($information ['roomType']) ? $information ['roomType'] : array()),
                                                                                            'blocChoices'     => $roomTypes,
                                                                                            'blocHelp'        => __('label_form_create_room_types_help'),
                                                                                            'displayHelp'     => true,
                                                                                       )) ?>
                                <div style="border: 0px solid red; margin: 0px; padding: 0px; margin-top: 10px;">
                                    <?php include_component('interface', 'simpleWidget', array(
                                                                                              'bloc'            => 'information',
                                                                                              'largeur1'        => '220',
                                                                                              'largeur2'        => '220',
                                                                                              'width1'          => '220',
                                                                                              'width2'          => '252',
                                                                                              'width3'          => '230',
                                                                                              'widthGadget'     => '220',
                                                                                              'marginLeftError' => '400',
                                                                                              'messageError'    => '',
                                                                                              'blocType'        => 'text',
                                                                                              'blocIcone'       => '',
                                                                                              'blocName'        => 'roomTags',
                                                                                              'blocLegende'     => __('label_form_create_room_tags_field'),
                                                                                              'blocValue'       => (isset($information ['roomTags']) ? $information ['roomTags'] : ''),
                                                                                              'blocHelp'        => __('label_form_create_room_tags_help'),
                                                                                              'displayHelp'     => true,
                                                                                         )) ?>
                                </div>
                                <div style="height: 20px;"></div>
                                <div align="center">
                                    <input type="image" title="" src="<?php echo '/image/' . $sf_user->getCulture() . '/kup/button_prediction_save.png' ?>"/>
                                </div>
                            </div>
                        </form>
                        <div style="height: 50px;"></div>
                        <?php include_component('interface', 'areaOneEnd') ?>
                    </div>
                </td>
                <td style="vertical-align: top; width: 220px;">
                    <div style="padding-left: 5px; padding-top: 7px;">
                        <?php if (isset($roomUI)): ?>
                        <?php include_component('room', 'right', array(
                                                                      'dataRoom' => $dataRoom,
                                                                      'roomUI'   => $roomUI
                                                                 )) ?>
                        <?php else: ?>
                        <?php include_component('room', 'right', array('dataRoom'=> $dataRoom)) ?>
                        <?php endif ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#roomDescription').charCounter({
            'maxlength':130,
            'counterId':'room-description-counter',
            'counterText':'<?php echo __('text_char_counter')?>'
        });
    });
</script>
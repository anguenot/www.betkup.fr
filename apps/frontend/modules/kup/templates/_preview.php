<div class="kupPreview" id="bloc_<?php echo $kup["uuid"] ?>">
    <?php if ($kup['display'] == $right) : ?>
    <div class="diplayRight"></div>
    <?php endif; ?>
    <form action="" name="form_room_manage_kups_<?php echo $kup["uuid"] ?>" id="form_room_manage_kups_<?php echo $kup["uuid"] ?>" method="post">
        <input type="hidden" name="kup" id="room_manage_kup_<?php echo $kup["uuid"] ?>" value="<?php echo $kup["uuid"] ?>"/>

        <div class="closed" id="part1_<?php echo $kup["uuid"] ?>">
            <div class="bouton_plus" id="bouton_plus_<?php echo $kup["uuid"] ?>"></div>
            <div class="titre_encart" title="<?php echo (isset($kup["name"]) ? strtoupper(__($kup["name"])) : __('text_not_defined')) ?>">
                <?php echo image_tag('/images/room/module/accordion/coupe.png', array(
                                                                                     'size'  => '12x14',
                                                                                     'style' => 'float: left;'
                                                                                )); ?>
                <?php echo (isset($kup["name"]) ? Util::coupe(strtoupper(__($kup["name"])), 19, '..') : __('text_not_defined')) ?>
            </div>
            <div class="sstitre_encart"><?php echo image_tag('/kup/default/' . $kup["ui"]["picto_mini"], array(
                                                                                                              'size'  => '20x20',
                                                                                                              'style' => 'vertical-align:middle; float:left;'
                                                                                                         ))?><?php echo (isset($kup["category"]) ? $kup["category"] : __('text_not_defined')) ?></div>

            <div class="plus plus_<?php echo $kup["uuid"] ?>">
                <?php echo image_tag('/image/default/room/kups_plus.png', array(
                                                                               'alt'  => __('label_room_kups_add'),
                                                                               'size' => '30x57',
                                                                               'style'=> 'cursor: pointer',
                                                                               'class'=> 'bouton_add_kup_in_room_' . $kup["uuid"]
                                                                          )) ?>
            </div>
            <div class="moins moins_<?php echo $kup["uuid"] ?>">
                <?php echo image_tag('/image/default/room/kups_del.png', array(
                                                                              'alt'  => __('label_room_kups_del'),
                                                                              'size' => '18x18',
                                                                              'style'=> 'cursor: pointer',
                                                                              'class'=> 'bouton_del_kup_in_room_' . $kup["uuid"]
                                                                         )) ?>
            </div>
        </div>
        <div class="anchor"></div>
        <div id="part2_<?php echo $kup["uuid"] ?>">
            <div class="bouton_moins" id="bouton_moins_<?php echo $kup["uuid"] ?>"></div>
            <div class="titre_encart" title="<?php echo (isset($kup["name"]) ? strtoupper(__($kup["name"])) : __('text_not_defined')) ?>">
                <?php echo image_tag('/images/room/module/accordion/coupe.png', array(
                                                                                     'size'  => '12x14',
                                                                                     'style' => 'float: left;'
                                                                                )); ?>
                <?php echo (isset($kup["name"]) ? Util::coupe(strtoupper(__($kup["name"])), 19, '..') : __('text_not_defined')) ?>
            </div>
            <div class="sstitre_encart"><?php echo image_tag('/kup/default/' . $kup["ui"]["picto_mini"], array(
                                                                                                              'size'  => '20x20',
                                                                                                              'style' => 'vertical-align:middle; float:left;'
                                                                                                         ))?><?php echo (isset($kup["category"]) ? $kup["category"] : __('text_not_defined')) ?></div>

            <div class="plus plus_<?php echo $kup["uuid"] ?>">
                <?php echo image_tag('/image/default/room/kups_plus.png', array(
                                                                               'alt'  => __('label_room_kups_add'),
                                                                               'size' => '30x57',
                                                                               'style'=> 'cursor: pointer',
                                                                               'class'=> 'bouton_add_kup_in_room_' . $kup["uuid"]
                                                                          )) ?>
            </div>

            <div class="moins moins_<?php echo $kup["uuid"] ?>">
                <?php echo image_tag('/image/default/room/kups_del.png', array(
                                                                              'alt'  => __('label_room_kups_del'),
                                                                              'size' => '18x18',
                                                                              'style'=> 'cursor: pointer',
                                                                              'class'=> 'bouton_del_kup_in_room_' . $kup["uuid"]
                                                                         )) ?>
            </div>

            <div class="delimiteur"></div>
            <?php if (isset($kup['ui']['vignette_edition_kup'])): ?>
            <?php echo image_tag($kup['ui']['vignette_edition_kup'], array(
                                                                          'size'  => '105x109',
                                                                          'class' => 'bloc_part2_avatar'
                                                                     )); ?>
            <?php endif ?>
            <div class="bloc_part2_texte">
                <?php echo (isset($kup["description"]) ? __($kup["description"]) : '') ?>
            </div>
            <div class="bloc_part2_time">
                <?php echo image_tag('/images/room/module/accordion/horloge.png', array('size' => '14x14')); ?> <?php echo __('text_preview_time_spend') ?>
                : <?php echo Util::nombreJoursEntreDeuxDates($kup["startDate"], $kup["endDate"], ' jours'); ?>
            </div>
            <?php if (isset($kup["events"])) : ?>
            <div class="bloc_part2_event">
                <?php echo image_tag('/images/room/module/accordion/suivant.png', array('size' => '14x14')); ?><?php echo (isset($kup["events"]) ? $kup["events"] : __('text_not_defined')); ?>
            </div>
            <?php endif; ?>
            <div class="delimiteur2"></div>

            <div class="bloc_part2_chrono" style="width: 272px; height: 36px; background: url('<?php echo '/image/' . $sf_user->getCulture() . '/room/kup_chrono.png' ?>');">
                <div class="bloc_part2_chrono_day"><?php echo util::displayDateFormated($kup["startDate"]) ?></div>
                <div class="bloc_part2_chrono_hour"><?php echo util::displayTimeFromTimestamp($kup["startDate"]) ?></div>
            </div>
            <div id="display_preview_form_<?php echo $kup["uuid"] ?>">
                <div class="delimiteur3"></div>
                <div class="bloc_part2_select1">
                    <div id="hideRepartitionBox_<?php echo $kup["uuid"] ?>" style="display:none; position:absolute; z-index: 1020; background-color: #D9D9D9; opacity: 0.6;"></div>
                    <table style="border-collapse:collapse; border-spacing: 0;">
                        <tr height="40">
                            <td width="140" height="40" style="text-align: left; vertical-align: middle;">
                                <div>
                                    <span class="bloc_part2_select_legende"><?php echo __('text_preview_stake'); ?></span>
                                </div>
                            </td>
                            <td align="left" valign="middle" width="150">
                                <?php if ($kup['display'] == $right) : ?>
                                <span><?php echo $kup["stake"]; ?> €</span>
                                <?php else : ?>
                                <select name="stake" id="stake_<?php echo $kup["uuid"] ?>" class="formInputSelect">
                                    <?php foreach ($availableStakes as $key => $value): ?>
                                    <?php if ($kup["stake"] == $key): ?>
                                        <option value="<?php echo $key ?>" selected="selected"><?php echo __($value) ?></option>
                                        <?php else : ?>
                                        <option value="<?php echo $key ?>"><?php echo __($value) ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="140" height="40" style="text-align: left; vertical-align: middle;">
                                <div>
                                    <span class="bloc_part2_select_legende"><?php echo __('text_prize_distibution_pool'); ?></span>
                                </div>
                            </td>
                            <td align="left" valign="middle" width="150" id="repartition_td_<?php echo $kup["uuid"] ?>">
                                <?php if ($kup['display'] == $right) : ?>
                                <span><?php echo str_replace(' (', '<br />(', $availableJackpotRepartitions[$kup["repartition"]]); ?></span>
                                <?php else: ?>
                                <select name="repartition" id="repartition_<?php echo $kup["uuid"] ?>" class="formInputSelect">
                                    <?php foreach ($availableJackpotRepartitions as $key => $value): ?>
                                    <?php if ($kup["repartition"] == $key): ?>
                                        <option value="<?php echo $key ?>" selected="selected"><?php echo $value ?></option>
                                        <?php else : ?>
                                        <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                                <?php endif;?>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php if ($kup['display'] != $right) : ?>
                <div class="delimiteur4"></div>
                <div class="bloc_part2_button">
                    <?php echo image_tag('/image/' . $sf_user->getCulture() . '/room/kups_button.png', array(
                                                                                                            'alt'  => __('label_room_manage_kups_button'),
                                                                                                            'size' => '163x34',
                                                                                                            'id'   => 'bouton_confirm_kup_in_room_' . $kup["uuid"]
                                                                                                       )) ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        var textFormatting = function (text) {
            var newText = new Array();
            newText = text.split('(');
            if (newText.length > 1) {
                return '<span class="ui-selectmenu-item-header">' + newText[0] + '</span><span class="ui-selectmenu-item-content">(' + newText[1] + '</span>';
            } else {
                return text;
            }
        };

        var disableSelect = function () {
            var width, height;

            width = 290;
            height = 40;

            $("#hideRepartitionBox_<?php echo $kup["uuid"] ?>").width(width).height(height);
            $("#hideRepartitionBox_<?php echo $kup["uuid"] ?>").css('top', height);
            $("#hideRepartitionBox_<?php echo $kup["uuid"] ?>").show();
        };

        var enableSelect = function () {
            $("#hideRepartitionBox_<?php echo $kup["uuid"] ?>").hide();
        };

        $('#stake_<?php echo $kup["uuid"] ?>').selectmenu({
            style:'dropdown',
            width:150,
            menuWidth:240
        });

        $('#repartition_<?php echo $kup["uuid"] ?>').selectmenu({
            style:'dropdown',
            format:textFormatting,
            width:150,
            menuWidth:240});

        if ($('#stake_<?php echo $kup["uuid"] ?>').val() == 0) {
            disableSelect();
        }

        $('#stake_<?php echo $kup["uuid"] ?>').change(function () {
            if ($(this).val() == '0') {
                setDefaultRepartitionValue();
                disableSelect();
            } else {
                enableSelect();
            }
        });

        var setDefaultRepartitionValue = function () {
            $("#repartition_<?php echo $kup["uuid"] ?>").val(3);
            var html = $("#repartition_<?php echo $kup["uuid"] ?>").find("option[value=3]").html();

            $("#repartition_td_<?php echo $kup["uuid"] ?>").find("a").attr('aria-selected', 'false');
            $("#repartition_td_<?php echo $kup["uuid"] ?>").find('li').removeClass('ui-selectmenu-item-selected');
            $("#repartition_td_<?php echo $kup["uuid"] ?>").find("a:contains('3')").attr('aria-selected', 'true');
            $("#repartition_td_<?php echo $kup["uuid"] ?>").find("a:contains('3')").parent().addClass('ui-selectmenu-item-selected');
            $("#repartition_td_<?php echo $kup["uuid"] ?>").find('.ui-selectmenu-status').html(textFormatting(html));
        };

    <?php if ($kup['display'] == $left) : ?>
            $('.plus_<?php echo $kup["uuid"] ?>').show();
            $('.moins_<?php echo $kup["uuid"] ?>').hide();

            $('#part2_<?php echo $kup["uuid"] ?>').removeClass('bloc_open_big');
            $('#part2_<?php echo $kup["uuid"] ?>').addClass('encart_ouvert_petit');
            $('#display_preview_form_<?php echo $kup["uuid"] ?>').hide();
            <?php elseif ($kup['display'] == $right) : ?>
            $('.moins_<?php echo $kup["uuid"] ?>').show();
            $('.plus_<?php echo $kup["uuid"] ?>').hide();

            $('#part2_<?php echo $kup["uuid"] ?>').removeClass('encart_ouvert_petit');
            $('#part2_<?php echo $kup["uuid"] ?>').addClass('bloc_open_big2');

            $('#display_preview_form_<?php echo $kup["uuid"] ?>').show();
            <?php endif; ?>
    });

    $("#part2_<?php echo $kup["uuid"] ?>").hide();

    $('#bouton_plus_<?php echo $kup["uuid"] ?>').click(function () {
        $("#part2_<?php echo $kup["uuid"] ?>").show();
        $("#part1_<?php echo $kup["uuid"] ?>").hide();

    });
    $('#bouton_moins_<?php echo $kup["uuid"] ?>').click(function () {
        $("#part1_<?php echo $kup["uuid"] ?>").show();
        $("#part2_<?php echo $kup["uuid"] ?>").hide();

    });
    $(function () {
        $(".bouton_add_kup_in_room_<?php echo $kup["uuid"] ?>").click(function () {

            var isSubscribe = $('#right_manage_bloc').find('.kupPreview:first').find('.diplayRight:first').attr('class');

            var rightIsEmpty = $('#right_manage_bloc').find('.anchor').attr('class');

            if (isSubscribe != 'diplayRight' && rightIsEmpty != undefined) {
                alert("<?php echo __('text_confirm_add_edit_kup'); ?>.");
            } else {

                $('#right_manage_bloc').prepend($('#bloc_<?php echo $kup["uuid"] ?>'));
                $("#part2_<?php echo $kup["uuid"] ?>").show();
                $("#part1_<?php echo $kup["uuid"] ?>").hide();

                $('.moins_<?php echo $kup["uuid"] ?>').show();
                $('.plus_<?php echo $kup["uuid"] ?>').hide();

                $('#part2_<?php echo $kup["uuid"] ?>').removeClass('encart_ouvert_petit');
                $('#part2_<?php echo $kup["uuid"] ?>').addClass('bloc_open_big');

                $('#display_preview_form_<?php echo $kup["uuid"] ?>').show();
            }
        });
    });
    $(function () {

        $(".bouton_del_kup_in_room_<?php echo $kup["uuid"] ?>").click(function () {

            var isSubscribe = $(this).parent().parent().parent().parent().find('.diplayRight:first').attr('class');

            if (isSubscribe == 'diplayRight' && confirm("<?php echo __('text_confirm_delete_edit_kup'); ?>")) {

                $.ajax({
                    type:'get',
                    dataType:'html',
                    success:function (data, textStatus) {
                        $('#room_kups_manage').html(data);
                        var flash = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('/images/interface/ticker_success.png', array(
                                                                                                                                                           'size'  => '15x15',
                                                                                                                                                           'style' => 'padding-right:10px;'
                                                                                                                                                      )); ?><?php echo __('flash_notice_room_kup_removed_success'); ?>.</div>';
                        showNotification(flash, "success", function () {
                        });
                    },
                    beforeSend:function (XMLHttpRequest) {
                        $('#room_kups_manage').loadingModal({show:true});
                    },
                    complete:function (XMLHttpRequest, textStatus) {
                        $('#room_kups_manage').loadingModal({show:false});
                    },
                    url:'<?php echo url_for(array(
                                                 'module' => 'room', 'action'=> 'editKups',
                                                 'uuid'   => $kup["room_uuid"], 'what'=> 'del'
                                            )) ?>/kup/' + $("#room_manage_kup_<?php echo $kup["uuid"] ?>").val()
                });

            } else if (isSubscribe != 'diplayRight') {

                $('#left_manage_bloc').prepend($('#bloc_<?php echo $kup["uuid"] ?>'));
                $("#part2_<?php echo $kup["uuid"] ?>").hide();
                $("#part1_<?php echo $kup["uuid"] ?>").show();

                $('.plus_<?php echo $kup["uuid"] ?>').show();
                $('.moins_<?php echo $kup["uuid"] ?>').hide();

                $('#part2_<?php echo $kup["uuid"] ?>').removeClass('bloc_open_big');
                $('#part2_<?php echo $kup["uuid"] ?>').addClass('encart_ouvert_petit');
                $('#display_preview_form_<?php echo $kup["uuid"] ?>').hide();
            }

        });

    });
    $(function () {
        $("#bouton_confirm_kup_in_room_<?php echo $kup["uuid"] ?>").click(function () {
            var dataSerialized = ($("#form_room_manage_kups_<?php echo $kup["uuid"] ?>").serialize());

            var regFormatUrl = new RegExp('[&=]', 'gi');

            $.ajax({
                type:'get',
                dataType:'html',
                success:function (data, textStatus) {

                    $('#room_kups_manage').html(data);
                    var flash = '<div style="vertical-align: middle; padding: 10px;"><?php echo image_tag('/images/interface/ticker_success.png', array(
                                                                                                                                                       'size'  => '15x15',
                                                                                                                                                       'style' => 'padding-right:10px;'
                                                                                                                                                  )); ?><?php echo __('flash_notice_room_kup_registered_success'); ?>.</div>';
                    showNotification(flash, "success", function () {
                    });
                },
                beforeSend:function (XMLHttpRequest) {
                    $('#room_kups_manage').loadingModal({show:true});

                },
                complete:function (XMLHttpRequest, textStatus) {
                    $('#room_kups_manage').loadingModal({show:false});
                },
                url:'<?php echo url_for(array(
                                             'module' => 'room', 'action'=> 'editKups',
                                             'uuid'   => $kup["room_uuid"], 'what'=> 'add'
                                        )) ?>/' + dataSerialized.replace(regFormatUrl, '/')
            });
        });
    });
</script>
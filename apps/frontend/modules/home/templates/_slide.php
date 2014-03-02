<div id="slidedeck_frame" class="skin-slidedeck">
<dl id="deck_1" class="slidedeck">
<dt>
    <?php echo __('home_slidedeck_slide_1_title')?>
</dt>
<dd>
    <ul class="slidesVertical">
        <li>
            <div style="position: relative;">
                <?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/img_welcome_betkup.png', array(
                                                                                                               'width' => '100%',
                                                                                                               'height'=> '300px',
                                                                                                               'alt'   => __('home_slidedeck_slide_1_img_how_work_1_alt_text')
                                                                                                          ))?>
                <a href="https://www.youtube.com/watch?v=4EV-6M1ylHI" title="Betkup, 1er site de paris sportifs communautaire." class="video-slide-welcome-betkup video-pop-up"></a>
                <a href="#" id="slide_how_work_1" class="slide_welcome_betkup_kup">
                    <?php echo __('home_slide_welcome_betkup_kup_text');?>
                </a>
                <a href="#" id="slide-welcome-bonus" class="slide-welcome-bonus"></a>
                <a href="#" id="slide_how_work_2" class="slide_welcome_betkup_room">
                    <?php echo __('home_slide_welcome_betkup_room_text');?>
                </a>
            </div>
        </li>
        <li>
            <div style="position: relative;">
                <?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/img_slide_kup.jpg', array(
                                                                                                               'width' => '100%',
                                                                                                               'height'=> '300px',
                                                                                                               'alt'   => __('home_slidedeck_slide_1_img_how_work_2_alt_text')
                                                                                                          ))?>
            </div>
        </li>
        <li>
            <div style="position: relative;">
                <?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/img_slide_room.jpg', array(
                                                                                                              'width' => '100%',
                                                                                                              'height'=> '300px',
                                                                                                              'alt'   => __('home_slidedeck_slide_1_img_how_work_2_alt_text')
                                                                                                         ))?>
            </div>
        </li>
    </ul>
    <a href="#previous" class="vertical-prev-next previous"><?php echo __('home_slidedeck_button_previous_text')?>
    </a>
    <a href="#next" class="vertical-prev-next next"><?php echo __('home_slidedeck_button_next_text')?>
    </a>
</dd>
<dt>
    <?php echo 'BONUS BETKUP !' ?>
</dt>
<dd>
    <ul class="slidesVertical">
        <!--
                <li>
                    <div style="position: relative;">
                        <?php echo link_to(image_tag('/image/' . $sf_user->getCulture() . '/carousel/promo_bonus_edf_2012.jpeg',
            array(
                 'width' => '100%', 'height'=> '100%',
                 'alt'   => 'BETKUP SOUTIENT L\' EQUIPE DE FRANCE'
            )), url_for(array(
                             'module'  => 'challenge',
                             'action'  => 'promos',
                             'uuid'    => 'promo_bonus_edf_2012'
                        ))) ?>
                    </div>
                </li>
                -->
        <li>
            <div style="position: relative;">
                <?php echo link_to(image_tag('/image/' . $sf_user->getCulture() . '/carousel/promo_bonus_l1_2012.png',
                array(
                     'width' => '100%', 'height'=> '100%',
                     'alt'   => 'BONUS REPRISE LIGUE 1'
                )), url_for(array(
                                 'module'  => 'challenge',
                                 'action'  => 'promos',
                                 'uuid'    => 'promos_bonus_l1_2012'
                            ), array('comming_from' => 'home')), array('target'=> '_blank')) ?>
            </div>
        </li>
    </ul>
    <a href="#previous" class="vertical-prev-next previous"><?php echo __('home_slidedeck_button_previous_text')?>
    </a>
    <a href="#next" class="vertical-prev-next next"><?php echo __('home_slidedeck_button_next_text')?>
    </a>
</dd>
<dt>
    <?php echo __('home_slidedeck_slide_3_title')?></dt>
<dd>
<div style="width: 440px; float: left;">
    <ul class="slidesVertical">
        <li><?php echo link_to(image_tag('/image/' . $sf_user->getCulture() . '/carousel/img_nba_m_m_2012.jpeg', array(
                                                                                                                  'width' => '100%',
                                                                                                                  'height'=> '100%'
                                                                                                             )), url_for(array(
                                                                                                                              'module'        => 'kup',
                                                                                                                              'action'        => 'view',
                                                                                                                              'uuid'          => '20129000'
                                                                                                                         ), array('comming_from' => 'home')), array('target'=> '_blank'))?>
        </li>
        <li><?php echo link_to(image_tag('/image/' . $sf_user->getCulture() . '/carousel/img_room_rdj_2012.jpeg', array(
                                                                                                                      'width' => '100%',
                                                                                                                      'height'=> '100%'
                                                                                                                 )), url_for(array(
                                                                                                                                  'module'        => 'room',
                                                                                                                                  'action'        => 'view',
                                                                                                                                  'uuid'          => '2335692'
                                                                                                                             ), array('comming_from' => 'home')), array('target'=> '_blank'))?>
        </li>
        <li><?php echo link_to(image_tag('/image/' . $sf_user->getCulture() . '/carousel/img_hcup_2012.jpg', array(
                                                                                                                       'width' => '100%',
                                                                                                                       'height'=> '100%'
                                                                                                                  )), url_for(array(
                                                                                                                                   'module'        => 'kup',
                                                                                                                                   'action'        => 'home',
                                                                                                                                   'selectedDatas' => array(
                                                                                                                                       'SPORTS_RUGBY',
                                                                                                                                       'STAKE_ALL',
                                                                                                                                       'status_IN_PROGRESS',
                                                                                                                                       'status_IN_COMMING',
                                                                                                                                       'SORTING_START_DATE'
                                                                                                                                   )
                                                                                                                              ), array('comming_from' => 'home')), array('target'=> '_blank'))?>
        </li>
        <li><?php echo link_to(image_tag('/image/' . $sf_user->getCulture() . '/carousel/img_kups_ldc_2012.jpeg', array(
                                                                                                                       'width' => '100%',
                                                                                                                       'height'=> '100%'
                                                                                                                  )), url_for(array(
                                                                                                                                   'module'        => 'kup',
                                                                                                                                   'action'        => 'home',
                                                                                                                                   'selectedDatas' => array(
                                                                                                                                       'SPORTS_SOCCER',
                                                                                                                                       'STAKE_ALL',
                                                                                                                                       'status_IN_PROGRESS',
                                                                                                                                       'status_IN_COMMING',
                                                                                                                                       'SORTING_START_DATE'
                                                                                                                                   )
                                                                                                                              ), array('comming_from' => 'home')), array('target'=> '_blank'))?>
        </li>
        <li><?php echo link_to(image_tag('/image/' . $sf_user->getCulture() . '/carousel/img_challenge_k8_europe_2012.jpeg', array(
                                                                                                                                  'width' => '100%',
                                                                                                                                  'height'=> '100%'
                                                                                                                             )), url_for(array(
                                                                                                                                              'module'  => 'room',
                                                                                                                                              'action'  => 'view',
                                                                                                                                              'uuid'    => '3921267'
                                                                                                                                         ), array('comming_from' => 'home')), array('target'=> '_blank'))?>
        </li>
    </ul>
    <a href="#previous" class="vertical-prev-next previous" style="left: 40%"><?php echo __('home_slidedeck_button_previous_text')?>
    </a>
    <a href="#next" class="vertical-prev-next next" style="left: 40%"><?php echo __('home_slidedeck_button_next_text')?>
    </a>
</div>
<div style="width: 130px; float: right; height: 100%">
    <table id="slide_3_list_vertical" style="height: 100%; border-spacing: 1px; border-collapse: collapse;">
        <tr>
            <td id="slide_3_move_prev" colspan="2" align="center" class="arrow_slide"><?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/picto/arrow_prev.png', array(
                                                                                                                                                                                       'size' => '21x19',
                                                                                                                                                                                       'alt'  => __('home_slidedeck_slide_3_picto_arrow_prev_alt_text')
                                                                                                                                                                                  ))?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/separator.png', array(
                                                                                                                                     'width' => '140px',
                                                                                                                                     'alt'   => __('home_slidedeck_slide_3_separator_alt_text')
                                                                                                                                ))?>
            </td>
        </tr>
        <tr id="row_list_0">
            <td class="picto_slide" align="center">
                <?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/picto/normal/picto_nba.png', array(
                                                                                                                        'value'  => 'picto_nba.png',
                                                                                                                        'alt'    => 'NBA Match par Match'
                                                                                                                   ))?>
            </td>
            <td class="text">
                <div id="slide_3_move_0">NBA Match par Match</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/separator.png', array(
                                                                                                                                     'width' => '140px',
                                                                                                                                     'alt'   => __('home_slidedeck_slide_3_separator_alt_text')
                                                                                                                                ))?>
            </td>
        </tr>
        <tr id="row_list_1">
            <td class="picto_slide" align="center">
                <?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/picto/normal/picto_rdj.png', array(
                                                                                                                       'value'  => 'picto_rdj.png',
                                                                                                                       'alt'    => 'Room Rue des joueurs'
                                                                                                                  ))?>
            </td>
            <td class="text">
                <div id="slide_3_move_1">Room Rue des joueurs</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/separator.png', array(
                                                                                                                                     'width' => '140px',
                                                                                                                                     'alt'   => __('home_slidedeck_slide_3_separator_alt_text')
                                                                                                                                ))?>
            </td>
        </tr>
        <tr id="row_list_2">
            <td class="picto_slide" align="center">
                <?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/picto/normal/picto_hcup.png', array(
                                                                                                                      'value'  => 'picto_hcup.png',
                                                                                                                      'alt'    => 'Kups H-CUP'
                                                                                                                 ))?>
            </td>
            <td class="text">
                <div id="slide_3_move_2">Kups H-CUP</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/separator.png', array(
                                                                                                                                     'width' => '140px',
                                                                                                                                     'alt'   => __('home_slidedeck_slide_3_separator_alt_text')
                                                                                                                                ))?>
            </td>
        </tr>
        <tr id="row_list_3">
            <td class="picto_slide" align="center">
                <?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/picto/normal/picto_cl.png', array(
                                                                                                                      'value'  => 'picto_cl.png',
                                                                                                                      'alt'    => 'Kups ligue des champions'
                                                                                                                 ))?>
            </td>
            <td class="text">
                <div id="slide_3_move_3">Kups Ligue des Champions</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/separator.png', array(
                                                                                                                                     'width' => '140px',
                                                                                                                                     'alt'   => __('home_slidedeck_slide_3_separator_alt_text')
                                                                                                                                ))?>
            </td>
        </tr>
        <tr id="row_list_4">
            <td class="picto_slide" align="center">
                <?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/picto/normal/picto_k8.png', array(
                                                                                                                      'value'  => 'picto_k8.png',
                                                                                                                      'alt'    => 'Challenge K8 Europe'
                                                                                                                 ))?>
            </td>
            <td class="text">
                <div id="slide_3_move_4">Challenge K8 Europe</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/separator.png', array(
                                                                                                                                     'width' => '140px',
                                                                                                                                     'alt'   => __('home_slidedeck_slide_3_separator_alt_text')
                                                                                                                                ))?>
            </td>
        </tr>
        <tr>
            <td id="slide_3_move_next" colspan="2" align="center" class="arrow_slide"><?php echo image_tag('/image/' . $sf_user->getCulture() . '/carousel/picto/arrow_next.png', array(
                                                                                                                                                                                       'size' => '21x19',
                                                                                                                                                                                       'alt'  => __('home_slidedeck_slide_3_picto_arrow_next_alt_text')
                                                                                                                                                                                  ))?>
            </td>
        </tr>
    </table>
</div>
</dd>
</dl>
</div>
<script type="text/javascript">
    $('.skin-slidedeck dl.slidedeck').slidedeck({
        speed:500,
        transition:'swing',
        cycle:true,
        autoPlay:true,
        autoPlayInterval:5000,
        scroll:'stop',
        start:2
    }).

            loaded(function () {
                $('.skin-slidedeck .slide .verticalSlideNav').each(function () {
                    $(this).parents('dd.slide').prevAll('dt.spine:first').append(this);
                });

                $('.skin-slidedeck .spine .verticalSlideNav').each(function () {
                    var liHeight = $(this).find('li').height();
                    var ulOffset = ( 62 + ( ($(this).find('li').length - 1) * liHeight ) ) + 'px';
                    $(this).css({
                        left:ulOffset
                    });
                });
            }).

            vertical({
                before:function (deck) {
                    if (deck.current == 0) {
                        $(deck.navChildren.context).find('a.vertical-prev-next.previous').hide();
                    } else {
                        $(deck.navChildren.context).find('a.vertical-prev-next.previous')[0].style.display = "";
                    }
                    if (deck.current == (deck.slides.length - 1)) {
                        $(deck.navChildren.context).find('a.vertical-prev-next.next').hide();
                    } else {
                        $(deck.navChildren.context).find('a.vertical-prev-next.next')[0].style.display = "";
                    }
                },
                complete:function (deck) {
                    if (deck.current == 0) {
                        $(deck.navChildren.context).find('a.vertical-prev-next.previous').hide();
                    } else {
                        $(deck.navChildren.context).find('a.vertical-prev-next.previous')[0].style.display = "";
                    }
                    if (deck.current == (deck.slides.length - 1)) {
                        $(deck.navChildren.context).find('a.vertical-prev-next.next').hide();
                    } else {
                        $(deck.navChildren.context).find('a.vertical-prev-next.next')[0].style.display = "";
                    }
                    if ($('#deck_1').slidedeck().current == "3") {
                        var current = $('#deck_1').slidedeck().vertical().current;
                        $(this).click(focus_current(current));
                    }
                }
            });

    $('.skin-slidedeck a.vertical-prev-next').bind('click', function (event) {
        event.preventDefault();
        switch (this.href.split('#')[1]) {
            case "previous":
                $('.skin-slidedeck .slidedeck').slidedeck().vertical().prev();
                break;
            case "next":
                $('.skin-slidedeck .slidedeck').slidedeck().vertical().next();
                break;
        }
    });

    $('.skin-slidedeck dl.slidedeck a.vertical-prev-next.previous').hide();

    $(document).ready(function () {
        $('.skin-slidedeck .slidedeck dd.slide_2 .use-cases img').each(function (index) {
            $(this).click(function () {
                $('.skin-slidedeck .slidedeck').slidedeck().vertical().goTo(index + 2);
            });
        });
    });
    $('#slide_how_work_1').click(function () {
        $('#deck_1').slidedeck().goToVertical(2, 1);
        return false;
    });

    $('#slide_how_work_2').click(function () {
        $('#deck_1').slidedeck().goToVertical(3, 1);
        return false;
    });

    $('#slide-welcome-bonus').click(function() {
        $('#deck_1').slidedeck().goToVertical(1, 2);
        return false;
    });

    $('#slide_how_work_3').click(function () {
        $('#deck_1').slidedeck().goToVertical(1, 1);
    });

    $('#slide_how_work_4').click(function () {
        $('#deck_1').slidedeck().goToVertical(1, 4);
    });

    $('.slide_how_work_text').mouseover(function () {
        $(this).css("cursor", "pointer");
    });

    $('.slide_rabadan_text').mouseover(function () {
        $(this).css("cursor", "pointer");
    });

    $('#slide_3_move_prev').click(function () {
        $('#deck_1').slidedeck().vertical().prev();
        var current = $('#deck_1').slidedeck().vertical().current;
        $(this).click(focus_prev(current));
    });
    $('#row_list_0').click(function () {
        $('#deck_1').slidedeck().goToVertical(1, 3);
        var current = $('#deck_1').slidedeck().vertical().current;
        $(this).click(focus_current(current));
    });
    $('#row_list_1').click(function () {
        $('#deck_1').slidedeck().goToVertical(2, 3);
        var current = $('#deck_1').slidedeck().vertical().current;
        $(this).click(focus_current(current));
    });
    $('#row_list_2').click(function () {
        $('#deck_1').slidedeck().goToVertical(3, 3);
        var current = $('#deck_1').slidedeck().vertical().current;
        $(this).click(focus_current(current));
    });
    $('#row_list_3').click(function () {
        $('#deck_1').slidedeck().goToVertical(4, 3);
        var current = $('#deck_1').slidedeck().vertical().current;
        $(this).click(focus_current(current));
    });
    $('#row_list_4').click(function () {
        $('#deck_1').slidedeck().goToVertical(5, 3);
        var current = $('#deck_1').slidedeck().vertical().current;
        $(this).click(focus_current(current));
    });
    $('#row_list_5').click(function () {
        $('#deck_1').slidedeck().goToVertical(6, 3);
        var current = $('#deck_1').slidedeck().vertical().current;
        $(this).click(focus_current(current));
    });
    $('#slide_3_move_next').click(function () {
        $('#deck_1').slidedeck().vertical().next();
        var current = $('#deck_1').slidedeck().vertical().current;
        $(this).click(focus_next(current));
    });

    $('.slide_3').css('padding-bottom', '0px').css('padding-top', '0px').css('height', '300px');

    $('.arrow').mouseover(function () {
        $(this).css("cursor", "pointer");
    });

    $('#slide_3_list_vertical tr').mouseover(function () {
        $(this).css("cursor", "pointer");
    });

    function focus_next(current) {
        for (var int = 0; int < '7'; int++) {
            $('#row_list_' + int + ' td.text').removeClass("focus");
            var picto_name = $('#row_list_' + int + ' td.picto_slide img').attr('value');
            $('#row_list_' + int + ' td.picto_slide img').attr('src', '/image/<?php echo $sf_user->getCulture(); ?>/carousel/picto/normal/' + picto_name);
        }
        $('#row_list_' + current + ' td.text').addClass("focus");
        var picto_name_current = $('#row_list_' + current + ' td.picto_slide img').attr('value');
        $('#row_list_' + current + ' td.picto_slide img').attr('src', '/image/<?php echo $sf_user->getCulture(); ?>/carousel/picto/focus/' + picto_name_current);
    }

    function focus_prev(current) {
        for (var int = 0; int < '7'; int++) {
            $('#row_list_' + int + ' td.text').removeClass("focus");
            var picto_name = $('#row_list_' + int + ' td.picto_slide img').attr('value');
            $('#row_list_' + int + ' td.picto_slide img').attr('src', '/image/<?php echo $sf_user->getCulture(); ?>/carousel/picto/normal/' + picto_name);
        }
        $('#row_list_' + current + ' td.text').addClass("focus");
        var picto_name_current = $('#row_list_' + current + ' td.picto_slide img').attr('value');
        $('#row_list_' + current + ' td.picto_slide img').attr('src', '/image/<?php echo $sf_user->getCulture(); ?>/carousel/picto/focus/' + picto_name_current);
    }

    function focus_current(current) {
        for (var int = 0; int < '7'; int++) {
            $('#row_list_' + int + ' td.text').removeClass("focus");
            var picto_name = $('#row_list_' + int + ' td.picto_slide img').attr('value');
            $('#row_list_' + int + ' td.picto_slide img').attr('src', '/image/<?php echo $sf_user->getCulture(); ?>/carousel/picto/normal/' + picto_name);
        }
        $('#row_list_' + current + ' td.text').addClass("focus");
        var picto_name_current = $('#row_list_' + current + ' td.picto_slide img').attr('value');
        $('#row_list_' + current + ' td.picto_slide img').attr('src', '/image/<?php echo $sf_user->getCulture(); ?>/carousel/picto/focus/' + picto_name_current);
    }
</script>

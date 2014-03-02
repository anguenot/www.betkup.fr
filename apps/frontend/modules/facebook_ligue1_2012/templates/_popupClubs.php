<?php use_stylesheet('facebook_ligue1_2012/chooseTeam.css') ?>
<div id="modal-window">
    &nbsp;
</div>
<div id="popup-clubs">
    <div id="choose-team-container">
        <div class="header">
            <h1>AVANT DE COMMENCER, CHOISIS TON CLUB DE COEUR AFIN DE DEFENDRE SES COULEURS TOUT AU
                LONG DE LA SAISON 2012/2013</h1>
        </div>
        <div id="team-container">
            <?php foreach ($teamList as $team) : ?>
            <div class="team-element">
                <a href="#" rel="<?php echo $team['name'] . '|' . $team['betkup_room_name'] . '|' . $team['betkup_room_password'] ?>" class="team">
                    <?php echo image_tag($team['avatar_big'], array('style' => 'width: 100%; height: 100%;')) ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="popup-footer-logo">
    </div>
</div>
<script type="text/javascript">

    $(function () {
        $('.team').click(function () {
            var teamData = $(this).attr('rel').split('|');
            var teamName = teamData[0];
            var teamId = teamData[1];
            var teamPassword = teamData[2];

            if ($('.validation-box').length == 0) {
                showValidationBox($(this).parent(), teamName, teamId, teamPassword);

                $(this).css({
                    height:"100",
                    width:"100"
                }).unbind('hover');
            }
            return false;
        });

        $('.team').each(function (index) {
            $(this).tween({
                opacity:{
                    start:0,
                    stop:100,
                    time:1,
                    duration:1.4,
                    effect:'easeInOut'
                },
                left:{
                    start:function () {
                        if (index < 5) {
                            return Math.floor((Math.random() * 300) + 1);
                        } else if (index < 10) {
                            return -Math.floor((Math.random() * 300) + 1);
                        } else if (index < 15) {
                            return Math.floor((Math.random() * 300) + 1);
                        } else {
                            return -Math.floor((Math.random() * 300) + 1);
                        }
                    },
                    stop:0,
                    time:1,
                    units:'px',
                    duration:1.4,
                    effect:'easeInOut'
                },
                top:{
                    start:function () {
                        if (index < 5) {
                            return Math.floor((Math.random() * 300) + 1);
                        } else if (index < 10) {
                            return -Math.floor((Math.random() * 300) + 1);
                        } else if (index < 15) {
                            return Math.floor((Math.random() * 300) + 1);
                        } else {
                            return -Math.floor((Math.random() * 300) + 1);
                        }
                    },
                    stop:0,
                    time:1,
                    units:'px',
                    duration:1.4,
                    effect:'easeInOut'
                },
                onStop:function (elem) {
                    bindHoverEvent(elem)
                }
            });
        });
        $.play();

    });

    function bindHoverEvent(elem) {
        $(elem).hover(function () {
            $(this).animate({
                height:"100",
                width:"100",
                left:"-=10",
                top:"-=10"
            }, "fast");
        }, function () {
            $(this).animate({
                height:"70",
                width:"70",
                left:"+=10",
                top:"+=10"
            }, 'fast');
        });
    }

    function showValidationBox(caller, teamName, teamId, teamPassword) {
        caller.append(
            $(document.createElement('div'))
                .addClass('validation-box')
                .append(
                $(document.createElement('div'))
                    .addClass('arrow-up')
            ).append(
                $(document.createElement('div'))
                    .addClass('validation-box-container')
                    .append(
                    $(document.createElement('div'))
                        .addClass('validation-box-warning')
                ).append(
                    $(document.createElement('div'))
                        .addClass('validation-box-description')
                        .html("ATTENTION, ce choix est irréversible ! Es-tu sûr de vouloir défendre les couleurs du club : " + teamName)
                ).append(
                    $(document.createElement('form'))
                        .attr({'action':'<?php echo url_for(array(
                                                                 'module'  => 'facebook_ligue1_2012',
                                                                 'action'  => 'validateClub'
                                                            )) ?>',
                            'method':'post',
                            'id':'validate_form_club'})
                        .append(
                        $(document.createElement('input'))
                            .attr({'type':'hidden', 'name':'club_id'})
                            .val(teamId)
                    ).append(
                        $(document.createElement('input'))
                            .attr({'type':'hidden', 'name':'club_password'})
                            .val(teamPassword)
                    )
                ).append(
                    $(document.createElement('a'))
                        .addClass('button-cancel')
                        .attr('href', 'javascript:void(0);')
                        .html('NON')
                        .click(function () {
                            $('.validation-box').remove();
                            bindHoverEvent(caller.find('.team'));
                            caller.find('.team').mouseleave();
                        })
                ).append(
                    $(document.createElement('a'))
                        .addClass('button-validate')
                        .attr('href', 'javascript:void(0)')
                        .html('OUI')
                        .click(function () {
                            $('#validate_form_club').submit();
                        })
                )
            )
        )
    }
</script>
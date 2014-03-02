<div class="home-next-match-description">
    <div class="participation">
        <!--
        <?php if ($kupData['is_participant'] == 'true') : ?>
        <div class="is-participant"></div>
        <p>Participation validée</p>
        <?php else: ?>
        <div class="not-participant"></div>
        <p>Participation non validée</p>
        <?php endif; ?>
        -->
    </div>

    <h1>
        <?php echo $kupData['name'] ?>
    </h1>

    <p>
        <b>Date : </b>
        <?php echo util::displayDateFromTimestampComplet($kupData['startDate']) ?>
    </p>

    <p>
        <b>1er match : </b>
        <?php echo $dateFirstMatch; ?>
    </p>

    <p>
        <b>Dernier match :</b>
        <?php echo $dateLastMatch; ?>
    </p>
</div>
<div class="home-next-match-carousel">
    <table class="home-next-match-carousel-table">
        <tbody>
        <tr>
            <td class="arrow-carousel-left">
                <a href="javascript:void(0);">
                    <span class="arrow-left"></span>
                </a>
            </td>
            <td>
                <div class="carousel-content">
                    <div id="carousel-game-list">
                        <div id="slides">
                            <ul>
                                <?php foreach ($kupGamesData as $gamesData) : ?>
                                <li>
                                    <table class="carousel-game-table">
                                        <tbody>
                                        <tr>
                                            <td class="carousel-team">
                                                <a href="<?php echo url_for(array(
                                                                                 'module'    => 'facebook_ligue1_2012',
                                                                                 'action'    => 'club',
                                                                                 'club_uuid' => $gamesData['team1Bindings']['room_uuid']
                                                                            )) ?>">
                                                    <?php echo image_tag($gamesData['team1Bindings']['avatar_big'], array('size' => '100x100')) ?>

                                                    <!-- We enable it for the moment to optimize the display time.
                                                    <p>
                                                        <?php //echo $gamesData['team1Bindings']['roomData']['numberOfMembers'] ?>
                                                        suporters
                                                    </p>
                                                    -->
                                                </a>
                                            </td>
                                            <td class="carousel-vs-image">
                                                <div></div>
                                            </td>
                                            <td class="carousel-team">
                                                <a href="<?php echo url_for(array(
                                                                                 'module'    => 'facebook_ligue1_2012',
                                                                                 'action'    => 'club',
                                                                                 'club_uuid' => $gamesData['team2Bindings']['room_uuid']
                                                                            )) ?>">
                                                    <?php echo image_tag($gamesData['team2Bindings']['avatar_big'], array('size' => '100x100')) ?>
                                                    <!-- We enable it for the moment to optimize the display time.
                                                    <p>
                                                        <?php //echo $gamesData['team2Bindings']['roomData']['numberOfMembers'] ?>
                                                        suporters
                                                    </p>
                                                    -->
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </td>
            <td class="arrow-carousel-right">
                <a href="javascript:void(0);">
                    <span class="arrow-right"></span>
                </a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="button">
    <a href="<?php echo url_for('facebook_ligue1_2012_predictions') ?>">
        Pronostiquer !
    </a>
</div>
<script type="text/javascript">
    $(function () {

        //rotation speed and timer
        var speed = 5000;
        var run = setInterval('rotate()', speed);

        $('a', $('.arrow-carousel-left')).click(function () {
            $('#slides ul').tween({
                opacity:{
                    start:100,
                    stop:0,
                    time:0,
                    duration:0.4,
                    effect:'easeInOut'
                },
                onStop:function (elem) {
                    $('#slides li:last').after($('#slides li:first'));
                    $('#slides ul').tween({
                        opacity:{
                            start:0,
                            stop:100,
                            time:0,
                            duration:0.4,
                            effect:'easeInOut'
                        }
                    });
                }
            });
            $.play();
        });

        $('a', $('.arrow-carousel-right')).click(function () {
            $('#slides ul').tween({
                opacity:{
                    start:100,
                    stop:0,
                    time:0,
                    duration:0.4,
                    effect:'easeInOut'
                },
                onStop:function (elem) {
                    $('#slides li:first').before($('#slides li:last'));
                    $('#slides ul').tween({
                        opacity:{
                            start:0,
                            stop:100,
                            time:0,
                            duration:0.4,
                            effect:'easeInOut'
                        }
                    });
                }
            });
            $.play();
        });

        $('.home-next-match-carousel-table').hover(
            function () {
                clearInterval(run);
            },
            function () {
                run = setInterval('rotate()', speed);
            }
        );
    });

    function rotate() {
        $('a', $('.arrow-carousel-right')).trigger('click');
    }
</script>
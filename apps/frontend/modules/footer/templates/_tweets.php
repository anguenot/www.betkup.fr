<div style="height: 3px;"></div>
<div id="twitter-box">
    <a href="<?php echo sfConfig::get('mod_footer_twitter_betkup_page_url') ?>" class="twitter-box-button"></a>

    <div class="twitter-box-content"></div>
</div>
<div class="twitter-navigator">
    <a class="button-up" href="#" rel="no-follow">
        <?php echo image_tag('/image/default/home/button_top.png', array(
                                                                        'id'   => 'twitter_up',
                                                                        'alt'  => __('label_footer_twitter_up'),
                                                                        'size' => '15x15'
                                                                   )) ?>
    </a>

    <div style="height: 20px;"></div>
    <a class="button-down" href="#" rel="no-follow">
        <?php echo image_tag('/image/default/home/button_bottom.png', array(
                                                                           'id'   => 'twitter_down',
                                                                           'alt'  => __('label_footer_twitter_down'),
                                                                           'size' => '15x15'
                                                                      )) ?>
    </a>
</div>
<script type="text/javascript">
    $(function () {
        var upAnimate = false, downAnimate = false;

        $('.button-up', $('.twitter-navigator')).click(function () {

            if (!upAnimate) {
                upAnimate = true;

                var offsetTop = $('#tweets-container').css('top').replace('px', '');

                if (offsetTop == 0) {
                    $('#tweets-container').animate({
                        top:'+=20'
                    }, 200, function () {
                        $(this).animate({
                            top:'-=20'
                        }, 200, function () {
                            upAnimate = false;
                        });
                    });
                } else {
                    $('#tweets-container').animate({
                        top:'+=70'
                    }, 300, function () {
                        upAnimate = false;
                    });
                }
            }
            return false;
        });
        $('.button-down', $('.twitter-navigator')).click(function () {

            if (!downAnimate) {
                downAnimate = true;

                var offsetTop = Math.abs($('#tweets-container').css('top').replace('px', '')),
                    containerHeight = $('#tweets-container').css('height').replace('px', '');

                if (offsetTop >= (containerHeight - 70)) {
                    $('#tweets-container').animate({
                        top:'-=10'
                    }, 200, function () {
                        $(this).animate({
                            top:'+=10'
                        }, 200, function () {
                            downAnimate = false;
                        });
                    });
                } else {
                    $('#tweets-container').animate({
                        top:'-=70'
                    }, 300, function () {
                        downAnimate = false;
                    });
                }
            }
            return false;
        });
/*
        loadTweets();

        setTimeout(function () {
            loadNotyTweets(2, true);
        }, 1000);

        setInterval(function () {
            loadNotyTweets(1);
        }, 6000);
*/
    });

    function generateNoty(text) {
        var notyObj = noty({
            template:'<div class="noty_message"><div class="noty_text"></div><div class="noty_close"></div></div>',
            type:'tweets',
            layout:'bottomLeft',
            text:text,
            closeWith:['button'],
            onClose:function () {
                var hashTweet = calcMD5(text);
                $.cookie(hashTweet, "close");
            }
        });
    }

    function loadTweets() {
        var jqXhr = $.ajax({
            'url':'<?php echo url_for(array('module' => 'footer', 'action' => 'thumbnailTweets')) ?>',
            'type':'GET',
            'async':true,
            'dataType':'html'
        }).done(function (data) {
            $('.twitter-box-content', $('#twitter-box')).html(data);
        });
    }

    function loadNotyTweets(tweetCount, forced) {

        var params = {};

        if (forced === true) {
            params = {forced:'1'}
        }

        var jqXhr = $.ajax({
            'url':'<?php echo url_for(array('module' => 'footer', 'action' => 'getLastApiTweets')) ?>',
            'type':'GET',
            'async':true,
            'data':params,
            'dataType':'json'
        }).done(function (data) {

            if (data.code && data.code == '400') {

            }
            else {

                var j = 0;
                for (var i in data) {
                    var text = formatNoty(data[i]['text'], data[i]['user']['screen_name'], data[i]['user']['name'], data[i]['user']['profile_image_url_https'], data[i]['created_at']),
                            hashTweet = calcMD5(text);

                    if (!$.cookie(hashTweet) || $.cookie(hashTweet) != 'close') {
                        generateNoty(text);
                    }
                    j++;
                    if (j == tweetCount) {
                        break;
                    }
                }

                loadTweets();
            }
        });

    }

    function formatNoty(text, user, name, image, date) {
        var html = '<table class="noty-tweet-table">';
        html += '<tr>';
        html += '<td class="tweet-image">';
        html += '<img src="' + image + '" alt="' + name + '" />';
        html += '</td>';
        html += '<td class="tweet-text">';
        html += '<span class="tweet-twitter-bird"></span>';
        html += '<h3>' + name + ' ' + user + '</h3>';
        html += '<span class="tweet-date">' + date + '</span>';
        html += '<p>' + text + '</p>';
        html += '</td>';
        html += '</tr>';
        html += '</table>';

        return html;
    }
</script>
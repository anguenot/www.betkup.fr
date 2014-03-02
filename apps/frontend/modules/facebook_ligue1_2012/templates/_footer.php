<div id="footer">
    <div class="row-fluid row-footer">
        <div class="span1"></div>
        <div class="span3">
            <table>
                <tbody>
                <tr>
                    <td>
                        <div class="footer-play"></div>
                    </td>
                    <td>
                        <a id="link-invite-friends" href="javascript:void(0);" onclick="sendFooterRequestViaMultiFriendSelector();">
                            Inviter des amis
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="span3">
            <div class="fb-like" data-href="<?php echo sfConfig::get('app_facebook_betkup_page_url')?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true" data-font="lucida grande"></div>
        </div>
        <div class="span2">
            <table>
                <tbody>
                <tr>
                    <td>
                        <div class="footer-play"></div>
                    </td>
                    <td>
                        <a href="https://www.facebook.com/betkup/app_395372147178321" target="_blank">Feedback</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="span2">
            <table>
                <tbody>
                <tr>
                    <td>
                        <div class="footer-play"></div>
                    </td>
                    <td>
                        <a href="<?php echo sfConfig::get('app_facebook_betkup_page_url')?>" target="_blank">Forum</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="span1"></div>
    </div>
</div>
<script type="text/javascript">
    var timerFooter;
    $(function () {

    <?php if ($inviteFriends == 1) : ?>
            timerFooter = setInterval('sendFooterRequestViaMultiFriendSelector()', 400);
            <?php endif; ?>
    });

    function sendFooterRequestViaMultiFriendSelector() {
        if (isFBLoaded) {
            clearInterval(timerFooter);
            FB.ui({
                method:'apprequests',
                filters:['app_non_users'],
                message:html_entity_decode("<?php echo $messageInviteRequest?>")
            }, function (response) {
                if(response != 'undefined' && response != null) {
                    alert('Requêtes envoyées.');
                }
            });
        }
    }
</script>
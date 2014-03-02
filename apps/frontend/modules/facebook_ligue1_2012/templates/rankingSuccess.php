<div class="br-big"></div>
<div class="row-fluid">
    <div class="span1"></div>
    <div class="span10">
        <div class="tabs-ranking">
            <ul class="tabs">
                <li>
                    <a href="<?php echo url_for('facebook_ligue1_2012_ranking_tab', array('tab' => 'individual')) ?>"
                       class="<?php echo $tab == 'individual' ? 'selected' : '' ?>">
                        Individuel
                    </a>
                </li>
                <li>
                    <a href="<?php echo url_for('facebook_ligue1_2012_ranking_tab', array('tab' => 'clubs')) ?>"
                       class="<?php echo $tab == 'clubs' ? 'selected' : '' ?>">
                        Clubs
                    </a>
                </li>
                <li>
                    <a href="<?php echo url_for('facebook_ligue1_2012_ranking_tab', array('tab' => 'friends')) ?>"
                       class="<?php echo $tab == 'friends' ? 'selected' : '' ?>">
                        Amis
                    </a>
                </li>
                <li>
                    <a href="<?php echo url_for('facebook_ligue1_2012_ranking_tab', array('tab' => 'my_club')) ?>"
                       class="<?php echo $tab == 'my_club' ? 'selected' : '' ?>">
                        Mon club
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="span1"></div>
</div>
<div class="br-big"></div>
<div class="row-fluid">
    <div class="span1"></div>
    <div class="span10">
        <div class="ranking-container">

        </div>
    </div>
    <div class="span1"></div>
</div>
<script type="text/javascript">
    $(function () {
        $('.ranking-container').loadContent({
            'url':'<?php echo $loadUrl ?>',
            'method':'POST',
            data:{}
        }, "resizeCanvas()");
    });


    function sendRequestToRecipients(facebookId) {
        FB.ui({
            method:'apprequests',
            message:'<?php echo isset($publishMessageFacebook) ? $publishMessageFacebook : '' ?>',
            to:facebookId
        }, function (response) {
            if(response.request != '') {
                alert('Requête envoyée ou déjà envoyée.');
            }
        });
    }

    function sendRequestViaMultiFriendSelector() {
        FB.ui({
            method:'apprequests',
            message:'<?php echo isset($publishMessageFacebook) ? $publishMessageFacebook : '' ?>'
        }, function (response) {
            if(response != 'undefined' && response != null) {
                alert('Requêtes envoyées.');
            }
        });
    }

    function facebookWallPublish() {
        FB.ui({
            method: 'feed',
            link: '<?php echo $publishLink ?>',
            name: '<?php echo $publishTitle ?>',
            description: '<?php echo $publishDescription ?>'
        })
    }
</script>
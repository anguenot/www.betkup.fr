<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php $browser = browser::get_browser() ?>
<?php $navigator = $browser["browser"] ?>
<?php $version = $browser["version"] ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# <?php echo sfConfig::get('mod_facebook_ligue1_2012_facebook_canvas_ns') ?>: http://ogp.me/ns/fb/<?php echo sfConfig::get('mod_facebook_ligue1_2012_facebook_canvas_ns') ?>#">
    <?php include_title() ?>
    <?php include_component("header", "openTags") ?>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <script type="text/javascript">
        var isFBLoaded = false;
        window.fbAsyncInit = function () {
            FB.init({
                appId:'<?php echo sfConfig::get('mod_facebook_ligue1_2012_facebook_connect_app_id') ?>',
                status:true,
                cookie:true,
                frictionlessRequests:true,
                xfbml:true,
                oauth:true
            });
            isFBLoaded = true;
            if (document.location.protocol == 'https:' && !!FB && !!FB._domain && !!FB._domain.staticfb) {
                FB._domain.staticfb = FB._domain.staticfb.replace('http://static.ak.facebook.com/', 'https://s-static.ak.fbcdn.net/');
            }
        };
        (function (d) {
            var js, id = 'facebook-jssdk';
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement('script');
            js.id = id;
            js.async = true;
            js.src = "https://connect.facebook.net/fr_FR/all.js";
            d.getElementsByTagName('head')[0].appendChild(js);
        }(document));
    </script>
</head>
<body>
<div id="fb-root"></div>
<script type="text/javascript">
    var timerFB;
    $(function () {
        timerFB = setInterval("resizeCanvas()", 400);
    });
    function resizeCanvas() {
        if (isFBLoaded) {
            var containerHeight = document.getElementById('body-container').offsetHeight;
            var obj = new Object;
            obj.height = containerHeight;
            FB.Canvas.setSize(obj);
            clearInterval(timerFB);
        }
    }
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', "<?php echo sfConfig::get('mod_facebook_ligue1_2012_analytics_google') ?>"]);
    _gaq.push(['_trackPageview']);
    _gaq.push(['_trackPageLoadTime']);
    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();
</script>
<div id="body-container">
    <?php include_component('interface', 'flashMessage') ?>
    <?php include_component("facebook_ligue1_2012", "header")?>
    <?php echo $sf_content ?>
    <?php include_component("facebook_ligue1_2012", "footer")?>
    <?php if ($sf_user->getAttribute('clubId', '', 'subscriber') == '' &&
              $sf_request->getParameter('action', '') != 'landingPage') : ?>
    <?php include_component("facebook_ligue1_2012", "popupClubs") ?>
    <?php endif; ?>
</div>
</body>
</html>

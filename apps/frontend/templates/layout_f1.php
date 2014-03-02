<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php $browser = browser::get_browser() ?>
<?php $navigator = $browser["browser"] ?>
<?php $version = $browser["version"] ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_stylesheets()?>
    <?php include_javascripts()?>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <script type="text/javascript">
        var isFBLoaded = false;
        window.fbAsyncInit = function () {
            FB.init({
                appId:'<?php echo sfConfig::get('mod_facebook_f1_sport24_facebook_connect_app_id') ?>',
                status:true,
                cookie:true,
                xfbml:true
            });
            isFBLoaded = true;
            if (document.location.protocol == 'https:' && !!FB && !!FB._domain && !!FB._domain.staticfb) {
                FB._domain.staticfb = FB._domain.staticfb.replace('http://static.ak.facebook.com/', 'https://s-static.ak.fbcdn.net/');
            }
        };
        (function (d) {
            var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement('script');
            js.id = id;
            js.async = true;
            js.src = "https://connect.facebook.net/fr_FR/all.js";
            ref.parentNode.insertBefore(js, ref);
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
            var containerHeight = document.getElementById('body-contener').offsetHeight;
            var obj = new Object;
            obj.height = containerHeight;
            FB.Canvas.setSize(obj);
            clearInterval(timerFB);
        }
    }
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', "<?php echo sfConfig::get('mod_facebook_f1_sport24_analytics_google') ?>"]);
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
<div id="body-contener">
    <?php include_component('interface', 'flashMessage') ?>
    <?php include_component("facebook_f1_sport24", "header")?>
    <?php echo $sf_content ?>
    <?php include_component("facebook_f1_sport24", "footer")?>
</div>
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php $browser = browser::get_browser() ?>
<?php $navigator = $browser["browser"] ?>
<?php $version = $browser["version"] ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_title() ?>
        <?php include_metas() ?>
        <?php include_http_metas() ?>
        <?php include_component("header", "openTags") ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets()?>
        <?php include_javascripts()?>
        <?php if ($navigator == "MSIE" && $version <= 8): ?>
        <link rel="stylesheet" type="text/css" media="screen" href="/css/kupIE.css"/>
        <?php endif ?>
    </head>
    <body>
    <!-- Add all tracking codes for adwords -->
    <?php include_component('tracking', 'trackings') ?>

    <div id="fb-root"></div>
    <?php include_component('header', 'header', array()) ?>
    <?php include_component('header', 'toppage', array('page' => 'home')) ?>
    <div class="container">
        <?php echo $sf_content ?>
    </div>
    <?php include_component('footer', 'footer', array()) ?>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', "<?php echo sfConfig::get('app_analytics_google') ?>"]);
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

        var isFBLoaded = false;
        window.fbAsyncInit = function () {
            FB.init({
                appId:'<?php echo sfConfig::get('app_facebook_connect_app_id') ?>',
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

        var popupDisplay = 0;
        $("#boutonConnexionPopup").click(function (key) {
            if (popupDisplay == 0) {
                $('#popupConnection').fadeIn('fast');
                popupDisplay = 1;
            }
            else if (popupDisplay == 1) {
                $('#popupConnection').fadeOut('fast');
                popupDisplay = 0;
            }
        });

        var uservoiceOptions = {
            key:'betkup',
            host:'betkup.uservoice.com',
            forum:'59327',
            alignment:'left',
            background_color:'#f05627',
            text_color:'white',
            hover_color:'#000000',
            lang:'en',
            showTab:true
        };
        function _loadUserVoice() {
            var uv = document.createElement('script');
            uv.type = 'text/javascript';
            uv.async = true;
            uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/WaIQxPN8ZcUZUeViuwAg.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(uv, s);
        }
        _loadSuper = window.onload;
        window.onload = (typeof window.onload != 'function') ? _loadUserVoice : function () {
            _loadSuper();
            _loadUserVoice();
        };

        document.write(unescape("%3Cscript src='" + ((document.location.protocol == "https:") ? "https:" : "http:") + "//snapabug.appspot.com/snapabug.js' type='text/javascript'%3E%3C/script%3E"));</script>
    <script type="text/javascript">
        SnapABug.setLocale("fr");
        SnapABug.addButton("0525400b-f13c-4ae7-90a0-3a5f8e9f0b67", "0", "460px");
    </script>
    </body>
</html>


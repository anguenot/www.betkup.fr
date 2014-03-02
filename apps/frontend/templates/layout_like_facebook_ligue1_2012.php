<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>

    <script type="text/javascript">

        var isFBLoaded = false;
        window.fbAsyncInit = function () {
            FB.init({
                appId:'<?php echo sfConfig::get('app_facebook_connect_app_id') ?>',
                status:true,
                cookie:true,
                xfbml:true
            });
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
<?php echo $sf_content ?>
</body>
</html>

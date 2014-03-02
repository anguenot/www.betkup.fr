<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php $browser = browser::get_browser() ?>
<?php $navigator = $browser["browser"] ?>
<?php $version = $browser["version"] ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<link rel="shortcut icon" href="/favicon.ico" />
<?php include_stylesheets() ?>
<?php include_javascripts() ?>
<script type="text/javascript">
	var isFBLoaded = false;
    if (typeof FB == 'undefined') {   	
    	window.fbAsyncInit = function() {
            FB.init({
              appId      : '<?php echo sfConfig::get('app_facebook_connect_app_id') ?>',
              status     : true, 
              cookie     : true,
              xfbml      : true
            });
            if(document.location.protocol == 'https:' && !!FB && !!FB._domain && !!FB._domain.staticfb) {
            	FB._domain.staticfb = FB._domain.staticfb.replace('http://static.ak.facebook.com/', 'https://s-static.ak.fbcdn.net/');
            }
            isFBLoaded = true;
        };
    	(function(d){
			var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
		    	js = d.createElement('script'); js.id = id; js.async = true;
		        js.src = "https://connect.facebook.net/fr_FR/all.js";
		        d.getElementsByTagName('head')[0].appendChild(js);
		}(document));
    	isFBLoaded = true;
    } else {
    	isFBLoaded = true;
    }
</script>
</head>
<body>
	<div id="fb-root"></div>
	<div id="body-contener">
	<?php include_component('interface', 'flashMessage') ?>
	<?php include_component("room", "widgetHeader")?>
	<?php echo $sf_content ?>
	<?php include_component("room", "widgetFooter")?>
	</div>
	<script type="text/javascript">
			var _gaq = _gaq || [];
            _gaq.push(['_setAccount', "<?php echo sfConfig::get('app_analytics_google') ?>"]);
            _gaq.push(['_trackPageview']);
            _gaq.push(['_trackPageLoadTime']);
            (function() {
                  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
	</script>
</body>
</html>

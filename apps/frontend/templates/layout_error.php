<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php $browser = browser::get_browser() ?>
<?php $navigator = $browser["browser"] ?>
<?php $version = $browser["version"] ?>
<html xmlns="http://www.w3.org/1999/xhtml"
      xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <?php include_stylesheets()?>
        <?php include_javascripts()?>
        <link rel="shortcut icon" href="/favicon.ico" />
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
	</head>
    <body>
    	<?php echo $sf_content ?> 
    </body>
</html>
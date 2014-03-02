<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>  
	    <?php include_http_metas() ?>
		<?php include_metas() ?>
		<?php include_title() ?>
		<?php include_javascripts() ?>
		
		<script type="text/javascript">

			var isFBLoaded = false;   	
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
                FB.getLoginStatus(function(response) {
                	if (response.status === 'connected') {
                		var uid = response.authResponse.userID;
                	    var accessToken = response.authResponse.accessToken;
                	    pageLiked();
                	} else if (response.status === 'not_authorized') {
                  	    console.log('USER CONNECTED, NOT AUTHORIZED');

                  	  	FB.login(function(response) {
                  			if (response.authResponse) {
                  		   		pageLiked();
                  			} else {
                  		     console.log('User cancelled login or did not fully authorize.');
                  		   }
                  		 }, {scope: 'email,user_likes'});
                	} else {
                	    console.log('USER NOT CONNECTED, NOT AUTHORIZED');
                	}
                });
            };
            (function(d){
                var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
                js = d.createElement('script'); js.id = id; js.async = true;
                js.src = "https://connect.facebook.net/fr_FR/all.js";
                d.getElementsByTagName('head')[0].appendChild(js);
            }(document));
	    	
			function isEmpty(obj) {
			    for(var prop in obj) {
			        if(obj.hasOwnProperty(prop))
			            return false;
			    }
			 
			    return true;
			}

			function pageLiked() {
				FB.api('/me/likes/<?php echo sfConfig::get('app_facebook_betkup_page_id') ?>', function(response) {
       			    if( response.data ) {
       			        if( !isEmpty(response.data) ) {
       			        	$('#page-liked').show();
   			        		$('#page-unliked').hide();
       			        } else {
       			        	$('#page-unliked').show();
       			        	$('#page-liked').hide();
       			        }
       			    } else {
       			    	console.log('ERROR!');
       			    }
				});
                resizeCanvas();
			}
		</script>
	</head>  
	<body>
	<div id="fb-root"></div>
    <script type="text/javascript">
        var timerFB;
        $(function() {
            timerFB = setInterval("resizeCanvas()", 400);
        });
        function resizeCanvas() {
            if(isFBLoaded) {
                var containerHeight = document.getElementById('body-container').offsetHeight;
                var obj = new Object;
                obj.height=containerHeight + 30;
                FB.Canvas.setSize(obj);
                clearInterval(timerFB);
            }
        }
    </script>
    <div id="body-container">
	<?php echo $sf_content ?>
    </div>
	</body>
</html>  

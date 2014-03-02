Compatibility
______________________

Examples have been tested with following configuration : APACHE 2.2.14, PHP Version 5.3.2
with following php extensions actived : php_curl, php_http, php_openssl, php_soap.

Installation and usage
______________________

Upload the contents of the archive paylineSDK.zip into a new folder named 'payline' on your server.
Open and modify 'identification.php' file in 'configuration' folder and change following vars :

	MERCHANT_ID, ACCESS_KEY

If you're using a proxy to access the web, change following vars in the same file :

	PROXY_HOST, PROXY_PORT, PROXY_LOGIN, PROXY_PASSWORD

Save your modifications and upload file. Open your browser and go to url
http://www.example.com/payline/

You can see html, php and css code by clicking on link available on the top
You can use this source code for your web payment page. For documentation on all of the
parameters availables, refer to the payline's documentation

Finally, you can open and modify 'options.php' file in 'configuration' folder in order to get your own configuration site. For example, in this file, you can modify default payment currency, default cancel URL or default return URL.

PRODUCTION
______________________

When all test are approved, open and modify 'identification.php' file in 'configuration' folder
and change the "PRODUCTION" value to TRUE.
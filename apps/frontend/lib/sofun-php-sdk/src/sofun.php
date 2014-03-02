<?php

/*
 * Copyright (c) 2011, Sofun Gaming SAS
 *
 *
 *       This software is licensed under the Terms and Conditions
 *       contained within the "LICENSE.txt" file that accompanied
 *       this software.  Any inquiries concerning the scope or
 *       enforceability of the license should be addressed to:
 *
 *       Sofun Gaming SAS
 *       30 rue blondel
 *       75002 Paris
 *       France
 *       p. +33 (0) 7 86 85 70 44
 *       www.sofungaming.com
 *
 * @version $Id: sofun.php 52 2012-10-26 14:05:36Z anguenot $
 */

if (!function_exists('curl_init')) {
	throw new Exception('Sofun needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
	throw new Exception('Sofun needs the JSON PHP extension.');
}

/**
 * Provides acccess to the Sofun Platform.
 *
 * @author <a href="mailto:anguenot@sofungaming.com">Julien Anguenot</a>
 *
 */
class Sofun {

	/**
	 * Default Sofun platform domain.
	 * <p/>
	 * Can be overriden using constructor params.
	 */
	private static $DOMAIN = "api.sofungaming.com";

	/**
	 * Default protocol to access the Sofun platform
	 * <p/>
	 * Can be overriden using constructor params.
	 */
	private static $PROTOCOL = "https://";

	/**
	 * Relative path to access the Sofun platform.
	 */
	private static $BASE = "/sofun";

	/**
	 * Path relative to $BASE to exchange oauth tokens
	 */
	private static $BASE_OAUTH = "/oauth";

	/**
	 * Path relative to $BASE to access Sofun platform ReST resources
	 */
	private static $BASE_API = "/rest";

	/**
	 * Default options for curl.
	 */
	public static $CURL_OPTS = array(
	CURLOPT_CONNECTTIMEOUT => 30,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_TIMEOUT        => 60,
	CURLOPT_USERAGENT      => 'Sofun-SDK/1.1',
	CURLOPT_HTTPHEADER     =>  array('Content-Type: application/json'),
	);

	/**
	 * OAuth consumer identifier. Application trying to acces the Sofun must have one.
	 */
	protected $consumerId;

	/**
	 * OAuth consumer secret. Application trying to acces the Sofun must have one.
	 */
	protected $consumerSecret;

	/**
	 * Sofun platform domain
	 * <p/>
	 * Can be configured using the constructor params.
	 */
	protected $domain;

	/**
	 * Protocol used to access the Sofun platform.
	 * <p/>
	 * Can be either http or https depending on the instance.
	 * <p/>
	 * Can be configured using the constructor params.
	 */
	protected $protocol;

	/**
	 * Sofun platform session.
	 */
	protected $session = array();

	/**
	 * Sofun platform token object
	 */
	protected $oauth_token = NULL;

	/**
	 * Initialize a Sofun Application given a configuration.
	 *
	 * The configuration:
	 *     - consumerId: the OAuth consumer Id
	 *     - consumerSecrect: the OAuth consumer secret
	 *     - domain: the API domain
	 *     - protocol: API domain protocol
	 *
	 * @param Array $config the application configuration
	 */
	public function __construct($config) {
		$this->setConsumerId($config['consumerId']);
		$this->setConsumerSecret($config['consumerSecret']);
		if (isset($config['domain'])) {
			$this->domain = $config['domain'];
		} else {
			$this->domain = self::$DOMAIN;
		}
		if (isset($config['protocol'])) {
			$this->protocol = $config['protocol'];
		} else {
			$this->protocol = self::$PROTOCOL;
		}
		// We store these information in the session.
		$this->setSession($config);
	}

	/**
	 * Initialize session.
	 * 
	 * <p>
	 * 
	 * Currently request / access tokens generation.
	 */
	public function init() {
		//  Generate request and access tokens and store them in session.
		$this->_getAccessToken();
	}

	/**
	 * Get the consumer ID.
	 *
	 * @return String the consumer ID
	 */
	public function getConsumerId() {
		return $this->consumerId;
	}

	/**
	 * Set the consumer ID.
	 *
	 * @param String $consumerId the consumer ID
	 */
	public function setConsumerId($consumerId) {
		$this->consumerId = $consumerId;
		return $this;
	}

	/**
	 * Get the consumer secret.
	 *
	 * @return String the consumer secret
	 */
	public function getConsumerSecret() {
		return $this->consumerSecret;
	}

	/**
	 * Set the consumer secret.
	 *
	 * @param String $consumerSecret the consumer secret
	 */
	public function setConsumerSecret($consumerSecret) {
		$this->consumerSecret =$consumerSecret;
		return $this;
	}

	/**
	 * Get the Sofun platform domain.
	 *
	 * @return String the consumer ID
	 */
	public function getDomain() {
		return $this->domain;
	}

	/**
	 * Set the Sofun Platform doamin
	 *
	 * @param String $domain the Sofun Platform doamin
	 */
	public function setDomain($domain) {
		$this->domain = $domain;
		return $this;
	}

	/**
	 * Get the protocol in use to access the Sofun platform.
	 *
	 * @return String the consumer ID
	 */
	public function getProtocol() {
		return $this->protocol;
	}

	/**
	 * Set the protocol in use to access the Sofun platform.
	 *
	 * @param String $protocol the protocol in use to access the Sofun platform.
	 */
	public function setProtocol($protocol) {
		$this->protocol = $protocol;
		return $this;
	}

	/**
	 * Get the Sofun Session.
	 *
	 * <p/>
	 * Include the oauth access token and secret as well as user meta information
	 * such as email, facebookId etc. It also includes the App configuration as given
	 * to constructor.
	 *
	 * @return Array $session the session
	 */
	public function getSession() {
		return $this->session;
	}

	/**
	 * Set the Sofun Session.
	 *
	 * <p/>
	 * Include the oauth access token and secret as well as user meta information
	 * such as email, facebookId etc. It also includes the App configuration as given
	 * to constructor.
	 *
	 * @param Array $session the session
	 */
	public function setSession($session=NULL) {
		if ($session != NULL) {
			$this->session = $session;
			return $this;
		}
	}

	/**
	 * Get the session's status.
	 *
	 * @return Boolean the status of the session
	 */
	public function getSessionStatus() {
		$status = true;
		$resp = $this->api_GET("/core/status");
		// 401: token expired.
		// 503: the platform is down.
		if ($resp["http_code"] == "401" || $resp["http_code"] == "503") {
			$status = false;
			// Cleanup sessions.
			$session = array();
			$this->setSession($session);
		}
		return $status;
	}

	/**
	 * Login a user.
	 *
	 * @param Array $login_info the login information
	 */
	public function login($login_info) {

		if (array_key_exists('email', $login_info)) {
			$email = $login_info["email"];
		}

		if (array_key_exists('facebookId', $login_info)) {
			$facebookId = $login_info["facebookId"];
		}

		$session = $this->getSession();

		if (isset($facebookId)) {
			$session["facebookId"] = $facebookId;
			$this->setSession($session);
			return $this->api_POST("/member/login/facebook?facebookId=" . $facebookId, $login_info);
		} else if (isset($email)) {
			$session["email"] = $email;
			$this->setSession($session);
			return $this->api_POST("/member/login?email=" . $email, $login_info);
		}	else {
			$info = array();
			$info["error_code"] = 400;
			$info["error"] = array();
			$info["error"]["message"] = "Email or facebookId are compulsory.";
			$info["error"]["type"] = "SDK input validation exception";
			throw new SofunApiException($info);
		}

	}

	/**
	 * Logout user from Sofun Platform.
	 */
	public function logout() {

		$session = $this->getSession();

		if (!empty($session) && isset($session['facebookId']) && $session['facebookId'] != '') {
			return $this->api_POST("/member/facebook/" . $session['facebookId'] . "/logout");
		} else if (!empty($session) && isset($session['email'])) {
			return $this->api_POST("/member/" . $session['email'] . "/logout");
		}
		
	}

	/**
	 * Returns actual Sofun Platform token object bound to current session.
	 */
	protected function _getAccessToken() {
		if ($this->oauth_token == NULL) {
			$accessToken = $this->getAccessToken();
			$this->oauth_token =  new OAuthToken($accessToken['oauth_token'], $accessToken['oauth_token_secret'], 1);
		}
		return $this->oauth_token;
	}

	protected function _GET($method, $params=NULL, $form="GET") {

		if (!$params) {
			$params = array();
		}

		$token =  $this->_getAccessToken();

		$url = OAuthRequest::from_consumer_and_token($this->getOAUthConsumer(), $token, $form, self::getBaseAPIURL() . $method);
		$url->sign_request($this->getOAuthSignatureMethod(), $this->getOAUthConsumer(), $token);

		try {
			$results = $this->makeOAuthRequest($url, $params, $form);
			$buffer = $results['result'];
			$http_code = $results['http_code'];
		} catch (SofunApiException $e) {
			$buffer = $e->__toString();
			$http_code = $e->getCode();
		}

		$result = json_decode($buffer, true);
		if ($result == '') {
			$result = $buffer;
		}

		return array('buffer' => $result,
			         'http_code' => $http_code);

	}

	/**
	 * Performs a GET API call agains the Sofun Platform.
	 *
	 * @param String $method the method to invoke.
	 * @param Array $params the parameters to include while performing the request.
	 */
	public function api_GET($method, $params=NULL) {
		return $this->_GET($method, $params, "GET");
	}

	/**
	 * Performs a POST API call agains the Sofun Platform.
	 *
	 * @param String $method the method to invoke.
	 * @param Array $params the parameters to include while performing the request.
	 */
	public function api_POST($method, $params=NULL) {
		return $this->_GET($method, $params, "POST");
	}

	protected function getRequestToken() {

		$session = $this->getSession();
		if (isset($session['request_token']) && !empty($session['request_token'])) {
			return $session['request_token'];
		}

		// oauth_verifier=1 because user can NEVER interact with the application and therefore get a oauth verification id.
		// Only allowed applications with credentials and allowed routing can interact directly with a given instance of the
		// the sofun platform.  A user will always interact with a Sofun platform instance through an application.
		$url = OAuthRequest::from_consumer_and_token($this->getOAUthConsumer(), NULL, "GET", self::getBaseOAUTHURL() . '/requestToken?oauth_verifier=1' . "");
		$url->sign_request($this->getOAuthSignatureMethod(), $this->getOAUthConsumer(), NULL);

		$results = $this->makeRequest($url, NULL);
		$buffer = $results['result'];

		if(strpos($buffer, 'oauth_token=') === 0) {
			$session = $this->getSession();
			$session['request_token'] = array("oauth_token" => trim(Sofun::getvalue($buffer, 'oauth_token=', '&')),
		             "oauth_token_secret" => trim(Sofun::getvalue($buffer,'oauth_token_secret=','&')));
			$this->setSession($session);
			return $session['request_token'];
		}

		$session['request_token'] = '';
		$this->setSession($session);

		$info = array();
		$info["error_code"] = 500;
		$info["error"] = array();
		$info["error"]["message"] = "Failed to retrieve a OAUth request token.";
		$info["error"]["type"] = "SDK Exception";
		throw new SofunApiException($info);
	}

	protected function getAccessToken() {

		$session = $this->getSession();
		if (isset($session['access_token']) && $session['access_token'] != '') {
			return $session['access_token'];
		}

		$requestToken = $this->getRequestToken();
		$acc_token_consumer =  new OAuthConsumer($requestToken['oauth_token'], $requestToken['oauth_token_secret'], 1);

		$url = OAuthRequest::from_consumer_and_token($this->getOAUthConsumer(), $acc_token_consumer, "GET", self::getBaseOAUTHURL() . '/accessToken?oauth_verifier=1' . "");
		$url->sign_request($this->getOAuthSignatureMethod(), $this->getOAUthConsumer(), $acc_token_consumer);

		$results = $this->makeRequest($url, NULL);
		$buffer = $results['result'];

		if(strpos($buffer, 'oauth_token=') === 0) {
			$session = $this->getSession();
			$session['access_token'] = array("oauth_token" => trim(sofun::getvalue($buffer, 'oauth_token=', '&')),
		                                     "oauth_token_secret" => trim(sofun::getvalue($buffer,'oauth_token_secret=',' ')));
			$this->setSession($session);
			return $session['access_token'];
		}

		$session['access_token'] = '';
		$this->setSession($session);

		$info = array();
		$info["error_code"] = 500;
		$info["error"] = array();
		$info["error"]["message"] = "Failed to retrieve a OAUth access token.";
		$info["error"]["type"] = "SDK Exception";
		throw new SofunApiException($buffer);

	}

	protected function getOAUthConsumer() {
		return new OAuthConsumer($this->getConsumerId(), $this->getConsumerSecret(), NULL);
	}

	protected function getOAuthSignatureMethod() {
		if ($this->getProtocol() == 'https://') {
			return new OAuthSignatureMethod_PLAINTEXT();
		} else {
			return new OAuthSignatureMethod_HMAC_SHA1();
		}
	}

	protected function makeOAuthRequest($url, $params, $method="GET") {

		if (!$params) {
			$params = array();
		}

		// json_encode all params values that are not strings
		foreach ($params as $key => $value) {
			if (!is_string($value)) {
				$params[$key] = json_encode($value);
			}
		}

		return $this->makeRequest($url, $params, $method);

	}

	protected function makeRequest($url, $params, $method="GET") {

		if (!$params) {
			$params = array();
		}

		$curl_handle = curl_init();

		$opts = self::$CURL_OPTS;

		if ($method == 'POST') {
			$opts[CURLOPT_POST] = true;
			$opts[CURLOPT_POSTFIELDS] = json_encode($params);
		}

		$opts[CURLOPT_URL] = $url;
		curl_setopt_array($curl_handle, $opts);

		$buffer = curl_exec($curl_handle);
		$http_code = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
		curl_close($curl_handle);

		// Server is unavailable
		if ($http_code == false || $http_code == '0' || $http_code == '503') {
			$error = "Sofun Platform " . $this->getBaseAPIURL() . " is unavailable.";
			$this->throwException(503, $error, "SofunException");
		}

		// Forbidden
        /*
		if ($http_code == '401') {
            error_log($url);
            error_log(print_r($params, true));
			$error = "API call forbidden by Sofun Platform.";
			$this->throwException($http_code, $error, "Unauthorized");
		}
        */

		// Fallback
		if ($buffer === false) {
			$this->throwException($http_code, curl_error($curl_handle), "Exception");
		}

		return array('result'=> $buffer,
		             'http_code' => $http_code);

	}

	protected function throwException($http_code, $error, $type) {
		throw new SofunApiException(array(
		               'error_code' => $http_code,
		               'error'      => array(
		                   'message' => $error,
		                   'type'    => $type,
		)));
	}

	protected final function getBaseAPIURL() {
		return $this->getProtocol() . $this->getDomain() . self::$BASE . self::$BASE_API;
	}

	protected final function getBaseOAUTHURL() {
		return $this->getProtocol() . $this->getDomain() . self::$BASE . self::$BASE_OAUTH;
	}

	protected static function errorLog($msg) {
		if (php_sapi_name() != 'cli') {
			error_log('sofun-sdk: ' . $msg);
		}
	}

	protected static function getvalue($string, $start, $end) {

		$string = " ".$string. " ";

		$ini = strpos($string,$start);
		if ($ini == 0) {
			return "";
		}

		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);

	}

	protected function printStackTrace() {
		$dbgTrace = debug_backtrace();
		error_log(" -- Stack trace -- \n\n");
		foreach($dbgTrace as $dbgIndex => $dbgInfo) {
			error_log("at $dbgIndex  ".$dbgInfo['file']." (line {$dbgInfo['line']})\n\n");
			/* -> {$dbgInfo['function']}(".join(",",$dbgInfo['args']).")$NL"; */
		}
		error_log("Debug backtrace end");
	}


}

/**
 * Thrown when an API call returns an exception.
 *
 * @author <a href="mailto:anguenot@sofungaming.com">Julien Anguenot</a>
 *
 */
class SofunApiException extends Exception {

	/**
	 * The result from the API server that represents the exception information.
	 */
	protected $result = "";

	/**
	 * Exception's type.
	 */
	protected $type = "";

	/**
	 * Make a new API Exception with the given result.
	 *
	 * @param Array $result the result from the API server
	 */
	public function __construct($result) {

		if (is_array($result) && !empty($result)) {
			$this->result = $result;
			$code = isset($result['error_code']) ? $result['error_code'] : 0;
			$msg = (isset($result['error']) && isset($result['error']['message'])) ? $result['error']['message'] : "Unknown error";
		} else {
			error_log("Information to construct Sofun API Exception not provided.");
		}

		parent::__construct($msg, $code);

	}

	/**
	 * Return the associated result object returned by the API server.
	 *
	 * @returns Array the result from the API server
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * Returns the associated type for the error. This will default to
	 * 'Exception' when a type is not available.
	 *
	 * @return String
	 */
	public function getType() {

		if (isset($this->result['error'])) {
			$error = $this->result['error'];
			if (is_string($error)) {
				return $error;
			} else if (is_array($error)) {
				if (isset($error['type'])) {
					return $error['type'];
				}
			}
		}

		return 'Exception';
	}

	/**
	 * To make debugging easier.
	 *
	 * @returns String the string representation of the error
	 */
	public function __toString() {
		$str = $this->getType() . ': ';
		if ($this->code != 0) {
			$str .= $this->code . ': ';
		}
		return $str . $this->message;
	}

}

?>

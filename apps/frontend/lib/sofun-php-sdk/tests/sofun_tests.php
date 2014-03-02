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
 *       17 rue Eugene Varlin
 *       75010 Paris
 *       France
 *       p. +33 (0) 6475 70815
 *       www.sofungaming.com
 *
 * @version $Id: sofun_tests.php 12 2011-07-12 00:04:45Z anguenot $
 */

require_once(dirname(__FILE__) . '/simpletest/autorun.php');
require_once('../src/sofun.php');
require_once('../src/oauth/OAuth.php');

function getvalue($string, $start, $end)
{
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}

class SofunSDKTestCase extends UnitTestCase {

	function __construct() {
		parent::__construct('Sofun SDK Test Case.');
	}

	public function testDomain() {
		
		$config = array(
		'consumerId' => 'cac383dba35fb6f7eef12ba8cee504c6',
		'consumerSecret' => '4a85d20e5cbad626a494f75d233cd688',
		'domain' => 'localhost:8080',
		'protocol' => 'http://',
		);

		$sf = new Sofun($config);
		
		$this->assertEqual($config['domain'], $sf->getDomain());
		
		$config = array(
		'consumerId' => 'cac383dba35fb6f7eef12ba8cee504c6',
		'consumerSecret' => '4a85d20e5cbad626a494f75d233cd688',
		'protocol' => 'http://',
		);

		$sf = new Sofun($config);
		
		$this->assertEqual('api.sofungaming.com', $sf->getDomain());
		
	}
	
	public function testGETAPI() {

		$config = array(
		'consumerId' => 'cac383dba35fb6f7eef12ba8cee504c6',
		'consumerSecret' => '4a85d20e5cbad626a494f75d233cd688',
		'domain' => 'localhost:8080',
		'protocol' => 'http://',
		);

		$sf = new Sofun($config);

		$results = $sf->api_GET("/core/info");
		//print_r($results);
		
		
		$info = $results['buffer'];
		$http_code = $results['http_code'];
		
		$this->assertEqual("0.2", $info['version']);
		$this->assertEqual("Sofun Platform", $info['poweredBy']);
		$this->assertEqual("(c) 2011 Sofun Gaming SAS ", $info['copyright']);
		$this->assertEqual("http://www.sofungaming.com", $info['copyrightURL']);
		$this->assertEqual("contact@sofungaming.com", $info['contactEmail']);
		
		
		$this->assertEqual('200', $http_code);
	}
	
	public function testPOSTAPI() {
		
		
		$config = array(
		'consumerId' => 'cac383dba35fb6f7eef12ba8cee504c6',
		'consumerSecret' => '4a85d20e5cbad626a494f75d233cd688',
		'domain' => 'localhost:8080',
		'protocol' => 'http://',
		);

		$sf = new Sofun($config);

		$results = $sf->api_POST("/core/echo", array('msg' => 'sofun'));
		$msg = $results['buffer'];
		$http_code = $results['http_code'];
		
		//print_r($msg);
		
		$this->assertEqual("sofun", $msg['msg']);
		$this->assertEqual('202', $http_code);
		
		
	}
	
	public function testLogin() {
		
		$config = array(
		'consumerId' => 'cac383dba35fb6f7eef12ba8cee504c6',
		'consumerSecret' => '4a85d20e5cbad626a494f75d233cd688',
		'domain' => 'localhost:8080',
		'protocol' => 'http://',
		);

		$sf = new Sofun($config);
		
		$params = array('communityId' => 1,
    					'email' => 'ja@anguenot.org',
    					'password' => 'azerty',
						'birthDay' => '08',
						'birthMonth' => '04',
						'birthYear' => '1981');
		
		$results = $sf->api_POST("/member/login", $params);
		$msg = $results['buffer'];
		$http_code = $results['http_code'];
		
		// Member not found
		$this->assertEqual('400', $http_code);
		
		//print_r($results);
		
	}
	

}

?>
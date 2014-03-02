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
 * @version $Id: all_tests.php 2 2011-05-04 18:06:43Z anguenot $
 */

require_once(dirname(__FILE__) . '/simpletest/autorun.php');
require_once(dirname(__FILE__) . '/sofun_tests.php');

class AllTests extends TestSuite {
	
	function __construct() {
		parent::__construct();
		$this->add(new SofunSDKTestCase());
	}
}

?>
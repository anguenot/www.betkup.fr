<?php

/*
 * Copyright (c)  Sofun Gaming SAS.
 * Copyright (c)  Julien Anguenot <julien@anguenot.org>
 * Copyright (c)  Julien De Preaumont <juliendepreaumont@gmail.com>
 *
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 *
 * Contributors:
 *     Julien Anguenot <julien@anguenot.org> - initial API and implementation
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
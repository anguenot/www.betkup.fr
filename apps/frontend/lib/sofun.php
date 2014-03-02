<?php

/**
 * Sofun App Wrapper.
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: sofun.php 5532 2012-07-03 14:27:42Z anguenot $
 */
class SofunAPIHelper {

	static function get() {
		$config = array(
            'consumerId' => sfConfig::get('app_sofun_consumer_key'),
            'consumerSecret' => sfConfig::get('app_sofun_consumer_secret'),
            'domain' => sfConfig::get('app_sofun_domain'),
        	'protocol' => sfConfig::get('app_sofun_protocol'),
		);

		$sofun =  new Sofun($config);
		$sofun->init();
		return $sofun;
	}
}

?>
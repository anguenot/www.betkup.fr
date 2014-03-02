<?php

/**
 * Filter keeping track of partner's tracking code.
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: trackingFilter.class.php 6443 2012-11-12 13:39:11Z jmasmejean $
 */
class TrackingFilter extends sfFilter {

	private static $LOG_KEY = "TrackingFilter : ";

	public function execute($filterChain) {
		$response = $this->getContext()->getResponse();
		if ($this->isFirstCall()) {
			$context = $this->getContext();
			$request = $context->getRequest();

			$trackingCode = $request->getParameter(sfConfig::get('app_tracking_filter_param_name'), '');
			if ($trackingCode != '') {
				$context->getLogger()->info(TrackingFilter::$LOG_KEY . " Setting tracking cookie w/ value=" . $trackingCode);
				// Set cookie with tracking code (Valid for 30 days)
				$response->setcookie(sfConfig::get('app_tracking_filter_cookie_name'), $trackingCode, $_SERVER['REQUEST_TIME']+60*60*24*30, '/', $request->getHost(), false);
			}

            $trackingRegistationSimple = $context->getUser()->getAttribute(sfConfig::get('app_tracking_filter_registration_simple_complete'), '', 'tracking_filter');
            if($trackingRegistationSimple == 'success') {

                $trackingConfig = $this->getTrankingYAMLConfigModule();
                $adWordsTrackings = isset($trackingConfig['adwords_trackings']) ? $trackingConfig['adwords_trackings'] : array();

                if(count($adWordsTrackings) > 0) {
                    foreach($adWordsTrackings as $componentName) {
                        $context->getLogger()->info(TrackingFilter::$LOG_KEY . " Setting tracking cookie after registration simple w/ value=" . $componentName.'_simpleAccount');
                        // Set cookie with tracking code (Valid for 30 days)
                        $response->setcookie($componentName.'_simpleAccount', "first-view", $_SERVER['REQUEST_TIME']+60*60*24*30, '/', $request->getHost(), false);
                    }
                }
            }

            $trackingRegistationAdvanced = $context->getUser()->getAttribute(sfConfig::get('app_tracking_filter_registration_advanced_complete'), '', 'tracking_filter');
            if($trackingRegistationAdvanced == 'success') {

                $trackingConfig = $this->getTrankingYAMLConfigModule();
                $adWordsTrackings = isset($trackingConfig['adwords_trackings']) ? $trackingConfig['adwords_trackings'] : array();

                if(count($adWordsTrackings) > 0) {
                    foreach($adWordsTrackings as $componentName) {
                        $context->getLogger()->info(TrackingFilter::$LOG_KEY . " Setting tracking cookie after registration advanced w/ value=" . $componentName.'_simpleAccount');
                        // Set cookie with tracking code (Valid for 30 days)
                        $response->setcookie($componentName.'_advancedAccount', "first-view", $_SERVER['REQUEST_TIME']+60*60*24*30, '/', $request->getHost(), false);
                    }
                }
            }

		}
		$filterChain->execute();
	}

    /**
     * Get the config for tracking module.
     *
     * @return array|string
     */
    private function getTrankingYAMLConfigModule() {

        $cacheKey = 'tracking_module_config';
        $config = sfMemcache::getInstance()->get($cacheKey, array());
        if(empty($config)) {
            $module_dir = sfConfig::get('sf_app_module_dir');
            $module_name = 'tracking';
            $data = 'config';
            $module = sfYaml::load($module_dir . '/' . $module_name . '/' . $data . '/module.yml');
            $config = $module['all'];
            if(!empty($config)) {
                sfMemcache::getInstance()->set($cacheKey, $config, 0, 0);
            }
        }
        return $config;
    }

}

?>
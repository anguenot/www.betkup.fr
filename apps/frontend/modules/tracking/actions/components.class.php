<?php
    /*
     * @package     betkup.fr
     * @subpackage
     * @author      Sofun Gaming SAS
     * @version     svn:$Id: components.class.php 6443 2012-11-12 13:39:11Z jmasmejean $
     */
    class trackingComponents extends sfComponents {

        /**
         * Display the tracking code for google adWords after register forms.
         *
         * This one is for "Pierre" tracking. #BETKUP-1990
         *
         * @param sfWebRequest $request
         */
        public function executeTrackingNbaPierre(sfWebRequest $request) {
            $response = $this->getContext()->getResponse();
            $this->cookieName = "";
            $trackingConfig = $this->getTrankingYAMLConfigModule();
            $this->trackingNamePrefix = $trackingConfig['adwords_trackings']['nba_pierre'];

            if (isset($_COOKIE[$this->trackingNamePrefix . '_simpleAccount']) && $_COOKIE[$this->trackingNamePrefix . '_simpleAccount'] == "first-view") {
                $this->cookieName = $this->trackingNamePrefix . '_simpleAccount';
                $response->setcookie($this->trackingNamePrefix. '_simpleAccount', "repeat-view", (time() + 60 * 60 * 24 * 30), "/", $request->getHost(), false);
                $this->getUser()->setAttribute(sfConfig::get('app_tracking_filter_registration_simple_complete'), 'done', 'tracking_filter');
            }
            else if (isset($_COOKIE[$this->trackingNamePrefix . '_advancedAccount']) && $_COOKIE[$this->trackingNamePrefix . '_advancedAccount'] == "first-view") {
                $this->cookieName = $this->trackingNamePrefix . '_advancedAccount';
                $response->setcookie($this->trackingNamePrefix. '_advancedAccount', "repeat-view", (time() + 60 * 60 * 24 * 30), "/", $request->getHost(), false);
                $this->getUser()->setAttribute(sfConfig::get('app_tracking_filter_registration_advanced_complete'), 'done', 'tracking_filter');
            }

        }

        /**
         * Display all tracking adWords codes.
         *
         * @param sfWebRequest $request
         */
        public function executeTrackings() {
            $moduleConfig = $this->getTrankingYAMLConfigModule();
            $this->trackingConfig = $moduleConfig['adwords_trackings'];
        }

        /**
         * Get the config for tracking module.
         *
         * @return array|string
         */
        private function getTrankingYAMLConfigModule() {

            $cacheKey = 'tracking_module_config';
            $config = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($config)) {
                $module_dir = sfConfig::get('sf_app_module_dir');
                $module_name = 'tracking';
                $data = 'config';
                $module = sfYaml::load($module_dir . '/' . $module_name . '/' . $data . '/module.yml');
                $config = $module['all'];
                if (!empty($config)) {
                    sfMemcache::getInstance()->set($cacheKey, $config, 0, 0);
                }
            }
            return $config;
        }
    }

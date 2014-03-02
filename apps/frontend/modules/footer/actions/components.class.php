<?php

    /**
     * Footer components.
     *
     * @package    betkup.fr
     * @subpackage footer
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: components.class.php 6539 2012-11-22 14:27:10Z jmasmejean $
     */
    class footerComponents extends betkupComponents {

        /**
         * Display the footer on each pages.
         *
         * @param sfWebRequest $request
         */
        public function executeFooter(sfWebRequest $request) {
            if (sfConfig::get('app_profile') == sfConfig::get('app_profile_free')) {
                $this->cguUrl = sfConfig::get('app_url_cgu_free');
                $this->rulesUrl = sfConfig::get('app_url_rule_free');
            }
            else if (sfConfig::get('app_profile') == sfConfig::get('app_profile_gambling')) {
                $this->cguUrl = sfConfig::get('app_url_cgu_gambling');
                $this->rulesUrl = sfConfig::get('app_url_rule_gambling');
            }

            $this->actionsExcludedForVideo = array('landingPage');
            $this->currentAction = $request->getParameter('action', '');
            $this->showVideo = true;
            if (in_array($this->currentAction, $this->actionsExcludedForVideo)) {
                $this->showVideo = false;
            }
        }

        public function executeTweets() {

        }

        public function executeThumbnailTweet() {
            if (!isset($this->tweet)) {
                $this->tweet = array();
            }
        }

    }
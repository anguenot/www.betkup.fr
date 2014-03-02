<?php

    /**
     * Home components.
     *
     * @package    betkup.fr
     * @subpackage kup
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: components.class.php 6171 2012-09-24 14:34:43Z jmasmejean $
     */
    class homeComponents extends sfComponents {

        public function executeFacebook() {

        }

        /**
         * Display the box "Ready to play" when the user is authenticated.
         */
        public function executeReadyToPlayHomeBox() {

        }

        public function executeLive() {

        }

        public function executeQuotes() {

        }

        public function executeQuote() {

        }

        public function executePress() {

        }

        public function executeReference() {

        }

        public function executeRegister() {

        }

        public function executeSlide() {

        }

        public function executeRanking() {

        }

        public function executeFeed() {

        }

        /**
         *  Display the winners tab on landing page.
         */
        public function executeLandingWinners() {
            if (!isset($this->winnersData) || $this->winnersData == '') {
                $this->winnersData = array();
            }
        }

        /**
         * Display the kups tab on landing page.
         */
        public function executeLandingKups() {
            if (!isset($this->kupsData) || $this->kupsData == '') {
                $this->kupsData = array();
            }
        }

    }
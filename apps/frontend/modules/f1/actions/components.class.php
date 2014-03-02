<?php

    /**
     * f1 components.
     *
     * @package    betkup.fr
     * @subpackage f1
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: actions.class.php 4078 2012-03-08 19:07:13Z jmasmejean $
     */
    class f1Components extends betkupComponents {

        /**
         * Displays a custom prediction's page view for F1.
         */
        public function executePredictions(sfWebRequest $request) {

            if (!isset($this->urlToPublish)) {
                $this->urlToPublish = '';
            }
            if (!isset($this->kupData)) {
                $this->kupData = null;
            }
            if (!isset($this->kup_uuid)) {
                $this->kup_uuid = '';
            }
            if (!isset($this->room_uuid)) {
                $this->room_uuid = '';
            }
            if (!isset($this->roomUI)) {
                $this->roomUI = array();
            }

            $this->kupRoundsData = $this->getKupRoundsData($request, $this->kup_uuid);

            $this->canSavePredictionsGrid = $this->canSavePredictionsGrid($request, $this->kupData, $this->kupRoundsData);
            $this->canSavePredictionsRace = $this->canSavePredictionsRace($request, $this->kupData, $this->kupRoundsData);
        }

        /**
         * Displays a custom result's page view for F1.
         */
        public function executeResults() {
            if (!isset($this->kup_uuid)) {
                $this->kup_uuid = '';
            }
            if (!isset($this->room_uuid)) {
                $this->room_uuid = '';
            }
            if (!isset($this->urlToPublish)) {
                $this->urlToPublish = '';
            }
            if (!isset($this->kupData)) {
                $this->kupData = array();
            }
            if (!isset($this->fnResizeCanvas)) {
                $this->fnResizeCanvas = '';
            }
        }

        /**
         * Displays driver element info for best lap popup on predictions's page.
         */
        public function executeBestLapPopupDriver() {
        }

        /**
         * Displays rules for Free 2012 Kups
         */
        public function executeKup_2012_free_rules() {
        }

        /**
         * Displays rules for Gambling 2012 Kups
         */
        public function executeKup_2012_gambling_rules() {
        }

        /**
         * Can a player save a prediction on the qualification?
         *
         * @param $request
         */
        private function canSavePredictionsGrid($request, $kupData, $kupRoundsData) {
            $allowed = false;
            $roundName = $kupData['config']['qualiRoundName'];
            foreach ($kupRoundsData as $round) {
                if ($round['name'] == $roundName) {
                    if ($round['status'] == 'SCHEDULED') {
                        // Double check if the status is wrong platform side.
                        date_default_timezone_set('UTC');
                        $timeNow = time() . '000';
                        $start_date = $round['startDate'];
                        if ($start_date > $timeNow) {
                            $allowed = true;
                        }
                    }
                }
            }
            return $allowed;
        }

        /**
         * Can a player save a prediction on the race?
         *
         * @param $request
         */
        private function canSavePredictionsRace($request, $kupData, $kupRoundsData) {
            $allowed = false;
            $roundName = $kupData['config']['raceRoundName'];
            foreach ($kupRoundsData as $round) {
                if ($round['name'] == $roundName) {
                    if ($round['status'] == 'SCHEDULED') {
                        // Double check if the status is wrong platform side.
                        date_default_timezone_set('UTC');
                        $timeNow = time() . '000';
                        $start_date = $round['startDate'];
                        if ($start_date > $timeNow) {
                            $allowed = true;
                        }
                    }
                }
            }
            return $allowed;
        }

    }

?>
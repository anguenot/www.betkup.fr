<?php
    /**
     * f1 actions.
     *
     * @package    betkup.fr
     * @subpackage f1
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: actions.class.php 6398 2012-10-31 15:35:43Z jmasmejean $
     */
    class f1Actions extends betkupActions {

        /**
         * Displays GP ranking predictions page.
         *
         *  <p>
         *
         *  Handles POST when players saves.
         *
         * @param sfWebRequest $request
         */
        public function executePredictionsRanking(sfWebRequest $request) {
            $this->kup_uuid = $request->getParameter('kup_uuid', '');
            $this->room_uuid = $request->getParameter('room_uuid', '');
            $this->urlToPublish = $request->getParameter('publish_url', '');
            $this->roomUI = $request->getParameter('roomUI', array());

            if ($request->isXmlHttpRequest()) {
                if ($this->urlToPublish == '') {
                    if ($this->room_uuid == '') {
                        $this->urlToPublish = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                        'module'  => 'kup',
                                                                                                                        'action'  => 'view',
                                                                                                                        'uuid'    => $this->kup_uuid
                                                                                                                   ));
                    }
                    else {
                        $this->urlToPublish = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                        'module'    => 'room',
                                                                                                                        'action'    => 'kup',
                                                                                                                        'room_uuid' => $this->room_uuid,
                                                                                                                        'kup_uuid'  => $this->kup_uuid
                                                                                                                   ));
                    }
                }
                if ($request->getMethod() == 'POST') {

                    $predictions = $request->getParameter('predictions', '');
                    $this->getUser()->setAttribute('ranking_is_draft', '1', 'predictionsSave');
                    $this->getUser()->setAttribute('predictionsRanking', $predictions, 'predictionsSave');
                    $this->getUser()->setAttribute('kup_uuid', $this->kup_uuid, 'predictionsSave');

                    if (!$this->getUser()->isAuthenticated()) {
                        $error = '400';
                        $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_failed_must_login'));
                        return $this->renderText(json_encode(
                            array(
                                 'cerror'       => $error,
                                 'redirect_url' => $this->getController()->genUrl(array(
                                                                                       'module'            => 'account',
                                                                                       'action'            => 'login',
                                                                                       'customRedirectUrl' => $request->getReferer()
                                                                                  ))
                            )
                        ));
                    }

                    $this->kupData = $request->getParameter('kupData', array());
                    $this->kupRoundsData = $request->getParameter('kupRoundsData', array());

                    return $this->renderText($this->savePredictionRanking($request, $this->kup_uuid, $predictions, $this->kupData, $this->kupRoundsData, $this->roomUI));
                }
                else {
                    $this->kupData = $request->getParameter('kupData', array());
                    $this->kupRoundsData = $request->getParameter('kupRoundsData', array());

                    $this->predictions = $this->getF1Predictions($request, $this->kup_uuid, sfConfig::get('mod_f1_prediction_type_ranking'), NULL, $this->kupData);
                    $this->drivers = $this->getF1DriversFilteredBy($this->getF1Drivers($request, $this->kup_uuid, $this->kupData), $this->predictions);

                }
            }
        }

        /**
         * Display ranking predictions area on main predictions page.
         *
         * @param sfWebRequest $request
         */
        public function executeHomePredictionsRanking(sfWebRequest $request) {
            if ($request->isXmlHttpRequest()) {
                $this->kup_uuid = $request->getParameter('kup_uuid', '');
                $this->predictions = array();
                $this->lastModified = NULL;
                if ($this->getUser()->isAuthenticated()) {
                    $this->kupData = $request->getParameter('kupData', array());
                    $this->predictions = $this->getF1Predictions($request, $this->kup_uuid, sfConfig::get('mod_f1_prediction_type_ranking'), NULL, $this->kupData);
                    $this->lastModified = isset($this->predictions['lastModified']) ? $this->predictions['lastModified'] : NULL;
                }
            }
        }

        /**
         * Displays grid predictions page.
         *
         *  <p>
         *
         *  Handles POST when players saves.
         *
         * @param sfWebRequest $request
         */
        public function executePredictionsGrid(sfWebRequest $request) {
            $this->kup_uuid = $request->getParameter('kup_uuid', '');
            $this->room_uuid = $request->getParameter('room_uuid', '');
            $this->urlToPublish = $request->getParameter('publish_url', '');
            $this->kupData = $request->getParameter('kupData', array());
            $this->roomUI = $request->getParameter('roomUI', array());

            if ($request->isXmlHttpRequest()) {
                if ($this->urlToPublish == '') {
                    if ($this->room_uuid == '') {
                        $this->urlToPublish = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                        'module'  => 'kup',
                                                                                                                        'action'  => 'view',
                                                                                                                        'uuid'    => $this->kup_uuid
                                                                                                                   ));
                    }
                    else {
                        $this->urlToPublish = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                        'module'    => 'room',
                                                                                                                        'action'    => 'kup',
                                                                                                                        'room_uuid' => $this->room_uuid,
                                                                                                                        'kup_uuid'  => $this->kup_uuid
                                                                                                                   ));
                    }
                }
                $this->maxDisplay = 4;
                if (isset($this->kupData['type']) && $this->kupData['type'] == sfConfig::get('mod_f1_kup_type_gambling_fr')) {
                    $this->maxDisplay = 3;
                }

                if ($request->getMethod() == 'POST') {

                    $predictions = $request->getParameter('predictions', '');
                    $this->getUser()->setAttribute('grid_is_draft', '1', 'predictionsSave');
                    $this->getUser()->setAttribute('predictionsGrid', $predictions, 'predictionsSave');
                    $this->getUser()->setAttribute('kup_uuid', $this->kup_uuid, 'predictionsSave');

                    if (!$this->getUser()->isAuthenticated()) {
                        $error = '400';
                        $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_failed_must_login'));
                        return $this->renderText(json_encode(
                            array(
                                 'cerror'       => $error,
                                 'redirect_url' => $this->getController()->genUrl(array(
                                                                                       'module'            => 'account',
                                                                                       'action'            => 'login',
                                                                                       'customRedirectUrl' => $request->getReferer()
                                                                                  ))
                            )
                        ));
                    }
                    $this->kupRoundsData = $request->getParameter('kupRoundsData', array());

                    return $this->renderText($this->savePredictionGrid($request, $this->kup_uuid, $predictions, $this->kupData, $this->kupRoundsData, $this->roomUI));
                }
                else {
                    $this->kupRoundsData = $request->getParameter('kupRoundsData', array());

                    $this->predictions = $this->getF1Predictions($request, $this->kup_uuid, sfConfig::get('mod_f1_prediction_type_grid'), NULL, $this->kupData);
                    $this->drivers = $this->getF1DriversFilteredBy($this->getF1Drivers($request, $this->kup_uuid, $this->kupData), $this->predictions);
                }
            }
        }

        /**
         * Display grid predictions area on main predictions page.
         *
         * @param sfWebRequest $request
         */
        public function executeHomePredictionsGrid(sfWebRequest $request) {
            if ($request->isXmlHttpRequest()) {

                $this->kup_uuid = $request->getParameter('kup_uuid', '');
                $this->kupData = $request->getParameter('kupData', array());

                $this->maxDisplay = 4;
                if (isset($this->kupData['type']) && $this->kupData['type'] == sfConfig::get('mod_f1_kup_type_gambling_fr')) {
                    $this->maxDisplay = 3;
                }

                $this->predictions = array();
                $this->lastModified = NULL;
                if ($this->getUser()->isAuthenticated()) {
                    $this->predictions = $this->getF1Predictions($request, $this->kup_uuid, sfConfig::get('mod_f1_prediction_type_grid'), NULL, $this->kupData);
                    $this->lastModified = isset($this->predictions['lastModified']) ? $this->predictions['lastModified'] : NULL;
                }
            }
        }

        /**
         * Displays best lap predictions area on predictions view.
         *
         * <p>
         *
         * Handles POST when players saves.
         *
         * @param sfWebRequest $request
         */
        public function executeHomePredictionsBestLap(sfWebRequest $request) {
            $this->kup_uuid = $request->getParameter('kup_uuid', '');
            $this->room_uuid = $request->getParameter('room_uuid', '');
            $this->urlToPublish = $request->getParameter('publish_url', '');
            $this->roomUI = $request->getParameter('roomUI', array());

            if ($request->isXmlHttpRequest()) {
                $this->lastModified = NULL;
                if ($this->urlToPublish == '') {
                    if ($this->room_uuid == '') {
                        $this->urlToPublish = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                        'module'  => 'kup',
                                                                                                                        'action'  => 'view',
                                                                                                                        'uuid'    => $this->kup_uuid
                                                                                                                   ));
                    }
                    else {
                        $this->urlToPublish = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                        'module'    => 'room',
                                                                                                                        'action'    => 'kup',
                                                                                                                        'room_uuid' => $this->room_uuid,
                                                                                                                        'kup_uuid'  => $this->kup_uuid
                                                                                                                   ));
                    }
                }
                if ($request->getMethod() == 'POST') {

                    $driver_uuid = $request->getParameter('prediction', '');
                    $predictions = array(0 => $driver_uuid);
                    $this->getUser()->setAttribute('best_lap_is_draft', '1', 'predictionsSave');
                    $this->getUser()->setAttribute('predictionsBestLap', $predictions, 'predictionsSave');
                    $this->getUser()->setAttribute('kup_uuid', $this->kup_uuid, 'predictionsSave');

                    if (!$this->getUser()->isAuthenticated()) {
                        $error = '400';
                        $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_failed_must_login'));
                        return $this->renderText(json_encode(
                            array(
                                 'cerror'       => $error,
                                 'redirect_url' => $this->getController()->genUrl(array(
                                                                                       'module'            => 'account',
                                                                                       'action'            => 'login',
                                                                                       'customRedirectUrl' => $request->getReferer()
                                                                                  ))
                            )
                        ));
                    }
                    else {
                        $this->kupData = $request->getParameter('kupData', array());
                        $this->kupRoundsData = $request->getParameter('kupRoundsData', array());

                        return $this->renderText($this->savePredictionBestLap($request, $this->kup_uuid, $predictions, $this->kupData, $this->kupRoundsData, $this->roomUI));
                    }
                }
                else {
                    $this->kupData = $request->getParameter('kupData', array());
                    $this->kupRoundsData = $request->getParameter('kupRoundsData', array());

                    $this->drivers = $this->getF1Drivers($request, $this->kup_uuid, $this->kupData);
                    $this->canSavePredictionsRace = $this->canSavePredictionsRace($request, $this->kupData, $this->kupRoundsData);
                    $this->predictions = array();

                    $this->predictions = $this->getF1Predictions($request, $this->kup_uuid, sfConfig::get('mod_f1_prediction_type_bestlap'), NULL, $this->kupData);
                    $this->lastModified = isset($this->predictions['lastModified']) ? $this->predictions['lastModified'] : NULL;

                }
            }
        }

        /**
         * Display results grid page fragment on results page.
         *
         * @param sfWebRequest $request
         */
        public function executeResultsGrid(sfWebRequest $request) {

            $this->kup_uuid = $request->getParameter('kup_uuid', '');
            $this->room_uuid = $request->getParameter('room_uuid', '');
            $this->filter = $request->getParameter('filter', array());
            $this->kupData = $request->getParameter('kupData', array());

            $this->maxResults = 4;
            if ($this->kupData['type'] == sfConfig::get('mod_f1_kup_type_gambling_fr')) {
                $this->maxResults = 3;
            }

            if ($request->isXmlHttpRequest()) {
                if (isset($this->filter['results_kups']) && $this->filter['results_kups'] != '') {
                    $this->kup_uuid = $this->filter['results_kups'];
                }

                // Get official results.
                $cacheKey = 'betkup_f1_results_grid_for_'.$this->room_uuid.'_' . $this->kup_uuid;
                $this->resultsGrid = sfMemcache::getInstance()->get($cacheKey, array());

                if (empty($this->resultsGrid)) {
                    $this->resultsGrid = $this->getF1Results($request, $this->kupData, $this->kup_uuid, sfConfig::get('mod_f1_prediction_type_grid'));
                    sfMemcache::getInstance()->set($cacheKey, $this->resultsGrid, 0, $this->getResultsCacheTimeFor($this->kupData));
                }

                // Get user results predictions
                $cacheKey = 'betkup_f1_results_grid_predictions_for_'.$this->room_uuid.'_' . $this->kup_uuid.'_'.$this->getUser()->getAttribute('subscriberId', '', 'subscriber');
                $this->predictions = sfMemcache::getInstance()->get($cacheKey, array());

                if (empty($this->predictions)) {
                    $this->predictions = $this->getF1Predictions($request, $this->kup_uuid, sfConfig::get('mod_f1_prediction_type_grid'), $this->resultsGrid, $this->kupData);
                    sfMemcache::getInstance()->set($cacheKey, $this->predictions, 0, $this->getResultsCacheTimeFor($this->kupData));
                }

                if ($this->room_uuid == '') {
                    $this->urlFacebook = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                   'module'  => 'kup',
                                                                                                                   'action'  => 'results',
                                                                                                                   'uuid'    => $this->kup_uuid
                                                                                                              )) . '#grid';
                }
                else {
                    $this->urlFacebook = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                   'module'    => 'room',
                                                                                                                   'action'    => 'kupResults',
                                                                                                                   'room_uuid' => $this->room_uuid,
                                                                                                                   'kup_uuid'  => $this->kup_uuid
                                                                                                              )) . '#grid';
                }
            }
        }

        /**
         * Display results ranking page fragment on results page.
         *
         * @param sfWebRequest $request
         */
        public function executeResultsRanking(sfWebRequest $request) {

            $this->kup_uuid = $request->getParameter('kup_uuid', '');
            $this->room_uuid = $request->getParameter('room_uuid', '');
            $this->filter = json_decode($request->getParameter('filter', array()));
            $this->kupData = $request->getParameter('kupData', array());

            if ($request->isXmlHttpRequest()) {

                $cacheKey = 'betkup_f1_results_ranking_for_'.$this->room_uuid.'_' . $this->kup_uuid;
                $this->resultsGrid = sfMemcache::getInstance()->get($cacheKey, array());

                if (empty($this->resultsGrid)) {
                    $this->resultsGrid = $this->getF1Results($request, $this->kupData, $this->kup_uuid, sfConfig::get('mod_f1_prediction_type_ranking'));
                    sfMemcache::getInstance()->set($cacheKey, $this->resultsGrid, 0, $this->getResultsCacheTimeFor($this->kupData));
                }

                // Get user results predictions
                $cacheKey = 'betkup_f1_results_ranking_predictions_for_'.$this->room_uuid.'_' . $this->kup_uuid.'_'.$this->getUser()->getAttribute('subscriberId', '', 'subscriber');
                $this->predictions = sfMemcache::getInstance()->get($cacheKey, array());

                if (empty($this->predictions)) {
                    $this->predictions = $this->getF1Predictions($request, $this->kup_uuid, sfConfig::get('mod_f1_prediction_type_ranking'), $this->resultsGrid, $this->kupData);
                    sfMemcache::getInstance()->set($cacheKey, $this->predictions, 0, $this->getResultsCacheTimeFor($this->kupData));
                }

                if ($this->room_uuid == '') {
                    $this->urlFacebook = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                   'module'  => 'kup',
                                                                                                                   'action'  => 'results',
                                                                                                                   'uuid'    => $this->kup_uuid
                                                                                                              )) . '#ranking';
                }
                else {
                    $this->urlFacebook = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                   'module'    => 'room',
                                                                                                                   'action'    => 'kupResults',
                                                                                                                   'room_uuid' => $this->room_uuid,
                                                                                                                   'kup_uuid'  => $this->kup_uuid
                                                                                                              )) . '#ranking';
                }
                // "Bonus Podium" check is frontend side
                $this->isBonus = 0;
                $bonus = 0;
                for ($i = 0; $i < 3; $i++) {
                    if (isset($this->resultsGrid[$i]) && isset($this->predictions[$i]) && $this->resultsGrid[$i]['uuid'] == $this->predictions[$i]['uuid']) {
                        $bonus++;
                    }
                }
                if ($bonus == 3) {
                    $this->isBonus = 1;
                }
            }
        }

        /**
         * Display best lap result page fragment on results page.
         *
         * @param sfWebRequest $request
         */
        public function executeResultsBestLap(sfWebRequest $request) {

            $this->kup_uuid = $request->getParameter('kup_uuid', '');
            $this->room_uuid = $request->getParameter('room_uuid', '');
            $this->kupData = $request->getParameter('kupData', array());
            $this->filter = $request->getParameter('filter', array());

            if ($request->isXmlHttpRequest()) {
                if (isset($this->filter['results_kups']) && $this->filter['results_kups'] != '') {
                    $this->kup_uuid = $this->filter['results_kups'];
                }

                // Get official results.
                $cacheKey = 'betkup_f1_results_bestlap_for_'.$this->room_uuid.'_' . $this->kup_uuid;
                $this->results = sfMemcache::getInstance()->get($cacheKey, array());

                if (empty($this->results)) {
                    $this->results = $this->getF1Results($request, $this->kupData, $this->kup_uuid, sfConfig::get('mod_f1_prediction_type_bestlap'));
                    sfMemcache::getInstance()->set($cacheKey, $this->results, 0, $this->getResultsCacheTimeFor($this->kupData));
                }

                // Get user results predictions
                $cacheKey = 'betkup_f1_results_bestlap_predictions_for_'.$this->room_uuid.'_' . $this->kup_uuid.'_'.$this->getUser()->getAttribute('subscriberId', '', 'subscriber');
                $this->predictions = sfMemcache::getInstance()->get($cacheKey, array());

                if (empty($this->predictions)) {
                    $this->predictions = $this->getF1Predictions($request, $this->kup_uuid, sfConfig::get('mod_f1_prediction_type_bestlap'), $this->results, $this->kupData);
                    sfMemcache::getInstance()->set($cacheKey, $this->predictions, 0, $this->getResultsCacheTimeFor($this->kupData));
                }

            }
        }

        /**
         * Retrieve the cache timestamp to put results in cache.
         *
         * @param $kupData
         *
         * @return int
         */
        private function getResultsCacheTimeFor($kupData) {
            $cacheTime = 3600; // 1h
            if($kupData != null) {
                if(isset($kupData['status']) && isset($kupData['type'])) {
                    if($kupData['type'] == sfConfig::get('mod_f1_kup_type_free')) {
                        if($kupData['status'] >= 4 || $kupData['status'] == -1) {
                            $cacheTime = 0;
                        }
                    } else {
                        if($kupData['status'] >= 5 || $kupData['status'] == -1) {
                            $cacheTime = 0;
                        }
                    }
                }
            }
            return $cacheTime;
        }

        /**
         * Display results total points page fragment on results page.
         *
         * @param sfWebRequest $request
         */
        public function executeResultsTotalPoint(sfWebRequest $request) {
            $this->kup_uuid = $request->getParameter('kup_uuid', '');
            $this->room_uuid = $request->getParameter('room_uuid', '');
            $this->filter = $request->getParameter('filter', array());
            $this->kupData = $request->getParameter('kupData', array());
            $roomUI = $request->getParameter('roomUI', array());

            if ($request->isXmlHttpRequest()) {

                $cacheKey = 'betkup_f1_results_total_points_for_'.$this->room_uuid.'_' . $this->kup_uuid.'_'.$this->getUser()->getAttribute('subscriberId', '', 'subscriber');
                $this->totalPoints = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($this->totalPoints)) {
                    $this->totalPoints = $this->getKupTotalPointsFor($request, $this->kupData);
                    sfMemcache::getInstance()->set($cacheKey, $this->totalPoints, 0, $this->getResultsCacheTimeFor($this->kupData));
                }
                if ($this->room_uuid == '') {
                    $this->urlFacebook = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                   'module'  => 'kup',
                                                                                                                   'action'  => 'results',
                                                                                                                   'uuid'    => $this->kup_uuid
                                                                                                              )) . '#totalpoints';
                }
                else {
                    $this->urlFacebook = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                   'module'    => 'room',
                                                                                                                   'action'    => 'kupResults',
                                                                                                                   'room_uuid' => $this->room_uuid,
                                                                                                                   'kup_uuid'  => $this->kup_uuid
                                                                                                              )) . '#totalpoints';
                }
            }
        }

        /**
         * Save predictions for grid
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param array        $predictions
         *
         * @return JSON
         */
        private function savePredictionGrid(sfWebRequest $request, $kup_uuid, $predictions, $kupData = array(), $kupRoundsData = array(), $roomUI = array()) {
            //XXX Use the new saveF1Prediction function to save all F1 types and adapt it to return json to template.

            $payload = array(
                isset($predictions['podium_1']) ? $predictions['podium_1'] : '',
                isset($predictions['podium_2']) ? $predictions['podium_2'] : '',
                isset($predictions['podium_3']) ? $predictions['podium_3'] : '',
                isset($predictions['podium_4']) ? $predictions['podium_4'] : '',
            );

            $seasonID = $kupData['config']['seasonID'];
            $stageName = $kupData['config']['stageName'];
            $roundName = $kupData['config']['qualiRoundName'];

            // Another check to make sure predictions are still allowed.
            if (!$this->canSavePredictionsGrid($request, $kupData, $kupRoundsData)) {
                return json_encode(array(
                                        'cerror' => '400',
                                   ));
            }

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            $params = array(
                'communityId'                                => sfConfig::get('app_sofun_community_id'),
                'type'                                       => sfConfig::get('mod_f1_prediction_type_grid'),
                sfConfig::get('mod_f1_prediction_type_grid') => $payload,
                'seasonId'                                   => $seasonID,
                'stageName'                                  => $stageName,
                'roundName'                                  => $roundName,
            );
            try {
                $email = $this->getUser()->getAttribute('email', '', 'subscriber');
                $response = $sofun->api_POST("/kup/" . $kup_uuid . "/member/" . $email . "/predictions/add", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }
            if ($response["http_code"] != "202") {
                error_log($response['buffer']);
            }
            $this->getUser()->setAttribute('grid_is_draft', '0', 'predictionsSave');
            $facebookMessage = $this->getFacebookPublishMessageF1For($request, $kup_uuid, $payload, $kupData);

            $prizeValue = '-';
            if (isset($roomUI['kups']) && isset($roomUI['kups'][$kupData['uuid']]) && isset($roomUI['kups'][$kupData['uuid']]['prize_value']) && $roomUI['kups'][$kupData['uuid']]['prize_value'] != '') {

                $prizeValue = $roomUI['kups'][$kupData['uuid']]['prize_value'];
            }
            else if (isset($kupData['ui']) && isset($kupData['ui']['prizeValue']) && $kupData['ui']['prizeValue'] != '') {
                $prizeValue = $kupData['ui']['prizeValue'];
            }
            else if ($kupData['jackpot'] != '') {
                $prizeValue = $kupData['jackpot'];
            }

            return json_encode(array(
                                    'cerror'             => $response["http_code"],
                                    'predictionFacebook' => $facebookMessage,
                                    'messagePublish'     => $this->getContext()->getI18n()->__('message_publish_predictions_f1_grid', array(
                                                                                                                                           '%kup_name%'  => $kupData['name'],
                                                                                                                                           '%prize%'     => $prizeValue . ' €'
                                                                                                                                      ))
                               ));
        }

        /**
         * Save predictions for Best lap
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param array        $predictions
         *
         * @return JSON
         */
        private function savePredictionBestLap(sfWebRequest $request, $kup_uuid, $predictions, $kupData = array(), $kupRoundsData = array(), $roomUI = array()) {
            //XXX Use the new saveF1Prediction function to save all F1 types and adapt it to return json to template.

            $seasonID = $kupData['config']['seasonID'];
            $stageName = $kupData['config']['stageName'];
            $roundName = $kupData['config']['raceRoundName'];

            // Another check to make sure predictions are still allowed.
            if (!$this->canSavePredictionsRace($request, $kupData, $kupRoundsData)) {
                return json_encode(array(
                                        'cerror' => '400',
                                   ));
            }

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            $params = array(
                'communityId'                                   => sfConfig::get('app_sofun_community_id'),
                'type'                                          => sfConfig::get('mod_f1_prediction_type_bestlap'),
                sfConfig::get('mod_f1_prediction_type_bestlap') => $predictions,
                'seasonId'                                      => $seasonID,
                'stageName'                                     => $stageName,
                'roundName'                                     => $roundName,
            );
            try {
                $email = $this->getUser()->getAttribute('email', '', 'subscriber');
                $response = $sofun->api_POST("/kup/" . $kup_uuid . "/member/" . $email . "/predictions/add", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }
            if ($response["http_code"] != "202") {
                error_log($response['buffer']);
            }
            $this->getUser()->setAttribute('best_lap_is_draft', '0', 'predictionsSave');
            $facebookMessage = $this->getFacebookPublishMessageF1For($request, $kup_uuid, $predictions, $kupData);

            $prizeValue = '-';
            if (isset($roomUI['kups']) && isset($roomUI['kups'][$kupData['uuid']]) && isset($roomUI['kups'][$kupData['uuid']]['prize_value']) && $roomUI['kups'][$kupData['uuid']]['prize_value'] != '') {

                $prizeValue = $roomUI['kups'][$kupData['uuid']]['prize_value'];
            }
            else if (isset($kupData['ui']) && isset($kupData['ui']['prizeValue']) && $kupData['ui']['prizeValue'] != '') {
                $prizeValue = $kupData['ui']['prizeValue'];
            }
            else if ($kupData['jackpot'] != '') {
                $prizeValue = $kupData['jackpot'];
            }

            return json_encode(array(
                                    'cerror'             => $response["http_code"],
                                    'predictionFacebook' => $facebookMessage,
                                    'messagePublish'     => $this->getContext()->getI18n()->__('message_publish_predictions_f1_best_lap', array(
                                                                                                                                               '%kup_name%'  => $kupData['name'],
                                                                                                                                               '%prize%'     => $prizeValue . ' €'
                                                                                                                                          ))
                               ));

        }

        /**
         * Save prediction for ranking
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param array        $predictions
         *
         * @return JSON
         */
        private function savePredictionRanking(sfWebRequest $request, $kup_uuid, $predictions, $kupData = array(), $kupRoundsData = array(), $roomUI = array()) {
            //XXX Use the new saveF1Prediction function to save all F1 types and adapt it to return json to template.

            $payload = array(
                $predictions['podium_1'],
                $predictions['podium_2'],
                $predictions['podium_3'],
                $predictions['podium_4'],
                $predictions['podium_5'],
                $predictions['podium_6'],
                $predictions['podium_7'],
                $predictions['podium_8'],
                $predictions['podium_9'],
                $predictions['podium_10'],
            );

            $seasonID = $kupData['config']['seasonID'];
            $stageName = $kupData['config']['stageName'];
            $roundName = $kupData['config']['raceRoundName'];

            // Another check to make sure predictions are still allowed.
            if (!$this->canSavePredictionsRace($request, $kupData, $kupRoundsData)) {
                return json_encode(array(
                                        'cerror' => '400',
                                   ));
            }

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            $params = array(
                'communityId'                                   => sfConfig::get('app_sofun_community_id'),
                'type'                                          => sfConfig::get('mod_f1_prediction_type_ranking'),
                sfConfig::get('mod_f1_prediction_type_ranking') => $payload,
                'seasonId'                                      => $seasonID,
                'stageName'                                     => $stageName,
                'roundName'                                     => $roundName,
            );
            try {
                $email = $this->getUser()->getAttribute('email', '', 'subscriber');
                $response = $sofun->api_POST("/kup/" . $kup_uuid . "/member/" . $email . "/predictions/add", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }
            if ($response["http_code"] != "202") {
                error_log($response['buffer']);
            }
            $this->getUser()->setAttribute('ranking_is_draft', '0', 'predictionsSave');
            $facebookMessage = $this->getFacebookPublishMessageF1For($request, $kup_uuid, $payload, $kupData);

            $prizeValue = '-';
            if (isset($roomUI['kups']) && isset($roomUI['kups'][$kupData['uuid']]) && isset($roomUI['kups'][$kupData['uuid']]['prize_value']) && $roomUI['kups'][$kupData['uuid']]['prize_value'] != '') {

                $prizeValue = $roomUI['kups'][$kupData['uuid']]['prize_value'];
            }
            else if (isset($kupData['ui']) && isset($kupData['ui']['prizeValue']) && $kupData['ui']['prizeValue'] != '') {
                $prizeValue = $kupData['ui']['prizeValue'];
            }
            else if ($kupData['jackpot'] != '') {
                $prizeValue = $kupData['jackpot'];
            }

            return json_encode(array(
                                    'cerror'             => $response["http_code"],
                                    'predictionFacebook' => $facebookMessage,
                                    'messagePublish'     => $this->getContext()->getI18n()->__('message_publish_predictions_f1_ranking', array(
                                                                                                                                              '%kup_name%'  => $kupData['name'],
                                                                                                                                              '%prize%'     => $prizeValue . ' €'
                                                                                                                                         ))
                               ));

        }

        /**
         * Returns the total points for the current logged in player.
         *
         */
        private function getKupTotalPointsFor($request, $kupData) {
            $totalPoints = '-';
            if (!empty($kupData) && isset($kupData['status']) && $kupData['status'] != -1 && $kupData['status'] > 3) {
                $ranking = $this->getKupRanking($request, $kupData['uuid'], 0, 2);
                if (!empty($ranking) && isset($ranking['totalPoints'])) {
                    $totalPoints = $ranking['totalPoints'];
                }
                else {
                    $totalPoints = 0;
                }
            }
            return $totalPoints;
        }

        /**
         * Returns a message that will be used within a Facebook publish when a player just saved a prediction.
         *
         * @param $request
         * @param $kup_uuid
         * @param $predictions
         */
        private function getFacebookPublishMessageF1For($request, $kup_uuid, $predictions, $kupData = array()) {
            $message = array();
            $i = 1;
            foreach ($predictions as $prediction) {
                $sufix = 'ème'; // XXX i18n
                if ($i == 1) {
                    $sufix = 'er'; // XXX i18n
                }
                $driver = 'Aucun pronostic'; // XXX i18n
                if ($prediction != '') {
                    $driver = $this->getF1DriverByUUID($request, $kup_uuid, $prediction, $kupData);
                    $driver = $driver['driver'];
                }
                $message[$i . $sufix] = $driver;
                $i++;
            }
            return $message;
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
                $round = (array)$round;
                if ($round['name'] == $roundName) {
                    if ($round['status'] == 'SCHEDULED') {
                        // We can have cached data here. We need to check start date.
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
                $round = (array)$round;
                if ($round['name'] == $roundName) {
                    if ($round['status'] == 'SCHEDULED') {
                        // We can have cached data here. We need to check start date.
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

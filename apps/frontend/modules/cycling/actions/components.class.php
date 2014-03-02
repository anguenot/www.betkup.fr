<?php

    /**
     * cycling components.
     *
     * @package    betkup.fr
     * @subpackage cycling
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: components.class.php 6050 2012-09-03 10:19:20Z jmasmejean $
     */
    class cyclingComponents extends betkupComponents {

        /**
         * Predictions component for cycling
         *
         * @param sfWebRequest $request
         */
        public function executePredictions(sfWebRequest $request) {

            if (!isset($this->kupData)) {
                $this->kupData = null;
            }
            if (!isset($this->kup_uuid)) {
                $this->kup_uuid = '';
            }
            if (!isset($this->room_uuid)) {
                $this->room_uuid = '';
            }

            $this->kupRoundsData = $this->getKupRoundsData($request, $this->kup_uuid);
            if ($this->kupRoundsData > 1) {
                $this->roundUUID = $request->getParameter('roundUUID', '');
                if ($this->roundUUID == '') {
                    foreach ($this->kupRoundsData as $roundData) {
                        if ($roundData['startDate'] > time() . '000') {
                            $this->kupRoundData = $roundData;
                            $this->roundUUID = $roundData['uuid'];
                            break;
                        }
                    }
                    if ($this->roundUUID == '') {
                        $this->kupRoundData = $this->kupRoundsData[0];
                        $this->roundUUID = $this->kupRoundsData[0]['uuid'];
                    }
                }
                else {
                    foreach ($this->kupRoundsData as $roundData) {
                        if ($roundData['uuid'] == $this->roundUUID) {
                            $this->kupRoundData = $roundData;
                        }
                    }
                }
            }
            else {
                $this->kupRoundData = $this->kupRoundsData[0];
                $this->roundUUID = $this->kupRoundsData[0]['uuid'];
            }

            $this->racers = $this->getSeasonPlayers($request, $this->kupData['config']['seasonID']);
            $this->teams = $this->getSeasonTeams($request, $this->kupData['config']['seasonID']);

            if ($request->isMethod('post')) {

                if ($request->getParameter('predictions_tdf_maillot_jaune', '') != '') {
                    $this->predictionsTdfMaillotJaune = $request->getParameter('predictions_tdf_maillot_jaune', '');
                    if (isset($this->predictionsTdfMaillotJaune['tdf_maillot_jaune'])) {
                        $predictionsTdfMaillotJauneCyclist = array($this->predictionsTdfMaillotJaune['tdf_maillot_jaune']);
                    }
                }
                if ($request->getParameter('predictions_tdf_maillot_blanc', '') != '') {
                    $this->predictionsTdfMaillotBlanc = $request->getParameter('predictions_tdf_maillot_blanc', '');
                    if (isset($this->predictionsTdfMaillotBlanc['tdf_maillot_blanc'])) {
                        $predictionsTdfMaillotBlancCyclist = array($this->predictionsTdfMaillotBlanc['tdf_maillot_blanc']);
                    }
                }
                if ($request->getParameter('predictions_tdf_maillot_vert', '') != '') {
                    $this->predictionsTdfMaillotVert = $request->getParameter('predictions_tdf_maillot_vert', '');
                    if (isset($this->predictionsTdfMaillotVert['tdf_maillot_vert'])) {
                        $predictionsTdfMaillotVertCyclist = array($this->predictionsTdfMaillotVert['tdf_maillot_vert']);
                    }
                }
                if ($request->getParameter('predictions_tdf_maillot_apois', '') != '') {
                    $this->predictionsTdfMaillotApois = $request->getParameter('predictions_tdf_maillot_apois', '');
                    if (isset($this->predictionsTdfMaillotApois['tdf_maillot_apois'])) {
                        $predictionsTdfMaillotApoisCyclist = array($this->predictionsTdfMaillotApois['tdf_maillot_apois']);
                    }
                }
                if ($request->getParameter('predictions_tdf_podium_individual', '') != '') {
                    $this->predictionsTdfPodiumIndividual = $request->getParameter('predictions_tdf_podium_individual', '');
                    $predictionsTdfPodiumIndividualCyclists = array();
                    if (count($this->predictionsTdfPodiumIndividual) > 0) {
                        $predictionsTdfPodiumIndividualCyclists[0] = isset($this->predictionsTdfPodiumIndividual['podium_individual_1']) ? $this->predictionsTdfPodiumIndividual['podium_individual_1'] : '';
                        $predictionsTdfPodiumIndividualCyclists[1] = isset($this->predictionsTdfPodiumIndividual['podium_individual_2']) ? $this->predictionsTdfPodiumIndividual['podium_individual_2'] : '';
                        $predictionsTdfPodiumIndividualCyclists[2] = isset($this->predictionsTdfPodiumIndividual['podium_individual_3']) ? $this->predictionsTdfPodiumIndividual['podium_individual_3'] : '';
                    }
                }
                if ($request->getParameter('predictions_tdf_podium_team', '') != '') {
                    $this->predictionsTdfPodiumTeam = $request->getParameter('predictions_tdf_podium_team', '');
                    $predictionsTdfPodiumTeamTeams = array();
                    if (count($this->predictionsTdfPodiumTeam) > 0) {
                        $predictionsTdfPodiumTeamTeams[0] = isset($this->predictionsTdfPodiumTeam['podium_team_1']) ? $this->predictionsTdfPodiumTeam['podium_team_1'] : '';
                        $predictionsTdfPodiumTeamTeams[1] = isset($this->predictionsTdfPodiumTeam['podium_team_2']) ? $this->predictionsTdfPodiumTeam['podium_team_2'] : '';
                        $predictionsTdfPodiumTeamTeams[2] = isset($this->predictionsTdfPodiumTeam['podium_team_3']) ? $this->predictionsTdfPodiumTeam['podium_team_3'] : '';
                    }
                }

                // Save predictions.
                $predictionsTdfMaillotJauneSave = $this->saveCyclingPredictions($request, sfConfig::get('mod_cycling_prediction_type_cycling_maillot_jaune'), $this->kup_uuid, $predictionsTdfMaillotJauneCyclist, $this->kupData, $this->kupRoundData);
                $predictionsTdfMaillotBlancSave = $this->saveCyclingPredictions($request, sfConfig::get('mod_cycling_prediction_type_cycling_maillot_blanc'), $this->kup_uuid, $predictionsTdfMaillotBlancCyclist, $this->kupData, $this->kupRoundData);
                $predictionsTdfMaillotVertSave = $this->saveCyclingPredictions($request, sfConfig::get('mod_cycling_prediction_type_cycling_maillot_vert'), $this->kup_uuid, $predictionsTdfMaillotVertCyclist, $this->kupData, $this->kupRoundData);
                $predictionsTdfMaillotApoisSave = $this->saveCyclingPredictions($request, sfConfig::get('mod_cycling_prediction_type_cycling_maillot_apois'), $this->kup_uuid, $predictionsTdfMaillotApoisCyclist, $this->kupData, $this->kupRoundData);

                $predictionsTdfPodiumIndividualSave = $this->saveCyclingPredictions($request, sfConfig::get('mod_cycling_prediction_type_cycling_podium_individual'), $this->kup_uuid, $predictionsTdfPodiumIndividualCyclists, $this->kupData, $this->kupRoundData);
                $predictionsTdfPodiumTeamSave = $this->saveCyclingPredictions($request, sfConfig::get('mod_cycling_prediction_type_cycling_podium_team'), $this->kup_uuid, $predictionsTdfPodiumTeamTeams, $this->kupData, $this->kupRoundData);

                // Format back for UI
                $this->predictions = array_merge($this->predictionsTdfMaillotJaune, $this->predictionsTdfMaillotBlanc, $this->predictionsTdfMaillotVert, $this->predictionsTdfMaillotApois, $this->predictionsTdfPodiumIndividual, $this->predictionsTdfPodiumTeam);

                if ($predictionsTdfMaillotJauneSave == false || $predictionsTdfMaillotBlancSave == false
                    || $predictionsTdfMaillotVertSave == false
                    || $predictionsTdfMaillotApoisSave == false
                    || $predictionsTdfPodiumIndividualSave == false
                    || $predictionsTdfPodiumTeamSave == false
                ) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_failed'));
                }
                else {
                    if ($this->kupData != null && isset($this->kupData['type']) && $this->kupData['type'] == sfConfig::get('mod_kup_type_gambling_fr')) {
                        $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_gambling_kup_bet'));
                    }
                    if (isset($this->redirect_url) && $this->redirect_url != '') {
                        $this->getController()->redirect($this->redirect_url);
                    }
                    else if ($this->room_uuid != 0) {
                        $this->getController()->redirect(array(
                                                              'module'    => 'room',
                                                              'action'    => 'kupBet',
                                                              'kup_uuid'  => $this->kup_uuid,
                                                              'room_uuid' => $this->room_uuid,
                                                              'hasPreds'  => 1
                                                         ));
                    }
                    else {
                        $this->getController()->redirect(array(
                                                              'module'   => 'kup',
                                                              'action'   => 'bet',
                                                              'uuid'     => $this->kup_uuid,
                                                              'hasPreds' => 1
                                                         ));
                    }
                }
            }
            else {

                $this->predictionsTdfMaillotJaune = array();
                $this->predictionsTdfMaillotBlanc = array();
                $this->predictionsTdfMaillotVert = array();
                $this->predictionsTdfMaillotApois = array();
                $this->predictionsTdfPodiumIndividual = array();
                $this->predictionsTdfPodiumTeam = array();

                if ($this->getUser()->isAuthenticated()) {

                    $prediction = $this->getCyclingPredictions($request, $this->kup_uuid, sfConfig::get('mod_cycling_prediction_type_cycling_maillot_jaune'), array(), $this->kupData, array('roundUUID' => $this->roundUUID));
                    if (isset($prediction['uuid'])) {
                        $this->predictionsTdfMaillotJaune['tdf_maillot_jaune'] = $prediction['uuid'];
                    }
                    $prediction = $this->getCyclingPredictions($request, $this->kup_uuid, sfConfig::get('mod_cycling_prediction_type_cycling_maillot_blanc'), array(), $this->kupData, array('roundUUID' => $this->roundUUID));
                    if (isset($prediction['uuid'])) {
                        $this->predictionsTdfMaillotBlanc['tdf_maillot_blanc'] = $prediction['uuid'];
                    }
                    $prediction = $this->getCyclingPredictions($request, $this->kup_uuid, sfConfig::get('mod_cycling_prediction_type_cycling_maillot_vert'), array(), $this->kupData, array('roundUUID' => $this->roundUUID));
                    if (isset($prediction['uuid'])) {
                        $this->predictionsTdfMaillotVert['tdf_maillot_vert'] = $prediction['uuid'];
                    }
                    $prediction = $this->getCyclingPredictions($request, $this->kup_uuid, sfConfig::get('mod_cycling_prediction_type_cycling_maillot_apois'), array(), $this->kupData, array('roundUUID' => $this->roundUUID));
                    if (isset($prediction['uuid'])) {
                        $this->predictionsTdfMaillotApois['tdf_maillot_apois'] = $prediction['uuid'];
                    }
                    $prediction = $this->getCyclingPredictions($request, $this->kup_uuid, sfConfig::get('mod_cycling_prediction_type_cycling_podium_individual'), array(), $this->kupData, array('roundUUID' => $this->roundUUID));
                    $this->predictionsTdfPodiumIndividual = array();
                    $this->predictionsTdfPodiumIndividual['tdf_podium_individual_1'] = array();
                    $this->predictionsTdfPodiumIndividual['tdf_podium_individual_2'] = array();
                    $this->predictionsTdfPodiumIndividual['tdf_podium_individual_3'] = array();
                    if (count($prediction) > 0) {
                        $this->predictionsTdfPodiumIndividual['tdf_podium_individual_1'] = array('tdf_podium_individual' => isset($prediction[0]['uuid']) ? $prediction[0]['uuid'] : '');
                    }
                    if (count($prediction) > 1) {
                        $this->predictionsTdfPodiumIndividual['tdf_podium_individual_2'] = array('tdf_podium_individual' => isset($prediction[1]['uuid']) ? $prediction[1]['uuid'] : '');
                    }
                    if (count($prediction) > 2) {
                        $this->predictionsTdfPodiumIndividual['tdf_podium_individual_3'] = array('tdf_podium_individual' => isset($prediction[2]['uuid']) ? $prediction[2]['uuid'] : '');
                    }

                    $prediction = $this->getCyclingPredictions($request, $this->kup_uuid, sfConfig::get('mod_cycling_prediction_type_cycling_podium_team'), array(), $this->kupData, array('roundUUID' => $this->roundUUID));

                    $this->predictionsTdfPodiumTeam = array();
                    $this->predictionsTdfPodiumTeam['tdf_podium_team_1'] = array();
                    $this->predictionsTdfPodiumTeam['tdf_podium_team_2'] = array();
                    $this->predictionsTdfPodiumTeam['tdf_podium_team_3'] = array();
                    if (count($prediction) > 0) {
                        $this->predictionsTdfPodiumTeam['tdf_podium_team_1'] = array('tdf_podium_team' => isset($prediction[0]['uuid']) ? $prediction[0]['uuid'] : '');
                    }
                    if (count($prediction) > 1) {
                        $this->predictionsTdfPodiumTeam['tdf_podium_team_2'] = array('tdf_podium_team' => isset($prediction[1]['uuid']) ? $prediction[1]['uuid'] : '');
                    }
                    if (count($prediction) > 2) {
                        $this->predictionsTdfPodiumTeam['tdf_podium_team_3'] = array('tdf_podium_team' => isset($prediction[2]['uuid']) ? $prediction[2]['uuid'] : '');
                    }

                }

            }
            $predictionsList = array(
                $this->predictionsTdfMaillotJaune, $this->predictionsTdfMaillotBlanc,
                $this->predictionsTdfMaillotVert, $this->predictionsTdfMaillotApois,
                $this->predictionsTdfPodiumIndividual, $this->predictionsTdfPodiumTeam
            );
            $this->publishProperties = $this->getFacebookPublishMessageFor($request, $this->kup_uuid, $predictionsList, $this->kupData);
            $this->getUser()->setAttribute('publishProperties', $this->publishProperties, 'userPredictions');
        }

        /**
         * Returns a message that will be used within a Facebook publish when a player just saved a prediction.
         *
         * @param $request
         * @param $kup_uuid
         * @param $predictions
         */
        private function getFacebookPublishMessageFor($request, $kup_uuid, $predictionsList, $kupData = array()) {
            $message = array();
            if (count($predictionsList > 0)) {
                foreach ($predictionsList as $predictions) {
                    foreach ($predictions as $key => $prediction) {
                        if ($key == 'tdf_maillot_jaune') {
                            $racer = $this->getF1DriverByUUID($request, $kup_uuid, $prediction, $kupData);
                            $message['Maillot Jaune'] = $racer['driver'];
                        }
                        else if ($key == 'tdf_maillot_blanc') {
                            $racer = $this->getF1DriverByUUID($request, $kup_uuid, $prediction, $kupData);
                            $message['Maillot Blanc'] = $racer['driver'];
                        }
                        else if ($key == 'tdf_maillot_vert') {
                            $racer = $this->getF1DriverByUUID($request, $kup_uuid, $prediction, $kupData);
                            $message['Maillot Vert'] = $racer['driver'];
                        }
                        else if ($key == 'tdf_maillot_apois') {
                            $racer = $this->getF1DriverByUUID($request, $kup_uuid, $prediction, $kupData);
                            $message['Maillot à Pois'] = $racer['driver'];
                        }
                        else if ($key == 'tdf_podium_individual_1') {
                            $racer = $this->getF1DriverByUUID($request, $kup_uuid, isset($prediction['tdf_podium_individual']) ? $prediction['tdf_podium_individual'] : '', $kupData);
                            $message['1er (individuel)'] = $racer['driver'];
                        }
                        else if ($key == 'tdf_podium_individual_2') {
                            $racer = $this->getF1DriverByUUID($request, $kup_uuid, isset($prediction['tdf_podium_individual']) ? $prediction['tdf_podium_individual'] : '', $kupData);
                            $message['2eme (individuel)'] = $racer['driver'];
                        }
                        else if ($key == 'tdf_podium_individual_3') {
                            $racer = $this->getF1DriverByUUID($request, $kup_uuid, isset($prediction['tdf_podium_individual']) ? $prediction['tdf_podium_individual'] : '', $kupData);
                            $message['3eme (individuel)'] = $racer['driver'];
                        }
                        else if ($key == 'tdf_podium_team_1') {
                            $team = $this->getF1TeamByUUID($request, $kup_uuid, isset($prediction['tdf_podium_team']) ? $prediction['tdf_podium_team'] : '', $kupData);
                            $message['1er (Equipe)'] = $team['name'];
                        }
                        else if ($key == 'tdf_podium_team_2') {
                            $team = $this->getF1TeamByUUID($request, $kup_uuid, isset($prediction['tdf_podium_team']) ? $prediction['tdf_podium_team'] : '', $kupData);
                            $message['2eme (Equipe)'] = $team['name'];
                        }
                        else if ($key == 'tdf_podium_team_3') {
                            $team = $this->getF1TeamByUUID($request, $kup_uuid, isset($prediction['tdf_podium_team']) ? $prediction['tdf_podium_team'] : '', $kupData);
                            $message['3eme (Equipe)'] = $team['name'];
                        }
                    }
                }
            }
            return $message;
        }

        /**
         * Prediction question for cycling
         */
        public function executePredictionJersey() {
        }

        /**
         * Prediction jersey for cycling
         */
        public function executePredictionQuestion() {
        }

        /**
         * Prediction choice for cycling
         */
        public function executePredictionChoice() {
            if (!isset($this->title)) {
                $this->title = '';
            }
            if (!isset($this->value)) {
                $this->value = '';
            }
            if (!isset($this->imgDefault)) {
                $this->imgDefault = '/image/default/tdf/jersey/maillot_default.png';
            }
            if (!isset($this->imgSize)) {
                $this->imgSize = '87x103';
            }
            $this->predictionJerseyImg = '';
            $this->jerseyList = array();
            foreach ($this->choices as $choice) {
                $this->jerseyList[$choice['uuid']] = '';
                if (isset($this->predictions[$this->prefix . '_' . $this->type]) && $this->predictions[$this->prefix . '_' . $this->type] == $choice['uuid']) {
                    if ($this->class == 'racers') {
                        $this->predictionJerseyImg = isset($choice['properties']['teams'][0]) ? '/image/default/tdf/jersey/' . str_replace(array(
                                                                                                                                                ' ',
                                                                                                                                                '-'
                                                                                                                                           ), '_', $choice['properties']['teams'][0]['name']) . '.png' : $this->imgDefault;
                    }
                    else {
                        $this->predictionJerseyImg = isset($choice['name']) ? '/image/default/tdf/team/' . str_replace(array(
                                                                                                                            ' ',
                                                                                                                            '-'
                                                                                                                       ), '_', $choice['name']) . '.png' : $this->imgDefault;
                    }
                }
                if ($this->class == 'racers') {
                    if (isset($choice['teams']) && isset($choice['teams'][0])) {
                        $this->jerseyList[$choice['uuid']] = '/image/default/tdf/jersey/' . str_replace(array(
                                                                                                             ' ',
                                                                                                             '-'
                                                                                                        ), '_', $choice['teams'][0]['name']) . '.png';
                    }
                }
                else {
                    $this->jerseyList[$choice['uuid']] = '/image/default/tdf/team/' . str_replace(array(
                                                                                                       ' ',
                                                                                                       '-'
                                                                                                  ), '_', $choice['name']) . '.png';

                }
            }
        }

        /**
         * Prediction podium for cycling
         */
        public function executePredictionPodium() {
            if (!isset($this->podiumTitle)) {
                $this->podiumTitle = '';
            }
        }

        /**
         * Prediction podium team for cycling
         */
        public function executePredictionPodiumTeam() {
            if (!isset($this->podiumTitle)) {
                $this->podiumTitle = '';
            }
        }

        /**
         * Show results component page.
         *
         * @param sfWebRequest $request
         */
        public function executeResults(sfWebRequest $request) {

            if (!isset($this->kupData)) {
                $this->kupData = array();
            }
            if (!isset($this->kup_uuid)) {
                $this->kup_uuid = '';
            }
            if (!isset($this->room_uuid)) {
                $this->room_uuid = '';
            }

            if (isset($this->roomKups)) {

                $cacheKey = 'facebook_tdf_results_room_kups_rounds_data';
                $this->kupRoundsData = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($this->kupRoundsData)) {
                    foreach ($this->roomKups as $key => $roomKup) {
                        $roundKupData = $this->getKupRoundsData($request, $roomKup['uuid']);
                        $this->kupRoundsData[$key] = $roundKupData[0];
                    }
                    if (!empty($this->kupRoundsData)) {
                        sfMemcache::getInstance()->set($cacheKey, $this->kupRoundsData);
                    }
                }
            }
            else {
                $this->kupRoundsData = $this->getKupRoundsData($request, $this->kup_uuid);
            }

            if (count($this->kupRoundsData) > 1) {
                $this->roundUUID = $request->getParameter('roundUUID', '');
                if ($this->roundUUID == '') {
                    foreach ($this->kupRoundsData as $key => $roundData) {
                        if ($roundData['startDate'] > time() . '000') {
                            $this->kupRoundData = $roundData;
                            $this->roundUUID = $roundData['uuid'];
                            if (isset($this->roomKups)) {
                                $this->kupData = $this->roomKups[$key];
                                $this->kup_uuid = $this->kupData['uuid'];
                            }
                            break;
                        }
                    }
                    if ($this->roundUUID == '') {
                        $this->kupRoundData = $this->kupRoundsData[0];
                        $this->roundUUID = $this->kupRoundsData[0]['uuid'];
                        if (isset($this->roomKups)) {
                            $this->kupData = $this->roomKups[0];
                            $this->kup_uuid = $this->kupData['uuid'];
                        }
                    }
                }
                else {
                    foreach ($this->kupRoundsData as $key => $roundData) {
                        if ($roundData['uuid'] == $this->roundUUID) {
                            $this->kupRoundData = $roundData;
                            if (isset($this->roomKups)) {
                                $this->kupData = $this->roomKups[$key];
                                $this->kup_uuid = $this->kupData['uuid'];
                            }
                        }
                    }
                }
            }
            else {
                $this->kupRoundData = $this->kupRoundsData[0];
                $this->roundUUID = $this->kupRoundsData[0]['uuid'];
                if (isset($this->roomKups)) {
                    $this->kupData = $this->roomKups[0];
                    $this->kup_uuid = $this->kupData['uuid'];
                }
            }


            $maillotJaune = $this->getResults($request,
                $this->kupData,
                $this->kup_uuid,
                sfConfig::get('mod_cycling_prediction_type_cycling_maillot_jaune'),
                array(
                     'class'    => 'jersey-yellow',
                     'typeName' => 'Maillot jaune'
                ),
                $this->roundUUID);

            $maillotVert = $this->getResults($request,
                $this->kupData,
                $this->kup_uuid,
                sfConfig::get('mod_cycling_prediction_type_cycling_maillot_vert'),
                array(
                     'class'    => 'jersey-green',
                     'typeName' => 'Maillot Vert'
                ),
                $this->roundUUID);

            $mailloApois = $this->getResults($request,
                $this->kupData,
                $this->kup_uuid,
                sfConfig::get('mod_cycling_prediction_type_cycling_maillot_apois'),
                array(
                     'class'    => 'jersey-pink',
                     'typeName' => 'Maillot à pois'
                ),
                $this->roundUUID);

            $maillotBlanc = $this->getResults($request,
                $this->kupData,
                $this->kup_uuid,
                sfConfig::get('mod_cycling_prediction_type_cycling_maillot_blanc'),
                array(
                     'class'    => 'jersey-white',
                     'typeName' => 'Maillot blanc'
                ),
                $this->roundUUID);

            $this->resultsJersey = array_merge($maillotJaune, $maillotVert, $mailloApois, $maillotBlanc);

            $this->resultsPodiumIndividual = $this->getResults($request,
                $this->kupData,
                $this->kup_uuid,
                sfConfig::get('mod_cycling_prediction_type_cycling_podium_individual'),
                array(),
                $this->roundUUID);

            $this->resultsPodiumTeam = $this->getResults($request,
                $this->kupData,
                $this->kup_uuid,
                sfConfig::get('mod_cycling_prediction_type_cycling_podium_team'),
                array(),
                $this->roundUUID);

        }

        /**
         * Get jersey results by type.
         *
         * @param sfWebRequest $request
         * @param array        $kupData
         * @param number       $kup_uuid
         * @param string       $type
         * @param array        $params
         *
         * @return array
         */
        private function getResults($request, $kupData, $kup_uuid, $type, $params = array(), $roundUUID) {

            $results = array();
            $coreResults = $this->getCyclingResults($request, $kupData, $kup_uuid, $type, $roundUUID);
            $corePredictions = $this->getCyclingPredictions($request, $kup_uuid, $type, array(), $kupData, array('roundUUID' => $roundUUID));
            if (!empty($coreResults)) {
                if ($type != sfConfig::get('mod_cycling_prediction_type_cycling_podium_individual') && $type != sfConfig::get('mod_cycling_prediction_type_cycling_podium_team')) {
                    $i = 0;
                    foreach ($coreResults as $result) {
                        $results[$i] = $result;
                        $results[$i]['class'] = isset($params['class']) ? $params['class'] : '';
                        $results[$i]['typeName'] = isset($params['typeName']) ? $params['typeName'] : '';
                        $results[$i]['predictions'] = isset($corePredictions[$i]) ? $corePredictions[$i] : $corePredictions;
                        $i++;
                    }
                }
                else {
                    $i = 0;
                    foreach ($coreResults as $result) {
                        $results[$i] = $result;
                        $results[$i]['class'] = isset($params['class']) ? $params['class'] : '';
                        $results[$i]['typeName'] = isset($params['typeName']) ? $params['typeName'] : '';
                        $results[$i]['predictions'] = isset($corePredictions[$i]) ? $corePredictions[$i] : $corePredictions;
                        $i++;
                    }
                }
            }

            return $results;
        }

        /**
         * XXX
         * Enter description here ...
         */
        private function getCombos() {
        }

        public function executeResultRow() {
            if (!isset($this->class)) {
                $this->class = '';
            }
            if (!isset($this->comboLabel)) {
                $this->comboLabel = '';
            }
        }

        public function executeKup_2012_tdf_etape_etape_rules() {
        }

        public function executeKup_2012_tdf_grande_boucle_rules() {
        }

        public function executeKup_2012_tdf_e_rules() {
        }

    }
<?php
    /**
     * k8 components.
     *
     * @package    betkup.fr
     * @subpackage f1
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: components.class.php 6459 2012-11-16 10:34:11Z jmasmejean $
     */
    class k8Components extends betkupComponents {

        /**
         * Display K8 custom prediction's page.
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
            if (!isset($this->name)) {
                $this->name = $this->kupData['name'];
            }

            $this->roundUUID = $request->getParameter('roundUUID', '');

            $this->kupRoundsData = $this->getKupRoundsData($request, $this->kup_uuid);
            if ($this->roundUUID == '') {
                if (count($this->kupRoundsData) > 0) {
                    $this->roundUUID = $this->getRoundUUID($request, $this->kup_uuid, $this->kupRoundsData);
                }
            }
            $this->kupGamesData = $this->getKupGamesData($request, $this->kup_uuid, $this->roundUUID, false, '');
            $this->lastModified = $this->getPredictionsLastModified($request, $this->kup_uuid);

            // Member saves predictions. No need to retrieve them.
            if ($request->isMethod('post')) {

                $this->predictions_ic = $request->getParameter('predictions_ic', array());
                $this->predictions_se = array();
                $this->predictions_q = array();
                $this->predictions_tb = $request->getParameter('predictions_tb', array());

                // Stores predictions in user's session. Used to display publish messages and possibly for offline users.
                $this->getUser()->setAttribute('predictions_ic', $this->predictions_ic, 'predictionsSave');
                $this->getUser()->setAttribute('predictions_tb', $this->predictions_tb, 'predictionsSave');

                if ($this->getUser()->isAuthenticated()) {
                    $this->savePredictions($request, $this->kup_uuid, $this->predictions_ic, $this->predictions_se, $this->predictions_q, array(), array(), $this->predictions_tb);
                    if ($this->kupData != null && isset($this->kupData['type']) && $this->kupData['type'] == sfConfig::get('mod_kup_type_gambling_fr')) {
                        $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_gambling_kup_bet'));
                    }

                    if ($this->room_uuid != 0) {
                        sfContext::getInstance()->getController()->redirect($this->getController()->genUrl(array(
                                                                                                                'module'    => 'room',
                                                                                                                'action'    => 'kupBet',
                                                                                                                'kup_uuid'  => $this->kup_uuid,
                                                                                                                'room_uuid' => $this->room_uuid,
                                                                                                                'hasPreds'  => 1
                                                                                                           )));
                    }
                    else {
                        sfContext::getInstance()->getController()->redirect($this->getController()->genUrl(array(
                                                                                                                'module'   => 'kup',
                                                                                                                'action'   => 'bet',
                                                                                                                'uuid'     => $this->kup_uuid,
                                                                                                                'hasPreds' => 1
                                                                                                           )));
                    }
                }
                else {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_failed_must_login'));
                    $this->getController()->redirect(array(
                                                          'module'            => 'account',
                                                          'action'            => 'login',
                                                          'customRedirectUrl' => $request->getReferer()
                                                     ));
                }
            }
            else {
                if ($this->getUser()->isAuthenticated()) {
                    // Retrieve predictions
                    $this->predictions_ic = $this->getPredictions($request, $this->kup_uuid, 'ic');
                    if (!empty($this->predictions_ic)) {
                        $this->predictions_ic = $this->predictions_ic[0];
                    }
                    $this->predictions_tb = $this->getPredictions($request, $this->kup_uuid, 'tb');
                    if (!empty($this->predictions_tb)) {
                        $this->predictions_tb = $this->predictions_tb[0];
                    }

                    // We doesn't use these types for K8.
                    $this->predictions_se = array();
                    $this->predictions_q = array();
                }
                else {
                    $this->predictions_ic = array();
                    $this->predictions_tb = array();
                    $this->predictions_se = array();
                    $this->predictions_q = array();
                }
            }
        }

        /**
         * Display K8 custom results' page.
         */
        public function executeResults(sfWebRequest $request) {

            if (!isset($this->kupData)) {
                $this->kupData = null;
            }
            if (!isset($this->kup_uuid)) {
                $this->kup_uuid = '';
            }
            if (!isset($this->room_uuid)) {
                $this->room_uuid = '';
            }

            $this->roundUUID = $request->getParameter('roundUUID', '');
            // Get kup's bettable round's data
            $this->kupRoundsData = $this->getKupRoundsData($request, $this->kup_uuid, array(
                                                                                           'SCHEDULED',
                                                                                           'TERMINATED'
                                                                                      ));

            // Get Kup's bettable game's data
            if ($this->roundUUID == '' && count($this->kupRoundsData) > 0) {
                $this->kupGamesData = $this->getKupGamesData($request, $this->kup_uuid, NULL, false, 'TERMINATED');
                if (count($this->kupRoundsData) > 0) {
                    $this->roundUUID = $this->kupRoundsData[0]['uuid'];
                }
            }
            $this->kupGamesData = $this->getKupGamesData($request, $this->kup_uuid, $this->roundUUID, false, 'TERMINATED');

            // Retrieve member predictions
            $this->predictions_ic = $this->getPredictions($request, $this->kup_uuid, 'ic');
            $this->predictions_se = $this->getPredictions($request, $this->kup_uuid, 'se');
            $this->predictions_q = $this->getPredictions($request, $this->kup_uuid, 'q');
            $this->predictions_tb = $this->getPredictions($request, $this->kup_uuid, 'tb');

            $ok = '/image/default/kup/result/prediction_result_ok.png';
            $ko = '/image/default/kup/result/prediction_result_ko.png';
            $partial = '/image/default/kup/result/prediction_result_partial.png';

            // Add member predictions to game info.
            $offset = 0;
            for ($i = 0; $i < count($this->kupGamesData); $i++) {

                if ($this->kupGamesData[$i]['type'] == 'ic') {

                    if (isset($this->predictions_ic[0][$this->kupGamesData[$i]['uuid']])) {
                        $this->kupGamesData[$i]['prediction'] = $this->predictions_ic[0][$this->kupGamesData[$i]['uuid']];
                    }
                    else {
                        $this->kupGamesData[$i]['prediction'] = $this->getContext()->getI18n()->__('label_no_prediction');
                    }

                    $kupGameData = $this->kupGamesData[$i];
                    if (($kupGameData['prediction'] == 1 && $kupGameData['team1title'] == $kupGameData['winnerTitle'])
                        || ($kupGameData['prediction'] == 3 && $kupGameData['team2title'] == $kupGameData['winnerTitle'])
                        || ($kupGameData['prediction'] == 2 && $kupGameData['winnerTitle'] == $this->getContext()->getI18n()->__('label_prediction_draw'))
                    ) {
                        $this->kupGamesData[$i]['predictionResult'] = $ok;
                    }
                    else {
                        $this->kupGamesData[$i]['predictionResult'] = $ko;
                    }

                    // Mark it with a '-' if the points have not been computed yet.
                    if (isset($this->predictions_ic[2][$this->kupGamesData[$i]['uuid']])
                        && $this->predictions_ic[2][$this->kupGamesData[$i]['uuid']] == 'false'
                    ) {
                        $this->kupGamesData[$i]['points'] = '-';
                    }
                    else {
                        if (isset($this->predictions_ic[1][$this->kupGamesData[$i]['uuid']])) {
                            $this->kupGamesData[$i]['points'] = $this->predictions_ic[1][$this->kupGamesData[$i]['uuid']];
                        }
                        else {
                            $this->kupGamesData[$i]['points'] = 0;
                        }
                    }

                    $offset += 1;

                }
                else if ($this->kupGamesData[$i]['type'] == 'se') {

                    if (isset($this->predictions_se[0][$this->kupGamesData[$i]['uuid'] . '_1']) && isset($this->predictions_se[0][$this->kupGamesData[$i]['uuid'] . '_2'])
                    ) {

                        $prediction = "";
                        $prediction = $prediction . $this->predictions_se[0][$this->kupGamesData[$i]['uuid'] . '_1'];
                        $prediction = $prediction . " - ";
                        $prediction = $prediction . $this->predictions_se[0][$this->kupGamesData[$i]['uuid'] . '_2'];
                        $this->kupGamesData[$i]['prediction'] = $prediction;
                        $this->kupGamesData[$i]['prediction_team1'] = $this->predictions_se[0][$this->kupGamesData[$i]['uuid'] . '_1'];
                        $this->kupGamesData[$i]['prediction_team2'] = $this->predictions_se[0][$this->kupGamesData[$i]['uuid'] . '_2'];

                    }
                    else {

                        $this->kupGamesData[$i]['prediction'] = $this->getContext()->getI18n()->__('label_no_prediction');
                        $this->kupGamesData[$i]['prediction_team1'] = '';
                        $this->kupGamesData[$i]['prediction_team2'] = '';
                    }

                    $kupGameData = $this->kupGamesData[$i];
                    if (intval($kupGameData['scoreTeam1']) == intval($kupGameData['prediction_team1']) && intval($kupGameData['scoreTeam2']) == intval($kupGameData['prediction_team2'])
                    ) {
                        $this->kupGamesData[$i]['predictionResult'] = $ok;
                    }
                    else if (intval($kupGameData['scoreTeam1']) > intval($kupGameData['scoreTeam2']) && intval($kupGameData['prediction_team1']) > intval($kupGameData['prediction_team2'])
                    ) {
                        $this->kupGamesData[$i]['predictionResult'] = $partial;
                    }
                    else if (intval($kupGameData['scoreTeam1']) < intval($kupGameData['scoreTeam2']) && intval($kupGameData['prediction_team1']) < intval($kupGameData['prediction_team2'])
                    ) {
                        $this->kupGamesData[$i]['predictionResult'] = $partial;
                    }
                    else {
                        $this->kupGamesData[$i]['predictionResult'] = $ko;
                    }

                    // Mark it with a '-' if the points have not been computed yet.
                    if (isset($this->predictions_se[2][$this->kupGamesData[$i]['uuid']])
                        && $this->predictions_se[2][$this->kupGamesData[$i]['uuid']] == 'false'
                    ) {
                        $this->kupGamesData[$i]['points'] = '-';
                    }
                    else {
                        if (isset($this->predictions_se[1][$this->kupGamesData[$i]['uuid']])) {
                            $this->kupGamesData[$i]['points'] = $this->predictions_se[1][$this->kupGamesData[$i]['uuid']];
                        }
                        else {
                            $this->kupGamesData[$i]['points'] = 0;
                        }
                    }

                    $offset += 1;

                }
                else if ($this->kupGamesData[$i]['type'] == 'q') {

                    $question = $this->kupGamesData[$i];
                    $coreGame = $this->kupGamesData[$offset - 1];

                    $players = $this->getTeamPlayers($request, $coreGame['team1id']);
                    $players = array_merge($players, $this->getTeamPlayers($request, $coreGame['team2id']));

                    if (isset($this->predictions_q[0][$this->kupGamesData[$offset - 1]['uuid'] . '_' . $this->kupGamesData[$i]['questionId']])) {

                        $prediction = $this->predictions_q[0][$this->kupGamesData[$offset - 1]['uuid'] . '_' . $this->kupGamesData[$i]['questionId']];
                        $this->kupGamesData[$i]['prediction'] = $prediction;

                        $predictionTitle = "";
                        if ($question['label'] == 'label_question_number_of_total_tries_team1') {
                            $predictionTitle = $prediction;
                        }
                        else if ($question['label'] == 'label_question_number_of_total_tries_team2') {
                            $predictionTitle = $prediction;
                        }
                        else if ($question['label'] == 'label_question_first_team_that_tries' || $question['label'] == 'label_question_team_first_scores' || $question['label'] == 'label_question_winner_first_half' || $question['label'] == 'label_question_team_winner_half_time' || $question['label'] == 'label_question_team_winner_second_half' || $question['label'] == 'label_question_winner_second_half' || $question['label'] == 'label_question_which_team_qualifies'
                        ) {
                            if ($prediction == $coreGame['team1id']) {
                                $predictionTitle = $coreGame['team1title'];
                            }
                            else if ($prediction == $coreGame['team2id']) {
                                $predictionTitle = $coreGame['team2title'];
                            }
                            else {
                                $predictionTitle = $this->getContext()->getI18n()->__("label_select_none");
                            }
                        }
                        else if ($question['label'] == 'label_question_first_player_that_tries' || $question['label'] == 'label_question_france_first_player_that_tries'
                            || $question['label'] == 'label_question_first_player_that_scores'
                            || $question['label'] == 'label_question_toulouse_first_player_that_tries'
                            || $question['label'] == 'label_question_clermont_first_player_that_tries'
                            || $question['label'] == 'label_question_ulster_first_player_that_tries'
                            || $question['label'] == 'label_question_top14_final_toulon_first_player_that_tries'
                            || $question['label'] == 'label_question_top14_final_toulouse_first_player_that_tries'
                        ) {
                            if ($prediction == "0") {
                                $predictionTitle = $this->getContext()->getI18n()->__("label_select_none");
                            }
                            else if ($prediction == "-1") {
                                $predictionTitle = $this->getContext()->getI18n()->__('label_no_prediction');
                            }
                            else {
                                $predictionTitle = $this->getPlayerNameByUUID($players, $prediction);
                            }
                            if ($predictionTitle == '') {
                                $predictionTitle = $this->getContext()->getI18n()->__("label_select_none");
                            }
                        }
                        else if ($question['label'] == 'label_question_will_france_scores') {
                            $predictionTitle = $this->getContext()->getI18n()->__($prediction);
                        }
                        else if ($question['label'] == 'label_question_half_with_more_points' || $question['label'] == 'label_question_which_quaters_first_score'
                        ) {
                            if ($prediction == "0") {
                                $predictionTitle = $this->getContext()->getI18n()->__("label_select_none");
                            }
                            else {
                                $predictionTitle = $this->getContext()->getI18n()->__($prediction);
                            }
                        }
                        else if ($question['label'] == 'label_question_more_than_3_tries') {
                            $predictionTitle = $this->getContext()->getI18n()->__($prediction);
                        }
                        else if ($question['label'] == 'label_question_points_difference_end') {
                            $predictionTitle = $this->getContext()->getI18n()->__($prediction);
                        }
                        else {
                            $predictionTitle = $prediction;
                        }

                        $this->kupGamesData[$i]['predictionTitle'] = $this->getContext()->getI18n()->__($predictionTitle);
                    }
                    else {
                        $this->kupGamesData[$i]['prediction'] = "";
                        $this->kupGamesData[$i]['predictionTitle'] = $this->getContext()->getI18n()->__('label_no_prediction');
                    }

                    // Results OK / KO flag

                    if ($this->kupGamesData[$i]['answer'] == $this->kupGamesData[$i]['prediction']) {
                        $this->kupGamesData[$i]['predictionResult'] = $ok;
                    }
                    else if ($question['label'] == 'label_question_first_player_that_scores' && $this->kupGamesData[$i]['prediction'] == "0" && $this->kupGamesData[$i]['answer'] == "-1") {
                        $this->kupGamesData[$i]['predictionResult'] = $ok;
                    }
                    else if ($question['label'] == 'label_question_points_difference_end') {
                        if ($this->kupGamesData[$i]['prediction'] == 'label_less_than_4') {
                            if ($this->kupGamesData[$i]['answer'] > 0 && $this->kupGamesData[$i]['answer'] < 4) {
                                $this->kupGamesData[$i]['predictionResult'] = $ok;
                            }
                        }
                        else if ($this->kupGamesData[$i]['prediction'] == 'label_between_4_and_7') {
                            if ($this->kupGamesData[$i]['answer'] >= 4 && $this->kupGamesData[$i]['answer'] < 8) {
                                $this->kupGamesData[$i]['predictionResult'] = $ok;
                            }
                        }
                        else if ($this->kupGamesData[$i]['prediction'] == 'label_between_8_and_11') {
                            if ($this->kupGamesData[$i]['answer'] >= 8 && $this->kupGamesData[$i]['answer'] <= 11) {
                                $this->kupGamesData[$i]['predictionResult'] = $ok;
                            }
                        }
                        else if ($this->kupGamesData[$i]['prediction'] == 'labe_more_than_11') {
                            if ($this->kupGamesData[$i]['answer'] > 11) {
                                $this->kupGamesData[$i]['predictionResult'] = $ok;
                            }
                        }
                        $this->kupGamesData[$i]['predictionResult'] = $ko;
                    }
                    else {
                        $this->kupGamesData[$i]['predictionResult'] = $ko;
                    }

                    // Mark it with a '-' if the points have not been computed yet.
                    if (isset($this->predictions_q[2][$this->kupGamesData[$offset - 1]['uuid'] . '_' . $this->kupGamesData[$i]['questionId']])
                        && $this->predictions_q[2][$this->kupGamesData[$offset - 1]['uuid'] . '_' . $this->kupGamesData[$i]['questionId']] == 'false'
                    ) {
                        $this->kupGamesData[$i]['points'] = '-';
                    }
                    else {
                        if (isset($this->predictions_q[1][$coreGame['uuid'] . '_' . $this->kupGamesData[$i]['questionId']])) {
                            $this->kupGamesData[$i]['points'] = $this->predictions_q[1][$coreGame['uuid'] . '_' . $this->kupGamesData[$i]['questionId']];
                        }
                        else {
                            $this->kupGamesData[$i]['points'] = 0;
                        }
                    }

                    $offset += 1;
                }
            }
        }

        /**
         * Show result row.
         */
        public function executeResultRow() {
            if (!isset($this->index)) {
                $this->index = 0;
            }
        }

        /**
         * Display tie breaker question for predictions
         */
        public function executePredictionsTieBreaker() {
        }

        /**
         * Display tie breaker question for results
         */
        public function executeResultsTieBreaker() {
            $this->resultsTbPlayerAnswer = NULL;
            if (!empty($this->predictions_tb) && isset($this->predictions_tb[0][$this->kupData['config']['tb']])) {
                $this->resultsTbPlayerAnswer = $this->predictions_tb[0][$this->kupData['config']['tb']];
            }
            $this->resultsTbAnswer = NULL;
            if (count($this->predictions_tb) >= 2 && isset($this->predictions_tb[1][$this->kupData['config']['tb']])) {
                $this->resultsTbAnswer = $this->predictions_tb[1][$this->kupData['config']['tb']];
            }
        }

    }
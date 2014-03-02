<?php

    /**
     * Rugby Components.
     *
     * @package    betkup.fr
     * @subpackage rugby
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: components.class.php 6243 2012-10-10 14:28:51Z anguenot $
     */
    class rugbyComponents extends betkupComponents {

        public function executePredictionFixtures() {
        }

        public function executePredictionKnockout() {
        }

        public function executeKup_wc_2011_coq() {
        }

        public function executeKup_wc_2011_6_nations() {
        }

        public function executeKup_wc_2011_chocs_poules() {
        }

        public function executeKup_wc_2011_la_totale() {
        }

        public function executeKup_wc_2011_match_par_match() {
        }

        public function executeKup_wc_2011_tableau() {
        }

        public function executeKup_wc_2011_blacks_blues() {
        }

        public function executeKup_wc_2011_quarter_finals() {
        }

        public function executeKup_wc_2011_semi_finals_one() {
        }

        public function executeKup_wc_2011_semi_finals_two() {
        }

        public function executeKup_wc_2011_final() {
        }

        public function executeKup_top14_2011_2012() {
        }

        public function executeKup_top14_2012_clermont_toulouse() {
        }

        public function executeKup_top14_2012_toulouse_castres() {
        }

        public function executeKup_top14_2012_clermont_toulon() {
        }

        public function executeKup_top14_2012_castres_montpellier() {
        }

        public function executeKup_top14_2012_toulon_racing() {
        }

        public function executeKup_top14_2012_chocs_1() {
        }

        public function executeKup_top14_2012_finale() {
        }

        public function executeKup_6nations_match_par_match() {
        }

        public function executeKup_6nations_france_italie() {
        }

        public function executeKup_6nations_france_irelande() {
        }

        public function executeKup_6nations_france_england() {
        }

        public function executeKup_6nations_ecosse_france() {
        }

        public function executeKup_6nations_wales_france() {
        }

        public function executeKup_6nations_match_week3() {
        }

        public function executeKup_6nations_match_week4() {
        }

        public function executeKup_6nations_match_week5() {
        }

        public function executeKup_hcup_2012_match_match() {
        }

        public function executeKup_hcup_2012_edimbourg_toulouse() {
        }

        public function executeKup_hcup_2012_saracens_clermont() {
        }

        public function executeKup_hcup_2012_clermont_leister() {
        }

        public function executeKup_hcup_2012_ulster_edimbourg() {
        }

        public function executeKup_hcup_2012_leinster_ulster() {
        }

        /**
         * Display available predictions for a given Kup.
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

            if (count($this->kupGamesData) > 0) {
                $this->hideButtons = true;
                foreach ($this->kupGamesData as $gameData) {
                    if ($gameData['isActive']) {
                        $this->hideButtons = false;
                        break;
                    }
                }
            }
            // Member saves predictions. No need to retrieve them.
            if ($request->isMethod('post')) {

                $this->predictions_ic = $request->getParameter('predictions_ic', array());
                $this->predictions_se = $request->getParameter('predictions_se', array());
                $this->predictions_q = $request->getParameter('predictions_q', array());

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
                                                                                                                'hasPreds' => 1
                                                                                                           )));
                    }
                    else {
                        sfContext::getInstance()->getController()->redirect($this->getController()->genUrl(array(
                                                                                                                'module'  => 'kup',
                                                                                                                'action'  => 'bet',
                                                                                                                'uuid'    => $this->kup_uuid,
                                                                                                                'hasPreds' => 1
                                                                                                           )));
                    }
                }
            }
            else {
                if ($this->getUser()->isAuthenticated()) {
                    // Retrieve predictions
                    $this->predictions_ic = $this->getPredictions($request, $this->kup_uuid, 'ic');
                    if (!empty($this->predictions_ic)) {
                        $this->predictions_ic = $this->predictions_ic[0];
                    }
                    $this->predictions_se = $this->getPredictions($request, $this->kup_uuid, 'se');
                    if (!empty($this->predictions_se)) {
                        $this->predictions_se = $this->predictions_se[0];
                    }
                    $this->predictions_q = $this->getPredictions($request, $this->kup_uuid, 'q');
                    if (!empty($this->predictions_q)) {
                        $this->predictions_q = $this->predictions_q[0];
                    }
                }
                else {
                    $this->predictions_ic = array();
                    $this->predictions_se = array();
                    $this->predictions_q = array();
                }
            }
        }

        /**
         * Show the result component.
         *
         * @param sfWebRequest $request
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
                    if (($kupGameData['prediction'] == 1 && ($kupGameData['team1title'] == $kupGameData['winnerTitle']))
                        || ($kupGameData['prediction'] == 3 && ($kupGameData['team2title'] == $kupGameData['winnerTitle']))
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

                    if (isset($this->predictions_se[0][$this->kupGamesData[$i]['uuid'] . '_1']) && isset($this->predictions_se[0][$this->kupGamesData[$i]['uuid'] . '_2'])) {

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
                    if (intval($kupGameData['scoreTeam1']) == intval($kupGameData['prediction_team1']) && intval($kupGameData['scoreTeam2']) == intval($kupGameData['prediction_team2'])) {
                        $this->kupGamesData[$i]['predictionResult'] = $ok;
                    }
                    else if (intval($kupGameData['scoreTeam1']) > intval($kupGameData['scoreTeam2']) && intval($kupGameData['prediction_team1']) > intval($kupGameData['prediction_team2'])) {
                        $this->kupGamesData[$i]['predictionResult'] = $partial;
                    }
                    else if (intval($kupGameData['scoreTeam1']) < intval($kupGameData['scoreTeam2']) && intval($kupGameData['prediction_team1']) < intval($kupGameData['prediction_team2'])) {
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
                        else if ($question['label'] == 'label_question_first_team_that_tries' || $question['label'] == 'label_question_team_first_scores' || $question['label'] == 'label_question_winner_first_half' || $question['label'] == 'label_question_team_winner_half_time' || $question['label'] == 'label_question_team_winner_second_half' || $question['label'] == 'label_question_winner_second_half' || $question['label'] == 'label_question_which_team_qualifies') {
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
                            || $question['label'] == 'label_question_first_player_scores_left'
                            || $question['label'] == 'label_question_first_player_scores_right'
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
                        else if ($question['label'] == 'label_question_half_with_more_points' || $question['label'] == 'label_question_which_quaters_first_score') {
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

        public function executeKup_top14_201213_match_match() {
        }

        public function executeKup_top14_201213_bg() {
        }

        public function executeKup_top14_201213_onebg() {
        }

        public function executeKup_hcup_201213_k8() {
        }

        public function executeKup_hcup_201213_k12() {
        }

        public function executeKup_hcup_201213_bg() {
        }

        public function executeKup_hcup_201213_match_match() {
        }

    }
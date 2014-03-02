<?php

    /**
     * Soccer Components.
     *
     * @package    betkup.fr
     * @subpackage soccer
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: components.class.php 6573 2012-12-06 15:59:16Z anguenot $
     */
    class soccerComponents extends betkupComponents {

        public function executeKup_ligue1_2010_2011() {
        }

        public function executeKup_ligue1_psg_mhsc_2012() {
        }

        public function executeKup_ligue1_ol_psg_2012() {
        }

        public function executeKup_ligue1_ol_lille_2012() {
        }

        public function executeKup_ligue1_rennes_lyon_2012() {
        }

        public function executeKup_ligue1_rennes_mhsc_2012() {
        }

        public function executeKup_ligue1_lille_toulouse_2012() {
        }

        public function executeKup_ligue1_om_mhsc_2012() {
        }

        public function executeKup_ligue1_psg_om_2012() {
        }

        public function executeKup_ligue1_psg_asse_2012() {
        }

        public function executeKup_ligue1_val_psg_2012() {
        }

        public function executeKup_ligue1_lille_psg_2012() {
        }

        public function executeKup_ligue1_mhsc_asse_2012() {
        }

        public function executeKup_ligue1_mhsc_evian_2012() {
        }

        public function executeKup_ligue1_aja_mhsc_2012() {
        }

        public function executeKup_ligue1_lorient_psg_2012() {
        }

        public function executeKup_ligue1_loosers_2012() {
        }

        public function executeKup_2012_premiere_league_match_match() {
        }

        public function executeKup_bundesliga_2010_2011() {
        }

        public function executeKup_liga_2010_2011() {
        }

        public function executeKup_lega_2010_2011() {
        }

        public function executeKup_mix_eu() {
        }

        public function executeKup_cl_2012_match_par_match() {
        }

        public function executeKup_el_2012_match_par_match() {
        }

        public function executeKup_el_2012_bilbao_madrid() {
        }

        public function executeKup_cl_2012_lyon_apoel() {
        }

        public function executeKup_cl_2012_apoel_lyon() {
        }

        public function executeKup_cl_2012_om_inter() {
        }

        public function executeKup_cl_2012_milan_arsenal() {
        }

        public function executeKup_cl_2012_arsenal_milan() {
        }

        public function executeKup_cl_2012_naples_chelsea() {
        }

        public function executeKup_cl_2012_chelsea_naples() {
        }

        public function executeKup_cl_2012_chelsea_bayern() {
        }

        public function executeKup_cl_2012_inter_om() {
        }

        public function executeKup_can_2012_semi_final() {
        }

        public function executeKup_can_2012_final() {
        }

        public function executeKup_k8_2012_1() {
        }

        public function executeKup_k13_2012_1() {
        }

        public function executeKup_cl_2012_om_bayern() {
        }

        public function executeKup_cl_2012_milan_barcelona() {
        }

        public function executeKup_cl_2012_bayern_real() {
        }

        public function executeKup_cl_2012_chelsea_barcelona() {
        }

        public function executeKup_cl_2012_barcelona_chelsea() {
        }

        public function executeKup_cl_2012_apoel_madrid() {
        }

        public function executeKup_cl_2012_benfica_chelsea() {
        }

        public function executeKup_cl_2012_real_apoel() {
        }

        public function executeKup_cl_2012_bayern_om() {
        }

        public function executeKup_cl_2012_barcelona_milan() {
        }

        public function executeKup_cl_2012_chelsea_benfica() {
        }

        public function executeKup_ligue1_leaders_j32_2012() {
        }

        public function executeKup_liga_2012_barcelona_real() {
        }

        public function executeKup_ligue1_poduim1() {
        }

        public function executeKup_ligue1_poduim2() {
        }

        public function executeKup_2012_premier_league_arsenal_chelsea() {
        }

        public function executeKup_2012_premier_league_liverpool_chelsea() {
        }

        public function executeKup_2012_premier_league_mancity_manunited() {
        }

        public function executeKup_euro_2012_full() {
        }

        public function executeKup_euro_2012_match_match() {
        }

        public function executeKup_euro_2012_choc_poules() {
        }

        public function executeKup_euro_2012_pologne_grece() {
        }

        public function executeKup_euro_2012_russie_repcheque() {
        }

        public function executeKup_euro_2012_repcheque_poland() {
        }

        public function executeKup_euro_2012_france_england() {
        }

        public function executeKup_euro_2012_england_ukraine() {
        }

        public function executeKup_euro_2012_ukraine_sweden() {
        }

        public function executeKup_euro_2012_sweden_france() {
        }

        public function executeKup_euro_2012_germany_portugal() {
        }

        public function executeKup_euro_2012_denmark_germany() {
        }

        public function executeKup_euro_2012_portugal_holland() {
        }

        public function executeKup_euro_2012_spain_italie() {
        }

        public function executeKup_euro_2012_croatie_spain() {
        }

        public function executeKup_euro_2012_holland_denmark() {
        }

        public function executeKup_euro_2012_irland_croatie() {
        }

        public function executeKup_euro_2012_italie_ireland() {
        }

        public function executeKup_euro_2012_poland_russia() {
        }

        public function executeKup_euro_2012_grece_russia() {
        }

        public function executeKup_euro_2012_grece_repcheque() {
        }

        public function executeKup_euro_2012_denmark_portugal() {
        }

        public function executeKup_euro_2012_holland_germany() {
        }

        public function executeKup_euro_2012_italie_croatie() {
        }

        public function executeKup_euro_2012_spain_ireland() {
        }

        public function executeKup_euro_2012_sweden_england() {
        }

        public function executeKup_euro_2012_ukraine_france() {
        }

        public function executeKup_k24_euro_2012() {
        }

        /**
         * Display the Euro predictions component.
         */
        public function executeEuro2012FullPredictions(sfWebRequest $request) {
            // XXX we can't do this because this is not handle properly.
            $this->urlPredictionsGroup = $this->getContext()->getController()->genUrl(array(
                                                                                           'module'  => 'soccer',
                                                                                           'action'  => 'euro2012FullPredictionsGroup'
                                                                                      ));
            $this->urlRedirectToView = $request->getUri();
            $this->urlPredictionsFinal = $this->getContext()->getController()->genUrl(array(
                                                                                           'module'  => 'soccer',
                                                                                           'action'  => 'euro2012FullPredictionsFinal'
                                                                                      ));

            $this->redirectToFinal = $request->getParameter('redirectToFinal', '');

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

                // Stores predictions in user's session. Used to display publish messages and possibly for offline users.
                $this->getUser()->setAttribute('predictions_ic', $this->predictions_ic, 'predictionsSave');

                if ($this->getUser()->isAuthenticated()) {
                    $this->savePredictions($request, $this->kup_uuid, $this->predictions_ic, $this->predictions_se, $this->predictions_q, array(), array(), $this->predictions_tb);
                    if ($this->kupData != null && isset($this->kupData['type']) && $this->kupData['type'] == sfConfig::get('mod_kup_type_gambling_fr')) {
                        $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_gambling_kup_bet'));
                    }
                    if ($this->room_uuid != 0) {
                        $this->getController()->redirect($this->getController()->genUrl(array(
                                                                                             'module'    => 'room',
                                                                                             'action'    => 'kupBet',
                                                                                             'kup_uuid'  => $this->kup_uuid,
                                                                                             'room_uuid' => $this->room_uuid
                                                                                        )));
                    }
                    else {
                        $this->getController()->redirect($this->getController()->genUrl(array(
                                                                                             'module'  => 'kup',
                                                                                             'action'  => 'bet',
                                                                                             'uuid'    => $this->kup_uuid
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
                }
                else {
                    $this->predictions_ic = array();
                }
            }
        }

        /**
         * Display the Euro predictions row component.
         */
        public function executeEuro2012FullPredictionsGroupRow() {

        }

        /**
         * Display available predictions for a given Kup.
         *
         * @param sfWebRequest $request
         */
        public function executePredictions(sfWebRequest $request) {

            if (!isset($this->kupData)) {
                $this->kupData = array();
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
                    // Set flash message.
                    if ($this->kupData != null && isset($this->kupData['type']) && $this->kupData['type'] == sfConfig::get('mod_kup_type_gambling_fr')) {
                        $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_gambling_kup_bet'));
                    }
                    // Handle redirects.
                    if (isset($this->redirect_url) && $this->redirect_url != '') {
                        sfContext::getInstance()->getController()->redirect($this->redirect_url);
                    } else if ($this->room_uuid != 0) {
                        sfContext::getInstance()->getController()->redirect($this->getController()->genUrl(array(
                                                                                                                'module'    => 'room',
                                                                                                                'action'    => 'kupBet',
                                                                                                                'kup_uuid'  => $this->kup_uuid,
                                                                                                                'room_uuid' => $this->room_uuid,
                                                                                                                'hasPreds' => 1,
                                                                                                           )));
                    } else {
                        sfContext::getInstance()->getController()->redirect($this->getController()->genUrl(array(
                                                                                                                'module'  => 'kup',
                                                                                                                'action'  => 'bet',
                                                                                                                'uuid'    => $this->kup_uuid,
                                                                                                                'hasPreds' => 1,
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
                if (count($this->kupRoundsData) > 0) {
                    $this->roundUUID = $this->kupRoundsData[0]['uuid'];
                }
            }

            $user_id = $this->getUser()->getAttribute('subscriberId', '', 'subscriber');
            $cacheKey = 'soccer_results_component_kup_games_data_for_'.$user_id.'_kup_'.$this->kup_uuid.'_round_'.$this->roundUUID;
            $this->kupGamesData = sfMemcache::getInstance()->get($cacheKey, array());
            if(empty($this->kupGamesData)) {

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
                        if ($kupGameData['prediction_team1'] != '' && $kupGameData['prediction_team2'] != '' && intval($kupGameData['scoreTeam1']) == intval($kupGameData['prediction_team1']) && intval($kupGameData['scoreTeam2']) == intval($kupGameData['prediction_team2'])) {
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
                            else if ($question['label'] == 'label_question_first_team_that_tries'
                                || $question['label'] == 'label_question_team_first_scores'
                                || $question['label'] == 'label_question_winner_first_half'
                                || $question['label'] == 'label_question_team_winner_half_time'
                                || $question['label'] == 'label_question_team_winner_second_half'
                                || $question['label'] == 'label_question_winner_second_half'
                                || $question['label'] == 'label_question_which_team_qualifies'
                                || $question['label'] == 'label_question_which_team_best_scorer'
                                || $question['label'] == 'label_question_which_team_best_intercepteur'
                                || $question['label'] == 'label_question_which_team_best_contreur') {
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

                $cacheTime = 3600; // 1h
                if($this->kupData != null) {
                    if(isset($this->kupData['status']) && isset($this->kupData['type'])) {
                        if($this->kupData['type'] == sfConfig::get('mod_soccer_kup_type_free')) {
                            if($this->kupData['status'] >= 4 || $this->kupData['status'] == -1) {
                                $cacheTime = 0;
                            }
                        } else {
                            if($this->kupData['status'] >= 5 || $this->kupData['status'] == -1) {
                                $cacheTime = 0;
                            }
                        }
                    }
                }
                sfMemcache::getInstance()->set($cacheKey, $this->kupGamesData, 0, $cacheTime);
            }
        }

        public function executeKup_euro_2012_repcheque_portugal() {
        }

        public function executeKup_euro_2012_germany_greece() {
        }

        public function executeKup_euro_2012_quarters_chocs() {
        }

        public function executeKup_euro_2012_4quarts() {
        }

        public function executeKup_euro_2012_spain_france() {
        }

        public function executeKup_euro_2012_england_italie() {
        }

        public function executeKup_euro_2012_portugal_spain() {
        }

        public function executeKup_euro_2012_germany_italie() {
        }

        public function executeKup_euro_2012_spain_italie_final() {
        }

        public function executeKup_ligue2_201213_match_match() {
        }

        public function executeKup_ligue2_201213_days() {
        }

        public function executeKup_ligue1_201213_match_match() {
        }

        public function executeKup_ligue1_201213_days() {
        }

        public function executeKup_ligue1_201213_k8() {
        }

        public function executeKup_ligue1_201213_d1_rennes_lyon() {
        }

        public function executeKup_ligue1_201213_d1_asse_lille() {
        }

        public function executeKup_ligue1_201213_d2_ajaccio_paris() {
        }

        public function executeKup_ligue1_201213_d2_om_sochaux() {
        }

        public function executeKup_ligue1_201213_d3_paris_bordeaux() {
        }

        public function executeKup_ligue1_201213_d3_mhsc_marseille() {
        }

        public function executeKup_ligue1_201213_d4_lille_paris() {
        }

        public function executeKup_ligue1_201213_d4_lyon_valenciennes() {
        }

        public function executeKup_ligue1_201213_d5_rennes_lorient() {
        }

        public function executeKup_ligue1_201213_d5_asse_sochaux() {
        }

        public function executeKup_ligue1_201213_d6_lille_lyon() {
        }

        public function executeKup_ligue1_201213_d6_marseille_evian() {
        }

        public function executeKup_ligue1_201213_d7_lyon_bordeaux() {
        }

        public function executeKup_ligue1_201213_d7_rennes_lille() {
        }

        public function executeKup_ligue1_201213_d8_marseille_paris() {
        }

        public function executeKup_ligue1_201213_d9_ajaccio_bastia() {
        }

        public function executeKup_ligue1_201213_d9_bordeaux_lille() {
        }

        public function executeKup_ligue1_201213_d11_bordeaux_toulouse() {
        }

        public function executeKup_ligue1_201213_d11_psg_asse() {
        }

        public function executeKup_premier_league_201213_match_match() {
        }

        public function executeKup_premier_league_201213_liverpool_manchester() {
        }

        public function executeKup_premier_league_201213_arsenal_chelsea() {
        }

        public function executeKup_premier_league_201213_bg() {
        }

        public function executeKup_ligue1_201213_bg() {
        }

        public function executeKup_cdll_201213_bg() {
        }

        public function executeKup_cl_201213_bg() {
        }

        public function executeKup_lega_201213_bg() {
        }

        public function executeKup_liga_201213_bg() {
        }

        public function executeKup_bundesliga_201213_bg() {
        }

        public function executeKup_liga_201213_match_match() {
        }

        public function executeKup_liga_201213_barcelone_valence() {
        }

        public function executeKup_liga_201213_barcelone_real() {
        }

        public function executeKup_lega_201213_match_match() {
        }

        public function executeKup_lega_201213_milan_inter() {
        }

        public function executeKup_bundesliga_201213_match_match() {
        }

        public function executeKup_bundesliga_201213_schalke_bayern() {
        }

        public function executeKup_internationals_201213_france_uruguay() {
        }

        public function executeKup_internationals_201213_spain_france() {
        }

        public function executeKup_internationals_201213_france_japan() {
        }

        public function executeKup_internationals_201213_italie_france() {
        }

        public function executeKup_kross_201213() {
        }

        public function executeKup_wc_q_2012_finland_france() {
        }

        public function executeKup_wc_q_2012_france_belarus() {
        }

        public function executeKup_cl_201213_match_match() {
        }

        public function executeKup_cl_201213_rounds() {
        }

        public function executeKup_cl_201213_k8() {
        }

        public function executeKup_cl_201213_bg_d1_psg_kiev() {
        }

        public function executeKup_cl_201213_bg_d2_porto_psg() {
        }

        public function executeKup_cl_201213_bg_d3_zagreb_psg() {
        }

        public function executeKup_cl_201213_bg_d1_losc_bate() {
        }

        public function executeKup_cl_201213_bg_d2_valence_losc() {
        }

        public function executeKup_cl_201213_bg_d3_losc_bayern() {
        }

        public function executeKup_cl_201213_bg_d1_mhsc_arsenal() {
        }

        public function executeKup_cl_201213_bg_d2_schalke_mhsc() {
        }

        public function executeKup_cl_201213_bg_d3_mhsc_olympiakos() {
        }

        public function executeKup_wc_q_201213_k8() {
        }

        public function executeKup_el_201213_k8() {
        }

        public function executeKup_el_201213_klub3() {
        }

        public function executeKup_cl_201213_krossc() {
        }

        public function executeKup_cdll_201213_daily() {
        }

        public function executeKup_cdll_201213_k8() {
        }

        public function executeKup_cdll_201213_kross() {
        }

        public function executeKup_cdll_201213_psg_om() {
        }

        public function executeKup_klassico_201213_k8() {
        }

        public function executeKup_k12_201213() {
        }

        public function executeKup_mediapronos_201213_weekly() {
        }

        public function executeKup_mediapronos_201213_bg() {
        }

        public function executeKup_fan2sport_201213_weekly() {
        }

        public function executeKup_liga_201213_k10() {
        }

        public function executeKup_lega_201213_k10() {
        }

        public function executeKup_premier_league_201213_k10() {
        }

    }
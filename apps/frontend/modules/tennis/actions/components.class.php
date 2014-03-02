<?php
    /**
     * tennis components.
     *
     * @package    betkup.fr
     * @subpackage tennis
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: actions.class.php 4078 2012-03-08 19:07:13Z jmasmejean $
     */
    class tennisComponents extends betkupComponents {

        /**
         * Displays a custom prediction's page view for RG.
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
                $this->predictions_se = $request->getParameter('predictions_se', array());
                $this->predictions_tb = $request->getParameter('predictions_tb', array());

                // XXX We asssume we only have one type of questions for tennus which is the case right now.
                $questions_sets = $request->getParameter('predictions_q', array());
                $this->predictions_q = array();
                foreach ($questions_sets as $key => $question) {
                    $value = '';
                    foreach ($question as $sets) {
                        foreach ($sets as $set) {
                            if ($value == '') {
                                $value = $set;
                            }
                            else {
                                $value = $value . '#' . $set;
                            }
                        }
                    }
                    $this->predictions_q[$key] = $value;
                }

                if ($this->getUser()->isAuthenticated()) {
                    $this->savePredictions($request, $this->kup_uuid, $this->predictions_ic, $this->predictions_se, $this->predictions_q, array(), array(), $this->predictions_tb);
                    $this->predictions_q = $questions_sets;
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

                        $questions_sets = $this->predictions_q[0];
                        $this->predictions_q = array();
                        foreach ($questions_sets as $key => $predictions) {

                            $this->predictions_q[$key] = array();

                            $v1 = array();
                            $v2 = array();

                            if (strpos($predictions, '#') !== false) {
                                $predictions = explode('#', $predictions);
                                $nb_sets = round(count($predictions) / 2);
                            }
                            else {
                                $nb_sets = round(strlen($predictions) / 2);
                            }

                            $offset = 0;
                            while ($offset < $nb_sets) {
                                $v1[$offset] = $predictions[$offset];
                                $offset += 1;
                            }

                            $i = 0;
                            while ($offset < $nb_sets * 2) {
                                $v2[$i] = $predictions[$offset];
                                $offset += 1;
                                $i++;
                            }

                            $this->predictions_q[$key][0] = $v1;
                            $this->predictions_q[$key][1] = $v2;

                        }

                    }
                    $this->predictions_tb = $this->getPredictions($request, $this->kup_uuid, 'tb');
                    if (!empty($this->predictions_tb)) {
                        $this->predictions_tb = $this->predictions_tb[0];
                    }
                }
                else {
                    $this->predictions_ic = array();
                    $this->predictions_se = array();
                    $this->predictions_q = array();
                    $this->predictions_tb = array();
                }
            }
        }

        /**
         * Displays a custom result's page view for RG.
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

            $this->totalPoints = 0;

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
                            $this->totalPoints += $this->kupGamesData[$i]['points'];
                        }
                        else {
                            $this->kupGamesData[$i]['points'] = 0;
                        }
                    }

                    if (isset($this->predictions_ic[0][$this->kupGamesData[$i]['uuid']])) {
                        if ($this->kupGamesData[$i]['prediction'] == 1) {
                            $this->kupGamesData[$i]['prediction'] = $kupGameData['team1title'];
                        }
                        else if ($this->kupGamesData[$i]['prediction'] == 3) {
                            $this->kupGamesData[$i]['prediction'] = $kupGameData['team2title'];
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
                            $this->totalPoints += $this->kupGamesData[$i]['points'];
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
                    $this->kupGamesData[$i]['subTotal'] = 0;
                    $this->kupGamesData[$i]['totalMatch'] = 0;

                    if (isset($coreGame['properties']) && isset($coreGame['properties']['number_of_sets'])) {

                        $nb_sets = $coreGame['properties']['number_of_sets'];
                        $sizePlayer1 = 1;
                        $sizePlayer2 = 1;

                        $questionLine = array();
                        if (strlen($coreGame['properties']['scoreFirstEntryId']) <= $nb_sets && strlen($coreGame['properties']['scoreSecondEntryId']) <= $nb_sets) {

                            $nb_sets = strlen($coreGame['properties']['scoreFirstEntryId']);
                        }
                        else {
                            $sizePlayer1 = strlen($coreGame['properties']['scoreFirstEntryId']) - $nb_sets;
                            $sizePlayer2 = strlen($coreGame['properties']['scoreSecondEntryId']) - $nb_sets;
                        }

                        $this->kupGamesData[$i]['questionAnswer'] = $nb_sets;

                        for ($s = 0; $s < $nb_sets; $s++) {
                            $questionLine[$s]['name'] = 'Résultats du set ' . ($s + 1) . ' : (' . substr($coreGame['properties']['scoreFirstEntryId'], $s, $sizePlayer1) . '/' . substr($coreGame['properties']['scoreSecondEntryId'], $s, $sizePlayer2) . ')';
                        }
                        $this->kupGamesData[$i]['points'] = '-';

                        if (isset($this->predictions_q[0][$this->kupGamesData[$offset - 1]['uuid'] . '_' . $this->kupGamesData[$i]['questionId']])) {

                            $prediction_q = $this->predictions_q[0][$this->kupGamesData[$offset - 1]['uuid'] . '_' . $this->kupGamesData[$i]['questionId']];
                            $predictions_explode = explode('#', $prediction_q);
                            $prediction_nb_sets = count($predictions_explode) / 2;
                            $this->kupGamesData[$i]['prediction'] = $prediction_nb_sets;

                            $predictionsPlayer1 = array();
                            $predictionsPlayer2 = array();

                            for ($p = 0; $p < count($predictions_explode); $p++) {
                                if ($p < $prediction_nb_sets) {
                                    $predictionsPlayer1[] = $predictions_explode[$p];
                                }
                                else {
                                    $predictionsPlayer2[] = $predictions_explode[$p];
                                }
                            }
                            $isComboPartial = true;
                            $isComboSuper = true;
                            for ($s = 0; $s < $nb_sets; $s++) {

                                $resultPlayer1 = substr($coreGame['properties']['scoreFirstEntryId'], $s, $sizePlayer1);
                                $resultPlayer2 = substr($coreGame['properties']['scoreSecondEntryId'], $s, $sizePlayer2);

                                if (isset($predictionsPlayer1[$s]) && isset($predictionsPlayer2[$s])) {
                                    $questionLine[$s]['prediction'] = $predictionsPlayer1[$s] . ' - ' . $predictionsPlayer2[$s];

                                    if ($resultPlayer1 == $predictionsPlayer1[$s] && $resultPlayer2 == $predictionsPlayer2[$s]) {
                                        $questionLine[$s]['points'] = 40;
                                        $questionLine[$s]['predictionResult'] = $ok;
                                    }
                                    else if ($resultPlayer1 > $resultPlayer2 && $predictionsPlayer1[$s] > $predictionsPlayer2[$s]) {
                                        $questionLine[$s]['points'] = 5;
                                        $questionLine[$s]['predictionResult'] = $partial;
                                        $isComboSuper = false;
                                    }
                                    else if ($resultPlayer1 < $resultPlayer2 && $predictionsPlayer1[$s] < $predictionsPlayer2[$s]) {
                                        $questionLine[$s]['points'] = 5;
                                        $questionLine[$s]['predictionResult'] = $partial;
                                        $isComboSuper = false;
                                    }
                                    else {
                                        $questionLine[$s]['points'] = 0;
                                        $questionLine[$s]['predictionResult'] = $ko;
                                        $isComboPartial = false;
                                        $isComboSuper = false;
                                    }
                                }
                            }

                            if ($isComboSuper) {
                                $this->kupGamesData[$i]['combo'] = array(
                                    'name'             => 'Bonnus tous scores exacts',
                                    'predictionResult' => $ok,
                                    'points'           => 50
                                );
                            }
                            else if ($isComboPartial) {
                                $this->kupGamesData[$i]['combo'] = array(
                                    'name'             => 'Bonnus toutes issues correctes',
                                    'predictionResult' => $ok,
                                    'points'           => 30
                                );
                            }

                            if ($prediction_nb_sets == $nb_sets) {
                                $this->kupGamesData[$i]['predictionResult'] = $ok;
                                if (isset($this->predictions_q[1][$this->kupGamesData[$offset - 1]['uuid'] . '_' . $this->kupGamesData[$i]['questionId']])) {
                                    $this->kupGamesData[$i]['points'] = 20;
                                }
                            }
                            else {
                                $this->kupGamesData[$i]['predictionResult'] = $ko;
                                $this->kupGamesData[$i]['points'] = 0;
                            }

                            $this->kupGamesData[$i]['subTotal'] = $this->predictions_q[1][$this->kupGamesData[$offset - 1]['uuid'] . '_' . $this->kupGamesData[$i]['questionId']];
                            $this->kupGamesData[$i]['totalMatch'] = $this->kupGamesData[$i]['subTotal'] + $coreGame['points'];
                            $this->totalPoints += $this->kupGamesData[$i]['points'];
                        }

                        $this->kupGamesData[$i]['questionLine'] = $questionLine;
                    }

                    $offset += 1;
                }
            }

            $this->resultSets = $this->getTennisResultsSets($this->kupGamesData);
        }

        private function getTennisResultsSets($kupGamesData) {

            $results = array();
            $j = 0;
            foreach ($kupGamesData as $kupGameData) {
                if (isset($kupGameData['properties']) && isset($kupGameData['properties']['scoreFirstEntryId']) && $kupGameData['properties']['scoreFirstEntryId'] != '') {

                    $nb_sets = $kupGameData['properties']['number_of_sets'];
                    $sizePlayer1 = 1;
                    $sizePlayer2 = 1;

                    $results[$j]['properties'] = array('sets' => array());

                    if (strlen($kupGameData['properties']['scoreFirstEntryId']) <= $nb_sets && strlen($kupGameData['properties']['scoreSecondEntryId']) <= $nb_sets) {

                        $nb_sets = strlen($kupGameData['properties']['scoreFirstEntryId']);
                    }
                    else {
                        $sizePlayer1 = strlen($kupGameData['properties']['scoreFirstEntryId']) - $nb_sets;
                        $sizePlayer2 = strlen($kupGameData['properties']['scoreSecondEntryId']) - $nb_sets;
                    }

                    for ($i = 0; $i < $nb_sets; $i++) {

                        $results[$j]['properties']['sets'][0][$i + 1] = array('set' => substr($kupGameData['properties']['scoreFirstEntryId'], $i, $sizePlayer1));
                        $results[$j]['properties']['sets'][1][$i + 1] = array('set' => substr($kupGameData['properties']['scoreSecondEntryId'], $i, $sizePlayer2));

                        if ($results[$j]['properties']['sets'][0][$i + 1]['set'] > $results[$j]['properties']['sets'][1][$i + 1]['set']) {
                            $results[$j]['properties']['sets'][0][$i + 1]['winner'] = 1;
                        }
                        else {
                            $results[$j]['properties']['sets'][1][$i + 1]['winner'] = 1;
                        }
                    }

                    /*
                      * $results[]['properties'] =
                     array(
                         'sets' => array(
                             '0' => array(1 => array('set' => 3), 2 => array('set' => 7, 'winner' => 1), 3 => array('set' => 7, 'tieBreak' => 11, 'winner' => 1), 4 => array('set' => 4), 5 => array('set' => 2)),
                             '1' => array(1 => array('set' => 6, 'winner' => 1), 2 => array('set' => 5), 3 => array('set' => 6, 'tieBreak' => 9), 4 => array('set' => 6, 'winner' => 1), 5 => array('set' => 6, 'winner' => 1)),
                         )
                     );
                     */
                }
                else {
                    $results[] = array();
                }
                $j++;
            }

            return $results;
        }

        /**
         * Displays a custom result row for RG.
         */
        public function executeResultRow() {

        }

        public function executePredictionRow() {
            if (!isset($this->selectSmall)) {
                $this->selectSmall = 80;
            }
            if (!isset($this->selectBig)) {
                $this->selectBig = 180;
            }
            $this->minSets = 2;
            $this->maxSets = 5;
            $this->sets = array();
            for ($i = $this->minSets; $i <= $this->maxSets; $i++) {
                $this->sets[$i] = $i . ' sets';
            }

            $this->predictionsNumberSets = -1;
            if (isset($this->kupGameData) && isset($this->kupGameData['questionId']) && isset($this->kupGameData['id'])) {
                if (isset($this->predictions_q) && isset($this->predictions_q[$this->kupGameData['id'] . '_' . $this->kupGameData['questionId']]) && isset($this->predictions_q[$this->kupGameData['id'] . '_' . $this->kupGameData['questionId']][0])) {
                    $this->predictionsNumberSets = count($this->predictions_q[$this->kupGameData['id'] . '_' . $this->kupGameData['questionId']][0]);
                }
            }

            if (!isset($this->kupData)) {
                $this->kupData = array();
            }
            if (!isset($this->sport)) {
                $this->sport = '';
            }
            $this->questionsBindings = $this->getKupQuestionsBindings();
            $this->setKupInterogationsText($this->kupData, $this->sport, $this->kupGameData, $this->questionsBindings);
        }

        /**
         * Display count down component.
         */
        public function executeCountDown() {
        }

        /**
         * Rules for RG 2012 match / match free kup
         */
        public function executeKup_rg_2012_match_match() {

        }

        /**
         * Rules for RG 2012 daily kups
         */
        public function executeKup_rg_2012_daily() {

        }

        /**
         * Rules for RG 2012 daily kups
         */
        public function executeKup_2012_rg_k8_d1() {

        }

        /**
         * Display tie breaker question for predictions
         */
        public function executePredictionsTieBreaker() {
        }

        /**
         * Rules for W K8 D1
         */
        public function executeKup_2012_w_k8_d1() {

        }

        /**
         * Rules for W 2012 match / match free kup
         */
        public function executeKup_w_2012_match_match() {

        }

        /**
         * Rules for US Open 2012 match / match free kup
         */
        public function executeKup_usopen_2012_match_match() {


    }
        /**
         * Rules for Wimbledon2012 daily kups
         */
        public function executeKup_w_2012_daily() {

        }

        /**
         * Rules for US Open daily kups
         */
        public function executeKup_usopen_2012_daily() {

        }

    }

?>
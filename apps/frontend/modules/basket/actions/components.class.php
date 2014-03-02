<?php
    /**
     * Basket components.
     *
     * @package    betkup.fr
     * @subpackage basket
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: components.class.php 6553 2012-11-22 22:25:45Z anguenot $
     */
    class basketComponents extends betkupComponents {

        /**
         * Display the prediction view for basket.
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
                $this->predictions_q = $request->getParameter('predictions_q', array());

                if ($this->getUser()->isAuthenticated()) {
                    $this->savePredictions($request, $this->kup_uuid, $this->predictions_ic, array(), $this->predictions_q, array(), array(), $this->predictions_tb);
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
                    $this->predictions_q = $this->getPredictions($request, $this->kup_uuid, 'q');
                    if (!empty($this->predictions_q)) {
                        $this->predictions_q = $this->predictions_q[0];
                    }
                }
                else {
                    $this->predictions_ic = array();
                    $this->predictions_q = array();
                }
            }
        }

        /**
         * Display a prediction row view for basket.
         *
         * @param sfWebRequest $request
         */
        public function executePredictionRow(sfWebRequest $request) {
            if (!isset($this->isKn)) {
                $this->isKn = false;
            }
            if (!isset($this->kupData)) {
                $this->kupData = array();
            }
            if (!isset($this->sport)) {
                $this->sport = '';
            }

            // For question 1X2 we have to change the order of choices.
            if($this->kupGameData['type'] == 'q' && $this->kupGameData['questionId'] != sfConfig::get('mod_basket_slider_question')) {
                if(count($this->kupGameData['choices']) == 3) {
                    $reorderKupGameData = array();
                    $newChoices = array();
                    foreach($this->kupGameData['choices'] as $key => $kupGameData) {
                        $reorderKupGameData[][$key] = $kupGameData;
                    }
                    $sortedKupGameChoices = array(
                        0 => $reorderKupGameData[1],
                        1 => $reorderKupGameData[0],
                        2 => $reorderKupGameData[2]
                    );
                    foreach($sortedKupGameChoices as $rkupGameData) {
                        foreach($rkupGameData as $k => $v) {
                            $newChoices[$k] = $v;
                        }
                    }
                    $this->kupGameData['choices'] = $newChoices;
                }
            }

            $this->questionsBindings = $this->getKupQuestionsBindings();
            $this->setKupInterogationsText($this->kupData, $this->sport, $this->kupGameData, $this->questionsBindings);
        }

        /**
         * Display the prediction view for basket.
         *
         * @param sfWebRequest $request
         */
        public function executePredictionsPlayer(sfWebRequest $request) {

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

            // Test slider //////////////////
            $this->kupGamesData = array();

            $kupGamesDataT = $this->getKupGamesData($request, $this->kup_uuid, $this->roundUUID, false, '');

            $i=0;
            foreach($kupGamesDataT as $t) {
                if($i==1) {
                    $this->kupGamesData[] = array(
                        'type' => 'q',
                        'id' => 'test',
                        'questionId' => 'qTest',
                        'question' => 'Le joueur de la kup réussirat-il :',
                        'isActive' => 0,
                        'choices' => array(
                            "010" => 'Entre 0 et 10 points',
                            "10" => 'Plus de 10 points',
                            "20" => 'Plus de 20 points',
                            "30" => 'Plus de 30 points'
                        )
                    );
                }
                $this->kupGamesData[] = $t;

                $i++;
            }
            ///////////////////////////
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
                $this->predictions_q = $request->getParameter('predictions_q', array());

                if ($this->getUser()->isAuthenticated()) {
                    $this->savePredictions($request, $this->kup_uuid, $this->predictions_ic, array(), $this->predictions_q, array(), array(), $this->predictions_tb);
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
                    $this->predictions_q = $this->getPredictions($request, $this->kup_uuid, 'q');
                    if (!empty($this->predictions_q)) {
                        $this->predictions_q = $this->predictions_q[0];
                    }
                }
                else {
                    $this->predictions_ic = array();
                    $this->predictions_q = array();
                }
            }
        }

        /**
         * Display a prediction row view for basket.
         *
         * @param sfWebRequest $request
         */
        public function executePredictionPlayerRow(sfWebRequest $request) {
            if (!isset($this->isKn)) {
                $this->isKn = false;
            }
            if (!isset($this->kupData)) {
                $this->kupData = array();
            }
            if (!isset($this->sport)) {
                $this->sport = '';
            }

            // For question 1X2 we have to change the order of choices.
            if($this->kupGameData['type'] == 'q' && $this->kupGameData['questionId'] != sfConfig::get('mod_basket_slider_question')) {
                if(count($this->kupGameData['choices']) == 3) {
                    $reorderKupGameData = array();
                    $newChoices = array();
                    foreach($this->kupGameData['choices'] as $key => $kupGameData) {
                        $reorderKupGameData[][$key] = $kupGameData;
                    }
                    $sortedKupGameChoices = array(
                        0 => $reorderKupGameData[1],
                        1 => $reorderKupGameData[0],
                        2 => $reorderKupGameData[2]
                    );
                    foreach($sortedKupGameChoices as $rkupGameData) {
                        foreach($rkupGameData as $k => $v) {
                            $newChoices[$k] = $v;
                        }
                    }
                    $this->kupGameData['choices'] = $newChoices;
                }
            }

//            print_r($this->kupGameData);

            $this->questionsBindings = $this->getKupQuestionsBindings();
            $this->setKupInterogationsText($this->kupData, $this->sport, $this->kupGameData, $this->questionsBindings);
        }


        /**
         * TODO Implement this method.
         * Show the results page for basket.
         *
         * @param sfWebRequest $request
         */
        public function executeResults(sfWebRequest $request) {

        }

        /**
         * TODO Implement this method.
         * Show the rules page for basket.
         *
         * @param sfWebRequest $request
         */
        public function executeRules(sfWebRequest $request) {

        }

        /**
         * TODO comment
         */
        public function executeKup_nba_201213_match_match() {

        }

        /**
         * TODO comment
         */
        public function executeKup_nba_201213_k15() {

        }

        /**
         * TODO comment
         */
        public function executeKup_nba_201213_bg() {

        }

        /**
         * TODO comment
         */
        public function executeKup_nba_201213_dorado() {

        }

    }

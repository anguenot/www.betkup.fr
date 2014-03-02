<?php

    /**
     * Kup components.
     *
     * @package    betkup.fr
     * @subpackage kup
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: components.class.php 6416 2012-11-05 17:20:47Z jmasmejean $
     */
    class kupComponents extends betkupComponents {

        /**
         * XXX
         * Enter description here ...
         */
        public function executeHome() {

        }

        /**
         * Displays a Kup Thumbnail.
         *
         * <p>
         *
         * In use in dashboard and Rooms for instance.
         */
        public function executeKupThumbnailHome(sfWebRequest $request) {
            $this->kupUrl = '';
            $roomUuid = (isset($this->roomUuid)) ? $this->roomUuid : '';
            $this->kup = $this->data;

            // Room or challenge ?
            $this->isChallenge = false;
            if ($this->kup['roomUUID'] != '740') {
                $roomUI = $this->getRoomUIParametersFor($this->kup['name']);
                if (isset($roomUI['isChallenge']) && $roomUI['isChallenge'] == 1) {
                    $this->isChallenge = true;
                }
            }
            if ($this->data['roomUUID'] == 740 || $this->isChallenge) {
                if ($this->data['status'] == 4 || $this->data['status'] == 5 || $this->data['status'] == -1) {
                    $this->kupUrl = $this->getController()->genUrl(array(
                                                                        'module'  => 'kup',
                                                                        'action'  => 'ranking',
                                                                        'uuid'    => intval($this->data['uuid'])
                                                                   ));
                }
                else {
                    $this->kupUrl = $this->getController()->genUrl(array(
                                                                        'module'  => 'kup',
                                                                        'action'  => 'view',
                                                                        'uuid'    => intval($this->data['uuid'])
                                                                   ));
                }
            }
            else {
                if ($roomUuid == '') {
                    $roomUuid = $this->data['roomUUID'];
                }
                if ($this->data['status'] == 4 || $this->data['status'] == 5 || $this->data['status'] == -1) {
                    $this->kupUrl = $this->getController()->genUrl(array(
                                                                        'module'    => 'room',
                                                                        'action'    => 'kupRanking',
                                                                        'room_uuid' => $roomUuid,
                                                                        'kup_uuid'  => intval($this->data['uuid'])
                                                                   ));
                }
                else {
                    $this->kupUrl = $this->getController()->genUrl(array(
                                                                        'module'    => 'room',
                                                                        'action'    => 'kup',
                                                                        'room_uuid' => $roomUuid,
                                                                        'kup_uuid'  => intval($this->data['uuid'])
                                                                   ));
                }
            }
            if (!isset($this->roomUI)) {
                $this->roomUI = array();
            }
        }


        /**
         * Display the header search Kup form.
         *
         * @param sfWebRequest $request
         */
        public function executeSearch(sfWebRequest $request) {

            $this->offset = $this->getUser()->getAttribute('offset', 0, 'searchKupsHolder');
            $this->batchSize = 8;

            $this->datas = Data::searchTerms();
            // Default selected data for search form.
            $this->selectedDatas = array(
                sfConfig::get('app_kup_search_params_sports') . '_' . sfConfig::get('app_params_type_sports_all'),
                sfConfig::get('app_kup_search_params_stake') . '_' . sfConfig::get('app_params_type_stake_all'),
                sfConfig::get('app_kup_search_params_status') . '_' . sfConfig::get('app_params_type_duration_in_progress'),
                sfConfig::get('app_kup_search_params_status') . '_' . sfConfig::get('app_params_type_duration_in_comming'),
                sfConfig::get('app_kup_search_params_sorting') . '_' . sfConfig::get('app_params_type_sorting_start_date')
            );

            $this->disabledDatas = array();

            if ($request->getParameter('selectedDatas', '') != '') {
                $this->selectedDatas = $request->getParameter('selectedDatas', '');
            }
            else if ($this->getUser()->getAttribute('selectedDatas', '', 'searchKupsHolder') != '') {
                $this->selectedDatas = $this->getUser()->getAttribute('selectedDatas', '', 'searchKupsHolder');
            }
        }

        /**
         * Displays a Kup's thunmbnail within the Kup's home page.
         */
        public function executeKupThumbnailKups(sfWebRequest $request) {
            if ($this->winners == 4) {
                $this->winners = 10;
            }
            else if ($this->winners == 5) {
                $this->winners = 13;
            }
            else if ($this->winners == 6) {
                $this->winners = 20;
            }

            // Room or challenge ?
            $this->isChallenge = false;
            if ($this->kup['roomUUID'] != '740') {
                $roomUI = $this->getRoomUIParametersFor($this->kup['roomName']);
                if (isset($roomUI['isChallenge']) && $roomUI['isChallenge'] == 1) {
                    $this->isChallenge = true;
                }
            }

            // Determine the sport for search kup component.
            $this->typeSport = 'SPORTS_'.strtoupper($this->kup['ui']['typeSport']);

            if ($this->kup['roomUUID'] == '740' || $this->isChallenge) {
                $this->urlToKupView = $this->getController()->genUrl(array(
                                                                          'module'  => 'kup',
                                                                          'action'  => 'view',
                                                                          'uuid'    => $this->kup['uuid']
                                                                     ));
                if (isset($this->status) && ($this->status == 4 || $this->status == 5 || $this->status == -1)) {
                    $this->urlToKupView = $this->getController()->genUrl(array(
                                                                              'module'  => 'kup',
                                                                              'action'  => 'ranking',
                                                                              'uuid'    => $this->kup['uuid']
                                                                         ));
                }
            }
            else if($this->kup['roomUUID'] != '740') {
                $this->urlToKupView = $this->getController()->genUrl(array(
                                                                          'module'    => 'room',
                                                                          'action'    => 'kup',
                                                                          'room_uuid' => $this->kup['roomUUID'],
                                                                          'kup_uuid'  => $this->kup['uuid']
                                                                     ));
                if (isset($this->status) && ($this->status == 4 || $this->status == 5 || $this->status == -1)) {
                    $this->urlToKupView = $this->getController()->genUrl(array(
                                                                              'module'    => 'room',
                                                                              'action'    => 'kupRanking',
                                                                              'room_uuid' => $this->kup['roomUUID'],
                                                                              'kup_uuid'  => $this->kup['uuid']
                                                                         ));
                }
            }
        }

        /**
         * Returns the Room UI bindings.
         *
         * @return array from room name to yml configuration file.
         */
        private function getRoomUIBindings() {
            $cacheKey = 'rooms_ui_bindings';
            $roomUIBindings = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty( $roomUIBindings)) {
                $pathConfigFile = sfConfig::get('sf_app_dir') . '/modules/room/config/module.yml';
                $moduleConfig = sfYaml::load($pathConfigFile);
                $config = $moduleConfig['all']['ui']['bindings'];
                $bindings = explode(" ", $config);
                $roomUIBindings = array();
                foreach ($bindings as $binding) {
                    $binding_param = $this->getRoomUIFor($binding);
                    $roomName = $binding_param['roomName'];
                    $roomUIBindings[$roomName] = $binding_param;
                }
                if (!empty($roomUIBindings)) {
                    sfMemcache::getInstance()->set($cacheKey, $roomUIBindings, 0, 0);
                }
            }
            return $roomUIBindings;
        }

        /**
         * Returns the Room UI parameters given the yaml configuration file.
         *
         * @param str $file
         */
        private function getRoomUIFor($file) {

            $module_dir = sfConfig::get('sf_app_module_dir');
            $module_name = 'room';
            $data = 'data/ui';

            $config = sfYaml::load($module_dir . '/' . $module_name . '/' . $data . '/' . $file);
            return $config['ui'];
        }

        /**
         * Returns a room customization given its name.
         *
         * @param str $roomName
         */
        private function getRoomUIParametersFor($roomName) {
            $bindings = $this->getRoomUIBindings();
            if (array_key_exists($roomName, $bindings)) {
                return $bindings[$roomName];
            }
            return array();
        }

        /**
         * Display the kup header.
         */
        public function executeKupHeader() {
            $this->siteUrl = 'https://' . $this->getContext()->getRequest()->getHost();
            $this->culture = $this->getUser()->getCulture();
            $this->module = $this->request->getParameter('module', '');

            $this->kupType = '';
            if ($this->kupData["type"] == sfConfig::get('mod_kup_type_gambling_fr')) {
                if ($this->kupData["stake"] == 0) {
                    $this->kupType = 'Kup freeroll';
                }
                else {
                    $this->kupType = 'Kup payante';
                }
            }
            else {
                $this->kupType = 'Kup gratuite';
            }
        }

        /**
         * Display the tabs for kup nav.
         */
        public function executeTabs() {

            if (!isset($this->numTab)) {
                $this->numTab = 1;
            }

            if ($this->tab == "predictions") {
                $this->numTab = 1;
            }

            if ($this->tab == "ranking") {
                $this->numTab = 2;
            }

            if ($this->tab == "results") {
                $this->numTab = 3;
            }

            if ($this->tab == "rules") {
                $this->numTab = 4;
            }

            if ($this->tab == "inviteFriends") {
                $this->numTab = 5;
            }
        }

        /**
         * XXX
         * Enter description here ...
         */
        public function executeResultRow() {
            if (!isset($this->index)) {
                $this->index = 0;
            }
        }

        /**
         * XXX
         * Enter description here ...
         */
        public function executeJackpot() {

            if (!isset($this->amount)) {
                $this->amount = 0;
            }
            else {
                $this->amount = round($this->amount);
            }
            $this->unity = 0;
            if ($this->amount > 0) {
                $this->unity = substr($this->amount, -1);
            }
            $this->ten = '';
            if ($this->amount > 9) {
                $this->ten = substr($this->amount, -2, 1);
            }
            $this->hundred = '';
            if ($this->amount > 99) {
                $this->hundred = substr($this->amount, -3, 1);
            }
            $this->thousands = '';
            if ($this->amount > 999) {
                $this->thousands = substr($this->amount, 0, 1);
            }
        }

        /**
         * XXX
         * Enter description here ...
         */
        public function executeRules() {
            if ($this->request->getParameter('kup_uuid')) {
                $this->kup_uuid = $this->request->getParameter('kup_uuid');
            }

            // Minimum of player require for the kup
            if ($this->kupData['repartition'] == 1) {
                $this->repartitionRule = 2;
            } else if ($this->kupData['repartition'] == 4) {
                $this->repartitionRule = 10;
            } else if ($this->kupData['repartition'] == 5) {
                $this->repartitionRule = 13;
            } else if ($this->kupData['repartition'] == 6) {
                $this->repartitionRule = 20;
            } else if ($this->kupData['repartition'] == 55) {
                $this->repartitionRule = 5;
            } else {
                $this->repartitionRule = $this->kupData['repartition'];
            }

            $this->repartitions = util::getRepartitionsFor($this->kupData['repartition']);

            $this->module = $this->request->getParameter('module', '');
            $this->action = $this->request->getParameter('action', '');
        }

        /**
         * Display the rule table component.
         */
        public function executeRulesTable() {

        }

        /**
         * XXX
         * Enter description here ...
         */
        public function executePercent() {

            if (!isset($this->nbEvents)) {
                $this->nbEvents = 0;
            }

            if (!isset($this->nbEventsTotal)) {
                $this->nbEventsTotal = 0;
            }

            // Progress value
            if (!isset($this->progress)) {
                $this->progress = 0;
            }

            // size to px dashed bar
            $this->sizePercentToPx = round((550 * $this->progress) / 100);
            if ($this->progress < 2) {
                $this->sizePercentToPx = 10;
            }

            // size to px zone label percent
            $this->sizePxLabel = $this->sizePercentToPx;
            if ($this->progress < 8) {
                $this->sizePxLabel = 48 + ($this->progress > 2 ? round(($this->progress - 2) * 5) : 0);
            }

            if ($this->progress > 80) {
                $this->sizePercentToPx = $this->sizePercentToPx - 45;
                $this->sizePxLabel = $this->sizePxLabel - 45;
            }
        }

        /**
         * XXX
         * Enter description here ...
         */
        public function executeWall() {

        }

        /**
         * XXX
         * Enter description here ...
         */
        public function executeWallComment() {

        }

        /**
         * XXX
         * Enter description here ...
         */
        public function executeStatus() {

        }

        /**
         * Display Kup's ranking.
         *
         * Computes participant's batch properties for UI display.
         */
        public function executeRanking() {

            // Set all position to 0
            $this->supToFirst = 0;
            $this->supToMiddle = 0;
            $this->supToLast = 0;

            // Set number of page
            $this->nbPage = ceil($this->nbPlayers / $this->batch);

            // Set actual page
            $this->numActualPage = round(intval($this->offset) / intval($this->batch), 0, PHP_ROUND_HALF_UP) + 1;

            //Set page remaining
            $this->nbPageRemaining = $this->nbPage - $this->numActualPage;

            //Set member position page
            if ($this->memberPosition != 0) {
                $this->offsetMemberRanking = (ceil($this->memberPosition / $this->batch) - 1) * $this->batch;
            }
            else {
                $this->offsetMemberRanking = 0;
            }


            if (!isset($this->urlForFacebook)) {
                $this->urlForFacebook = '';
            }
            if (!isset($this->userRanking)) {
                $this->userRanking = array();
            }
            if (!isset($this->description)) {
                $this->description = $this->getContext()->getI18N()->__('text_publish_fb_ranking', array(
                                                                                                        '%jackpot%'  => isset($this->userRanking['winnings']) ? $this->userRanking['winnings'] : '0',
                                                                                                        '%bet%'      => $this->kupData['stake'],
                                                                                                        '%kup%'      => $this->kupData['name']
                                                                                                   ));
            }
            if (!isset($this->properties)) {
                $this->properties = array(
                    'Mon classement'   => (isset($this->userRanking['position']) && !empty($this->userRanking) ? $this->userRanking['position'] : '0') . '/' . $this->nbPlayers,
                    'Nombre de points' => (isset($this->userRanking['value']) && !empty($this->userRanking) ? $this->userRanking['value'] : '0') . ' pts',
                    'Mon pseudo'       => $this->getUser()->getAttribute('nickName', '', 'subscriber')
                );
            }


            //Decide position with the number of page and actual page
            if ($this->nbPage == 1) {
                $this->supToFirst = 0;
                $this->supToMiddle = 0;
                $this->supToLast = 0;
            }
            else if ($this->nbPage == 2) {
                if ($this->numActualPage == 1) {
                    $this->supToFirst = 1;
                }
                if ($this->numActualPage == 2) {
                    $this->supToLast = 1;
                }
            }
            else if ($this->nbPage <= 3) {
                if ($this->numActualPage == 1) {
                    $this->supToFirst = 1;
                }
                if ($this->numActualPage == 2) {
                    $this->supToFirst = 1;
                }
                if ($this->numActualPage == 3) {
                    $this->supToLast = 1;
                }
            }
            else {
                if ($this->numActualPage < 4) {
                    $this->supToFirst = 1;
                }
                if ($this->nbPageRemaining <= 2) {
                    $this->supToLast = 1;
                }
                if ($this->supToFirst != 1 && $this->supToLast != 1) {
                    $this->supToMiddle = 1;
                }
            }

        }

        /**
         * Display the kups within a room
         */
        public function executeKupsRoom() {
            if (!isset($this->parentModule)) {
                $this->parentModule = 0;
            }
            if (!isset ($this->kupStatus)) {
                $this->kupStatus = sfConfig::get('app_kup_status_all_opened');
            }
            if (!isset ($this->isInsideRoom)) {
                $this->isInsideRoom = 0;
            }
            if (!isset ($this->nbDisplay)) {
                $this->nbDisplay = 2;
            }
            if (!isset ($this->totalKups)) {
                $this->totalKups = 0;
            }
            if (!isset($this->async)) {
                $this->async = 0;
            }
            if (!isset($this->batchSize)) {
                $this->batchSize = 4;
            }
            if (!isset($this->nbLine)) {
                $this->nbLine = 2;
            }
            if (!isset($this->previousOffset)) {
                $this->previousOffset = 0;
            }
            if (!isset($this->currentOffset)) {
                $this->currentOffset = 0;
            }
            if (!isset($this->roomUI)) {
                $this->roomUI = array();
            }
            $this->nextOffset = $this->batchSize;

            if (!isset($this->elementHeight)) {
                $this->elementHeight = '';
            }

            if(!isset($this->containerHeight)) {
                $this->containerHeight = '400px';
            }
        }

        /**
         * Display informations for kup at the right of the screen
         */
        public function executeRight() {

            $this->module = $this->request->getParameter('module', '');
            $this->action = $this->request->getParameter('action', '');

            if (!isset($this->canInvite)) {
                // Default : The user can invite friends
                $this->canInvite = 1;
            }

            // Generate the URL to invite.
            if (isset($this->room_uuid)) {
                $this->urlInvite = $this->generateUrl('room_kup_invite_step3', array(
                                                                                    'is_room_kup_invite'  => '1',
                                                                                    'kup_uuid'            => $this->kupData["uuid"],
                                                                                    'room_uuid'           => $this->room_uuid,
                                                                                    'tabInvite'           => '1',
                                                                                    'tab'                 => 'inviteFriends'
                                                                               ));
            }
            else {
                $this->urlInvite = url_for(array(
                                                'module'    => 'kup', 'action' => 'inviteFriends',
                                                'uuid'      => $this->kupData["uuid"],
                                                'tabInvite' => '1'
                                           ));
            }

            if (isset($this->kupData) && $this->kupData['type'] == sfConfig::get('mod_kup_type_gambling_fr')) {
                $this->repartitions = util::getRepartitionsArrayBoxFor($this->kupData['repartition']);

            }
        }

        /**
         * This component display one bloc in edition room / kups
         * used on room / edition / kups for example
         */
        public function executePreview() {
            // this component aimed at being added to the left or right of the  edit kups canvas within rooms.
            $this->left = 'left';
            $this->right = 'right';

            // Default value 3 when kup is free (stake == 0)
            if (!array_key_exists('repartition', $this->kup) || $this->kup["stake"] == 0) {
                $this->kup["repartition"] = 3;
            }
        }

        /**
         * Kup's bet main UI component.
         */
        public function executeKupBet() {

            $this->userEmail = $this->getUser()->getAttribute('email', '', 'subscriber');
            $this->userCreditBefore = $this->getUser()->getAttribute('credit', '', 'subscriber');
        }

        /**
         * This component display one detailed kup
         * @see /me (My Betkup)
         *
         * @params sfWebRequest $request
         */
        public function executeKupThumbnail(sfWebRequest $request) {

            if (!isset($this->parentModule)) {
                $this->parentModule = '';
            }
            if (!isset($this->isInsideRoom)) {
                $this->isInsideRoom = 0;
            }
            if (!isset($this->kupStatus)) {
                $this->kupStatus = sfConfig::get('app_kup_status_all');
            }
            if (!isset($this->roomUI)) {
                $this->roomUI = array();
            }

            $this->roomPrivacy = '';
            if($this->room_uuid != 'me') {
                // The room is already in cache at this time.
                $room = $this->getRoom($request, $this->room_uuid);
                $this->roomPrivacy = $room['privacy'];
            }
        }

        /**
         * Display one prediction row.
         *
         * Form elements of type select or radio
         *
         * Typically a game or question.
         */
        public function executePredictionRow() {
            if (!isset($this->isKn)) {
                $this->isKn = false;
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

    }
<?php

    /**
     * Abstract Betkup Actions class.
     *
     * <p/>
     *
     * Abstract class that betkup.fr actions should inherit from.
     * It defines primitives handling the Sofun Platform access and session using the sfWebRequest.
     *
     * @package    betkup.fr
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: betkupActions.class.php 6561 2012-11-27 14:54:44Z anguenot $
     */
    class betkupActions extends sfActions {


        /**
         * Redirect to referer when login success.
         *
         * Otherwrise it redirect to $url.
         *
         * @param string $statusCode (200 if success)
         * @param string $url
         * @param int    $statusCode
         */
        public function redirectIfLoginSuccess($url, $statusCode = 302, $redirectionCode = 400) {

            if($redirectionCode == 200) {
                $user = $this->getUser();
                $referer = $user->getAttribute('referer', '', sfConfig::get('app_redirection_filter_namespace_name'));
                if($referer != '') {
                    $url = $referer;
                    // We delete the user referer namespace after it's used.
                    $user->getAttributeHolder()->removeNamespace(sfConfig::get('app_redirection_filter_namespace_name'));
                }
            }
            $this->redirect($url, $statusCode);
        }

        /**
         * Set the title and description to optimize the SEO by Kups, Rooms, Room Kups.
         *
         * @param string $type
         * @param array  $coreEntity (kupData or roomData)
         * @param string  $viewType
         */
        protected function setTitleDescriptionSEOFor($type = "", $viewType = "predictions", $coreEntity = array(), $roomTitle = "") {
            $titleMessage = "";
            $descriptionMessage = "";
            $title = "";
            $description = "";
            $roomPrivacy = "";
            $roomAuthor = "";
            $date = isset($coreEntity['startDate']) ? util::displayDateFormated($coreEntity['startDate']) : '';
            if($viewType == 'results' && isset($coreEntity['endDate'])) {
                $date = util::displayDateFormated($coreEntity['endDate']);
            }

            if($type == 'kups') {
                $title = isset($coreEntity['name']) ? $coreEntity['name'] : "";
                $description = isset($coreEntity['description']) ? $coreEntity['description'] : "";
                $titleMessage = "title_kups_".$viewType;
                $descriptionMessage = "description_kups_".$viewType;
            }
            else if($type == 'rooms') {
                $roomAuthor = isset($coreEntity['author_nickname']) ? $coreEntity['author_nickname'] : "";
                $roomPrivacy = (isset($coreEntity['legendes']) && isset($coreEntity['legendes']['legend1'])) ? ucfirst($coreEntity['legendes']['legend1']) : '';
                $title = isset($coreEntity['name']) ? $coreEntity['name'] : "";
                $description = isset($coreEntity['description']) ? $coreEntity['description'] : "";
                $titleMessage = "title_rooms_".$viewType;
                $descriptionMessage = "description_rooms_".$viewType;
            }
            else if($type == 'room-kups') {
                $title = isset($coreEntity['name']) ? $coreEntity['name'] : "";
                $description = isset($coreEntity['description']) ? $coreEntity['description'] : "";
                $titleMessage = "title_room_kups_".$viewType;
                $descriptionMessage = "description_room_kups_".$viewType;
            }

            if($titleMessage != "" && $descriptionMessage != "") {
                $this->getResponse()->setTitle($this->getContext()->getI18N()->__($titleMessage, array(
                                                                                                         '%title%' => $title,
                                                                                                         '%date%' => $date,
                                                                                                         '%roomPrivacy%' => $roomPrivacy,
                                                                                                         '%author%' => $roomAuthor,
                                                                                                         '%roomTitle%' => $roomTitle
                                                                                                    )));
                $this->getResponse()->addMeta('description', $this->getContext()->getI18N()->__($descriptionMessage, array(
                                                                                                                         '%title%' => $title,
                                                                                                                         '%description%' => $description,
                                                                                                                         '%roomPrivacy%' => $roomPrivacy,
                                                                                                                         '%roomTitle%' => $roomTitle
                                                                                                                    )));
            }
        }

        /**
         * Returns the widget configuration given a room.
         *
         * @param array $room
         */
        protected function getRoomDataForWidget(array $coreRoom) {

            if (empty($coreRoom)) {
                return array();
            }

            $uuid = $coreRoom['uuid'];
            $name = $coreRoom['name'];
            $description = $coreRoom['description'];
            $privacy = $coreRoom['privacy'];

            $avatar = $coreRoom['avatar'];
            if ($avatar == "") {
                $avatar = sfConfig::get('mod_room_avatar_default');
            }

            // Creator is the fist admin
            if (count($coreRoom['admins']) > 0) {
                $admin = $coreRoom['admins'][0];
                $admin_name = $admin['firstName'] . " " . $admin['lastName'];
                $admin_email = $admin['email'];
                $admin_avatar = util::getAvatarForUser($admin['avatarSmall']);
                $admin_nickname = Util::getNicknameFor($admin);
            }
            else {
                // This case should never happend
                $admin_name = "";
                $admin_avatar = "";
                $admin_email = "";
                $admin_nickname = "";
            }

            // Check if the room is official
            $isOfficial = 0;
            foreach ($coreRoom['types'] as $tags) {
                if (in_array('label_team_type_official', $tags)) {
                    $isOfficial = 1;
                }
            }

            $openKups = 0;
            $jackpots = 0;
            foreach ($coreRoom['kups'] as $kup) {
                if ($kup['status'] != -1 && $kup['status'] < 4) {
                    $openKups += 1;
                    $jackpots += $kup['jackpot'];
                }
            }

            $data = array(
                'id'                      => $uuid,
                'uuid'                    => $uuid,
                'name'                    => $name,
                'author'                  => $admin_name,
                'author_nickname'         => $admin_nickname,
                'author_email'            => $admin_email,
                'authorPicture'           => $admin_avatar,
                'official'                => $isOfficial,
                'picture'                 => $avatar,
                'description'             => $description,
                'privacy'                 => $privacy,
                'numberOfKups'            => $coreRoom['numberOfKups'],
                'numberOfMembers'         => $coreRoom['numberOfMembers'],
                'numberOfFacebookMembers' => 0, // TODO implement me
                'legendes'                => array(
                    'legend1' => ($privacy == sfConfig::get('app_room_privacy_public') || $privacy == sfConfig::get('app_room_privacy_public_gambling_fr')) ? 'room publique' : 'room privée',
                    // XXX i18n
                    'legend3' => strval($openKups) . ' Open Kups',
                    'legend2' => $jackpots . '€ en jeu',
                    'legend4' => strval($coreRoom['numberOfMembers']) . ' membres',
                    'legend5' => strval(0) . ' membres'
                )
            );

            return $data;

        }

        /**
         * Count Rooms total search results given search params.
         *
         * <p>
         *
         * Useful because searchKups() is paged and UI might need the total number of results.
         *
         * @param sfWebRequest $request
         * @param array        $params
         */
        protected function countRooms(sfWebRequest $request, $params = array()) {

            $count = 0;
            $params['communityId'] = sfConfig::get('app_sofun_community_id');

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_POST("/team/search/count/get", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $count = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return $count;

        }

        /**
         * Search for rooms given parameters.
         *
         * @param sfWebRequest $request
         * @param array        $params
         */
        private function getRooms(sfWebRequest $request, $params = array()) {

            $rooms = array();
            $params['communityId'] = sfConfig::get('app_sofun_community_id');

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_POST("/team/search", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $rooms = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return $rooms;

        }

        /**
         * Save prediction in the predictionSave namespace of the user object.
         *
         * @param sfWebRequest $request
         */
        protected function saveDraftPredictions(sfWebRequest $request, $kup_uuid = '') {

            $this->predictions_ic = $request->getParameter('predictions_ic', array());
            $this->predictions_se = $request->getParameter('predictions_se', array());
            $this->predictions_q = $request->getParameter('predictions_q', array());
            $this->predictions_full = $request->getParameter('predictions_full', array());
            $this->predictions_tb = $request->getParameter('predictions_tb', array());
            $this->roundUUID = $request->getParameter('roundUUID', '');

            // Stores predictions in user's session. Used to display publish messages and possibly for offline users.
            $this->getUser()->setAttribute('roundUUID', $this->roundUUID, 'predictionsSave');
            $this->getUser()->setAttribute('kup_uuid', $kup_uuid, 'predictionsSave');
            $this->getUser()->setAttribute('is_draft', '1', 'predictionsSave');
            $this->getUser()->setAttribute('predictions_ic', $this->predictions_ic, 'predictionsSave');
            $this->getUser()->setAttribute('predictions_se', $this->predictions_se, 'predictionsSave');
            $this->getUser()->setAttribute('predictions_q', $this->predictions_q, 'predictionsSave');
            $this->getUser()->setAttribute('predictions_full', $this->predictions_full, 'predictionsSave');
            $this->getUser()->setAttribute('predictions_tb', $this->predictions_tb, 'predictionsSave');
        }


        /**
         * Search for kups of rooms given parameters.
         *
         * @param sfWebRequest $request
         * @param array        $params
         */
        protected function getRoomKups(sfWebRequest $request, $params = array()) {

            if (!isset($params['uuid']) || $params['uuid'] == '') {
                $uuid = BetkupWrapper::getRoomUUID($request);
            }
            else {
                $uuid = $params['uuid'];
            }

            $hash = md5(implode('_', $params));
            $with_security = true;
            $ttl = 10;
            $cacheKey = 'room_kups_' . $uuid .'_for_'.$hash;
            if ($this->getUser()->isAuthenticated()) {
                if (isset($params['with_security']) && $params['with_security'] != true) {
                    $with_security = false;
                    $ttl = 3600;
                }
                else {
                    $cacheKey = 'room_kups_' . $uuid .'_for_'.$hash.'_'. $this->getUser()->getAttribute('subscriberId', '', 'subscriber');
                }
            } else {
                $ttl = 3600;
            }
            $roomKups = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($roomKups)) {
                $roomKups = BetkupWrapper::getRoomKups($request, $this, $params);
                if (!empty($roomKups)) {
                    sfMemcache::getInstance()->set($cacheKey, $roomKups, 0, $ttl);
                }
            }
            return $roomKups;
        }

        /**
         * Returns the room UUID from a room context.
         *
         * The URL pattern is:
         *
         *     /room/<uuid>/<action>
         *
         * @return int or -1 if not found
         */
        private function getRoomUUID() {
            return BetkupWrapper::getRoomUUID($this);
        }

        /**
         * Search for kups given parameters
         *
         * @param sfWebRequest $request
         * @param array        $params
         */
        protected function searchKups(sfWebRequest $request, $params = array()) {

            $kups = array();

            $params['communityId'] = sfConfig::get('app_sofun_community_id');
            if (!in_array('isTemplate', $params)) {
                $params['isTemplate'] = 1;
            }

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_POST("/kup/search/", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $kups = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return $kups;

        }


        /**
         * Get room datas for UI widgets
         *
         * @return array
         *
         * @param sfWebRequest $request
         */
        protected function getRoomsData(sfWebRequest $request, $params = array()) {
            $rooms = array();
            $coreRooms = $this->getRooms($request, $params);
            $i = 0;
            foreach ($coreRooms as $coreRoom) {
                $rooms[$i] = $this->getRoomDataForWidget($coreRoom);
                $i++;
            }
            return $rooms;
        }

        /**
         * Get room tags from gaming platform.
         *
         * @return array
         *
         * @param sfWebRequest $request
         */
        private function getRoomTags(sfWebRequest $request) {

            $tags = array();
            $limit = sfConfig::get("mod_room_tags_limit");

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_GET("/team/tags/" . $limit . "/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $tags = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return ($tags);

        }

        /**
         * Get room types from gaming platform.
         *
         * @return array
         *
         * @param sfWebRequest $request
         */
        private function getRoomTypes(sfWebRequest $request) {

            $types = array();

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_GET("/team/types/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $types = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return ($types);

        }

        /**
         * Retyrns the room type names.
         *
         * @param array $room
         */
        protected function getRoomTypesNameFor($room) {

            $types = $room['types'];

            $names = array();

            $offset = 0;
            foreach ($types as $type) {
                $names[$offset] = $type['name'];
                $offset += 1;
            }

            return $names;

        }

        /**
         * Get room type names from gaming platform.
         *
         * @return array
         *
         * @param sfWebRequest $request
         */
        protected function getRoomTypeNames(sfWebRequest $request) {

            $names = array();

            $types = $this->getRoomTypes($request);

            $offset = 0;
            foreach ($types as $type) {
                if ($type['name'] != 'Official') {
                    $names[$offset] = $type['name'];
                    $offset++;
                }
            }

            return $names;

        }

        /**
         * Get room privacy types from gaming platform.
         *
         * @return array
         *
         * @param sfWebRequest $request
         */
        protected function getRoomPrivacyTypes(sfWebRequest $request) {

            $types = array();

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_GET("/team/privacy/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $types = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return ($types);

        }

        /**
         * Returns a room given its UUID.
         *
         * @param sfWebRequest $request
         * @param int          $uuid
         */
        protected function getRoom(sfWebRequest $request, $uuid) {
            return BetkupWrapper::getRoom($request, $uuid, $this);
        }

        /**
         * Returns a room given its UUID.
         *
         * @param sfWebRequest $request
         * @param int          $uuid
         */
        protected function getRoomByName(sfWebRequest $request, $name = '') {
            return BetkupWrapper::getRoomByName($request, $this, $name);
        }

        /**
         * Returns the room tag names
         *
         * @param array $room
         */
        protected function getRoomTagNames($room) {

            $tags = $room['tags'];

            $names = array();

            $offset = 0;
            foreach ($tags as $tag) {
                $names[$offset] = $tag['name'];
                $offset += 1;
            }

            return $names;

        }

        /**
         * Returns the data to build up friends search filters
         *
         * @param sfWebRequest $request
         */
        protected function getFriendsSearchDataWidget(sfWebRequest $request) {

            $data = array(
                'item1' => array(
                    'id'      => '1',
                    'name'    => $this->getContext()->getI18n()->__('label_room_search_facebook_friends'),
                    'picture' => ''
                )
            );

            return $data;

        }

        /**
         * Get room tags data for search widgets.
         *
         * @return array
         *
         * @param sfWebRequest $request
         */
        protected function getRoomTagsDataForSearchWidgets(sfWebRequest $request) {

            $tags = array();
            $coreTags = $this->getRoomTags($request);

            $offset = 1;
            foreach ($coreTags as $coreTag) {

                $name = $coreTag['name'];
                $msgId = $coreTag['msgId'];
                $score = $coreTag['score'];

                $tags[$offset - 1] = array(
                    'name'  => $this->getContext()->getI18n()->__($name),
                    'score' => $score,
                    'form'  => 'input_room_tag_' . strval($offset)
                );

                $offset++;

            }

            return ($tags);
        }

        /**
         * Automatically have the player joined the room if he has not yet.
         *
         * @param sfWebRequest $request
         * @param string       $room_uuid
         */
        protected function joinRoom(sfWebRequest $request, $room_uuid = '') {
            if($room_uuid != '') {

                // Get the room privacy and room credentials for the user.
                $email = $this->getUser()->getAttribute('email', '0', 'subscriber');
                $cacheKey = 'room_credentials_and_privacy_for_'.str_replace(array('-', '.', '@'), '_', $email).'_' . $room_uuid;
                $response = sfMemcache::getInstance()->get($cacheKey, array());
                if(empty($response)) {

                    $sofun = BetkupWrapper::_getSofunApp($request, $this);
                    try {
                        $response = $sofun->api_GET("/team/" . $room_uuid . "/member/" . $email . "/security");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if(!empty($response)) {
                        sfMemcache::getInstance()->set($cacheKey, $response, 0, 0);
                    }
                }
                $roomCredentials = array();
                $roomPrivacy = '';
                if (!empty($response) && isset($response['buffer']) && !empty($response['buffer'])) {
                    foreach ($response['buffer'] as $i => $buffer) {
                        if ($i == 0) {
                            $roomPrivacy = $buffer;
                        }
                        else {
                            $roomCredentials[] = $buffer;
                        }
                    }
                }

                // The user is not a Room member.
                $module = $this->getModuleName();
                if( !in_array(sfConfig::get('mod_'.$module.'_security_sofun_member'), $roomCredentials) &&
                    !in_array(sfConfig::get('mod_'.$module.'_security_sofun_administrator'), $roomCredentials)) {

                    // The Room privacy is public or the user is has a gambling account.
                    if($roomPrivacy == sfConfig::get('app_room_privacy_public')
                        ||
                        $this->getUser()->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_'.$module.'_registration_account_type_gambling_fr')
                        ||
                        $this->getUser()->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_'.$module.'_registration_account_type_gambling_fr_verified')
                    ) {
                        // Add the user to the room.
                        $email = $this->getUser()->getAttribute('email', '', 'subscriber');
                        $params = array(
                            'email'       => $email,
                            'communityId' => sfConfig::get('app_sofun_community_id')
                        );
                        $sofun = BetkupWrapper::_getSofunApp($request, $this);
                        try {
                            $response = $sofun->api_POST("/team/" . $room_uuid . "/member/add", $params);
                        } catch (SofunApiException $e) {
                            error_log($e);
                        }
                        if($response['http_code'] == 202) {
                            $this->getLogger()->debug("JOIN ROOM : The user has been added to room ".$room_uuid);

                            // When the user is added to the room, we have to update the cache. Then we flush it.
                            sfMemcache::getInstance()->set($cacheKey, array(), 0, 1);

                            // The user has been added to the Room. Let's show a custom flash message.
                            $this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('flash_login_added_to_room_auto_join'));

                            // Redirect to Room kup view if needed.
                            $this->redirectToRoomView($request);
                        }

                        // If the user doesn't have gambling account and Room privacy need one,
                        // we redirect the user to account update to create one.
                    } else if($roomPrivacy == sfConfig::get('app_room_privacy_public_gambling_fr')) {

                        if($this->getUser()->getAttribute('account_type', '', 'subscriber') != sfConfig::get('mod_'.$module.'_registration_account_type_gambling_fr')
                            ||
                            $this->getUser()->getAttribute('account_type', '', 'subscriber') != sfConfig::get('mod_'.$module.'_registration_account_type_gambling_fr_verified')
                        ) {
                            $registeringParams = array();
                            if ($request->getParameter('need_advanced_account', '') == 1) {
                                $registeringParams['room_uuid'] = $request->getParameter('uuid', '');
                            }
                            if ($request->getParameter('redirect_route', '') != '') {
                                $registeringParams['redirect_route'] = $request->getParameter('redirect_route', '');
                            }
                            if($request->getParameter('kup_uuid', '0') != '0') {
                                $registeringParams['kup_uuid'] = $request->getParameter('kup_uuid', '0');
                            }

                            // We delete the notice flash.
                            $this->getUser()->setFlash('notice', '');
                            $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_need_advanced_account_to_join_room'));

                            if($this->getUser()->isAuthenticated()) {
                                if(count($registeringParams) > 2 && isset($registeringParams['kup_uuid'])) {
                                    $this->redirect('account_register_update_room_kup', $registeringParams);
                                }
                                else {
                                    $this->redirect('account_update');
                                }
                            } else {
                                if(count($registeringParams) > 2 && isset($registeringParams['kup_uuid'])) {
                                    $this->redirect('account_register_advanced_room_kup', $registeringParams);
                                }
                                else {
                                    $this->redirect('account_register_advanced');
                                }
                            }
                        }
                    }
                }
                else {
                    $this->redirectToRoomView($request);
                }
            }
        }

        /**
         * Redirect to Room kup view if specific parameters are given into the request.
         *
         * Typically used to redirect the user after prediction to the Room kup view after login.
         *
         * @param sfWebRequest $request
         */
        private function redirectToRoomView(sfWebRequest $request) {

            $room_uuid = $request->getParameter('room_uuid', '');
            $kup_uuid = $request->getParameter('kup_uuid', '');
            $redirect_route = $request->getParameter('redirect_route', '');

            if($room_uuid != '' && $kup_uuid != '' && $redirect_route != '') {
                $this->redirect(array(
                                     'module' => 'room',
                                     'action' => 'kup',
                                     'kup_uuid' => $kup_uuid,
                                     'room_uuid' => $room_uuid
                                ));
            }
        }
        /**
         * Get room types data for search widgets.
         *
         * @return $array
         *
         * @param sfWebRequest $request
         */
        protected function getRoomTypesDataForSearchWidgets(sfWebRequest $request) {

            $types = array();
            $coreTypes = $this->getRoomTypes($request);

            $offset = 1;
            foreach ($coreTypes as $coreType) {

                $types["item" . strval($offset + 1)] = array(
                    'id'      => $coreType['name'],
                    'name'    => $this->getContext()->getI18n()->__($coreType['msgId']),
                    'picture' => '',
                );

                $offset++;
            }

            return $types;

        }

        /**
         * Returns kup data for search widget
         *
         * @return array
         *
         * @param sfWebRequest $request
         */
        protected function getKupDataForSearchWidgets(sfWebRequest $request) {

            $kupsData = array();
            $kups = $this->searchKups($request);

            $offset = 0;
            foreach ($kups as $kup) {

                $kupsData['item' . strval($offset + 1)] = array(
                    'id'      => $kup['uuid'],
                    'name'    => $this->getContext()->getI18n()->__($kup['name']),
                    'picture' => 'kup/search/pictoMultimini.png', // XXX needed by widget?
                );

                $offset += 1;

            }

            unset($kups);

            return $kupsData;

        }

        /**
         * Returns the room privacy type data for search widgets.
         *
         * @return array
         *
         * @param sfWebRequest $request
         */
        protected function getRoomPrivacyTypeDataForSearchWidgets(sfWebRequest $request) {

            $coreTypes = $this->getRoomPrivacyTypes($request);

            $types = array();

            $offset = 0;
            foreach ($coreTypes as $type) {
                $types["item" . strval($offset + 1)] = array(
                    'id'      => $offset + 1,
                    'name'    => $this->getContext()->getI18n()->__($type),
                    'picture' => ''
                );
                $offset++;
            }

            return $types;

        }

        /**
         * Returns the community ranking table.
         *
         * @param sfWebRequest $request
         * @param int          $start
         * @param int          $batch_size
         */
        protected function getCommunityRanking(sfWebRequest $request, $start = 0, $batch_size = 10) {

            $ranking = array();

            $communityId = sfConfig::get('app_sofun_community_id');

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_GET("/community/" . $communityId . "/ranking/" . $start . "/" . $batch_size . "/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $ranking = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return $ranking;

        }

        /**
         * Returns Kup's data given a core Kup
         *
         * @param array        $coreKup
         * @param sfWebRequest $request
         */
        protected function getKupDataFor($kup, sfWebRequest $request, $with_security = true) {
            return BetkupWrapper::getKupDataFor($kup, $request, $this, $with_security);
        }

        /**
         * Returns Kups data for UI display.
         *
         * @param sfWebRequest $request
         * @param array        $params
         */
        protected function getKupsData(sfWebRequest $request, $params = array(), $with_batch_info = false, $with_security = true) {
            $kups = $this->searchKups($request, $params);
            $offset = 0;
            $kupsData = array();
            foreach ($kups['results'] as $kup) {
                $kupsData[$offset] = $this->getKupDataFor($kup, $request, $with_security);
                $offset++;
            }
            $kups['results'] = $kupsData;
            if ($with_batch_info != true) {
                return $kups['results'];
            }
            return $kups;

        }

        /**
         * Returns Kup's data given it's uuid
         *
         * @param sfWebRequest $request
         * @param int          $uuid
         * @param boolean|int      $fetch
         */
        protected function getKupData(sfWebRequest $request, $uuid, $fetch = 0) {
            return BetkupWrapper::getKupData($request, $uuid, $this, $fetch);
        }

        /**
         * Returns the Kups names.
         *
         * @param unknown_type $kups_data
         */
        protected function getKupNames($kups_data) {

            $names = array();

            $offset = 0;
            foreach ($kups_data as $kup) {
                $names[$offset] = $kup['name'];
                $offset += 1;
            }

            return $names;

        }

        /**
         * Returns ranking data for UI widget.
         *
         * @param sfWebRequest $request
         */
        protected function getRankingData(sfWebRequest $request, $ranking) {

            $rankingData = array();

            $offset = 0;
            foreach ($ranking['entries'] as $entry) {

                $position = $entry['position'];
                $value = $entry['value'];

                $member = $entry['member'];
                $name = $member['firstName'] . " " . $member['lastName'];
                $avatar = $member['avatarSmall'];
                $nickname = Util::getNicknameFor($member);

                // Handle Facebook avatar in PLAIN HTTP
                if (is_string($avatar) && util::startswith($avatar, "http://")) {
                    $count = 1;
                    $avatar = str_replace("http", "https", $avatar, $count);
                }

                $color = 'fonce';
                if ($offset % 2) {
                    $color = 'clair';
                }

                $rankingData[$offset] = array(
                    'cellColor'   => $color,
                    'position'    => $position,
                    'progression' => 'equals.png',
                    'photo'       => $avatar,
                    'title'       => $name,
                    'points'      => $value,
                    'nickName'    => $nickname
                );

                $offset++;
            }

            unset($ranking);
            return $rankingData;
        }

        /**
         * Returns the community feed rankin.
         *
         * @param sfWebRequest $request
         * @param int          $start
         * @param int          $batch_size
         */
        protected function getCommunityFeed(sfWebRequest $request, $start = 0, $batch_size = 10) {

            $feed = array();

            $communityId = sfConfig::get('app_sofun_community_id');

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_GET("/community/" . $communityId . "/feed/0/50/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $feed = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return $feed;

        }

        /**
         * Returns the feed for a given room.
         *
         * @param sfWebRequest $request
         * @param int          $room_uuid
         */
        protected function getRoomFeedData(sfWebRequest $request, $room_uuid) {

            $feed = array();

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_GET("/team/" . $room_uuid . "/feed/0/50/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $feed = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return $feed;


        }

        /**
         * Returns the room ranking table
         *
         * @param sfWebRequest $request
         * @param int          $room_uuid
         */
        protected function getRoomRanking(sfWebRequest $request, $room_uuid, $offset = 0, $batch = 50, $friends_only = false, $userMember = true) {
            return BetkupWrapper::getRoomRanking($request, $room_uuid, $this, $offset, $batch, $friends_only, $userMember);
        }

        /**
         * Returns the activity feed data.
         *
         * @param sfWebRequest $request
         * @param: array() $feed
         */
        protected function getFeedData(sfWebRequest $request, $feed) {

            $feedData = array();

            $offset = 0;
            $entries = $feed['feedEntries'];

            foreach ($entries as $entry) {

                $color = 'fonce';
                if ($offset % 2) {
                    $color = 'clair';
                }

                $member = $entry['member'];
                $name = $member['firstName'] . " " . $member['lastName'];
                $avatar = $member['avatarSmall'];

                // Handle Facebook avatar in PLAIN HTTP
                if (is_string($avatar) && util::startswith($avatar, "http://")) {
                    $count = 1;
                    $avatar = str_replace("http", "https", $avatar, $count);
                }

                $eventMsgId = $entry['content'];
                $date = $entry['date'];

                $feedData[$offset] = array(
                    'cellColor' => $color,
                    'picto'     => 'community.png', // XXX make this dynamic
                    'avatar'    => $avatar,
                    'title'     => $this->getContext()->getI18n()->__($eventMsgId),
                    'ago'       => Util::displayDiffFromTimestamp($date),
                );

                $offset++;
            }

            unset($feed);
            return $feedData;

        }

        /**
         * Returns the Kup's rounds.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         */
        private function getKupRounds(sfWebRequest $request, $kup_uuid) {
            return BetkupWrapper::getKupRounds($request, $kup_uuid, $this);
        }

        protected function getKupRoundsData(sfWebRequest $request, $kup_uuid, $status = array('SCHEDULED')) {
            return BetkupWrapper::getKupRoundsData($request, $kup_uuid, $this);
        }

        /**
         * Returns the Kup's games.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         */
        private function getKupGames(sfWebRequest $request, $kup_uuid, $status = 'SCHEDULED') {
            return BetkupWrapper::getKupGames($request, $kup_uuid, $this);
        }

        /**
         * Returns an array from player uuid => player name
         *
         * Used to populate select boxes.
         *
         * @param sfWebRequest $request
         * @param long         $team_id
         */
        protected function getTeamPlayerNames(sfWebRequest $request, $team_id) {
            return BetkupWrapper::getTeamPlayerNames($request, $team_id, $this);
        }

        protected function getPlayerNameByUUID($players, $uuid) {
            return BetkupWrapper::getPlayerNameByUUID($players, $uuid);
        }

        protected function getF1TeamByUUID($request, $kup_uuid, $team_uuid, $kupData = array()) {
            return BetkupWrapper::getF1TeamByUUID($request, $kup_uuid, $team_uuid, $this, $kupData);
        }

        /**
         * Returns the players of a given team.
         *
         * @param sfWebRequest $request
         * @param long         $player_id
         *
         * @return array
         */
        protected function getTeamPlayers(sfWebRequest $request, $team_id) {
            return BetkupWrapper::getTeamPlayers($request, $team_id, $this);
        }

        /**
         * Returns the Kups's game data
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param int          $round_uuid
         */
        protected function getKupGamesData(sfWebRequest $request, $kup_uuid, $round_uuid = NULL, $future = false, $status = '') {
            return BetkupWrapper::getKupGamesData($request, $this, $kup_uuid, $round_uuid, $future, $status);
        }

        /**
         * Returns the Kup's stages.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         */
        private function getKupStages(sfWebRequest $request, $kup_uuid) {


            $stages = array();

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_GET("/kup/" . $kup_uuid . "/stages/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $stages = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return $stages;

        }

        /**
         * Returns the Kup's seasons.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         */
        private function getKupSeasons(sfWebRequest $request, $kup_uuid) {

            $seasons = array();

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_GET("/kup/" . $kup_uuid . "/seasons/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $seasons = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return $seasons;

        }

        /**
         * Saves player's predictions.
         *
         * @param sfWebRequst $request
         * @param array       $predictions
         * @param in          $kupUUID
         */
        protected function savePredictions(sfWebRequest $request, $kupUUID, $ic = array(), $se = array(), $q = array(), $full = array(), $params = array(), $tb = array()) {
            BetkupWrapper::savePredictions($request, $kupUUID, $this, $ic, $se, $q, $full, $params, $tb);
        }

        /**
         * Get player's predictions if any.
         *
         * @param sfWebRequest $request
         * @param in           $kupUUID
         */
        protected function getPredictions(sfWebRequest $request, $kupUUID, $type) {
            return BetkupWrapper::getPredictions($request, $kupUUID, $type, $this);
        }

        protected function getPredictionsLastModified(sfWebRequest $request, $kupUUID) {
            return BetkupWrapper::getPredictionsLastModified($request, $kupUUID, $this);
        }

        /**
         * Get user predictions for one kup
         *
         * @param int    $kup_uuid
         * @param string $predictionType
         *
         * @return array
         */
        protected function getF1Predictions($request, $kup_uuid, $type, $coreResults = null, $kupData = array()) {
            return BetkupWrapper::getF1Predictions($request, $kup_uuid, $type, $this, $coreResults, $kupData);
        }

        protected function saveF1Predictions(sfWebRequest $request, $type, $kup_uuid, $predictions, $kupData = array(), $kupRoundsData = array()) {
            return BetkupWrapper::saveF1Predictions($request, $type, $kup_uuid, $predictions, $this, $kupData, $kupRoundsData);
        }

        /**
         * Get driver data including UI elements and properties.
         */
        protected function getF1DriverDataFor($coreDriver) {
            return BetkupWrapper::getF1DriverDataFor($coreDriver);
        }

        /**
         * Get the driver's list for a given Kup.
         *
         * @param int $kup_uuid
         *
         * @return array
         */
        protected function getF1Drivers($request, $kup_uuid, $kupData = array()) {
            return BetkupWrapper::getF1Drivers($request, $kup_uuid, $this, $kupData);
        }

        /**
         * Get the driver infos by it's uuid
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param int          $driver_uuid
         * @param array        $kupData
         */
        protected function getF1DriverByUUID($request, $kup_uuid, $driver_uuid, $kupData = array()) {
            return BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $driver_uuid, $this, $kupData);
        }

        /**
         * Returns a filtered list of drivers given a player prediction.
         *
         * <p>
         *
         * Drivers in predictions will be removed.
         *
         * @param array $drivers
         * @param array $userPredictions
         *
         * @return array $fiteredDrivers
         */
        protected function getF1DriversFilteredBy($drivers, $userPredictions) {
            return BetkupWrapper::getF1DriversFilteredBy($drivers, $userPredictions);
        }

        /**
         * Returns results data including driver's data for UI display.
         *
         * @param unknown_type $request
         * @param unknown_type $kup_uuid
         * @param unknown_type $type
         */
        protected function getF1Results($request, $kupData, $kup_uuid, $type) {
            return BetkupWrapper::getF1Results($request, $kupData, $kup_uuid, $type, $this);
        }


        /**
         * Filter rounds depending on games.
         *
         * @param array $rounds
         */
        protected function filterVisibleRounds($rounds) {

            $visibles = array();

            $offset = 0;
            foreach ($rounds as $round) {
                if ($round['status'] == 'SCHEDULED' || $round['status'] == 'ON_GOING') {
                    $visibles[$offset] = $round;
                    $offset += 1;
                }
            }

            return $visibles;

        }

        /**
         * Returns the tournament's season teams.
         *
         * @param sfWebRequest $request
         * @param long         $seasonId
         */
        protected function getSeasonTeams(sfWebRequest $request, $seasonId) {
            return BetkupWrapper::getSeasonTeams($request, $seasonId, $this);
        }

        /**
         * Returns the tournament's season players.
         *
         * @param sfWebRequest $request
         * @param long         $seasonId
         */
        protected function getSeasonPlayers(sfWebRequest $request, $seasonId) {
            return BetkupWrapper::getSeasonPlayer($request, $seasonId, $this);
        }

        protected function getTeamByISO($teams, $iso) {

            foreach ($teams as $team) {
                if ($iso == $team['country']['iso']) {
                    return $team;
                }
            }

            return array();

        }

        protected function getTeamByUUID($teams, $uuid) {
            foreach ($teams as $team) {
                if ($uuid == $team['uuid']) {
                    return $team;
                }
            }
            return array();
        }


        /**
         * Get messages for predictions on a facebook predictions publish
         *
         * @param sfWebRequest $request
         * @param array        $kupData
         *
         * @return string
         */
        protected function getFacebookPublishMessageFor($request, $kupData) {

            $properties = array();

            // Facebook requires a "key" => "value" mapping used within the publish message.
            // Note, we need to localize it. (based on betkup not facebook localization)

            $description = $this->getContext()->getI18n()->__('label_facebook_publish_description');
            $kup = $this->getContext()->getI18n()->__('label_facebook_publish_kup');
            $stake = $this->getContext()->getI18n()->__('label_facebook_publish_stake');
            $jackpot = $this->getContext()->getI18n()->__('label_facebook_publish_jackpot');
            $predictions = $this->getContext()->getI18n()->__('label_facebook_publish_predictions');

            $properties[$description] = $kupData['description'];
            $properties[$kup] = $kupData['type'] == sfConfig::get("mod_kup_type_free") ? 'Gratuite' : 'Payante'; // XXX i18n
            $properties[$stake] = $kupData['stake'] . '€';
            $properties[$jackpot] = $kupData['jackpot'] . '€';
            $properties[$predictions] = '';

            $predictions_se = $this->getUser()->getAttribute('predictions_se', '', 'predictionsSave');
            $predictions_ic = $this->getUser()->getAttribute('predictions_ic', '', 'predictionsSave');
            if ($predictions_se != '' || $predictions_ic != '') {
                // Case of SE
                foreach ($predictions_se as $key => $prediction) {
                    $explodedKey = explode('_', $key);
                    $gameUUID = $explodedKey[0];
                    $homeOrAway = isset($explodedKey[1]) ? $explodedKey[1] : 0;
                    $game = $this->getCoreSportGameByUUID($request, $gameUUID);
                    if ($homeOrAway == 1) {
                        $properties[$predictions] .= $game['teams'][0]['name'] . ' ' . $prediction;
                    }
                    else if ($homeOrAway == 2) {
                        $properties[$predictions] .= ' - ' . $prediction . ' ' . $game['teams'][1]['name'] . ', ';
                    }
                }
                // Case of IC
                foreach ($predictions_ic as $key => $prediction) {
                    $explodedKey = explode('_', $key);
                    $gameUUID = $explodedKey[0];
                    $game = $this->getCoreSportGameByUUID($request, $gameUUID);
                    $properties[$predictions] .= $game['teams'][0]['name'] . ' vs ' . $game['teams'][1]['name'] . ' : ';
                    if ($prediction == 2) {
                        $properties[$predictions] .= 'match nul'; // XXX i18n
                    }
                    else if ($prediction == 1) {
                        $properties[$predictions] .= $game['teams'][0]['name'];
                    }
                    else if ($prediction == 3) {
                        $properties[$predictions] .= $game['teams'][1]['name'];
                    }
                    $properties[$predictions] .= ', ';
                }
                $properties[$predictions] = substr($properties[$predictions], 0, -2);
            }

            return $properties;
        }

        /**
         * Get the message for facebook predictions publish.
         *
         * @param array $kupData
         *
         * @return string
         */
        protected function getPublishFacebookMessageFor($kupData) {
            return $this->getContext()->getI18n()->__('text_invite_publish_predictions', array('%name%' => $kupData['title']));
        }

        /**
         * Returns a core sport game given its UUID.
         *
         * @param unknown_type $request
         * @param unknown_type $uuid
         */
        protected function getCoreSportGameByUUID($request, $uuid) {
            $game = array();
            $cacheKey = 'sport_game_' . $uuid;
            $game = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($game)) {
                $sofun = BetkupWrapper::_getSofunApp($request, $this);
                try {
                    $response = $sofun->api_GET("/sport/game/" . $uuid . "/get");
                } catch (SofunApiException $e) {
                    error_log($e);
                }
                if ($response["http_code"] != "202") {
                    error_log($response['buffer']);
                }
                else {
                    $game = $response['buffer'];
                }
                if (!empty($game)) {
                    sfMemcache::getInstance()->set($cacheKey, $game);
                }
            }
            return $game;
        }

        /**
         * Returns a core sport team given its UUID.
         *
         * <p>
         *
         * Will be fetch stored in cache after first hit.
         *
         * @param unknown_type $request
         * @param unknown_type $uuid
         */
        protected function getCoreSportTeamByUUID($request, $uuid) {
            $team = array();
            $cacheKey = 'sport_team_' . $uuid;
            $team = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($team)) {
                $sofun = BetkupWrapper::_getSofunApp($request, $this);
                try {
                    $response = $sofun->api_GET("/sport/team/" . $uuid . "/get");
                } catch (SofunApiException $e) {
                    error_log($e);
                }
                if ($response["http_code"] != "202") {
                    error_log($response['buffer']);
                }
                else {
                    $team = $response['buffer'];
                }
                if (!empty($team)) {
                    sfMemcache::getInstance()->set($cacheKey, $team);
                }
            }
            return $team;
        }

        /**
         * Returns a Kup Rankin Table
         *
         * @param long $team_uuid
         * @param int  $offset
         * @param int  $batchSize
         */
        protected function getKupRanking(sfWebRequest $request, $team_uuid, $offset = 0, $batchSize = 20, $friends_only = false, $userMember = true) {
            return BetkupWrapper::getKupRanking($request, $team_uuid, $this, $offset, $batchSize, $friends_only, $userMember);
        }

        /**
         * Prepare results for display.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid the Kup UUID
         */
        protected function _results(sfWebRequest $request, $kup_uuid) {

        }

        /**
         * Custom view predictions factoring for apps.
         *
         * @param sfWebRequest $request
         * @param string       $parentModule
         * @param string       $parentAction
         * @param number       $kup_uuid
         * @param number       $room_uuid
         * @param array        $kupData
         */
        protected function _appView(sfWebRequest $request, $parentModule, $parentAction, $kup_uuid, $room_uuid = 0, $kupData = null) {

            $this->kupRoundsData = $this->getKupRoundsData($request, $kup_uuid);
            if ($this->roundUUID == '') {
                if (count($this->kupRoundsData) > 0) {
                    $this->roundUUID = $this->getRoundUUID($request, $kup_uuid, $this->kupRoundsData);
                }
            }
            $this->kupGamesData = $this->getKupGamesData($request, $kup_uuid, $this->roundUUID, false, '');
            $this->lastModified = $this->getPredictionsLastModified($request, $kup_uuid);

            // Member saves predictions. No need to retrieve them.
            if ($request->isMethod('post')) {

                $this->predictions_ic = $request->getParameter('predictions_ic', array());
                $this->predictions_se = $request->getParameter('predictions_se', array());
                $this->predictions_q = $request->getParameter('predictions_q', array());
                $this->predictions_tb = $request->getParameter('predictions_tb', array());

                // Stores predictions in user's session. Used to display publish messages and possibly for offline users.
                $this->getUser()->setAttribute('predictions_ic', $this->predictions_ic, 'predictionsSave');
                $this->getUser()->setAttribute('predictions_se', $this->predictions_se, 'predictionsSave');
                $this->getUser()->setAttribute('predictions_q', $this->predictions_q, 'predictionsSave');
                $this->getUser()->setAttribute('predictions_tb', $this->predictions_tb, 'predictionsSave');

                if ($this->getUser()->isAuthenticated()) {
                    $this->savePredictions($request, $kup_uuid, $this->predictions_ic, $this->predictions_se, $this->predictions_q, array(), array(), $this->predictions_tb);
                    if ($kupData != null && isset($kupData['type']) && $kupData['type'] == sfConfig::get('mod_kup_type_gambling_fr')) {
                        $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_gambling_kup_bet'));
                    }
                    if ($room_uuid != 0) {
                        $this->redirect($this->getController()->genUrl(array(
                                                                            'module'    => $parentModule,
                                                                            'action'    => $parentAction,
                                                                            'kup_uuid'  => $kup_uuid,
                                                                            'room_uuid' => $room_uuid
                                                                       )));
                    }
                    else {
                        $this->redirect($this->getController()->genUrl(array(
                                                                            'module' => $parentModule,
                                                                            'action' => $parentAction,
                                                                            'uuid'   => $kup_uuid
                                                                       )));
                    }
                }
                else {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_failed_must_login'));
                    $this->forward('account', 'login');
                }
            }
            else {
                if ($this->getUser()->isAuthenticated()) {
                    // Retrieve predictions
                    $this->predictions_ic = $this->getPredictions($request, $kup_uuid, 'ic');
                    if (!empty($this->predictions_ic)) {
                        $this->predictions_ic = $this->predictions_ic[0];
                    }
                    $this->predictions_se = $this->getPredictions($request, $kup_uuid, 'se');
                    if (!empty($this->predictions_se)) {
                        $this->predictions_se = $this->predictions_se[0];
                    }
                    $this->predictions_q = $this->getPredictions($request, $kup_uuid, 'q');
                    if (!empty($this->predictions_q)) {
                        $this->predictions_q = $this->predictions_q[0];
                    }
                    $this->predictions_tb = $this->getPredictions($request, $kup_uuid, 'tb');
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
         * Get the default round (next game) to display for a kup
         *
         * @param sfWebRequest $request
         * @param integer      $kup_uuid
         * @param array        $kupRoundsData
         */
        protected function getRoundUUID(sfWebRequest $request, $kup_uuid, $kupRoundsData) {
            return BetkupWrapper::getRoundUUID($request, $kup_uuid, $kupRoundsData, $this);
        }

        /**
         * Logged in player has bet on Kup with uuid ?
         *
         * @param sfWebRequest $request
         * @param int          $uuid
         */
        protected function hasBet(sfWebRequest $request, $uuid) {
            return BetkupWrapper::hasBet($request, $uuid, $this);
        }

        /**
         * Logged in player has predictions on Kup with uuid ?
         *
         * @param sfWebRequest $request
         * @param int          $uuid
         */
        protected function hasPredictions(sfWebRequest $request, $uuid) {
            return BetkupWrapper::hasPredictions($request, $uuid, $this);
        }

        protected function _bet(sfWebRequest $request, $kup_uuid, $room_uuid = 0, $kupData = array()) {

            // Retrieve predictions to forward to ARJEL SENSOR
            // PHP is fucking retarded: have to do that kind of shit since impossible to use JSON...
            $this->predictions_se = "";
            $ser = $this->getPredictions($request, $kup_uuid, 'se');
            if (!empty($ser)) {
                foreach ($ser[0] as $k => $v) {
                    $this->predictions_se = $this->predictions_se . $k . ":" . $v . ";";
                }
            }
            $this->predictions_se = base64_encode($this->predictions_se);

            $this->predictions_q = "";
            $q = $this->getPredictions($request, $kup_uuid, 'q');
            if (!empty($q)) {
                foreach ($q[0] as $k => $v) {
                    $this->predictions_q = $this->predictions_q . $k . ":" . $v . ";";
                }
            }

            if ($kupData['ui']['typeSport'] == 'cycling' || $kupData['ui']['typeSport'] == 'f1') {

                $cycling_maillot_jaune = $this->getF1Predictions($request, $kup_uuid, 'cycling_maillot_jaune', NULL, $kupData);
                if (!empty($cycling_maillot_jaune)) {
                    $this->predictions_q = $this->predictions_q . $kupData['config']["seasonID"] . ':' . $cycling_maillot_jaune . ";";
                }
                $cycling_maillot_vert = $this->getF1Predictions($request, $kup_uuid, 'cycling_maillot_vert', NULL, $kupData);
                if (!empty($cycling_maillot_vert)) {
                    $this->predictions_q = $this->predictions_q . $kupData['config']["seasonID"] . ':' . $cycling_maillot_vert . ";";
                }
                $cycling_maillot_blanc = $this->getF1Predictions($request, $kup_uuid, 'cycling_maillot_blanc', NULL, $kupData);
                if (!empty($cycling_maillot_blanc)) {
                    $this->predictions_q = $this->predictions_q . $kupData['config']["seasonID"] . ':' . $cycling_maillot_blanc . ";";
                }
                $cycling_maillot_apois = $this->getF1Predictions($request, $kup_uuid, 'cycling_maillot_apois', NULL, $kupData);
                if (!empty($cycling_maillot_apois)) {
                    $this->predictions_q = $this->predictions_q . $kupData['config']["seasonID"] . ':' . $cycling_maillot_apois . ";";
                }

                if ($this->predictions_q == "") {
                    $this->predictions_q = $kupData['config']["seasonID"] . ':none;';
                }

            }

            $this->predictions_q = base64_encode($this->predictions_q);

            $this->predictions_ic = "";
            $icr = $this->getPredictions($request, $kup_uuid, 'ic');
            if (!empty($icr)) {
                foreach ($icr[0] as $k => $v) {
                    $this->predictions_ic = $this->predictions_ic . $k . ":" . $v . ";";
                }
            }
            $this->predictions_ic = base64_encode(json_encode($this->predictions_ic));

            if ($request->isMethod('post')) {

                $email = $this->getUser()->getAttribute('email', '', 'subscriber');

                $information = $request->getParameter('information');
                $stake = $information['betStakeValue'];
                $password = $information['betStakePassword'];

                $sofun = BetkupWrapper::_getSofunApp($request, $this);

                // verify password entered by player in bet form
                $hash_algo = sfConfig::get('app_crypto_password_hash');
                $hash = hash($hash_algo, $password);

                try {
                    $response = $sofun->api_GET("/member/" . $email . "/password/" . $hash . "/verify");
                } catch (SofunApiException $e) {
                    error_log($e);
                }
                if ($response['http_code'] != '202') {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("kup_bet_password_verification_failed"));
                }
                else {
                    // Place bet on Kup on behalf of player
                    try {
                        $response = $sofun->api_GET("/kup/" . $kup_uuid . "/member/" . $email . "/bet/place");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response['http_code'] == '202') {
                        // Notify ARJEL sensor of OP success
                        $this->setSensorOperationSuccessStatus();
                        $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__("kup_bet_placed_success"));
                        // Update credits in session.
                        try {
                            $response = $sofun->api_GET("/member/" . $email . "/properties");
                        } catch (SofunApiException $e) {
                            error_log($e);
                        }
                        if ($response['http_code'] == '202') {
                            $member_properties = $response['buffer'];
                            // Refresh user session (credit)
                            $this->getUser()->setAttribute('credit', $member_properties['credit'], 'subscriber');
                            $this->getUser()->setAttribute('transferable_credit', $member_properties['transferable_credit'], 'subscriber');
                            $this->getUser()->setAttribute('bets', $member_properties['bets'], 'subscriber');
                            // Forward to flow step 3 : invite friends
                            if (isset($information['betStakeRoomUuid']) && $information['betStakeRoomUuid'] != null && $information['betStakeRoomUuid'] != '') {
                                $this->redirect('room_kup_invite_step3', array(
                                                                              'kup_uuid'           => $information['betStakeKupUuid'],
                                                                              'room_uuid'          => $information['betStakeRoomUuid'],
                                                                              'is_room_kup_invite' => '1'
                                                                         ));
                            }
                            else {
                                $this->redirect('kup_bet_invite_step3', array('uuid' => $information['betStakeKupUuid']));
                            }
                        }
                    }
                    else {
                        $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("kup_bet_placed_failed"));
                    }
                }

            }

        }

        /**
         * Marks operation as successful for ARJEL Sensor
         */
        protected function setSensorOperationSuccessStatus() {
            // Only notify sensor if account type is gambling
            if ($this->getUser()->getAttribute('account_type', '', 'subscriber') == 'GAMBLING_FR') {
                header('Sofun-Sensor-Op-Status: 1');
            }
        }

        /**
         * Marks operation as successful for ARJEL Sensor
         */
        protected function setSensorUpdateAccountOperationSuccessStatus() {
            header('Sofun-Sensor-Op-Status: 1');
        }

        /**
         * Special case for account activation mixed up with status form
         */
        protected function setSensorOperationActivationSuccessStatus() {
            // Only notify sensor if account type is gambling
            if ($this->getUser()->getAttribute('account_type', '', 'subscriber') == 'GAMBLING_FR') {
                header('Sofun-Sensor-Op-Activation-Status: 1');
            }
        }

        /**
         * Format all uriPrefix to https if isSecure
         *
         * @param sfWebRequest $request
         */
        protected function getCustomUriPrefix($request) {
            if (sfConfig::get('app_is_secure_ssl') == true) {
                return str_replace('http:', 'https:', $request->getUriPrefix());
            }
            else {
                return $request->getUriPrefix();
            }
        }

        /**
         * Returns the actual view template for a Kup predictions' view.
         *
         * @param array $kupData: kup date including UI properties
         */
        protected function setPredictionsViewTemplate($kupData) {
            // Defaults
            $this->predictions_view_module = 'soccer';
            $this->predictions_view_component = 'predictions';
            // Check if custom templates defined
            if (isset($kupData['ui']['predictions_view_template'])) {
                $split = explode(',', $kupData['ui']['predictions_view_template']);
                $this->predictions_view_module = $split[0];
                $this->predictions_view_component = $split[1];
            }
        }

        /**
         * Returns the actual view template for a Kup results' view.
         *
         * @param array $kupData: kup data including UI properties
         */
        protected function setResultsViewTemplate($kupData) {
            // Defaults
            $this->predictions_view_module = 'soccer';
            $this->predictions_view_component = 'results';
            // Check if custom templates defined
            if (isset($kupData['ui']['results_view_template'])) {
                $split = explode(',', $kupData['ui']['results_view_template']);
                $this->predictions_view_module = $split[0];
                $this->predictions_view_component = $split[1];
            }
        }

        /**
         * Post login fixtures.
         *
         * @param sfWebRequest $request
         * @param array        $sofun_member
         */
        protected function _postLogin($request, $sofun_member) {

            $this->getUser()->setAuthenticated(true);
            $this->getUser()->addCredential('member');

            $memberAvatar = util::getAvatarForUser($sofun_member['avatarBig']);

            $this->getUser()->setAttribute('subscriberId', $sofun_member['uuid'], 'subscriber');
            $this->getUser()->setAttribute('firstName', $sofun_member['firstName'], 'subscriber');
            $this->getUser()->setAttribute('lastName', $sofun_member['lastName'], 'subscriber');
            $this->getUser()->setAttribute('email', $sofun_member['email'], 'subscriber');
            $this->getUser()->setAttribute('birthDate', $sofun_member['birthDate'], 'subscriber');
            $this->getUser()->setAttribute('policyAcceptanceDate', $sofun_member['policyAcceptanceDate'], 'subscriber');
            $this->getUser()->setAttribute('account_status', $sofun_member['status'], 'subscriber');
            $this->getUser()->setAttribute('account_type', $sofun_member['type'], 'subscriber');
            $this->getUser()->setAttribute('avatar', $memberAvatar, 'subscriber');
            $this->getUser()->setAttribute('type', $sofun_member['type'], 'subscriber');

            $facebookId = '';
            if (array_key_exists('facebookId', $sofun_member)) {
                $facebookId = $sofun_member['facebookId'];
            }
            $this->getUser()->setAttribute('facebookId', $facebookId, 'subscriber');

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_GET("/member/" . $sofun_member['email'] . "/properties");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response['http_code'] == '202') {
                $member_properties = $response['buffer'];

                $this->getUser()->setAttribute('title', $member_properties['title'], 'subscriber');
                $this->getUser()->setAttribute('last_login', $member_properties['last_login'], 'subscriber');
                $this->getUser()->setAttribute('nickName', $member_properties['nickName'], 'subscriber');

                $facebookName = '';
                if (array_key_exists('facebookName', $member_properties)) {
                    $facebookName = $member_properties['facebookName'];
                }
                $this->getUser()->setAttribute('facebookName', $facebookName, 'subscriber');

                if ($sofun_member['type'] == sfConfig::get('app_credentials_account_type_gambling_fr')) {
                    $member_credit = $member_properties['credit'];
                    if ($member_credit != '') {
                        $member_credit = round($member_credit, 2, PHP_ROUND_HALF_DOWN);
                    }
                    $member_transferable_credit = $member_properties['transferable_credit'];
                    if ($member_transferable_credit != '') {
                        $member_transferable_credit = round($member_transferable_credit, 2, PHP_ROUND_HALF_DOWN);
                    }
                    $member_bets = $member_properties['bets'];
                    $member_credit_currency = $member_properties['credit_currency'];
                    $member_max_amount_bet_weekly = $member_properties['max_amount_bet_weekly'];
                    $member_max_amount_credit_weekly = $member_properties['max_amount_credit_weekly'];
                    $this->getUser()->setAttribute('address_city', $member_properties['address_city'], 'subscriber');
                    $this->getUser()->setAttribute('address_zip', $member_properties['address_zip'], 'subscriber');
                    $this->getUser()->setAttribute('address_street', $member_properties['address_street'], 'subscriber');
                    $this->getUser()->setAttribute('address_country', $member_properties['address_country'], 'subscriber');
                }
                else {
                    $member_credit = 0;
                    $member_bets = 0;
                    $member_credit_currency = '';
                    $member_max_amount_bet_weekly = 0;
                    $member_max_amount_credit_weekly = 0;
                    $member_transferable_credit = 0;
                }

                $this->getUser()->setAttribute('credit', $member_credit, 'subscriber');
                $this->getUser()->setAttribute('transferable_credit', $member_transferable_credit, 'subscriber');
                $this->getUser()->setAttribute('credit_currency', $member_credit_currency, 'subscriber');
                $this->getUser()->setAttribute('max_amount_bet_weekly', $member_max_amount_bet_weekly, 'subscriber');
                $this->getUser()->setAttribute('max_amount_credit_weekly', $member_max_amount_credit_weekly, 'subscriber');
                $this->getUser()->setAttribute('bets', $member_bets, 'subscriber');

                $notifications = array();

                // CGU updates
                if (isset($member_properties['mustAcceptPolicy'])) {
                    $urls = $this->getCguRuleUrls();
                    $cguUrl = $urls["cguUrl"];
                    $rulesUrl = $urls["ruleUrl"];
                    $cguLink = '<a href="' . $cguUrl . '" target="_blank">' . $this->getContext()->getI18n()->__('accountAcceptConditions_link_text') . '</a>';
                    $rulesLink = '<a href="' . $rulesUrl . '" target="_blank">' . $this->getContext()->getI18n()->__('accountAcceptRules_link_text') . '</a>';
                    $cguRulesText = $this->getContext()->getI18n()->__('account_me_accountAcceptConditions_legende_text_1') . '<br />';
                    $cguRulesText .= '<ul style="margin-left: 15px;"><li>' . $this->getContext()->getI18n()->__('account_registerAdvanced_accountAcceptConditions_legende_text_2') . ' ' . $cguLink . ' ' . $this->getContext()->getI18n()->__('account_registerAdvanced_accountAcceptConditions_legende_text_3') . ' ' . $rulesLink . ' ' . $this->getContext()->getI18n()->__('account_registerAdvanced_accountAcceptConditions_legende_text_4') . '</li>';
                    $notifications['policyAcceptance'] = $cguRulesText;
                }

                /*
                // Bonus to ack
                if (isset($member_properties['bonusTxn'])) {
                    $txns = array();
                    try {
                        $response = $sofun->api_GET("/member/" . $sofun_member['email'] . "/transaction/bonus/unack");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response['http_code'] == '202') {
                        $txns = $response['buffer'];
                    }
                    if (count($txns) > 0) {
                        $notifications['bonus'] = $txns;
                    }
                }


                // Winnings to ack
                if (isset($member_properties['winningsTxn'])) {
                    $txns = array();
                    try {
                        $response = $sofun->api_GET("/member/" . $sofun_member['email'] . "/transaction/winnings/unack");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response['http_code'] == '202') {
                        $txns = $response['buffer'];
                    }
                    if (count($txns) > 0) {
                        $notifications['winnings'] = $txns;
                    }
                }
                */

                //print_r($notifications);exit();

                $this->getUser()->setAttribute('notifications', $notifications, 'subscriber');

            }
            else {
                $this->messageError = $response['buffer'];
            }

            if ($sofun_member['type'] == sfConfig::get('app_credentials_account_type_gambling_fr')) {
                $this->getUser()->addCredential('member_gambling_fr');

                if ($sofun_member['status'] == sfConfig::get('app_credentials_account_type_gambling_fr_verified')) {
                    $this->getUser()->addCredential('member_gambling_fr_verified');
                }
            }
        }


        /**
         * Sorting kupsData.
         *
         * @param array  $kupsData
         * @param string $sortType (ASC = Ascending, DESC = Descending)
         *
         * @return array|boolean false
         */
        protected function sortKupsDataFor($kupsData, $sortType = 'DESC') {
            $sortKupData = array();
            $kupsStartingDate = array();
            if (count($kupsData) > 0) {
                foreach ($kupsData as $kupData) {
                    $kupsStartingDate[$kupData['uuid']] = $kupData['startDate'];
                }
                if ($sortType == 'DESC') {
                    arsort($kupsStartingDate);
                }
                else if ($sortType == 'ASC') {
                    asort($kupsStartingDate);
                }
                foreach ($kupsStartingDate as $key => $value) {
                    foreach ($kupsData as $kupData) {
                        if ($key == $kupData['uuid']) {
                            $sortKupData[] = $kupData;
                        }
                    }
                }
            }
            return $sortKupData;
        }

        /**
         * FIXME get this out of here...
         *
         * @param unknown_type $sortedKupsData
         */
        protected function getLatestClosedKup($descSortedKupsData) {
            $kupData = array();
            foreach ($descSortedKupsData as $kup) {
                if (($kup['status'] >= 2) && $kup['status'] != -1) {
                    $kupData = $kup;
                    break;
                }
            }
            return $kupData;
        }

        /**
         * Return the kupData by the kup_uuid in kupsData.
         *
         * @param array  $kupsData
         * @param number $kup_uuid
         *
         * @return array
         */
        protected function getKupDataByUuidFor($kupsData, $kup_uuid) {
            $kupData = array();
            foreach ($kupsData as $kup) {
                if ($kup['uuid'] == $kup_uuid) {
                    $kupData = $kup;
                    break;
                }
            }
            return $kupData;
        }


        /**
         * Get the unfiltered Room Ranking (App cumulated ranking) given a Kup UUID and batch window.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param int          $offset
         * @param int          $batch
         */
        protected function getAppRanking($request, $room_uuid, $offset, $batch) {
            $ranking = $this->getRoomRanking($request, $room_uuid, $offset, $batch);
            $roomRankingData = array();
            if (isset($ranking['entries'])) {
                $offset = 0;
                foreach ($ranking['entries'] as $entry) {
                    $roomRankingData[$offset] = $entry;
                    $member = $entry['member'];
                    $kupsRankingData[$offset]['member']['nickName'] = Util::getNicknameFor($member);
                    $avatar = $member['avatarSmall'];
                    // Handle Facebook avatar in PLAIN HTTP
                    if (is_string($avatar)) {
                        $avatar = str_replace("http://", "https://", $avatar);
                        $kupsRankingData[$offset]['member']['avatarSmall'] = $avatar;
                    }
                    $offset++;
                }
                $roomRankingData['memberPosition'] = $ranking['memberPosition'];
                $roomRankingData['totalMembers'] = $ranking['totalMembers'];
                unset($ranking);
                return $roomRankingData;
            }
            else {
                return array();
            }
        }

        /**
         * Get the general last results for the current kup.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param int          $offset
         * @param int          $batchSize
         */
        protected function getAppLastResults($request, $kup_uuid, $offset, $batchSize) {
            $challengers = array();
            //TODO get the total chalengers from the API
            $totalChallengers = 10;

            //TODO Get the last results and match it with the dictionary
            for ($i = 0; $i < $totalChallengers; $i++) {
                if ($i >= $offset && $i < $offset + $batchSize) {
                    $challengers['results'][] = array(
                        'avatar'         => '',
                        'qualifications' => rand(0, 10),
                        'gp'             => rand(0, 5),
                        'best-lap'       => rand(0, 10)
                    );
                }
            }
            $challengers['total'] = $totalChallengers;
            return $challengers;
        }

        /**
         * Get the friends last results for the current kup.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param int          $offset
         * @param int          $batchSize
         */
        protected function getAppFriendsLastResults($request, $kup_uuid, $offset, $batchSize) {
            $challengers = array();
            //TODO get the total chalengers from the API
            $totalChallengers = 10;

            //TODO Get the last results and match it with the dictionary
            for ($i = 0; $i < $totalChallengers; $i++) {
                if ($i >= $offset && $i < $offset + $batchSize) {
                    $challengers['results'][] = array(
                        'avatar'         => '',
                        'qualifications' => rand(0, 10),
                        'gp'             => rand(0, 5),
                        'best-lap'       => rand(0, 10)
                    );
                }
            }
            $challengers['total'] = $totalChallengers;
            return $challengers;
        }

        /**
         * Get Facebook friend's filtered Room Ranking (App cumulated ranking) given a Kup UUID and batch window.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param int          $offset
         * @param int          $batch
         */
        protected function getAppFacebookRanking($request, $room_uuid, $offset, $batch) {
            $ranking = $this->getRoomRanking($request, $room_uuid, $offset, $batch, true);
            $roomRankingData = array();
            if (isset($ranking['entries'])) {
                $offset = 0;
                foreach ($ranking['entries'] as $entry) {
                    $roomRankingData[$offset] = $entry;
                    $member = $entry['member'];
                    $kupsRankingData[$offset]['member']['nickName'] = Util::getNicknameFor($member);
                    $avatar = $member['avatarSmall'];
                    // Handle Facebook avatar in PLAIN HTTP
                    if (is_string($avatar)) {
                        $avatar = str_replace("http://", "https://", $avatar);
                        $kupsRankingData[$offset]['member']['avatarSmall'] = $avatar;
                    }
                    $offset++;
                }
                $roomRankingData['friendsMemberPosition'] = $ranking['friendsMemberPosition'];
                $roomRankingData['totalFriends'] = $ranking['totalFriends'];
                unset($ranking);
                return $roomRankingData;
            }
            else {
                return array();
            }
        }

        /**
         * Get ranking data.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param int          $offset
         * @param int          $batch
         */
        protected function getRanking($request, $kup_uuid, $offset, $batch, $friends_only = false) {
            return BetkupWrapper::getRanking($request, $kup_uuid, $this, $offset, $batch, $friends_only);
        }

        protected function getRoomRankingFor(sfWebRequest $request, $room_uuid, $offset = 0, $batch = 50, $friends_only = false) {
            return BetkupWrapper::getRoomRankingFor($request, $room_uuid, $this, $offset, $batch, $friends_only);
        }

        protected function usortByArrayKey(array $array, $key, $order = SORT_ASC) {
            return BetkupWrapper::usortByArrayKey($array, $key, $order);
        }

        /**
         * Get ranking for friends ranking
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param int          $offset
         * @param int          $batch
         */
        protected function friendsRanking($request, $kup_uuid, $offset, $batch, $kupData = '') {
            if ($kupData == '' && $kup_uuid != 'all') {
                $this->kupData = $this->getKupData($request, $kup_uuid);
            }
            else {
                $this->kupData = $kupData;
            }
            if (count($this->kupData) > 0) {
                if ($this->kupData['repartition'] == 4) {
                    $this->kupData['nbWinners'] = 10;
                }
                else {
                    $this->kupData['nbWinners'] = $this->kupData['repartition'];
                }
                $this->kupsRankingData = $this->getFriendsRanking($request, $kup_uuid, $offset, $batch);
            }
            else {
                $this->kupsRankingData = $this->getAppFacebookRanking($request, $this->room_uuid, $offset, $batch);
            }

            $this->memberPosition = $this->kupsRankingData['memberPosition'];
            $this->nbPlayers = $this->kupsRankingData['totalMembers'];
        }

        /**
         * Get the url to CGU and Rules PDFs
         *
         * @return array
         */
        protected function getCguRuleUrls() {
            $urls = array();
            if (sfConfig::get('app_profile') == sfConfig::get('app_profile_free')) {
                $urls['cguUrl'] = sfConfig::get('app_url_cgu_free');
                $urls['ruleUrl'] = sfConfig::get('app_url_rule_free');
            }
            else if (sfConfig::get('app_profile') == sfConfig::get('app_profile_gambling')) {
                $urls['cguUrl'] = sfConfig::get('app_url_cgu_gambling');
                $urls['ruleUrl'] = sfConfig::get('app_url_rule_gambling');
            }
            return $urls;
        }

        /**
         * Simple PHP timer.
         *
         * @return float
         */
        protected function timeStamp() {
            list($usec, $sec) = explode(" ", microtime());
            return ((float)$usec + (float)$sec);
        }

        /**
         * Get datas from an URL.
         *
         * Curl equivalent for PHP file_get_contents.
         *
         * @param $url
         *
         * @return mixed
         */
        protected function file_get_contents($url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $output = curl_exec($ch);
            curl_close($ch);

            return $output;
        }

        /**
         * Get an user (OAuth) facebook Access token.
         *
         * @param $app_id
         * @param $app_secret
         * @param $my_url
         * @param $code
         *
         * @return string
         */
        protected function getFacebookOAuthAccessTokenArray($app_id, $app_secret, $my_url, $code) {
            $token_url = "https://graph.facebook.com/oauth/access_token?"
                . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
                . "&client_secret=" . $app_secret . "&code=" . $code;

            $response = $this->file_get_contents($token_url);
            $params = null;
            parse_str($response, $params);

            return $params;
        }

        /**
         * Get an user (OAuth) facebook Access token.
         *
         * @param $app_id
         * @param $app_secret
         * @param $my_url
         * @param $code
         *
         * @return string
         */
        protected function getFacebookOAuthAccessToken($app_id, $app_secret, $my_url, $code) {
            $access_token = "";
            $response = $this->getFacebookOAuthAccessTokenArray($app_id, $app_secret, $my_url, $code);

            if (isset($response['access_token'])) {
                $access_token = $response['access_token'];
            }
            return $access_token;
        }

        /**
         * Get the facebook authorize url formated.
         *
         * @param $app_id
         * @param $app_scope
         * @param $my_url
         *
         * @return string
         */
        protected function getFacebookLoginUrl($app_id, $app_scope, $my_url) {

            $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
            $dialog_url = "https://www.facebook.com/dialog/oauth?scope="
                . $app_scope . "&client_id="
                . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
                . $_SESSION['state'];

            return $dialog_url;
        }

        /**
         * Set the cookie containing the subscriberId and use it to cache login user data.
         *
         * @param              $cacheKey
         * @param              $user_and_permissions
         * @param              $access_token
         * @param              $access_token_expiration
         */
        protected function setFacebookCache($cacheKey, $user_and_permissions, $access_token, $access_token_expiration) {

            $expire = $access_token_expiration;
            if ($access_token_expiration > 2592000) {
                $expire = 2592000;
            }
            $cacheValue = array(
                'access_token' => $access_token,
                'userData'     => $user_and_permissions
            );
            sfMemcache::getInstance()->set($cacheKey, $cacheValue, 0, $expire);
        }

    }

?>

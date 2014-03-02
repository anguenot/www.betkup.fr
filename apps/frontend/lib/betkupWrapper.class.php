<?php

    /**
     * Abstract Betkup Actions class.
     *
     * <p/>
     *
     * It defines primitives handling the Sofun Platform access and session using the sfWebRequest.
     *
     * @package    betkup.fr
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: betkupActions.class.php 5236 2012-06-12 23:52:50Z anguenot $
     */
    class BetkupWrapper {

        /**
         * Sort array or objects by field.
         *
         * <p>
         *
         * Sort an array or object alphanumerically.
         *
         * @param array        $array Array of objects to sort.
         * @param string|array $key   Name of field or array of fields name.
         * @param              $order (SORT_ASC | SORT_DESC)
         *
         * @return $array Sorted array
         */
        static function usortByArrayKey(array &$array, $key, $order = SORT_ASC) {
            $sort_flags = array(SORT_ASC, SORT_DESC);
            if (!in_array($order, $sort_flags)) {
                error_log('sort flag only accepts SORT_ASC or SORT_DESC');
                return null;
            }
            $cmp = function (array $a, array $b) use ($key, $order, $sort_flags) {
                if (is_string($key)) {
                    if (!isset($a[$key]) || !isset($b[$key])) {
                        error_log('attempting to sort on non-existent keys');
                        return null;
                    }
                    if (is_numeric($a[$key]) && is_numeric($b[$key])) {
                        if ($a[$key] == $b[$key]) {
                            return 0;
                        }
                        return ($order == SORT_ASC xor $a[$key] < $b[$key]) ? 1 : -1;
                    }
                    else {
                        return strcmp($a[$key], $b[$key]);
                    }
                }
                else if(is_array($key)) {
                    foreach ($key as $sub_key => $sub_order) {
                        if (!in_array($sub_order, $sort_flags)) {
                            $sub_key = $sub_order;
                            $sub_order = $order;
                        }
                        if (!isset($a[$sub_key]) || !isset($b[$sub_key])) {
                            error_log('attempting to sort on non-existent keys');
                            return null;
                        }
                        if ($a[$sub_key] == $b[$sub_key]) {
                            continue;
                        }
                        if (is_numeric($a[$sub_key]) && is_numeric($b[$sub_key])) {
                            return ($sub_order == SORT_ASC xor $a[$sub_key] < $b[$sub_key]) ? 1 : -1;
                        }
                        else {
                            return strcmp($a[$sub_key], $b[$sub_key]);
                        }
                    }
                    return 0;
                }
            };
            usort($array, $cmp);
            return $array;
        }

        /**
         * Returns a Kup Ranking Table
         *
         * @param sfWebRequest $request
         * @param int          $team_uuid
         * @param object       $parent
         * @param int          $offset
         * @param int          $batchSize
         * @param boolean      $friends_only
         */
        static function getKupRanking(sfWebRequest $request, $team_uuid, $parent, $offset = 0, $batchSize = 20, $friends_only = false, $userMember = true) {
            $email = '';
            if ($userMember) {
                $email = $parent->getUser()->getAttribute('email', '', 'subscriber');
            }

            $ranking = array();

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            try {
                if ($email == '') {
                    $response = $sofun->api_GET("/kup/" . $team_uuid . "/ranking/" . $offset . "/" . $batchSize . "/get");
                }
                else {
                    if ($friends_only == false) {
                        $response = $sofun->api_GET("/kup/" . $team_uuid . "/ranking/member/" . $email . "/" . $offset . "/" . $batchSize . "/get");
                    }
                    else {
                        $response = $sofun->api_GET("/kup/" . $team_uuid . "/ranking/facebook/member/" . $email . "/" . $offset . "/" . $batchSize . "/get");
                    }
                }
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] != "202") {
                error_log($response['buffer']);
            }
            else {
                $ranking = $response['buffer'];
            }

            return $ranking;
        }

        /**
         * @param sfWebRequest $request
         * @param int          $room_uuid
         * @param int          $offset
         * @param int          $batch
         * @param object       $parent
         * @param bool         $friends_only
         *
         * @return array
         */
        static function getRoomRankingFor($request, $room_uuid, $parent, $offset = 0, $batch = 50, $friends_only = false) {
            $ranking = BetkupWrapper::getRoomRanking($request, $room_uuid, $parent, $offset, $batch, $friends_only);
            $rankingData = array();
            if (isset($ranking['entries'])) {
                $offset = 0;
                foreach ($ranking['entries'] as $entry) {
                    $rankingData[$offset] = $entry;
                    $member = $entry['member'];
                    $rankingData[$offset]['member']['nickName'] = Util::getNicknameFor($member);

                    $avatarSmall = util::getAvatarForUser($member['avatarSmall']);
                    $avatarBig = util::getAvatarForUser($member['avatarBig']);
                    $rankingData[$offset]['member']['avatarSmall'] = $avatarSmall;
                    $rankingData[$offset]['member']['avatarBig'] = $avatarBig;

                    $offset++;
                }

                $rankingData['memberPosition'] = $ranking['memberPosition'];
                $rankingData['totalMembers'] = $ranking['totalMembers'];
                $rankingData['totalFriends'] = $ranking['totalFriends'];
                $rankingData['friendsMemberPosition'] = $ranking['friendsMemberPosition'];
                unset($ranking);
                return $rankingData;
            }
            else {
                return array();
            }
        }

        /**
         * Returns the room ranking table
         *
         * @param sfWebRequest $request
         * @param int          $room_uuid
         */
        static function getRoomRanking($request, $room_uuid, $parent, $offset = 0, $batch = 50, $friends_only = false, $userMember = true) {

            $ranking = array();
            $communityId = sfConfig::get('app_sofun_community_id');

            $email = '';
            if ($userMember) {
                $email = $parent->getUser()->getAttribute('email', '', 'subscriber');
            }

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            try {
                if ($email == '') {
                    $response = $sofun->api_GET("/team/" . $room_uuid . "/ranking/" . $offset . "/" . $batch . "/get");
                }
                else {
                    if (!$friends_only) {
                        $response = $sofun->api_GET("/team/" . $room_uuid . "/ranking/member/" . $email . "/" . $offset . "/" . $batch . "/get");
                    }
                    else {
                        $response = $sofun->api_GET("/team/" . $room_uuid . "/ranking/facebook/member/" . $email . "/" . $offset . "/" . $batch . "/get");
                    }
                }
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
         * Get ranking data.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param int          $offset
         * @param int          $batch
         */
        static function getRanking($request, $kup_uuid, $parent, $offset, $batch, $friends_only = false) {
            $ranking = BetkupWrapper::getKupRanking($request, $kup_uuid, $parent, $offset, $batch, $friends_only);
            $rankingData = array();
            if (isset($ranking['entries'])) {
                $offset = 0;
                foreach ($ranking['entries'] as $entry) {
                    $rankingData[$offset] = $entry;
                    $member = $entry['member'];
                    $rankingData[$offset]['member']['nickName'] = Util::getNicknameFor($member);
                    $avatar = $member['avatarSmall'];
                    // Handle Facebook avatar in PLAIN HTTP
                    if (is_string($avatar) && util::startswith($avatar, "http://")) {
                        $count = 1;
                        $avatar = str_replace("http", "https", $avatar, $count);
                        $rankingData[$offset]['member']['avatarSmall'] = $avatar;
                    }
                    $offset++;
                }
                //
                $rankingData['memberPosition'] = $ranking['memberPosition'];
                $rankingData['totalMembers'] = $ranking['totalMembers'];
                $rankingData['totalFriends'] = $ranking['totalFriends'];
                $rankingData['friendsMemberPosition'] = $ranking['friendsMemberPosition'];
                unset($ranking);
                return $rankingData;
            }
            else {
                return array();
            }
        }

        /**
         * Returns the Sofun API
         *
         * <p/>
         *
         * Returns a Sofun SDK instance. It checks if the User's Sofun's sessions is still active. If not the user will be logged
         * out and it's session will be reset.
         *
         * @param sfWebRequest $request
         */
        static function _getSofunApp($request, $parent) {
            return BetkupWrapper::_getSofunSession($parent);
        }

        /**
         * Search for kups of rooms given parameters.
         *
         * @param sfWebRequest $request
         * @param array        $params
         */
        static function getRoomKups(sfWebRequest $request, $parent, $params = array()) {
            $with_security = (isset($params['with_security']) && $params['with_security'] != true) ? false : true;

            if (!isset($params['uuid']) || $params['uuid'] == '') {
                $parent->uuid = BetkupWrapper::getRoomUUID($parent);
            }
            else {
                $parent->uuid = $params['uuid'];
            }

            $offset = 0; // default
            if (isset($params['offset'])) {
                $offset = $params['offset'];
            }

            $batchSize = 25; // default
            if (isset($params['batchSize'])) {
                $batchSize = $params['batchSize'];
            }

            $kupsData = array();
            $kups = array();
            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            try {
                $response = $sofun->api_GET("/team/" . $parent->uuid . "/kups/" . $offset . "/" . $batchSize . "/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $kups = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            $i = 0;
            foreach ($kups as $kup) {
                // Set the display and the room uuid for kups to use it in preview -> editkups action
                $kup['display'] = 'right';
                $kup['room_uuid'] = $parent->uuid; // XXX we should not have to do that and fix the template to use `uuid` instead.
                $kupsData[$i] = BetkupWrapper::getKupDataFor($kup, $request, $parent, $with_security);
                $i++;
            }

            return $kupsData;
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
        static function getRoomUUID($parent) {

            $uuid = -1;

            $action = $parent->getContext()->getActionName();
            if (in_array($action, array('view', 'edit', 'members', 'kups', 'join', 'leave'))) {
                $uuid = $parent->getContext()->getRequest()->getParameter("uuid", -1);
            }
            return $uuid;
        }

        /**
         * Returns the Sofun Session from the Symfony session if any.
         */
        static function _getSofunSession($parent) {
            $sessionKey = $parent->getUser()->getAttribute('subscriberId', 'anonymous', 'subscriber');
            $cacheKey = 'sofun_session_' . $sessionKey;
            $sofun = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($sofun) || $sofun->getSessionStatus() != true) {
                $sofun = SofunAPIHelper::get();
                sfMemcache::getInstance()->set($cacheKey, $sofun, 0, 3600);
            }
            $parent->getUser()->setAttribute('sessionKey', $sessionKey, 'subscriber');
            return $sofun;
        }

        /**
         * Returns a room given its UUID.
         *
         * @param sfWebRequest $request
         * @param int          $uuid
         */
        static function getRoomByName(sfWebRequest $request, $parent, $name = '') {

            $room = array();

            if ($name == '') {
                return $room;
            }

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            try {
                $response = $sofun->api_GET("/team/name/" . urlencode($name) . "/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $room = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }
            return $room;
        }

        /**
         * Sets the Sofun session.
         *
         * @param array $session
         */
        static function _setSofunSession($infos, $parent) {
            $sessionKey = $parent->getUser()->getAttribute('subscriberId', 'anonymous', 'subscriber');
            $cacheKey = 'sofun_session_' . $sessionKey;
            $sofun = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($sofun) || $sofun->getSessionStatus() != true) {
                $sofun = SofunAPIHelper::get();
                $parent->getUser()->setAttribute('sessionKey', $sessionKey, 'subscriber');
            }
            $sofun->setSession($infos);
            sfMemcache::getInstance()->set($cacheKey, $sofun, 0, 3600);
            return $sofun;
        }

        /**
         * Get the default round (next game) to display for a kup
         *
         * @param sfWebRequest $request
         * @param integer      $kup_uuid
         * @param array        $kupRoundsData
         */
        static function getRoundUUID(sfWebRequest $request, $kup_uuid, $kupRoundsData, $parent) {

            $today = time();
            $roundOrder = array();

            // Get only scheduled kup games data
            $coreGames = BetkupWrapper::getKupGames($request, $kup_uuid, $parent, 'SCHEDULED');

            foreach ($kupRoundsData as $key => $round) {

                if ($round['status'] == 'SCHEDULED') {
                    $gameOrder = array();

                    foreach ($coreGames as $coreGame) {

                        if (count($coreGame['teams']) == 0) {
                            continue;
                        }
                        if ($coreGame['round']['uuid'] == $round['uuid']) {
                            if (intval(Util::diffDate($today, $coreGame['startDate'])) > 0) {
                                $gameOrder[] = Util::diffDate($today, $coreGame['startDate']);
                            }
                        }
                    }
                    asort($gameOrder, SORT_NUMERIC);
                    if (count($gameOrder) > 0) {
                        $roundOrder[$key] = $gameOrder[0];
                    }
                }
            }
            asort($roundOrder, SORT_NUMERIC);
            $index = 0;
            if (key($roundOrder) != '') {
                $index = key($roundOrder);
            }
            return $kupRoundsData[$index]['uuid'];
        }

        /**
         * Returns an array from player uuid => player name
         *
         * Used to populate select boxes.
         *
         * @param sfWebRequest $request
         * @param long         $team_id
         */
        static function getTeamPlayerNames(sfWebRequest $request, $team_id, $parent) {

            $names = array();

            $players = BetkupWrapper::getTeamPlayers($request, $team_id, $parent);

            if ($players && count($players) > 0) {
                foreach ($players as $player) {
                    $names[$player['uuid']] = $player['name'];
                }
            }

            return $names;
        }

        /**
         * Return player name giving player uuid.
         *
         * @param array  $players
         * @param number $uuid
         *
         * @return string Player name
         */
        static function getPlayerNameByUUID($players, $uuid) {

            $name = '';
            foreach ($players as $player) {
                if ($player['uuid'] == $uuid) {
                    $name = $player['name'];
                    break;
                }
            }
            return $name;
        }

        /**
         * Returns the players of a given team.
         *
         * @param sfWebRequest $request
         * @param long         $player_id
         *
         * @return array
         */
        static function getTeamPlayers(sfWebRequest $request, $team_id, $parent) {

            $cacheKey = 'team_' . $team_id . '_players';
            $players = sfMemcache::getInstance()->get($cacheKey, array());

            if (empty($players)) {
                $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                try {
                    $response = $sofun->api_GET("/sport/team/" . $team_id . "/players/get");
                } catch (SofunApiException $e) {
                    error_log($e);
                }

                if ($response["http_code"] == "202") {
                    $players = $response['buffer'];
                }
                else {
                    error_log($response['buffer']);
                }

                if (!empty($players)) {
                    // Cache up for 1 day.
                    sfMemcache::getInstance()->set($cacheKey, $players, 0, 86400);
                }
            }
            if (!function_exists('compNames')) {
                function compNames($a, $b) {
                    return strcmp($a['name'], $b['name']);
                }
            }
            usort($players, 'compNames');
            return $players;
        }

        /**
         * Return if is a game question.
         *
         * @param int   $gameUUID
         * @param array $config
         *
         * @return boolean
         */
        static function hasGameQuestion($gameUUID, $config) {

            $q = array();
            if (isset( $config['questions'])) {
                $q = explode(" ", $config['questions']);
            }
            if (in_array($gameUUID, $q)) {
                return true;
            }
            return false;
        }

        /**
         * Return if is a big game.
         *
         * @param int   $gameUUID
         * @param array $config
         *
         * @return boolean
         */
        static function isBigGame($gameUUID, $config) {

            $q = array();
            if (isset($config['bg'])) {
                $q = explode(" ", $config['bg']);
            }
            if (in_array($gameUUID, $q)) {
                return true;
            }
            return false;
        }

        /**
         * Return the prediction type giving game uuid and config.
         *
         * @param int   $gameUUID
         * @param array $config
         *
         * @return string
         */
        static function getPredictionTypeFor($gameUUID, $config) {

            $ic = array();
            if (isset($config['ic'])) {
                $ic = explode(" ", $config['ic']);
            }

            $se = array();
            if (isset($config['se'])) {
                $se = explode(" ", $config['se']);
            }

            if (in_array($gameUUID, $ic)) {
                return "ic";
            }
            else if (in_array($gameUUID, $se)) {
                return "se";
            }
            else {
                // Defaults: no configuration equals 'ic'
                return "ic";
            }
        }

        static function getKupQuestion(sfWebRequest $request, $kup_uuid, $parent) {

            $questions = array();
            $sofun = BetkupWrapper::_getSofunApp($request, $parent);

            try {
                $response = $sofun->api_GET("/kup/" . $kup_uuid . "/questions/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $questions = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return $questions;
        }

        /**
         * Returns the Kup's games.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         */
        static function getKupGames(sfWebRequest $request, $kup_uuid, $parent, $status = 'SCHEDULED') {

            $games = array();

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            try {
                if ($status != '') {
                    $response = $sofun->api_GET("/kup/" . $kup_uuid . "/games/status/" . $status . "/get");
                }
                else {
                    // All games if not status provided.
                    $response = $sofun->api_GET("/kup/" . $kup_uuid . "/games/get");
                }
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $games = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return $games;
        }

        /**
         * Returns Kup's data given it's uuid
         *
         * @param sfWebRequest $request
         * @param int          $uuid
         */
        static function getKupData(sfWebRequest $request, $uuid, $parent, $fetch = 0) {

            if($parent->getUser()->isAuthenticated()) {
                $kupDataCacheKey = 'kup_data_' . $uuid.'_for_'.$parent->getUser()->getAttribute('subscriberId', '', 'subscriber');
            } else {
                $kupDataCacheKey = 'kup_data_' . $uuid;
            }
            $kupData = sfMemcache::getInstance()->get($kupDataCacheKey, array());
            if ($fetch == 1 || empty($kupData)) {

                $kupCoreCacheKey = 'kup_core_' . $uuid;
                $kup = sfMemcache::getInstance()->get($kupCoreCacheKey, array());
                if (empty($kup)) {
                    $kup = BetkupWrapper::getCoreKup($request, $uuid, $parent);
                    if (!empty($kup)) {
                        // Request scope hack (10 seconds)
                        sfMemcache::getInstance()->set($kupCoreCacheKey, $kup, 0, 10);
                    }
                }
                if (count($kup) > 0) {
                    $kupData = BetkupWrapper::getKupDataFor($kup, $request, $parent, true);
                    if (!empty($kupData)) {
                        // Request scope hack (10 seconds)
                        sfMemcache::getInstance()->set($kupDataCacheKey, $kupData, 0, 10);
                    }
                }
            }
            return $kupData;
        }

        /**
         * Returns the Kup's rounds.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         */
        static function getKupRounds(sfWebRequest $request, $kup_uuid, $parent) {

            $rounds = array();
            if ($kup_uuid == '' || $kup_uuid == '-1') {
                return $rounds;
            }

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            try {
                $response = $sofun->api_GET("/kup/" . $kup_uuid . "/rounds/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $rounds = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return $rounds;
        }

        /**
         * Saves player's predictions.
         *
         * @param sfWebRequst $request
         * @param array       $predictions
         * @param in          $kupUUID
         */
        static function savePredictions(sfWebRequest $request, $kupUUID, $parent, $ic = array(), $se = array(), $q = array(), $full = array(), $params = array(), $tb = array()) {

            $email = $parent->getUser()->getAttribute('email', '', 'subscriber');

            $params = array(
                'communityId' => sfConfig::get('app_sofun_community_id'),
                'ic'          => $ic,
                'se'          => $se,
                'q'           => $q,
                'full'        => $full,
                'tb'          => $tb,
            );

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            try {
                $response = $sofun->api_POST("/kup/" . $kupUUID . "/member/" . $email . "/predictions/add", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] != "202") {
                error_log($response['buffer']);
                $parent->getUser()->setFlash('error', $parent->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_failed'));
            }
            else {
                $parent->getUser()->setAttribute('is_draft', '0', 'predictionsSave');
                $parent->getUser()->setFlash('notice', $parent->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_success'));
            }
        }

        /**
         * Return the round data for given kup uuid.
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param object       $parent
         * @param string       $status
         *
         * @return array
         */
        static function getKupRoundsData(sfWebRequest $request, $kup_uuid, $parent, $status = array('SCHEDULED')) {

            $rounds = array();
            $coreRounds = BetkupWrapper::getKupRounds($request, $kup_uuid, $parent);
            $isDefault = 0;
            $i = 0;
            $offset = 0;
            foreach ($coreRounds as $coreRound) {
                foreach ($status as $s) {
                    if ($coreRound['status'] != $s) {
                        continue;
                    }
                }
                if (isset($coreRound['uuid']) && $coreRound['uuid'] != '') {

                    $rounds[$offset] = array(
                        'uuid'       => $coreRound['uuid'],
                        'name'       => $coreRound['name'],
                        'status'     => $coreRound['status'],
                        'startDate'  => $coreRound['startDate'],
                        'properties' => $coreRound['properties']
                    );
                    $offset += 1;
                }
            }

            if (!function_exists('compareName')) {
                function compareName($a, $b) {
                    return strnatcmp($a['startDate'], $b['startDate']);
                }
            }
            usort($rounds, 'compareName');
            return $rounds;
        }

        /**
         * Returns core Kup's data given its uuid.
         *
         * @param sfWebRequest $request
         * @param int          $uuid
         */
        static function getCoreKup(sfWebRequest $request, $uuid, $parent) {

            $kup = array();

            if ($uuid == "-1" || $uuid == "0" || $uuid == '') {
                return $kup;
            }

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            try {
                $response = $sofun->api_GET("/kup/" . strval($uuid) . "/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $kup = $response['buffer'];
            }
            else {
                error_log($response['buffer']);
            }

            return $kup;
        }

        /**
         * Return if an user is a kup participant.
         *
         * @param sfWebRequest $request
         * @param number       $uuid
         * @param object       $parent
         *
         * @return boolean
         */
        static function isKupParticipant(sfWebRequest $request, $uuid, $parent) {
            $credentials = BetkupWrapper::getKupCredentials($request, $uuid, $parent);
            if (in_array("Participant", $credentials)) {
                return true;
            }
            else {
                return false;
            }
        }

        /**
         * Return the credientials for specified kup.
         *
         * @param sfWebRequest $request
         * @param number       $uuid
         * @param object       $parent
         *
         * @return array
         */
        static function getKupCredentials(sfWebRequest $request, $uuid, $parent) {

            $kupCredentials = array();

            $email = $parent->getUser()->getAttribute('email', '', 'subscriber');
            if ($email == '') {
                return $kupCredentials;
            }

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            try {
                $response = $sofun->api_GET("/kup/" . $uuid . "/member/" . $email . "/credentials");
            } catch (SofunApiException $e) {
                error_log($e);
            }
            if ($response['http_code'] == '202') {
                $kupCredentials = $response['buffer'];
            }

            return $kupCredentials;
        }

        /**
         * Logged in player has predictions on Kup with uuid ?
         *
         * @param sfWebRequest $request
         * @param int          $uuid
         */
        static function hasPredictions(sfWebRequest $request, $uuid, $parent) {

            $kup = array();

            if ($uuid == "-1" || $uuid == "0") {
                return false;
            }

            $email = $parent->getUser()->getAttribute('email', '', 'subscriber');
            if ($email == '') {
                return false;
            }

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            try {
                $response = $sofun->api_GET("/kup/" . strval($uuid) . "/member/" . $email . "/hasPredictions");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                return true;
            }
            return false;
        }

        /**
         * Logged in player has bet on Kup with uuid ?
         *
         * @param sfWebRequest $request
         * @param int          $uuid
         */
        static function hasBet(sfWebRequest $request, $uuid, $parent) {

            $kup = array();

            if ($uuid == "-1" || $uuid == "0") {
                return false;
            }

            $email = $parent->getUser()->getAttribute('email', '', 'subscriber');
            if ($email == '') {
                return false;
            }

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            try {
                $response = $sofun->api_GET("/kup/" . strval($uuid) . "/member/" . $email . "/hasBet");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                return true;
            }

            return false;
        }

        /**
         * Returns the Kup UI bindings.
         *
         * @return array from kup name to yml configuration file.
         */
        static function getKupsUIBindings() {
            $cacheKey = 'kups_ui_bindings';
            $kupsUIBindings = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($kupsUIBindings)) {

                $module_dir = sfConfig::get('sf_app_module_dir');
                $module_name = 'kup';
                $file = 'module.yml';

                $config = sfYaml::load($module_dir . '/' . $module_name . '/config/' . $file);

                $bindings = $config['all']['ui']['bindings'];
                $bindings = explode(" ", $bindings);

                $kupsUIBindings = array();
                foreach ($bindings as $binding) {
                    $binding_param = BetkupWrapper::getKupUIFor($binding);
                    $kupName = $binding_param['kupName'];
                    $kupsUIBindings[$kupName] = $binding_param;
                }
                if (!empty($kupsUIBindings)) {
                    sfMemcache::getInstance()->set($cacheKey, $kupsUIBindings, 0, 0);
                }
            }
            return $kupsUIBindings;
        }

        /**
         * Returns the Kup UI parameters given the kup file.
         *
         * @param str $file
         */
        static function getKupUIFor($file) {

            $module_dir = sfConfig::get('sf_app_module_dir');
            $module_name = 'kup';
            $data = 'data/ui';

            $config = sfYaml::load($module_dir . '/' . $module_name . '/' . $data . '/' . $file);
            return $config['ui'];
        }

        /**
         * Returns a Kup customization given its name.
         *
         * @param str $roomName
         */
        static function getKupUIParametersFor($kupName) {

            $bindings = BetkupWrapper::getKupsUIBindings();
            if (array_key_exists($kupName, $bindings)) {
                return $bindings[$kupName];
            }
            return array();
        }

        static function timeStamp() {
            list($usec, $sec) = explode(" ", microtime());
            return ((float)$usec + (float)$sec);
        }


        /**
         * Returns Kup's data given a core Kup
         *
         * @param array        $coreKup
         * @param sfWebRequest $request
         */
        static function getKupDataFor($kup, sfWebRequest $request, $parent, $with_security = true) {

            $kupData = array();
            $uuid = $kup['uuid'];
            $title = $kup['name'];
            $description = $kup['description'];
            $jackpot = $kup['jackpot'];
            $guaranteedPrice = $kup['guaranteedPrice'];
            $stake = $kup['stake'];
            $start_date = $kup['startDate'];
            $end_date = $kup['endDate'];
            $kupStatus = $kup['status'];

            $hasBet = false;
            $hasPredictions = false;
            $isParticipant = false;

            if ($parent->getUser()->isAuthenticated() && $with_security == true) {
                $isParticipant = BetkupWrapper::isKupParticipant($request, $uuid, $parent);
                if ($isParticipant) {
                    $hasPredictions = true;
                    $hasBet = true;
                }
                else {
                    if ($kup['type'] == sfConfig::get("mod_kup_type_free")) {
                        $hasBet = true;
                        $hasPredictions = false;
                    }
                    else {
                        $hasPredictions = BetkupWrapper::hasPredictions($request, $uuid, $parent);
                        if ($hasPredictions != false) {
                            $hasBet = BetkupWrapper::hasBet($request, $uuid, $parent);
                        }
                    }
                }
            }

            $legendStatus = "";
            $buttonLegend = "";
            if ($kupStatus == 0) {
                $legendStatus = $parent->getContext()->getI18n()->__('label_kup_status_created');
                $buttonLegend = $parent->getContext()->getI18n()->__('label_button_kup_check_status');
            }
            else if ($kupStatus == 1) {
                $legendStatus = $parent->getContext()->getI18n()->__('label_kup_status_opened');
                if ($isParticipant) {
                    $buttonLegend = $parent->getContext()->getI18n()->__('label_button_kup_front_do_predict');
                }
                else if (!$isParticipant && $hasPredictions) {
                    $buttonLegend = $parent->getContext()->getI18n()->__('label_button_kup_front_bet');
                }
                else {
                    $buttonLegend = $parent->getContext()->getI18n()->__('label_button_kup_front_play_win');
                }
            }
            else if ($kupStatus == 2) {
                $legendStatus = $parent->getContext()->getI18n()->__('label_kup_status_ongoing');
                if ($isParticipant) {
                    $buttonLegend = $parent->getContext()->getI18n()->__('label_button_kup_front_do_predict');
                }
                else if (!$isParticipant && $hasPredictions) {
                    $buttonLegend = $parent->getContext()->getI18n()->__('label_button_kup_front_bet');
                }
                else {
                    $buttonLegend = $parent->getContext()->getI18n()->__('label_button_kup_front_play_win');
                }
            }
            else if ($kupStatus == 3) {
                $legendStatus = $parent->getContext()->getI18n()->__('label_kup_status_closed');
                $buttonLegend = $parent->getContext()->getI18n()->__('label_button_kup_front_follow_ladder');
            }
            else if ($kupStatus == 4) {
                $legendStatus = $parent->getContext()->getI18n()->__('label_kup_status_settled');
                $buttonLegend = $parent->getContext()->getI18n()->__('label_button_kup_front_see_winner');
            }
            else if ($kupStatus == 5) {
                $legendStatus = $parent->getContext()->getI18n()->__('label_kup_status_paidout');
                $buttonLegend = $parent->getContext()->getI18n()->__('label_button_kup_front_see_winner');
            }
            else if ($kupStatus == -1) {
                $legendStatus = $parent->getContext()->getI18n()->__('label_kup_status_cancelled');
                $buttonLegend = $parent->getContext()->getI18n()->__('label_button_kup_check_status');
            }

            $customUI = BetkupWrapper::getKupUIParametersFor($kup['name']);
            $configs = BetkupWrapper::getKupConfigParametersFor($kup['name']);

            $kupData = array(
                'uuid'            => $uuid,
                'type'            => $kup['type'],
                'status'          => $kup['status'],
                'category'        => $customUI['category'],
                'title'           => $parent->getContext()->getI18n()->__($title),
                'name'            => $parent->getContext()->getI18n()->__($title),
                'jackpot'         => $jackpot,
                'length'          => Util::nombreJoursEntreDeuxDates(intval($start_date), intval($end_date)),
                'stake'           => $stake,
                'guaranteedPrice' => $guaranteedPrice,
                'delai'           => '',
                'startDate'       => $start_date,
                'endDate'         => $end_date,
                'button'          => $buttonLegend,
                'picto'           => $customUI['picto'],
                'picto_mini'      => $customUI['picto_mini'],
                'description'     => $parent->getContext()->getI18n()->__($description),
                'rubrique'        => $customUI['category'],
                'legend1'         => $legendStatus,
                'legend2'         => $stake == 0 ? 'Gratuit' : $stake . ' €',
                'legend3'         => $kup['numberOfParticipants'],
                'legend4'         => $stake == 0 ? 'Gratuit' : $stake . ' €',
                'is_participant'  => $isParticipant,
                'is_template'     => $kup['template'],
                'end'             => $end_date,
                'ui'              => $customUI,
                'config'          => $configs,
                'hasBet'          => $hasBet,
                'hasPredictions'  => $hasPredictions,
                'repartition'     => $kup['repartitionType'],
                'rake_percentage' => $kup['rakePercentage'],
                'rake_amount'     => $kup['rakeAmount'],
                'roomUUID'        => $kup['teamUUID'],
                'roomName'        => $kup['teamName'],
            );

            // When this function is called by the "editKup" module, there is the param it needs
            // Display kups at left or right side of the edit module
            if (isset($kup['display'])) {
                $kupData['display'] = $kup['display'];
            }
            // The room_uuid is needed by the addRoomKup and delRoomKup action to add or delete kup in room kup list
            if (isset($kup['room_uuid'])) {
                $kupData['room_uuid'] = $kup['room_uuid'];
            }

            return $kupData;
        }

        /**
         * Returns a Kup configuration given its name.
         *
         * @param str $kupName
         */
        static function getKupConfigParametersFor($kupName) {

            $bindings = BetkupWrapper::getKupsConfigBindings();
            if (array_key_exists($kupName, $bindings)) {
                return $bindings[$kupName];
            }
            return array();
        }

        /**
         * Returns the Kup Config bindings.
         *
         * @return array from kup name to yml configuration file.
         */
        static function getKupsConfigBindings() {
            $cacheKey = 'kups_config_bindings';
            $kupsConfigBindings = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($kupsConfigBindings)) {

                $module_dir = sfConfig::get('sf_app_module_dir');
                $module_name = 'kup';
                $file = 'module.yml';

                $config = sfYaml::load($module_dir . '/' . $module_name . '/config/' . $file);

                $bindings = $config['all']['config']['bindings'];
                $bindings = explode(" ", $bindings);

                $kupsConfigBindings = array();
                foreach ($bindings as $binding) {
                    $binding_param = BetkupWrapper::getKupConfigFor($binding);
                    $kupName = isset($binding_param['kupName']) ? $binding_param['kupName'] : '';
                    $kupsConfigBindings[$kupName] = $binding_param;
                }

                if (!empty($kupsConfigBindings)) {
                    sfMemcache::getInstance()->set($cacheKey, $kupsConfigBindings, 0, 0);
                }

            }
            return $kupsConfigBindings;
        }

        /**
         * Returns the Kup Config parameters given the kup file.
         *
         * @param str $file
         */
        static function getKupConfigFor($file) {

            $module_dir = sfConfig::get('sf_app_module_dir');
            $module_name = 'kup';
            $data = 'data/config';

            $config = sfYaml::load($module_dir . '/' . $module_name . '/' . $data . '/' . $file);
            return isset($config['all']) ? $config['all'] : array();
        }

        /**
         * Get player's predictions if any.
         *
         * @param sfWebRequest $request
         * @param in           $kupUUID
         *
         * @return array $predictions
         */
        static function getPredictions(sfWebRequest $request, $kupUUID, $type, $parent, $params = array()) {
            $predictions = array();
            $predictionsF1 = array();

            if ($parent->getUser()->isAuthenticated()) {
                // Test if the user have a draft prediction set. In this case, we use them.
                if (($parent->getUser()->getAttribute('is_draft', '0', 'predictionsSave')
                    || $parent->getUser()->getAttribute('grid_is_draft', '0', 'predictionsSave')
                    || $parent->getUser()->getAttribute('ranking_is_draft', '0', 'predictionsSave')
                    || $parent->getUser()->getAttribute('best_lap_is_draft', '0', 'predictionsSave'))
                    && $kupUUID == $parent->getUser()->getAttribute('kup_uuid', '', 'predictionsSave')
                ) {
                    switch ($type) {
                        case 'f1_driver_ranking' :
                            if ($parent->getUser()->hasAttribute('predictionsRanking', 'predictionsSave')) {
                                $predictionsF1 = $parent->getUser()->getAttribute('predictionsRanking', '', 'predictionsSave');
                            }
                            break;
                        case 'f1_driver_grid' :
                            if ($parent->getUser()->hasAttribute('predictionsGrid', 'predictionsSave')) {
                                $predictionsF1 = $parent->getUser()->getAttribute('predictionsGrid', '', 'predictionsSave');
                            }
                            break;
                        case 'f1_driver_best_lap' :
                            if ($parent->getUser()->hasAttribute('predictionsBestLap', 'predictionsSave')) {
                                $predictionsF1 = $parent->getUser()->getAttribute('predictionsBestLap', '', 'predictionsSave');
                            }
                            break;
                        case 'ic' :
                            if ($parent->getUser()->hasAttribute('predictions_ic', 'predictionsSave')) {
                                $predictions = array(0 => $parent->getUser()->getAttribute('predictions_ic', '', 'predictionsSave'));
                            }
                            break;
                        case 'se' :
                            if ($parent->getUser()->hasAttribute('predictions_se', 'predictionsSave')) {
                                $predictions = array(0 => $parent->getUser()->getAttribute('predictions_se', '', 'predictionsSave'));
                            }
                            break;
                        case 'q' :
                            if ($parent->getUser()->hasAttribute('predictions_q', 'predictionsSave')) {
                                $predictions = array(0 => $parent->getUser()->getAttribute('predictions_q', '', 'predictionsSave'));
                            }
                            break;
                        case 'tb' :
                            if ($parent->getUser()->hasAttribute('predictions_tb', 'predictionsSave')) {
                                $predictions = array(0 => $parent->getUser()->getAttribute('predictions_tb', '', 'predictionsSave'));
                            }
                            break;
                        case 'full' :
                            if ($parent->getUser()->hasAttribute('predictions_full', 'predictionsSave')) {
                                $predictions = array(0 => $parent->getUser()->getAttribute('predictions_full', '', 'predictionsSave'));
                            }
                            break;
                        default:
                            $predictions = array();
                            break;
                    }
                }

                if (empty($predictions)) {
                    $email = $parent->getUser()->getAttribute('email', '', 'subscriber');

                    $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                    try {
                        $response = $sofun->api_GET("/kup/" . $kupUUID . "/member/" . $email . "/predictions/" . $type . "/get");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }

                    if ($response["http_code"] != "202") {
                        error_log($response['buffer']);
                    }
                    else {
                        $predictions = $response['buffer'];
                        if (isset($params['roundUUID'])) {
                            $offset = 0;
                            while ($offset < count($predictions[0])) {
                                if ($predictions[0][$offset + 1][0] == $params['roundUUID']) {
                                    $predictions = $predictions[0][$offset];
                                    break;
                                }
                                $offset += 1;
                            }
                        }
                    }
                }

                if (!empty($predictionsF1)) {
                    $predictions[0] = $predictionsF1;
                }
            }

            return $predictions;
        }

        static function getPredictionsLastModified(sfWebRequest $request, $kupUUID, $parent) {

            $lastModified = NULL;
            $email = $parent->getUser()->getAttribute('email', '', 'subscriber');
            if ($email == '') {
                // Unauthenticated player.
                return $lastModified;
            }

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            try {
                $response = $sofun->api_GET("/kup/" . $kupUUID . "/member/" . $email . "/predictions/lastmodified/get");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] != "202") {
                error_log($response['buffer']);
            }
            else {
                $lastModified = $response['buffer'];
            }

            return $lastModified;
        }

        /**
         * Returns the Kups's game data
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param int          $round_uuid
         */
        static function getKupGamesData(sfWebRequest $request, $parent, $kup_uuid, $round_uuid = NULL, $future = false, $status = '') {

            $games = array();

            $kupData = BetkupWrapper::getKupData($request, $kup_uuid, $parent);
            $coreGames = BetkupWrapper::getKupGames($request, $kup_uuid, $parent, $status);
            $questions = BetkupWrapper::getKupQuestion($request, $kup_uuid, $parent);

            $offset = 0;
            foreach ($coreGames as $coreGame) {

                if (count($coreGame['teams']) < 2) {
                    if ($future == false) {
                        // This is the case when a game is announced but we don't know the contestants.
                        // We do not include the game here.
                        continue;
                    }
                }
                else {
                    $uuid1 = $coreGame['teams'][0]['uuid'];
                    $uuid2 = $coreGame['teams'][1]['uuid'];
                }

                // Let's not return this game if already started.
                // Ensure that this game will not show up if a problem occured PF side.
                if ($status == 'SCHEDULED') {
                    date_default_timezone_set('UTC');
                    $timeNow = time() . '000';
                    $start_date = $coreGame['startDate'];
                    if ($start_date <= $timeNow) {
                        continue;
                    }
                }
                $isActive = true;
                if ($coreGame['status'] == 'SCHEDULED') {
                    date_default_timezone_set('UTC');
                    $timeNow = time() . '000';
                    $start_date = $coreGame['startDate'];
                    if ($start_date <= $timeNow) {
                        $isActive = false;
                    }
                }
                else if ($coreGame['status'] == 'ON_GOING' || $coreGame['status'] == 'TERMINATED') {
                    $isActive = false;
                }

                if ($future == false) {
                    $team1 = $coreGame['teams'][0];
                    $team2 = $coreGame['teams'][1];
                }
                else {
                    // Build up fake teams in case we do want to displau future games that do not have contestants yet.
                    $team1 = array(
                        'uuid' => '', 'name' => 'unknown', 'country' => array('iso' => '')
                    );
                    $team2 = array(
                        'uuid' => '', 'name' => 'unknown', 'country' => array('iso' => '')
                    );
                }

                $round = $coreGame['round'];

                if ($round_uuid != NULL && $round_uuid != $round['uuid']) {
                    // Filter by given round UUID
                    continue;
                }

                $type = BetkupWrapper::getPredictionTypeFor($coreGame['uuid'], $kupData['config']);
                $bg = BetkupWrapper::isBigGame($coreGame['uuid'], $kupData['config']);
                $score = $coreGame['score'];

                $scoreTeam1 = 0;
                $scoreTeam2 = 0;
                $team1NbTries = 0;
                $team2NbTries = 0;
                $playerFirstTried = '';
                $teamFirstTried = '';
                $winnerTitle = '-';
                if (count($score) == 2) {
                    $scoreTeam1 = $score[0];
                    $scoreTeam2 = $score[1];
                    if ($coreGame['status'] == 'TERMINATED') {
                        // XXX we need to move this code somewhere else.
                        if (isset($coreGame['properties']['GAME_PROP_TEAM1_NB_TRIES'])) {
                            $team1NbTries = $coreGame['properties']['GAME_PROP_TEAM1_NB_TRIES'];
                        }
                        if (isset($coreGame['properties']['GAME_PROP_TEAM2_NB_TRIES'])) {
                            $team2NbTries = $coreGame['properties']['GAME_PROP_TEAM2_NB_TRIES'];
                        }
                        if (isset($coreGame['properties']['GAME_PROP_PLAYER_UUID_FIRST_TRY'])) {
                            $playerFirstTried = $coreGame['properties']['GAME_PROP_PLAYER_UUID_FIRST_TRY'];
                            if ($playerFirstTried == '-1') {
                                $playerFirstTried = '';
                            }
                        }
                        if (isset($coreGame['properties']['GAME_PROP_TEAM_UUID_FIRST_TRY'])) {
                            $teamFirstTried = $coreGame['properties']['GAME_PROP_TEAM_UUID_FIRST_TRY'];
                            if ($teamFirstTried == '-1') {
                                $teamFirstTried = '';
                            }
                        }
                    }
                    if ($coreGame['winner']['uuid'] == $team1['uuid']) {
                        $winnerTitle = $team1['name'];
                    }
                    else if ($coreGame['winner']['uuid'] == $team2['uuid']) {
                        $winnerTitle = $team2['name'];
                    }
                    else {
                        $winnerTitle = $parent->getContext()->getI18n()->__('label_prediction_draw');
                    }

                }

                $games[$offset] = array(
                    'id'               => $coreGame['uuid'],
                    'uuid'             => $coreGame['uuid'],
                    'roundUUID'        => $round['uuid'],
                    'type'             => $type,
                    'status'           => $coreGame['status'],
                    'title'            => util::displayDateCompleteFromTimestampComplet($coreGame['startDate']),
                    'team1id'          => $team1['uuid'],
                    'team1title'       => $team1['name'],
                    'team1avatar'      => '/image/default/rugby/teams/' . $team1['uuid'] . '.png',
                    // XXX make this generic
                    'team2id'          => $team2['uuid'],
                    'team2title'       => $team2['name'],
                    'team2avatar'      => '/image/default/rugby/teams/' . $team2['uuid'] . '.png',
                    // XXX make this generic
                    'choc'             => $bg == true ? 'yes' : 'no',
                    'winner'           => $coreGame['winner'],
                    'winnerTitle'      => $winnerTitle,
                    'scoreTeam1'       => $scoreTeam1,
                    'scoreTeam2'       => $scoreTeam2,
                    'team1NbTries'     => $team1NbTries,
                    'team2NbTries'     => $team2NbTries,
                    'playerFirstTried' => $playerFirstTried,
                    'teamFirstTried'   => $teamFirstTried,
                    'properties'       => $coreGame['properties'],
                    'isActive'         => $isActive == true ? '1' : '0',
                    'ui'               => isset($kupData['ui']['questions']) ? $kupData['ui']['questions'] : array()
                );

                $offset += 1;
                $coreGameTitle = $team1['name'] . " VS " . $team2['name'];

                if (BetkupWrapper::hasGameQuestion($coreGame['uuid'], $kupData['config'])) {

                    foreach ($questions as $question) {

                        // deal with choices and labels depending of the type of question.
                        $choicesData = array();
                        $choicesData[0] = $parent->getContext()->getI18n()->__('label_select_none');

                        $i = 1;
                        foreach ($question['choices'] as $choice) {

                            if ($choice == '') {
                                continue;
                            }

                            if ($choice == 'label_yes') {
                                // Remove none choice.
                                $choicesData = array();
                            }

                            if ($choice == 'team1') {
                                $choicesData[$team1['uuid']] = $team1['name'];
                            }
                            else if ($choice == 'team2') {
                                $choicesData[$team2['uuid']] = $team2['name'];
                            }
                            else if ($choice == 'players1') {
                                //FIXME Tennis => error_log : Team not found
                                $playerTeam1 = BetkupWrapper::getTeamPlayerNames($request, $team1['uuid'], $parent);
                                foreach ($playerTeam1 as $key => $value) {
                                    $choicesData[$key] = $value;
                                }
                            }
                            else if ($choice == 'players2') {
                                //FIXME Tennis => error_log : Team not found
                                $playerTeam2 = BetkupWrapper::getTeamPlayerNames($request, $team2['uuid'], $parent);
                                foreach ($playerTeam2 as $key => $value) {
                                    $choicesData[$key] = $value;
                                }
                            }
                            else {
                                $choicesData[$choice] = $choice;
                            }
                            $i++;
                        }

                        $answer = '';
                        $answerTitle = '';

                        if ($coreGame['status'] == 'TERMINATED') {
                            //FIXME Tennis => error log : Team not found
                            $player1 = BetkupWrapper::getTeamPlayers($request, $team1['uuid'], $parent);
                            //FIXME Tennis => error_log : Team not found
                            $player2 = BetkupWrapper::getTeamPlayers($request, $team2['uuid'], $parent);
                            if (!is_array($player1)) {
                                $player1 = array($player1);
                            }
                            if (!is_array($player2)) {
                                $player2 = array($player2);
                            }

                            $players = array_merge($player1, $player2);

                            if ($question['label'] == 'label_question_number_of_total_tries_team1') {
                                $answer = $coreGame['properties']['GAME_PROP_TEAM1_NB_TRIES'];
                                $answerTitle = $answer;
                            }
                            else if ($question['label'] == 'label_question_number_of_total_tries_team2') {
                                $answer = $coreGame['properties']['GAME_PROP_TEAM2_NB_TRIES'];
                                $answerTitle = $answer;
                            }
                            else if ($question['label'] == 'label_question_first_team_that_tries') {
                                $answer = $coreGame['properties']['GAME_PROP_TEAM_UUID_FIRST_TRY'];
                                if ($answer == $team1['uuid']) {
                                    $answerTitle = $team1['name'];
                                }
                                else if ($answer == $team2['uuid']) {
                                    $answerTitle = $team2['name'];
                                }
                                else {
                                    if ($answer != '-1') {
                                        $answerTitle = $answer;
                                    }
                                    else {
                                        $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                    }
                                }
                            }
                            else if ($question['label'] == 'label_question_team_home_scores_first'
                            || $question['label'] == 'label_question_basket_home_scores_first') {
                                $first = $coreGame['properties']['GAME_PROP_TEAM_UUID_FIRST_GOAL'];
                                if ($first == $team1['uuid']) {
                                    $answer = 'label_yes';
                                    $answerTitle = $parent->getContext()->getI18n()->__('label_yes');
                                } else {
                                    $answer = 'label_no';
                                    $answerTitle = $parent->getContext()->getI18n()->__('label_no');
                                }
                            }else if ($question['label'] == 'label_question_more_than_2_goals') {
                                $total = $scoreTeam1 + $scoreTeam2;
                                if ($total > 2) {
                                    $answer = 'label_yes';
                                    $answerTitle = $parent->getContext()->getI18n()->__('label_yes');
                                } else {
                                    $answer = 'label_no';
                                    $answerTitle = $parent->getContext()->getI18n()->__('label_no');
                                }
                            }
                            else if ($question['label'] == 'label_question_basket_difference_points_range') {
                                $diff = abs($scoreTeam1 - $scoreTeam2);
                                if ($diff >=30) {
                                    $answer = 30;
                                } else if ($diff >=20) {
                                    $answer = 20;
                                } else if ($diff >=10) {
                                    $answer = 10;
                                } else {
                                    $answer = 0;
                                }
                                $answerTitle = "+ " . $answer;
                            } else if ($question['label'] == 'label_question_basket_180_plus') {
                                $total = $scoreTeam1 + $scoreTeam2;
                                if ($total > 180) {
                                    $answer = 'label_yes';
                                    $answerTitle = $parent->getContext()->getI18n()->__('label_yes');
                                } else {
                                    $answer = 'label_no';
                                    $answerTitle = $parent->getContext()->getI18n()->__('label_no');
                                }
                            }
                            else if ($question['label'] == 'label_question_which_team_best_scorer') {
                                $answer = $coreGame['properties']['GAME_PROP_BASKET_TEAM_BEST_SCORER'];
                                if ($answer == $team1['uuid']) {
                                    $answerTitle = $team1['name'];
                                }
                                else if ($answer == $team2['uuid']) {
                                    $answerTitle = $team2['name'];
                                }
                                else {
                                    if ($answer != '-1') {
                                        $answerTitle = $answer;
                                    }
                                    else {
                                        $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                    }
                                }

                            }
                            else if ($question['label'] == 'label_question_which_team_best_intercepteur') {
                                $answer = $coreGame['properties']['GAME_PROP_BASKET_TEAM_BEST_INTERCEPTEUR'];
                                if ($answer == $team1['uuid']) {
                                    $answerTitle = $team1['name'];
                                }
                                else if ($answer == $team2['uuid']) {
                                    $answerTitle = $team2['name'];
                                }
                                else {
                                    if ($answer != '-1') {
                                        $answerTitle = $answer;
                                    }
                                    else {
                                        $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                    }
                                }

                            }
                            else if ($question['label'] == 'label_question_which_team_best_contreur') {
                                $answer = $coreGame['properties']['GAME_PROP_BASKET_TEAM_BEST_CONTREUR'];
                                if ($answer == $team1['uuid']) {
                                    $answerTitle = $team1['name'];
                                }
                                else if ($answer == $team2['uuid']) {
                                    $answerTitle = $team2['name'];
                                }
                                else {
                                    if ($answer != '-1') {
                                        $answerTitle = $answer;
                                    }
                                    else {
                                        $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                    }
                                }

                            }
                            else if ($question['label'] == 'label_question_number_of_total_tries') {
                                if (intval($question['id']) == 1) {
                                    $t1 = $coreGame['properties']['GAME_PROP_TEAM1_NB_TRIES'];
                                    $t2 = $coreGame['properties']['GAME_PROP_TEAM2_NB_TRIES'];
                                    $answer = intval($t1) + intval($t2);
                                    $answerTitle = $answer;
                                }
                            }
                            else if ($question['label'] == 'label_question_france_number_of_points') {
                                if (intval($question['id']) == 3) {
                                    if ($team1['name'] == 'France') {
                                        $answer = $scoreTeam1;
                                    }
                                    else {
                                        $answer = $scoreTeam2;
                                    }
                                    $answerTitle = $answer;
                                }
                            }
                            else if ($question['label'] == 'label_question_first_player_that_tries'
                                || $question['label'] == 'label_question_france_first_player_that_tries'
                            ) {
                                if (intval($question['id']) == 2) {
                                    if ($team1['name'] == 'France') {
                                        $uuid = $team1['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM1_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    else {
                                        $uuid = $team2['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM2_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    $players = BetkupWrapper::getTeamPlayers($request, $uuid, $parent);
                                    if ($answer != '-1') {
                                        $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                    }
                                    else {
                                        $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                    }
                                }
                                else {
                                    $answer = $coreGame['properties']['GAME_PROP_PLAYER_UUID_FIRST_TRY'];
                                    if ($answer != '-1') {
                                        $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                    }
                                    else {
                                        $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                    }
                                }
                            }
                            else if ($question['label'] == 'label_question_toulouse_first_player_that_tries') {
                                if (intval($question['id']) == 66) {
                                    if ($team1['name'] == 'Toulouse') {
                                        $uuid = $team1['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM1_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    else {
                                        $uuid = $team2['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM2_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    $players = BetkupWrapper::getTeamPlayers($request, $uuid, $parent);
                                    if ($answer != '-1') {
                                        $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                    }
                                    else {
                                        $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                    }
                                }
                                else {
                                    $answer = $coreGame['properties']['GAME_PROP_PLAYER_UUID_FIRST_TRY'];
                                    $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                }
                            }
                            else if ($question['label'] == 'label_question_top14_final_toulon_first_player_that_tries') {
                                if (intval($question['id']) == 103) {
                                    if ($team1['name'] == 'Toulon') {
                                        $uuid = $team1['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM1_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    else {
                                        $uuid = $team2['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM2_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    $players = BetkupWrapper::getTeamPlayers($request, $uuid, $parent);
                                    if ($answer != '-1' && $answer != '') {
                                        $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                    }
                                    else {
                                        $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                    }
                                }
                                else {
                                    $answer = $coreGame['properties']['GAME_PROP_PLAYER_UUID_FIRST_TRY'];
                                    $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                }
                            }
                            else if ($question['label'] == 'label_question_top14_final_toulouse_first_player_that_tries') {
                                if (intval($question['id']) == 104) {
                                    if ($team1['name'] == 'Toulouse') {
                                        $uuid = $team1['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM1_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    else {
                                        $uuid = $team2['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM2_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    $players = BetkupWrapper::getTeamPlayers($request, $uuid, $parent);
                                    if ($answer != '-1' && $answer != '') {
                                        $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                    }
                                    else {
                                        $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                    }
                                }
                                else {
                                    $answer = $coreGame['properties']['GAME_PROP_PLAYER_UUID_FIRST_TRY'];
                                    $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                }
                            }
                            else if ($question['label'] == 'label_question_clermont_first_player_that_tries') {
                                if (intval($question['id']) == 67) {
                                    if ($team1['uuid'] == 'rut2250') {
                                        $uuid = $team1['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM1_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    else {
                                        $uuid = $team2['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM2_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    $players = BetkupWrapper::getTeamPlayers($request, $uuid, $parent);
                                    if ($answer != '-1') {
                                        $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                    }
                                    else {
                                        $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                    }
                                }
                                else {
                                    $answer = $coreGame['properties']['GAME_PROP_PLAYER_UUID_FIRST_TRY'];
                                    $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                }
                            }
                            else if ($question['label'] == 'label_question_ulster_first_player_that_tries') {
                                if (intval($question['id']) == 67) {
                                    if ($team1['uuid'] == 'rut2450') {
                                        $uuid = $team1['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM1_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    else {
                                        $uuid = $team2['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM2_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    $players = BetkupWrapper::getTeamPlayers($request, $uuid, $parent);
                                    if ($answer != '-1') {
                                        $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                    }
                                    else {
                                        $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                    }
                                }
                                else {
                                    $answer = $coreGame['properties']['GAME_PROP_PLAYER_UUID_FIRST_TRY'];
                                    $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                }
                            }
                            else if ($question['label'] == 'label_kup_title_2012_hcup_leinster_ulster') {
                                if (intval($question['id']) == 67) {
                                    if ($team1['uuid'] == 'rut2450') {
                                        $uuid = $team1['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM1_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    else {
                                        $uuid = $team2['uuid'];
                                        $tries = $coreGame['properties']['GAME_PROP_TEAM2_PLAYERS_UUID_TRIES_KEY'];
                                        $uuids = explode(",", $tries);
                                        if (count($tries) > 0) {
                                            $answer = $uuids[0];
                                        }
                                    }
                                    $players = BetkupWrapper::getTeamPlayers($request, $uuid, $parent);
                                    if ($answer != '-1') {
                                        $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                    }
                                    else {
                                        $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                    }
                                }
                                else {
                                    $answer = $coreGame['properties']['GAME_PROP_PLAYER_UUID_FIRST_TRY'];
                                    $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                }
                            }
                            else if ($question['label'] == 'label_question_winner_first_half'
                                || $question['label'] == 'label_question_team_winner_half_time'
                            ) {
                                $answer = isset($coreGame['properties']['GAME_PROP_WINNER_FIRST_HALF']) ? $coreGame['properties']['GAME_PROP_WINNER_FIRST_HALF'] : '';
                                if ($answer == $team1['uuid']) {
                                    $answerTitle = $team1['name'];
                                }
                                else if ($answer == $team2['uuid']) {
                                    $answerTitle = $team2['name'];
                                }
                                else {
                                    $answerTitle = $answer;
                                }
                                if ($answerTitle == '') {
                                    $answer = "0";
                                    $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                }
                            }
                            else if ($question['label'] == 'label_question_winner_second_half'
                                || $question['label'] == 'label_question_team_winner_second_half'
                            ) {
                                $answer = $coreGame['properties']['GAME_PROP_WINNER_SECOND_HALF'];
                                if ($answer == $team1['uuid']) {
                                    $answerTitle = $team1['name'];
                                }
                                else if ($answer == $team2['uuid']) {
                                    $answerTitle = $team2['name'];
                                }
                                else {
                                    $answerTitle = $answer;
                                }
                                if ($answerTitle == '') {
                                    $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                }
                            }
                            else if ($question['label'] == 'label_question_which_team_qualifies') {
                                $answer = $coreGame['properties']['GAME_PROP_WINNER_LEG'];
                                if ($answer == $team1['uuid']) {
                                    $answerTitle = $team1['name'];
                                }
                                else if ($answer == $team2['uuid']) {
                                    $answerTitle = $team2['name'];
                                }
                                else {
                                    $answerTitle = $answer;
                                }
                                if ($answerTitle == '') {
                                    $answer = 0;
                                    $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                }
                            }
                            else if ($question['label'] == 'label_question_will_france_scores') {
                                if ($team1['name'] == 'France') {
                                    $answer = $coreGame['properties']['GAME_PROP_TEAM1_NB_TRIES'];
                                }
                                else {
                                    $answer = $coreGame['properties']['GAME_PROP_TEAM2_NB_TRIES'];
                                }
                                if (count($answer) > 0) {
                                    $answer = 'label_yes';
                                    $answerTitle = $parent->getContext()->getI18n()->__('label_yes');
                                }
                                else {
                                    $answer = 'label_no';
                                    $answerTitle = $parent->getContext()->getI18n()->__('label_no');
                                }
                            }
                            else if ($question['label'] == 'label_question_number_of_total_convs') {
                                $answer = $coreGame['properties']['GAME_PROP_TEAM1_NB_CONVS'] + $coreGame['properties']['GAME_PROP_TEAM2_NB_CONVS'];
                                $answerTitle = $answer;
                            }
                            else if ($question['label'] == 'label_question_number_of_total_penks') {
                                $answer = $coreGame['properties']['GAME_PROP_TEAM1_NB_PENKS'] + $coreGame['properties']['GAME_PROP_TEAM2_NB_PENKS'];
                                $answerTitle = $answer;
                            }
                            else if ($question['label'] == 'label_question_number_of_total_drops') {
                                $answer = $coreGame['properties']['GAME_PROP_TEAM1_NB_DROPS'] + $coreGame['properties']['GAME_PROP_TEAM2_NB_DROPS'];
                                $answerTitle = $answer;
                            }
                            else if ($question['label'] == 'label_question_half_with_more_points') {

                                $firstHalfScoreStr = $coreGame['properties']['GAME_PROP_SCORE_FIRST_HALF'];
                                $secondHalfScoreStr = $coreGame['properties']['GAME_PROP_SCORE_SECOND_HALF'];

                                $score1 = explode(",", $firstHalfScoreStr);
                                $score2 = explode(",", $secondHalfScoreStr);

                                $firstHalfTotalPoints = $score1[0] + $score1[1];
                                $secondHalfTotalPoints = $score2[0] + $score2[1];

                                if ($firstHalfTotalPoints == $secondHalfTotalPoints) {
                                    $answer = "label_select_none";
                                    $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                }
                                else if ($firstHalfTotalPoints > $secondHalfTotalPoints) {
                                    $answer = "half_1";
                                    $answerTitle = $parent->getContext()->getI18n()->__("half_1");
                                }
                                else if ($firstHalfTotalPoints < $secondHalfTotalPoints) {
                                    $answer = "half_2";
                                    $answerTitle = $parent->getContext()->getI18n()->__("half_2");
                                }

                            }
                            else if ($question['label'] == 'label_question_total_points'
                                || $question['label'] == 'label_question_total_goals_fulltime'
                                || $question['label'] == 'label_question_total_goals_fulltime_and_extra'
                            ) {

                                $firstHalfScoreStr = $coreGame['properties']['GAME_PROP_SCORE_FIRST_HALF'];
                                $secondHalfScoreStr = $coreGame['properties']['GAME_PROP_SCORE_SECOND_HALF'];

                                $score1 = explode(",", $firstHalfScoreStr);
                                $score2 = explode(",", $secondHalfScoreStr);

                                $answer = $score1[0] + $score1[1] + $score2[0] + $score2[1];
                                $answerTitle = $answer;

                            }
                            else if ($question['label'] == 'label_question_points_difference' || $question['label'] == 'label_question_goals_difference_at_end' || $question['label'] == 'label_question_points_difference_end') {

                                $answer = abs($scoreTeam1 - $scoreTeam2);
                                $answerTitle = $answer;

                            }
                            else if ($question['label'] == 'label_question_more_than_3_tries') {
                                $answer = $coreGame['properties']['GAME_PROP_TEAM1_NB_TRIES'] + $coreGame['properties']['GAME_PROP_TEAM2_NB_TRIES'];
                                if ($answer > 3) {
                                    $answer = 'label_yes';
                                    $answerTitle = $parent->getContext()->getI18n()->__('label_yes');
                                }
                                else {
                                    $answer = 'label_no';
                                    $answerTitle = $parent->getContext()->getI18n()->__('label_no');
                                }
                            }
                            else if ($question['label'] == 'label_question_first_player_that_scores'

                            ) {
                                $answer = $coreGame['properties']['GAME_PROP_PLAYER_UUID_FIRST_GOAL'];
                                if ($answer != '-1') {
                                    $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                }
                                else {
                                    $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                }
                            }
                            else if (
                                $question['label'] == 'label_question_first_player_scores_left'
                            ) {
                                $answers = $coreGame['properties']['GAME_PROP_TEAM1_PLAYERS_UUID_TRIES_KEY'];
                                $tries = explode(",", $answers);
                                $answer = "-1";
                                if (count($tries) > 0) {
                                    $answer = $tries[0];
                                }
                                if ($answer != '-1') {
                                    if ($answer == 'rup16240') {
                                        // XXX missing dude within Opta list of players for Toulouse
                                        $answerTitle = 'Timoci Matanavou';
                                    }
                                    else {
                                        $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                    }

                                }
                                else {
                                    $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                }
                            }
                            else if (
                                $question['label'] == 'label_question_first_player_scores_right'
                            ) {
                                $answers = $coreGame['properties']['GAME_PROP_TEAM2_PLAYERS_UUID_TRIES_KEY'];
                                $tries = explode(",", $answers);
                                $answer = "-1";
                                if (count($tries) > 0) {
                                    $answer = $tries[0];
                                }
                                if ($answer != '-1') {
                                    $answerTitle = BetkupWrapper::getPlayerNameByUUID($players, $answer);
                                }
                                else {
                                    $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                }
                            }
                            else if ($question['label'] == 'label_question_extra_time') {

                                $extra = $coreGame['properties']['GAME_PROP_HAS_EXTRA_TIME'];
                                if ($extra == "1") {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_penalties') {

                                $extra = $coreGame['properties']['GAME_PROP_HAS_SHOOTOUT'];
                                if ($extra == "1") {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_extra_or_shootouts') {

                                $extra = $coreGame['properties']['GAME_PROP_HAS_EXTRA_TIME'];
                                $penalties = $coreGame['properties']['GAME_PROP_HAS_SHOOTOUT'];
                                if ($extra == "1" || $penalties == "1") {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_drogba_ivory_coast_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p12303", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_drogba_chelsea_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p12303", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_giroud_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p44346", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_oliech_aja_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p34741", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_emeghara_lorient_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p85188", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_feret_rennes_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p45082", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_roux_lille_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p51525", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_sagbo_evian_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p51627", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_pastore_psg_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p54782", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_valbuena_om_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p37852", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_gameiro_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p42779", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_nene_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p20583", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_aubameyang_asse_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p54694", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_sturridge_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p40755", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_cavani_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p40720", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_forlan_inter_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p12273", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_remy_om_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p38419", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_sneijder_inter_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p15403", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_vanpersie_arsenal_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p12297", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_hazard_lille_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p42786", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_hazard_lille_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p15403", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_Ibrahimovic_milan_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p9808", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_hamsik_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p19802", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_ailton_apoel_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p48326", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_kaka_raeal_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p13135", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_gomis_ol_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p37998", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_danic_val_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p6751", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_gameiro_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p42779", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_sanchez_barcelona_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p37265", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_boateng_milan_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p20360", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_ayew_om_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p45124", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_hoarau_psg_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p44427", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_gomez_bayern_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p17884", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_falcao_madrid_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p48847", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_llorente_bilbao_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p19760", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_lampard_chelsea_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p2051", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_podolski_germany_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p17733", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_rooney_england_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p13017", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_modric_croatie_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p37055", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_alonso_spain_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p3508", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_kvist_denmark_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p27261", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_nani_portugal_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p38530", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_blaszczykowski_poland_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p37092", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_plasil_repcheque_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p12057", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_elmander_sweden_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p4739", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_ribery_france_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p28559", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_dzagoev_russia_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p51437", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == '') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_papastathopoulos_greece_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p51437", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_rosicky_repcheque_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p8597", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_karagounis_greece_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p6994", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_torres_spain_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p14402", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_balotelli_italie_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p42493", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_hamouna_asse_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p67276", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_nogueira_sochaux_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p45033", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_milevskiy_kiev_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p14566", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_arteta_arsenal_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p8758", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_pitroipa_rennes_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p18168", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_monnetpaquet_lorient_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p38261", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_gomez_bayern_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p17884", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            } else if ($question['label'] == 'label_question_gomis_lyon_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p37998", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            } else if ($question['label'] == 'label_question_gouffran_bordeaux_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p42727", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            } else if ($question['label'] == 'label_question_utaka_mhsc_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p13000", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            } else if ($question['label'] == 'label_question_hulk_porto_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p53645", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_huntelaar_schalke_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p14941", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_ronaldo_real_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p14937", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_belhanda_mhsc_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p66959", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_gomez_lyon_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p20088", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_gomez_lyon_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p20088", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_samassa_valenciennes_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p37786", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_ayew_marseille_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p45124", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_kalou_lille_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p37352", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_bressan_bate_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p63448", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_menez_paris_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p19500", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_lavezzi_paris_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p45154", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_plasil_bordeaux_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p12057", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_gerrard_liverpool_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p1814", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_nasri_manchester_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p28554", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_gago_valence_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p19975", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_iniesta_barcelone_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p12237", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_cabaye_france_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p27341", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_suarez_uruguay_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p44404", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_erding_rennes_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p19510", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_briand_lyon_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p27675", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_iniesta_spain_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p12237", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_moutinho_portugal_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p19624", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_fabregas_spain_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p17878", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_meireles_portugal_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p19921", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_mavouba_lille_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p18787", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_rami_valence_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p41795", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                                else if ($question['label'] == 'label_question_krohndehli_denmark_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p16099", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_ozil_germany_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p37605", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_robben_holland_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p8533", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_rossi_italie_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p10625", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_kranjcar_croatie_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p28097", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_ramos_spain_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p17861", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_duff_ireland_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p1256", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_nasri_france_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p28554", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_milevskyi_ukraine_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p14566", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_cole_england_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p3785", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_kallstrom_sweden_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p14985", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_dudka_poland_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p26917", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_pavlioutchenko_russia_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p20298", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_pekhart_repcheque_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p37647", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_salpingidis_grece_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p28130", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_gomez_germany_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p17884", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_xavi_spain_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p5816", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_cassano_italie_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p7174", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_keane_ireland_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p1710", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_olic_croatie_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p13139", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_benzema_france_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p19927", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_lampard_england_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p2051", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_milevskyi_ukraine_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p14566", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_ibrahimovic_sweden_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p9808", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_ronaldo_portugal_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p14937", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_contout_sochaux_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p42759", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_giroud_france_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p44346", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_pukki_finland_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p57127", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_valbuena_france_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p37852", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_putsila_belarus_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p49432", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_medjani_ajaccio_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p17337", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_ibrahimovic_paris_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p9808", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            } else if ($question['label'] == 'label_question_gignac_marseille_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p37827", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            } else if ($question['label'] == 'label_question_boateng_inter_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p20360", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            } else if ($question['label'] == 'label_question_forlan_milan_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p12273", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);


                            } else if ($question['label'] == 'label_question_vanpersie_holland_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p12297", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_bendtner_denmark_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p27697", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_samaras_greece_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p10866", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_lewandowsk_poland_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p56764", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_arshavin_russia_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p13227", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_baros_repcheque_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p10602", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_rooney_manunited_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p13017", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_suarez_liverpool_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p39336", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_messi_barcelona_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p19054", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_bulut_toulouse_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p40962", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_tevez_mancity_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p20312", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_hadji_rennes_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p27670", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_lissandro_ol_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p20088", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_which_quaters_first_score') {

                                $answer = $coreGame['properties']['GAME_PROP_FIRST_GOAL_QUARTER'];
                                if ("0" == $answer) {
                                    $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                }
                                else {
                                    $answerTitle = $parent->getContext()->getI18n()->__($answer);
                                }

                            }
                            else if ($question['label'] == 'label_question_benzema_madrid_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p19927", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_cardoza_benfica_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p42795", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_torres_chelsea_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p14402", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_xavi_barcelona_scores') {

                                $goals = $coreGame['properties']['GAME_PROP_PLAYERS_UUID_GOALS'];
                                $uuids = explode(",", $goals);
                                if (in_array("p5816", $uuids)) {
                                    $answer = "label_yes";
                                }
                                else {
                                    $answer = "label_no";
                                }
                                $answerTitle = $parent->getContext()->getI18n()->__($answer);

                            }
                            else if ($question['label'] == 'label_question_team_first_scores') {

                                $answer = $coreGame['properties']['GAME_PROP_TEAM_UUID_FIRST_GOAL'];

                                if ($answer == $team1['uuid']) {
                                    $answerTitle = $team1['name'];
                                }
                                else if ($answer == $team2['uuid']) {
                                    $answerTitle = $team2['name'];
                                }
                                else {
                                    $answerTitle = $answer;
                                }
                                if ($answerTitle == '-1') {
                                    $answer = "0";
                                    $answerTitle = $parent->getContext()->getI18n()->__("label_select_none");
                                }
                            }
                            else {
                                $answerTitle = $answer;
                            }
                        }
                        $games[$offset] = array(
                            'id'          => $coreGame['uuid'],
                            'uuid'        => $coreGame['uuid'],
                            'questionId'  => $question['id'],
                            'roundUUID'   => $round['uuid'],
                            'type'        => 'q',
                            'label'       => $question['label'],
                            'question'    => $parent->getContext()->getI18n()->__($question['label']),
                            'choc'        => 'false',
                            'orange'      => '',
                            'title'       => $coreGameTitle,
                            'choices'     => $choicesData,
                            'value'       => '-1', // TODO get points predictions for this games.
                            'answer'      => $answer,
                            'answerTitle' => $answerTitle,
                            'team1id'     => $team1['uuid'],
                            'team1title'  => $team1['name'],
                            'team2id'     => $team2['uuid'],
                            'team2title'  => $team2['name'],
                            'isActive'    => $isActive == true ? '1' : '0',
                            'ui'          => isset($kupData['ui']['questions']) ? $kupData['ui']['questions'] : array()
                        );
                        $offset += 1;
                    }
                }
            }

            return $games;
        }

        /**
         * Get user predictions for one kup
         *
         * @param int    $kup_uuid
         * @param string $predictionType
         *
         * @return array
         */
        static function getCyclingPredictions($request, $kup_uuid, $type, $parent, $coreResults = null, $kupData = array(), $params = array()) {
            $predictions = array();

            if ($parent->getUser()->isAuthenticated()) {
                $points = '-';
                $lastModified = NULL;
                $corePredictions = BetkupWrapper::getPredictions($request, $kup_uuid, $type, $parent, $params);
                if (count($corePredictions) == 2) {
                    // First array is the array of actual predictions.
                    // Second one is last modified.
                    $lastModified = isset($corePredictions[1][0]) ? $corePredictions[1][0] : '';
                    $corePredictions = $corePredictions[0];
                }
                if (count($corePredictions) == 1) {
                    $predictions = BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $corePredictions[0], $parent, $kupData);
                    if ($type == sfConfig::get('mod_' . $parent->getContext()->getModuleName() . '_prediction_type_bestlap')) {
                        $points = '-';
                        if ($coreResults != null && count($coreResults) == 1) {
                            if ($coreResults[0]['uuid'] == $corePredictions[0]) {
                                $points = 20;
                            }
                            else {
                                $points = 0;
                            }
                        }
                        $predictions['results']['points'] = $points;
                        $predictions['lastModified'] = $lastModified;
                    }
                    else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_maillot_jaune')) {
                        if ($coreResults != null && $coreResults[0]['uuid'] == $corePredictions[0]['uuid']) {

                            $points = 10;
                        }
                        else {
                            $points = 0;
                        }
                    }
                    else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_maillot_blanc')) {
                        if ($coreResults != null && $coreResults[0]['uuid'] == $corePredictions[0]['uuid']) {

                            $points = 10;
                        }
                        else {
                            $points = 0;
                        }
                    }
                    else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_maillot_vert')) {
                        if ($coreResults != null && $coreResults[0]['uuid'] == $corePredictions[0]['uuid']) {

                            $points = 10;
                        }
                        else {
                            $points = 0;
                        }
                    }
                    else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_maillot_apois')) {
                        if ($coreResults != null && $coreResults[0]['uuid'] == $corePredictions[0]['uuid']) {

                            $points = 10;
                        }
                        else {
                            $points = 0;
                        }
                    }

                }
                else {
                    $offset = -1;
                    foreach ($corePredictions as $corePrediction) {
                        $offset += 1;
                        if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_podium_team')) {
                            $predictions[$offset] = BetkupWrapper::getF1TeamByUUID($request, $kup_uuid, $corePrediction, $parent, $kupData);
                            if (!isset($predictions[$offset]['driver'])) {
                                $predictions[$offset]['nationality'] = $predictions[$offset]['properties']['PACOI'];
                                $predictions[$offset]['driver'] = $predictions[$offset]['name'];
                            }
                        }
                        else {
                            $predictions[$offset] = BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $corePrediction, $parent, $kupData);
                        }
                        if ($coreResults != null) {
                            $points = '-';
                            if ($type == sfConfig::get('mod_' . $parent->getContext()->getModuleName() . '_prediction_type_ranking')) {
                                if ($coreResults[$offset]['uuid'] == $corePrediction) {
                                    switch ($offset) {
                                        case 0:
                                            $points = 25;
                                            break;
                                        case 1:
                                            $points = 18;
                                            break;
                                        case 2:
                                            $points = 15;
                                            break;
                                        case 3:
                                            $points = 12;
                                            break;
                                        case 4:
                                            $points = 10;
                                            break;
                                        case 5:
                                            $points = 8;
                                            break;
                                        case 6:
                                            $points = 6;
                                            break;
                                        case 7:
                                            $points = 4;
                                            break;
                                        case 8:
                                            $points = 2;
                                            break;
                                        case 9:
                                            $points = 1;
                                            break;
                                    }
                                }
                                else {
                                    if ($offset < 5) {
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($coreResults[$i]['uuid'] == $corePrediction && $offset != $i) {
                                                $predictions[$offset]['results']['isTop5'] = '1';
                                                $points = '5';
                                                break;
                                            }
                                        }
                                    }
                                    if ($points == '-') {
                                        $points = 0;
                                    }
                                }
                            }
                            else if ($type == sfConfig::get('mod_' . $parent->getContext()->getModuleName() . '_prediction_type_grid')) {
                                if ($coreResults[$offset]['uuid'] == $corePrediction) {
                                    switch ($offset) {
                                        case 0:
                                            $points = 20;
                                            break;
                                        case 1:
                                            $points = 15;
                                            break;
                                        case 2:
                                            $points = 10;
                                            break;
                                        case 3:
                                            $points = 5;
                                            break;
                                    }
                                }
                                else {
                                    $points = 0;
                                }
                            }
                            else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_podium_individual')) {
                                if ($coreResults[$offset]['uuid'] == $corePrediction) {

                                    $points = 20;
                                }
                                else {
                                    $points = 0;
                                }
                            }
                            else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_podium_team')) {
                                if ($coreResults[$offset]['uuid'] == $corePrediction) {

                                    $points = 20;
                                }
                                else {
                                    $points = 0;
                                }
                            }
                        }
                        $predictions[$offset]['results']['points'] = $points;
                        $predictions['lastModified'] = $lastModified;
                    }
                }
            }
            return $predictions;
        }


        /**
         * Get user predictions for one kup
         *
         * @param int    $kup_uuid
         * @param string $predictionType
         *
         * @return array
         */
        static function getF1Predictions($request, $kup_uuid, $type, $parent, $coreResults = null, $kupData = array()) {
            $predictions = array();

            if ($parent->getUser()->isAuthenticated()) {
                $points = '-';
                $lastModified = NULL;
                $corePredictions = BetkupWrapper::getPredictions($request, $kup_uuid, $type, $parent);
                if (count($corePredictions) == 2) {
                    // First array is the array of actual predictions.
                    // Second one is last modified.
                    $lastModified = isset($corePredictions[1][0]) ? $corePredictions[1][0] : '';
                    $corePredictions = $corePredictions[0];
                }
                if (count($corePredictions) == 1) {
                    $predictions = BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $corePredictions[0], $parent, $kupData);
                    if ($type == sfConfig::get('mod_' . $parent->getContext()->getModuleName() . '_prediction_type_bestlap')) {
                        $points = '-';
                        if ($coreResults != null && count($coreResults) == 1) {
                            if ($coreResults[0]['uuid'] == $corePredictions[0]) {
                                $points = 20;
                            }
                            else {
                                $points = 0;
                            }
                        }
                        $predictions['results']['points'] = $points;
                        $predictions['lastModified'] = $lastModified;
                    }
                    else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_maillot_jaune')) {
                        //TODO implement cycling points
                        if ($coreResults != null && $coreResults[0]['uuid'] == $corePredictions[0]['uuid']) {

                            $points = 10;
                        }
                        else {
                            $points = 0;
                        }
                    }
                    else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_maillot_blanc')) {
                        //TODO implement cycling points
                        if ($coreResults != null && $coreResults[0]['uuid'] == $corePredictions[0]['uuid']) {

                            $points = 10;
                        }
                        else {
                            $points = 0;
                        }
                    }
                    else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_maillot_vert')) {
                        //TODO implement cycling points
                        if ($coreResults != null && $coreResults[0]['uuid'] == $corePredictions[0]['uuid']) {

                            $points = 10;
                        }
                        else {
                            $points = 0;
                        }
                    }
                    else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_maillot_apois')) {
                        //TODO implement cycling points
                        if ($coreResults != null && $coreResults[0]['uuid'] == $corePredictions[0]['uuid']) {

                            $points = 10;
                        }
                        else {
                            $points = 0;
                        }
                    }

                }
                else {
                    $offset = -1;
                    foreach ($corePredictions as $corePrediction) {
                        $offset += 1;
                        if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_podium_team')) {
                            $predictions[$offset] = BetkupWrapper::getF1TeamByUUID($request, $kup_uuid, $corePrediction, $parent, $kupData);
                        }
                        else {
                            $predictions[$offset] = BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $corePrediction, $parent, $kupData);
                        }
                        if ($coreResults != null) {
                            $points = '-';
                            if ($type == sfConfig::get('mod_' . $parent->getContext()->getModuleName() . '_prediction_type_ranking')) {
                                if ($coreResults[$offset]['uuid'] == $corePrediction) {
                                    switch ($offset) {
                                        case 0:
                                            $points = 25;
                                            break;
                                        case 1:
                                            $points = 18;
                                            break;
                                        case 2:
                                            $points = 15;
                                            break;
                                        case 3:
                                            $points = 12;
                                            break;
                                        case 4:
                                            $points = 10;
                                            break;
                                        case 5:
                                            $points = 8;
                                            break;
                                        case 6:
                                            $points = 6;
                                            break;
                                        case 7:
                                            $points = 4;
                                            break;
                                        case 8:
                                            $points = 2;
                                            break;
                                        case 9:
                                            $points = 1;
                                            break;
                                    }
                                }
                                else {
                                    if ($offset < 5) {
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($coreResults[$i]['uuid'] == $corePrediction && $offset != $i) {
                                                $predictions[$offset]['results']['isTop5'] = '1';
                                                $points = '5';
                                                break;
                                            }
                                        }
                                    }
                                    if ($points == '-') {
                                        $points = 0;
                                    }
                                }
                            }
                            else if ($type == sfConfig::get('mod_' . $parent->getContext()->getModuleName() . '_prediction_type_grid')) {
                                if ($coreResults[$offset]['uuid'] == $corePrediction) {
                                    switch ($offset) {
                                        case 0:
                                            $points = 20;
                                            break;
                                        case 1:
                                            $points = 15;
                                            break;
                                        case 2:
                                            $points = 10;
                                            break;
                                        case 3:
                                            $points = 5;
                                            break;
                                    }
                                }
                                else {
                                    $points = 0;
                                }
                            }
                            else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_podium_individual')) {
                                if ($coreResults[$offset]['uuid'] == $corePrediction) {

                                    $points = 20;
                                }
                                else {
                                    $points = 0;
                                }
                            }
                            else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_podium_team')) {
                                if ($coreResults[$offset]['uuid'] == $corePrediction) {

                                    $points = 20;
                                }
                                else {
                                    $points = 0;
                                }
                            }
                        }
                        $predictions[$offset]['results']['points'] = $points;
                        $predictions['lastModified'] = $lastModified;
                    }
                }
            }
            return $predictions;
        }

        /**
         * Get driver data including UI elements and properties.
         */
        static function getF1DriverDataFor($coreDriver) {
            return array(
                'uuid'        => $coreDriver['uuid'],
                'driver'      => $coreDriver['name'],
                'nationality' => $coreDriver['properties']['nat'],
                'lastRank'    => 'N/A',
                'team'        => $coreDriver['teams'][0]['name'],
                'flag'        => '/image/default/f1/2012_2013/driver/flag/' . $coreDriver['properties']['nat'] . '.jpg',
                'helmet'      => '/image/default/f1/2012_2013/driver/helmet/' . $coreDriver['uuid'] . '.png',
                'car'         => '/image/default/f1/2012_2013/driver/car/' . $coreDriver['uuid'] . '.png',
                'picture'     => '/image/default/f1/2012_2013/driver/pic/' . $coreDriver['uuid'] . '.jpg',
                'results'     => array('points' => '-', 'isTop5' => '-')
            );
        }

        /**
         * Get the driver's list for a given Kup.
         *
         * @param int $kup_uuid
         *
         * @return array
         */
        static function getF1Drivers($request, $kup_uuid, $parent, $kupData = array()) {

            $seasonUUID = $kupData['config']['seasonID'];
            $cacheKey = 'season_' . $seasonUUID . '_drivers';

            $drivers = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($drivers)) {
                $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                try {
                    $response = $sofun->api_GET("/sport/season/" . $seasonUUID . "/players/get");
                } catch (SofunApiException $e) {
                    error_log($e);
                }
                if ($response["http_code"] == "202") {
                    $coreDrivers = $response['buffer'];
                }
                else {
                    error_log($response['buffer']);
                }
                if (!empty($coreDrivers)) {
                    $drivers = array();
                    $offset = 0;
                    foreach ($coreDrivers as $coreDriver) {
                        $drivers[$offset] = BetkupWrapper::getF1DriverDataFor($coreDriver);
                        $offset += 1;
                    }
                    sfMemcache::getInstance()->set($cacheKey, $drivers, 0, 86400);
                }
            }
            return $drivers;
        }

        /**
         * Get the driver infos by it's uuid
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param int          $driver_uuid
         * @param array        $kupData
         */
        static function getF1DriverByUUID($request, $kup_uuid, $driver_uuid, $parent, $kupData = array()) {
            foreach (BetkupWrapper::getF1Drivers($request, $kup_uuid, $parent, $kupData) as $driver) {
                if ($driver['uuid'] == $driver_uuid) {
                    return $driver;
                }
            }
            return NULL;
        }

        /**
         * Get the driver infos by it's uuid
         *
         * @param sfWebRequest $request
         * @param int          $kup_uuid
         * @param int          $driver_uuid
         * @param array        $kupData
         */
        static function getF1TeamByUUID($request, $kup_uuid, $team_uuid, $parent, $kupData = array()) {
            foreach (BetkupWrapper::getSeasonTeams($request, $kupData['config']['seasonID'], $parent) as $team) {
                if ($team['uuid'] == $team_uuid) {
                    return $team;
                }
            }
            return NULL;
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
        static function getF1DriversFilteredBy($drivers, $userPredictions) {
            $fiteredDrivers = $drivers;
            $i = 0;
            if (count($userPredictions) > 0) {
                $fiteredDrivers = array();
                foreach ($drivers as $driver) {
                    $match = false;
                    foreach ($userPredictions as $userPrediction) {
                        if (isset($driver['uuid']) && isset($userPrediction['uuid']) && $driver['uuid'] == $userPrediction['uuid']) {
                            $match = true;
                            break;
                        }
                    }
                    if ($match === false) {
                        $fiteredDrivers[$i] = $driver;
                        $i++;
                    }
                }
            }
            return $fiteredDrivers;
        }

        /**
         * Returns results data including driver's data for UI display.
         *
         * @param unknown_type $request
         * @param unknown_type $kup_uuid
         * @param unknown_type $type
         */
        static function getF1Results($request, $kupData, $kup_uuid, $type, $parent) {
            // Object type versus Arrray since serialized and deserialized with json_encode / json_decode
            $seasonUUID = $kupData['config']['seasonID'];
            $results = array();
            if ($type == sfConfig::get('mod_' . $parent->getModuleName() . '_prediction_type_grid')) {
                $roundName = $kupData['config']['qualiRoundName'];
                $cacheKey = 'season_' . $seasonUUID . '_' . $roundName . '_qualification_drivers_results';
                $results = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($results)) {
                    $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                    try {
                        $response = $sofun->api_GET("/sport/season/" . $seasonUUID . "/round/" . $roundName . "/results/DRIVERS" . "/get");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response["http_code"] == "202") {
                        $coreDrivers = $response['buffer'];
                    }
                    else {
                        error_log($response['buffer']);
                    }
                    if (!empty($coreDrivers)) {
                        $offset = 0;
                        foreach ($coreDrivers as $coreDriver) {
                            $results[$offset] = BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $coreDriver['uuid'], $parent, $kupData);
                            $offset += 1;
                        }
                        sfMemcache::getInstance()->set($cacheKey, $results, 0, 300); // 5 minutes lifetime
                    }
                }

            }
            else if ($type == sfConfig::get('mod_' . $parent->getModuleName() . '_prediction_type_ranking')) {
                $roundName = $kupData['config']['raceRoundName'];
                $cacheKey = 'season_' . $seasonUUID . '_' . $roundName . '_race_drivers_results';
                $results = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($results)) {
                    $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                    try {
                        $response = $sofun->api_GET("/sport/season/" . $seasonUUID . "/round/" . $roundName . "/results/DRIVERS" . "/get");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response["http_code"] == "202") {
                        $coreDrivers = $response['buffer'];
                    }
                    else {
                        error_log($response['buffer']);
                    }
                    if (!empty($coreDrivers)) {
                        $offset = 0;
                        foreach ($coreDrivers as $coreDriver) {
                            $results[$offset] = BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $coreDriver['uuid'], $parent, $kupData);
                            $offset += 1;
                        }
                        sfMemcache::getInstance()->set($cacheKey, $results, 0, 300); // 5 minutes lifetime
                    }
                }
            }
            else if ($type == sfConfig::get('mod_' . $parent->getModuleName() . '_prediction_type_bestlap')) {
                $roundName = $kupData['config']['raceRoundName'];
                $cacheKey = 'season_' . $seasonUUID . '_' . $roundName . '_race_round';
                $results = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($results)) {
                    $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                    try {
                        $response = $sofun->api_GET("/sport/season/" . $seasonUUID . "/round/" . $roundName . "/get");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response["http_code"] == "202") {
                        $round = $response['buffer'];
                    }
                    else {
                        error_log($response['buffer']);
                    }
                    if (!empty($round)) {
                        if (isset($round['properties']['fast_time_driver_uuid'])) {
                            $results[0] = BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $round['properties']['fast_time_driver_uuid'], $parent, $kupData);
                        }
                        sfMemcache::getInstance()->set($cacheKey, $results, 0, 300); // 5 minutes life time
                    }
                }
            }
            return $results;
        }

        static function getCyclingResults($request, $kupData, $kup_uuid, $type, $parent, $roundUUID) {
            // Object type versus Arrray since serialized and deserialized with json_encode / json_decode
            $seasonUUID = $kupData['config']['seasonID'];
            $results = array();
            if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_maillot_jaune')) {
                $cacheKey = 'season_' . $seasonUUID . '_' . $roundUUID . $type;
                $results = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($results)) {
                    $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                    try {
                        $response = $sofun->api_GET("/sport/season/" . $seasonUUID . "/round/uuid/" . $roundUUID . "/results/INDIVIDUAL_AGGREGATED" . "/0/1/get");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response["http_code"] == "202") {
                        $coreDrivers = $response['buffer'];
                    }
                    else {
                        error_log($response['buffer']);
                    }
                    if (!empty($coreDrivers)) {
                        $offset = 0;
                        foreach ($coreDrivers as $coreDriver) {
                            $results[$offset] = BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $coreDriver['uuid'], $parent, $kupData);
                            $offset += 1;
                        }
                        sfMemcache::getInstance()->set($cacheKey, $results); // 5 minutes lifetime
                    }
                }
            }
            else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_maillot_blanc')) {
                $cacheKey = 'season_' . $seasonUUID . '_' . $roundUUID . $type;
                $results = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($results)) {
                    $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                    try {
                        $response = $sofun->api_GET("/sport/season/" . $seasonUUID . "/round/uuid/" . $roundUUID . "/results/YOUNG_AGGREGATED" . "/0/1/get");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response["http_code"] == "202") {
                        $coreDrivers = $response['buffer'];
                    }
                    else {
                        error_log($response['buffer']);
                    }
                    if (!empty($coreDrivers)) {
                        $offset = 0;
                        foreach ($coreDrivers as $coreDriver) {
                            $results[$offset] = BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $coreDriver['uuid'], $parent, $kupData);
                            $offset += 1;
                        }
                        sfMemcache::getInstance()->set($cacheKey, $results, 0, 300); // 5 minutes lifetime
                    }
                }
            }
            else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_maillot_vert')) {
                $cacheKey = 'season_' . $seasonUUID . '_' . $roundUUID . $type;
                $results = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($results)) {
                    $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                    try {
                        $response = $sofun->api_GET("/sport/season/" . $seasonUUID . "/round/uuid/" . $roundUUID . "/results/GREEN_AGGREGATED" . "/0/1/get");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response["http_code"] == "202") {
                        $coreDrivers = $response['buffer'];
                    }
                    else {
                        error_log($response['buffer']);
                    }
                    if (!empty($coreDrivers)) {
                        $offset = 0;
                        foreach ($coreDrivers as $coreDriver) {
                            $results[$offset] = BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $coreDriver['uuid'], $parent, $kupData);
                            $offset += 1;
                        }
                        sfMemcache::getInstance()->set($cacheKey, $results, 0, 300); // 5 minutes lifetime
                    }
                }
            }
            else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_maillot_apois')) {
                $cacheKey = 'season_' . $seasonUUID . '_' . $roundUUID . $type;
                $results = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($results)) {
                    $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                    try {
                        $response = $sofun->api_GET("/sport/season/" . $seasonUUID . "/round/uuid/" . $roundUUID . "/results/MOUNTAIN_AGGREGATED" . "/0/1/get");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response["http_code"] == "202") {
                        $coreDrivers = $response['buffer'];
                    }
                    else {
                        error_log($response['buffer']);
                    }
                    if (!empty($coreDrivers)) {
                        $offset = 0;
                        foreach ($coreDrivers as $coreDriver) {
                            $results[$offset] = BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $coreDriver['uuid'], $parent, $kupData);
                            $offset += 1;
                        }
                        sfMemcache::getInstance()->set($cacheKey, $results, 0, 300); // 5 minutes lifetime
                    }
                }
            }
            else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_podium_individual')) {
                $cacheKey = 'season_' . $seasonUUID . '_' . $roundUUID . $type;
                $results = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($results)) {
                    $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                    try {
                        if ($kupData['name'] == 'La grande Boucle') {
                            $response = $sofun->api_GET("/sport/season/" . $seasonUUID . "/round/uuid/" . $roundUUID . "/results/INDIVIDUAL_AGGREGATED" . "/0/3/get");
                        }
                        else {
                            $response = $sofun->api_GET("/sport/season/" . $seasonUUID . "/round/uuid/" . $roundUUID . "/results/INDIVIDUAL_STAGE" . "/0/3/get");
                        }
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response["http_code"] == "202") {
                        $coreDrivers = $response['buffer'];
                    }
                    else {
                        error_log($response['buffer']);
                    }
                    if (!empty($coreDrivers)) {
                        $offset = 0;
                        foreach ($coreDrivers as $coreDriver) {
                            $results[$offset] = BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $coreDriver['uuid'], $parent, $kupData);
                            $offset += 1;
                        }
                        sfMemcache::getInstance()->set($cacheKey, $results, 0, 300); // 5 minutes lifetime
                    }
                }
            }
            else if ($type == sfConfig::get('mod_cycling_prediction_type_cycling_podium_team')) {
                $cacheKey = 'season_' . $seasonUUID . '_' . $roundUUID . $type;
                $results = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($results)) {
                    $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                    try {
                        if ($kupData['name'] == 'La grande Boucle') {
                            $response = $sofun->api_GET("/sport/season/" . $seasonUUID . "/round/uuid/" . $roundUUID . "/results/TEAM_AGGREGATED" . "/0/3/get");
                        }
                        else {
                            $response = $sofun->api_GET("/sport/season/" . $seasonUUID . "/round/uuid/" . $roundUUID . "/results/TEAM_STAGE" . "/0/3/get");
                        }
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response["http_code"] == "202") {
                        $coreDrivers = $response['buffer'];
                    }
                    else {
                        error_log($response['buffer']);
                    }
                    if (!empty($coreDrivers)) {
                        $offset = 0;
                        foreach ($coreDrivers as $coreDriver) {
                            $results[$offset] = BetkupWrapper::getF1TeamByUUID($request, $kup_uuid, $coreDriver['uuid'], $parent, $kupData);
                            if (!isset($results[$offset]['driver'])) {
                                $results[$offset]['nationality'] = $results[$offset]['properties']['PACOI'];
                                $results[$offset]['driver'] = $results[$offset]['name'];
                            }
                            $offset += 1;
                        }
                        sfMemcache::getInstance()->set($cacheKey, $results, 0, 300); // 5 minutes lifetime
                    }
                }
            }
            return $results;
        }

        /**
         * Returns the tournament's season teams.
         *
         * @param sfWebRequest $request
         * @param long         $seasonId
         */
        static function getSeasonTeams(sfWebRequest $request, $seasonId, $parent) {

            $cacheKey = 'sport_season_' . $seasonId . '_teams';

            $teams = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($teams)) {
                $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                try {
                    $response = $sofun->api_GET("/sport/season/" . $seasonId . "/teams/get");
                } catch (SofunApiException $e) {
                    error_log($e);
                }

                if ($response["http_code"] != "202") {
                    error_log($response['buffer']);
                }
                else {
                    $teams = $response['buffer'];
                }

                if (!empty($teams)) {
                    function _alpha_sort($a, $b) {
                        return strcmp($a['name'], $b['name']);
                    }

                    usort($teams, "_alpha_sort");
                    sfMemcache::getInstance()->set($cacheKey, $teams, 0, 0);
                }
            }

            return $teams;
        }

        /**
         * Returns the tournament's season teams.
         *
         * @param sfWebRequest $request
         * @param long         $seasonId
         */
        static function getSeasonPlayers(sfWebRequest $request, $seasonId, $parent) {

            $cacheKey = 'sport_season_' . $seasonId . '_players';

            $players = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($players)) {
                $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                try {
                    $response = $sofun->api_GET("/sport/season/" . $seasonId . "/players/get");
                } catch (SofunApiException $e) {
                    error_log($e);
                }

                if ($response["http_code"] != "202") {
                    error_log($response['buffer']);
                }
                else {
                    $players = $response['buffer'];
                }

                if (!empty($players)) {
                    function alpha_sort($a, $b) {
                        return strcmp($a['name'], $b['name']);
                    }

                    usort($players, "alpha_sort");
                    sfMemcache::getInstance()->set($cacheKey, $players, 0, 0);
                }
            }

            return $players;
        }

        /**
         * Save predictions for all cycling types
         *
         * @param sfWebRequest $request
         * @param string       $type
         * @param int          $kup_uuid
         * @param array        $predictions
         * @param sfObject     $parent
         * @param array        $kupData
         * @param array        $kupRoundsData
         */
        static function saveCyclingPredictions(sfWebRequest $request, $type, $kup_uuid, $predictions, $parent, $kupData = array(), $kupRoundData = array()) {

            $seasonID = $kupData['config']['seasonID'];
            $roundUUID = $kupRoundData['uuid'];

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            $params = array(
                'communityId' => sfConfig::get('app_sofun_community_id'),
                'type'        => $type,
                $type         => $predictions,
                'seasonId'    => $seasonID,
                'roundUUID'   => $roundUUID,
            );

            try {
                $email = $parent->getUser()->getAttribute('email', '', 'subscriber');
                $response = $sofun->api_POST("/kup/" . $kup_uuid . "/member/" . $email . "/predictions/add", $params);
            } catch (SofunApiException $e) {
                error_log($e);
                return false;
            }
            if ($response["http_code"] != "202") {
                error_log($response['buffer']);
                return $response['buffer'];
            }
            return true;
        }


        /**
         * Save predictions for all F1 type and cycling
         *
         * @param sfWebRequest $request
         * @param string       $type
         * @param int          $kup_uuid
         * @param array        $predictions
         * @param sfObject     $parent
         * @param array        $kupData
         * @param array        $kupRoundsData
         */
        static function saveF1Predictions(sfWebRequest $request, $type, $kup_uuid, $predictions, $parent, $kupData = array(), $kupRoundsData = array()) {
            $seasonID = $kupData['config']['seasonID'];
            $stageName = $kupData['config']['stageName'];
            $roundName = $kupData['config']['raceRoundName'];

            $sofun = BetkupWrapper::_getSofunApp($request, $parent);
            $params = array(
                'communityId' => sfConfig::get('app_sofun_community_id'),
                'type'        => $type,
                $type         => $predictions,
                'seasonId'    => $seasonID,
                'stageName'   => $stageName,
                'roundName'   => $roundName,
            );
            try {
                $email = $parent->getUser()->getAttribute('email', '', 'subscriber');
                $response = $sofun->api_POST("/kup/" . $kup_uuid . "/member/" . $email . "/predictions/add", $params);
            } catch (SofunApiException $e) {
                error_log($e);
                return false;
            }
            if ($response["http_code"] != "202") {
                error_log($response['buffer']);
                return $response['buffer'];
            }
            return false;
        }

        /**
         * Returns a room given its UUID.
         *
         * @param sfWebRequest $request
         * @param int          $uuid
         */
        static function getRoom(sfWebRequest $request, $uuid, $parent) {
            $room = array();

            $room_uuid = strval($uuid);
            if ($room_uuid == '-1' || $room_uuid == 'me') {
                return $room;
            }

            $cacheKey = 'room_' . $uuid;
            $room = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($room)) {

                $sofun = BetkupWrapper::_getSofunApp($request, $parent);
                try {
                    $response = $sofun->api_GET("/team/" . $room_uuid . "/get");
                } catch (SofunApiException $e) {
                    error_log($e);
                }

                if ($response["http_code"] == "202") {
                    $room = $response['buffer'];
                    if (!empty($room)) {
                        sfMemcache::getInstance()->set($cacheKey, $room, 0, 300);
                    }
                }
                else {
                    error_log($response['buffer']);
                }
            }

            return $room;
        }

    }

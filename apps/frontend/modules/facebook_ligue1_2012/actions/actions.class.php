<?php

    /**
     * facebook_ligue1_2012 actions.
     *
     * @package    betkup.fr
     * @subpackage facebook_ligue1_2012
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: actions.class.php 6410 2012-11-05 13:50:55Z jmasmejean $
     */
    class facebook_ligue1_2012Actions extends betkupActions {

        /**
         * Connect players to Facebook.
         *
         * @param sfWebRequest $request
         */
        public function executeFacebookConnect(sfWebRequest $request) {

            $module = $this->getModuleName();
            $app_id = sfConfig::get('mod_facebook_ligue1_2012_facebook_connect_app_id');
            $app_secret = sfConfig::get('mod_facebook_ligue1_2012_facebook_connect_app_secret');
            $app_scope = sfConfig::get('mod_facebook_ligue1_2012_facebook_connect_app_scope');
            $my_url = $this->getCustomUriPrefix($request) . $this->generateUrl('facebook_ligue1_2012_login_facebook');
            $app_url = "https://apps.facebook.com/" . sfConfig::get('mod_' . $module . '_facebook_canvas_ns') . "/";

            $code = "";
            if (isset($_REQUEST["code"])) {
                $code = $_REQUEST["code"];
            }
            if (empty($code)) {
                echo "<script type='text/javascript'>top.location.href = '" . $this->getFacebookLoginUrl($app_id, $app_scope, $my_url) . "';</script>";
                exit();
            }

            if (isset($_REQUEST['state']) && isset($_SESSION['state']) && $_REQUEST['state'] == $_SESSION['state']) {

                $access_token_array = $this->getFacebookOAuthAccessTokenArray($app_id, $app_secret, $my_url, $code);
                $access_token = "";
                if (isset($access_token_array['access_token'])) {
                    $access_token = $access_token_array['access_token'];
                }
                if (isset($access_token_array['expires'])) {
                    $access_token_expiration = $access_token_array['expires'];
                }

                $cacheKey = 'betkup_app_l1_login_facebook_infos_for_' . $access_token;
                $oauthData = sfMemcache::getInstance()->get($cacheKey, array());

                if (empty($oauthData)) {
                    $userQuery = 'SELECT uid, username, name, first_name, last_name, pic_small, pic_square, pic_big, birthday_date, email FROM user WHERE uid=me()';
                    $permissionsQuery = 'SELECT ' . str_replace(',', ', ', $app_scope) . ' FROM permissions WHERE uid=me()';
                    $queries = array(
                        'user'          => $userQuery,
                        'permissions'   => $permissionsQuery
                    );

                    $fql_multiquery_url = 'https://graph.facebook.com/'
                        . 'fql?q=' . str_replace(' ', '+', json_encode($queries))
                        . '&access_token=' . $access_token;
                    $fql_multiquery_result = $this->file_get_contents($fql_multiquery_url);
                    $user_and_permissions = json_decode($fql_multiquery_result, true);
                    $user_and_permissions = $user_and_permissions['data'];
                }
                else {
                    $user_and_permissions = $oauthData['userData'];
                }

                $userInfos = array();
                $permissionsInfos = array();
                foreach ($user_and_permissions as $userPerms) {

                    // If the user have not Authorize the app, redirect to OAuth Facebook Page.
                    if ($userPerms['name'] == 'permissions' && count($userPerms['fql_result_set']) == 0) {

                        echo "<script type='text/javascript'>top.location.href = '" . $loginUrl . "';</script>";
                        exit();
                    }
                    if ($userPerms['name'] == 'user') {
                        $userInfos = $userPerms['fql_result_set'][0];
                    }
                    if ($userPerms['name'] == 'permissions') {
                        $permissionsInfos = $userPerms['fql_result_set'][0];
                    }
                }

                // Test if the user have all permissions needed.
                if (BetkupLigue1::appFacebookPermissionsMatch($app_scope, $permissionsInfos)) {

                    $user = $userInfos;
                    $email = $user['email'];
                    $fb_id = $user['uid'];
                    $birthdate = $user['birthday_date'];

                    $params = array(
                        'communityId' => sfConfig::get('app_sofun_community_id'),
                        'email'       => $email,
                        'facebookId'  => $fb_id,
                        'accessToken' => $access_token,
                        'birthdate'   => $birthdate,
                    );

                    $sofun = BetkupWrapper::_getSofunApp($request, $this);
                    $resp = $sofun->api_GET("/member/facebook/exists/" . $fb_id);

                    if ($resp["http_code"] == "202") {
                        try {
                            $response = $sofun->login($params);
                        } catch (SofunApiException $e) {
                            error_log($e);
                            $this->redirect(array(
                                                 'module' => 'facebook_ligue1_2012',
                                                 'action' => 'facebookConnect'
                                            ));
                        }

                        if ($response['http_code'] == '202') {
                            $sofun_member = $response['buffer'];
                            BetkupWrapper::_setSofunSession($sofun->getSession(), $this);
                            $this->_postLogin($request, $sofun_member);

                            // Add the access token into the user object.
                            $this->getUser()->setAttribute('access_token', $access_token, 'subscriber');

                            // Get the club for the user.
                            $club = $this->getUserClub($request);
                            if(!empty($club)) {
                                $clubId = $club['clubId'];
                                $clubName = $club['clubName'];
                                $this->getUser()->setAttribute('clubId', $clubId, 'subscriber');
                                $this->getUser()->setAttribute('clubBindingName', $clubName, 'subscriber');
                            }

                            if (empty($oauthData)) {
                                $this->setFacebookCache($cacheKey, $user_and_permissions, $access_token, $access_token_expiration);
                            }

                            echo "<script type='text/javascript'>top.location.href = '" . $app_url . "';</script>";
                            exit();
                        }
                        else {
                            $this->redirect(array(
                                                 'module' => 'facebook_ligue1_2012',
                                                 'action' => 'facebookConnect'
                                            ));
                        }
                    }
                    else {
                        try {
                            $response = $sofun->api_POST("/member/register/facebook", $params);
                        } catch (SofunApiException $e) {
                            error_log($e);
                            $this->redirect(array(
                                                 'module' => 'facebook_ligue1_2012',
                                                 'action' => 'facebookConnect'
                                            ));
                        }
                        if ($response['http_code'] == '202') {
                            $sofun_member = $response['buffer'];
                            $this->_postLogin($request, $sofun_member);
                            // Add the access token into the user object.
                            $this->getUser()->setAttribute('access_token', $access_token, 'subscriber');

                            // Get the user club.
                            $club = $this->getUserClub($request);
                            if(!empty($club)) {
                                $clubId = $club['clubId'];
                                $clubName = $club['clubName'];
                                $this->getUser()->setAttribute('clubId', $clubId, 'subscriber');
                                $this->getUser()->setAttribute('clubBindingName', $clubName, 'subscriber');
                            }

                            if (empty($oauthData)) {
                                $this->setFacebookCache($cacheKey, $user_and_permissions, $access_token, $access_token_expiration);
                            }

                            echo "<script type='text/javascript'>top.location.href = '" . $app_url . "';</script>";
                            exit();
                        }
                        else {
                            $this->redirect(array(
                                                 'module' => 'facebook_ligue1_2012',
                                                 'action' => 'facebookConnect'
                                            ));
                        }
                    }
                }
                else {
                    echo "<script type='text/javascript'>top.location.href = '" . $this->getFacebookLoginUrl($app_id, $app_scope, $my_url) . "';</script>";
                    exit();
                }
            }
            else {
                error_log("The state does not match. You may be a victim of CSRF. Facebook Connect action.");
            }
            $this->setTemplate('home');
        }

        /**
         * Get the user club id
         *
         * @return array [clubId, clubName]
         */
        private function getUserClub(sfWebRequest $request) {

            $cacheKey = 'facebook_ligue1_2012_user_club_datas_for_' . $this->getUser()->getAttribute('facebookId', '', 'subscriber');
            $userClub = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($userClub)) {
                $clubBindings = BetkupLigue1::getLigue1ClubsBindings();
                $params = array(
                    'email'     => $this->getUser()->getAttribute('email', '', 'subscriber'),
                    'offset'    => 0,
                    'batchSize' => 100,
                );
                $userRooms = $this->getRoomsData($request, $params);
                if (!empty($userRooms)) {
                    foreach ($userRooms as $room) {
                        foreach ($clubBindings as $club) {
                            if ($room['name'] == $club['betkup_room_name']) {
                                $club['clubId'] = $room['uuid'];
                                $club['clubName'] = $room['name'];
                                $club['datas'] = $room;

                                sfMemcache::getInstance()->set($cacheKey, $club, 0, 0);
                                return $club;
                            }
                        }
                    }
                }
            }

            return $userClub;
        }

        /**
         * Automatically have the player joined the dedicated Ligue 1 2012 - 2013 room where
         * all the LIGUE 1 kups will be.
         */
        protected function joinRoom(sfWebRequest $request, $room_uuid = '', $password = '', $clubBindingName = '', $clubAdd = 0) {
            if ($room_uuid == '') {
                $room_uuid = $request->getParameter('room_uuid', '');
            }
            if ($room_uuid == '') {
                $room_uuid = sfConfig::get('mod_facebook_ligue1_2012_room_uuid');
            }

            $email = $this->getUser()->getAttribute('email', '', 'subscriber');
            $params = array(
                'email'       => $email,
                'communityId' => sfConfig::get('app_sofun_community_id'),
                'password'    => $password,
            );
            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_POST("/team/" . $room_uuid . "/member/add", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($clubAdd == 1) {
                $this->getUser()->setAttribute('clubId', $room_uuid, 'subscriber');
                $this->getUser()->setAttribute('clubBindingName', $clubBindingName, 'subscriber');
            }
        }

        /**
         * Execute home action.
         *
         * Display the home page.
         *
         * @param sfWebRequest $request
         */
        public function executeHome(sfWebRequest $request) {

            // Club chosen by current logged in player.
            $this->clubId = $this->getUser()->getAttribute('clubId', '', 'subscriber');
            $this->room_uuid = sfConfig::get('mod_facebook_ligue1_2012_room_uuid');

            $id = $this->getUser()->getAttribute('subscriberId', '', 'subscriber');
            $cacheKey = 'facebook_ligue1_2012_home_current_kup_' . $id;
            $this->kupData = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->kupData)) {
                $this->kupData = $this->getNextMatch($request);
                if(!empty($this->kupData)) {
                    sfMemcache::getInstance()->set($cacheKey, $this->kupData, 0, 900); // 15m cache
                }
            }
            $this->kup_uuid = $this->kupData['uuid'];
            $this->access_token = $this->getUser()->getAttribute('access_token', '', 'subscriber');

            $this->publishMessageFacebook = $this->getContext()->getI18N()->__('text_facebook_ligue1_2012_home_publish_message');
            $this->publishLink = sfConfig::get('mod_facebook_ligue1_2012_facebook_app_page_url');
            $this->publishTitle = $this->getContext()->getI18N()->__('text_facebook_ligue1_2012_publish_title');

            $bindings = BetkupLigue1::getLigue1ClubsBindings();
            $userClub = $this->getUser()->getAttribute('clubBindingName', '', 'subscriber');
            $publishDescription = '';
            foreach ($bindings as $binding) {
                if ($userClub == $binding['betkup_room_name']) {
                    $publishDescription = $binding['publish_description'];
                    break;
                }
            }
            $this->publishDescription = $this->getContext()->getI18N()->__('text_facebook_ligue1_2012_publish_description');
            if ($publishDescription != '') {
                $this->publishDescription = $this->getContext()->getI18N()->__($publishDescription);
            }

        }

        /**
         * Display leaders box on home page.
         *
         * @param sfWebRequest $request
         */
        public function executeHomeBoxLeader(sfWebRequest $request) {

            $room_uuid = sfConfig::get('mod_facebook_ligue1_2012_room_uuid');

            $cacheKey = 'facebook_ligue1_2012_home_box_leader_ranking_general';
            $this->rankingGeneral = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->rankingGeneral)) {
                $this->rankingGeneral = $this->getRoomRanking($request, $room_uuid, 0, 2, false, false);
                sfMemcache::getInstance()->set($cacheKey, $this->rankingGeneral, 0, 3600);
            }

            $cacheKey = 'facebook_ligue1_2012_home_box_leader_ranking_day';
            $this->rankingDay = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->rankingDay)) {
                $kupsData = $this->getRoomKups($request, array(
                                                              'uuid' => $room_uuid,
                                                              'with_security' => false
                                                         ));
                $lastKups = $this->getResultsKups($kupsData);
                $this->rankingDay = array();
                if (count($lastKups) > 0) {
                    $lastKups = $this->usortByArrayKey($lastKups, 'startDate', SORT_DESC);
                    $this->rankingDay = $this->getKupRanking($request, $lastKups[0]['uuid'], 0, 2, false, false);
                    sfMemcache::getInstance()->set($cacheKey, $this->rankingDay, 0, 3600);
                }
            }

            $cacheKey = 'facebook_ligue1_2012_home_box_leader_ranking_club';
            $this->rankingClub = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->rankingClub)) {
                $bindings = BetkupLigue1::getLigue1ClubsBindings();
                $this->clubs = $this->getClubsDataForBindings($request, $bindings);
                $this->clubs = $this->usortByArrayKey($this->clubs, 'rankingPoints', SORT_DESC);
                $this->rankingClub = $this->clubs[0];
                sfMemcache::getInstance()->set($cacheKey, $this->rankingClub, 0, 3600);
            }

        }

        /**
         * Display my rankings box on home page.
         *
         * @param sfWebRequest $request
         */
        public function executeHomeBoxMyRanking(sfWebRequest $request) {

            $room_uuid = sfConfig::get('mod_facebook_ligue1_2012_room_uuid');
            $id = $this->getUser()->getAttribute('subscriberId', '', 'subscriber');

            $cacheKey = 'facebook_ligue1_2012_home_box_my_ranking_ranking_general_' . $id;
            $this->rankingGeneral = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->rankingGeneral)) {
                $this->rankingGeneral = $this->getRoomRanking($request, $room_uuid, 0, 2);
                sfMemcache::getInstance()->set($cacheKey, $this->rankingGeneral, 0, 3600);
            }

            $cacheKey = 'facebook_ligue1_2012_home_box_my_ranking_ranking_day_' . $id;
            $this->rankingDay = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->rankingDay) && $this->rankingDay != 'N/C') {
                $kupsData = $this->getRoomKups($request, array(
                                                              'uuid' => $room_uuid,
                                                              'with_security' => false
                                                         ));
                $lastKups = $this->getResultsKups($kupsData);
                $this->rankingDay = array();
                if (count($lastKups) > 0) {
                    $ranking = $this->getKupRanking($request, $lastKups[0]['uuid'], 0, 2);

                    $userMail = $this->getUser()->getAttribute('email', '', 'subscriber');
                    if ($ranking['entries'][0]['member']['email'] == $userMail) {
                        $this->rankingDay = $ranking;
                    }
                    else {
                        $this->rankingDay = array('N/C');
                    }
                }
                sfMemcache::getInstance()->set($cacheKey, $this->rankingDay, 0, 3600);
            }

            $cacheKey = 'facebook_ligue1_2012_home_box_my_ranking_ranking_club_' . $id;
            $this->rankingClub = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->rankingClub)) {
                $clubId = $this->getUser()->getAttribute('clubId', '', 'subscriber');
                $this->rankingClub = $this->getRoomRanking($request, $clubId, 0, 2);
                sfMemcache::getInstance()->set($cacheKey, $this->rankingClub, 0, 3600);
            }

            $cacheKey = 'facebook_ligue1_2012_home_box_my_ranking_ranking_club_logo_for_' . $id;
            $this->clubLogo = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->clubLogo)) {
                $clubs = BetkupLigue1::getLigue1ClubsBindings();
                $clubUser = $this->getUser()->getAttribute('clubBindingName', '', 'subscriber');
                foreach ($clubs as $club) {
                    if ($clubUser == $club['betkup_room_name']) {
                        $this->clubLogo = $club['avatar_big'];
                        sfMemcache::getInstance()->set($cacheKey, $this->clubLogo, 0, 0); // Club logo never change for user.
                        break;
                    }
                }
            }

        }

        /**
         * Display home ranking box.
         *
         * @param sfWebRequest $request
         */
        public function executeHomeClubRanking(sfWebRequest $request) {

            $cacheKey = 'facebook_ligue1_2012_home_clubs_ranking';
            $clubs = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($clubs)) {

                $bindings = BetkupLigue1::getLigue1ClubsBindings();
                $clubs = $this->getClubsDataForBindings($request, $bindings);
                $clubs = $this->usortByArrayKey($clubs, 'rankingPoints', SORT_DESC);
                sfMemcache::getInstance()->set($cacheKey, $clubs, 0, 3600);
            }
            $this->clubs = $clubs;

        }

        /**
         * Get the next match.
         *
         * Depending on kup startDate and kup status.
         *
         * @param sfWebRequest $request
         *
         * @return $nextKup.
         */
        private function getNextMatch(sfWebRequest $request, $kups = array()) {
            $room_uuid = sfConfig::get('mod_facebook_ligue1_2012_room_uuid');
            if (empty($kups)) {
                $params = array(
                    'uuid'          => $room_uuid,
                    'offset'        => 0,
                    'batchSize'     => 20,
                    'with_security' => false
                );
                $kups = $this->getRoomKups($request, $params);
            }

            $kups = $this->sortKupsDataFor($kups, 'ASC');

            $nextKup = array();
            foreach ($kups as $kupData) {
                if ($kupData['status'] < 3 && $kupData['status'] != -1) {
                    $nextKup = $kupData;
                    break;
                }
            }
            if (empty($nextKup)) {
                $nextKup = $kups[count($kups) - 1];
            }
            return $nextKup;
        }

        /**
         * Display the ranking (11 titulaire) box on club page.
         *
         * @param sfWebRequest $request
         */
        public function executeClubRankingBox(sfWebRequest $request) {
            $this->clubId = $request->getParameter('club_uuid', '');
            $this->rankings = $this->getRoomRanking($request, $this->clubId, 0, 11);
        }

        /**
         * Display predictions page
         *
         * @param sfWebRequest $request
         */
        public function executePredictions(sfWebRequest $request) {
            $this->is_saved = $request->getParameter('is_saved', 0);
            $this->room_uuid = sfConfig::get('mod_facebook_ligue1_2012_room_uuid');
            $this->kup_uuid = $request->getParameter('kup_uuid', '');

            if ($this->kup_uuid == '') {
                $id = $this->getUser()->getAttribute('subscriberId', '', 'subscriber');
                $cacheKey = 'facebook_ligue1_2012_home_current_kup_' . $id;
                $this->kupData = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($this->kupData)) {
                    $this->kupsList = $this->getRoomKups($request, array('uuid' => $this->room_uuid));
                    $this->kupData = $this->getNextMatch($request, $this->kupsList);
                    sfMemcache::getInstance()->set($cacheKey, $this->kupData, 0, 3600);
                }
                $this->kup_uuid = $this->kupData['uuid'];
            }

            // Fresh up
            $this->kupData = $this->getKupData($request, $this->kup_uuid);
            $this->publishProperties = $this->getAppL1FacebookPublishPropertiesFor($request, $this->kupData);
            $this->publishMessageFacebook = $this->getContext()->getI18N()->__('text_facebook_ligue1_2012_home_publish_message');
            $this->publishLink = sfConfig::get('mod_facebook_ligue1_2012_facebook_app_page_url');
            $this->publishTitle = $this->getContext()->getI18N()->__('text_facebook_ligue1_2012_publish_title');
            $this->publishDescription = $this->getContext()->getI18N()->__('text_facebook_ligue1_2012_publish_description');

            if ($this->is_saved == 1) {
                $url = $this->getCustomUriPrefix($request) . $this->generateUrl('facebook_ligue1_2012_open_graph_kup_url', array('kup_uuid' => $this->kup_uuid));
                $app_id = sfConfig::get('mod_facebook_ligue1_2012_facebook_connect_app_id');
                $app_secret = sfConfig::get('mod_facebook_ligue1_2012_facebook_connect_app_secret');
                $app_namespace = sfConfig::get('mod_facebook_ligue1_2012_facebook_canvas_ns');

                $access_token = $this->getUser()->getAttribute('access_token', '', 'subscriber');
                $facebook = new Facebook(array(
                                              'appId'  => $app_id,
                                              'secret' => $app_secret,
                                         ));
                $facebook->setAccessToken($access_token);
                try {
                    $ret_obj = $facebook->api('/me/' . $app_namespace . ':predict', 'post', array(
                                                                                                 'matchday' => $url
                                                                                            ));
                } catch (FacebookApiException $e) {
                    error_log($e->getMessage());
                }
            }

        }

        /**
         * Display the landing page for OpenGraph matchday objects.
         *
         * @param sfWebRequest $request
         */
        public function executeLandingPage(sfWebRequest $request) {
            $this->kup_uuid = $request->getParameter('kup_uuid', '');
            $this->kupData = $this->getKupData($request, $this->kup_uuid);
            $this->getResponse()->setTitle($this->kupData['title'] . $this->getContext()->getI18N()->__('text_title_kup_facebook_ligue1'));
            $this->siteUrl = sfConfig::get('mod_facebook_ligue1_2012_facebook_app_page_url');
        }


        /**
         * Display feed box on predictions page
         *
         * @param sfWebRequest $request
         */
        public function executePredictionsBoxFeed(sfWebRequest $request) {
            $this->rssFeed = RSSParser::parser(sfConfig::get('mod_facebook_ligue1_2012_rss_parser_predictions_feed'));
        }

        /**
         * Display the like page.
         *
         * @param sfWebRequest $request
         */
        public function executeLikePage(sfWebRequest $request) {

        }

        /**
         * Display club page
         *
         * @param sfWebRequest $request
         */
        public function executeClub(sfWebRequest $request) {
            $bindings = BetkupLigue1::getLigue1ClubsBindings();

            $clubName = '';
            $this->club_uuid = $request->getParameter('club_uuid', '');
            if ($this->club_uuid != '') {
                $clubData = $this->getRoom($request, $this->club_uuid);
                $clubName = $clubData['name'];
            }

            $this->club_name = $clubName;
            $this->club = $this->getUserClubDataForBindings($request, $bindings, $clubName);
            $this->clubHeader = $this->getClubHeader($bindings, $clubName);

            $this->commentUrl = sfConfig::get('mod_facebook_ligue1_2012_facebook_app_page_url') . 'club/' . $this->club[0]['uuid'];
            $this->publishMessageFacebook = $this->getContext()->getI18N()->__('text_facebook_ligue1_2012_home_publish_message');
            $this->publishLink = sfConfig::get('mod_facebook_ligue1_2012_facebook_app_page_url');
            $this->publishTitle = $this->getContext()->getI18N()->__('text_facebook_ligue1_2012_publish_title');
            $this->access_token = $this->getUser()->getAttribute('access_token', '', 'subscriber');

            $userClub = $this->getUser()->getAttribute('clubBindingName', '', 'subscriber');
            $publishDescription = '';
            foreach ($bindings as $binding) {
                if ($userClub == $binding['betkup_room_name']) {
                    $publishDescription = $binding['publish_description'];
                    break;
                }
            }
            $this->publishDescription = $this->getContext()->getI18N()->__('text_facebook_ligue1_2012_publish_description');
            if ($publishDescription != '') {
                $this->publishDescription = $this->getContext()->getI18N()->__($publishDescription);
            }

        }

        /**
         * Display the feed box on "My club" page.
         *
         * @param sfWebRequest $request
         */
        public function executeClubBoxFeed(sfWebRequest $request) {

            $club_name = $request->getParameter('club_name', '');
            $bindings = BetkupLigue1::getLigue1ClubsBindings();
            $this->clubFeed = $this->getClubFeed($bindings, $club_name);
            $this->rssFeed = RSSParser::parser($this->clubFeed);

        }

        /**
         * Display friends box in club page
         *
         * @param sfWebRequest $request
         */
        public function executeClubFriends(sfWebRequest $request) {

            $this->friends = array();
            $access_token = $request->getParameter('access_token', array());
            $page_id = sfConfig::get('app_facebook_betkup_page_id');

            $limit = 20;

            $friendsQuery = 'SELECT uid, name, pic_small, pic_square FROM user WHERE is_app_user=0 AND uid in (SELECT uid2 FROM friend WHERE uid1=me())';
            $friendsLikePageQuery = 'SELECT uid FROM page_fan WHERE uid in (' . $friendsQuery . ') AND page_id=' . $page_id;
            $friendsLikePageQuery = 'SELECT uid, name, pic_small, pic_square FROM user WHERE uid in (' . $friendsLikePageQuery . ')';

            $multi_query = array(
                'friendsLikedPage' => $friendsLikePageQuery . ' LIMIT ' . $limit,
                'friends'          => $friendsQuery . ' LIMIT ' . $limit
            );

            $app_id = sfConfig::get('mod_facebook_ligue1_2012_facebook_connect_app_id');
            $app_secret = sfConfig::get('mod_facebook_ligue1_2012_facebook_connect_app_secret');
            $config = array(
                'appId'  => $app_id,
                'secret' => $app_secret,
                'cookie' => true,
            );
            $facebook = new Facebook($config);
            $facebook->setAccessToken($access_token);

            $params = array(
                'method'  => 'fql.multiquery',
                'queries' => json_encode($multi_query)
            );

            try {
                $this->friends = $facebook->api($params);
                $this->friends = $this->getSortMultiFriendsDatas($this->friends, $limit);
            } catch (FacebookApiException $e) {
                error_log($e);
            }
        }

        /**
         * @param $request
         * @param $room_uuid
         *
         * @return array|bool
         */
        private function getLigue1KupsData($request, $room_uuid) {
            $cacheKey = 'facebook_ligue1_2012_kups_datas_ranking_results';
            $kupsData = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($kupsData)) {
                $params = array(
                    'uuid' => $room_uuid,
                    'with_security' => false
                );
                $kups = $this->getRoomKups($request, $params);
                $kupsData = $this->sortKupsDataFor($kups, 'DESC');
                $kupsData = $this->getResultsKups($kupsData);
                sfMemcache::getInstance()->set($cacheKey, $kupsData, 0, 3600);
            }

            return $kupsData;
        }

        /**
         * Display results page
         *
         * @param sfWebRequest $request
         */
        public function executeResults(sfWebRequest $request) {

            $this->kup_uuid = $request->getParameter('kup_uuid', '');
            $this->room_uuid = $request->getParameter('room_uuid', sfConfig::get('mod_facebook_ligue1_2012_room_uuid'));

            $this->kupsData = $this->getLigue1KupsData($request, $this->room_uuid);

            if ($this->kup_uuid != '') {
                $cacheKey = 'facebook_ligue1_2012_results_for_kup_'.$this->kup_uuid;
                $this->kupData = sfMemcache::getInstance()->get($cacheKey, array());
                if(empty($this->kupData)) {
                    $this->kupData = $this->getKupData($request, $this->kup_uuid);
                    sfMemcache::getInstance()->set($cacheKey, $this->kupData, 0, 3600);
                }
            }
            else {
                $cacheKey = 'facebook_ligue1_2012_results_for_last_kup';
                $this->kupData = sfMemcache::getInstance()->get($cacheKey, array());
                if(empty($this->kupData)) {
                    $this->kupData = $this->getLatestClosedKup($this->kupsData);
                    sfMemcache::getInstance()->set($cacheKey, $this->kupData, 0, 3600);
                }
                $this->kup_uuid = '';
                if (!empty($this->kupData)) {
                    $this->kup_uuid = $this->kupData['uuid'];
                }
            }
        }


        /**
         * Get the kups to show on drop down in result page.
         *
         * Return the last closed kups ascending to DESC.
         *
         * @param $kupsData
         *
         * @return array
         */
        private function getResultsKups($kupsData) {
            $resultsKups = array();

            foreach ($kupsData as $kupData) {
                if ($kupData['status'] >= 3 && $kupData['status'] != '-1') {
                    $resultsKups[] = $kupData;
                }
            }

            return $resultsKups;
        }

        /**
         * Display ranking page
         *
         * @param sfWebRequest $request
         */
        public function executeRanking(sfWebRequest $request) {
            $this->tab = $request->getParameter('tab', '');
            if ($this->tab == '') {
                $this->tab = 'individual';
            }

            $this->loadUrl = '';
            switch ($this->tab) {
                case 'individual' :
                    $this->loadUrl = $this->getController()->genUrl(array(
                                                                         'module' => 'facebook_ligue1_2012',
                                                                         'action' => 'rankingIndividual'
                                                                    ));
                    break;
                case 'clubs' :
                    $this->loadUrl = $this->getController()->genUrl(array(
                                                                         'module' => 'facebook_ligue1_2012',
                                                                         'action' => 'rankingClubs'
                                                                    ));
                    break;
                case 'friends' :
                    $this->loadUrl = $this->getController()->genUrl(array(
                                                                         'module' => 'facebook_ligue1_2012',
                                                                         'action' => 'rankingFriends'
                                                                    ));
                    break;
                case 'my_club' :
                    $this->loadUrl = $this->getController()->genUrl(array(
                                                                         'module' => 'facebook_ligue1_2012',
                                                                         'action' => 'rankingMyClub'
                                                                    ));
                    break;
                default:
                    $this->loadUrl = $this->getController()->genUrl(array(
                                                                         'module' => 'facebook_ligue1_2012',
                                                                         'action' => 'rankingIndividual'
                                                                    ));
                    break;
            }
            $this->access_token = $this->getUser()->getAttribute('access_token', '', 'subscriber');
            $this->publishMessageFacebook = $this->getContext()->getI18N()->__('text_facebook_ligue1_2012_home_publish_message');
            $this->publishLink = sfConfig::get('mod_facebook_ligue1_2012_facebook_app_page_url');
            $this->publishTitle = $this->getContext()->getI18N()->__('text_facebook_ligue1_2012_publish_title');

            $bindings = BetkupLigue1::getLigue1ClubsBindings();
            $userClub = $this->getUser()->getAttribute('clubBindingName', '', 'subscriber');
            $publishDescription = '';
            foreach ($bindings as $binding) {
                if ($userClub == $binding['betkup_room_name']) {
                    $publishDescription = $binding['publish_description'];
                    break;
                }
            }
            $this->publishDescription = $this->getContext()->getI18N()->__('text_facebook_ligue1_2012_publish_description');
            if ($publishDescription != '') {
                $this->publishDescription = $this->getContext()->getI18N()->__($publishDescription);
            }
        }

        /**
         * Display ranking individual page
         *
         * @param sfWebRequest $request
         */
        public function executeRankingIndividual(sfWebRequest $request) {
            $this->access_token = $this->getUser()->getAttribute('access_token', '', 'subscriber');
            $this->kup_uuid = $request->getParameter('kup_uuid', '');
            $this->room_uuid = $request->getParameter('room_uuid', sfConfig::get('mod_facebook_ligue1_2012_room_uuid'));

            $this->kupsData = $this->getLigue1KupsData($request, $this->room_uuid);
        }

        /**
         * Display ranking clubs page
         *
         * @param sfWebRequest $request
         */
        public function executeRankingClubs(sfWebRequest $request) {
            $this->access_token = $this->getUser()->getAttribute('access_token', '', 'subscriber');
        }

        /**
         * Display ranking friends page
         *
         * @param sfWebRequest $request
         */
        public function executeRankingFriends(sfWebRequest $request) {
            $this->access_token = $this->getUser()->getAttribute('access_token', '', 'subscriber');
        }

        /**
         * Display ranking my club page
         *
         * @param sfWebRequest $request
         */
        public function executeRankingMyClub(sfWebRequest $request) {
            $this->access_token = $this->getUser()->getAttribute('access_token', '', 'subscriber');
        }

        /**
         * Display ranking individual box
         *
         * @param sfWebRequest $request
         */
        public function executeRankingBoxIndividual(sfWebRequest $request) {
            $this->access_token = $this->getUser()->getAttribute('access_token', '', 'subscriber');
            $this->offset = $request->getParameter('offset', 0);
            $this->batchSize = $request->getParameter('batchSize', 11);
            $this->room_uuid = $request->getParameter('room_uuid', '');
            $this->kup_uuid = $request->getParameter('kup_uuid', '');

            if ($this->room_uuid == '') {
                $this->room_uuid = sfConfig::get('mod_facebook_ligue1_2012_room_uuid');
            }

            if ($this->kup_uuid == '') {
                $this->rankings = $this->getRoomRanking($request, $this->room_uuid, $this->offset, $this->batchSize);
                $this->nbPlayers = $this->rankings['totalMembers'];
            }
            else {
                $this->rankings = $this->getKupRanking($request, $this->kup_uuid, $this->offset, $this->batchSize);
                $this->nbPlayers = $this->rankings['totalMembers'];

            }
        }

        /**
         * Display ranking individual podium box
         *
         * @param sfWebRequest $request
         */
        public function executeRankingIndividualHonorBox(sfWebRequest $request) {
            $room_uuid = sfConfig::get('mod_facebook_ligue1_2012_room_uuid');
            $cacheKey = 'facebook_ligue1_2012_individual_ranking_honor_box_day';
            $this->rankingDay = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->rankingDay)) {
                $kupsData = $this->getRoomKups($request, array('uuid' => $room_uuid, 'with_security' => false));
                $lastKups = $this->getResultsKups($kupsData);

                $this->rankingDay = array();
                if (count($lastKups) > 0) {
                    $lastKups = $this->usortByArrayKey($lastKups, 'startDate', SORT_DESC);
                    $this->rankingDay = $this->getKupRanking($request, $lastKups[0]['uuid'], 0, 3, false, false);

                    $podiumRanking = array(
                        'entries' => array(
                            0 => array(), 1 => array(), 2 => array()
                        )
                    );
                    foreach ($this->rankingDay['entries'] as $key => $ranking) {
                        if ($key == 0) {
                            $podiumRanking['entries'][1] = $ranking;
                        }
                        else if ($key == 1) {
                            $podiumRanking['entries'][0] = $ranking;
                        }
                        else if ($key == 2) {
                            $podiumRanking['entries'][2] = $ranking;
                        }
                    }
                    $this->rankingDay = $podiumRanking;
                    sfMemcache::getInstance()->set($cacheKey, $this->rankingDay, 0, 3600);
                }
            }

        }

        /**
         * Display ranking my club podium box
         *
         * @param sfWebRequest $request
         */
        public function executeRankingMyClubHonorBox(sfWebRequest $request) {
            $cacheKey = 'facebook_ligue1_2012_my_club_ranking_honor_box_day';
            $this->rankingDay = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->rankingDay)) {

                $this->room_uuid = $this->getUser()->getAttribute('clubId', '', 'subscriber');
                $rankingMyClub = $this->getRoomRanking($request, $this->room_uuid, 0, 3, false, false);

                $this->rankingDay = array();
                if (count($rankingMyClub) > 0) {

                    $podiumRanking = array(
                        'entries' => array(
                            0 => array(), 1 => array(), 2 => array()
                        )
                    );
                    foreach ($rankingMyClub['entries'] as $key => $ranking) {
                        if ($key == 0) {
                            $podiumRanking['entries'][1] = $ranking;
                        }
                        else if ($key == 1) {
                            $podiumRanking['entries'][0] = $ranking;
                        }
                        else if ($key == 2) {
                            $podiumRanking['entries'][2] = $ranking;
                        }
                    }
                    $this->rankingDay = $podiumRanking;
                    sfMemcache::getInstance()->set($cacheKey, $this->rankingDay, 0, 3600);
                }
            }

        }

        /**
         * Display ranking clubs box
         *
         * @param sfWebRequest $request
         */
        public function executeRankingBoxClubs(sfWebRequest $request) {
            $cacheKey = 'facebook_ligue1_2012_home_clubs_ranking';
            $clubs = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($clubs)) {

                $bindings = BetkupLigue1::getLigue1ClubsBindings();
                $clubs = $this->getClubsDataForBindings($request, $bindings);
                $clubs = $this->usortByArrayKey($clubs, 'rankingPoints', SORT_DESC);
                sfMemcache::getInstance()->set($cacheKey, $clubs, 0, 3600);
            }
            $this->clubs = $clubs;
        }

        /**
         * Display ranking friends box
         *
         * @param sfWebRequest $request
         */
        public function executeRankingBoxFriends(sfWebRequest $request) {
            $this->access_token = $this->getUser()->getAttribute('access_token', '', 'subscriber');
            $this->offset = $request->getParameter('offset', 0);
            $this->batchSize = $request->getParameter('batchSize', 11);
            $this->room_uuid = $request->getParameter('room_uuid', '');
            if ($this->room_uuid == '') {
                $this->room_uuid = sfConfig::get('mod_facebook_ligue1_2012_room_uuid');
            }
            $this->kup_uuid = $request->getParameter('kup_uuid', '');

            // Default (room ranking)
            $this->rankings = $this->getRoomRanking($request, $this->room_uuid, $this->offset, $this->batchSize, true);
            $this->nbPlayers = $this->rankings['totalFriends'];
        }

        /**
         * Display ranking my club box
         *
         * @param sfWebRequest $request
         */
        public function executeRankingBoxMyClub(sfWebRequest $request) {
            $this->access_token = $this->getUser()->getAttribute('access_token', '', 'subscriber');
            $this->offset = $request->getParameter('offset', 0);
            $this->batchSize = $request->getParameter('batchSize', 11);
            $this->room_uuid = $request->getParameter('room_uuid', '');
            if ($this->room_uuid == '') {
                $this->room_uuid = $this->getUser()->getAttribute('clubId', '', 'subscriber');
            }
            $this->kup_uuid = $request->getParameter('kup_uuid', '');

            $this->rankings = $this->getRoomRanking($request, $this->room_uuid, $this->offset, $this->batchSize);
            $this->nbPlayers = $this->rankings['totalMembers'];
        }

        /**
         * Display rules page
         *
         * @param sfWebRequest $request
         */
        public function executeRules(sfWebRequest $request) {

        }

        /**
         * Display box home friends to invite
         *
         * @param sfWebRequest $request
         */
        public function executeHomeFriendsToInvite(sfWebRequest $request) {

            $this->friends = array();
            $access_token = $request->getParameter('access_token', '');

            $page_id = sfConfig::get('app_facebook_betkup_page_id');

            $limit = 20;

            $friendsQuery = 'SELECT uid, name, pic_small, pic_square FROM user WHERE is_app_user=0 AND uid in (SELECT uid2 FROM friend WHERE uid1=me())';
            $friendsLikePageQuery = 'SELECT uid FROM page_fan WHERE uid in (' . $friendsQuery . ') AND page_id=' . $page_id;
            $friendsLikePageQuery = 'SELECT uid, name, pic_small, pic_square FROM user WHERE uid in (' . $friendsLikePageQuery . ')';

            $multi_query = array(
                'friendsLikedPage' => $friendsLikePageQuery . ' LIMIT ' . $limit,
                'friends'          => $friendsQuery . ' LIMIT ' . $limit
            );

            $app_id = sfConfig::get('mod_facebook_ligue1_2012_facebook_connect_app_id');
            $app_secret = sfConfig::get('mod_facebook_ligue1_2012_facebook_connect_app_secret');
            $config = array(
                'appId'  => $app_id,
                'secret' => $app_secret,
                'cookie' => true,
            );
            $facebook = new Facebook($config);
            $facebook->setAccessToken($access_token);

            $params = array(
                'method'  => 'fql.multiquery',
                'queries' => json_encode($multi_query)
            );

            try {
                $this->friends = $facebook->api($params);
                $this->friends = $this->getSortMultiFriendsDatas($this->friends, $limit);
            } catch (FacebookApiException $e) {
                error_log($e);
            }

        }

        /**
         * Display the next match box on home page.
         *
         * @param sfWebRequest $request
         */
        public function executeHomeNextMatch(sfWebRequest $request) {

            $id = $this->getUser()->getAttribute('subscriberId', '', 'subscriber');
            $cacheKey = 'facebook_ligue1_2012_home_current_kup_' . $id;
            $this->kupData = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->kupData)) {
                $this->kupData = $this->getNextMatch($request);
                if(!empty($this->kupData)) {
                    sfMemcache::getInstance()->set($cacheKey, $this->kupData, 0, 900); // 15m cache
                }
            }
            $this->kup_uuid = $request->getParameter('kup_uuid', '');
            $this->room_uuid = $request->getParameter('room_uuid', '');

            $cacheKey = 'app_ligue1_home_next_match_kup_rounds_data_for_kup_' . $this->kup_uuid;
            $this->kupRoundsData = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->kupRoundsData)) {
                $this->kupRoundsData = $this->getKupRoundsData($request, $this->kup_uuid);
                sfMemcache::getInstance()->set($cacheKey, $this->kupRoundsData, 0, 259200); // 3 days cache
            }

            $cacheKey = 'app_ligue1_home_next_match_kup_round_uuid_for_kup_' . $this->kup_uuid;
            $this->roundUUID = sfMemcache::getInstance()->get($cacheKey, '');
            if ($this->roundUUID == '') {
                if (count($this->kupRoundsData) > 0) {
                    $this->roundUUID = $this->getRoundUUID($request, $this->kup_uuid, $this->kupRoundsData);
                    sfMemcache::getInstance()->set($cacheKey, $this->roundUUID, 0, 259200); // 3 days cache
                }
            }

            $cacheKey = 'app_ligue1_home_next_match_kup_games_data_for_kup_' . $this->kup_uuid . '_round_' . $this->roundUUID;
            $this->kupGamesData = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->kupGamesData)) {
                $this->kupGamesData = $this->getKupGamesData($request, $this->kup_uuid, $this->roundUUID, false, '');

                $countKupGamesData = count($this->kupGamesData);
                if ($countKupGamesData > 0) {
                    $FrontKupGameData = array();
                    $this->kupGamesData = $this->usortByArrayKey($this->kupGamesData, 'title', SORT_ASC);
                    $clubBindings = BetkupLigue1::getLigue1ClubsBindings();

                    $i = 0;
                    foreach ($this->kupGamesData as $kupGameData) {
                        $FrontKupGameData[$i]['title'] = $kupGameData['title'];
                        $FrontKupGameData[$i]['team1Bindings'] = $clubBindings[$kupGameData['team1id']];
                        $FrontKupGameData[$i]['team2Bindings'] = $clubBindings[$kupGameData['team2id']];
                        $FrontKupGameData[$i]['team1Bindings']['room_uuid'] = $clubBindings[$kupGameData['team1id']]['betkup_room_id'];
                        $FrontKupGameData[$i]['team2Bindings']['room_uuid'] = $clubBindings[$kupGameData['team2id']]['betkup_room_id'];

                        /* For the moment we enable this to optimise the display speed.

                        $team1Room = $this->getLigue1Room($request, $clubBindings[$kupGameData['team1id']]['betkup_room_name']);
                        $team2Room = $this->getLigue1Room($request, $clubBindings[$kupGameData['team2id']]['betkup_room_name']);
                        $FrontKupGameData[$i]['team1Bindings']['roomData'] = $team1Room;
                        $FrontKupGameData[$i]['team2Bindings']['roomData'] = $team2Room;
                        */

                        $i++;
                    }
                    $this->kupGamesData = $FrontKupGameData;
                }
                if (!empty($this->kupGamesData)) {
                    sfMemcache::getInstance()->set($cacheKey, $this->kupGamesData, 0, 259200); // 3 days cache
                }

            }

            $this->dateFirstMatch = '';
            $this->dateLastMatch = '';
            $countKupGamesData = count($this->kupGamesData);
            if ($countKupGamesData > 0) {
                $this->dateFirstMatch = $this->kupGamesData[0]['title'];
                $this->dateLastMatch = $this->kupGamesData[$countKupGamesData - 1]['title'];
            }

        }

        /**
         * Get the roomData for the associate room and cache it.
         *
         * @param sfWebRequest $request
         * @param string       $roomAssociate
         *
         * @return array $roomData (the room datas)
         */
        private function getLigue1Room(sfWebRequest $request, $roomAssociate) {

            $cacheKey = 'facebook_ligue1_2012_room_associate_' . str_replace(' ', '_', $roomAssociate);
            $roomData = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($roomData)) {
                $roomData = $this->getRoomByName($request, $roomAssociate);
                sfMemcache::getInstance()->set($cacheKey, $roomData, 0, 900);
            }
            return $roomData;
        }

        /**
         * Display box home friends to invite
         *
         * @param sfWebRequest $request
         */
        public function executeHomeFriendsRanking(sfWebRequest $request) {

            $this->friendsRanking = array();
            $this->room_uuid = $request->getParameter('room_uuid', '');

            $id = $this->getUser()->getAttribute('subscriberId', '', 'subscriber');
            $cacheKey = 'facebook_ligue1_2012_friends_ranking_' . $id;
            $this->friendsRanking = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->friendsRanking)) {
                $this->friendsRanking = $this->getRoomRanking($request, $this->room_uuid, 0, 20, true);
                sfMemcache::getInstance()->set($cacheKey, $this->friendsRanking, 0, 3600);
            }

        }

        /**
         * Get merge and sort the facebook multi query in an array
         *
         * show only friends who's not like the app.
         * show friends who liked the page first.
         *
         * @param array  $multiQuery
         * @param int    $maxFriends
         *
         * @return array
         */
        private function getSortMultiFriendsDatas($multiQuery, $maxFriends = 10) {
            $queryFriends = array();
            $queryLikedPage = array();
            if (!empty($multiQuery)) {
                foreach ($multiQuery as $entries) {
                    if (isset($entries['fql_result_set']) && !empty($entries['fql_result_set'])) {
                        foreach ($entries['fql_result_set'] as $fb_results) {
                            if (isset($entries['name']) && $entries['name'] == 'friends') {
                                $queryFriends[] = $fb_results;
                            }
                            else if (isset($entries['name']) && $entries['name'] == 'friendsLikedPage') {
                                $queryLikedPage[] = $fb_results;
                            }
                        }
                    }
                }
                $sortedFriends = array_merge($queryLikedPage, $queryFriends);
                return array_slice($sortedFriends, 0, $maxFriends);
            }
            return array();
        }

        /**
         * Validate the club form to add user to a club.
         *
         * @param sfWebRequest $request
         */
        public function executeValidateClub(sfWebRequest $request) {
            if ($request->isMethod('post')) {
                // Add the user into the general room.
                $this->joinRoom($request, sfConfig::get('mod_facebook_ligue1_2012_room_uuid'));

                // Add the user into his chosen club.
                $clubName = $request->getParameter('club_id', 0);
                $password = $request->getParameter('club_password', 0);
                $club = $this->getRoomByName($request, $clubName);
                $this->joinRoom($request, $club['uuid'], $password, $clubName, 1);
            }
            $this->redirect(array(
                                 'module' => 'facebook_ligue1_2012',
                                 'action' => 'home',
                                 'inviteFriend' => 1
                            ));
        }

        /**
         * Get clubs datas depending on bindings you give.
         *
         * @param $request
         * @param $bindings
         *
         * @return array
         */
        private function getClubsDataForBindings($request, $bindings) {
            $cacheKey = 'facebook_ligue1_2012_home_clubs_data';
            $clubData = sfMemcache::getInstance()->get($cacheKey, array());

            if (empty($clubData)) {
                $clubData = array();
                $i = 0;
                foreach ($bindings as $club) {
                    $roomData = $this->getRoom($request, $club['betkup_room_id']);
                    $roomRanking = $this->getRoomRanking($request, $club['betkup_room_id'], 0, 1);
                    $clubData[$i]['uuid'] = $roomData['uuid'];
                    $clubData[$i]['numberOfMembers'] = $roomData['numberOfMembers'];
                    $clubData[$i]['rankingPoints'] = intval($roomRanking['entriesTotalPoints']);
                    $clubData[$i]['ui'] = $club;
                    $i++;
                }
                sfMemcache::getInstance()->set($cacheKey, $clubData, 0, 3600);
            }

            return $clubData;
        }

        /**
         * Get club datas for specific club.
         *
         * @param $request
         * @param $bindings
         *
         * @return array
         */
        private function getUserClubDataForBindings($request, $bindings, $club_name = '') {
            if ($club_name == '') {
                $userClubName = $this->getUser()->getAttribute('clubBindingName', '', 'subscriber');
            }
            else {
                $userClubName = $club_name;
            }

            $cacheKey = 'facebook_ligue1_2012_club_datas_' . str_replace(' ', '_', $userClubName);
            $clubData = sfMemcache::getInstance()->get($cacheKey, array());

            if (empty($clubData)) {
                $i = 0;
                foreach ($bindings as $club) {
                    if ($club['betkup_room_name'] == $userClubName) {
                        $roomData = $this->getRoom($request, $club['betkup_room_id']);
                        $roomRanking = $this->getRoomRanking($request, $roomData['uuid'], 0, 2);
                        $clubData[$i] = $roomData;
                        $clubData[$i]['rankingPoints'] = $roomRanking['entriesTotalPoints'];
                        $clubData[$i]['ui'] = $club;
                        break;
                    }
                }
                sfMemcache::getInstance()->set($cacheKey, $clubData, 0, 900);
            }
            return $clubData;
        }

        /**
         * Get the header image for user club.
         *
         * @return string
         */
        private function getClubHeader($clubs, $clubName = '') {

            if ($clubName != '') {
                $userClubName = $clubName;
            }
            else {
                $userClubName = $this->getUser()->getAttribute('clubBindingName', '', 'subscriber');
            }

            foreach ($clubs as $club) {
                if ($club['betkup_room_name'] == $userClubName) {
                    return $club['header'];
                }
            }
            return '';
        }

        /**
         * Get the feed url for user club.
         *
         * @return string
         */
        private function getClubFeed($clubs, $clubName = '') {

            if ($clubName != '') {
                $userClubName = $clubName;
            }
            else {
                $userClubName = $this->getUser()->getAttribute('clubBindingName', '', 'subscriber');
            }

            foreach ($clubs as $club) {
                if ($club['betkup_room_name'] == $userClubName) {
                    return $club['feed'];
                }
            }
            return '';
        }

        /**
         * Get messages for predictions on a facebook predictions publish
         *
         * @param sfWebRequest $request
         * @param array        $kupData
         *
         * @return string
         */
        private function getAppL1FacebookPublishPropertiesFor($request, $kupData) {

            $properties = array();

            // Facebook requires a "key" => "value" mapping used within the publish message.
            // Note, we need to localize it. (based on betkup not facebook localization)
            $description = $this->getContext()->getI18n()->__('label_facebook_publish_description');
            $kup = $this->getContext()->getI18n()->__('label_facebook_publish_kup');
            $stake = $this->getContext()->getI18n()->__('label_facebook_publish_stake');
            $jackpot = $this->getContext()->getI18n()->__('label_facebook_publish_jackpot_app_l1');
            $predictions = $this->getContext()->getI18n()->__('label_facebook_publish_predictions');

            $properties[$description] = $kupData['description'];
            $properties[$kup] = 'App Facebook'; // XXX i18n
            $properties[$stake] = 'gratuit';
            $properties[$jackpot] = 'Fifa 13 et plus de 7000€ de lots et bonus'; // XXX i18n
            $properties[$predictions] = '';

            $predictions_se = $this->getUser()->getAttribute('predictions_se', '', 'predictionsSave');
            $predictions_ic = $this->getUser()->getAttribute('predictions_ic', '', 'predictionsSave');

            $predictionsProperties = array();
            $predictionsPropertiesIndex = 0;

            if ($predictions_se != '' || $predictions_ic != '') {

                // Case of SE
                $countProperties = 0;
                foreach ($predictions_se as $key => $prediction) {
                    $explodedKey = explode('_', $key);
                    $gameUUID = $explodedKey[0];
                    $homeOrAway = $explodedKey[1];
                    $game = $this->getCoreSportGameByUUID($request, $gameUUID);

                    if ($countProperties == 0) {
                        $predictionsProperties[$predictionsPropertiesIndex] = '';
                    }
                    if ($homeOrAway == 1) {
                        $predictionsProperties[$predictionsPropertiesIndex] .= $game['teams'][0]['name'] . ' ' . $prediction;
                    }
                    else if ($homeOrAway == 2) {
                        $predictionsProperties[$predictionsPropertiesIndex] .= ' - ' . $prediction . ' ' . $game['teams'][1]['name'] . ', ';
                    }
                    $countProperties++;

                    if ($countProperties == 4) {
                        $countProperties = 0;
                        $predictionsProperties[$predictionsPropertiesIndex] = substr($predictionsProperties[$predictionsPropertiesIndex], 0, -2);
                        $predictionsPropertiesIndex++;
                    }
                }

                // Case of IC
                $countProperties = 0;
                foreach ($predictions_ic as $key => $prediction) {
                    $explodedKey = explode('_', $key);
                    $gameUUID = $explodedKey[0];
                    $game = $this->getCoreSportGameByUUID($request, $gameUUID);

                    if ($countProperties == 0) {
                        $predictionsProperties[$predictionsPropertiesIndex] = '';
                    }
                    $predictionsProperties[$predictionsPropertiesIndex] .= $game['teams'][0]['name'] . ' vs ' . $game['teams'][1]['name'] . ' : ';
                    if ($prediction == 2) {
                        $predictionsProperties[$predictionsPropertiesIndex] .= 'match nul'; // XXX i18n
                    }
                    else if ($prediction == 1) {
                        $predictionsProperties[$predictionsPropertiesIndex] .= $game['teams'][0]['name'];
                    }
                    else if ($prediction == 3) {
                        $predictionsProperties[$predictionsPropertiesIndex] .= $game['teams'][1]['name'];
                    }
                    $predictionsProperties[$predictionsPropertiesIndex] .= ', ';

                    $countProperties++;

                    if ($countProperties == 6) {
                        $countProperties = 0;
                        $predictionsProperties[$predictionsPropertiesIndex] = substr($predictionsProperties[$predictionsPropertiesIndex], 0, -2);
                        $predictionsPropertiesIndex++;
                    }
                }

                foreach ($predictionsProperties as $key => $prediction) {
                    $properties['pronos ' . ($key + 1)] = $prediction;
                }
            }

            return $properties;
        }

    }
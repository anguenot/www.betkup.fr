<?php

/**
 * facebook_f1_sport24 actions.
 *
 * @package    betkup.fr
 * @subpackage facebook_f1_sport24
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: actions.class.php 6398 2012-10-31 15:35:43Z jmasmejean $
 */
class facebook_f1_sport24Actions extends betkupActions {

	/**
	 * Executes home action to show home page
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeHome(sfWebRequest $request) {
        $this->room_uuid = sfConfig::get('mod_facebook_f1_sport24_room_associate_uuid');

        $kupsData = $this->getNextKupsFor($request, $this->room_uuid);
        $this->kupData = $kupsData[0];
		$this->kup_uuid = $this->kupData['uuid'];
	}

    /**
     * Get all currents and next incoming kups.
     *
     * @param sfWebRequest $request
     * @param $room_uuid
     *
     * @return array|string
     */
    private function getNextKupsFor(sfWebRequest $request, $room_uuid) {
        $cacheKey = 'betkup_app_sport24_f1_room_kups_data_for_' . $room_uuid;
        $kupsData = sfMemcache::getInstance()->get($cacheKey, array());

        if (empty($kupsData)) {
            $params = array(
                'uuid' => $room_uuid,
                'with_security' => false);
            $kups = $this->getRoomKups($request, $params);
            $nextKups = $this->getNextRacesFor($kups);

            // We make the cache timestemp from today to next future race.
            $cacheTimestamp = 86400; //1 day cache default
            $futureRaceTime = 0;
            $currentTime = time();

            // If there are future race
            if(isset($nextKups[1]) && !empty($nextKups[1])) {
                $futureRaceTime = substr($nextKups[1]['startDate'], 0, 10);
            }
            // If there are not future race, we take the current race.
            else if(isset($nextKups[0]) && !empty($nextKups[0])) {
                $futureRaceTime = substr($nextKups[0]['startDate'], 0, 10);
            }
            // If there are future race, we take the diff between today and future race startDate
            if($currentTime < $futureRaceTime) {
                $cacheTimestamp = $futureRaceTime - $currentTime;
            }
            $kupsData = $nextKups;
            sfMemcache::getInstance()->set($cacheKey, $kupsData, 0, $cacheTimestamp);
        }

        return $kupsData;
    }

    /**
     * Get the next races.
     *
     * Return only kups with status < 3 and != -1 pre-sorted
     *
     * @param array $kups
     *
     * @return array $nextKups
     */
    private function getNextRacesFor($kups) {
        $kupsData = $this->sortKupsDataFor($kups, 'ASC');
        $nextKups = array();
        foreach ($kupsData as $kupData) {
            if ($kupData['status'] < 3 && $kupData['status'] != -1) {
                $nextKups[] = $kupData;
            }
        }
        if (empty($nextKups)) {
            $nextKups = array($kupsData[count($kupsData) - 1]);
        }

        return $nextKups;
    }

	/**
	 * Executes homeHowTo action to show how to box on the home page
	 *
	 * @param sfWebRequest $request
	 */
	public function executeHomeHowTo(sfWebRequest $request) {
	}

	/**
	 * Executes lastResults action to show last results box on the home page
	 *
	 * @param sfWebRequest $request
	 */
	public function executeHomeLastResults(sfWebRequest $request) {
		$this->kup_uuid = $request->getParameter('kup_uuid', '');
		$this->room_uuid = $request->getParameter('room_uuid', '');
		$this->kupData = $request->getParameter('kup_data', array());
	}

	/**
	 * Executes homeNextRace action to show next race box on the home page
	 *
	 * @param sfWebRequest $request
	 */
	public function executeHomeNextRace(sfWebRequest $request) {
		$this->kup_uuid = $request->getParameter('kup_uuid', '');
		$this->room_uuid = $request->getParameter('room_uuid', '');
		$this->kupData = $request->getParameter('kup_data', '');
		$this->urlLike = $this->getCustomUriPrefix($request).$this->getController()->genUrl(array('module' => 'facebook_f1_sport24', 'action' => 'nextRace'));
	}

	/**
	 * Executes homeNews action to show news box on the home page
	 *
	 * @param sfWebRequest $request
	 */
	public function executeHomeNews(sfWebRequest $request) {
		$this->rssFeed = RSSParser::parser(sfConfig::get('mod_facebook_f1_sport24_rss_parser_url'));
	}

	/**
	 * Executes homeRanking action to show ranking box on the home page
	 *
	 * @param sfWebRequest $request
	 */
	public function executeHomeRanking(sfWebRequest $request) {
		$this->room_uuid = $request->getParameter('room_uuid', '');

        $cacheKey = 'betkup_app_sport24_f1_room_general_ranking_for_' . $this->room_uuid.'_'.$this->getUser()->getAttribute('subscriberId', '', 'subscriber');
        $this->generalRanking = sfMemcache::getInstance()->get($cacheKey, array());
        if (empty($this->generalRanking)) {
            $this->generalRanking = $this->getAppRanking($request, $this->room_uuid, 0, 1);
            sfMemcache::getInstance()->set($cacheKey, $this->generalRanking, 0, 86400);// 1 day cache
        }

        $cacheKey = 'betkup_app_sport24_f1_room_friends_ranking_for_' . $this->room_uuid.'_'.$this->getUser()->getAttribute('subscriberId', '', 'subscriber');
        $this->friendsRanking = sfMemcache::getInstance()->get($cacheKey, array());
        if (empty($this->friendsRanking)) {
            $this->friendsRanking = $this->getAppFacebookRanking($request, $this->room_uuid, 0, 5);
            sfMemcache::getInstance()->set($cacheKey, $this->friendsRanking, 0, 86400);// 1 day cache
        }

		$this->titleInviteRequest = $this->getContext()->getI18n()->__('text_facebook_sport24_home_ranking_title_invite_request');
		$this->messageInviteRequest = $this->getContext()->getI18n()->__('text_facebook_sport24_home_ranking_message_invite_request');
	}

	/**
	 * Executes homePromo action to show betkup promo box on the home page
	 *
	 * @param sfWebRequest $request
	 */
	public function executeHomePromo(sfWebRequest $request) {
	}

	/**
	 * Executes predictions action to show predictions for kups
	 *
	 * @param sfWebRequest $request
	 */
	public function executePredictions(sfWebRequest $request) {

		$this->room_uuid = sfConfig::get('mod_facebook_f1_sport24_room_associate_uuid');
		$kupsData = $this->getNextKupsFor($request, $this->room_uuid);
        $this->kupData = $kupsData[0];
		$this->kup_uuid = $this->kupData['uuid'];

		$roomUIFile = sfConfig::get('mod_facebook_f1_sport24_room_associate_ui', '');
		$this->roomUI = array();
		if($roomUIFile != '') {
			$this->roomUI = $this->getRoomUIFor($roomUIFile);
		}
		
		if(isset($this->kupData["ui"]["rules_view_template"]) && ($this->kupData["ui"]["rules_view_template"] != "")) {
			$this->includeRules = explode(",",$this->kupData["ui"]["rules_view_template"]);
		}
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
	 * Execute lastResult action to show last results on the home page
	 *
	 * @param sfWebRequest $request
	 */
	public function executeLastResults(sfWebRequest $request) {
		$this->offset = $request->getParameter('offset', 0);
		$this->batchSize = $request->getParameter('batchSize', 3);
		$this->kup_uuid =  $request->getParameter('kup_uuid', '');
		$this->challengers = array();
		$this->totalChallengers = 0;
		$this->filter = $request->getParameter('filter', '');

		if(isset($this->filter['last_results_filter']) && $this->filter['last_results_filter'] == '0') {

			$lastResults = $this->getAppLastResults($request, $this->kup_uuid, $this->offset, $this->batchSize);
			$this->challengers = $lastResults['results'];
			$this->totalChallengers = $lastResults['total'];


		} else if(isset($this->filter['last_results_filter']) && $this->filter['last_results_filter'] == '1') {

			$lastResults = $this->getAppFriendsLastResults($request, $this->kup_uuid, $this->offset, $this->batchSize);
			$this->challengers = $lastResults['results'];
			$this->totalChallengers = $lastResults['total'];
		}
	}

	/**
	 * Display main ranking page.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeRanking(sfWebRequest $request) {
		$this->room_uuid = $request->getParameter('room_uuid', '');
		$this->batchSize = $request->getParameter('batchSize', sfConfig::get('mod_facebook_f1_sport24_ranking_batch_size'));
		$this->offset = $request->getParameter('offset', 0);
		$this->selectedTab = $request->getParameter('selectedTab', '1');

		if($this->room_uuid == '') {
			$this->room_uuid = sfConfig::get('mod_facebook_f1_sport24_room_associate_uuid');
		}

        $cacheKey = 'betkup_app_sport24_f1_room_kups_desc_data_for_' . $this->room_uuid;
        $this->kupsData = sfMemcache::getInstance()->get($cacheKey, array());

        if (empty($this->kupsData)) {
            $params = array(
                'uuid' => $this->room_uuid,
                'with_security' => false);
            $roomKups = $this->getRoomKups($request, $params);
            $this->kupsData = $this->sortKupsDataFor($roomKups);
            sfMemcache::getInstance()->set($cacheKey, $this->kupsData, 0, 7200);//2h cache
        }
		$this->kupData = $this->getLatestClosedKup($this->kupsData);
	}

	/**
	 * Display a global unfiltered ranking.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeRankingGeneral(sfWebRequest $request) {

		$this->room_uuid = $request->getParameter('room_uuid', '');
		$this->kup_uuid = $request->getParameter('kup_uuid', '');
		$this->offset = $request->getParameter('offset', 0);
		$this->batchSize = $request->getParameter('batchSize', sfConfig::get('mod_facebook_f1_sport24_ranking_batch_size'));
		
		$this->urlFbCommentRanking = $this->getFacebookCommentsURL();
		$this->selectedTab = 1;
		
		$this->isRoomRanking = false;
		if($this->kup_uuid != '-1' && $this->kup_uuid != '') {

            $this->kupData = $this->getKupData($request, $this->kup_uuid);
            $this->rankingData = $this->getRanking($request, $this->kup_uuid, $this->offset, $this->batchSize);
		} else {

			$this->kupData = array();
			$this->rankingData = $this->getRoomRankingFor($request, $this->room_uuid, $this->offset, $this->batchSize);
            $this->isRoomRanking = true;
		}
	}

	/**
	 * Display a friends filtered ranking.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeRankingFriends(sfWebRequest $request) {
		
		$this->room_uuid = $request->getParameter('room_uuid', '');
		$this->kup_uuid = $request->getParameter('kup_uuid', '');
		$this->offset = $request->getParameter('offset', 0);
		$this->batchSize = $request->getParameter('batchSize', sfConfig::get('mod_facebook_f1_sport24_ranking_batch_size'));
		
		$this->selectedTab = 2;
	
		$this->isRoomRanking = false;
		if($this->kup_uuid != '-1' && $this->kup_uuid != '') {
			$this->kupData = $this->getKupData($request, $this->kup_uuid);
			$this->rankingData = $this->getRanking($request, $this->kup_uuid, $this->offset, $this->batchSize, true);
		} else {
			$this->kupData = array();
			$this->rankingData = $this->getRoomRankingFor($request, $this->room_uuid, $this->offset, $this->batchSize, true);	
			$this->isRoomRanking = true;
		}
	}

	/**
	 * Executes results action to show results for kups
	 *
	 * @param sfWebRequest $request
	 */
	public function executeResults(sfWebRequest $request) {
        $this->room_uuid = sfConfig::get('mod_facebook_f1_sport24_room_associate_uuid');

        $cacheKey = 'betkup_app_sport24_f1_room_kups_desc_data_for_' . $this->room_uuid;
        $this->kupsData = sfMemcache::getInstance()->get($cacheKey, array());

        if (empty($this->kupsData)) {
            $params = array(
                'uuid' => $this->room_uuid,
                'with_security' => false);
            $roomKups = $this->getRoomKups($request, $params);
            $this->kupsData = $this->sortKupsDataFor($roomKups);
            sfMemcache::getInstance()->set($cacheKey, $this->kupsData, 0, 7200);//2h cache
        }
		$this->kupData = $this->getLatestClosedKup($this->kupsData);
	}
	
	/**
	 * Display the F1 result component depending on the choosen kup_uuid.
	 * 
	 * @param sfWebRequest $request
	 */
	public function executeResultsLoad(sfWebRequest $request) {
		$this->kupsData = $request->getParameter('kupsData', '');
		$this->room_uuid = $request->getParameter('room_uuid', '');
		$this->result_kup = $request->getParameter('results_kups', '');
		
		if($this->result_kup == '') {
			$this->kupData = $this->getLatestClosedKup($this->kupsData);
		} else {
			$this->kupData = $this->getKupDataByUuidFor($this->kupsData, $this->result_kup);
		}
		$this->kup_uuid = $this->kupData['uuid'];
	}

	/**
	 * Executes rules action to show rules for kups
	 *
	 * @param sfWebRequest $request
	 */
	public function executeRules(sfWebRequest $request) {
	}

	/**
	 * Connect players to Facebook.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeFacebookConnect(sfWebRequest $request) {

		$app_id = sfConfig::get('mod_facebook_f1_sport24_facebook_connect_app_id');
		$app_secret = sfConfig::get('mod_facebook_f1_sport24_facebook_connect_app_secret');
		$app_scope = sfConfig::get('mod_facebook_f1_sport24_facebook_connect_app_scope');
		$my_url = $request->getUriPrefix().$this->generateUrl('sport24_login_facebook');

		$code = "";
		if (isset($_REQUEST["code"])) {
			$code = $_REQUEST["code"];
		}

		if (empty($code)) {

			$_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
			$dialog_url = "https://www.facebook.com/dialog/oauth?scope="
			. $app_scope . "&client_id="
			. $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
			. $_SESSION['state'];
			echo "<script type='text/javascript'>top.location.href = '" . $dialog_url . "';</script>";
			//$this->redirect($dialog_url);
		}

		if (isset($_REQUEST['state']) && isset($_SESSION['state']) && $_REQUEST['state'] == $_SESSION['state']) {

			$token_url = "https://graph.facebook.com/oauth/access_token?"
			. "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
			. "&client_secret=" . $app_secret . "&code=" . $code;

			$response = file_get_contents($token_url);
			$params = null;
			parse_str($response, $params);
			$access_token = $params['access_token'];

			$graph_url = "https://graph.facebook.com/me?access_token=".$access_token;

			$user = json_decode(file_get_contents($graph_url));
			$email = $user->email;
			$fb_id = $user->id;
			$birthdate = $user->birthday;

			$params = array(
					'communityId' => sfConfig::get('app_sofun_community_id'),
					'email' => $email,
					'facebookId' => $fb_id,
					'accessToken' => $access_token,
					'birthdate' => $birthdate,
			);

			$sofun = BetkupWrapper::_getSofunApp($request, $this);
			$resp = $sofun->api_GET("/member/facebook/exists/" . $fb_id);
			if ($resp["http_code"] == "202") {
				try {
					$response = $sofun->login($params);
				} catch (SofunApiException $e) {
					error_log($e);
					$this->redirect(array('module' => 'facebook_f1_sport24', 'action' => 'facebookConnect'));
				}
				if ($response['http_code'] == '202') {
					$sofun_member = $response['buffer'];
					BetkupWrapper::_setSofunSession($sofun->getSession(), $this);
					$this->_postLogin($request, $sofun_member);
					$this->joinSport24Room($request);
					//$this->redirect(array('module' => 'facebook_f1_sport24', 'action' => 'home'));
					$module = $this->getModuleName();
					$url_redirect = "https://apps.facebook.com/" . sfConfig::get('mod_' . $module . '_facebook_canvas_ns') . "/";
					echo "<script type='text/javascript'>top.location.href = '" . $url_redirect . "';</script>";
				} else {
					$this->redirect(array('module' => 'facebook_f1_sport24', 'action' => 'facebookConnect'));
				}
			} else {
				try {
					$response = $sofun->api_POST("/member/register/facebook", $params);
				} catch (SofunApiException $e) {
					error_log($e);
					$this->redirect(array('module' => 'facebook_f1_sport24', 'action' => 'facebookConnect'));
				}
				if ($response['http_code'] == '202') {
					$sofun_member = $response['buffer'];
					$this->_postLogin($request, $sofun_member);
					$this->joinSport24Room($request);
					//$this->redirect(array('module' => 'facebook_f1_sport24', 'action' => 'home'));
					$module = $this->getModuleName();
					$url_redirect = "https://apps.facebook.com/" . sfConfig::get('mod_' . $module . '_facebook_canvas_ns') . "/";
					echo "<script type='text/javascript'>top.location.href = '" . $url_redirect . "';</script>";
				} else {
					$this->redirect(array('module' => 'facebook_f1_sport24', 'action' => 'facebookConnect'));
				}
			}
		} else {
			error_log("The state does not match. You may be a victim of CSRF. Facebook Connect action.");
		}

	}

	/**
	 * Automatically have the player joined the dedicated Sport24 room where
	 * all the F1 kups will be.
	 */
	protected function joinSport24Room(sfWebRequest $request) {

		$room_uuid = $request->getParameter('room_uuid', '');
		if($room_uuid == '') {
			$roomData = $this->getRoomByName($request, sfConfig::get('mod_facebook_f1_sport24_room_associate_name'));
			$room_uuid = $roomData['uuid'];
		}
		$email = $this->getUser()->getAttribute('email', '', 'subscriber');
		$params = array(
				'email' => $email,
				'communityId' =>  sfConfig::get ('app_sofun_community_id'),
				'password' => $request->getParameter("password", ""),
		);
		$sofun = BetkupWrapper::_getSofunApp($request, $this);
		try {
			$response = $sofun->api_POST("/team/" . $room_uuid . "/member/add", $params);
		} catch (SofunApiException $e) {
			error_log($e);
		}
		if ($response["http_code"] != "202") {
			$this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_joined_room_error'));
		}
	}
	
	/**
	 * Returns the Facebook public comments URL for the comments plugin.
	 */
	private function getFacebookCommentsURL() {
		return 'https://apps.facebook.com/'.sfConfig::get('mod_facebook_f1_sport24_facebook_canvas_ns').'/ranking/1';
	}

}

<?php

/**
 * facebook_tdf actions.
 *
 * @package    betkup.fr
 * @subpackage facebook_tdf
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class facebook_tdfActions extends betkupActions
{
	/**
	 * Connect players to Facebook.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeFacebookConnect(sfWebRequest $request) {
	
		$app_id = sfConfig::get('mod_facebook_tdf_facebook_connect_app_id');
		$app_secret = sfConfig::get('mod_facebook_tdf_facebook_connect_app_secret');
		$app_scope = sfConfig::get('mod_facebook_tdf_facebook_connect_app_scope');
		$my_url = $this->getCustomUriPrefix($request).$this->generateUrl('facebook_tdf_login_facebook');
		
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
			//$this->redirect($dialog_url);
			echo "<script type='text/javascript'>top.location.href = '" . $dialog_url . "';</script>";
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
					$this->redirect(array('module' => 'facebook_tdf', 'action' => 'facebookConnect'));
				}
				if ($response['http_code'] == '202') {
					$sofun_member = $response['buffer'];
					BetkupWrapper::_setSofunSession($sofun->getSession(), $this);
					$this->_postLogin($request, $sofun_member);
					$this->joinRoom($request);
					//$this->redirect(array('module' => 'facebook_tdf', 'action' => 'home'));
					$module = $this->getModuleName();
					$url_redirect = "https://apps.facebook.com/" . sfConfig::get('mod_' . $module . '_facebook_canvas_ns') . "/";
					echo "<script type='text/javascript'>top.location.href = '" . $url_redirect . "';</script>";
				} else {
					$this->redirect(array('module' => 'facebook_tdf', 'action' => 'facebookConnect'));
				}
			} else {
				try {
					$response = $sofun->api_POST("/member/register/facebook", $params);
				} catch (SofunApiException $e) {
					error_log($e);
					$this->redirect(array('module' => 'facebook_tdf', 'action' => 'facebookConnect'));
				}
				if ($response['http_code'] == '202') {
					$sofun_member = $response['buffer'];
					$this->_postLogin($request, $sofun_member);
					$this->joinRoom($request);
					$module = $this->getModuleName();
					$url_redirect = "https://apps.facebook.com/" . sfConfig::get('mod_' . $module . '_facebook_canvas_ns') . "/";
					echo "<script type='text/javascript'>top.location.href = '" . $url_redirect . "';</script>";
					//$this->redirect(array('module' => 'facebook_tdf', 'action' => 'home'));
				} else {
					$this->redirect(array('module' => 'facebook_tdf', 'action' => 'facebookConnect'));
				}
			}
		} else {
			error_log("The state does not match. You may be a victim of CSRF. Facebook Connect action.");
		}

	}
	
	/**
	 * Automatically have the player joined the dedicated Tour de France room where
	 * all the TDF kups will be.
	 */
	protected function joinRoom(sfWebRequest $request) {
		$room_uuid = $request->getParameter('room_uuid', '');
		if($room_uuid == '') {
			
			$roomData = $this->getTdfRoom($request, sfConfig::get('mod_facebook_tdf_room_associate_name'));
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
	 * Get the next race.
	 * 
	 * Depending on kup startDate and kup status.
	 * 
	 * @param sfWebRequest $request
	 * @return kup next race.
	 */
	private function getNextRace(sfWebRequest $request) {
		$roomData = $this->getTdfRoom($request, sfConfig::get('mod_facebook_tdf_room_associate_name'));
		$room_uuid = $roomData['uuid'];
		$params = array('uuid' => $room_uuid);
		$kupsData = $this->sortKupsDataFor($this->getRoomKups($request, $params), 'ASC');
		$next = array();
		foreach ($kupsData as $kupData) {
			if ($kupData['status'] < 3 && $kupData['status'] != -1) {
				$next = $kupData;
				break;
			}
		}
		if (empty($next)) {
			$next = $kupsData[count($kupsData) - 1];
		}
		return $next;
	}
	
	/**
	 * Home action.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeHome(sfWebRequest $request) {
		$roomData = $this->getTdfRoom($request, sfConfig::get('mod_facebook_tdf_room_associate_name'));
		$this->room_uuid = $roomData['uuid'];
		$this->kupData = $this->getNextRace($request);
		$this->kup_uuid = $this->kupData['uuid'];
	}
	
	/**
	 * Executes homeRanking action to show ranking box on the home page
	 *
	 * @param sfWebRequest $request
	 */
	public function executeHomeRanking(sfWebRequest $request) {
		$this->room_uuid = $request->getParameter('room_uuid', '');
		$this->generalRanking = $this->getAppRanking($request, $this->room_uuid, 0, 1);
		$this->friendsRanking = $this->getAppFacebookRanking($request, $this->room_uuid, 0, 5);
		$this->titleInviteRequest = $this->getContext()->getI18n()->__('text_facebook_tdf_home_ranking_title_invite_request');
		$this->messageInviteRequest = $this->getContext()->getI18n()->__('text_facebook_tdf_home_ranking_message_invite_request');
	}
	
	/**
	 * Home news action.
	 * 
	 * Called with ajax from home page.
	 */
	public function executeHomeNews() {
		$this->rssFeed = RSSParser::parser(sfConfig::get('mod_facebook_tdf_rss_parser_url'));
	}
	
	/**
	 * Home next race action.
	 * 
	 * Called with ajax from home page.
	 */
	public function executeHomeNextRace(sfWebRequest $request) {
		$this->kup_uuid = $request->getParameter('kup_uuid', '');
		$this->room_uuid = $request->getParameter('room_uuid', '');
		$this->kupData = $request->getParameter('kup_data', '');
		
		$this->kupRoundData = '';
		$this->kupRoundsData = $this->getKupRoundsData($request, $this->kup_uuid);
		if ($this->kupRoundsData > 1) {
			foreach ($this->kupRoundsData as $roundData) {
				if ($roundData['status'] == 'SCHEDULED') {
					$this->kupRoundData = $roundData;
					break;
				}
			}
			if($this->kupRoundData == '') {
				$this->kupRoundData = $this->kupRoundsData[0];
			}
		} else {
			$this->kupRoundData = $this->kupRoundsData[0];
		}
	}
	
	/**
	 * Results action.
	 * 
	 * @param sfWebRequest $request
	 */
	public function executeResults(sfWebRequest $request) {
        $roomData = $this->getTdfRoom($request, sfConfig::get('mod_facebook_tdf_room_associate_name'));
        $this->room_uuid = $roomData['uuid'];

        $cacheKey = 'facebook_tdf_results_room_kups';
        $this->roomKups =  sfMemcache::getInstance()->get($cacheKey, array());
        if(empty($this->roomKups)) {
            $this->roomKups = $this->sortKupsDataByDateAndStatusFor(
                $this->getRoomKups($request, array('uuid' => $this->room_uuid)),
                SORT_DESC,
                array(4)
            );
            if(!empty($this->roomKups)) {
                sfMemcache::getInstance()->set($cacheKey, $this->roomKups);
            }
        }
	}

    /**
     * Sort kups data by date and/or status.
     *
     * @param Array $kupsData
     * @param $order (optional) direction of sorting for date and status : SORT_ASC or SORT_DESC.
     * @param Array $statusList (optional) list of status you want to display.
     */
    private function sortKupsDataByDateAndStatusFor($kupsData, $order = SORT_ASC, $statusList = array()) {

        if(!empty($statusList)) {
            $neededKupsList = array();
            foreach($kupsData as $kupData) {
                if(in_array($kupData['status'], $statusList)) {
                    $neededKupsList[] = $kupData;
                }
            }
            $kupsData = $neededKupsList;
        }

        $kupsData = $this->usortByArrayKey($kupsData, array('startDate', 'status'), $order);

        return $kupsData;
    }
	
	/**
	 * Display main ranking page.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeRanking(sfWebRequest $request) {
		$this->room_uuid = $request->getParameter('room_uuid', '');
		$this->batchSize = $request->getParameter('batchSize', 10);
		$this->offset = $request->getParameter('offset', 0);
		$this->selectedTab = $request->getParameter('selectedTab', '1');
		
		if($this->room_uuid == '') {
			$roomData = $this->getTdfRoom($request, sfConfig::get('mod_facebook_tdf_room_associate_name'));
			$this->room_uuid = $roomData['uuid'];
		}
		
		$params = array('uuid' => $this->room_uuid);
		$roomKups = $this->getRoomKups($request, $params);
		$playedKups = array();
		foreach ($roomKups as $roomKup) {
			if ($roomKup['status'] != -1) {
				$playedKups[] = $roomKup;
			}
		}
		$this->kupsData = $this->sortKupsDataFor($playedKups);
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
		$this->batchSize = $request->getParameter('batchSize', 10);
		
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
		$this->batchSize = $request->getParameter('batchSize', 10);
		
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
	 * Returns the Facebook public comments URL for the comments plugin.
	 */
	private function getFacebookCommentsURL() {
		return 'https://apps.facebook.com/'.sfConfig::get('mod_facebook_tdf_canvas_ns').'/ranking/1';
	}
	
	/**
	 * Predictions action.
	 * 
	 * @param sfWebRequest $request
	 */
	public function executePredictions(sfWebRequest $request) {
		
		$this->is_saved = $request->getParameter('is_saved', 0);
		$this->titleInviteRequest = $this->getContext()->getI18n()->__('text_facebook_tdf_home_ranking_title_invite_request');
		$this->messageInviteRequest = $this->getContext()->getI18n()->__('text_facebook_tdf_home_ranking_message_invite_request');
		$this->urlToPublish = 'https://apps.facebook.com/'.sfConfig::get('mod_facebook_tdf_facebook_canvas_ns').'/predictions';
		$this->publishMessage = $this->getContext()->getI18n()->__('text_facebook_tdf_home_ranking_publish_message');
		
		$roomData = $this->getTdfRoom($request, sfConfig::get('mod_facebook_tdf_room_associate_name'));
		$this->room_uuid = $roomData['uuid'];
		$this->kupData = $this->getNextRace($request);
		$this->kup_uuid = $this->kupData['uuid'];
		$roomUIFile = sfConfig::get('mod_facebook_tdf_room_associate_ui', '');
		$this->roomUI = array();
		if($roomUIFile != '') {
			$this->roomUI = $this->getRoomUIFor($roomUIFile);
		}
		$this->publishProperties = $this->getUser()->getAttribute('publishProperties', array(), 'userPredictions');
		
	}
	
	/**
	 * Get the roomData for the associate room and cache it.
	 * 
	 * @param sfWebRequest $request
	 * @param string $roomAssociate
	 * @return array $roomData (the room datas)
	 */
	private function getTdfRoom(sfWebRequest $request, $roomAssociate) {	
		$cacheKey = 'facebook_tdf_room_associate';
		$roomData = sfMemcache::getInstance()->get($cacheKey, array());   
		if(empty($roomData)) {
			$roomData = $this->getRoomByName($request, $roomAssociate);
			sfMemcache::getInstance()->set($cacheKey, $roomData);
		}
		return $roomData;
	}
	
	/**
	 * Rules action.
	 * 
	 * @param sfWebRequest $request
	 */
	public function executeRules(sfWebRequest $request) {
	}
	
	/**
	 * Facebook Like page TDF.
	 * 
	 * @param sfWebRequest $request
	 */
	public function executeLikePage(sfWebRequest $request) {
		
	}
}

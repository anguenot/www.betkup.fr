<?php

/**
 * facebook_rg actions.
 *
 * @package    betkup.fr
 * @subpackage facebook_rg
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class facebook_rgActions extends betkupActions {
	
	/**
	 * Connect players to Facebook.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeFacebookConnect(sfWebRequest $request) {
	
		$app_id = sfConfig::get('mod_facebook_rg_facebook_connect_app_id');
		$app_secret = sfConfig::get('mod_facebook_rg_facebook_connect_app_secret');
		$app_scope = sfConfig::get('mod_facebook_rg_facebook_connect_app_scope');
		$my_url = $request->getUriPrefix().$this->generateUrl('facebook_rg_login_facebook');
	
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
	
			$this->redirect($dialog_url);
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
					$this->redirect(array('module' => 'facebook_rg', 'action' => 'facebookConnect'));
				}
				if ($response['http_code'] == '202') {
					$sofun_member = $response['buffer'];
					BetkupWrapper::_setSofunSession($sofun->getSession(), $this);
					$this->_postLogin($request, $sofun_member);
					$this->joinRoom($request);
					$this->redirect(array('module' => 'facebook_rg', 'action' => 'home'));
				} else {
					$this->redirect(array('module' => 'facebook_rg', 'action' => 'facebookConnect'));
				}
			} else {
				try {
					$response = $sofun->api_POST("/member/register/facebook", $params);
				} catch (SofunApiException $e) {
					error_log($e);
					$this->redirect(array('module' => 'facebook_rg', 'action' => 'facebookConnect'));
				}
				if ($response['http_code'] == '202') {
					$sofun_member = $response['buffer'];
					$this->_postLogin($request, $sofun_member);
					$this->joinRoom($request);
					$this->redirect(array('module' => 'facebook_rg', 'action' => 'home'));
				} else {
					$this->redirect(array('module' => 'facebook_rg', 'action' => 'facebookConnect'));
				}
			}
		} else {
			error_log("The state does not match. You may be a victim of CSRF. Facebook Connect action.");
		}
	
		// Here to avoid Symfony errors.
		$this->setTemplate('home');
	}
	
	/**
	 * Executes home action to show home page
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeHome(sfWebRequest $request) {
		$roomData = $this->getRoomByName($request, sfConfig::get('mod_facebook_rg_room_associate_name'));
		$this->room_uuid = $roomData['uuid'];
		$params = array('uuid' => $this->room_uuid);
		$kupsData = $this->sortKupsDataFor($this->getRoomKups($request, $params));
		$this->kupData = $kupsData[0];
		$this->kup_uuid = $this->kupData['uuid'];
	}
	
	/**
	 * Executes home action to show home page
	 *
	 * @param sfRequest $request A request object
	 */
	public function executePredictions(sfWebRequest $request) {
		
	}
	
	/**
	 * Executes home action to show home page
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeRanking(sfWebRequest $request) {
		
	}
	
	/**
	 * Executes home action to show home page
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeResults(sfWebRequest $request) {
		
	}
	
	/**
	 * Executes home action to show home page
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeRules(sfWebRequest $request) {
		
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
	 * Executes homeNews action to show news box on the home page
	 *
	 * @param sfWebRequest $request
	 */
	public function executeHomeNews(sfWebRequest $request) {
		$this->rssFeed = RSSParser::parser(sfConfig::get('mod_facebook_rg_rss_parser_url'));
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
		$this->titleInviteRequest = $this->getContext()->getI18n()->__('text_facebook_sport24_home_ranking_title_invite_request');
		$this->messageInviteRequest = $this->getContext()->getI18n()->__('text_facebook_sport24_home_ranking_message_invite_request');
	}
	
	public function executeHomeNextChocs(sfWebRequest $request) {
		$this->kup_uuid = $request->getParameter('kup_uuid', '');
		$this->room_uuid = $request->getParameter('room_uuid', '');
		$this->kupData = $request->getParameter('kup_data', '');
		$this->urlLike = $this->getCustomUriPrefix($request).$this->getController()->genUrl(array('module' => 'facebook_rg', 'action' => 'nextChocs'));
	}

	/**
	 * Executes homePromo action to show betkup promo box on the home page
	 *
	 * @param sfWebRequest $request
	 */
	public function executeHomePromo(sfWebRequest $request) {
	}
}

<?php
/** Facebook TDF components.
 *
 * @package    betkup.fr
 * @subpackage facebook_tdf
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: components.class.php 4021 2012-02-29 12:20:34Z jmasmejean $
 */
class facebook_tdfComponents extends betkupComponents {
	
	/**
	 * Header component.
	 * 
	 * @param sfWebRequest $request
	 */
	public function executeHeader(sfWebRequest $request) {
		// By default we have already installed the app and like the page.
		$this->progress = 50;
		if($this->isUserPredictions($request)) {
			$this->progress = 75;
		}
		if($this->isUserComeBack($request)) {
			$this->progress = 100;
		}
	}
	
	/**
	 * Return true if the user has participate to a kup.
	 * 
	 * @param sfWebRequest $request
	 * @return true or false
	 */
	private function isUserPredictions($request) {
		$cacheKey = 'facebook_tdf_is_user_prediction';
		$result = sfMemcache::getInstance()->get($cacheKey, '');   
		if($result == '') {
			$roomData = $this->getRoomByName($request, sfConfig::get('mod_facebook_tdf_room_associate_name'));
			$room_uuid = $roomData['uuid'];
			$params = array('uuid' => $room_uuid);
			$kupsData = $this->getRoomKups($request, $params);
			
			$count = 0;
			foreach($kupsData as $kupData) {
				if($kupData['is_participant'] == 1) {
					$count++;
				}
			}
			if($count >= 1) {
				$result = true;
				sfMemcache::getInstance()->set($cacheKey, $result);
			}
		}
		if($result == '') {
			$result = false;
		}
		return $result;
	}
	
	/**
	 * Return true if the user have participate to more than 1 kup (he's come back).
	 * 
	 * @param sfWebRequest $request
	 * @return boolean
	 */
	private function isUserComeBack($request) {
		$cacheKey = 'facebook_tdf_is_user_comme_back';
		$result = sfMemcache::getInstance()->get($cacheKey, '');   
		if($result == '') {
			$roomData = $this->getRoomByName($request, sfConfig::get('mod_facebook_tdf_room_associate_name'));
			$room_uuid = $roomData['uuid'];
			$params = array('uuid' => $room_uuid);
			$kupsData = $this->getRoomKups($request, $params);
			
			$count = 0;
			foreach($kupsData as $kupData) {
				if($kupData['is_participant'] == 1) {
					$count++;
				}
			}
			if($count >= 2) {
				$result = true;
				sfMemcache::getInstance()->set($cacheKey, $result);
			}
		}
		if($result == '') {
			$result = false;
		}
		return $result;
	}
	
	public function executeFooter() {
		$this->titleInviteRequest = $this->getContext()->getI18n()->__('text_facebook_tdf_home_ranking_title_invite_request');
		$this->messageInviteRequest = $this->getContext()->getI18n()->__('text_facebook_tdf_home_ranking_message_invite_request');
	}
	
	public function executeMenu() {
		
	}
	
	public function executeHomeBoxHowTo() {
		
	}
	
	public function executeHomePromo() {
		
	}
	
	/**
	 * Displays the time to the next race on 'next race' are on home.
	 */
	public function executeChrono() {
		if(!isset($this->chronoId)) {
			$this->chronoId = '00';
		}
	}
	
}
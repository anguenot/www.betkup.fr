<?php
/**
 * Facebook F1 Sport24 components.
 *
 * @package    betkup.fr
 * @subpackage facebook_f1_sport24
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: components.class.php 4021 2012-02-29 12:20:34Z jmasmejean $
 */
class facebook_f1_sport24Components extends sfComponents {

	/**
	 * Displays top header progression area.
	 */
	public function executeHeader() {
		// TODO implement
		$this->progression = 50;
	}

	/**
	 * Displays the common footer
	 */
	public function executeFooter() {
		$this->titleInviteRequest = $this->getContext()->getI18n()->__('text_facebook_sport24_home_ranking_title_invite_request');
		$this->messageInviteRequest = $this->getContext()->getI18n()->__('text_facebook_sport24_home_ranking_message_invite_request');
	}

	/**
	 * Displays the time to the next race on 'next race' are on home.
	 */
	public function executeChrono() {
		if(!isset($this->chronoId)) {
			$this->chronoId = '00';
		}
	}

	/**
	 * Displays header menu visible throughout the application. 
	 */
	public function executeMenu() {
	}

	/**
	 * Displays ranking
	 */
	public function executeRanking() {
		if(!isset($this->module)) {
			$this->module = 'facebook_f1_sport24';
		}
		if(!isset($this->action)) {
			$this->action = 'ranking';
		}
		if(!isset($this->tabActive)) {
			$this->tabActive = '1';
		}
		if(!isset($this->isRoomRanking)) {
			$this->isRoomRanking = false;
		}
	}
}
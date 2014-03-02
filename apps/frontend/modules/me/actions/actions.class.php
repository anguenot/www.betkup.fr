<?php

/**
 * me actions.
 *
 * @package    betkup.fr
 * @subpackage me
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: actions.class.php 4667 2012-05-16 16:41:32Z anguenot $
 */
class meActions extends betkupActions {

	/**
	 * Number of items within the todo list for a free account.
	 *
	 * Used to compute percentage completion.
	 *
	 * @var int
	 */
	private static $TODO_ITEMS_FREE = 6;

	/**
	 * Number of items within the todo list for a free account.
	 *
	 * Used to compute percentage completion.
	 *
	 * @var int
	 */
	private static $TODO_ITEMS_GAMBLING_FR = 8;

	/**
	 * Returns the todo list status for the current authenticated member.
	 *
	 * @param sfWebRequest $request
	 */
	private function getTodoStatus(sfWebRequest $request) {

		$status = array('me_todo_account_created');

		if ($this->totalRooms > 0) {
			array_push($status, 'me_todo_join_room');
		}

		if ($this->totalKups > 0) {
			array_push($status, 'me_todo_kup_participate');
		}

		if ($this->getUser()->getAttribute('facebookId', '', 'subscriber') != '') {
			array_push($status, 'me_todo_facebook_linked');
		}

		if ($this->getUser()->getAttribute('avatar', '', 'subscriber') != '') {
			array_push($status, 'me_todo_photo_added');
		}

		if ($this->getUser()->getAttribute('type', '', 'subscriber') == sfConfig::get("mod_me_account_type_gambling_fr")) {
		    array_push($status, 'me_todo_gambling_account_created');

		    if ($this->getUser()->getAttribute('account_status', '', 'subscriber') == sfConfig::get("mod_me_account_type_gambling_fr_verified")) {
		        array_push($status, 'me_todo_gambling_account_verified');
		    }

		    if ($this->getUser()->getAttribute('credit', '', 'subscriber') > 0) {
		        array_push($status, 'me_todo_gambling_account_credited');
		    }

		}

		return $status;
	}

	/**
	 * Returns the percentage completion of the member todo list depending on its account type.
	 *
	 * @param sfWebRequest $request
	 * @param array $status
	 */
	private function getTodoPercentageCompletion(sfWebRequest $request, $status=array()) {

		$percentage = 0;
		$nb_items = 0;

		$account_type = $this->getUser()->getAttribute('type', '', 'subscriber');
		if ($account_type ==  sfConfig::get('mod_me_account_type_gambling_fr')) {
			$nb_items = meActions::$TODO_ITEMS_GAMBLING_FR;
		} else if ($account_type ==  sfConfig::get('mod_me_account_type_simple')) {
			$nb_items = meActions::$TODO_ITEMS_FREE;
		} // TODO deal with gambling not verified account account type. Possibly other cases.

		if ($nb_items != 0) {
			$percentage = round(100 * (count($status) / $nb_items));
		}

		return $percentage;

	}

	/**
	 * Return the kups list by status
	 *
	 * @param sfRequest $request A request object
	 * @param string $status
	 * @param boolean $isOnlyClosedKups (default : false)
	 */
	private function getKupsByStatus(sfWebRequest $request, $status, $isOnlyClosedKups = false) {

		$request->setParameter('kup_status', $status);

		// Returns Kups for the current logged in member in which member is a participant, depand of the kups status
		// (display ALL_OPENED or ALL_CLOSED kups)
		$params = array(
                'email' => $this->getUser()->getAttribute('email', '', 'subscriber'),
                'status' => $status
		);
		return $this->getKupsData($request, $params);

	}

	/**
	 * Count all Kups by Status
	 *
	 * @param sfRequest $request A request object
	 * @param string $status
	 * @param boolean $isOnlyClosedKups (default : false)
	 */
	private function countKupsByStatus(sfWebRequest $request, $status, $isOnlyClosedKups = false) {

		$request->setParameter('kup_status', $status);

		// Returns Kups for the current logged in member in which member is a participant, depand of the kups status
		// (display ALL_OPENED or ALL_CLOSED kups)
		$params = array(
                    'email' => $this->getUser()->getAttribute('email', '', 'subscriber'),
                    'status' => $status
		);
		// FIXME
		$results = $this->getKupsData($request, $params, true);
		return $results['totalResults'];

	}

	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request) {

		// Get notifications data if new notification is triggered for popup
		$this->notifications = $this->getUser()->getAttribute('notifications', array(), 'subscriber');

		// Set default value to display kups (ALL_OPENED or ALL_CLOSED)
		$kupStatus = sfConfig::get('app_kup_status_all_opened');
		$this->isOnlyClosedKups = false;
		$this->isOnlyOpenKups = false;

		// Returns the total number of Kups for the current logged in member in which member is a participant depend of the kups status.
		$this->kupStatus = $kupStatus;
		$this->totalKups = $this->countKupsByStatus($request, $kupStatus);

		// We test if all kups are opened only.
		$allTotalKups = $this->countKupsByStatus($request, sfConfig::get('app_kup_status_all'));
		if($this->totalKups == $allTotalKups) {
			$this->isOnlyOpenKups = true;
		}

		// Implementation of batching for generic kups when selected status changed
		$this->batchSize = 4;
		$this->nbDisplay = 2;
		$this->nbLine = 2;
		$this->previousOffset = 0;
		$this->currentOffset = 0;
		$this->nextOffset = $this->batchSize;

		// We test if there are closed kup only
		if ($this->totalKups == 0) {
			$this->isOnlyClosedKups = true;
			$this->kupStatus = sfConfig::get('app_kup_status_all');
			$this->totalKups = $allTotalKups;
		}

		// Returns rooms for the current logged in member in which member is an admin or a member.
		$params = array(
        	'email' => $this->getUser()->getAttribute('email', '', 'subscriber')
		);
		$this->totalRooms = $this->countRooms($request, $params);

		// Set member todo status.
		$this->status = $this->getTodoStatus($request);
		$this->percentage = $this->getTodoPercentageCompletion($request, $this->status);
	}

	/**
	 * Execute get total kup action
	 *
	 * @param sfRequest $request A request object
	 *
	 * Usage : This method is an Ajax action, used to get total kups for the selected satus.
	 * There is no template.
	 * ex: Usefull to get total kups when you use the HTML select box to choose the kup status with an Ajax call.
	 */
	public function executeGetTotalKups(sfWebRequest $request) {
		if($request->isXmlHttpRequest()) {
			return $this->renderText($this->countKupsByStatus($request, $request->getParameter('kup_status')));
		} else {
			return false;
		}
	}
}
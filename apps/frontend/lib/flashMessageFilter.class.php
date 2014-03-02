<?php

/**
 * Filter implementing a flash message mecanism in use throughout the application login page.
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 */
class FlashMessageFilter extends sfFilter {

	private static $LOG_KEY = "FlashMessageFilter : ";

	public function execute($filterChain) {
		if ($this->isFirstCall()) {
			$context = $this->getContext();
			$request = $context->getRequest();
			$action = $context->getActionName();
			$module = $context->getModuleName();
			if(in_array($action, $this->getAuthorizedActions())
					&& $request->getMethod() != 'POST'
					&& in_array($this->getModuleAction($request), $this->getAuthorizedRefererModuleAction())) {
				$context->getUser()->setFlash('error', $this->getFlashMessage($request));
			}
		}
		$filterChain->execute();
	}

	/**
	 * Get message to display to the user when he's not logged-in
	 *
	 * @param sfWebRequest $request
	 * @return String
	 */
	private function getFlashMessage(sfWebRequest $request) {
		$moduleAction = $this->getModuleAction($request);
		$message = '';
		$this->getContext()->getLogger()->debug(FlashMessageFilter::$LOG_KEY . "Module/action = ".$moduleAction);
		switch ($moduleAction) {
			case 'kup/results' :
				$message = $this->getContext()->getI18n()->__('flash_error_kup_results_filter_message');
				break;
			case 'room/join' :
				$message = $this->getContext()->getI18n()->__('flash_error_room_join_filter_message');
				break;
			case 'room/create' :
				$message = $this->getContext()->getI18n()->__('flash_error_room_create_filter_message');
				break;
			case 'me/index' :
				$message = $this->getContext()->getI18n()->__('flash_error_me_index_filter_message');
				break;
			case 'room/kup' :
				$message = $this->getContext()->getI18n()->__('flash_error_room_kup_filter_message');
				break;
            case 'room/kupRanking' :
                $message = $this->getContext()->getI18n()->__('flash_error_room_kup_filter_message');
                break;
			default:
				$message = $this->getContext()->getI18n()->__('flash_error_default_filter_message');
				break;
		}
		$this->getContext()->getLogger()->debug(FlashMessageFilter::$LOG_KEY . "Message = ".$message);
		return $message;
	}

	/**
	 * Get the list of alowed referer module/action.
	 *
	 * @return Array containing authorized actions
	 */
	private function getAuthorizedRefererModuleAction() {
		return array(
				'kup/results',
				'room/join',
				'room/create',
				'me/index',
				'room/kup',
                'room/kupRanking');
	}

	/**
	 * Get the list of allowed action.
	 *
	 * @return Array containing authorized actions
	 */
	private function getAuthorizedActions() {
		return array('login');
	}

	/**
	 * Get module/action of the referer to display the appropriate message to the user
	 *
	 * @param sfWebRequest $request
	 * @return string
	 */
	private function getModuleAction(sfWebRequest $request) {
		$moduleAction = '';
		$referer = $request->getRequestParameters();
		$moduleAction = $referer['module'].'/'.$referer['action'];
		return $moduleAction;
	}
	
}

?>
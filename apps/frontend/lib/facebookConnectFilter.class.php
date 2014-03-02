<?php

/**
 * Filter forcing a Facebook connect for players that are not authenticated.
 *
 * Simple accounts can use this aplication since this is a free predictions only application.
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: facebookConnectFilter.class.php 5636 2012-07-12 16:54:26Z jmasmejean $
 */
class sfFacebookConnectFilter extends sfFilter {

	public function execute($filterChain) {
		$action = $this->getContext()->getActionName();
		$module = $this->getContext()->getModuleName();
		$request = $this->getContext()->getRequest();
		
		header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"'); 	
		if ($this->isFirstCall() && $action != 'facebookConnect' && $action != 'likePage') {
			// Check if player is authenticated
			if (!$this->getContext()->getUser()->isAuthenticated()) {
				$this->getContext()->getController()->redirect(
						$this->getContext()->getController()->genUrl(
								array('module' => $module, 'action' => 'facebookConnect')));
			}
		}
		$filterChain->execute();
	}
}

?>
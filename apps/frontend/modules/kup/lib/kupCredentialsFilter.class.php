<?php

/**
 * Betkup Kup's Security Filter.
 *
 * @package    betkup.fr
 * @subpackage kup
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: kupCredentialsFilter.class.php 6471 2012-11-16 14:25:38Z jmasmejean $
 */
class sfKupCredentialsFilter extends sfFilter {

	private static $LOG_KEY = "sfKupCredentialsFilter : ";

	/**
	 * Returns the room UUID.
	 *
	 * The URL pattern is:
	 *
	 *     /room/view/<uuid>
	 *     /room/edit/<uuid>
	 *
	 * @return int or NULL
	 */
	private function getKupUUID() {

		$uuid = $this->getContext()->getRequest()->getParameter("uuid", -1);
		if ($uuid == -1) {
			// Kup within room
			$uuid = $this->getContext()->getRequest()->getParameter("kup_uuid", -1);
		}
		return $uuid;

	}

	public function execute($filterChain) {

		// Execute this filter only once
		if ($this->isFirstCall()) {

			// Code to executed before the action execution

			$context = $this->getContext();
			$request = $context->getRequest();
			$module = $context->getModuleName();

			$uuid = $this->getKupUUID();

			if ($uuid == -1 || $uuid == "me") {
				 
				// We don't need to remove anything here. Next visit in a kup will clear up.
				// Execute next filter in the chain
				$filterChain->execute();
				return;
				 
				$context->getLogger()->debug(sfKupCredentialsFilter::$LOG_KEY . "execute()");

				if ($context->getUser()->isAuthenticated()) {

					// We are not on a kup. Let's remove  credentials.

					$context->getUser()->removeCredential(sfConfig::get('mod_kup_security_betkup_administrator'));
					$context->getUser()->removeCredential(sfConfig::get('mod_kup_security_betkup_member'));
					$context->getUser()->removeCredential(sfConfig::get('mod_kup_security_betkup_participant'));

					$context->getLogger()->debug(sfKupCredentialsFilter::$LOG_KEY . "remove Kup's credentials from session");

				} else {

					$context->getUser()->removeCredential(sfConfig::get('mod_kup_security_betkup_anonymous'));
					$context->getLogger()->debug(sfKupCredentialsFilter::$LOG_KEY . "current session is anonymous in kup's section.");
					
				}

			} else {

				if ($context->getUser()->isAuthenticated())  {

					$email = $context->getUser()->getAttribute('email', '', 'subscriber');
					$context->getLogger()->debug(sfKupCredentialsFilter::$LOG_KEY . "found kup w/ UUID=" . $uuid . " . Checking credentials for member=" . $email);

					$sofun = BetkupWrapper::_getSofunApp($request, $context);
					try {
						$response = $sofun->api_GET("/kup/" . $uuid . "/member/" . $email . "/credentials");
					} catch (SofunApiException $e) {
						error_log($e);
					}

					if ($response['http_code'] == '202') {

						$context->getUser()->removeCredential(sfConfig::get('mod_kup_security_betkup_administrator'));
						$context->getUser()->removeCredential(sfConfig::get('mod_kup_security_betkup_member'));
						$context->getUser()->removeCredential(sfConfig::get('mod_kup_security_betkup_participant'));

						$kupCredentials = $response['buffer'];

                        // If the user is a kup member, we flush the kupData cache for this user to force next call to retrieve true values.
                        $cacheKey = 'kup_data_' . $uuid.'_for_'.$context->getUser()->getAttribute('subscriberId', '', 'subscriber');

						foreach($kupCredentials as $kupCredential) {

							$context->getLogger()->debug(sfKupCredentialsFilter::$LOG_KEY . "found core kup credential=" . $kupCredential . " for member=" . $email);

							if ($kupCredential == sfConfig::get('mod_kup_security_sofun_administrator')) {
								$context->getUser()->addCredential(sfConfig::get('mod_kup_security_betkup_administrator'));
							    sfMemcache::getInstance()->set($cacheKey, array(), 0, 10);
                            }

							if ($kupCredential == sfConfig::get('mod_kup_security_sofun_member')) {
								$context->getUser()->addCredential(sfConfig::get('mod_kup_security_betkup_member'));
                                sfMemcache::getInstance()->set($cacheKey, array(), 0, 10);
                            }

							if ($kupCredential == sfConfig::get('mod_kup_security_sofun_participant')) {
								$context->getUser()->addCredential(sfConfig::get('mod_kup_security_betkup_participant'));
                                sfMemcache::getInstance()->set($cacheKey, array(), 0, 10);
							}

						}

					} else {
						$context->getUser()->addCredential(sfConfig::get('mod_kup_security_betkup_anonymous'));
					}


				} else {

					$context->getLogger()->debug(sfkupCredentialsFilter::$LOG_KEY . "found kup w/ UUID=" . $uuid . ". Allowing access to anonymous");
					$context->getUser()->addCredential(sfConfig::get('mod_kup_security_betkup_anonymous'));

				}

			}

			// Execute next filter in the chain
			$filterChain->execute();

			// Nothing to execute after the action execution, before the rendering

		}

	}

}

?>
<?php

    /**
     * Sofun Credentials Security Filter.
     *
     * Set needed credentials for Room and Room Kup.
     *
     * @package    betkup.fr
     * @subpackage lib
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: roomCredentialsFilter.class.php 2803 2011-09-09 22:57:20Z anguenot $
     */
    class sfRoomCredentialsFilter extends sfFilter {

	private static $LOG_KEY = "sfRoomCredentialsFilter : ";

	/**
	 * Returns the room UUID.
	 *
	 * The URL pattern is:
	 *
	 *     /room/view/<uuid>
	 *     /room/edit/<uuid>
	 *
     * @return int
	 */
	private function getRoomUUID() {

		$uuid = $this->getContext()->getRequest()->getParameter("uuid", -1);
		if ($uuid == -1) {
			// Kup within room
			$uuid = $this->getContext()->getRequest()->getParameter("room_uuid", -1);
		}
		return $uuid;

	}

        /**
         * Set custom credentials if needed.
         *
         * Typically used when we want to set credentials for public gambling Room.
         * And redirect to update account if needed.
         *
         * @param sfWebRequest $request
         * @param string       $roomPrivacy
         * @param int          $room_uuid
         * @param int          $kup_uuid
         */
        private function setCustomCredentials(sfWebRequest $request, $roomPrivacy, $room_uuid, $kup_uuid, array $roomCredentials) {
            $context = $this->getContext();

            $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_connected_public'));
            $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_connected_private'));
            $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_anonymous_public'));
            $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_anonymous_private'));

            // Execute this only if the user is not already a Room member.
            if (!in_array(sfConfig::get('mod_room_security_sofun_member'), $roomCredentials)) {
                $type = 'anonymous';
                if ($context->getUser()->isAuthenticated()) {
                    $type = 'connected';
                }

                if ($roomPrivacy == sfConfig::get('mod_room_privacy_public') || $roomPrivacy == sfConfig::get('mod_room_privacy_public_gambling_fr')) {
                    $context->getUser()->addCredential(sfConfig::get('mod_room_security_betkup_' . $type . '_public'));
                    if ($roomPrivacy == sfConfig::get('mod_room_privacy_public_gambling_fr')) {

                        $context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "Set request parameters for gambling Room... ");

                        $request->setParameter('uuid', $room_uuid);
                        $request->setParameter('kup_uuid', $kup_uuid);
                        $request->setParameter('need_advanced_account', '1');
                        $request->setParameter('redirect_route', 'room_auto_join');
                    }
                    else {
                        $context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "Set request parameters for simple Room... ");

                        $request->setParameter('room_uuid', $room_uuid);
                        $request->setParameter('kup_uuid', $kup_uuid);
                        $request->setParameter('redirect_route', 'room_auto_join');
                    }
                }
                else if ($roomPrivacy == sfConfig::get('mod_room_privacy_private') || $roomPrivacy == sfConfig::get('mod_room_privacy_private_gambling_fr')) {
                    $context->getUser()->addCredential(sfConfig::get('mod_room_security_betkup_' . $type . '_private'));
                }
            }

        }

        /**
         * Return the kup uuid if exist or return -1.
         *
         * @return int
         */
	private function getKupUUID() {
		return $this->getContext()->getRequest()->getParameter("kup_uuid", -1);
	}

        /**
         * Execute the filter.
         *
         * @param $filterChain
         */
	public function execute($filterChain) {

		// Execute this filter only once
		if ($this->isFirstCall()) {

			// Code to executed before the action execution
			$context = $this->getContext();
			$request = $context->getRequest();
			$module = $context->getModuleName();

			$uuid = $this->getRoomUUID();

                $roomCredentials = array();
                $roomPrivacy = '';

			if ($uuid == -1 || $uuid == 'me') {

				// We don't need to remove anything here. Next visit in a room will clear up.
				// Execute next filter in the chain
				$filterChain->execute();
				return;

                    /*
                    $context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "execute()");

                    if ($context->getUser()->isAuthenticated()) {

                        // We are not on a Room. Let's remove  credentials.
                        $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_administrator'));
                        $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_member'));
                        $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_participant'));

                        $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_connected_public'));
                        $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_connected_private'));
                        $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_anonymous_public'));
                        $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_anonymous_private'));

                        $context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "remove Room's credentials from session");

                    }
                    else {
                        $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_anonymous'));
                        $context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "current session is anonymous in room's section.");
                    }
                    */
                }
                else {

                    // Get the room privacy and room credentials for the user.
                    $email = $context->getUser()->getAttribute('email', '0', 'subscriber');
					$context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "found room w/ UUID=" . $uuid . " . Checking credentials for member=" . $email);

                    $cacheKey = 'room_credentials_and_privacy_for_' . str_replace(array(
                                                                                       '-', '.', '@'
                                                                                  ), '_', $email) . '_' . $uuid;
                    $response = sfMemcache::getInstance()->get($cacheKey, array());
                    if (empty($response)) {
					$sofun = BetkupWrapper::_getSofunApp($request, $context);
					try {
                            $response = $sofun->api_GET("/team/" . $uuid . "/member/" . $email . "/security");
					} catch (SofunApiException $e) {
						error_log($e);
					}
                        if (!empty($response) && $response['http_code'] == 202) {
                            sfMemcache::getInstance()->set($cacheKey, $response, 0, 0);
                        }
                        $context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "Get credentials and privacy for Room : " . $uuid);

                    }

                    if (isset($response['buffer']) && count($response['buffer']) > 0) {
                        foreach ($response['buffer'] as $i => $buffer) {
                            if ($i == 0) {
                                $roomPrivacy = $buffer;
                            }
                            else {
                                $roomCredentials[] = $buffer;
                            }
                        }
                    }

                    if ($context->getUser()->isAuthenticated()) {

					if ($response['http_code'] == '202') {

						$context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_administrator'));
						$context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_member'));
						$context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_participant'));

                            $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_connected_public'));
                            $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_connected_private'));
                            $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_anonymous_public'));
                            $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_anonymous_private'));

                            if (count($roomCredentials) > 0) {
						foreach($roomCredentials as $roomCredential) {

							$context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "found core room credential=" . $roomCredential . " for member=" . $email);

							if ($roomCredential == sfConfig::get('mod_room_security_sofun_administrator')) {
								$context->getUser()->addCredential(sfConfig::get('mod_room_security_betkup_administrator'));
								$context->getUser()->addCredential(sfConfig::get('mod_room_security_betkup_member'));
							}

							if ($roomCredential == sfConfig::get('mod_room_security_sofun_member')) {
								$context->getUser()->addCredential(sfConfig::get('mod_room_security_betkup_member'));
							}

							if ($roomCredential == sfConfig::get('mod_room_security_sofun_participant')) {
								$context->getUser()->addCredential(sfConfig::get('mod_room_security_betkup_participant'));
							}
						}
                            }
                        }
                        else {
						$context->getUser()->addCredential(sfConfig::get('mod_room_security_betkup_anonymous'));
						error_log($response['buffer']);
					}

                    }
                    else {
					$context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "found room w/ UUID=" . $uuid . ". Allowing access to anonymous");
					$context->getUser()->addCredential(sfConfig::get('mod_room_security_betkup_anonymous'));

				}

			}

			$kup_uuid = $this->getKupUUID();

			if ($kup_uuid == -1 || $kup_uuid == 'me') {

				// We don't need to remove anything here. Next visit in a room will clear up.
				// Execute next filter in the chain
				$filterChain->execute();
				return;

                    /*
                    if ($context->getUser()->isAuthenticated()) {

                        // We are not on a kup. Let's remove  credentials.

                        $context->getUser()->removeCredential(sfConfig::get('mod_room_kup_security_betkup_administrator'));
                        $context->getUser()->removeCredential(sfConfig::get('mod_room_kup_security_betkup_member'));
                        $context->getUser()->removeCredential(sfConfig::get('mod_room_kup_security_betkup_participant'));

                        $context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "remove Kup's credentials from session");

                    } else {

                        $context->getUser()->removeCredential(sfConfig::get('mod_room_kup_security_betkup_anonymous'));
                        $context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "current session is anonymous in kup's section.");
                    }
                    */
                }
                else {
				if ($context->getUser()->isAuthenticated())  {

					$email = $context->getUser()->getAttribute('email', '', 'subscriber');
					$context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "found kup w/ UUID=" . $kup_uuid . " . Checking credentials for member=" . $email);

					$sofun = BetkupWrapper::_getSofunApp($request, $context);
					try {
						$response = $sofun->api_GET("/kup/" . $kup_uuid . "/member/" . $email . "/credentials");
					} catch (SofunApiException $e) {
						error_log($e);
					}

					if ($response['http_code'] == '202') {

						$context->getUser()->removeCredential(sfConfig::get('mod_room_kup_security_betkup_administrator'));
						$context->getUser()->removeCredential(sfConfig::get('mod_room_kup_security_betkup_member'));
						$context->getUser()->removeCredential(sfConfig::get('mod_room_kup_security_betkup_participant'));

                        $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_connected_public'));
                        $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_connected_private'));
                        $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_anonymous_public'));
                        $context->getUser()->removeCredential(sfConfig::get('mod_room_security_betkup_anonymous_private'));

						$kupCredentials = $response['buffer'];

                        // If the user is a kup member, we flush the kupData cache for this user to force next call to retrieve true values.
                        $cacheKey = 'kup_data_' . $kup_uuid . '_for_' . $context->getUser()->getAttribute('subscriberId', '', 'subscriber');

						foreach($kupCredentials as $kupCredential) {

							$context->getLogger()->debug(sfRoomCredentialsFilter::$LOG_KEY . "found core kup credential=" . $kupCredential . " for member=" . $email);

							if ($kupCredential == sfConfig::get('mod_room_kup_security_sofun_administrator')) {
								$context->getUser()->addCredential(sfConfig::get('mod_room_kup_security_betkup_administrator'));
                                sfMemcache::getInstance()->set($cacheKey, array(), 0, 1);
                            }

							if ($kupCredential == sfConfig::get('mod_room_kup_security_sofun_member')) {
								$context->getUser()->addCredential(sfConfig::get('mod_room_kup_security_betkup_member'));
                                sfMemcache::getInstance()->set($cacheKey, array(), 0, 1);
                            }

							if ($kupCredential == sfConfig::get('mod_room_kup_security_sofun_participant')) {
								$context->getUser()->addCredential(sfConfig::get('mod_room_kup_security_betkup_participant'));
                                sfMemcache::getInstance()->set($cacheKey, array(), 0, 1);
                            }
						}

                        $this->setCustomCredentials($request, $roomPrivacy, $uuid, $kup_uuid, $roomCredentials);
                    }
                    else {
                        $this->setCustomCredentials($request, $roomPrivacy, $uuid, $kup_uuid, $roomCredentials);
                        $context->getUser()->addCredential(sfConfig::get('mod_room_kup_security_betkup_anonymous'));
                    }
				}
                    else {
                        $this->setCustomCredentials($request, $roomPrivacy, $uuid, $kup_uuid, $roomCredentials);
                        $context->getUser()->addCredential(sfConfig::get('mod_room_kup_security_betkup_anonymous'));
			}
                }
			// Execute next filter in the chain
			$filterChain->execute();

			// Nothing to execute after the action execution, before the rendering
		}
	}
    }

?>
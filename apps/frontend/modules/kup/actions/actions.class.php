<?php

/**
 * Kup actions.
 *
 * <p/>
 *
 * See config/security.yml for module security settings. All actions needs to be
 * protected unless necessary.
 *
 * <p/>
 *
 * This module does not and shall not contain any admin related actions: only
 * member related account management actions.
 *
 * @package    betkup.fr
 * @subpackage kup
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: actions.class.php 6411 2012-11-05 15:54:47Z jmasmejean $
 */
class kupActions extends betkupActions {

	/**
	 * Default Kup action.
	 *
	 * Redirects to /kup/home.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeIndex(sfWebRequest $request) {
		$this->redirect(array('module' => 'kup', 'action' => 'home'));
	}

	/**
	 * Display rules tab within a Kup.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeRules(sfWebRequest $request) {

		$this->uuid = $request->getParameter('uuid');
		$this->setTabs($request, $this->uuid);
		$this->module = $request->getParameter('module');

		// Get Kup's data given its uuid.
		$this->kupData = $this->getKupData($request, $this->uuid);

        //SEO, make title and description dynamic.
        $this->setTitleDescriptionSEOFor("kups", "rules", $this->kupData);

	}

	/**
	 * Display results tab within a Kup
	 *
	 * @param sfWebRequest $request
	 */
	public function executeResults(sfWebRequest $request) {

		$this->uuid = $request->getParameter('uuid', '');

		if ($this->uuid == '') {
			$this->redirect (array ('module' => 'kup', 'action' => 'home'));
		}
		// Get Kup's data given its uuid.
		$this->kupData = $this->getKupData($request, $this->uuid);

        //SEO, make title and description dynamic.
        $this->setTitleDescriptionSEOFor("kups", "results", $this->kupData);

		$this->setTabs($request, $this->uuid);
		$this->setResultsViewTemplate($this->kupData);
	}

	/**
	 * Display ranking view within a Kup
	 *
	 * @param sfWebRequest $request
	 */
	public function executeRanking(sfWebRequest $request) {

		$this->uuid = $request->getParameter('uuid', '');
		if ($this->uuid == '') {
			$this->redirect (array ('module' => 'kup', 'action' => 'home'));
		}
		
		$this->offset = $request->getParameter('offset', 0);
		$this->batch = $request->getParameter('batchSize', 10);
		$this->urlForFacebook = $this->getCustomUriPrefix($request).$this->getController()->genUrl(array('module' => 'kup', 'action' => 'ranking', 'uuid' => $this->uuid));		
		$this->setTabs($request, $this->uuid);
		
		$this->kupData = $this->getKupData($request, $this->uuid);
		if ($this->kupData['repartition'] == 4) {
			$this->kupData['nbWinners'] = 10;
		} else {
			$this->kupData['nbWinners'] = $this->kupData['repartition'];
		}

        //SEO, make title and description dynamic.
        $this->setTitleDescriptionSEOFor("kups", "ranking", $this->kupData);

		$this->kupsRankingData = array();
		$this->memberPosition = 0;
		$this->nbPlayers = 0;
		$this->userRanking = array();
		
		$ranking = $this->getKupRanking($request, $this->uuid, $this->offset, $this->batch);
		if (isset($ranking['entries'])) {
			$offset = 0;
			foreach($ranking['entries'] as $entry) {
				$this->kupsRankingData[$offset] = $entry;
				$member = $entry['member'];
				$this->kupsRankingData[$offset]['member']['nickName'] = Util::getNicknameFor($member);

                $avatar = util::getAvatarForUser($member['avatarSmall']);
                $this->kupsRankingData[$offset]['member']['avatarSmall'] = $avatar;
                $avatar = util::getAvatarForUser($member['avatarBig']);
                $this->kupsRankingData[$offset]['member']['avatarBig'] = $avatar;

				if($this->getUser()->isAuthenticated() && $this->getUser()->getAttribute('email', '', 'subscriber') == $member['email']) {
					$this->userRanking = $entry;
				}
				
				$offset++;
			}
			$this->memberPosition = $ranking['memberPosition'];
			$this->nbPlayers = $ranking['totalMembers'];
			unset($ranking);
		}

		
	}

	/**
	 * Display view when user is about to place a Bet.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeBet(sfWebRequest $request) {

		$this->uuid = $request->getParameter('uuid');
        $this->hasPreds = $request->getParameter('hasPreds', '');
		$this->setTabs($request, $this->uuid);

		// Get Kup's data given its uuid.
		$this->kupData = $this->getKupData($request, $this->uuid);

		// If Kup is closed or cancelled redirect to ranking
		if ($this->kupData['status'] >= 3 || $this->kupData['status'] == -1) {
			$this->redirect (array ('module' => 'kup', 'action' => 'ranking', 'uuid' => $this->uuid));
		}

		// If no predictions, redirects to prediction page
		if($this->hasPreds != "1" && $this->kupData['hasPredictions'] != "1") {
			$this->redirect(array('module' => 'kup',  'action' => 'view','uuid' => $this->uuid));
		}

		// Redirect to step 3 (invite friend) when the kup is free
		if($this->kupData['type'] == sfConfig::get('mod_kup_type_free')) {
			$this->redirect ('kup_bet_invite_step3', array ('uuid' => $this->uuid));
		} else if($this->kupData['type'] == sfConfig::get('mod_kup_type_gambling_fr') && $this->kupData['is_participant'] == '1') {
			$this->redirect ('kup_bet_invite_step3', array ('uuid' => $this->uuid));
		}

		$this->_bet($request, $this->uuid, 0, $this->kupData);
	}



	/**
	 * Display the invite friend module - kup -> bet  stake flow step 3
	 *
	 * @param sfWebRequest $request
	 */
	public function executeInviteFriends(sfWebRequest $request) {

		// When the user is within a prediction flow no tab is to be shown.
		if($request->getParameter('tabInvite') != '') {
			$this->notInFlow = $request->getParameter('tabInvite', 0);
		}

		if($request->getParameter('uuid') != '') {
			$this->kupUuid = $request->getParameter('uuid', 0);
		}
		$this->kupData = $this->getKupData($request, $this->kupUuid);

        //SEO, make title and description dynamic.
        $this->setTitleDescriptionSEOFor("kups", "invite", $this->kupData);

		$this->urlShareFacebook = $this->getCustomUriPrefix($request).$this->getController()->genUrl(array('module' => 'kup', 'action' => 'view', 'uuid' => $this->kupUuid));
		$this->publishMsg = $this->getPublishFacebookMessageFor($this->kupData);
		$this->publishProperties = json_encode($this->getFacebookPublishMessageFor($request, $this->kupData));

		$this->setTabs($request, $this->kupUuid);
	}


	/**
	 * Display Kup's default view.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeView(sfWebRequest $request) {

		$this->uuid = $request->getParameter('uuid', '');
		if ($this->uuid == '') {
			$this->redirect (array ('module' => 'kup', 'action' => 'home'));
		}
		$this->kupData = $this->getKupData($request, $this->uuid);

        //SEO, make title and description dynamic.
        $this->setTitleDescriptionSEOFor("kups", "predictions", $this->kupData);

        // If we get the comming_from parameter that comming from home page, we redirect to ranking
		if($request->getParameter('comming_from', '') == 'home') {
			if($this->kupData['status'] == 4 || $this->kupData['status'] == 5 || $this->kupData['status'] == -1) {
				$this->redirect (array ('module' => 'kup', 'action' => 'ranking', 'uuid' => $this->uuid));
			}
		}
		$this->setTabs($request, $this->uuid);
		$this->setPredictionsViewTemplate($this->kupData);

        // If there are draft predictions, delete them if the user wat to.
        if($request->isMethod('get')) {
            $empty_draft = $request->getParameter('empty_draft', 0);
            if($empty_draft) {
                $this->getUser()->getAttributeHolder()->removeNamespace('predictionsSave');
            }
        }

		// Forward to login if the user is'nt connected.
		if ($request->isMethod ('post')) {
            $this->saveDraftPredictions($request, $this->uuid);
			if (!$this->getUser()->isAuthenticated()) {

				$this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_failed_must_login'));
				$this->forward('account', 'login');
			}
		}
	}

	/**
	 * Sets tabs data showing up while viewing a Kup.
	 *
	 * @param sfWebRequest $request
	 * @param int $uuid
	 */
	private function setTabs(sfWebRequest $request, $uuid) {

		$this->tab = $request->getParameter('action');

		$this->dataTabs = array(

				'tab1' => array(
						'id' => '1',
						'name' => 'predictions',
						'libelle' => $this->getContext()->getI18n ()->__('label_tab_kup_prediction'),
						'link' => array('module' => 'kup', 'action' => 'view', 'uuid' => $uuid),
		),
				'tab2' => array(
						'id' => '2',
						'name' => 'ranking',
						'libelle' => $this->getContext()->getI18n ()->__('label_tab_kup_ranking'),
						'link' => array('module' => 'kup', 'action' => 'ranking', 'uuid' => $uuid),
		),
				'tab3' => array(
						'id' => '3',
						'name' => 'results',
						'libelle' => $this->getContext()->getI18n ()->__('label_tab_kup_results'),
						'link' => array('module' => 'kup', 'action' => 'results', 'uuid' => $uuid),
		),
				'tab4' => array(
						'id' => '4',
						'name' => 'rules',
						'libelle' => $this->getContext()->getI18n ()->__('label_tab_kup_rules'),
						'link' => array('module' => 'kup', 'action' => 'rules', 'uuid' => $uuid),
		),

				'tab5' => array(
						'id' => '5',
						'name' => 'invite',
						'libelle' => $this->getContext()->getI18n ()->__('label_tab_kup_invite'),
						'link' => array('module' => 'kup', 'action' => 'inviteFriends', 'uuid' => $uuid, 'tabInvite' => '1'),
		),
		);

	}

	/**
	 * Order the front Kups.
	 */
	private function sortFrontKups($kups) {

		$ordered = array();
		$names = $this->getFrontKupNames();

		// Configuration issue.
		if (count($names) != count($kups)) {
			error_log("Issue ordering kups on front page. Check kup/module.yml");
			return $kups;
		}

		$offset = 0;
		$iteration = 0;
		while ((count($ordered) < count($kups)) && $iteration <= count($kups)) {
			foreach ($names as $name) {
				foreach ($kups as $kup) {
					if ($kup['name'] == $this->getContext()->getI18n()->__($name)) {
						$ordered[$offset] = $kup;
						$offset +=1 ;
						break;
					}
				}
			}
			$iteration++;
		}

		if (count($ordered) < count($kups)) {
			error_log("Issue ordering kups on front page. Check kup/module.yml");
			$ordered = $kup;
		}

		return $ordered;

	}

	/**
	 * Kups home page.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeHome(sfWebRequest $request) {
	}

	/**
	 * Returns the search engine parameter for Kup's status depending on what the user selected.
	 *
	 * @param sfWebRequest $request
	 */
	private function getQuerySearchStatusFor(sfWebRequest $request) {
		$default = '';
		$extracted = $request->getParameter(sfConfig::get('app_kup_search_params_status'), '');
		if ($extracted == '') {
			return $default;
		}
		if (isset($extracted[sfConfig::get('app_kup_status_all')])
		&& $extracted[sfConfig::get('app_kup_status_all')] == 1) {
			return 'ALL';
		}
		if (isset($extracted['IN_PROGRESS'])
		&& $extracted['IN_PROGRESS'] == 1) {
			if (isset($extracted['IN_COMMING'])
			&& $extracted['IN_COMMING'] == 1) {
				if (isset($extracted['CLOSED'])
				&& $extracted['CLOSED'] == 1) {
					return 'ALL';
				} else {
					return 'ALL_OPENED';
				}
			} else if (isset($extracted['CLOSED'])
			&& $extracted['CLOSED'] == 1) {
				return 'ALL';
			} else {
				return 'ON_GOING';
			}
		}
		if (isset($extracted['IN_COMMING'])
		&& $extracted['IN_COMMING'] == 1) {
			return 'OPENED';
		}
		if (isset($extracted['CLOSED'])
		&& $extracted['CLOSED'] == 1) {
			return 'ALL_CLOSED';
		}
		return $default;
	}

	/**
	 * Returns the search engine parameter for Kup's stake depending on what the user selected.
	 *
	 * @param sfWebRequest $request
	 */
	private function getQuerySearchStakeFor(sfWebRequest $request) {
		$default = '';
		$extracted = $request->getParameter(sfConfig::get('app_kup_search_params_stake'), '');
		if (isset($extracted['ALL'])
		&& $extracted['ALL'] == 1) {
			return 'ALL';
		}
		if (isset($extracted['FREE'])
		&& $extracted['FREE'] == 1) {
			if (isset($extracted['FREEROLLS'])
			&& $extracted['FREEROLLS'] == 1) {
				if (isset($extracted['PAYABLE'])
				&& $extracted['PAYABLE'] == 1) {
					return 'ALL';
				} else {
					return 'FREE_FREEROLL';
				}
			}
			if (isset($extracted['PAYABLE'])
			&& $extracted['PAYABLE'] == 1) {
				return 'ALL';
			} else {
				return 'FREE';
			}
		}
		if (isset($extracted['FREEROLLS'])
		&& $extracted['FREEROLLS'] == 1) {
			if (isset($extracted['PAYABLE'])
			&& $extracted['PAYABLE'] == 1) {
				return 'ALL_GAMBLING';
			} else {
				return 'FREEROLL';
			}
		}
		if (isset($extracted['PAYABLE'])
		&& $extracted['PAYABLE'] == 1) {
			return 'GAMBLING';
		}
		return $default;
	}

	/**
	 * Returns the search engine parameter sorting kups depending on what the
	 * user selected.
	 *
	 * @param sfWebRequest $request
	 */
	private function getQuerySearchSortFor(sfWebRequest $request) {
		$extracted = $request->getParameter(sfConfig::get('app_kup_search_params_sorting'), '');
		if ($extracted == '') {
			return '';
		}
		$query = '';
		foreach ($extracted as $key => $value) {
			if ($value == 1) {
				if ($query == '') {
					$query = $query . $key;
				} else {
					$query = $query . "#" . $key;
				}
			}
		}
		return $query;
	}

	/**
	 * Returns the search engine parameter sorting kups depending on what the
	 * user selected.
	 *
	 * @param sfWebRequest $request
	 */
	private function getQuerySearchSportsFor(sfWebRequest $request) {
		$extracted = $request->getParameter(sfConfig::get('app_kup_search_params_sports'), '');
		if ($extracted == '') {
			return '';
		}
		$query = '';
		foreach ($extracted as $key => $value) {
			if ($value == 1) {
				if ($query == '') {
					$query = $query . $key;
				} else {
					$query = $query . "#" . $key;
				}
			}
		}
		return $query;
	}

	/**
	 * Searching.... Kups & Destroy! Yeah yeah.
	 *
	 * @param sfWebRequest $request
	 */
	public function executeKupsThumbnailsSearch(sfWebRequest $request) {

		if($request->isXmlHttpRequest()) {

			$this->offset = $request->getParameter('offset', 0);
			$this->batchSize = $request->getParameter('batchSize', 10);

			$this->sports = $this->getQuerySearchSportsFor($request);
			$this->stake = $this->getQuerySearchStakeFor($request);
			$this->status = $this->getQuerySearchStatusFor($request);
			$this->sorting = $this->getQuerySearchSortFor($request);
			$this->more = $request->getParameter(sfConfig::get('app_kup_search_params_other'), array());

            $params = array(
                'sports' => $this->sports,
                'stake' => $this->stake,
                'status' => $this->status,
                'sort' => $this->sorting,
                'offset' => $this->offset,
                'batchSize' => $this->batchSize,
                'withRoomKups' => isset($this->more['withRoomKups']) && $this->more['withRoomKups'] == 1 ? 1 : 0,
            );

            // Save the search filter for current user even anonymous.
            $searchParams = $this->getFormatedSearchFilter($request);
            $this->getUser()->setAttribute('selectedDatas', $searchParams, 'searchKupsHolder');
            $this->getUser()->setAttribute('offset', $this->offset, 'searchKupsHolder');

			if (isset($this->more['removeValidatedfor']) && $this->more['removeValidatedfor'] == 1) {
 				$params['removeValidatedfor'] =  $this->getUser()->getAttribute('email', '', 'subscriber');
			}
			$results = $this->getKupsData($request, $params, true);
            $this->kupsData  = $results['results'];
            $this->totalKups = $results['totalResults'];
            $this->pagerSize = round($this->totalKups / $this->batchSize);

            // It's possible (rare) that the offset is out of date and it's asking for a page who's not existing anymore.
            // In this case, we reset the offset to 0 and we get kupsData from API again.
            if($this->offset > $this->totalKups) {
                $params['offset'] = 0;
                $this->getUser()->setAttribute('offset', 0, 'searchKupsHolder');
                $results = $this->getKupsData($request, $params, true);
                $this->kupsData  = $results['results'];
                $this->totalKups = $results['totalResults'];
                $this->pagerSize = round($this->totalKups / $this->batchSize);
            }
		}

	}

    /**
     * Get the filter from $request and format it to a exploitable array.
     *
     * Typicaly useful for save filter into user object.
     *
     * @param $request
     *
     * @return array
     */
     private function getFormatedSearchFilter($request) {

        $prefixesList = array(
            sfConfig::get('app_kup_search_params_sports'),
            sfConfig::get('app_kup_search_params_stake'),
            sfConfig::get('app_kup_search_params_status'),
            sfConfig::get('app_kup_search_params_sorting'),
            sfConfig::get('app_kup_search_params_other')
        );

        $searchParams = array();
        foreach($prefixesList as $prefixes) {
            if($request->getParameter($prefixes, '') != '') {
                foreach($request->getParameter($prefixes, '') as $param => $value) {

                    if($value == 1) {
                        $searchParams[] = $prefixes . '_' . $param;
                    }
                }
            }
        }

        return $searchParams;
    }

	/**
	 * Retrieve Kups and sort them into an array
	 *
	 * @param sfWebRequest $request
	 * @param Array $params
	 * @param Int $nbLine
	 * @param Int $nbDisplay
	 */
	private function formatRetrieveKupsData($batchedKups, $nbLine, $nbDisplay) {

		$displayKup = array();
        $countKups = ceil(count($batchedKups));
		for ($a=1; $a <= $nbLine; $a++) {
            if($a <= $countKups) {
                $displayKup[$a-1] = array();
            }
		}

		$j=0;
		$i=0;
		foreach($batchedKups as $kups) {
			array_push($displayKup[$i], $kups);
			$j++;
			// If we get the number of kups we want to be displayed we increment the array key
			if($j == $nbDisplay) {
                $j=0;
				$i++;
			}
		}

		return $displayKup;
	}


	/**
	 * Get paged Kups
	 *
	 * @param sfWebRequest $request
	 */
	public function executeKupsThumbnails(sfWebRequest $request) {

		if ($request->isXmlHttpRequest()) {

			$this->parentModule = $request->getParameter('module_parent', 0);
			$this->uuid = $request->getParameter('uuid', '');
			$kupStatus = $request->getParameter('kup_status', sfConfig::get('app_kup_status_all_opened'));
			$this->nbLine = $request->getParameter('nbLine', "1");
			$this->roomUI = $request->getParameter('roomUI', array());
			$this->nbDisplay = $request->getParameter('nbDisplay', "2");
			$this->isInsideRoom = $request->getParameter('is_inside_room', 0);

			$offset = $request->getParameter('offset');
			$batchSize = $request->getParameter('batchSize');

			$this->kupsData = array();

			// We build an array that will correspond to the top and bottom line of the display.
			// (ex: if we want 4 Kups, there will be 2 line of 2 kups, one in the top and one in bottom of container)

			if ($this->uuid == 'me') {

				// Dashboard case (My Betkup)

				$params = array(
						'email' => $this->getUser()->getAttribute('email', '', 'subscriber'),
						'status' => $kupStatus,
						'offset' => $offset,
						'batchSize' => $batchSize
				);
				$batchedKups = $this->getKupsData($request, $params);
				$this->kupsData = $this->formatRetrieveKupsData($batchedKups, $this->nbLine, $this->nbDisplay);

			} else {
				// Kups' Room's case.
				$params = array(
						'offset' => $offset,
						'batchSize' => $batchSize,
						'uuid' => $this->uuid
				);

				$batchedKups = $this->getRoomKups($request, $params);
				$this->kupsData = $this->formatRetrieveKupsData($batchedKups, $this->nbLine, $this->nbDisplay);

            }
		}
	}
}
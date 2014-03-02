<?php

/**
 * Soccer actions.
 *
 * @package    betkup.fr
 * @subpackage soccer
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: actions.class.php 5524 2012-07-01 21:52:00Z anguenot $
 */
class soccerActions extends betkupActions {

	/**
	 * Is the current user logged in?
	 *
	 * <p>
	 *
	 * Helper for AJAX code.
	 *
	 * @return string true | false
	 */
	public function executeIsUserConnected() {
		if($this->getUser()->isAuthenticated()) {
			return $this->renderText('true');
		} else {
			return $this->renderText('false');
		}
	}

	/**
	 * Euro 2012 full prono groups predictions.
	 *
	 * <p>
	 *
	 * Dedicated prediction's page.
	 *
	 * <p>
	 *
	 * https://www.betkup.fr/kup/20120001/view
	 *
	 * @param sfWebRequest $request
	 */
	public function executeEuro2012FullPredictionsGroup(sfWebRequest $request) {

		$this->kupRoundsData = $request->getParameter('kup_rounds_data', '');
		$this->kup_uuid = $request->getParameter('kup_uuid', '');
		$this->predictions_ic = $request->getParameter('predictions_ic', array());
		$this->kupData = $request->getParameter('kupData', array());
		
		$this->kupGamesData = array();
		foreach($this->kupRoundsData as $round) {
			$this->kupGamesData[$round['name']] = $this->getKupGamesData($request, $this->kup_uuid, $round['uuid'], false, '');
		}
		
		$this->hideButtons = false;
		$this->isActive = true;
		if(isset($this->kupData) && $this->kupData['status'] != 1) {	
			$this->hideButtons = true;
			$this->isActive = false;
		}
	}

	/**
	 * Euro 2012 full prono final stages predictions.
	 *
	 * <p>
	 *
	 * Dedicated prediction's page.
	 *
	 * https://www.betkup.fr/kup/20120001/view
	 *
	 * <p>
	 *
	 * @param sfWebRequest $request
	 */
	public function executeEuro2012FullPredictionsFinal(sfWebRequest $request) {

		$this->kup_uuid = $request->getParameter('kup_uuid', '-1');
		$this->kupData = $request->getParameter('kupData', array());

		$this->kupRoundsData = $request->getParameter('kup_rounds_data', '');
		if (empty($this->kupRoundData)) {
			$this->kupRoundsData = $this->getKupRoundsData($request, $this->kup_uuid);
		}

		$this->kupGamesData = $request->getParameter('kup_games_data', array());
		if (empty($this->kupGamesData)) {
			$this->kupGamesData = array();
			foreach($this->kupRoundsData as $round) {
				$this->kupGamesData[$round['name']] = $this->getKupGamesData($request, $this->kup_uuid, $round['uuid'], false, '');
			}
		}

		$this->predictions_ic = $request->getParameter('predictions_ic', array());
		$predictionsCleanUp = array();
		if(count($this->predictions_ic) > 0) {
			foreach ($this->predictions_ic as $key => $prediction) {
				$cleanKey = str_replace(array('predictions_ic[', ']'), '', $key);
				$predictionsCleanUp[$cleanKey] = $prediction;
			}
		}
		$this->predictions_ic = $predictionsCleanUp;
		if (empty($this->predictions_ic) && $this->getUser()->isAuthenticated()) {
			$this->predictions_ic = $this->getPredictions($request, $this->kup_uuid, 'ic');
			$this->predictions_ic = $this->predictions_ic[0];
		}
		
		if ($request->isMethod('post')) {
			
			// Stores predictions in user's session. Used to display publish messages and possibly for offline users.
			$this->getUser()->setAttribute('predictions_ic', $this->predictions_ic, 'predictionsSave');
			if ($this->getUser()->isAuthenticated()) {
				// Saving group predictions.
				$this->savePredictions($request, $this->kup_uuid, $this->predictions_ic);
				// Reset final' predictions as some modification's occured.
				$sofun = BetkupWrapper::_getSofunApp($request, $this);
				$params = array(
					'communityId' => sfConfig::get('app_sofun_community_id'),
					'type' => sfConfig::get('mod_soccer_prediction_type_final_stage'),
				sfConfig::get('mod_soccer_prediction_type_final_stage') => array(null,null,null,null,null,null,null,null),
					'seasonUUID' => sfConfig::get('mod_soccer_season_uuid'),
				);
				try {
					$email = $this->getUser()->getAttribute('email', '', 'subscriber');
					$response = $sofun->api_POST("/kup/" . $this->kup_uuid . "/member/" . $email . "/predictions/add", $params);
				} catch (SofunApiException $e) {
					error_log($e);
				}
				if ($response["http_code"] != "202") {
					error_log($response['buffer']);
				}
			} else {
				$this->getUser()->setFlash ('error', $this->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_failed_must_login'));
				$this->forward('account', 'login');
			}
		}
		$corePredictions = array();
		if ($this->getUser()->isAuthenticated()) {
			$corePredictions = $this->getPredictions($request, $this->kup_uuid, sfConfig::get('mod_soccer_prediction_type_final_stage'));
		}
		$this->predictions_full = array ();
		$offset = 0;
		foreach ($corePredictions as $teamUUID) {
			$team = array();
			if ($teamUUID != '') {
				$team = $this->getCoreSportTeamByUUID($request, $teamUUID);
			}
			if (count($team) > 0) {
				$team['avatar'] = '/image/default/rugby/teams/' . $teamUUID . '.png';
				$this->predictions_full[$offset] = $team;
			} else {
				$this->predictions_full[$offset] = array();
			}
			$offset++;
		}
		if (count($this->predictions_full) < 8) {
			$this->candidates = $this->getEuro2012FinalStageCandidates($request, $this->kupGamesData, $this->predictions_ic);
		} else {
			$this->candidates = array(
					'A' => array(
							'first' =>  array(array($this->predictions_full[0])),
							'second' => array(array($this->predictions_full[1]))),
					'B' => array(
							'first' => array(array($this->predictions_full[2])),
							'second' =>  array(array($this->predictions_full[3]))),		
					'C' => array(
							'first' => array(array($this->predictions_full[4])),
							'second' => array(array($this->predictions_full[5]))),	

					'D' => array(
							'first' => array(array($this->predictions_full[6])),
							'second' => array(array($this->predictions_full[7]))),
			);
		}
		
		$this->quarterPoints = $this->calculPoints($this->getResultsQuarterFinals(), $this->predictions_full);
		$this->halfPoints = $this->calculPoints($this->getResultsHalfFinals(), $this->predictions_full);
		$this->finalPoints = $this->calculPoints($this->getResultsFinals(), $this->predictions_full);
		$this->winnerPoints = $this->calculPoints($this->getResultsWinner(), $this->predictions_full);
	}
	
	private function getResultsQuarterFinals() {
		return array('t367', 't359', 't118', 't368', 't357', 't517', 't114', 't119');
	}
	private function getResultsHalfFinals() {
		return array('t359', 't118', 't357', 't119');
	}
	private function getResultsFinals() {
		return array('t118', 't119');
	}
	private function getResultsWinner() {
		return array('t118');
	}
	
	private function calculPoints($results, $predictions) {
		$points = 0;
		$quarterFinal = array();
		$halfFinal = array();
		$final = array();
		$winner = array();
		
		$i=0;
		foreach($predictions as $prediction) {
			if($i>=0 && $i< 8) {
				$quarterFinal[] =  isset($prediction['uuid']) ? $prediction['uuid'] : '' ;
			} else if($i>=8 && $i<12) {
				$halfFinal[] = isset($prediction['uuid']) ? $prediction['uuid'] : '';
			} else if($i>=12 && $i<14) {
				$final[] = isset($prediction['uuid']) ? $prediction['uuid'] : '';
			} else if($i>= 15) {
				$winner[] = isset($prediction['uuid']) ? $prediction['uuid'] : '';
			}
			$i++;
		}
		
		$j=0;
		foreach($results as $result) {
			if(count($results) == 8) {
				if(in_array($result, $quarterFinal)) {
					$points += 10;
				}
			} else if(count($results) == 4) {
				if(in_array($result, $halfFinal)) {
					$points += 20;
				}
			} else if(count($results) == 2) {
				if(in_array($result, $final)) {
					$points += 30;
				}
			} else if(count($results) == 1) {
				if(in_array($result, $winner)) {
					$points += 50;
				}
			}
			$j++;
		}
		
		return $points;
	}

	/**
	 * Computes the list of candidate teams for the final stage as pre-selected teams
	 * in predictions's tree depending on player's groups predictions formerly placed.
	 *
	 * <p>
	 *
	 * Official UEFA rules : http://fr.uefa.com/MultimediaFiles/Download/Regulations/competitions/Regulations/01/49/45/07/1494507_DOWNLOAD.pdf
	 *
	 * @param array $kupGamesData
	 * @param array $predictions_ic
	 * @return array
	 */
	private function getEuro2012FinalStageCandidates($request, $kupGamesData, $predictions_ic) {
		$teams = array();
		foreach($kupGamesData as $key => $gamesData) {
			$teams[$key] = array();
			foreach($gamesData as $gameData) {
				$prediction = $this->getEuro2012PredictionsForGame($predictions_ic, $gameData['id']);
				if($prediction == 1) {
					if(!isset($teams[$key][$gameData['team1id']])) {
						$teams[$key][$gameData['team1id']] = 0;
					}
					$teams[$key][$gameData['team1id']] += 3;
				} else if($prediction == 2) {
					if(!isset($teams[$key][$gameData['team1id']])) {
						$teams[$key][$gameData['team1id']] = 0;
					}
					if(!isset($teams[$key][$gameData['team2id']])) {
						$teams[$key][$gameData['team2id']] = 0;
					}
					$teams[$key][$gameData['team1id']] += 1;
					$teams[$key][$gameData['team2id']] += 1;
				} else if($prediction == 3) {
					if(!isset($teams[$key][$gameData['team2id']])) {
						$teams[$key][$gameData['team2id']] = 0;
					}
					$teams[$key][$gameData['team2id']] += 3;
				}
			}
		}

		// Sort by rounds.
		$candidates = array();
		foreach($teams as $round => $roundTeam) {
			$candidates[$round] = $this->getEuro2012FinalStageCandidatesForRound($request, $roundTeam);
		}
		
		if (!empty($candidates) && isset($candidates['A']) && !empty($candidates['A'])) {
			$ordered = array(
				'A' => array(
						'first' =>  $candidates['A']['first'],
						'second' => $candidates['B']['second']),
				'B' => array(
						'first' => $candidates['B']['first'],
						'second' => $candidates['A']['second']),
				'C' => array(
						'first' => $candidates['C']['first'],
						'second' =>$candidates['D']['second']),
				'D' => array(
						'first' => $candidates['D']['first'],
						'second' => $candidates['C']['second']),
			);
			
		} else {
			// no predictions or anonymous
			$ordered = array(
					'A' => array(
							'first' =>  array(),
							'second' => array()),
					'B' => array(
							'first' => array(),
							'second' =>  array()),
					'C' => array(
							'first' => array(),
							'second' => array()),
					'D' => array(
							'first' => array(),
							'second' => array()),
			);
		}

		return $ordered;

	}


	/**
	 * Get the predictions value for a games uuid
	 *
	 * @param array $predictions_ic
	 * @param number $gamesId
	 * @return number
	 */
	private function getEuro2012PredictionsForGame($predictions_ic, $gamesId) {
		foreach($predictions_ic as $key => $value) {
			if($key == $gamesId) {
				return $value;
			}
		}
	}


	/**
	 * Get the list of finalist.
	 *
	 * @param array $teams
	 * @param array $kupGamesData
	 * @return array
	 */
	private function getEuro2012FinalStageCandidatesForRound($request, $teams) {
		arsort($teams);
		$candidates = array(
				'first' => array(),
				'second' => array()
		);
		foreach($teams as $teamId => $score) {
			if(count($candidates['first']) == 0) {
				$candidates['first'][$teamId] = $score;
			} else {
				$continue = false;
				foreach($candidates['first'] as $team => $points) {
					if($score > $points) {
						$candidates['first'][$teamId] = $score;
						$continue = true;
					} else if ($score == $points) {
						$candidates['first'][$teamId] = $score;
					}
				}
				if($continue) {
					continue;
				}
			}
		}
		foreach($teams as $teamId => $score) {
			//Second
			if(count($candidates['second']) == 0) {
				if (count($candidates['first']) == 1 && !isset($candidates['first'][$teamId])) {
					$candidates['second'][$teamId] = $score;
				} else {
					continue;
				}
			} else {
				foreach($candidates['second'] as $team => $points) {
					if($score > $points) {
						$candidates['second'][$teamId] = $score;
					} else if ($score == $points) {
						$candidates['second'][$teamId] = $score;
					}
				}
			}
		}
		if (empty($candidates['second'])) {
			$candidates['second'] = $candidates['first'];
		}
		
		$final_candidates = array();
		// Add team metadata
		foreach ($candidates as $position => $pcandidates) {
			$mcandidates = array();
			foreach ($pcandidates as $teamUUID => $score) {
				$team = $this->getCoreSportTeamByUUID($request, $teamUUID);
				$team['avatar'] = '/image/default/rugby/teams/' . $teamUUID . '.png';
				array_push($mcandidates, array($teamUUID => $team));
				//$mcandidates[$teamUUID] = $team;
			}
			$final_candidates[$position] = $mcandidates;
		}

		return $final_candidates;
	}


	/**
	 * Save predictions for final part.
	 *
	 * @param sfWebRequest $request
	 * @return json
	 */
	public function executeEuro2012FullPredictionsFinalSave(sfWebRequest $request) {

		$kup_uuid = $request->getParameter('kup_uuid', '-1');
		$predictions_full = $request->getParameter('predictions_full', array());
		if (empty($predictions_full)) {
			$resp = array('response' => '', 'cerror' => '202');
			return $this->renderText(json_encode($resp));
		}
		
		// Ordered list of teams (top to bottom, left to right. We must insert null if no prediction.
		$payload = array(
		// Quarters predictions are always initialized
		$predictions_full['round'][0],
		$predictions_full['round'][1],
		$predictions_full['round'][2],
		$predictions_full['round'][3],
		$predictions_full['round'][4],
		$predictions_full['round'][5],
		$predictions_full['round'][6],
		$predictions_full['round'][7],
		);
		if (isset($predictions_full['quarter_final'])) {
			array_push($payload,
			isset($predictions_full['quarter_final']['A']) ? $predictions_full['quarter_final']['A'] : NULL,
			isset($predictions_full['quarter_final']['B']) ? $predictions_full['quarter_final']['B'] : NULL,
			isset($predictions_full['quarter_final']['C']) ? $predictions_full['quarter_final']['C'] : NULL,
			isset($predictions_full['quarter_final']['D']) ? $predictions_full['quarter_final']['D'] : NULL
			);
		}
		if (isset($predictions_full['half_final'])) {
			array_push($payload,
			isset($predictions_full['half_final'][0]) ? $predictions_full['half_final'][0] : NULL,
			isset($predictions_full['half_final'][1]) ? $predictions_full['half_final'][1] : NULL
			);
		}
		if (isset($predictions_full['final'])) {
			array_push($payload,
			$predictions_full['final']
			);
		}

		$sofun = BetkupWrapper::_getSofunApp($request, $this);
		$params = array(
				'communityId' => sfConfig::get('app_sofun_community_id'),
				'type' => sfConfig::get('mod_soccer_prediction_type_final_stage'),
		sfConfig::get('mod_soccer_prediction_type_final_stage') => $payload,
				'seasonUUID' => sfConfig::get('mod_soccer_season_uuid'),
		);
		try {
			$email = $this->getUser()->getAttribute('email', '', 'subscriber');
			$response = $sofun->api_POST("/kup/" . $kup_uuid . "/member/" . $email . "/predictions/add", $params);
		} catch (SofunApiException $e) {
			error_log($e);
		}
		if ($response["http_code"] != "202") {
			error_log($response['buffer']);
		}
		$resp = array('response' => '', 'cerror' => $response["http_code"]);
		return $this->renderText(json_encode($resp));
	}

}

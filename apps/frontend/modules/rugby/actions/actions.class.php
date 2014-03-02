<?php

/**
 * Rugby actions.
 *
 * @package    betkup.fr
 * @subpackage rugby
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: actions.class.php 3638 2012-01-24 18:23:35Z anguenot $
 */
class rugbyActions extends betkupActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

    }

    /**
     * Display fixture's predictions.
     *
     * <p/>
     *
     * XXX dead code: used to be within Kups for CDM
     *
     * @param sfWebRequest $request
     */
    public function executePredictionFixtures(sfWebRequest $request) {

        $this->uuid = $request->getParameter('uuid', '');

        if ($this->uuid == '') {
            $this->redirect (array ('module' => 'kup', 'action' => 'home'));
        }

        $this->redirect (array ('module' => 'kup', 'action' => 'predictionKnockout', 'uuid' => $this->uuid));

        $this->setTabs($request, $this->uuid);

        // Get Kup's data given its uuid.
        $this->kupData = $this->getKupData($request, $this->uuid);

        // Get kup's bettable round's data
        $this->kupRoundsData = $this->getKupRoundsData($request, $this->uuid);
        $this->kupRoundsData = $this->filterVisibleRounds($this->kupRoundsData);

        if ($request->isMethod ('post')) {

            $this->predictionFixturesData = $request->getParameter('match', array());
            $this->fixtures_ic = array();

            foreach($this->predictionFixturesData as $key => $value) {
                $this->fixtures_ic[$key] = intval($value[$key]);
            }

            if ($this->getUser()->isAuthenticated()) {
                $this->savePredictions($request, $this->uuid, $this->fixtures_ic, array(), array());
                $this->redirect (array ('module' => 'kup', 'action' => 'predictionKnockout', 'uuid' => $this->uuid));
            } else {
                $this->getUser ()->setFlash ('error', $this->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_failed_must_login'));
            }

        } else {

            if ($this->getUser()->isAuthenticated()) {
                // Retrieve predictions
                $this->fixtures_ic = $this->getPredictions($request, $this->uuid, 'ic');;
            } else {
                $this->fixtures_ic = array();
            }
        }

        $this->fixturesData = array();

        foreach($this->kupRoundsData as $round) {

            $this->fixturesData[$round['name']] = array();

            $roundGames = $this->getKupGamesData($request, $this->uuid, $round['uuid']);

            $offset = 0;
            foreach($roundGames as $game) {
                $this->fixturesData[$round['name']][$offset] = array(
						'id' => $game['uuid'],
						'date' => $game['title'],
						'team1Id' => $game['team1id'],
						'team1Title' => $game['team1title'],
						'team2Id' => $game['team2id'],
						'team2Title' => $game['team2title'],
						'first_country' => $game['team1id'],
						'team1_avatar' => $game['team1avatar'],
						'second_country' => $game['team2id'],
						'team2_avatar' => $game['team2avatar'],
                );
                $offset+=1;
            }

        }

    }

    /**
     * Display knockout's predictions for Kup "Le Tableau"
     *
     * <p/>
     *
     * XXX dead code: used to be within Kups for CDM
     *
     * @param sfWebRequest $request
     */
    public function executePredictionKnockout(sfWebRequest $request) {

        $this->uuid = $request->getParameter('uuid', '');

        if ($this->uuid == '') {
            $this->redirect (array ('module' => 'kup', 'action' => 'home'));
        }

        $this->setTabs($request, $this->uuid);

        // Get Kup's data given its uuid.
        $this->kupData = $this->getKupData($request, $this->uuid);

        $this->kupRoundsData = array(

        array('uuid' => 668, 'name' => 'QF'),
        array('uuid' => 673, 'name' => 'SF'),
        array('uuid' => 678, 'name' => 'F'),
        array('uuid' => -1,  'name' => 'W'),

        );

        $teams = $this->getSeasonTeams($request, 210);
        if ($request->isMethod ('post')) {

            $prediction = array();

            $qf = $request->getParameter('QF');
            foreach($qf as $game) {

                $team1 = $this->getTeamByISO($teams, $game[0]);
                $team2 = $this->getTeamByISO($teams, $game[1]);

                if (isset($team1['uuid'])) {
                    $t1uuid = $team1['uuid'];
                } else {
                    $t1uuid = null;
                }

                if (isset($team2['uuid'])) {
                    $t2uuid = $team2['uuid'];
                } else {
                    $t2uuid = null;
                }

                array_push($prediction, $t1uuid, $t2uuid);

            }

            $sf = $request->getParameter("SF");
            foreach($sf as $game) {

                $team1 = $this->getTeamByISO($teams, $game[0]);
                $team2 = $this->getTeamByISO($teams, $game[1]);

                if (isset($team1['uuid'])) {
                    $t1uuid = $team1['uuid'];
                } else {
                    $t1uuid = null;
                }

                if (isset($team2['uuid'])) {
                    $t2uuid = $team2['uuid'];
                } else {
                    $t2uuid = null;
                }

                array_push($prediction, $t1uuid, $t2uuid);

            }

            $f = $request->getParameter("F");
            foreach($f as $game) {

                $team1 = $this->getTeamByISO($teams, $game[0]);
                $team2 = $this->getTeamByISO($teams, $game[1]);

                if (isset($team1['uuid'])) {
                    $t1uuid = $team1['uuid'];
                } else {
                    $t1uuid = null;
                }

                if (isset($team2['uuid'])) {
                    $t2uuid = $team2['uuid'];
                } else {
                    $t2uuid = null;
                }

                array_push($prediction, $t1uuid, $t2uuid);

            }

            $w = $request->getParameter("W");
            foreach($w as $game) {

                $team1 = $this->getTeamByISO($teams, $game[0]);

                if (isset($team1['uuid'])) {
                    $t1uuid = $team1['uuid'];
                } else {
                    $t1uuid = null;
                }

                array_push($prediction, $t1uuid);

            }

            if ($this->getUser()->isAuthenticated()) {
                $this->savePredictions($request, $this->uuid, array(),array(), array(), $prediction);
                $knockoutPrediction = $this->getPredictions($request, $this->uuid, 'full');
            } else {
                $this->getUser ()->setFlash ('error', $this->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_failed_must_login'));
            }

        } else {

            if ($this->getUser()->isAuthenticated()) {
                // Retrieve predictions
                $knockoutPrediction = $this->getPredictions($request, $this->uuid, 'full');
            } else {
                $knockoutPrediction = array();
            }

        }

        $this->tournamentData = array();

        $reducedTeams = array();

        $offset = 0;
        foreach ($teams as $team) {
            $reducedTeams[$offset] = $team['country']['iso'];
            $offset++;
        }

        $gameOffset = 0;
        foreach($this->kupRoundsData as $round) {

            $this->tournamentData[$round['name']] = array();

            if ($round['uuid'] == -1) {

                $team1 = NULL;
                if (isset($knockoutPrediction[$gameOffset]) && $knockoutPrediction[$gameOffset] != 0) {
                    $t1 = $this->getTeamByUUID($teams, $knockoutPrediction[$gameOffset]);
                    $team1 = $t1['country']['iso'];
                }

                if ($team1 == NULL) {
                    $this->tournamentData[$round['name']][$offset] = array(
                                    	  'date' => $game['title'],
                    );
                } else {
                    $this->tournamentData[$round['name']][$offset] = array(
                                                        	  'date' => $game['title'],
                        'first_country' => $team1,
                    );
                }


            } else {
                $roundGames = $this->getKupGamesData($request, $this->uuid, $round['uuid'], true, '');
                $offset = 0;
                foreach($roundGames as $game) {

                    $team1 = $reducedTeams;
                    if (isset($knockoutPrediction[$gameOffset]) && $knockoutPrediction[$gameOffset] != 0) {
                        $t1 = $this->getTeamByUUID($teams, $knockoutPrediction[$gameOffset]);
                        $team1 = $t1['country']['iso'];
                    }

                    $team2 = $reducedTeams;
                    if (isset($knockoutPrediction[$gameOffset+1]) && $knockoutPrediction[$gameOffset+1] != 0) {
                        $t2 = $this->getTeamByUUID($teams, $knockoutPrediction[$gameOffset+1]);
                        $team2 = $t2['country']['iso'];
                    }

                    if ($round['uuid'] == 668) {
                        $teamComplete = $reducedTeams;
                        $this->tournamentData[$round['name']][$offset] = array(
    						'date' => $game['title'],
    						'first_country' => $team1,
    						'second_country' => $team2,
                            'team_complete' => $teamComplete,
                        );

                    } else {

                        $this->tournamentData[$round['name']][$offset] = array(
    						'date' => $game['title'],
                        );

                        if (!is_array($team1)) {
                            $this->tournamentData[$round['name']][$offset]['first_country'] = $team1;
                        }

                        if (!is_array($team2)) {
                            $this->tournamentData[$round['name']][$offset]['second_country'] = $team2;
                        }

                    }

                    $offset+=1;
                    $gameOffset +=2;
                }
            }

        }

    }

}
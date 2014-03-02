<?php

/**
 * Abstract Betkup Components class.
 *
 * <p/>
 *
 * Abstract class that betkup.fr components should inherit from.
 * It defines primitives handling the Sofun Platform access and session using the sfWebRequest.
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: betkupComponents.class.php 5236 2012-06-12 23:52:50Z anguenot $
 */
class betkupComponents extends sfComponents
{

    /**
     * Return the round data for given kup uuid.
     *
     * @param sfWebRequest $request
     * @param int          $kup_uuid
     * @param object       $parent
     * @param string       $status
     *
     * @return array
     */
    protected function getKupRoundsData($request, $kup_uuid)
    {
        $cacheKey = 'kup_rounds_data_' . $kup_uuid;
        $kupRoundsData = sfMemcache::getInstance()->get($cacheKey, 'NULL');
        if ($kupRoundsData == 'NULL' || $kupRoundsData == '') {
            $kupRoundsData = BetkupWrapper::getKupRoundsData($request, $kup_uuid, $this);
            // We will be caching rounds for 5 minutes.
            sfMemcache::getInstance()->set($cacheKey, $kupRoundsData, 0, 300);
        }
        return $kupRoundsData;
    }

    /**
     * Returns a room given its UUID.
     *
     * @param sfWebRequest $request
     * @param int          $uuid
     */
    protected
    function getRoomByName(sfWebRequest $request, $name = '')
    {
        return BetkupWrapper::getRoomByName($request, $this, $name);
    }

    protected
    function getRoundUUID($request, $kup_uuid, $kupRoundsData)
    {
        return BetkupWrapper::getRoundUUID($request, $kup_uuid, $kupRoundsData, $this);
    }

    protected
    function getKupGamesData($request, $kup_uuid, $roundUUID, $future, $status)
    {
        $cacheKey = 'kup_games_data_' . $kup_uuid . '_' . $roundUUID . '_' . $status;
        $kupGamesData = sfMemcache::getInstance()->get($cacheKey, 'NULL');
        if ($kupGamesData == 'NULL' || $kupGamesData == '') {
            $kupGamesData = BetkupWrapper::getKupGamesData($request, $this, $kup_uuid, $roundUUID, $future, $status);
            // We will be caching rounds for 5 minutes.
            sfMemcache::getInstance()->set($cacheKey, $kupGamesData, 0, 300);
        }
        return $kupGamesData;
    }

    protected
    function getPredictionsLastModified($request, $kup_uuid)
    {
        return BetkupWrapper::getPredictionsLastModified($request, $kup_uuid, $this);
    }

    /**
     * Search for kups of rooms given parameters.
     *
     * @param sfWebRequest $request
     * @param array        $params
     */
    protected
    function getRoomKups(sfWebRequest $request, $params = array())
    {
        return BetkupWrapper::getRoomKups($request, $this, $params);
    }

    /**
     * Saves player's predictions.
     *
     * @param sfWebRequst $request
     * @param array       $predictions
     * @param in          $kupUUID
     */
    protected
    function savePredictions(sfWebRequest $request, $kupUUID, $ic = array(), $se = array(), $q = array(), $full = array(), $params = array(), $tb = array())
    {
        BetkupWrapper::savePredictions($request, $kupUUID, $this, $ic, $se, $q, $full, $params, $tb);
    }

    /**
     * Get player's predictions if any.
     *
     * @param sfWebRequest $request
     * @param in           $kupUUID
     */
    protected
    function getPredictions(sfWebRequest $request, $kupUUID, $type)
    {
        return BetkupWrapper::getPredictions($request, $kupUUID, $type, $this);
    }

    protected
    function getTeamPlayers($request, $team_id)
    {
        return BetkupWrapper::getTeamPlayers($request, $team_id, $this);
    }

    protected
    function getPlayerNameByUUID($players, $uuid)
    {
        return BetkupWrapper::getPlayerNameByUUID($players, $uuid);
    }

    /**
     * Get user predictions for one kup
     *
     * @param int    $kup_uuid
     * @param string $predictionType
     *
     * @return array
     */
    protected
    function getF1Predictions($request, $kup_uuid, $type, $coreResults = null, $kupData = array())
    {
        return BetkupWrapper::getF1Predictions($request, $kup_uuid, $type, $this, $coreResults, $kupData);
    }

    protected
    function getKupRanking(sfWebRequest $request, $team_uuid, $offset = 0, $batchSize = 20, $friends_only = false)
    {
        return BetkupWrapper::getKupRanking($request, $team_uuid, $this, $offset, $batchSize, $friends_only);
    }

    protected
    function getRanking($request, $kup_uuid, $offset, $batch, $friends_only = false)
    {
        return BetkupWrapper::getRanking($request, $kup_uuid, $this, $offset, $batch, $friends_only);
    }

    protected
    function getRoomRankingFor(sfWebRequest $request, $room_uuid, $offset = 0, $batch = 50, $friends_only = false)
    {
        return BetkupWrapper::getRoomRankingFor($request, $room_uuid, $this, $offset, $batch, $friends_only);
    }

    protected
    function getRoomRanking(sfWebRequest $request, $room_uuid, $offset = 0, $batch = 50, $friends_only = false)
    {
        return BetkupWrapper::getRoomRanking($request, $room_uuid, $this, $offset, $batch, $friends_only);
    }

    protected
    function getCyclingPredictions($request, $kup_uuid, $type, $coreResults = null, $kupData = array(), $params = array())
    {
        return BetkupWrapper::getCyclingPredictions($request, $kup_uuid, $type, $this, $coreResults, $kupData, $params);
    }

    protected
    function getF1TeamByUUID($request, $kup_uuid, $team_uuid, $kupData = array())
    {
        return BetkupWrapper::getF1TeamByUUID($request, $kup_uuid, $team_uuid, $this, $kupData);
    }

    protected
    function saveF1Predictions(sfWebRequest $request, $type, $kup_uuid, $predictions, $kupData = array(), $kupRoundsData = array())
    {
        return BetkupWrapper::saveF1Predictions($request, $type, $kup_uuid, $predictions, $this, $kupData, $kupRoundsData);
    }

    protected
    function saveCyclingPredictions(sfWebRequest $request, $type, $kup_uuid, $predictions, $kupData = array(), $kupRoundData = array())
    {
        return BetkupWrapper::saveCyclingPredictions($request, $type, $kup_uuid, $predictions, $this, $kupData, $kupRoundData);
    }

    /**
     * Get driver data including UI elements and properties.
     */
    protected
    function getF1DriverDataFor($coreDriver)
    {
        return BetkupWrapper::getF1DriverDataFor($coreDriver);
    }

    protected
    function usortByArrayKey(array $array, $key, $order = SORT_ASC)
    {
        return BetkupWrapper::usortByArrayKey($array, $key, $order);
    }

    /**
     * Get the driver's list for a given Kup.
     *
     * @param int $kup_uuid
     *
     * @return array
     */
    protected
    function getF1Drivers($request, $kup_uuid, $kupData = array())
    {
        return BetkupWrapper::getF1Drivers($request, $kup_uuid, $this, $kupData);
    }

    /**
     * Get the driver infos by it's uuid
     *
     * @param sfWebRequest $request
     * @param int          $kup_uuid
     * @param int          $driver_uuid
     * @param array        $kupData
     */
    protected
    function getF1DriverByUUID($request, $kup_uuid, $driver_uuid, $kupData = array())
    {
        return BetkupWrapper::getF1DriverByUUID($request, $kup_uuid, $driver_uuid, $this, $kupData);
    }

    /**
     * Returns a filtered list of drivers given a player prediction.
     *
     * <p>
     *
     * Drivers in predictions will be removed.
     *
     * @param array $drivers
     * @param array $userPredictions
     *
     * @return array $fiteredDrivers
     */
    protected
    function getF1DriversFilteredBy($drivers, $userPredictions)
    {
        return BetkupWrapper::getF1DriversFilteredBy($drivers, $userPredictions);
    }

    /**
     * Returns results data including driver's data for UI display.
     *
     * @param unknown_type $request
     * @param unknown_type $kup_uuid
     * @param unknown_type $type
     */
    protected
    function getF1Results($request, $kupData, $kup_uuid, $type)
    {
        return BetkupWrapper::getF1Results($request, $kupData, $kup_uuid, $type, $this);
    }

    protected
    function getCyclingResults($request, $kupData, $kup_uuid, $type, $roundUUID)
    {
        return BetkupWrapper::getCyclingResults($request, $kupData, $kup_uuid, $type, $this, $roundUUID);
    }

    /**
     * Returns the tournament's season teams.
     *
     * @param sfWebRequest $request
     * @param long         $seasonId
     */
    protected
    function getSeasonTeams(sfWebRequest $request, $seasonId)
    {
        return BetkupWrapper::getSeasonTeams($request, $seasonId, $this);
    }

    /**
     * Returns the tournament's season teams.
     *
     * @param sfWebRequest $request
     * @param long         $seasonId
     */
    protected
    function getSeasonPlayers(sfWebRequest $request, $seasonId)
    {
        return BetkupWrapper::getSeasonPlayers($request, $seasonId, $this);
    }

    /**
     * Returns a room given its UUID.
     *
     * @param sfWebRequest $request
     * @param int          $uuid
     */
    protected
    function getRoom(sfWebRequest $request, $uuid)
    {
        return BetkupWrapper::getRoom($request, $uuid, $this);
    }

    /**
     * Get the default bindings for kup match questions.
     *
     * @return array
     */
    protected
    function getKupQuestionsBindings()
    {
        $module_dir = sfConfig::get('sf_app_module_dir');
        $module_name = 'kup';
        $data = 'data/config';
        $file = 'kup_questions_bindings.yml';
        $config = sfYaml::load($module_dir . '/' . $module_name . '/' . $data . '/' . $file);
        return $config['bindings'];
    }

    /**
     * Set the question text and points to display on the kup prediction page.
     *
     * @param $kupData
     * @param $kupGameData
     */
    protected
    function setKupInterogationsText($kupData, $sport, $kupGameData, $questionsBindings)
    {
        $this->questionText = '';
        $this->pointsText = '';
        if (count($kupData) > 0 && isset($kupData['ui']['questions']) && (isset($kupData['ui']['questions'][$kupGameData["id"]]) || (isset($kupGameData["questionId"]) && isset($kupData['ui']['questions'][$kupGameData["questionId"]])))) {
            if (isset($kupGameData["questionId"])) {
                $this->questionText = $this->getContext()->getI18N()->__($kupData['ui']['questions'][$kupGameData["questionId"]]['label']);
                $this->pointsText = $kupData['ui']['questions'][$kupGameData["questionId"]]['points'];
            } else {
                $this->questionText = $this->getContext()->getI18N()->__($kupData['ui']['questions'][$kupGameData["id"]]['label']);
                $this->pointsText = $kupData['ui']['questions'][$kupGameData["id"]]['points'];
            }
        } else if (count($kupData) > 0 && isset($kupData['ui']['questions']) && isset($kupData['ui']['questions'][$kupGameData["type"]])) {
            $this->questionText = $this->getContext()->getI18N()->__($kupData['ui']['questions'][$kupGameData["type"]]['label']);
            $this->pointsText = $kupData['ui']['questions'][$kupGameData["type"]]['points'];
        } else if (isset($questionsBindings[$kupGameData["type"]]) && isset($questionsBindings[$kupGameData["type"]][$sport])) {
            $this->questionText = $this->getContext()->getI18N()->__($questionsBindings[$kupGameData["type"]][$sport]['label']);
            $this->pointsText = $questionsBindings[$kupGameData["type"]][$sport]['points'];
        } else if (isset($questionsBindings[$kupGameData["type"]]) && $kupGameData["type"] == 'q' && isset($questionsBindings[$kupGameData["type"]][$kupGameData["questionId"]])) {
            $this->questionText = $this->getContext()->getI18N()->__($questionsBindings[$kupGameData["type"]][$kupGameData["questionId"]]['label']);
            $this->pointsText = $questionsBindings[$kupGameData["type"]][$kupGameData["questionId"]]['points'];
        } else {
            if (isset($kupGameData["questionId"])) {
                $this->questionText = $this->getContext()->getI18N()->__('label_kup_question_' . $kupGameData["questionId"]);
                $this->pointsText = 'N/C';
            } else {
                $this->questionText = $this->getContext()->getI18N()->__('label_kup_question_' . $kupGameData["id"]);
                $this->pointsText = 'N/C';
            }
        }
    }

}
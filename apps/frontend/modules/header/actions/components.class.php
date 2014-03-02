<?php

/**
 * header components.
 *
 * @package    betkup.fr
 * @subpackage header
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: components.class.php 6155 2012-09-20 15:40:06Z jmasmejean $
 */
class headerComponents extends betkupActions
{

    /**
     * Returns the kup UUID.
     *
     * The URL pattern is:
     *
     *     /kup/<uuid>/view/
     *     /kup/<uuid>/ranking/
     *
     * @return int or NULL
     */
    private function getKupUUID()
    {

        $uuid = -1;

        $arrayActionKup = array('view', 'ranking', 'results', 'news', 'rules', 'bet', 'predictionFixtures', 'predictionKnockout');
        $arrayActionKupRoom = array('view', 'kup', 'kupRanking', 'kupResults', 'kupRules', 'kupPrediction', 'kupPredictionFixtures', 'kupPredictionKnockout', 'kupNews');

        $module = $this->getContext()->getModuleName();
        $action = $this->getContext()->getActionName();
        if ($module == "kup") {
            if (in_array($action, $arrayActionKup)) {
                $uuid = $this->getContext()->getRequest()->getParameter("uuid", -1);
            }
        } elseif ($module == "room") {
            if (in_array($action, $arrayActionKupRoom)) {
                $uuid = $this->getContext()->getRequest()->getParameter("kup_uuid", -1);
            }
        }

        return $uuid;

    }

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
    private function getRoomUUID()
    {

        $uuid = -1;

        $arrayActionKup = array('view', 'ranking', 'results', 'news', 'rules', 'bet', 'predictionFixtures', 'predictionKnockout');
        $arrayActionRoom = array('view', 'edit', 'inviteFacebook', 'inviteLink', 'invite', 'inviteTwitter', 'kups', 'members');
        $arrayActionKupRoom = array('kup', 'kupRanking', 'kupResults', 'kupRules', 'kupPrediction', 'kupPredictionFixtures', 'kupPredictionKnockout', 'kupNews');

        $module = $this->getContext()->getModuleName();
        $action = $this->getContext()->getActionName();
        if ($module == "kup") {
            if (in_array($action, $arrayActionKup)) {
                $uuid = $this->getContext()->getRequest()->getParameter("room_uuid", -1);
            }
        } elseif ($module == "room") {
            if (in_array($action, $arrayActionKupRoom)) {
                $uuid = $this->getContext()->getRequest()->getParameter("room_uuid", -1);
            } elseif (in_array($action, $arrayActionRoom)) {
                $uuid = $this->getContext()->getRequest()->getParameter("uuid", -1);
            }
        }

        return $uuid;

    }

    /**
     *
     * call the header
     */
    public function executeHeader()
    {
        $this->backgroundList = array('header_warrning_1.png', 'header_warrning_2.png');
        $this->randomIndex = rand(0, count($this->backgroundList) - 1);

        $this->selectedBackground = $this->backgroundList[$this->randomIndex];
    }

    /**
     *
     * call the connexion box when the user is not connected
     */
    public function executePopup()
    {
        $this->form = new ConnexionForm();
        $this->form->disableCSRFProtection();

        $this->birthdateCookiePrefix = sfConfig::get('mod_header_birthdate_cookie_prefix');
        // XXX BETKUP-542
        // $this->form->getCSRFToken();
    }

    /**
     *
     * call the top of the page, when the user is connected
     */
    public function executeToppage()
    {

        $this->account_type = $this->getUser()->getAttribute('account_type', '', 'subscriber');
        $this->userFirstName = $this->getUser()->getAttribute('firstName', '', 'subscriber');
        $this->userLastName = $this->getUser()->getAttribute('lastName', '', 'subscriber');

        $admin = array(
            'nickName' => $this->getUser()->getAttribute('nickName', '', 'subscriber'),
            'firstName' => $this->userFirstName,
            'lastName' => $this->userLastName
        );
        $this->userNickname = Util::getNicknameFor($admin);
        $this->userCredit = $this->getUser()->getAttribute('credit', '', 'subscriber');
        $this->userBets = $this->getUser()->getAttribute('bets', '0', 'subscriber');
    }

    /**
     * check module and action then get room or kup informations.
     * @param $request
     */
    public function executeOpenTags(sfWebRequest $request)
    {

        $this->module = $this->request->getParameter('module', '');
        $this->action = $this->request->getParameter('action', '');
        $this->siteUrl = $this->getCustomUriPrefix($request);

        $arrayActionKup = array('view', 'ranking', 'results', 'news', 'rules', 'bet', 'predictionFixtures', 'predictionKnockout');
        $arrayActionRoom = array('view', 'edit', 'inviteFacebook', 'inviteLink', 'invite', 'inviteTwitter', 'kups', 'members');
        $arrayActionKupRoom = array('view', 'kup', 'kupRanking', 'kupResults', 'kupRules', 'kupPrediction', 'kupPredictionFixtures', 'kupPredictionKnockout', 'kupNews');

        if ($this->module == "room" && ((in_array($this->action, $arrayActionRoom)) || (in_array($this->action, $arrayActionKupRoom)))) {
            $this->roomUuid = $this->getRoomUUID($request);
            $room = $this->getRoom($request, $this->roomUuid);
            $this->dataRoom = $this->getRoomDataForWidget($room);
            if ((in_array($this->action, $arrayActionKupRoom))) {
                $this->kupUuid = $this->getKupUUID($request);
                $this->kupData = $this->getKupData($request, $this->kupUuid);
            }
        }

        if ($this->module == "kup" && in_array($this->action, $arrayActionKup)) {
            $uuid = $this->getKupUUID($request);
            $this->kupData = $this->getKupData($request, $uuid);
        }

        if($this->module == "facebook_ligue1_2012" && $this->request->getParameter('kup_uuid', '') != '') {
            $this->kupData = $this->getKupData($request, $this->request->getParameter('kup_uuid', ''));
        }


    }
}
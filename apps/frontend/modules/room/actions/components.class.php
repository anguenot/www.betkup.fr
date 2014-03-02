<?php

/**
 * Room components.
 *
 * @package    betkup.fr
 * @subpackage room
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: components.class.php 6303 2012-10-25 18:03:50Z jmasmejean $
 */
class roomComponents extends betkupComponents
{

    /**
     * Display green banner.
     * $titre = strings
     * $liens = array of links
     */
    public function executeHome()
    {

    }

    /**
     * Display search options on the top of the screen
     *
     * @see room/search
     */
    public function executeSearch()
    {

    }

    /**
     * Display the rooms from a particular user
     */
    public function executeMyRooms()
    {

        if (!isset ($this->nbDisplay)) {
            $this->nbDisplay = 1;
        }
        if (!isset ($this->totalRooms)) {
            $this->totalRooms = 0;
        }
        if (!isset($this->roomUI)) {
            $this->roomUI = "";
        }
        if (!isset($this->elementHeight)) {
            $this->elementHeight = '';
        }

        $this->batchSize = 2;
        $this->nbLine = 2;
        $this->previousOffset = 0;
        $this->currentOffset = 0;
        $this->nextOffset = $this->batchSize;
    }

    /**
     * XXX
     */
    public function executeMyaccount()
    {

    }

    /**
     *
     * Displays component bloc header in a kup
     */
    public function executeHeader()
    {
        $this->module = $this->request->getParameter('module', '');
        $this->action = $this->request->getParameter('action', '');
        $this->siteUrl = 'https://' . $this->getContext()->getRequest()->getHost();
        $this->culture = $this->getUser()->getCulture();

        $avatarsPath = sfConfig::get('mod_room_avatar_path');
        $dir = sfConfig::get('sf_web_dir') . $avatarsPath;
        $handle = opendir($dir) or die('Erreur');
        $this->avatarList = array();
        while ($entry = @readdir($handle)) {
            $info = pathinfo($entry);
            $this->avatarList[$info['filename']] = $avatarsPath . $entry;
        }
        closedir($handle);
    }

    /**
     *
     * Displays component bloc header in a kup of room
     */
    public function executeKupheader()
    {
        $this->module = $this->request->getParameter('module', '');
        $this->action = $this->request->getParameter('action', '');
        $this->siteUrl = 'https://' . $this->getContext()->getRequest()->getHost();
        $this->culture = $this->getUser()->getCulture();

        $this->kupType = '';
        if ($this->kupData["type"] == sfConfig::get('mod_room_kup_type_gambling_fr')) {
            if ($this->kupData["stake"] == 0) {
                $this->kupType = 'Kup freeroll';
            } else {
                $this->kupType = 'Kup payante';
            }
        } else {
            $this->kupType = 'Kup gratuite';
        }
    }

    /**
     * XXX
     * Enter description here ...
     */
    public function executeRight()
    {

        $this->prevTimeKup = '0';
        $this->idLongerKup = '0';
        if ((isset($this->kups)) && ($this->kups != "")) {
            foreach ($this->kups as $this->kup) {
                $this->timeKup = Util::nombreJoursEntreDeuxDates($this->kup["startDate"], $this->kup["endDate"]);
                if ($this->timeKup > $this->prevTimeKup) {
                    $this->prevTimeKup = $this->timeKup;
                    $this->idLongerKup = $this->kup["uuid"];
                }
            }
        }

        $this->joinUrl = $this->getController()->genUrl(array(
            'module' => 'room',
            'action' => 'join',
            'uuid' => $this->dataRoom['id']
        ));
        if (isset($this->needAdvancedAccount) && $this->needAdvancedAccount == 1) {
            $this->joinUrl = $this->generateUrl('room_join_advanced_account', array(
                'uuid' => $this->dataRoom['id'],
                'need_advanced_account' => 1,
                'redirect_route' => 'room_join'
            ));
        }
    }

    public function executeTabs()
    {

        if (!isset($this->numTab)) {
            $this->numTab = 1;
        }

        if ($this->tab == "information") {
            $this->numTab = 1;
        }

        if ($this->tab == "kups") {
            $this->numTab = 2;
        }

        if ($this->tab == "members") {
            $this->numTab = 3;
        }

    }

    /**
     * Show the home front kups in a room homepage
     */
    public function executeKupsHomeFront()
    {
        //Fix prize value & jackpot for a kup
        $roomKupsData = array();
        foreach ($this->kupsData as $kupData) {
            // XXX hack. Should be fixed properly...
            if (isset($kupData['type']) && $kupData['type'] == sfConfig::get('mod_room_kup_type_free')) {
                $kupData['isInRoom'] = true;
            }
            $roomKupsData[] = $kupData;
        }
        $this->kupsData = $roomKupsData;
        if (!isset($this->roomUI)) {
            $this->roomUI = array();
        }
    }

    /**
     * Show tabs for a room homepage
     **/
    public function executeTabsHome()
    {

    }

    /**
     * Show default home view of a room.
     **/
    public function executeRoomView()
    {

    }

    /**
     * XXX
     * Enter description here ...
     */
    public function executeListMembers()
    {

    }

    /**
     * Displays ranking and feed.
     *
     */
    public function executeLive()
    {

    }

    /**
     * Displays component feed
     *
     */
    public function executeFeed()
    {

    }

    /**
     * Displays component ranking
     *
     */
    public function executeRanking()
    {

    }


    /**
     * Displays component KupRanking
     *
     */
    public function executeKupRanking()
    {

        // Set all position to 0
        $this->supToFirst = 0;
        $this->supToMiddle = 0;
        $this->supToLast = 0;

        // Set number of page
        $this->nbPage = ceil($this->nbPlayers / $this->batch);

        // Set actual page
        $this->numActualPage = round(intval($this->offset) / intval($this->batch), 0, PHP_ROUND_HALF_UP) + 1;

        //Set page remaining
        $this->nbPageRemaining = $this->nbPage - $this->numActualPage;

        //Set member position page
        if ($this->memberPosition != 0) {
            $this->offsetMemberRanking = (ceil($this->memberPosition / $this->batch) - 1) * $this->batch;
        } else {
            $this->offsetMemberRanking = 0;
        }

        if (!isset($this->urlForFacebook)) {
            $this->urlForFacebook = '';
        }
        if (!isset($this->userRanking)) {
            $this->userRanking = array();
        }
        if (!isset($this->description)) {
            $this->description = $this->getContext()->getI18N()->__('text_publish_fb_ranking', array(
                '%jackpot%' => isset($this->userRanking['winnings']) ? $this->userRanking['winnings'] : '0',
                '%bet%' => $this->kupData['stake'],
                '%kup%' => $this->kupData['name']
            ));
        }
        if (!isset($this->properties)) {
            $this->properties = array(
                'Mon classement' => (isset($this->userRanking['position']) && !empty($this->userRanking) ? $this->userRanking['position'] : '0') . '/' . $this->nbPlayers,
                'Nombre de points' => (isset($this->userRanking['value']) && !empty($this->userRanking) ? $this->userRanking['value'] : '0') . ' pts',
                'Mon pseudo' => $this->getUser()->getAttribute('nickName', '', 'subscriber')
            );
        }

        //Decide position with the number of page and actual page
        if ($this->nbPage == 1) {
            $this->supToFirst = 0;
            $this->supToMiddle = 0;
            $this->supToLast = 0;
        } else if ($this->nbPage == 2) {
            if ($this->numActualPage == 1) {
                $this->supToFirst = 1;
            }
            if ($this->numActualPage == 2) {
                $this->supToLast = 1;
            }
        } else if ($this->nbPage <= 3) {
            if ($this->numActualPage == 1) {
                $this->supToFirst = 1;
            }
            if ($this->numActualPage == 2) {
                $this->supToFirst = 1;
            }
            if ($this->numActualPage == 3) {
                $this->supToLast = 1;
            }
        } else {
            if ($this->numActualPage < 4) {
                $this->supToFirst = 1;
            }
            if ($this->nbPageRemaining <= 2) {
                $this->supToLast = 1;
            }
            if ($this->supToFirst != 1 && $this->supToLast != 1) {
                $this->supToMiddle = 1;
            }
        }

    }

    /**
     * Displays one detailed room and kups inside
     */
    public function executeRoomThumbnail()
    {
        if (!isset($this->parentModule)) {
            $this->parentModule = '';
        }
        $this->avatarList = $this->getAvatarsList();
    }

    /**
     * Display one room bloc from search action
     */
    public function executeRoomThumbnailSearch()
    {

        if (!isset($this->module)) {
            $this->module = $this->request->getParameter('module', '');
        }
        if (!isset($this->roomData)) {
            $this->roomData = array();
        }
        $this->avatarList = $this->getAvatarsList();
    }

    /**
     * Display room flow at home page
     *
     * @see /home
     */
    public function executeRoomThumbnailHomePage()
    {
        if (!isset($this->module)) {
            $this->module = $this->request->getParameter('module', '');
        }
        if (!isset($this->roomData)) {
            $this->roomData = array();
        }
        $this->avatarList = $this->getAvatarsList();
    }

    /**
     * Display search room elements
     *
     * @see room/search
     */
    public function executeRoomSearch()
    {

        if (!isset ($this->nbDisplay)) {
            $this->nbDisplay = 3;
        }
        if (!isset ($this->totalRooms)) {
            $this->totalRooms = 0;
        }
        if (!isset($this->elementHeight)) {
            $this->elementHeight = "";
        }
        $this->batchSize = 6;
        $this->nbLine = 2;
        $this->previousOffset = 0;
        $this->currentOffset = 0;
        $this->nextOffset = $this->batchSize;
    }

    /**
     * Display home room elements
     *
     * @see room/home
     */
    public function executeRoomHome()
    {

        if (!isset ($this->nbDisplay)) {
            $this->nbDisplay = 3;
        }
        if (!isset ($this->totalRooms)) {
            $this->totalRooms = 0;
        }
        if (!isset($this->elementHeight)) {
            $this->elementHeight = "";
        }
        $this->batchSize = 6;
        $this->nbLine = 2;
        $this->previousOffset = 0;
        $this->currentOffset = 0;
        $this->nextOffset = $this->batchSize;
        $this->totalRooms = 12; // XXX see module.yml fixed size for the moment.
    }

    private function getAvatarsList()
    {
        $avatarsPath = sfConfig::get('mod_room_avatar_path');
        $dir = sfConfig::get('sf_web_dir') . $avatarsPath;
        $handle = opendir($dir) or die('Erreur');
        $avatarList = array();
        while ($entry = @readdir($handle)) {
            if ($entry != '.' && $entry != '..') {
                $info = pathinfo($entry);
                if ($info['filename'] != '') {
                    $avatarList[$info['filename']] = $avatarsPath . $entry;
                }
            }
        }
        closedir($handle);

        return $avatarList;
    }

    /**
     * Display the header for widget ranking.
     */
    public function executeWidgetHeader()
    {

    }

    /**
     * Display the footer for widget ranking.
     */
    public function executeWidgetFooter()
    {

    }

    public function executeWidgetCountDown()
    {

    }

    public function executeWidgetKupRanking()
    {

    }

    /**
     * @param sfWebRequest $request
     */
    public function executeMembers(sfWebRequest $request)
    {
        $this->room_uuid = $request->getParameter('uuid', '');
        $this->offset = $request->getParameter('offset', 0);
        $this->batchSize = $request->getParameter('batchSize', 10);

        //XXX use specific function. Not ranking.
        $members = $this->getRoomRanking($request, $this->room_uuid, $this->offset, $this->batchSize);
        $this->totalMembers = $members['totalMembers'];
        $this->members = $this->formatMembersForUi($members);

    }

    /**
     *  Format members to post to api.
     */
    private function formatMembersForApi()
    {
        //XXX format member
    }

    /**
     *  Format members for template
     *
     * @param array $memberList
     *
     * @return array $members
     */
    private function formatMembersForUi($memberList)
    {
        $members = array();

        foreach ($memberList['entries'] as $member) {

            $link = array('text' => 'Bloquer', 'href' => '');
            if ($member['member']['status'] == 'BLOCKED') {
                $link = array('text' => 'Débloquer', 'href' => '');
            }

            $members[] = array(
                'avatar' => isset($member['member']['avatarSmall']) ? $member['member']['avatarSmall'] : '',
                'name' => isset($member['member']['nickName']) && $member['member']['nickName'] != '' ? $member['member']['nickName'] : $member['member']['lastName'] . ' ' . $member['member']['firstName'],
                'status' => '',
                'color' => '',
                'link' => $link
            );
        }
        return $members;
    }

}
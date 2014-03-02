<?php
    /**
     * facebook_ligue1_2012 components.
     *
     * @package    betkup.fr
     * @subpackage facebook_ligue1_2012
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: components.class.php 6198 2012-10-02 13:11:50Z jmasmejean $
     */
    class facebook_ligue1_2012Components extends betkupComponents {

        /**
         *  Display the header
         */
        public function executeHeader(sfWebRequest $request) {
            // By default we have already installed the app.
            $this->progress = 25;
            $this->action = $request->getParameter('action', '');

            /*
                        if ($this->isUserPredictions($request)) {
                            $this->progress = 75;
                        }
                        if ($this->isUserComeBack($request)) {
                            $this->progress = 100;
                        }
            */
        }

        /**
         * Return true if the user has participate to a kup.
         *
         * @param sfWebRequest $request
         *
         * @return boolean
         */
        private function isUserPredictions($request) {
            $cacheKey = 'facebook_ligue1_201213_is_user_prediction';
            $result = sfMemcache::getInstance()->get($cacheKey, '');
            if ($result == '') {
                $roomData = $this->getRoomByName($request, sfConfig::get('mod_facebook_ligue1_2012_room_associate_name'));
                $room_uuid = $roomData['uuid'];
                $params = array('uuid' => $room_uuid);
                $kupsData = $this->getRoomKups($request, $params);

                $count = 0;
                foreach ($kupsData as $kupData) {
                    if ($kupData['is_participant'] == 1) {
                        $count++;
                    }
                }
                if ($count >= 1) {
                    $result = true;
                    sfMemcache::getInstance()->set($cacheKey, $result);
                }
            }
            if ($result == '') {
                $result = false;
            }
            return $result;
        }

        /**
         * Return true if the user have participate to more than 1 kup (he's come back).
         *
         * @param sfWebRequest $request
         *
         * @return boolean
         */
        private function isUserComeBack($request) {
            $cacheKey = 'facebook_ligue1_201213_is_user_comme_back';
            $result = sfMemcache::getInstance()->get($cacheKey, '');
            if ($result == '') {
                $roomData = $this->getRoomByName($request, sfConfig::get('mod_facebook_ligue1_2012_room_associate_name'));
                $room_uuid = $roomData['uuid'];
                $params = array('uuid' => $room_uuid);
                $kupsData = $this->getRoomKups($request, $params);

                $count = 0;
                foreach ($kupsData as $kupData) {
                    if ($kupData['is_participant'] == 1) {
                        $count++;
                    }
                }
                if ($count >= 2) {
                    $result = true;
                    sfMemcache::getInstance()->set($cacheKey, $result);
                }
            }
            if ($result == '') {
                $result = false;
            }
            return $result;
        }

        /**
         *  Display the how to box
         */
        public function executeHomeHowTo() {

        }

        /**
         *  Display the Betkup Promo box
         */
        public function executeHomeBetkupPromo() {

        }

        /**
         *  Display the Friends box
         */
        public function executeHomeFriends() {

        }

        /**
         *  Display the popup for club choosing
         */
        public function executePopupClubs() {

            $this->teamList = BetkupLigue1::getLigue1ClubsBindings();
        }

        /**
         *  Display the footer
         */
        public function executeFooter(sfWebRequest $request) {

            $this->inviteFriends = $request->getParameter('inviteFriend', 0);
            $this->messageInviteRequest = $this->getContext()->getI18n()->__('text_facebook_ligue1_2012_home_publish_message');
        }

        /**
         *  Display the menu
         */
        public function executeMenu() {
            $this->clubLogo = '';
            $clubs = BetkupLigue1::getLigue1ClubsBindings();
            $clubUser = $this->getUser()->getAttribute('clubBindingName', '', 'subscriber');
            foreach ($clubs as $club) {
                if ($clubUser == $club['betkup_room_name']) {
                    $this->clubLogo = $club['avatar_small'];
                    break;
                }
            }
        }


    }

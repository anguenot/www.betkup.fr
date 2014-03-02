<?php

    /**
     * Member account components.
     *
     * @package    betkup.fr
     * @subpackage account
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: components.class.php 6132 2012-09-13 09:17:18Z jmasmejean $
     */
    class accountComponents extends sfComponents {

        public function executeMyaccount() {

        }

        public function executeInfo() {
            $this->countries = Data::ISOCountries();
            $this->oldCountryId = '';
            foreach ($this->countries as $key => $country) {
                if ($this->monComptePays == $country) {
                    $this->monComptePays = $key;
                    $this->oldCountryId = $key;
                    break;
                }
            }

            // Properties must to be sent out to ARJEL sensor for XML Trace generation (MODIFINFOPERSO)
            // Only if account type is gambling
            if ($this->getUser()->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr')) {
                $this->userEmail = $this->getUser()->getAttribute('email', '', 'subscriber');
            }
            else {
                $this->userEmail = "";
            }

            $this->userFirstName = $this->getUser()->getAttribute('firstName', '', 'subscriber');
            $this->userLastName = $this->getUser()->getAttribute('lastName', '', 'subscriber');
            $this->userNickName = $this->getUser()->getAttribute('nickName', '', 'subscriber');
            $this->userTitle = $this->getUser()->getAttribute('title', '', 'subscriber');
            $this->userAddress = $this->getUser()->getAttribute('address_street', '', 'subscriber');
            $this->userZip = $this->getUser()->getAttribute('address_zip', '', 'subscriber');
            $this->userCountry = $this->getUser()->getAttribute('address_country', '', 'subscriber');
            $this->userCity = $this->getUser()->getAttribute('address_city', '', 'subscriber');
        }

        public function executeCheckbox() {

        }

        public function executeLeft() {

        }

        public function executeCreateAccountOnHome() {
            $this->form = new createForm();
        }

        public function executeMenu() {

        }

        public function executeTitle() {
            if (!isset($this->area)) {
                $this->area = "";
            }
            if (!isset($this->startY)) {
                $this->startY = "0";
            }
            if (!isset($this->height)) {
                $this->height = 67 + $this->startY;
            }
        }

        public function executeClose() {

        }

        public function executeBank() {

            $this->userEmail = $this->getUser()->getAttribute('email', '', 'subscriber');

        }

        /**
         * Displays sub-nav menu within Room and Kup.
         *
         * @param sfWebRequest $request
         */
        public function executeNavigation(sfWebRequest $request) {

            $this->module = $request->getParameter('module');
            $this->action = $request->getParameter('action');

            $kupActionArray = array(
                'predictionFixtures', 'predictionKnockout', 'view', 'ranking', 'results', 'news',
                'rules', 'bet', 'inviteFriends'
            );
            $roomActionArray = array(
                'view', 'edit', 'members', 'kups', 'kup', 'invite', 'roomKupsRanking', 'kupsNews', 'kupRanking', 'kupResults', 'kupRules', 'kupBet'
            );
            $challengeActionArray = array();

            if ($this->module == "kup" && !in_array($this->action, $kupActionArray)) {
                $this->excludedKupAction = true;
            }
            else {
                $this->excludedKupAction = false;
            }

            if ($this->module == "room" && !in_array($this->action, $roomActionArray)) {
                $this->excludedRoomAction = true;
            }
            else {
                $this->excludedRoomAction = false;
            }

            if ($this->module == "challenge" && !in_array($this->action, $challengeActionArray)) {
                $this->excludedChallengeAction = true;
            }
            else {
                $this->excludedChallengeAction = false;
            }

            if (!isset($this->marginHeight)) {
                $this->marginHeight = 18;
            }

        }

        public function executeCreditForm($request) {

            // We need to add this to the form as hidden values to be able to trace it sensor side.
            $this->userCreditBefore = $this->getUser()->getAttribute('credit', '', 'subscriber');
            $this->userEmail = $this->getUser()->getAttribute('email', '', 'subscriber');

            // Show (or not) the bonus box if the player register date is minus than 10 days.
            $this->accountDate = substr($this->getUser()->getAttribute('policyAcceptanceDate', '', 'subscriber'), 0, 10);
            $this->maxDay = 10;
            $today = time();
            $this->effectivesDays = util::diffDate($this->accountDate, $today);
            $this->daysRemaining = ($this->maxDay + 1) - $this->effectivesDays;
        }

    }
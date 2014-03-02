<?php

    /**
     * Member account actions.
     *
     * <p/>
     * See config/security.yml for module security settings. All actions needs to be
     * protected unless necessary.
     *
     * <p/>
     * This module does not and shall not contain any admin related actions: only
     * member related account management actions.
     *
     * @package    betkup.fr
     * @subpackage account
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: actions.class.php 6536 2012-11-21 04:23:25Z anguenot $
     */
    class accountActions extends betkupActions {

        /**
         * Edit a single member field.
         *
         * @param sfWebRequest $request
         */
        public function executeEditField($request) {

            $cerror = 202;
            $check = true;
            $errorMsg = '';

            $this->sofun = BetkupWrapper::_getSofunApp($request, $this);
            $params = array(
                'communityId' => sfConfig::get('app_sofun_community_id'),
                'email'       => $this->getUser()->getAttribute('email', '', 'subscriber'),
            );

            $parameters = $request->getParameterHolder()->getAll(null);

            switch ($parameters['formName']) {
                case 'editInfosForm' :

                    $civility = 'M';
                    if (isset($parameters['edit']['monCompteCivility'])) {
                        $civility = $parameters['edit']['monCompteCivility'];
                    }
                    $parameters['title'] = $civility;
                    $params['firstName'] = $parameters['monComptePrenom'];
                    $params['lastName'] = $parameters['monCompteNom'];

                    if ($parameters['title'] == 'M') {
                        $params['title'] = 'MR';
                        $params['gender'] = '0';
                    }
                    else if ('Mme' == $parameters['title']) {
                        $params['title'] = 'MS';
                        $params['gender'] = '1';
                    }
                    else if ('Mlle' == $parameters['title']) {
                        $params['title'] = 'MRS';
                        $params['gender'] = '1';
                    }
                    $parameters['titleEn'] = $params['title'];

                    if ($this->getUser()->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr')) {
                        $params['street'] = $parameters['monCompteAdresse'];
                    }

                    if (!isset($params['title']) || $params['title'] == '') {
                        $check = false;
                        $errorMsg = $this->getContext()->getI18n()->__("account_registerAdvanced_accountCivilite_messageError_text");
                    }

                    if ($params['firstName'] == '' || $params['lastName'] == '') {
                        $check = false;
                        $errorMsg = $this->getContext()->getI18n()->__("text_editfield_empty_fields");
                    }
                    else if ($this->getUser()->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr') && $params['street'] == '') {
                        $check = false;
                        $errorMsg = $this->getContext()->getI18n()->__("text_editfield_empty_fields");
                    }

                    if ($this->getUser()->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr')) {

                        // City zipcode case
                        $splitCityZipCode = explode(' (', $parameters['monCompteVille']);

                        if (count($splitCityZipCode) == 2 && $parameters['information']['accountCountry'] == 'FR') {
                            $params['zip'] = str_replace(')', '', $splitCityZipCode[1]);
                            if (!preg_match('#[0-9]{5}#', $params['zip'])) {
                                $errorMsg = $this->getContext()->getI18n()->__("text_editfield_valid_city_zipcode");
                                $check = false;
                            }
                            $params['city'] = $splitCityZipCode[0];
                            $parameters['monCompteCodepostal'] = $params['zip'];

                        }
                        else if ($parameters['information']['accountCountry'] != 'FR') {
                            $params['zip'] = $parameters['monCompteCodepostal'];
                            $params['city'] = $parameters['monCompteVille'];
                        }

                        if (!isset($params['city'])) {
                            $check = false;
                            $errorMsg = $this->getContext()->getI18n()->__("text_editfield_valid_city");
                        }
                        if ($params['zip'] == '' || !preg_match("<^(([0-8][0-9AB])|(9[0-8AB]))[0-9]{3}$>", $params['zip'])) {
                            $errorMsg = $this->getContext()->getI18n()->__("text_register_error_zipcode_not_match_constraint");
                            $check = false;
                        }

                        // Country case
                        $this->countries = Data::ISOCountries();
                        foreach ($this->countries as $key => $country) {
                            if ($parameters['information']['accountCountry'] == $key) {
                                $params['country'] = $country;
                                $parameters['countryName'] = $country;
                                $parameters['countryId'] = $key;
                                break;
                            }
                        }
                    }

                    break;
                case 'editAccountForm' :
                    // NickName case
                    $params['pseudo'] = $parameters['monComptePseudo'];

                    $resp = $this->sofun->api_GET("/member/pseudo/exists/" . urlencode($params['pseudo']));

                    if (!preg_match("<^[0-9A-Za-zÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸàâäçéèêëîïôöùûüÿÆŒæœ€#$'()*+,./:;=?!@_ -]*$>", $params['pseudo'])) {
                        $errorMsg = $this->getContext()->getI18n()->__("text_register_error_pseudo_not_match_constraint");
                        $check = false;
                    }
                    else if ($resp["http_code"] != "202") {

                    }
                    else {
                        $errorMsg = $this->getContext()->getI18n()->__("text_register_pseudo_already_exist");
                        $check = false;
                    }
                    break;
                case 'editBankForm' :
                    $params['ribBank'] = $parameters['ribBank'];
                    $params['ribBranch'] = $parameters['ribBranch'];
                    $params['ribNumber'] = $parameters['ribNumber'];
                    $params['ribKey'] = $parameters['ribKey'];

                    $rib = $params['ribBank'] . $params['ribBranch'] . $params['ribNumber'] . $params['ribKey'];

                    $params['ibanNumber'] = $parameters['ibanNumber'];
                    $params['ibanSwift'] = $parameters['ibanSwift'];

                    $iban = $params['ibanNumber'];
                    $bic = $params['ibanSwift'];

                    $params['maxAmountBetWeekly'] = $parameters['maxAmountBetWeekly'];
                    $params['maxAmountCreditWeekly'] = $parameters['maxAmountCreditWeekly'];

                    if ($rib != '' && !Bank::isValidRib($rib)) {
                        $errorMsg = $this->getContext()->getI18n()->__("label_rib_invalid");
                        $check = false;
                    }
                    else if ($iban != null && !Bank::isValidIBAN($iban)) {
                        $errorMsg = $this->getContext()->getI18n()->__("label_iban_invalid");
                        $check = false;
                    }
                    else if ($bic != null && !Bank::isValidBIC($bic)) {
                        $errorMsg = $this->getContext()->getI18n()->__("label_bic_invalid");
                        $check = false;
                    }
                    else if ($iban == '' && $rib == '') {
                        $errorMsg = $this->getContext()->getI18n()->__("label_iban_and_rib_null");
                        $check = false;
                    }
                    else if (!preg_match("/^[0-9]+$/", $params['maxAmountCreditWeekly']) || !preg_match("/^[0-9]+$/", $params['maxAmountBetWeekly'])) {
                        $errorMsg = $this->getContext()->getI18n()->__("label_limit_values_invalid");
                        $check = false;
                    }
                    else if (intval($params['maxAmountCreditWeekly']) > intval(sfConfig::get('mod_account_limit_weekly_bets'))) {
                        $errorMsg = $this->getContext()->getI18n()->__("label_limit_weekly_bets_invalid");
                        $check = false;
                    }
                    else if (intval($params['maxAmountBetWeekly']) > intval(sfConfig::get('mod_account_limit_weekly_credit'))) {
                        $errorMsg = $this->getContext()->getI18n()->__("label_limit_weekly_credit_invalid");
                        $check = false;
                    }
                    break;
            }

            if ($check == true) {
                $response = $this->sofun->api_POST("/member/edit", $params);
                $cerror = $response['http_code'];
                if ($cerror != 202) {
                    $errorMsg = $this->getContext()->getI18n()->__("text_register_edit_generic_error");
                }
                else {
                    // Update USER object
                    if ($parameters['formName'] == 'editInfosForm') {

                        $this->getUser()->setAttribute('title', $params['title'], 'subscriber');
                        $this->getUser()->setAttribute('firstName', $params['firstName'], 'subscriber');
                        $this->getUser()->setAttribute('lastName', $params['lastName'], 'subscriber');

                        if ($this->getUser()->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr')) {
                            $this->getUser()->setAttribute('address_street', $params['street'], 'subscriber');
                            $this->getUser()->setAttribute('address_zip', $params['zip'], 'subscriber');
                            $this->getUser()->setAttribute('address_country', $params['country'], 'subscriber');
                            $this->getUser()->setAttribute('address_city', $params['city'], 'subscriber');
                        }
                    }
                    else if ($parameters['formName'] == 'editAccountForm') {

                        $this->getUser()->setAttribute('nickName', $params['pseudo'], 'subscriber');
                    }
                    else if ($parameters['formName'] == 'editBankForm') {

                        $this->getUser()->setAttribute('max_amount_bet_weekly', $params['maxAmountBetWeekly'], 'subscriber');
                        $this->getUser()->setAttribute('max_amount_credit_weekly', $params['maxAmountCreditWeekly'], 'subscriber');
                    }
                }
                // Notify ARJEL sensor
                $this->setSensorOperationSuccessStatus();

                $return = array("query" => $parameters, "http_code" => $cerror, 'msg' => $errorMsg);
            }
            else {
                // Return 400 if the validation did not pass.
                $return = array("http_code" => '400', 'msg' => $errorMsg);
            }

            return $this->renderText(json_encode($return));
        }

        /**
         * Simple member registration.
         *
         * <p />
         *
         * Method is unprotected and available to anonymous users. It requires extra
         * attention.
         *
         * @param sfWebRequest $request
         */
        public function executeRegister($request) {

            //
            // If user is already logged in then redirect to his account
            //

            if ($this->getUser()->isAuthenticated()) {
                $this->redirect('@dashboard');
            }

            $urls = $this->getCguRuleUrls();

            $this->cguUrl = $urls["cguUrl"];
            $this->rulesUrl = $urls["ruleUrl"];

            //
            // Form variables initialization
            //

            $this->form = new connexionForm();

            if ($request->isMethod('post')) {
                $this->accountLastname = $_POST["information"]["accountLastname"];
                $this->accountFirstname = $_POST["information"]["accountFirstname"];
                $this->accountEmail = $_POST["information"]["accountEmail"];
            }
            else {
                $this->accountLastname = "";
                $this->accountFirstname = "";
                $this->accountEmail = "";
            }

            $this->accountPseudo = "";
            $this->accountBirthdate_1 = date("d");
            $this->accountBirthdate_2 = date("m");
            $this->accountBirthdate_3 = date("Y");
            $this->accountPassword = "";
            $this->accountConfirmation = "";

            //
            // Recaptcha
            //

            $this->recaptcha_response_field = "";
            $privatekey = sfConfig::get('app_recaptcha_private_key');
            require_once('recaptchalib.php');

            //
            // Below are for the 3 birth dates form fields
            //

            $this->blocChoices1 = array();
            for ($i = 1; $i <= 31; $i++) {
                $this->blocChoices1[] = sprintf("%02d", $i);
            }

            $this->blocChoices2 = array();
            for ($i = 1; $i <= 12; $i++) {
                $this->blocChoices2[] = sprintf("%02d", $i);
            }

            $this->blocChoices3 = array();
            for ($i = date("Y") - sfConfig::get('mod_account_registration_simple_age') + 1; $i >= date("Y") - 77; $i--) {
                $this->blocChoices3[] = sprintf("%02d", $i);
            }

            $pathInfo = $request->getPathInfoArray();
            if ($request->isMethod('post') && @eregi("account/register", $pathInfo["HTTP_REFERER"])) {

                //
                // Get values from POST
                //

                $this->information = $request->getParameter('information');

                $this->accountLastname = $this->information["accountLastname"];
                $this->accountFirstname = $this->information["accountFirstname"];
                $this->accountPseudo = $this->information["accountPseudo"];
                $this->accountBirthdate_1 = $this->information["accountBirthdate_1"];
                $this->accountBirthdate_2 = $this->information["accountBirthdate_2"];
                $this->accountBirthdate_3 = $this->information["accountBirthdate_3"];
                $this->accountEmail = $this->information["accountEmail"];
                $this->accountPassword = $this->information["accountPassword"];
                $this->accountConfirmation = $this->information["accountConfirmation"];

                if (isset($this->information["recaptcha_response_field"])) {
                    $this->recaptcha_response_field = $this->information["recaptcha_response_field"];
                }
                else {
                    $this->recaptcha_response_field = "";
                }


                //
                // Check date of birth: above a certain tage required. See app.yml for values
                //
                if (!preg_match("<^[0-9A-Za-zÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸàâäçéèêëîïôöùûüÿÆŒæœ€#$'()*+,./:;=?!@_ -]*$>", $this->accountPseudo)) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_error_pseudo_not_match_constraint"));
                }
                else if (Util::age($this->accountBirthdate_3 . '-' . $this->accountBirthdate_2 . '-' . $this->accountBirthdate_1) < sfConfig::get('mod_account_registration_advanced_age')) {
                    $this->getUser()->setFlash('error', 'L\'age minimum pour vous inscrire est ' . sfConfig::get('mod_account_registration_simple_age') . ' ans');
                }
                else {

                    //
                    // Verify the choosen pseudo is not already in use.
                    //

                    $this->sofun = BetkupWrapper::_getSofunApp($request, $this);
                    $resp = $this->sofun->api_GET("/member/pseudo/exists/" . $this->accountPseudo);
                    if ($resp["http_code"] == "202") {
                        $this->getUser()->setFlash('error', 'Votre pseudo est déjà utilisé');
                    }
                    else {

                        //
                        // Verify the choosen email is not already in use.
                        //
                        // XXX catch Sofun exception
                        $resp = $this->sofun->api_GET("/member/email/exists/" . $this->accountEmail);
                        if ($resp["http_code"] == "202") {
                            $this->getUser()->setFlash('error', 'Votre email est déjà utilisé');
                        }
                        else {
                            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                            if (!$resp->is_valid) {
                                $this->getUser()->setFlash('error', "Le texte entrée pour la captcha n'est pas valide.");
                            }
                            else {

                                $hash_algo = sfConfig::get('app_crypto_password_hash');

                                $params = array(
                                    'communityId'    => sfConfig::get('app_sofun_community_id'),
                                    'account_type'   => sfConfig::get('mod_account_registration_account_type_simple'),
                                    'account_status' => sfConfig::get('mod_account_registration_account_status_confirmed'),
                                    'lastName'       => $this->accountLastname,
                                    'givenName'      => $this->accountFirstname,
                                    'pseudo'         => $this->accountPseudo,
                                    'birthYear'      => $this->accountBirthdate_3,
                                    'birthMonth'     => $this->accountBirthdate_2,
                                    'birthDay'       => $this->accountBirthdate_1,
                                    'email'          => $this->accountEmail,
                                    'password'       => hash($hash_algo, $this->accountPassword),
                                    'trackingCode'   => $this->getTrackingCode(),
                                );

                                try {
                                    $rep = $this->sofun->api_POST("/member/register", $params);
                                } catch (SofunApiException $e) {
                                    error_log($e);
                                }

                                if ($rep['http_code'] == '202') {
                                    // Member authentification after account creation
                                    $sofun_member = $rep['buffer'];
                                    BetkupWrapper::_setSofunSession($this->sofun->getSession(), $this);
                                    $this->_postLogin($request, $sofun_member);

                                    // Specify to tracking filter that the registration has succeed.
                                    $this->getUser()->setAttribute(sfConfig::get('app_tracking_filter_registration_simple_complete'), 'success', 'tracking_filter');

                                    $this->setCustomFlashActions($request, 'flash_message_create_account_success');
                                    $this->redirectIfLoginSuccess('@dashboard', 302, 200);
                                }
                                else {
                                    $this->getUser()->setFlash('error', $rep["buffer"] . " - " . $rep["http_code"]);
                                }
                            }
                        }
                    }
                }
                $this->accountPassword = '';
                $this->accountConfirmation = '';
            }
        }

        /**
         * Advanced registration form initialization.
         *
         * @see executeRegisterAdvanced
         * @see executeUpdateSimpleAccount
         *
         * @param sfWebRequest $request
         */
        protected function _initAdvancedRegistrationForm($request) {

            /**
             * Form variables initialization
             */
            $this->isUpgrade = 0;

            $this->information_accountCivilite = "M";
            $this->information_accountLastname = "";
            $this->information_accountFirstname = "";
            $this->information_accountAdresse = "";
            $this->information_accountCodezip = "";
            $this->information_accountCity = "";
            $this->information_accountCountry = "FR";

            $this->personal_accountBirthdate_1 = date("d");
            $this->personal_accountBirthdate_2 = date("m");
            $this->personal_accountBirthdate_3 = date("Y");
            $this->personal_accountBirthcountry = "FR";
            $this->personal_accountBirthregion = "";
            $this->personal_accountBirthplace = "";

            $this->login_accountPseudo = "";
            $this->login_accountEmail = "";
            $this->login_accountPassword = "";
            $this->login_accountConfirmation = "";

            $this->choiceRIB_IBAN = 'RIB';

            $this->gold_accountRib_1 = "";
            $this->gold_accountRib_2 = "";
            $this->gold_accountRib_3 = "";
            $this->gold_accountRib_4 = "";

            $this->gold_accountLimiteDeDepot = "";
            $this->gold_depotPerso = '0';
            $this->gold_accountLimiteDeMise = "";
            $this->gold_misePerso = '0';

            //RIB information
            $this->gold_accountCodeBank = "";
            $this->gold_accountCodeGuichet = "";
            $this->gold_accountNumAccount = "";
            $this->gold_accountKeyRIB = "";

            //IBAN information
            $this->gold_accountSwift = "";
            $this->gold_accountIban = "";

            $this->gold_accountDepotLimit = "";
            $this->gold_accountMiseLimit = "";

            $this->gold_accountLimiteDepotPerso = "";
            $this->gold_accountLimiteMisePerso = "";

            /**
             * Recaptcha
             */
            $this->recaptcha_response_field = "";
            $this->privatekey = sfConfig::get('app_recaptcha_private_key');
            require_once('recaptchalib.php');

            /**
             * Load countries and French departement from files.
             */
            $this->allCountries = Data::ISOCountries();

            /**
             * Load RIB Limit
             */
            $this->ribLimit = Data::ribLimit();

            /**
             * Blacklister the countries specified in app.yml
             */
            $this->countries = array();
            $this->allCountriesReSize = array();
            foreach ($this->allCountries as $key => $country) {
                if (strlen($country) > 30) {
                    $this->allCountriesReSize[$key] = substr($country, 0, 30) . '...';
                }
                else {
                    $this->allCountriesReSize[$key] = $country;
                }
                if (!in_array($country, sfConfig::get('mod_account_registration_black_countries'))) {
                    if (strlen($country) > 30) {
                        $this->countries[$key] = substr($country, 0, 30) . '...';
                    }
                    else {
                        $this->countries[$key] = $country;
                    }
                }
            }

            $this->allCountries = $this->allCountriesReSize;

            /**
             * Below are for the 3 birth dates form fields
             */
            $this->blocChoices1 = array();
            for ($i = 1; $i <= 31; $i++) {
                $this->blocChoices1[] = sprintf("%02d", $i);
            }

            $this->blocChoices2 = array();
            for ($i = 1; $i <= 12; $i++) {
                $this->blocChoices2[] = sprintf("%02d", $i);
            }

            $this->blocChoices3 = array();
            for ($i = date("Y") - (sfConfig::get('mod_account_registration_advanced_age') - 1); $i >= date("Y") - 77; $i--) {
                $this->blocChoices3[] = sprintf("%02d", $i);
            }
        }

        /**
         * Advanced registration form POST.
         *
         * @see executeRegisterAdvanced
         * @see executeUpdateSimpleAccount
         *
         * @param sfWebRequest $request
         */
        protected function _postAdvancedRegistrationForm($request) {

            //
            // Initialize vars from POST request.
            //

            $this->data = array();
            $this->data["information"] = $request->getParameter('information');
            $this->data["personal"] = $request->getParameter('personal');
            $this->data["login"] = $request->getParameter('login');
            $this->data["gold"] = $request->getParameter('gold');
            $this->data["accept"] = $request->getParameter('accept');

            $this->information_accountCivilite = $this->data["information"]["accountCivilite"];

            //
            // Member gender
            //

            $this->gender = 0; // male
            if ('Mme' == $this->information_accountCivilite || 'Mlle' == $this->information_accountCivilite) {
                $this->gender = 1;
            }

            //
            // Member title

            $this->title = 'MR';
            if ('Mme' == $this->information_accountCivilite) {
                $this->title = 'MRS';
            }
            else if ('Mlle' == $this->information_accountCivilite) {
                $this->title = 'MS';
            }

            if ($this->isUpgrade == 1) {
                $this->information_isUpgrade = 1;
            }
            else {
                $this->information_isUpgrade = $this->data["information"]["isUpgrade"];
                if ($this->information_isUpgrade == 1) {
                    $this->information_isUpgrade = 1;
                }
                else {
                    $this->information_isUpgrade = 0;
                }
            }

            // Get all required fields. Prompt an error if empty.
            $requiredFields = array(
                $this->data["information"]["accountCity"],
                $this->data["personal"]["accountBirthplace"],
                $this->data["personal"]["accountBirthdate_1"],
                $this->data["personal"]["accountBirthdate_2"],
                $this->data["personal"]["accountBirthdate_3"],
                $this->data["personal"]["accountBirthcountry"],
                $this->data["information"]["accountCountry"],
                $this->data["information"]["accountLastname"],
                $this->data["information"]["accountFirstname"]
            );
            $fieldsEmpty = false;
            foreach ($requiredFields as $fields) {
                if ($fields == '') {
                    $fieldsEmpty = true;
                }
            }

            // Format city, zipcode, department to match INSEE legislation
            $departments = Data::departments();
            $cities = Data::cities();
            $zipError = false;
            $informationCityError = true;
            $personalCityError = true;

            // Need city format => CITY_NAME (zipcode)
            if ($this->data["personal"]["accountBirthcountry"] == 'FR') {
                $splitPersonalCityZipcode = explode(' (', $this->data["personal"]["accountBirthplace"]);

                if (count($splitPersonalCityZipcode) >= 2) {
                    $personalCity = $splitPersonalCityZipcode[0];
                    $personalZipcode = str_replace(')', '', $splitPersonalCityZipcode[1]);

                    foreach ($cities as $city) {
                        if ($city['name'] == $personalCity) {
                            $personalCityError = false;
                            break;
                        }
                    }

                    if (!preg_match('#[0-9]{5}#', $personalZipcode)) {
                        $zipError = true;
                    }
                }
                else {
                    $zipError = true;
                }
            }
            else {
                $personalCity = $this->data["personal"]["accountBirthplace"];
                $personalZipcode = '';
                $personalCityError = false;
            }

            if ($this->data["information"]["accountCountry"] == 'FR') {
                $splitInformationCityZipcode = explode(' (', $this->data["information"]["accountCity"]);

                if (count($splitInformationCityZipcode) >= 2) {
                    $informationCity = $splitInformationCityZipcode[0];
                    $informationZipcode = str_replace(')', '', $splitInformationCityZipcode[1]);

                    foreach ($cities as $city) {
                        if ($city['name'] == $informationCity) {
                            $informationCityError = false;
                            break;
                        }
                    }

                    if (!preg_match('#[0-9]{5}#', $informationZipcode)) {
                        $zipError = true;
                    }
                }
                else {
                    $zipError = true;
                }
            }
            else {
                $informationCity = $this->data["information"]["accountCity"];
                $informationZipcode = '';
                $informationCityError = false;
            }

            $this->information_accountLastname = $this->data["information"]["accountLastname"];
            $this->information_accountFirstname = $this->data["information"]["accountFirstname"];

            if ($this->login_accountPseudo == '') {
                $this->login_accountPseudo = $this->data["information"]["accountPseudo"];
            }

            $this->information_accountAdresse = $this->data["information"]["accountAdresse"];
            $this->information_accountCodezip = $this->data["information"]["accountCodezip"];
            $this->information_accountCity = $this->data["information"]["accountCity"];
            $this->information_accountCountry = $this->data["information"]["accountCountry"];

            $this->personal_accountBirthdate_1 = $this->data["personal"]["accountBirthdate_1"];
            $this->personal_accountBirthdate_2 = $this->data["personal"]["accountBirthdate_2"];
            $this->personal_accountBirthdate_3 = $this->data["personal"]["accountBirthdate_3"];

            if ($this->data["personal"]["accountBirthcountry"] == 'FR') {
                $personal_accountBirthregion = $this->data["personal"]["accountBirthregion"];
            }
            else {
                $personal_accountBirthregion = '99';
            }
            $this->personal_accountBirthcountry = $this->data["personal"]["accountBirthcountry"];
            $this->personal_accountBirthregion = $personal_accountBirthregion;
            $this->personal_accountBirthplace = $this->data["personal"]["accountBirthplace"];

            // If the member is upgrading from a simple to a gambling account the following values will be already initialized
            // from session

            if ($this->login_accountEmail == '') {
                $this->login_accountEmail = $this->data["login"]["accountEmail"];
            }

            $hash_algo = sfConfig::get('app_crypto_password_hash');

            if ($this->login_accountPassword == '') {
                $this->login_accountPassword = hash($hash_algo, $this->data["login"]["accountPassword"]);
            }

            if ($this->login_accountConfirmation == '') {
                $this->login_accountConfirmation = hash($hash_algo, $this->data["login"]["accountConfirmation"]);
            }

            // Choice RIB or IBAN

            $this->choiceRIB_IBAN = $this->data["gold"]["accountRib"];

            // RIB

            $this->gold_accountRib_1 = $this->data["gold"]["accountCodeBank"];
            $this->gold_accountRib_2 = $this->data["gold"]["accountCodeGuichet"];
            $this->gold_accountRib_3 = $this->data["gold"]["accountNumAccount"];
            $this->gold_accountRib_4 = $this->data["gold"]["accountKeyRIB"];

            $rib = $this->gold_accountRib_1 . $this->gold_accountRib_2 . $this->gold_accountRib_3 . $this->gold_accountRib_4;

            // IBAN
            $this->gold_accountIban_1 = $this->data["gold"]["accountSwift"];
            $this->gold_accountIban_2 = $this->data["gold"]["accountIban"];

            $iban = $this->gold_accountIban_2;
            $bic = $this->gold_accountIban_1;

            // User defined limit
            if ($this->data["gold"]["accountDepotLimit"] == '1') {
                $this->gold_accountLimiteDeDepot = $this->data["gold"]["accountLimiteDepotPerso"];
                $this->gold_depotPerso = '1';
            }
            else {
                $this->gold_accountLimiteDeDepot = $this->data["gold"]["accountDepotLimit"];
                $this->gold_depotPerso = '0';
            }

            if ($this->data["gold"]["accountMiseLimit"] == '1') {
                $this->gold_accountLimiteDeMise = $this->data["gold"]["accountLimiteMisePerso"];
                $this->gold_misePerso = '1';
            }
            else {
                $this->gold_accountLimiteDeMise = $this->data["gold"]["accountMiseLimit"];
                $this->gold_misePerso = '0';
            }
            $this->recaptcha_response_field = $this->information["recaptcha_response_field"];

            // First validation

            if ($zipError) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_error_zipcode"));
                return;
            }
            if ($informationCityError) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_error_information_city"));
                return;
            }
            if ($personalCityError) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_error_personal_city"));
                return;
            }
            if ($fieldsEmpty) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_error"));
                return;
            }
            if (!preg_match("<^[0-9A-Za-zÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸàâäçéèêëîïôöùûüÿÆŒæœ€#$'()*+,./:;=?!@_ -]*$>", $this->login_accountPseudo)) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_error_pseudo_not_match_constraint"));
                return;
            }
            if (!preg_match("<^(([0-8][0-9AB])|(9[0-8AB]))[0-9]{3}$>", $this->information_accountCodezip)) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_error_zipcode_not_match_constraint"));
                return;
            }
            if ($this->data["personal"]["accountBirthcountry"] == 'FR') {

                if (!isset($departments[$this->data["personal"]["accountBirthregion"]]) || $departments[$this->data["personal"]["accountBirthregion"]] == '') {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_error_department"));
                    return;
                }
                else {
                    $personal_accountBirthregion = $departments[$this->data["personal"]["accountBirthregion"]];
                }
            }
            else {
                $personal_accountBirthregion = '99';
            }
            //
            // Final validation before submitting to gaming platform.
            //

            if (Util::age($this->personal_accountBirthdate_3 . '-' . $this->personal_accountBirthdate_2 . '-' . $this->personal_accountBirthdate_1) < sfConfig::get('mod_account_registration_advanced_age')) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_require_age", array('%age%' => sfConfig::get('mod_account_registration_advanced_age'))));
            }
            else if ($rib != '' && !Bank::isValidRib($rib)) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("label_rib_invalid"));
            }
            else if ($iban != null && !Bank::isValidIBAN($iban)) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("label_iban_invalid"));
            }
            else if ($bic != null && !Bank::isValidBIC($bic)) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("label_bic_invalid"));
            }
            else if ($iban == '' && $rib == '') {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("label_iban_and_rib_null"));
            }
            else if (!preg_match("/^[0-9]+$/", $this->gold_accountLimiteDeDepot) || !preg_match("/^[0-9]+$/", $this->gold_accountLimiteDeMise)) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("label_limit_values_invalid"));
            }
            else if (intval($this->gold_accountLimiteDeDepot) > intval(sfConfig::get('mod_account_limit_weekly_bets'))) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("label_limit_weekly_bets_invalid"));
            }
            else if (intval($this->gold_accountLimiteDeMise) > intval(sfConfig::get('mod_account_limit_weekly_credit'))) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("label_limit_weekly_credit_invalid"));
            }
            else {

                $this->sofun = BetkupWrapper::_getSofunApp($request, $this);
                try {
                    $resp = $this->sofun->api_GET("/member/pseudo/exists/" . urlencode($this->accountPseudo));
                } catch (SofunApiException $e) {
                    error_log($e);
                    $this->getUser()->setFlash('error', $e);
                }

                if ($resp["http_code"] == "202" && $this->information_isUpgrade != 1) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_pseudo_already_exist"));
                }
                else {

                    // Check if email already exists.
                    try {
                        $resp = $this->sofun->api_GET("/member/email/exists/" . $this->login_accountEmail);
                    } catch (SofunApiException $e) {
                        $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_email_already_exist"));
                    }

                    if ($resp["http_code"] == "202" && $this->information_isUpgrade != 1) {
                        $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_email_already_exist"));
                    }
                    else {

                        $resp = recaptcha_check_answer($this->privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                        if (!$resp->is_valid) {
                            $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("text_register_not_human"));
                        }
                        else {

                            $allCountries = Data::ISOCountries();
                            $params = array(
                                // Basic information

                                'isUpgrade'             => $this->information_isUpgrade,
                                'communityId'           => sfConfig::get('app_sofun_community_id'),
                                'account_type'          => sfConfig::get('mod_account_registration_account_type_gambling_fr'),
                                'account_status'        => sfConfig::get('mod_account_registration_account_status_confirmed'),
                                'lastName'              => $this->information_accountLastname,
                                'givenName'             => $this->information_accountFirstname,
                                'pseudo'                => $this->login_accountPseudo,
                                'birthYear'             => $this->personal_accountBirthdate_3,
                                'birthMonth'            => $this->personal_accountBirthdate_2,
                                'birthDay'              => $this->personal_accountBirthdate_1,
                                'email'                 => $this->login_accountEmail,
                                'password'              => $this->login_accountPassword,
                                // Advanced information.

                                'gender'                => $this->gender,
                                'title'                 => $this->title,
                                'street'                => $this->information_accountAdresse,
                                'zip'                   => $this->information_accountCodezip,
                                'city'                  => $informationCity,
                                'state'                 => $allCountries[$this->information_accountCountry],
                                'birthCountry'          => $allCountries[$this->personal_accountBirthcountry],
                                'birthPlace'            => $personalCity,
                                'birthArea'             => $personal_accountBirthregion,
                                'ribBank'               => $this->gold_accountRib_1,
                                'ribBranch'             => $this->gold_accountRib_2,
                                'ribNumber'             => $this->gold_accountRib_3,
                                'ribKey'                => $this->gold_accountRib_4,
                                'ibanNumber'            => $this->gold_accountIban_2,
                                'ibanSwift'             => $this->gold_accountIban_1,
                                'maxAmountBetWeekly'    => $this->gold_accountLimiteDeMise,
                                'maxAmountCreditWeekly' => $this->gold_accountLimiteDeDepot,
                                'trackingCode'          => $this->getTrackingCode(),
                            );

                            try {
                                $response = $this->sofun->api_POST("/member/register", $params);
                            } catch (SofunApiException $e) {
                                error_log($e);
                                $this->getUser()->setFlash('error', $e);
                            }

                            if ($response['http_code'] == '202') {

                                // Operation is successful we notify ARJEL sensor
                                $this->setSensorUpdateAccountOperationSuccessStatus();

                                $sofun_member = $response['buffer'];
                                BetkupWrapper::_setSofunSession($this->sofun->getSession(), $this);
                                $this->_postLogin($request, $sofun_member);

                                // Specify to tracking filter that the registration has succeed.
                                $this->getUser()->setAttribute(sfConfig::get('app_tracking_filter_registration_advanced_complete'), 'success', 'tracking_filter');

                                $room_uuid = $request->getParameter('room_uuid', '-1');

                                if ($this->information_isUpgrade != 1) {
                                    $this->setCustomFlashActions($request, 'flash_message_create_account_success', $room_uuid);
                                }
                                else {
                                    $this->setCustomFlashActions($request, 'flash_message_upgrade_account_success', $room_uuid);
                                }

                                $kup_uuid = $request->getParameter('kup_uuid', '-1');
                                // If the user upgrade his account from kup bet flow.
                                if ($kup_uuid != '-1' && $request->getParameter('parent_referer', '') != '') {

                                    if ($room_uuid == '-1') {
                                        $this->redirect(array(
                                                             'module'  => 'kup',
                                                             'action' => 'bet',
                                                             'uuid'    => $kup_uuid
                                                        ));
                                    }
                                    else {
                                        $this->redirect(array(
                                                             'module'    => 'room',
                                                             'action'    => 'kupBet',
                                                             'kup_uuid'  => $kup_uuid,
                                                             'room_uuid' => $room_uuid
                                                        ));
                                    }
                                }
                                // If the user is registering when coming from room actions. Use to redirect to "join room" action after register credit
                                if ($request->getParameter('redirect_route', '') == 'room_join') {
                                    $this->redirect('account_register_credit_room', array(
                                                                                         'redirect_route'  => 'room_join',
                                                                                         'room_uuid'       => $room_uuid
                                                                                    ));
                                } else if($request->getParameter('redirect_route', '') == 'room_auto_join') {
                                    if($room_uuid != '' && $room_uuid != '-1') {
                                        $this->joinRoom($request, $room_uuid);
                                    }

                                    $this->redirect(array(
                                                         'module'  => 'room',
                                                         'action'  => 'kup',
                                                         'room_uuid' => $room_uuid,
                                                         'kup_uuid' => $kup_uuid
                                                    ));
                                }

                                $this->redirect(array(
                                                     'module'  => 'account',
                                                     'action'  => 'registerCredit'
                                                ));
                            }
                            else {
                                error_log($response['buffer'] . '. Return error : ' . $response['http_code']);
                                $this->getUser()->setFlash('error', $response['buffer'] . '. Return error : ' . $response['http_code']);
                            }
                        }
                    }
                }
            }

        }

        /**
         * Member upgrades its account from a simple to a gambling one.
         *
         * @param sfWebRequest $request
         */
        public function executeUpdateSimpleAccount($request) {

            // If the logged user is already in gambling account, we redirect him.
            if ($this->getUser()->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr')) {
                $this->redirect('@dashboard');
            }

            $this->_initAdvancedRegistrationForm($request);
            $this->isUpgrade = 1;

            $urls = $this->getCguRuleUrls();

            $this->cguUrl = $urls["cguUrl"];
            $this->rulesUrl = $urls["ruleUrl"];

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            $member_email = $this->getUser()->getAttribute('email', '', 'subscriber');
            try {
                $response = $sofun->api_GET("/member/" . $member_email . "/properties");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            $arrayBirthDate = explode(" ", Util::displayDateChiffreFromTimestampComplet($response["buffer"]["birthDate"], false));
            if ($response['http_code'] == '202') {

                $this->information_accountLastname = $response["buffer"]["lastName"];
                $this->information_accountFirstname = $response["buffer"]["firstName"];
                $this->login_accountEmail = $response["buffer"]["email"];
                if ($response["buffer"]["nickName"] == '') {
                    $this->login_accountPseudo = $this->getUser()->getAttribute('subscriberId', '', 'subscriber');
                }
                else {
                    $this->login_accountPseudo = $response["buffer"]["nickName"];
                }
                $this->personal_accountBirthdate_1 = $arrayBirthDate[0];
                $this->personal_accountBirthdate_2 = $arrayBirthDate[1];
                $this->personal_accountBirthdate_3 = $arrayBirthDate[2];
                $this->login_accountPassword = $response["buffer"]["password"];
                $this->login_accountConfirmation = $response["buffer"]["password"];

            }
            else {
                $this->getUser()->setFlash('error', $response['buffer']);
            }

            if ($request->isMethod('post')) {
                $this->_postAdvancedRegistrationForm($request);
            }

            $this->setTemplate('registerAdvanced');
        }

        /**
         * Complex Member registration.
         *
         * <p />
         * Method is unprotected and available to anonymous users. It requires extra
         * attention.
         *
         *
         * @param sfWebRequest $request
         */
        public function executeRegisterAdvanced($request) {

            // If user is already logged in then redirect to his account
            if ($this->getUser()->isAuthenticated()) {
                $this->redirect('@dashboard');
            }

            $urls = $this->getCguRuleUrls();

            $this->cguUrl = $urls["cguUrl"];
            $this->rulesUrl = $urls["ruleUrl"];

            $this->_initAdvancedRegistrationForm($request);
            if ($request->isMethod('post')) {
                $this->_postAdvancedRegistrationForm($request);
            }
            $this->login_accountPassword = '';
            $this->login_accountConfirmation = '';
        }

        /**
         * Account default action.
         *
         * <p/>
         *
         * Redirects to edit actions. Only available to members.
         *
         * @param sfWebRequest $request
         */
        public function executeIndex($request) {
            $this->redirect(array('module' => 'account', 'action' => 'edit'));
        }

        /**
         * Edit member account.
         *
         * @see editField() for individual field updates.
         *
         * @param sfWebRequest $request
         */
        public function executeEdit($request) {

            $this->lastLogin = $this->getUser()->getAttribute('last_login', '', 'subscriber');

            $this->countries = Data::ISOCountries();
            $this->title = '';
            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            $member_email = $this->getUser()->getAttribute('email', '', 'subscriber');

            if ($request->isMethod('post')) {

                $formIndex = $request->getParameter('my_account');
                $path_to_picture = $formIndex['path_to_picture'];

                if ($path_to_picture != '') {
                    /**
                     * Send avatar URL
                     */
                    $avatarRealPath = sfConfig::get('sf_web_dir') . $path_to_picture;
                    $avatar_url = $request->getUriPrefix() . $path_to_picture;
                    $params = array(
                        'communityId' => sfConfig::get('app_sofun_community_id'),
                        'email'       => $this->getUser()->getAttribute('email', '', 'subscriber'),
                        'avatar_url'  => $avatar_url
                    );

                    try {
                        $response = $sofun->api_POST("/member/edit", $params);
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }

                    if ($response['http_code'] != '202') {
                        $this->messageError = $response['buffer'];
                        $this->avatar = "";
                        $this->getUser()->setFlash('error', $response['buffer']);
                    }
                    else {
                        if (file_exists($avatarRealPath)) {
                            $this->avatar = $avatar_url;
                            $this->getUser()->setAttribute('avatar', $this->avatar, 'subscriber');
                        }
                    }
                }
            }

            try {
                $response = $sofun->api_GET("/member/" . $member_email . "/properties");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response['http_code'] == '202') {
                $this->member_data = $response['buffer'];
            }
            else {
                $this->messageError = $response['buffer'];
            }

            if (isset($this->member_data)) {
                if ($this->member_data['title'] == 'MR') {
                    $this->title = 'M';
                }
                else if ($this->member_data['title'] == 'MRS') {
                    $this->title = 'Mme';
                }
                else if ($this->member_data['title'] == 'MS') {
                    $this->title = 'Mlle';
                }
            }

            $this->ongletActif = 1;
            $this->setAccountTabs();
        }

        private function setAccountTabs() {
            $this->labelsOnglets = array(
                'labelOnglet1' => $this->getContext()->getI18n()->__('label_tab_account_player'),
                'labelOnglet2' => "Partage et notifications",
                'labelOnglet3' => "Vérification et limites",
                'labelOnglet4' => "Historique financier",
                'labelOnglet5' => "Historique de jeu",
            );
        }

        /**
         * Member views / updates its notifications / Facebook information.
         *
         * @param sfWebRequest $request
         */
        public function executePrivacy($request) {

            $this->notification_scheme = array();
            $member_email = $this->getUser()->getAttribute('email', '', 'subscriber');

            //
            // Get logged in member current notification scheme.
            //

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_GET("/member/" . $member_email . "/notifications");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response['http_code'] == '202') {
                $this->notification_scheme = $response['buffer'];
            }
            else {
                $this->getUser()->setFlash('error', $response['buffer']);
            }

            //
            // Update logged in member notification scheme.
            //

            if ($request->isMethod('post')) {

                $enabled = $request->getParameter('notifications');

                foreach ($this->notification_scheme as $key => $value) {

                    if ($enabled != '' && in_array($key, $enabled)) {
                        $this->notification_scheme[$key] = true;
                    }
                    else {
                        $this->notification_scheme[$key] = false;
                    }
                }

                if ($enabled != '') {
                    foreach ($enabled as $key) {
                        $this->notification_scheme[$key] = true;
                    }
                }

                try {
                    $response = $sofun->api_POST("/member/" . $member_email . "/notifications/edit", $this->notification_scheme);
                } catch (SofunApiException $e) {
                    error_log($e);
                }

                if ($response['http_code'] != '202') {
                    $this->getUser()->setFlash('error', $response['buffer']);
                }
            }

            $this->ongletActif = 2;
            $this->setAccountTabs();

        }

        /**
         * Members uploads ID / RIB files.
         *
         * @param unknown_type $request
         */
        public function executeUploads($request) {

            $this->setTemplate('status');

            $this->member_email = $this->getUser()->getAttribute('email', '', 'subscriber');
            $this->member_uuid = $this->getUser()->getAttribute('subscriberId', '', 'subscriber');

            if ($request->isMethod('post')) {

                $fileName = $_FILES["limites"]["name"]["identity"];
                $fileType = $_FILES["limites"]["type"]["identity"];
                $fileTmpName = $_FILES["limites"]["tmp_name"]["identity"];
                $fileError = $_FILES["limites"]["error"]["identity"];
                $fileSize = $_FILES["limites"]["size"]["identity"];
                $fileNameUnix = @ereg_replace("[^0-9a-zA-Z.]+", "", $fileName);

                // Show flash error if the file is more than 1mo
                if ($fileSize == 0 && $fileName != '') {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('text_account_upload_identity'));
                    $this->redirect(array('module' => 'account', 'action' => 'status'));
                }
                $savedIdentityFileName = "";
                if ($fileName != "") {
                    $savedIdentityFileName = $this->member_uuid . '_identity_' . $fileNameUnix;
                    $identityFileName = '../data/' . $savedIdentityFileName;
                    move_uploaded_file($fileTmpName, $identityFileName);
                    $this->sendLegigameEmail($this->member_uuid, $this->member_email, $identityFileName);
                }

                $fileName = $_FILES["limites"]["name"]["rib"];
                $fileType = $_FILES["limites"]["type"]["rib"];
                $fileTmpName = $_FILES["limites"]["tmp_name"]["rib"];
                $fileError = $_FILES["limites"]["error"]["rib"];
                $fileSize = $_FILES["limites"]["size"]["rib"];
                $fileNameUnix = @ereg_replace("[^0-9a-zA-Z.]+", "", $fileName);

                // Show flash error if the file is more than 1mo
                if ($fileSize == 0 && $fileName != '') {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('text_account_upload_rib'));
                    $this->redirect(array('module' => 'account', 'action' => 'status'));
                }

                $savedRibFileName = "";
                if ($fileName != "") {
                    $savedRibFileName = $this->member_uuid . '_rib_' . $fileNameUnix;
                    $ribFileName = '../data/' . $savedRibFileName;
                    move_uploaded_file($fileTmpName, $ribFileName);
                    $this->sendLegigameEmail($this->member_uuid, $this->member_email, $ribFileName);
                }

                $params = array(
                    'communityId' => sfConfig::get('app_sofun_community_id'),
                    'email'       => $this->member_email,
                    'idFilename'  => $savedIdentityFileName,
                    'ribFilename' => $savedRibFileName,
                );

                $sofun = BetkupWrapper::_getSofunApp($request, $this);
                try {
                    $response = $sofun->api_POST("/member/edit", $params);
                } catch (SofunApiException $e) {
                    error_log($e);
                }

                if ($response['http_code'] != '202') {
                    $this->getUser()->setFlash('error', $response['buffer']);
                }
                else {
                    $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('text_account_parameters_saved'));
                }

                $this->redirect(array('module' => 'account', 'action' => 'status'));
            }

        }

        /**
         * Send an email with attachement to Legigame for processing
         *
         * @param unknown_type $member_uuid : a member uuid
         * @param unknown_type $member_email: a member email
         * @param unknown_type $path        : the path to attachement
         */
        private function sendLegigameEmail($member_uuid, $member_email, $path) {
            $mailto = sfConfig::get('mod_account_legigame_mailto');
            if ($mailto != 'none') {
                $message = Swift_Message::newInstance()
                    ->setFrom(sfConfig::get('mod_account_legigame_mailfrom'))
                    ->setTo($mailto)
                    ->setCc(sfConfig::get('mod_account_legigame_mailcc'))
                    ->setSubject($member_uuid)
                    ->setBody($member_uuid)
                    ->attach(Swift_Attachment::fromPath($path));
                $this->getMailer()->send($message);
                $this->getLogger()->notice(
                    "Attachement=" . $path . " sent to " . mailto .
                        " on behalf of member w /uuid=" . $member_uuid);
            }
        }

        /**
         * Member updates his legal status (ID / RIB papers upload,
         * financial transactions limits, etc.)
         *
         * @param sfWebRequest $request
         */
        public function executeStatus($request) {

            $this->ongletActif = 3;
            $this->setAccountTabs();

            $this->activationKey = "";
            $this->maxAmountBetWeekly = "";
            $this->maxAmountCreditWeekly = "";
            $this->maxAmountAutomaticWire = "";
            $this->autoExclusion = "";


            $hostname = $this->getContext()->getRequest()->getHost();

            $this->account_type = $this->getUser()->getAttribute('account_type', '', 'subscriber');
            $this->member_email = $this->getUser()->getAttribute('email', '', 'subscriber');
            $this->member_uuid = $this->getUser()->getAttribute('subscriberId', '', 'subscriber');

            // Only get these of the member has a gambling profile.
            if ($this->account_type != sfConfig::get("mod_account_registration_account_type_simple")) {

                $sofun = BetkupWrapper::_getSofunApp($request, $this);
                try {
                    $response = $sofun->api_GET("/member/" . $this->member_email . "/properties");
                } catch (SofunApiException $e) {
                    error_log($e);
                }

                if ($response['http_code'] == '202') {
                    $this->maxAmountBetWeekly = $response["buffer"]['max_amount_bet_weekly'];
                    $this->maxAmountCreditWeekly = $response["buffer"]['max_amount_credit_weekly'];
                    $this->maxAmountAutomaticWire = $response["buffer"]['max_amount_automatic_wire'];
                    if ($this->maxAmountAutomaticWire == 0) {
                        $this->maxAmountAutomaticWire = "";
                    }
                    $this->autoExclusion = $response["buffer"]['auto_exclusion'];
                    $this->idFilename = $response["buffer"]['filename_id'];
                    $this->ribFilename = $response["buffer"]['filename_rib'];
                    $email = $this->getUser()->getAttribute('email', '', 'subscriber');
                    try {
                        $response = $response = $sofun->api_GET("/member/" . $email . "/properties");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response['http_code'] == '202') {
                        $member_properties = $response['buffer'];
                        // Update credit in session.
                        $this->getUser()->setAttribute('credit', $member_properties['credit'], 'subscriber');
                        $this->getUser()->setAttribute('transferable_credit', $member_properties['transferable_credit'], 'subscriber');
                    }
                }
                else {
                    $this->getUser()->setFlash('error', $response['buffer']);
                }

            }

            if ($request->isMethod('post')) {

                $notice_error = '';
                $message = '';

                $values = $request->getParameter('limites');
                if (isset($values['activationKey'])) {
                    $this->activationKey = $values['activationKey'];
                }
                if (isset($values['maxAmountBetWeekly'])) {
                    $this->maxAmountBetWeekly = $values['maxAmountBetWeekly'];
                }
                if (isset($values['maxAmountCreditWeekly'])) {
                    $this->maxAmountCreditWeekly = $values['maxAmountCreditWeekly'];
                }
                if (isset($values['maxAmountAutomaticWire'])) {
                    $this->maxAmountAutomaticWire = $values['maxAmountAutomaticWire'];
                }
                if (isset($values['autoExclusion'])) {
                    $this->autoExclusion = $values['autoExclusion'];
                }

                if ($this->maxAmountCreditWeekly != '' && !preg_match("/^[0-9]+$/", $this->maxAmountCreditWeekly) || $this->maxAmountBetWeekly != '' && !preg_match("/^[0-9]+$/", $this->maxAmountBetWeekly)) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("label_limit_values_invalid"));
                }
                else if ($this->maxAmountBetWeekly != '' && intval($this->maxAmountBetWeekly) > intval(sfConfig::get('mod_account_limit_weekly_bets'))) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("label_limit_weekly_bets_invalid"));
                }
                else if ($this->maxAmountCreditWeekly != '' && intval($this->maxAmountCreditWeekly) > intval(sfConfig::get('mod_account_limit_weekly_credit'))) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("label_limit_weekly_credit_invalid"));
                }
                else if ($this->maxAmountAutomaticWire != '' && !preg_match("/^[0-9]+$/", $this->maxAmountAutomaticWire)) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("label_limit_max_automatic_wire"));
                }
                else if ($this->maxAmountAutomaticWire != '' && intval($this->maxAmountAutomaticWire) != 0 && intval($this->maxAmountAutomaticWire) < intval(sfConfig::get('mod_account_limit_automatic_wire'))) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__("label_limit_max_automatic_wire"));
                }
                else {

                    $params = array(
                        'communityId' => sfConfig::get('app_sofun_community_id'),
                        'email'       => $this->member_email,
                    );
                    if ($this->activationKey != '') {
                        $params['activationKey'] = $this->activationKey;
                    }
                    if ($this->maxAmountBetWeekly != '') {
                        $params['maxAmountBetWeekly'] = $this->maxAmountBetWeekly;
                    }
                    if ($this->maxAmountCreditWeekly != '') {
                        $params['maxAmountCreditWeekly'] = $this->maxAmountCreditWeekly;
                    }
                    if ($this->maxAmountAutomaticWire != '') {
                        $params['maxAmountAutomaticWire'] = $this->maxAmountAutomaticWire;
                    }
                    if ($this->autoExclusion != '') {
                        $params['autoExclusion'] = $this->autoExclusion;
                    }

                    if (array_key_exists('activationKey', $params) || array_key_exists('maxAmountBetWeekly', $params) || array_key_exists('maxAmountCreditWeekly', $params) || array_key_exists('maxAmountAutomaticWire', $params) || array_key_exists('autoExclusion', $params)) {

                        try {
                            $response = $sofun->api_POST("/member/edit", $params);
                        } catch (SofunApiException $e) {
                            error_log($e);
                        }

                        if ($response['http_code'] != '202') {
                            $notice_error = 'error';
                            $message = $response['buffer'];
                        }
                        else {
                            // Operation is successful we notify ARJEL sensor
                            $this->setSensorOperationSuccessStatus();
                            $notice_error = 'notice';
                            $message = 'text_account_parameters_saved';
                        }
                    }

                    try {
                        $response = $sofun->api_GET("/member/" . $this->member_email . "/properties");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response['http_code'] == '202') {
                        $this->maxAmountBetWeekly = $response["buffer"]['max_amount_bet_weekly'];
                        $this->maxAmountCreditWeekly = $response["buffer"]['max_amount_credit_weekly'];
                        $this->maxAmountAutomaticWire = $response["buffer"]['max_amount_automatic_wire'];
                        $this->autoExclusion = $response["buffer"]['auto_exclusion'];
                        $this->idFilename = $response["buffer"]['filename_id'];
                        $this->ribFilename = $response["buffer"]['filename_rib'];
                        // Check if status changed
                        $this->getUser()->setAttribute('account_status', $response["buffer"]['account_status'], 'subscriber');
                        if ($response["buffer"]['account_status'] == sfConfig::get('mod_account_registration_account_type_gambling_fr_verified')
                            && !$this->getUser()->hasCredential('member_gambling_fr_verified')
                        ) {
                            // Activation is successful we notify ARJEL sensor
                            $this->setSensorOperationActivationSuccessStatus();
                            $this->getUser()->addCredential('member_gambling_fr_verified');
                            $notice_error = 'notice';
                            $message = 'text_account_verified_code';
                        }
                        else {
                            if (!array_key_exists('maxAmountBetWeekly', $params) || !array_key_exists('maxAmountCreditWeekly', $params) || !array_key_exists('maxAmountAutomaticWire', $params) || !array_key_exists('autoExclusion', $params)) {

                                if ($this->idFilename == '' || $this->ribFilename == '') {
                                    $notice_error = 'error';
                                    $message = 'text_account_not_verified';
                                }
                                else if ($this->activationKey != '') {
                                    $notice_error = 'error';
                                    $message = 'text_account_wrong_code';
                                }
                                else {
                                    $notice_error = 'error';
                                    $message = 'text_account_empty_code';
                                }
                            }
                        }
                    }
                    else {
                        $notice_error = 'error';
                        $message = $response['buffer'];
                    }

                    if ($this->autoExclusion != '') {
                        $this->executeLogout($request);
                    }
                }

                if ($notice_error != '' && $message != '') {
                    $this->getUser()->setFlash($notice_error, $this->getContext()->getI18n()->__($message));
                }
            }
        }

        /**
         * Displays Member's transactions.
         *
         * @param sfWebRequest $request
         */
        public function executeTransaction($request) {

            $this->member_email = $this->getUser()->getAttribute('email', '', 'subscriber');
            $this->account_type = $this->getUser()->getAttribute('account_type', '', 'subscriber');

            $this->member_credit = $this->getUser()->getAttribute('credit', '', 'subscriber');

            $this->ongletActif = 4;
            $this->setAccountTabs();

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            $txn_type = $request->getParameter('transaction', '');

            try {
                if ($txn_type == '') {
                    $response = $sofun->api_GET("/member/" . $this->member_email . "/transaction/history");
                }
                else if ($txn_type == 'bet') {
                    $response = $sofun->api_GET("/member/" . $this->member_email . "/debit/bet/history");
                }
                else if ($txn_type == 'winnings') {
                    $response = $sofun->api_GET("/member/" . $this->member_email . "/credit/bet/history");
                }
                else if ($txn_type == 'wire') {
                    $response = $sofun->api_GET("/member/" . $this->member_email . "/wire/history");
                }
                else if ($txn_type == 'bonus') {
                    $response = $sofun->api_GET("/member/" . $this->member_email . "/credit/bonus/history");
                }
                else if ($txn_type == 'credit') {
                    $response = $sofun->api_GET("/member/" . $this->member_email . "/credit/history");
                }
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response['http_code'] == '202') {

                $txns = $response['buffer'];

                $rows = array();
                foreach ($txns as $row) {

                    if ($row['credit'] == 1
                        && $row['txnLabel'] == "CC Credit"
                        && $row['txnStatus'] != "APPROVED"
                    ) {
                        continue;
                    }

                    $signe = $classe = "";
                    if ($row["credit"] == 1) {
                        $signe = "+";
                        $classe = "vert";
                        $image = "flecheVert.png";
                    }
                    else if ($row["debit"] == 1) {
                        $signe = "-";
                        $classe = "orange";
                        $image = "flecheOrange.png";
                    }

                    // '01/02/2011 - 10h34'
                    $date = Util::displayDateCompleteFromTimestampComplet($row["txnDate"], true);
                    $txtLabel = $row["txnLabel"];
                    if ($row["txnLabel"] == 'Bet Debit') {
                        $txtLabel = 'Mise';
                    }
                    else if ($row["txnLabel"] == 'Bet Credit') {
                        $txtLabel = 'Gain';
                    }

                    $rows[] = array(
                        'date'    => array(
                            'align' => 'left',
                            'class' => 'gris',
                            'value' => $date
                        ),
                        'objet'   => array(
                            'align' => 'left',
                            'class' => 'gris',
                            'value' => $txtLabel
                        ),
                        'kup'     => array(
                            'align' => 'left',
                            'class' => 'gris',
                            'value' => isset($row["kup"]['name']) ? $row["kup"]['name'] : ''
                        ),
                        'montant' => array(
                            'align'   => 'center',
                            'picture' => '/images/interface/tableau/' . $image,
                            'class'   => $classe,
                            'value'   => $signe . $row["txnAmount"] . ' ' . ($row["txnCurrency"] == 'Euro' ? '€' : '')
                        ),
                    );

                }

                $this->data = array(
                    'links'   => array(
                        array(
                            'name'   => 'Toutes', 'link' => array(
                            'module' => 'account', 'action' => 'transaction', 'transaction' => ''
                        ), 'class'   => ($txn_type == '' ? 'gris' : 'orange')
                        ),
                        array(
                            'name'   => 'Dépôt', 'link' => array(
                            'module'      => 'account', 'action' => 'transaction',
                            'transaction' => 'credit'
                        ), 'class'   => ($txn_type == 'depot' ? 'gris' : 'orange')
                        ),
                        array(
                            'name'   => 'Mises', 'link' => array(
                            'module' => 'account', 'action' => 'transaction', 'transaction' => 'bet'
                        ), 'class'   => ($txn_type == 'stake' ? 'gris' : 'orange')
                        ),
                        array(
                            'name'   => 'Gains', 'link' => array(
                            'module'      => 'account', 'action' => 'transaction',
                            'transaction' => 'winnings'
                        ), 'class'   => ($txn_type == 'gain' ? 'gris' : 'orange')
                        ),
                        array(
                            'name'   => 'Encaissements', 'link' => array(
                            'module'      => 'account', 'action' => 'transaction',
                            'transaction' => 'wire'
                        ), 'class'   => ($txn_type == 'encaissement' ? 'gris' : 'orange')
                        ),
                        array(
                            'name'   => 'Bonus', 'link' => array(
                            'module'      => 'account', 'action' => 'transaction',
                            'transaction' => 'bonus'
                        ), 'class'   => ($txn_type == 'bonus' ? 'gris' : 'orange')
                        ),
                    ),
                    'legende' => array(
                        array('title' => 'Date', 'width' => '200', 'align' => 'left'),
                        array('title' => 'Objet', 'width' => '200', 'align' => 'left'),
                        array('title' => 'Kups', 'width' => '150', 'align' => 'left'),
                        array('title' => 'Montant', 'width' => '', 'align' => 'center'),
                    ),
                    'rows'    => $rows
                );
            }
            else {
                $this->messageError = $response['buffer'];
                $this->avatar = "";
                $this->getUser()->setFlash('error', $response['buffer']);
            }

        }

        /**
         * Displays member predictions and related information.
         *
         * @param sfWebRequest $request
         */
        public function executePrediction($request) {

            $this->member_email = $this->getUser()->getAttribute('email', '', 'subscriber');
            $this->account_type = $this->getUser()->getAttribute('account_type', '', 'subscriber');
            $this->member_credit = $this->getUser()->getAttribute('credit', '', 'subscriber');

            $this->ongletActif = 5;
            $this->setAccountTabs();

            $offset = $request->getParameter('offset', 0);
            $batchSize = $request->getParameter('batchSize', 1000);
            $status = $request->getParameter('status', 'ALL');

            $sofun = BetkupWrapper::_getSofunApp($request, $this);

            try {
                $response = $sofun->api_GET("/member/" . $this->member_email . "/kups/history/status/" . $status . "/" . $offset . "/" . $batchSize);
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response['http_code'] == '202') {

                $kups = $response['buffer'];

                $rows = array();
                $offset = 0;
                foreach ($kups as $kup) {
                    if ($kup['status'] == -1) {
                        $ranking = $this->getContext()->getI18n()->__('label_cancelled');
                        $winnings = '-';
                    }
                    else if ($kup['status'] < 4) {
                        $ranking = $this->getContext()->getI18n()->__('label_in_progress');
                        $winnings = '-';
                    }
                    else {
                        $ranking = $kup['ranking'] . '/' . $kup['totalParticipants'];
                        $winnings = $kup['winnings'] . ' €';
                    }
                    $rows[$offset] = array(
                        'room'       => array(
                            'align' => 'left', 'class' => 'gris', 'value' => $kup['teamName']
                        ),
                        'kup'        => array(
                            'align' => 'left', 'class' => 'orange',
                            'value' => $this->getContext()->getI18n()->__($kup['name']),
                            'link'  => $this->getController()->genUrl(array(
                                                                           'module'  => 'kup',
                                                                           'action'  => 'view',
                                                                           'uuid'    => $kup['uuid']
                                                                      ))
                        ),
                        'stake'      => array(
                            'align' => 'center', 'class' => 'gris',
                            'value' => ($kup['stake'] != '' && $kup['stake'] != '0') ? $kup['stake'] . ' €' : $this->getContext()->getI18n()->__('label_free')
                        ),
                        'point'      => array(
                            'align' => 'center', 'class' => 'gris',
                            'value' => $kup['points'] . ' pts'
                        ),
                        'classement' => array(
                            'align' => 'center', 'class' => 'gris', 'value' => $ranking
                        ),
                        //'gain' => array('align' => 'center', 'class' => 'vert', 'value' => $winnings),
                    );
                    $offset++;
                }
                unset($predictions);

            }

            $this->data = array(
                'links'   => array(
                    array(
                        'name'   => 'Tous', 'link' => array(
                        'module' => 'account', 'action' => 'prediction', 'status' => 'ALL'
                    ), 'class'   => $status == 'ALL' ? 'gris' : 'orange'
                    ),
                    array(
                        'name'   => 'A venir', 'link' => array(
                        'module' => 'account', 'action' => 'prediction', 'status' => 'OPENED'
                    ), 'class'   => $status == 'OPENED' ? 'gris' : 'orange'
                    ),
                    array(
                        'name'   => 'En cours', 'link' => array(
                        'module' => 'account', 'action' => 'prediction', 'status' => 'ON_GOING'
                    ), 'class'   => $status == 'ON_GOING' ? 'gris' : 'orange'
                    ),
                    array(
                        'name'   => 'Terminé', 'link' => array(
                        'module' => 'account', 'action' => 'prediction', 'status' => 'ALL_CLOSED'
                    ), 'class'   => $status == 'ALL_CLOSED' ? 'gris' : 'orange'
                    ),
                ),
                'legende' => array(
                    array('title' => 'Room', 'width' => '130', 'align' => 'left'),
                    array('title' => 'Kup', 'width' => '200', 'align' => 'left'),
                    array('title' => 'Mise', 'width' => '100', 'align' => 'center'),
                    array('title' => 'Points', 'width' => '100', 'align' => 'center'),
                    array('title' => 'Classement final', 'width' => '100', 'align' => 'center'),
                    //array('title' => 'Gain', 'width' => '', 'align' => 'center'),
                ),
                'rows'    => $rows,
            );


        }

        /**
         * Member requests to reset its password.
         *
         * <p/>
         *
         * We provide a form so that it can provide its email address and get it reset. The
         * gaming platform will then send an email with an URL that will contain a unique temporary
         * generated token to identify the member.
         *
         * @see executePasswordReset() which will tbe the landing URL for the reset from email.
         *
         * @param sfWebRequest $request
         */
        public function executePasswordForgotten($request) {

            // If user is already logged in then redirect to his account
            if ($this->getUser()->isAuthenticated()) {
                $this->redirect(array('module' => 'account', 'action' => 'edit'));
            }

            $this->recaptcha_response_field = "";
            $this->privatekey = sfConfig::get('app_recaptcha_private_key');
            require_once('recaptchalib.php');

            $this->recaptcha_response_field = $this->information["recaptcha_response_field"];

            $this->form = new forgottenForm();
            if ($request->isMethod('post')) {

                $resp = recaptcha_check_answer($this->privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                if (!$resp->is_valid) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('message_flash_error_captcha'));
                    $this->redirect(array('module' => 'account', 'action' => 'passwordForgotten'));
                }
                ;

                $input = $request->getParameter('connexion');
                $email = $input['email'];

                if ($email == '') {
                    $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_password_forgotten_email_not_valid'));
                    $this->redirect(array('module' => 'account', 'action' => 'passwordForgotten'));
                }

                // will be redirected to HTTPS by web server
                $redirect = $request->getUriPrefix() . $this->getController()->genUrl('password_reset');
                $api_url = "/member/" . $email . "/password/forgotten/";

                $params = array();
                $params['redirect_url'] = $redirect;

                $sofun = BetkupWrapper::_getSofunApp($request, $this);
                try {
                    $response = $sofun->api_POST($api_url, $params);
                } catch (SofunApiException $e) {
                    error_log($e);
                }

                if ($response['http_code'] == '202') {
                    $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_password_forgotten_success'));
                    $this->redirect(array('module' => 'account', 'action' => 'edit'));
                }
                else {
                    $this->getUser()->setFlash('error', $response['buffer']);
                }
            }

        }

        /**
         * Member resets its password.
         *
         * <p/>
         *
         * A member will beforehand request a new password. He will then receive an email with a link that will contain a secret
         * token with a limited life time.
         *
         * @param sfWebRequest $request
         */
        public function executePasswordReset($request) {

            // If user is already logged in then redirect to his account
            if ($this->getUser()->isAuthenticated()) {
                $this->redirect(array('module' => 'account', 'action' => 'edit'));
            }

            $this->recaptcha_response_field = "";
            $this->privatekey = sfConfig::get('app_recaptcha_private_key');
            require_once('recaptchalib.php');

            $this->recaptcha_response_field = $this->information["recaptcha_response_field"];

            $this->token = $request->getParameter("token", '');
            $this->email = $request->getParameter("email", '');

            $this->form = new resetpasswdForm();
            if ($request->isMethod('post')) {

                $resp = recaptcha_check_answer($this->privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                $values = $request->getParameter('connexion');

                $passwd = $values['passwd'];
                $confirmation = $values['confirmation'];

                // The variables above are defined as hidden fields within the action template.
                $this->token = $values['token'];
                $this->email = $values['email'];

                if (!$resp->is_valid) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('message_flash_error_captcha'));
                }
                else if (strlen($passwd) < 5) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_password_reset_at_least_5_chars'));
                }
                else if ($passwd != $confirmation) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_password_reset_passwords_do_not_match'));
                }
                else {

                    // Verify if the token is valid for this user.
                    $params = array();
                    $params['token'] = $this->token;

                    $hash_algo = sfConfig::get('app_crypto_password_hash');
                    $params['password'] = hash($hash_algo, $passwd);

                    $sofun = BetkupWrapper::_getSofunApp($request, $this);
                    try {
                        $response = $sofun->api_POST("/member/" . $this->email . "/password/reset", $params);
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }

                    if ($response['http_code'] == '202') {
                        $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_password_reset_success'));
                        $this->redirect(array('module' => 'account', 'action' => 'login'));
                    }
                    else {
                        $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_password_reset_token_expired'));
                        $this->redirect(array('module' => 'account', 'action' => 'login'));
                    }
                }
            }

        }

        /**
         * Function used to get the birthdate cookie. Return null if cookie not found
         *
         * @param string $email
         *
         * @return Ambigous <NULL, string>
         */
        private function getCookieBirthdate($email) {
            $cookie = null;
            $cookieName = sfConfig::get('mod_account_birthdate_cookie_prefix') . str_replace(array(
                                                                                                  '@',
                                                                                                  '.'
                                                                                             ), '_', $email);
            if (isset($_COOKIE[$cookieName])) {
                $cookie = $_COOKIE[$cookieName];
            }
            return $cookie;
        }

        /**
         * Returns a tracking code, if exists, from a cookie.
         */
        private function getTrackingCode() {
            $trackingCode = '';
            $cookieName = sfConfig::get('app_tracking_filter_cookie_name');
            if (isset($_COOKIE[$cookieName])) {
                $trackingCode = $_COOKIE[$cookieName];
            }
            return $trackingCode;
        }

        /**
         * Function used to set a secured birthdate cookie who expire at the end of the session
         *
         * @param sfWebRequest $request
         * @param string       $birthDate
         * @param string       $email
         */
        private function setCookieBirthdate($request, $birthDate, $email) {
            $cookieValue = date('d/m/Y', intval($birthDate) / 1000);
            $cookieExpire = time() + 60 * 60 * 24 * 365;
            $cookieName = sfConfig::get('mod_account_birthdate_cookie_prefix') . str_replace(array(
                                                                                                  '@',
                                                                                                  '.'
                                                                                             ), '_', $email);

            setCookie($cookieName, $cookieValue, $cookieExpire, '/', $request->getHost(), true);
        }

        /**
         * Member login.
         *
         * @param sfWebRequest $request
         */
        public function executeLogin(sfWebRequest $request) {

            $registeringParams = array();
            if ($request->getParameter('need_advanced_account', '') == 1) {
                $registeringParams['room_uuid'] = $request->getParameter('uuid', '');
            }
            if ($request->getParameter('redirect_route', '') != '') {
                $registeringParams['redirect_route'] = $request->getParameter('redirect_route', '');
            }
            if($request->getParameter('kup_uuid', '-1') != '-1') {
                $registeringParams['kup_uuid'] = $request->getParameter('kup_uuid', '-1');
            }

            $this->registerUrl = $this->getController()->genUrl(array(
                                                                     'module'  => 'account',
                                                                     'action'  => 'register'
                                                                ));

            if ($request->getParameter('need_advanced_account', '') == 1) {
                if (count($registeringParams) == 2) {
                    $this->registerUrl = $this->generateUrl('account_register_advanced_room', $registeringParams);
                } else if(count($registeringParams) > 2 && isset($registeringParams['kup_uuid'])) {
                    $this->registerUrl = $this->generateUrl('account_register_advanced_room_kup', $registeringParams);
                }
            }

            // Generate flash when coming from a forward action.
            $module = $request->getParameter('module', '');
            if($module == 'room') {
                // Fix for facebook connect : Need a cookie due to redirects.
                $this->getResponse()->setCookie('room_uuid', $request->getParameter('room_uuid', ''));

                if($this->getUser()->hasCredential(sfConfig::get('mod_'.$module.'_security_betkup_anonymous_private', ''))) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_anonymous_room_private_login_error_message'));
                }
                if($this->getUser()->hasCredential(sfConfig::get('mod_'.$module.'_security_betkup_connected_private', ''))) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_connected_room_private_login_error_message'));
                }
                if($this->getUser()->hasCredential(sfConfig::get('mod_'.$module.'_security_betkup_anonymous_public', ''))) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_anonymous_room_public_login_error_message'));
                }
                if($this->getUser()->hasCredential(sfConfig::get('mod_'.$module.'_security_betkup_connected_public', ''))) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_connected_room_public_login_error_message'));
                }
            }

            $this->formBirthdateError = $this->messageError = "";
            $this->form = new connexionFormLogin();

            $this->birthdateCookiePrefix = sfConfig::get('mod_account_birthdate_cookie_prefix');

            // XXX BETKUP-542
            //$this->form->getCSRFToken();

            if ($request->isMethod('post')) {

                if (isset($_POST["connexion"]["birthdate"])) {
                    $birthdate = $_POST["connexion"]["birthdate"];
                }
                elseif (isset($_POST["connexionLogin"]["birthdate"])) {
                    $birthdate = $_POST["connexionLogin"]["birthdate"];
                }

                $formConnexion = $request->getParameter('connexion');
                $formConnexionLogin = $request->getParameter('connexionLogin');

                if (isset($formConnexion)) {
                    $this->form->bind($formConnexion);
                }
                elseif (isset($formConnexionLogin)) {
                    $this->form->bind($formConnexionLogin);
                }

                if ($this->form->isValid()) {

                    $values = $this->form->getValues();

                    $email = $values['email'];
                    $password = $values['password'];

                    if ($birthdate["day"] != "" && $birthdate["month"] != "" && $birthdate["year"] != "") {

                        $hash_algo = sfConfig::get('app_crypto_password_hash');
                        $params = array(
                            'communityId' => sfConfig::get('app_sofun_community_id'),
                            'email'       => $email,
                            'password'    => hash($hash_algo, $password),
                            'birthDay'    => $birthdate["day"],
                            'birthMonth'  => $birthdate["month"],
                            'birthYear'   => $birthdate["year"],
                        );

                        $sofun = BetkupWrapper::_getSofunApp($request, $this);
                        try {
                            $response = $sofun->login($params);
                        } catch (SofunApiException $e) {
                            error_log($e);
                        }

                        if ($response['http_code'] == '202') {
                            $sofun_member = $response['buffer'];
                            BetkupWrapper::_setSofunSession($sofun->getSession(), $this);
                            $this->_postLogin($request, $sofun_member);

                            // Cookie creation for birth date
                            if ($this->getCookieBirthdate($sofun_member['email']) == null && $sofun_member['type'] == sfConfig::get('mod_account_registration_account_type_simple')) {
                                $this->setCookieBirthdate($request, $sofun_member['birthDate'], $sofun_member['email']);
                            }

                            $this->setCustomFlashActions($request, 'flash_notice_member_logged_in');
                            $this->redirectIfLoginSuccess('@dashboard', 302, 200);
                        }
                        else {
                            // #BETKUP-544 - V19 - do not relay platform error message for security purpose.
                            // We use a generic one here.
                            $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_login_failed'));

                        }
                    }
                }
            }

        }

        /**
         * Set custom flash messages and / or custom actions.
         *
         * @param sfWebRequest $request
         *
         * @return void()
         */
        private function setCustomFlashActions(sfWebRequest $request, $defaultFlash, $room_uuid = '') {

            // Set flash message
            $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__($defaultFlash));
            $module = $request->getParameter('module', '');

            $room_uuid = $request->getParameter('room_uuid', $room_uuid);
            if($module == 'room' && $request->getParameter('uuid', '') != '') {
                $room_uuid = $request->getParameter('uuid', '');
            }
            if(($module == 'room' || $module == 'account') && $request->getCookie('room_uuid') != '') {
                $room_uuid = $request->getCookie('room_uuid');
                // We delete the cookie.
                $this->getResponse()->setCookie('room_uuid', '', 0, '/');
            }

            // We assume the user is a room member.
            if($room_uuid != '' && $room_uuid != '-1') {
                $this->joinRoom($request, $room_uuid);
            }

        }

        /**
         * Member registration step2 : credit account.
         *
         * @param sfWebRequest $request
         */
        public function executeRegisterCredit(sfWebRequest $request) {

            // lastUrl is used when the user clic on "credit account later" from the template.
            // Redirect the user where he was or to the default url (MyBetkup)
            $this->defaultUrl = $request->getUriPrefix() . $this->getContext()->getController()->genUrl(array(
                                                                                                             'module'  => 'me',
                                                                                                             'action'  => 'index'
                                                                                                        ));
            $this->lastUrl = $request->getAttribute('redirectUrl', $this->defaultUrl);
            if ($request->getParameter('redirect_route', '') != '') {
                $room_uuid = $request->getParameter('room_uuid', '');
                $this->defaultUrl = $this->generateUrl($request->getParameter('redirect_route', ''), array('uuid' => $room_uuid));
            }
            $this->setTemplate('registerCredit');
            return $this->executeCredit($request);
        }


        /**
         * Popup form verification for gain acceptation
         *
         * @param sfWebRequest $request
         */
        public function executeNotificationsPopup(sfWebRequest $request) {
            if ($request->isXmlHttpRequest()) {
                $notifications = $this->getUser()->getAttribute('notifications', array(), 'subscriber');
                $this->sofun = BetkupWrapper::_getSofunApp($request, $this);
                // New CGU/rules acceptance
                if ($request->getParameter("policyAcceptance") == "policyAcceptance") {
                    $params = array(
                        'communityId'       => sfConfig::get('app_sofun_community_id'),
                        'email'             => $this->getUser()->getAttribute('email', '', 'subscriber'),
                        'policy_acceptance' => 'policy_acceptance',
                    );
                    try {
                        $this->sofun->api_POST("/member/edit", $params);
                        unset($notifications['policy_acceptance']);
                        $this->setSensorOperationSuccessStatus();
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                }


                $txn = $request->getParameter('bonus', '');
                if ($txn != '') {
                        $params = array(
                            'communityId'       => sfConfig::get('app_sofun_community_id'),
                            'email'             => $this->getUser()->getAttribute('email', '', 'subscriber'),
                            'txnId' => $txn,
                        );
                        try {
                            error_log("Handling Bonus txn with id=" . $txn);
                            $this->sofun->api_POST("/member/transactions/ack", $params);
                        } catch (SofunApiException $e) {
                            error_log($e);
                        }
                    $this->setSensorOperationSuccessStatus();
                    unset($notifications['bonus']);
                }



                $txn = $request->getParameter('winnings', '');
                if ($txn != '') {
                        $params = array(
                            'communityId'       => sfConfig::get('app_sofun_community_id'),
                            'email'             => $this->getUser()->getAttribute('email', '', 'subscriber'),
                            'txnId' => $txn,
                        );
                        try {
                            error_log("Handling Winnings txn with id=" . $txn);
                            $this->sofun->api_POST("/member/transactions/ack", $params);
                        } catch (SofunApiException $e) {
                            error_log($e);
                        }
                    $this->setSensorOperationSuccessStatus();
                    unset($notifications['winnings']);
                }

                $this->getUser()->setAttribute('notifications', array(), 'subscriber');
                return $this->renderText('202');
            }
            return $this->renderText('404');
        }

        /**
         * Member wire some cash.
         *
         * <p/>
         * Only verified accounts can do this.
         *
         * @see security.yml
         *
         * @param sfWebRequest $request
         */
        public function executeWire($request) {

            $this->ongletActif = 4;
            $this->labelsOnglets = array(
                'labelOnglet1' => "Compte joueur",
                'labelOnglet2' => "Notifications et publications",
                'labelOnglet3' => "Vérification",
                'labelOnglet4' => "Transactions financières",
                'labelOnglet5' => "Historique des paris",
            );

            // We need to add this to the form as hidden values to be able to trace it sensor side.
            $this->member_credit = $this->getUser()->getAttribute('credit', '', 'subscriber');
            $this->transferable_member_credit = $this->getUser()->getAttribute('transferable_credit', '0', 'subscriber');
            $this->userEmail = $this->getUser()->getAttribute('email', '', 'subscriber');

            if ($request->isMethod('post')) {

                $data = $request->getParameter('wire');

                $email = $this->getUser()->getAttribute('email', '', 'subscriber');
                $params = array(
                    'communityId'  => sfConfig::get('app_sofun_community_id'),
                    'email'        => $email,
                    'txn_amount'   => $data["montantRetrait"],
                    'txn_currency' => 'Euro', // betkup.fr only deals with Euro
                );

                $sofun = BetkupWrapper::_getSofunApp($request, $this);
                try {
                    // Platform will perform checks related to account balance etc.
                    $response = $sofun->api_POST("/member/debit", $params);
                } catch (SofunApiException $e) {
                    error_log($e);
                }

                if ($response['http_code'] == '202') {

                    // Operation is successful we notify ARJEL sensor
                    $this->setSensorOperationSuccessStatus();

                    try {
                        $response = $response = $sofun->api_GET("/member/" . $email . "/properties");
                    } catch (SofunApiException $e) {
                        error_log($e);
                    }
                    if ($response['http_code'] == '202') {
                        $member_properties = $response['buffer'];
                        $this->getUser()->setAttribute('credit', $member_properties['credit'], 'subscriber');
                        $this->getUser()->setAttribute('transferable_credit', $member_properties['transferable_credit'], 'subscriber');
                        $this->redirect(array('module' => 'account', 'action' => 'transaction'));
                    }
                    else {
                        $this->messageError = $response['buffer'];
                    }

                }
                else {

                    $this->messageError = $this->getContext()->getI18n()->__('flash_error_wire_failed');

                }

            }

        }

        /**
         * Calculate a uniq reference for a transaction requested by a user (needed for payline)
         *
         * @param string $user_id
         * @param int    $timestamp
         *
         * @return string
         */
        private function getOrderReference($user_id, $timestamp) {
            return $user_id . $timestamp;
        }

        /**
         * Credit member account.
         *
         * @param  sfWebRequest $request
         */
        public function executeCredit($request) {

            $this->ongletActif = 4;
            $this->labelsOnglets = array(
                'labelOnglet1' => "Compte joueur",
                'labelOnglet2' => "Notifications et publications",
                'labelOnglet3' => "Vérification",
                'labelOnglet4' => "Transactions financières",
                'labelOnglet5' => "Historique des paris",
            );

            //
            // Initialize forms vars
            //

            $this->credit_amount = "";
            $this->credit_amountCreditPerso = "0";
            $this->credit_card_digits = "";
            $this->credit_card_expire_2 = date("m");
            $this->credit_card_expire_3 = date("y");
            $this->credit_card_crypto = "";

            if ($request->isMethod('post')) {

                $data = $request->getParameter('credit');

                // Value from predefined values (select box) (outside credit bloc for a reason I don't get...)
                $amountCreditSelectData = $request->getParameter("credit_select");
                $data["amountCreditSelect"] = $amountCreditSelectData["amountCreditSelect"];

                // Input from the member (member input) (outside credit bloc for a reason I don't get...)
                $amountCreditPersoData = $request->getParameter("credit_amount");
                $data["amountCreditPerso"] = $amountCreditPersoData["amountCreditPerso"];

                if ($data["amountCreditSelect"] == '1') {
                    $this->credit_amount = $data["amountCreditPerso"];
                    $this->credit_amountCreditPerso = '1';
                }
                else {
                    $this->credit_amount = $data["amountCreditSelect"];
                    $this->credit_amountCreditPerso = '0';
                }

                // Validators
                if (intval($this->credit_amount) < intval(sfConfig::get('mod_account_credit_min'))) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_message_transaction_credit_min_error', array('%bet%' => sfConfig::get('mod_account_credit_min'))));
                }
                else if (intval($this->credit_amount) > intval(sfConfig::get('mod_account_credit_max'))) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_message_transaction_credit_max_error', array('%bet%' => sfConfig::get('mod_account_credit_max'))));
                }
                else {

                    $this->credit_card_number = $data["cardnumber"];
                    $this->credit_card_expire_2 = $data["expiration_2"];
                    $this->credit_card_expire_3 = $data["expiration_3"];
                    $this->credit_card_crypto = $data["crypto"];

                    // Connect to bank for auth + capture

                    $array = array();
                    require_once(sfConfig::get('sf_app_module_dir') . '/account/lib/payline-php-sdk/sofun-include.php');

                    //Do define from configuration here
                    DEFINE('MERCHANT_ID', strval(sfConfig::get("mod_account_payline_merchant_id"))); // Merchant ID
                    DEFINE('ACCESS_KEY', strval(sfConfig::get("mod_account_payline_access_key"))); // Certificate key
                    DEFINE('PROXY_HOST', null); // Proxy URL (optional)
                    DEFINE('PROXY_PORT', null); // Proxy port number without 'quotes' (optional)
                    DEFINE('PROXY_LOGIN', ''); // Proxy login (optional)
                    DEFINE('PROXY_PASSWORD', ''); // Proxy password (optional)
                    DEFINE('PRODUCTION', sfConfig::get("mod_account_payline_production_flag")); // Demonstration (FALSE) or production (TRUE) mode

                    $payline = new paylineSDK();

                    //PAYMENT
                    $array['payment']['amount'] = intval($this->credit_amount) * 100;
                    $array['payment']['currency'] = sfConfig::get('mod_account_payline_payment_currency');
                    $array['payment']['action'] = sfConfig::get('mod_account_payline_payment_action');
                    $array['payment']['mode'] = sfConfig::get('mod_account_payline_payment_mode');
                    $array['payment']['contractNumber'] = sfConfig::get('mod_account_payline_contract_number');

                    //ORDER
                    $user_id = $this->getUser()->getAttribute('subscriberId', '', 'subscriber');
                    $timestamp = time();
                    $order_ref = $this->getOrderReference($user_id, $timestamp);
                    $array['order']['ref'] = $order_ref;
                    $array['order']['country'] = 'FR';
                    $array['order']['amount'] = intval($this->credit_amount) * 100;
                    $array['order']['date'] = date('d/m/Y H:i', $timestamp);
                    $array['order']['currency'] = sfConfig::get('mod_account_payline_payment_currency');

                    // CARD INFO
                    $array['card']['number'] = $this->credit_card_number;
                    $array['card']['type'] = 'CB';
                    $array['card']['expirationDate'] = $this->credit_card_expire_2 . substr($this->credit_card_expire_3, -2);
                    $array['card']['cvx'] = $this->credit_card_crypto;

                    // BUYER INFO (We do not use wallet)
                    $array['buyer'] = '';
                    $array['address'] = '';

                    // 3D Secure (we don't use this)
                    $array['3DSecure'] = '';

                    // To avoid warnings
                    $array['version'] = '';
                    $array['BankAccountData'] = '';
                    // RESPONSE
                    $txn_status = FALSE;
                    $response = $payline->do_authorization($array);
                    $txn_status = sfConfig::get('mod_account_payline_transaction_status_unknown');
                    if ($response['result']['code'] == '00000' || $response['result']['code'] == '01001') {
                        //Code 01001 theoritically require attention from the merchant
                        $txn_status = sfConfig::get('mod_account_payline_transaction_status_approved');
                        $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_message_transaction_succeeded'));
                        // Operation is successful we notify ARJEL sensor
                        $this->setSensorOperationSuccessStatus();
                    }
                    else {
                        if ($response['result']['code'] == '01940' || $response['result']['code'] == '01942' || $response['result']['code'] == '01943' || $response['result']['code'] == '02101') {
                            //We need to check the status after a while on payline
                            error_log('Warning[' . $response['result']['code'] . '] on payment (' . $response['result']['shortMessage'] . ',' . $response['result']['longMessage'] . ') Order [' . $order_ref . ']');
                            $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_message_transaction_unknown_status'));
                            $txn_status = sfConfig::get('mod_account_payline_transaction_status_pending');
                        }
                        else {
                            //Fatal error, transaction refused or invalid
                            error_log('Error[' . $response['result']['code'] . '] on payment (' . $response['result']['shortMessage'] . ',' . $response['result']['longMessage'] . ') Order [' . $order_ref . ']');
                            $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_message_transaction_failed'));
                            $txn_status = sfConfig::get('mod_account_payline_transaction_status_refused');
                        }
                    }

                    // Ensure no internal, uncaught, exception happened above
                    if ($txn_status != FALSE) {

                        $email = $this->getUser()->getAttribute('email', '', 'subscriber');
                        $params = array(
                            'communityId'     => sfConfig::get('app_sofun_community_id'),
                            'email'           => $email,
                            'txn_amount'      => $this->credit_amount,
                            'txn_currency'    => 'Euro',
                            'txn_date'        => $response['transaction']['date'],
                            'txn_id'          => $response['transaction']['id'],
                            'auth_num'        => $response['authorization']['number'],
                            'order_ref'       => $order_ref,
                            'txn_status_code' => $response['result']['code'],
                            'txn_status'      => $txn_status,
                        );

                        $sofun = BetkupWrapper::_getSofunApp($request, $this);
                        try {
                            $response = $sofun->api_POST("/member/credit", $params);
                        } catch (SofunApiException $e) {
                            error_log($e);
                        }

                        if ($response['http_code'] == '202') {
                            try {
                                $response = $response = $sofun->api_GET("/member/" . $email . "/properties");
                            } catch (SofunApiException $e) {
                                error_log($e);
                            }

                            if ($response['http_code'] == '202') {
                                $member_properties = $response['buffer'];
                                // Update credit in session.
                                $this->getUser()->setAttribute('credit', $member_properties['credit'], 'subscriber');
                                $this->getUser()->setAttribute('transferable_credit', $member_properties['transferable_credit'], 'subscriber');
                                if ($txn_status == sfConfig::get('mod_account_payline_transaction_status_refused')) {
                                    $this->redirect(array(
                                                         'module'  => 'account',
                                                         'action'  => 'credit'
                                                    ));
                                }
                                else {
                                    $register = $this->endswith($request->getReferer(), "registerCredit");
                                    if ($register) {
                                        $this->redirect(array(
                                                             'module' => 'me', 'action'  => 'index'
                                                        ));
                                    }
                                    else {
                                        if ($request->getParameter('parent_referer', '') == 'kup_bet') {
                                            $kup_uuid = $request->getParameter('kup_uuid', '');
                                            $room_uuid = $request->getParameter('room_uuid', '');

                                            if ($room_uuid == '') {
                                                $this->redirect(array(
                                                                     'module'  => 'kup',
                                                                     'action'  => 'bet',
                                                                     'uuid'    => $kup_uuid
                                                                ));
                                            }
                                            else {
                                                $this->redirect(array(
                                                                     'module'    => 'room',
                                                                     'action'    => 'kupBet',
                                                                     'kup_uuid'  => $kup_uuid,
                                                                     'room_uuid' => $room_uuid
                                                                ));
                                            }
                                        }
                                        else if ($request->getParameter('redirect_route', '') == 'room_join') {
                                            $room_uuid = $request->getParameter('room_uuid', '');
                                            $this->redirect($request->getParameter('redirect_route', ''), array('uuid' => $room_uuid));
                                        }
                                        else {
                                            $this->redirect(array(
                                                                 'module'  => 'account',
                                                                 'action'  => 'transaction'
                                                            ));
                                        }
                                    }
                                }
                            }
                            else {
                                error_log($response['buffer']);
                            }
                        }

                    }
                    else {
                        error_log("Seems an error happened while trying to get an auth from the bank... It is usually a symptom of a bad configuration");
                    }
                }
            }

        }

        private function startswith($string, $search) {
            $ret = false;
            if (strlen($string) >= strlen($search)) {
                $ret = (substr($string, 0, strlen($search)) == $search);
            }
            return $ret;
        }

        private function endswith($string, $search) {
            $string = strrev($string);
            $search = strrev($search);
            return $this->startsWith($string, $search);
        }

        /**
         * Member requests confirmation to close his account.
         *
         * @param sfWebRequest $request
         */
        public function executeConfirmCloseRequest($request) {

            $this->ongletActif = 1;
            $this->setAccountTabs();

            // We need to add this to the form as hidden values to be able to trace it sensor side.
            $this->userCredit = $this->getUser()->getAttribute('credit', '', 'subscriber');
            $this->userEmail = $this->getUser()->getAttribute('email', '', 'subscriber');

        }

        /**
         * Member requests to close his account.
         *
         * @param sfWebRequest $request
         */
        public function executeCloseRequest($request) {

            $member_email = $this->getUser()->getAttribute('email', '', 'subscriber');
            $type = $this->getUser()->getAttribute('type', '', 'subscriber');


            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_POST("/member/" . $member_email . "/account/close");
            } catch (SofunApiException $e) {
                error_log($e);
                $this->redirect(array('module' => 'account', 'action' => 'edit'));
            }

            if ($response['http_code'] == '202') {
                if ($type == sfConfig::get('mod_account_registration_account_type_simple')) {
                    $this->setSensorOperationSuccessStatus();
                }
                $this->redirect(array('module' => 'account', 'action' => 'logout'));
            }
            else {
                $this->redirect(array('module' => 'account', 'action' => 'edit'));
            }
        }

        /**
         * Member requests to change his password.
         *
         * @param sfWebRequest $request
         */
        public function executeChangePassword($request) {

            $this->isNoPassword = 0;

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            $member_email = $this->getUser()->getAttribute('email', '', 'subscriber');
            try {
                $response = $sofun->api_GET("/member/" . $member_email . "/properties");
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if (isset($response["buffer"]) && $response["buffer"]["password"] == '') {
                $this->isNoPassword = 1;
            }

            $this->ongletActif = 1;
            $this->setAccountTabs();

            if ($this->isNoPassword == 1) {
                $this->form = new ChangePasswordFormFacebook();
            }
            else {
                $this->form = new changePasswordForm();
            }

            if ($request->isMethod('post')) {

                $this->form->bind($request->getParameter('changePassword'));

                if ($this->form->isValid()) {

                    $values = $this->form->getValues();
                    if ($this->isNoPassword == 1) {
                        $oldPassword = '';
                    }
                    else {
                        $oldPassword = $values['oldPassword'];
                    }
                    $newPassword = $values['newPassword'];
                    $confirmationPassword = $values['confirmationPassword'];

                    if (strlen($newPassword) < 6) {
                        $this->getUser()->setFlash('error', "Votre mot de passe doit contenir au minimum 5 caracères alphanumériques");
                    }
                    else if ($newPassword != $confirmationPassword) {
                        $this->getUser()->setFlash('error', "Veuillez confirmer correctement votre mot de passe svp");
                    }
                    else if ($oldPassword == $newPassword) {
                        $this->getUser()->setFlash('error', "Votre nouveau mot de passe est identique à l'ancien");
                    }
                    else {

                        $this->sofun = BetkupWrapper::_getSofunApp($request, $this);
                        $params = array(
                            'communityId' => sfConfig::get('app_sofun_community_id'),
                            'email'       => $this->getUser()->getAttribute('email', '', 'subscriber'),
                        );
                        $hash_algo = sfConfig::get('app_crypto_password_hash');
                        $params['password'] = hash($hash_algo, $newPassword);

                        if ($this->isNoPassword == 1) {
                            $params['oldPassword'] = '';
                        }
                        else {
                            $params['oldPassword'] = hash($hash_algo, $oldPassword);
                        }

                        $response = $this->sofun->api_POST("/member/edit", $params);
                        $cerror = $response['http_code'];

                        if ($cerror != '202') {
                            $this->getUser()->setFlash('error', $response['buffer']);
                        }
                        else {
                            $this->redirect(array('module' => 'account', 'action' => 'edit'));
                        }
                    }
                }
            }
        }

        /**
         * Members logged in or register using Facebook.
         *
         * <p/>
         *
         * After Facebook connect we check if the Facebook user is already a Sofun Member.
         * If so, we log it. If not, we register him. In this case the Facebook user becomes
         * a simple Betkup user.
         *
         * <p/>
         *
         * This is not using the facebook SDK as we do have problem with it.
         *
         * @param sfWebRequest $request
         */
        public function executeLoginFacebook(sfWebRequest $request) {

            $app_id = sfConfig::get('app_facebook_connect_app_id');
            $app_secret = sfConfig::get('app_facebook_connect_app_secret');
            $app_scope = sfConfig::get('app_facebook_connect_app_scope');
            $my_url = $request->getUriPrefix() . $this->generateUrl('login_facebook');

            $code = "";
            if (isset($_REQUEST["code"])) {
                $code = $_REQUEST["code"];
            }
            if (empty($code)) {
                $this->redirect($this->getFacebookLoginUrl($app_id, $app_scope, $my_url));
            }

            if (isset($_REQUEST['state']) && isset($_SESSION['state']) && $_REQUEST['state'] == $_SESSION['state']) {

                $access_token_array = $this->getFacebookOAuthAccessTokenArray($app_id, $app_secret, $my_url, $code);
                $access_token = "";
                if (isset($access_token_array['access_token'])) {
                    $access_token = $access_token_array['access_token'];
                }
                if (isset($access_token_array['expires'])) {
                    $access_token_expiration = $access_token_array['expires'];
                }

                $cacheKey = 'betkup_login_facebook_infos_for_' . $access_token;
                $oauthData = sfMemcache::getInstance()->get($cacheKey, array());

                if (empty($oauthData)) {
                    $userQuery = 'SELECT uid, username, name, first_name, last_name, pic_small, pic_square, pic_big, birthday_date, email FROM user WHERE uid=me()';
                    $permissionsQuery = 'SELECT ' . str_replace(',', ', ', $app_scope) . ' FROM permissions WHERE uid=me()';
                    $queries = array(
                        'user'          => $userQuery,
                        'permissions'   => $permissionsQuery
                    );

                    $fql_multiquery_url = 'https://graph.facebook.com/'
                        . 'fql?q=' . str_replace(' ', '+', json_encode($queries))
                        . '&access_token=' . $access_token;
                    $fql_multiquery_result = $this->file_get_contents($fql_multiquery_url);
                    $user_and_permissions = json_decode($fql_multiquery_result, true);
                    $user_and_permissions = $user_and_permissions['data'];
                }
                else {
                    $user_and_permissions = $oauthData['userData'];
                }

                $userInfos = array();
                $permissionsInfos = array();
                foreach ($user_and_permissions as $userPerms) {

                    if ($userPerms['name'] == 'permissions' && count($userPerms['fql_result_set']) == 0) {
                        $this->redirect($this->getFacebookLoginUrl($app_id, $app_scope, $my_url));
                    }
                    if ($userPerms['name'] == 'user') {
                        $userInfos = $userPerms['fql_result_set'][0];
                    }
                    if ($userPerms['name'] == 'permissions') {
                        $permissionsInfos = $userPerms['fql_result_set'][0];
                    }
                }

                $user = $userInfos;
                $email = $user['email'];
                $fb_id = $user['uid'];
                $birthdate = $user['birthday_date'];

                $params = array(
                    'communityId' => sfConfig::get('app_sofun_community_id'),
                    'email'       => $email,
                    'facebookId'  => $fb_id,
                    'accessToken' => $access_token,
                    'birthdate'   => $birthdate,
                );

                $sofun = BetkupWrapper::_getSofunApp($request, $this);
                $resp = $sofun->api_GET("/member/facebook/exists/" . $fb_id);

                if ($resp["http_code"] == "202") {

                    try {
                        $response = $sofun->login($params);
                    } catch (SofunApiException $e) {
                        error_log($e);
                        $this->redirect(array('module' => 'account', 'action' => 'login'));
                    }

                    if ($response['http_code'] == '202') {

                        $sofun_member = $response['buffer'];
                        BetkupWrapper::_setSofunSession($sofun->getSession(), $this);
                        $this->_postLogin($request, $sofun_member);

                        if (empty($oauthData)) {
                            $this->setFacebookCache($cacheKey, $user_and_permissions, $access_token, $access_token_expiration);
                        }

                        $this->setCustomFlashActions($request, 'flash_notice_member_logged_in');

                        $this->redirectIfLoginSuccess('@dashboard', 302, 200);
                    }
                    else {

                        $this->getUser()->setFlash('error', $response['buffer']);
                        $this->redirect(array('module' => 'account', 'action' => 'login'));
                    }
                }
                else {

                    try {
                        $response = $sofun->api_POST("/member/register/facebook", $params);
                    } catch (SofunApiException $e) {
                        error_log($e);
                        $this->redirect(array('module' => 'account', 'action' => 'login'));
                    }

                    if ($response['http_code'] == '202') {
                        $sofun_member = $response['buffer'];
                        $this->_postLogin($request, $sofun_member);

                        // Specify to tracking filter that the registration has succeed.
                        $this->getUser()->setAttribute(sfConfig::get('app_tracking_filter_registration_simple_complete'), 'success', 'tracking_filter');

                        if (empty($oauthData)) {
                            $this->setFacebookCache($cacheKey, $user_and_permissions, $access_token, $access_token_expiration);
                        }

                        $this->setCustomFlashActions($request, 'flash_notice_member_logged_in');
                        $this->redirectIfLoginSuccess('@dashboard', 302, 200);
                    }
                    else {
                        $this->getUser()->setFlash('error', $response['buffer']);
                        $this->redirect(array('module' => 'account', 'action' => 'login'));
                    }
                }
            }
            else {
                error_log("The state does not match. You may be a victim of CSRF. Facebook Connect action.");
            }

            // Here to avoid Symfony errors.
            $this->setTemplate('login');
        }

        /**
         * Check if a nick name exists.
         *
         * <p/>
         *
         * Nickname is extracted from the request.
         * A call to the Sofun platform is performed.
         *
         * @param sfWebRequest $request
         */
        public function executeExistsNickname($request) {
            $this->accountPseudo = $request->getParameter('accountPseudo');
            $this->sofun = BetkupWrapper::_getSofunApp($request, $this);
            $resp = $this->sofun->api_GET("/member/pseudo/exists/" . urlencode($this->accountPseudo));
            if ($resp["http_code"] == "202") {
                $this->pseudoExist = 'true';
            }
            else {
                $this->pseudoExist = 'false';
            }
            ;

            return $this->renderText($this->pseudoExist);
        }

        /**
         * Links a Betkup Account to a Facebook one.
         *
         * @param sfWebRequest $request
         */
        public function executeLinkToFacebook($request) {

            $app_id = sfConfig::get('app_facebook_connect_app_id');
            $app_secret = sfConfig::get('app_facebook_connect_app_secret');
            $app_scope = sfConfig::get('app_facebook_connect_app_scope');
            $my_url = $request->getUriPrefix() . $this->getController()->genUrl('linking_facebook');

            session_start();

            $code = $_REQUEST["code"];
            if (empty($code)) {

                $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
                $dialog_url = "http://www.facebook.com/dialog/oauth?scope="
                    . $app_scope . "&client_id="
                    . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
                    . $_SESSION['state'];
                echo("<script> top.location.href='" . $dialog_url . "'</script>");
                exit();
            }

            if ($_REQUEST['state'] == $_SESSION['state']) {

                $token_url = "https://graph.facebook.com/oauth/access_token?"
                    . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
                    . "&client_secret=" . $app_secret . "&code=" . $code;

                //$response = file_get_contents($token_url);
                $response = $this->file_get_contents($token_url);
                $params = null;
                parse_str($response, $params);
                $access_token = $params['access_token'];

                $graph_url = "https://graph.facebook.com/me?access_token="
                    . $access_token;

                $user = json_decode($this->file_get_contents($graph_url));

                // We preserve the email of the current account.
                $email = $member_email = $this->getUser()->getAttribute('email', '', 'subscriber');
                $fb_id = $user->id;

                $params = array(
                    'communityId' => sfConfig::get('app_sofun_community_id'),
                    'email'       => $email,
                    'facebookId'  => $fb_id,
                    'accessToken' => $access_token,
                );

                $sofun = BetkupWrapper::_getSofunApp($request, $this);
                $resp = $sofun->api_GET("/member/facebook/exists/" . $fb_id);
                if ($resp["http_code"] == "202") {
                    $notice = $this->getContext()->getI18n()->__("flash_error_facebook_account_already_linked");
                    $this->getUser()->setFlash('error', $notice);
                    $this->redirect(array('module' => 'account', 'action' => 'privacy'));
                }
                else {

                    try {
                        $response = $sofun->api_POST("/member/link/facebook", $params);
                    } catch (SofunApiException $e) {
                        error_log($e);
                        $this->redirect(array('module' => 'account', 'action' => 'login'));
                    }

                    if ($response['http_code'] == '202') {
                        $sofun_member = $response['buffer'];
                        $this->getUser()->setAttribute('facebookId', $sofun_member['facebookId'], 'subscriber');
                        $this->getUser()->setAttribute('facebookName', $user->name, 'subscriber');
                        $this->redirect(array('module' => 'account', 'action' => 'privacy'));
                    }
                    else {
                        $this->getUser()->setFlash('error', $response['buffer']);
                        $this->redirect(array('module' => 'account', 'action' => 'login'));
                    }
                }
            }
            else {
                error_log("The state does not match. You may be a victim of CSRF.");
            }

            // Here to avoid Symfony errors.
            $this->setTemplate('privacy');
        }

        /**
         * Unlink a Facebook account from a Betkup account.
         *
         * @param sfWebRequest $request
         */
        public function executeUnlinkFromFacebook($request) {


            // We preserve the email of the current account.
            $email = $member_email = $this->getUser()->getAttribute('email', '', 'subscriber');
            $fbId = $this->getUser()->getAttribute('facebookId', '', 'subscriber');

            $params = array(
                'communityId' => sfConfig::get('app_sofun_community_id'),
                'email'       => $email,
                'facebookId'  => $fbId,
            );

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            $resp = $sofun->api_GET("/member/facebook/exists/" . $fbId);
            if ($resp["http_code"] != "202") {
                $notice = $this->getContext()->getI18n()->__("flash_error_facebook_account_already_unlinked");
                $this->getUser()->setFlash('error', $notice);
                $this->getUser()->setAttribute('facebookId', '', 'subscriber');
                $this->getUser()->setAttribute('facebookName', '', 'subscriber');
                $this->redirect(array('module' => 'account', 'action' => 'privacy'));
            }
            else {

                try {
                    $response = $sofun->api_POST("/member/unlink/facebook", $params);
                } catch (SofunApiException $e) {
                    error_log($e);
                    $this->redirect(array('module' => 'account', 'action' => 'login'));
                }

                if ($response['http_code'] == '202') {
                    $sofun_member = $response['buffer'];
                    $this->getUser()->setAttribute('facebookId', '', 'subscriber');
                    $this->getUser()->setAttribute('facebookName', '', 'subscriber');
                    $this->redirect(array('module' => 'account', 'action' => 'privacy'));
                }
                else {
                    $this->getUser()->setFlash('error', $response['buffer']);
                    $this->redirect(array('module' => 'account', 'action' => 'login'));
                }
            }

            // Here to avoid Symfony errors.
            $this->setTemplate('privacy');
        }

        /**
         * Member logout
         *
         * @param sfWebRequest $request
         */
        public function executeLogout($request) {

            $email = $this->getUser()->getAttribute('email', '', 'subscriber');
            $facebookId = $this->getUser()->getAttribute('facebookId', '', 'subscriber');

            if ($this->getUser()->isAuthenticated()) {
                $this->getUser()->setAuthenticated(false);
            }

            $this->getUser()->clearCredentials();
            $this->getUser()->getAttributeHolder()->removeNamespace('subscriber');

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $session = $sofun->getSession();
                $session['email'] = $email;
                $session['facebookId'] = $facebookId;
                $sofun->setSession($session);
                $response = $sofun->logout();
            } catch (SofunApiException $e) {
                error_log("An error occured trying to log out user platform side.");
                error_log($e);
            }

            // Delete last url cookie if exist
            if (isset($_COOKIE[sfConfig::get('app_redirection_filter_last_url_cookie_name')])) {
                $this->getResponse()->setcookie(sfConfig::get('app_redirection_filter_last_url_cookie_name'), FALSE, $_SERVER['REQUEST_TIME'] - 86400 * 60, '/', $request->getHost(), true);
                unset($_COOKIE[sfConfig::get('app_redirection_filter_last_url_cookie_name')]);
            }
            $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__("flash_notice_member_logged_out"));
            $this->redirect(array('module' => 'home', 'action' => 'index'));

            $this->setTemplate('login');
        }


        /**
         * Search cities by name and return them in json format
         *
         * @param sfWebRequest $request
         *
         * @return Ambigous <sfView::NONE, string>|string
         */
        public function executeSearchCity(sfWebRequest $request) {
            if ($request->isXmlHttpRequest()) {
                $cityName = $request->getParameter('city_name', '');
                $this->cities = Data::searchByCityName($cityName);

                return $this->renderText(json_encode($this->cities));
            }
            else {
                // Otherwise, return nothing
                return sfView::NONE;
            }

        }

    }
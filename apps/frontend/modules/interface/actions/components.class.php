<?php

    class interfaceComponents extends sfComponents {

        /**
         * Area 1 : start
         * This area is user in page Room View
         * Elle permet d'afficher la grande zone de gauche
         * contenant le content principal
         */
        public function executeAreaOneBegin() {
            if (!isset ($this->margintop)) {
                $this->margintop = 0;
            }
            if (!isset ($this->marginleft)) {
                $this->marginleft = 33;
            }
            if (!isset ($this->header)) {
                $this->header = '';
            }
            if (!isset ($this->displayTop)) {
                $this->displayTop = true;
            }
        }

        /**
         * Area 1 : end
         */
        public function executeAreaOneEnd() {
        }

        public function executeButtonText() {

            if (!isset ($this->name)) {
                $this->name = "Name";
            }

            if (!isset ($this->href)) {
                $this->href = '#';
            }
        }

        public function executeWidget() {

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }

            // Properties must to be sent out to ARJEL sensor for XML Trace generation (MODIFINFOPERSO)
            // Only if account type is gambling
            if ($this->getUser()->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_account_registration_account_type_gambling_fr')) {
                $this->userFirstName = $this->getUser()->getAttribute('firstName', '', 'subscriber');
                $this->userLastName = $this->getUser()->getAttribute('lastName', '', 'subscriber');
                $this->userEmail = $this->getUser()->getAttribute('email', '', 'subscriber');
                $this->userNickName = $this->getUser()->getAttribute('nickName', '', 'subscriber');
                $this->userTitle = $this->getUser()->getAttribute('title', '', 'subscriber');
                $this->userAddress = $this->getUser()->getAttribute('address_street', '', 'subscriber');
                $this->userZip = $this->getUser()->getAttribute('address_zip', '', 'subscriber');
                $this->userCountry = $this->getUser()->getAttribute('address_country', '', 'subscriber');
                $this->userCity = $this->getUser()->getAttribute('address_city', '', 'subscriber');
            }
            else {
                $this->userFirstName = "";
                $this->userLastName = "";
                $this->userEmail = "";
                $this->userNickName = "";
                $this->userTitle = "";
                $this->userAddress = "";
                $this->userZip = "";
                $this->userCountry = "";
                $this->userCity = "";
            }

        }

        public function executeEditingFieldWidget() {

            if (!isset($this->class)) {
                $this->class = '';
            }
            if (!isset ($this->width)) {
                $this->width = "222";
            }
            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }
            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }
        }

        public function executeEditingRadioWidget() {
            if (!isset($this->class)) {
                $this->class = '';
            }
            if (!isset ($this->width)) {
                $this->width = "222";
            }
            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }
            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }
        }

        public function executeAvatar() {

            if (!isset ($this->width)) {
                $this->width = "222";
            }
            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }
            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }
            $this->avatar = $this->getUser()->getAttribute('avatar', '', 'subscriber');
        }

        public function executeSimpleWidget() {

            // Use to specify the blocName authorized to add auto suggest module
            $this->autoSuggestBlocName = array('accountCity', 'accountBirthplace');
            $this->inArray = false;
            if (in_array($this->blocName, $this->autoSuggestBlocName)) {
                $this->inArray = true;
            }

            if (!isset ($this->blocType)) {
                $this->blocType = "";
            }

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "470";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }

            if (!isset ($this->widthGadget)) {
                $this->widthGadget = "238";
            }

            if (!isset ($this->heightGadget)) {
                $this->heightGadget = "27";
            }

            if (!isset ($this->width1)) {
                $this->width1 = "220";
            }

            if (!isset ($this->width2)) {
                $this->width2 = "252";
            }

            if (!isset ($this->width3)) {
                $this->width3 = "";
            }

            if (!isset ($this->option)) {
                $this->option = "";
            }

            if (!isset ($this->display)) {
                $this->display = true;
            }
        }

        /**
         * Popup accept gain
         */
        public function executeNotificationsPopup() {
            if ($this->getUser()->getAttribute('account_type', '', 'subscriber') == 'GAMBLING_FR') {
                $this->userEmail = $this->getUser()->getAttribute('email', '', 'subscriber');
            }
            else {
                $this->userEmail = "";
            }
        }

        public function executeRadio() {

            if (!isset ($this->width)) {
                $this->width = "160";
            }

            if (!isset ($this->width1)) {
                $this->width1 = "220";
            }

            if (!isset ($this->width2)) {
                $this->width2 = "252";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }
        }

        public function executeWidgetCheckbox() {
            if (!isset ($this->width)) {
                $this->width = "160";
            }
            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }
            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }
        }

        public function executeWidgetDownload() {

            if (!isset($this->formId)) {
                $this->formId = '';
            }

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->width1)) {
                $this->width1 = "220";
            }

            if (!isset ($this->width2)) {
                $this->width2 = "252";
            }

            if (!isset ($this->width3)) {
                $this->width3 = "";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "470";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }

            if (!isset ($this->widthGadget)) {
                $this->widthGadget = "238";
            }

            if (!isset ($this->heightGadget)) {
                $this->heightGadget = "27";
            }

            if (!isset ($this->option)) {
                $this->option = "";
            }

            if (!isset ($this->col2_align)) {
                $this->col2_align = "right";
            }

            if (!isset ($this->img_width)) {
                $this->img_width = "213";
            }

            if (!isset ($this->img_height)) {
                $this->img_height = "131";
            }

            if (!isset ($this->withThumb)) {
                $this->withThumb = true;
            }

            if (!isset($this->uploadPath)) {
                $this->uploadPath = "";
            }

            if (!isset($this->uploadName)) {
                $this->uploadName = "";
            }

        }

        public function executeWidgetTextarea() {

            if (!isset ($this->blocType)) {
                $this->blocType = "";
            }

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "470";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }

            if (!isset ($this->widthGadget)) {
                $this->widthGadget = "238";
            }

            if (!isset ($this->heightGadget)) {
                $this->heightGadget = "27";
            }

            if (!isset ($this->width1)) {
                $this->width1 = "220";
            }

            if (!isset ($this->width2)) {
                $this->width2 = "252";
            }

            if (!isset ($this->width3)) {
                $this->width3 = "";
            }

            if (!isset ($this->option)) {
                $this->option = "";
            }

            if (!isset ($this->col2_align)) {
                $this->col2_align = "right";
            }
        }

        public function executeDate() {

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }

            if (!isset ($this->widthGadget)) {
                $this->widthGadget = "245";
            }

            if (!isset ($this->width1)) {
                $this->width1 = "160";
            }

            if (!isset ($this->width2)) {
                $this->width2 = "252";
            }

            if (!isset ($this->width3)) {
                $this->width3 = "";
            }
        }

        public function executeCbExpiration() {

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }

            if (!isset ($this->widthGadget)) {
                $this->widthGadget = "245";
            }

            if (!isset ($this->width2)) {
                $this->width2 = "252";
            }

            if (!isset ($this->width3)) {
                $this->width3 = "";
            }
        }


        /**
         * Function executeSelect
         * seting default parameter for _select component
         * _select is used for styling an html select box
         * It sets default parameters in use within the _select template.
         */
        public function executeSelect() {

            // Authorized blocks: used by the `selectmenuMiddle` Javascript function to decide which display style to apply
            // for html select box. The array collection relates to the block (id of the select component) and how it will
            // use the "selectmenuMiddle" function. The blocks are the id of the select box
            $this->authorizedBlocs = array(
                'credit_select', 'home_kup_select', 'home_ranking_select', 'kup',
                'kups_status_select'
            );

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }

            if (!isset ($this->blocValueDefault)) {
                $this->blocValueDefault = "";
            }

            if (!isset ($this->width3)) {
                $this->width3 = "";
            }
        }

        public function executeCountries() {

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }

            if (!isset ($this->blocValueDefault)) {
                $this->blocValueDefault = "";
            }

            if (!isset ($this->width3)) {
                $this->width3 = "";
            }
        }

        public function executeCountriesEdit() {

            $this->countries = Data::ISOCountries();

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }

            if (!isset ($this->blocValueDefault)) {
                $this->blocValueDefault = "";
            }

            if (!isset ($this->width3)) {
                $this->width3 = "";
            }
        }

        public function executeTextarea() {

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }
        }

        public function executeRib() {

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }
        }

        public function executeIban() {

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }
        }

        public function executeCaptcha() {

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = $this->getContext()->getI18n()->__('captcha_message_error');
            }
        }

        public function executeCaptchaPassword() {

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "460";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = $this->getContext()->getI18n()->__('captcha_message_error');
            }
        }

        public function executeTableau() {

        }

        public function executeAccept() {

        }

        public function executeHeader() {

        }

        public function executeWidgetTags() {

        }

        public function executeWidgetChoices() {

            if (!isset ($this->data ["scrollbars"])) {
                $this->data ["scrollbars"] = false;
            }
            $this->selectedDatas = array(
                sfConfig::get('app_kup_search_params_sports') . '_' . sfConfig::get('app_params_type_sports_all'),
                sfConfig::get('app_kup_search_params_sorting') . '_MEMBERS',
                'CATEGORY_ALL',
                'ACCESS_PUBLIC'
            );
            if (!isset($this->width)) {
                $this->width = 208;
            }
        }

        public function executeTag() {

        }

        public function executeFlashMessage() {

        }

        public function executeAccountFacebookNolink() {

        }

        public function executeAccountFacebookLinked() {

        }

        public function executeAccountGamblingButtons() {

        }

        public function executeBlockPseudo() {

            if (!isset ($this->blocType)) {
                $this->blocType = "";
            }

            if (!isset ($this->width)) {
                $this->width = "222";
            }

            if (!isset ($this->marginLeftError)) {
                $this->marginLeftError = "470";
            }

            if (!isset ($this->messageError)) {
                $this->messageError = "Message Error";
            }

            if (!isset ($this->widthGadget)) {
                $this->widthGadget = "195";
            }

            if (!isset ($this->heightGadget)) {
                $this->heightGadget = "23";
            }

            if (!isset ($this->width1)) {
                $this->width1 = "160";
            }

            if (!isset ($this->width2)) {
                $this->width2 = "252";
            }

            if (!isset ($this->width3)) {
                $this->width3 = "";
            }

            if (!isset ($this->option)) {
                $this->option = "";
            }
        }

        public function executeChrono() {

        }

        public function executeTitle() {
            if (!isset($this->culture)) {
                $this->culture = "default";
            }
            if (!isset($this->startY)) {
                $this->startY = "0";
            }
            if (!isset($this->height)) {
                $this->height = 67 + $this->startY;
            }
        }

        /**
         * Redirects a member from a given URL.
         *
         * <p>
         *
         * Typicaly, redirects to a login page when the user is not logged in or unauthorized.
         */
        public function executeRedirect() {
            if (!isset($this->url)) {
                $this->url = $this->generateUrl('sf_guard_signin');
            }
        }

        public function executePagination() {
            if (!isset($this->totalKups)) {
                $this->totalKups = 0;
            }
            if (!isset($this->offset)) {
                $this->offset = 0;
            }
            if (!isset($this->batchSize)) {
                $this->batchSize = 7;
            }
            if (!isset($this->functionKupsLoad)) {
                $this->functionKupsLoad = 'loadKups';
            }
            if (!isset($this->pagerSize)) {
                $this->pagerSize = round($this->totalKups / $this->batchSize);
            }
        }

        public function executeUserAvatar() {
            if (!isset($this->class)) {
                $this->class = '';
            }
            if(!isset($this->id)) {
                $this->id = 'default';
            }
            if (!isset($this->style)) {
                $this->style = '';
            }
            if (!isset($this->alt)) {
                $this->alt = 'Avatar utilisateur'; //XXX i18n
            }
            if (!isset($this->avatarPath)) {
                $this->avatarPath = '';
            }
            if (!isset($this->canvasSize)) {
                $this->canvasSize = '150x150';
            }
            if (!isset($this->wAnimateTo)) {
                $this->wAnimateTo = 0;
            }
            if (!isset($this->hAnimateTo)) {
                $this->hAnimateTo = 0;
            }
            $animate = $this->wAnimateTo + $this->hAnimateTo;
            $this->isAnimate = false;
            if ($animate > 0) {
                $this->isAnimate = true;
            }

            $this->sizeAnimateTo = $this->wAnimateTo . 'x' . $this->hAnimateTo;

            // Determine the new size for the image, depending on canvas size.
            $this->avatarSize = '150x150';
            list($this->cWidth, $this->cHeight) = explode('x', $this->canvasSize);
            list($iWidth, $iHeight) = explode('x', $this->avatarSize);

            if($iWidth > $this->cWidth || $iHeight > $this->cHeight) {
                $this->avatarSize = $this->cWidth.'x'.$this->cHeight;
            }
        }

    }
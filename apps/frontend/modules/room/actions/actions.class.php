<?php

    /**
     * Room actions.
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
     * @subpackage room
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: actions.class.php 6416 2012-11-05 17:20:47Z jmasmejean $
     */
    class roomActions extends betkupActions {

        /**
         * Returns the room UUID from a room context.
         *
         * The URL pattern is:
         *
         *     /room/<uuid>/<action>
         *
         * @return int or -1 if not found
         */
        private function getRoomUUID() {
            $uuid = -1;
            $action = $this->getContext()->getActionName();
            if (in_array($action, array(
                                       'view', 'edit', 'delete', 'members', 'kups', 'join', 'leave',
                                       'kupsNews', 'roomKupsRanking'
                                  ))
            ) {
                $uuid = $this->getContext()->getRequest()->getParameter("uuid", -1);
            }
            return $uuid;

        }

        /**
         * Does a team name already exists?
         *
         * @param sfWebRequest $request
         */
        public function executeExistsRoomName(sfWebRequest $request) {
            $name = $request->getParameter('name');
            $exists = $this->existsRoomName($request, $name);
            return $this->renderText($exists);
        }

        /**
         * Does a team name already exists?
         *
         *
         * @param sfWebRequest $request
         * @param str          $name
         */
        private function existsRoomName(sfWebRequest $request, $name) {
            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_GET("/team/exists/name/" . urlencode($name));
            } catch (SofunApiException $e) {
                error_log($e);
            }
            if ($response["http_code"] == "202") {
                $exists = 'true';
            }
            else {
                $exists = 'false';
            }
            return $exists;
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
                    }
                    else {
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
                    }
                    else {
                        $query = $query . "#" . $key;
                    }
                }
            }
            return $query;
        }

        /**
         * Executes index action
         *
         * Redirects to home.
         *
         * @param sfWebRequest
         */
        public function executeIndex(sfWebRequest $request) {
            $this->redirect(array('module' => 'room', 'action' => 'home'));
        }

        /**
         * Default view for a room.
         *
         * /room/view/<uuid>
         *
         * @param uuid
         */
        public function executeView(sfWebRequest $request) {

            $start = $this->timeStamp();

            $this->roomUI = $request->getAttribute('roomUI', '');
            $uuid = $this->getRoomUUID($request);
            if ($uuid == -1) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_missing_room_uuid'));
                $this->redirect(array('module' => 'room', 'action' => 'home'));
            }

            $room = $this->getRoom($request, $uuid);
            $this->dataRoom = $this->getRoomDataForWidget($room);
            $this->dataTabs = $this->getViewTabs($uuid);

            //SEO, make title and description dynamic.
            $this->setTitleDescriptionSEOFor("rooms", "view", $this->dataRoom);

            $isChallenge = isset($this->roomUI['isChallenge']) ? $this->roomUI['isChallenge'] : false;
            if (!$isChallenge) {
                // Get front kups data
                $this->kupsData = $this->getRoomKups($request, array(
                                                                    'uuid'          => $uuid,
                                                                    'offset'        => 0,
                                                                    'batchSize'     => 3,
                                                                    'with_security' => false
                                                               ));

                $this->filteredKupsData = $this->filterRoomHomeKups($this->kupsData);

                $this->needAdvancedAccount = false;
                if ($this->roomUI != '' && isset($this->roomUI['needAdvancedAccount']) && $this->roomUI['needAdvancedAccount'] == true) {
                    $this->needAdvancedAccount = true;
                }
            }
            else {
                $this->kupsData = array();
                $this->filteredKupsData = array();
                $this->needAdvancedAccount = false;
            }
            $this->joinUrl = $this->getController()->genUrl(array(
                                                                 'module' => 'room',
                                                                 'action' => 'join',
                                                                 'uuid'   => $this->dataRoom['id']
                                                            ));
            if ($this->needAdvancedAccount) {
                $this->joinUrl = $this->generateUrl('room_join_advanced_account', array(
                                                                                       'uuid'                  => $this->dataRoom['id'],
                                                                                       'need_advanced_account' => 1,
                                                                                       'redirect_route'        => 'room_join'
                                                                                  ));
            }

            $this->setRoomView($this->roomUI);
            $check1 = $this->timeStamp();
            error_log("Checkpoint ...  " . round($check1 - $start,4));
        }

        private function setRoomView($roomUI = '') {
            $this->roomModuleName = 'room';
            $this->roomComponentName = 'roomView';
            if ($roomUI != '') {
                if (isset($roomUI['room_view'])) {
                    $explodeRoomView = explode(',', $roomUI['room_view']);
                    $this->roomModuleName = $explodeRoomView[0];
                    $this->roomComponentName = $explodeRoomView[1];
                }
            }
        }

        /**
         * General ranking view for a room
         *
         * @param sfWebRequest $request
         */
        public function executeRoomKupsRanking(sfWebRequest $request) {

            $this->roomUI = $request->getAttribute('roomUI', '');
            $this->room_uuid = $this->getRoomUUID($request);
            if ($this->room_uuid == -1) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_missing_room_uuid'));
                $this->redirect(array('module' => 'room', 'action' => 'home'));
            }

            $room = $this->getRoom($request, $this->room_uuid);
            $this->dataRoom = $this->getRoomDataForWidget($room);
            $this->dataTabs = $this->getViewTabs($this->room_uuid);

            //SEO, make title and description dynamic.
            $this->setTitleDescriptionSEOFor("rooms", "ranking", $this->dataRoom);

            $this->kupsData = $this->getRoomKups($request, array('uuid' => $this->room_uuid));
            $this->filteredKupsData = $this->filterRoomHomeKups($this->kupsData);

            $this->needAdvancedAccount = false;
            if ($this->roomUI != '' && isset($this->roomUI['needAdvancedAccount']) && $this->roomUI['needAdvancedAccount'] == true) {
                $this->needAdvancedAccount = true;
            }

            $this->joinUrl = $this->getController()->genUrl(array(
                                                                 'module' => 'room',
                                                                 'action' => 'join',
                                                                 'uuid'   => $this->dataRoom['id']
                                                            ));
            if ($this->needAdvancedAccount) {
                $this->joinUrl = $this->generateUrl('room_join_advanced_account', array(
                                                                                       'uuid'                  => $this->dataRoom['id'],
                                                                                       'need_advanced_account' => 1,
                                                                                       'redirect_route'        => 'room_join'
                                                                                  ));
            }
        }


        /**
         * Room kups general ranking action.
         *
         * @param sfWebRequest $request
         */
        public function executeRoomKupsGeneralRanking(sfWebRequest $request) {
            $this->offset = $request->getParameter('offset', 0);
            $this->batchSize = $request->getParameter('batchSize', 10);
            $this->room_uuid = $request->getParameter('room_uuid', '');
            $this->roomData = $request->getParameter('room_data', array());
            $this->totalRanking = $this->roomData['numberOfMembers'];

            $this->roomRanking = $this->getRoomRankingFor($request, $this->room_uuid, $this->offset, $this->batchSize);

            $this->offsetMemberRanking = 0;
            if ($this->roomRanking['memberPosition'] != 0) {
                $this->offsetMemberRanking = (ceil($this->roomRanking['memberPosition'] / $this->batchSize) - 1) * $this->batchSize;
            }
        }

        /**
         * Get list of tabs to display for room homepage
         *
         * @param int $uuid
         *
         * @return array
         */
        private function getViewTabs($uuid) {
            return array(
                'tab1' => array(
                    'id'    => '1',
                    'label' => $this->getContext()->getI18n()->__('label_tab_room_home'),
                    'link'  => array('module' => 'room', 'action' => 'view', 'uuid' => $uuid),
                ),
                'tab2' => array(
                    'id'    => '2',
                    'label' => $this->getContext()->getI18n()->__('label_tab_room_kup_actuality'),
                    'link'  => array('module' => 'room', 'action' => 'kupsNews', 'uuid' => $uuid),
                ),
                'tab3' => array(
                    'id'    => '3',
                    'label' => $this->getContext()->getI18n()->__('label_tab_room_ranking'),
                    'link'  => array(
                        'module' => 'room', 'action' => 'roomKupsRanking', 'uuid' => $uuid
                    ),
                )
            );
        }


        /**
         * Sorting for Kups. Filter and sort by status.
         *
         * @param array $kupsData
         * @param int   $limit
         *
         * @return array $filterKups
         */
        private function filterRoomHomeKups($kupsData, $limit = 3) {
            $filterKups = array();
            $filterStatus = array();
            $canceledKups = array();
            foreach ($kupsData as $key => $kupData) {
                $filterStatus[$key] = $kupData['status'];
            }
            asort($filterStatus);
            $i = 0;
            $c = 0;
            foreach ($filterStatus as $key => $status) {
                if ($i == $limit) {
                    break;
                }

                if ($status == -1) {
                    $canceledKups[$c] = $kupsData[$key];
                    $c++;
                }
                else {
                    $filterKups[$i] = $kupsData[$key];
                    $i++;
                }
            }
            // If there are less than 3 available kups, we merge available kups with canceled ones
            if (count($filterKups) < $limit) {
                $a = 0;
                for ($j = 0; $j < $limit; $j++) {
                    if (!isset($filterKups[$j])) {
                        if (isset($canceledKups[$a])) {
                            $filterKups[$j] = $canceledKups[$a];
                            $a++;
                        }
                        else {
                            break;
                        }
                    }
                }
                // If filtered kups is still less than $limit
                if (count($filterKups) < $limit) {
                    for ($i = count($filterKups); $i < $limit; $i++) {
                        $filterKups[$i] = 'specimen';
                    }
                }
            }
            return $filterKups;
        }

        /**
         * Show kups & news for a room.
         *
         * @param $request
         */
        public function executeKupsNews(sfWebRequest $request) {

            $this->roomUI = $request->getAttribute('roomUI', '');
            $uuid = $this->getRoomUUID($request);
            if ($uuid == -1) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_missing_room_uuid'));
                $this->redirect(array('module' => 'room', 'action' => 'home'));
            }

            $room = $this->getRoom($request, $uuid);
            $this->dataRoom = $this->getRoomDataForWidget($room);
            $this->dataTabs = $this->getViewTabs($uuid);

            //SEO, make title and description dynamic.
            $this->setTitleDescriptionSEOFor("rooms", "kups_news", $this->dataRoom);

            // XXX Should not be loaded from here.
            // Get Betkup activity feed data
            //$feed = $this->getRoomFeedData($request, $uuid);
            //$this->feedData = $this->getFeedData($request, $feed);
            $this->feedData = array();

            // Get betkup community ranking data
            //$ranking = $this->getRoomRanking($request, $uuid, $this->offset, $this->batch);
            //$this->rankingData = $this->getRankingData($request, $ranking);
            $this->rankingData = array();
            // END XXX Should not be loaded from here.

            $this->needAdvancedAccount = false;
            if ($this->roomUI != ''
                && isset($this->roomUI['needAdvancedAccount'])
                && $this->roomUI['needAdvancedAccount'] == true) {
                $this->needAdvancedAccount = true;
            }

            if(!isset($this->kupsNames)) {
                $this->kupsNames = '';
            }

        }

        /**
         * list kups in room/members.
         *
         * @param sfWebRequest $request
         */
        public function executeListPlayers(sfWebRequest $request) {

            // TODO implement me

            $this->uuid = $request->getParameter('uuid');
            $this->kup = $request->getParameter('kup');

            if ($this->kup == '') {
                $this->kups_players = array(
                    array(
                        'avatar'              => '/image/default/room/members_avatar.png',
                        'member_name'         => 'Adrien 94',
                        'member_statut'       => 'Participe',
                        'member_statut_style' => 'statut1',
                        'link_image'          => '',
                        'link'                => '',
                    ),
                    array(
                        'avatar'              => '/image/default/room/members_avatar.png',
                        'member_name'         => 'DarkSign',
                        'member_statut'       => 'Ne participe pas',
                        'member_statut_style' => 'statut2',
                        'link_image'          => '/image/' . $this->getUser()->getCulture() . '/room/members_button_right_send_invitation.png',
                        'link'                => array(
                            'module' => 'room', 'action' => 'members', 'uuid' => $this->uuid
                        ),
                    ),
                    array(
                        'avatar'              => '/image/default/room/members_avatar.png',
                        'member_name'         => 'DarkSign',
                        'member_statut'       => 'Ne participe vraiment pas',
                        'member_statut_style' => 'statut3',
                        'link_image'          => '/image/' . $this->getUser()->getCulture() . '/room/members_button_right_send_invitation.png',
                        'link'                => array(
                            'module' => 'room', 'action' => 'members', 'uuid' => $this->uuid
                        ),
                    ),
                );
            }
            else {
                $this->kups_players = array(
                    array(
                        'avatar'              => '/image/default/room/members_avatar.png',
                        'member_name'         => 'Adrien 94',
                        'member_statut'       => 'Participe',
                        'member_statut_style' => 'statut1',
                        'link_image'          => '',
                        'link'                => '',
                    ),
                );
            }

        }

        /**
         * Execute cropFile action.
         * Crop the avatar and create the thumb associate. Save them into avatar directory.
         *
         * @param sfWebRequest $request
         *
         * @return JSON
         */
        public function executeCropFile(sfWebRequest $request) {
            if ($request->isXmlHttpRequest()) {
                $cerror = '202';

                $x = $request->getParameter('x', '');
                $y = $request->getParameter('y', '');
                $w = $request->getParameter('w', '');
                $h = $request->getParameter('h', '');

                $uploadPath = $request->getParameter('upload_path', '');
                $uploadName = $request->getParameter('upload_name', '');
                $avatar = $uploadPath . $uploadName;
                $filename = sfConfig::get('sf_web_dir') . $avatar;

                $withThumb = $request->getParameter('with_thumb', true);
                $minWidth = $request->getParameter('min_width', 0);
                $minHeight = $request->getParameter('min_height', 0);

                $imageSource = $request->getParameter('image_source', '');
                $imageName = $request->getParameter('image_name', '');

                if ($uploadPath == '') {
                    $imageName = time() . '_' . $imageName;
                    $avatar = $this->getAvatarPath($imageName);
                    $filename = $this->getAvatarFileNameFor($imageName);
                }
                else {
                    $imageName = $uploadName;
                }
                if ($withThumb) {
                    $avatarThumb = $this->getAvatarPath('thumb_' . $imageName);
                    $fileNameThumb = $this->getAvatarFileNameFor('thumb_' . $imageName);
                }
                $picture = new Imagick(sfConfig::get('sf_web_dir') . $imageSource);

                if ($uploadPath == '/uploads/assets/') {
                    // Delete the old user pics.
                    $assetsList = util::getFilesBeginningWith($this->getUser()->getAttribute('subscriberId', '', 'subscriber') . '_avatar_*.png', sfConfig::get('sf_web_dir') . $uploadPath, GLOB_BRACE);
                    if (count($assetsList) > 0) {
                        foreach ($assetsList as $assetsFile) {
                            @unlink($assetsFile);
                        }
                    }

                }
                //Crop image
                $picture->cropImage($w, $h, $x, $y);
                $picture->resizeImage($minWidth, $minHeight, imagick::FILTER_CATROM, 1);
                $picture->writeImage($filename);

                if ($withThumb) {
                    $picture->resizeImage('114', '70', imagick::FILTER_CATROM, 1);
                    $picture->writeImage($fileNameThumb);
                }
                $picture->destroy();
                // Remove the image from temp folder
                @unlink(sfConfig::get('sf_web_dir') . $imageSource);

                return $this->renderText(json_encode(array(
                                                          'response'     => $cerror,
                                                          'picture_path' => $avatar,
                                                          'picture_name' => $imageName,
                                                          'thumb_path'   => $withThumb ? $avatarThumb : '',
                                                          'thumb_name'   => $withThumb ? 'thumb_' . $imageName : ''
                                                     )));

            }
            else {
                return $this->renderText(json_encode(array('response' => 'Isn\'t from ajax call')));
            }
        }

        /**
         * Execute uploadFile action.
         * Upload an avatar to the temp directory and resize it if it is larger than 750px
         *
         * @param sfWebRequest $request
         *
         * @return JSON
         */
        public function executeUploadFile(sfWebRequest $request) {

            $this->isXhr = false;
            if ($request->isXmlHttpRequest()) {
                $this->isXhr = true;
            }

            $this->formId = $request->getParameter('formId', '');

            $tempFileIndex = $request->getParameter('temp_file_index', '');
            if ($tempFileIndex == '') {
                $tempFileIndex = 'information';
            }
            $tempFileName = $request->getParameter('temp_file_name', '');
            if ($tempFileName == '') {
                $tempFileName = 'roomPicture';
            }
            $this->uploadPath = $request->getParameter('upload_path', '');
            $this->uploadName = $request->getParameter('upload_name', '');
            $this->withThumb = $request->getParameter('with_thumb', true);
            $this->minWidth = 0;
            $this->minHeight = 0;

            if (isset($_FILES[$tempFileIndex])) {
                $file = $_FILES[$tempFileIndex];

                if ($file['name'][$tempFileName] != "") {

                    $fileInfo = pathinfo($file['name'][$tempFileName]);
                    if (!in_array($fileInfo['extension'], $this->getImagesExtensions())) {
                        return $this->renderPartial('room/uploadError', array('errorMessage' => $this->getContext()->getI18n()->__('text_upload_file_error_partial', array('%br%' => '<br />'))));
                    }

                    $name = str_replace(' ', '_', $file['name'][$tempFileName]);
                    $dir = '/uploads/temp/';

                    $filename = sfConfig::get('sf_web_dir') . $dir . $name;
                    move_uploaded_file($file["tmp_name"][$tempFileName], $filename);
                    $imageToDelete = $filename;
                    @unlink($_FILES[$tempFileIndex]);

                    $imageInfos = new Imagick($filename);
                    $d = $imageInfos->getImageGeometry();
                    $imageInfos->destroy();

                    $w = $d['width'];
                    $h = $d['height'];
                    $canvasW = 0;
                    $canvasH = 0;

                    $wMax = 750;
                    $hMax = 461;

                    $minWidth = $request->getParameter('min_width', '');
                    $minHeight = $request->getParameter('min_height', '');
                    if ($minWidth == '') {
                        $minWidth = 213;
                    }
                    if ($minHeight == '') {
                        $minHeight = 131;
                    }
                    $this->minWidth = $minWidth;
                    $this->minHeight = $minHeight;

                    $ratioYMax = round(($h / $w) * $wMax);
                    $ratioXMax = round(($w / $h) * $hMax);

                    if ($w > $wMax || $h > $hMax) {
                        if ($ratioXMax != $ratioYMax && $ratioXMax < $wMax && $ratioYMax >= $hMax) {
                            $canvasW = $wMax;
                            $canvasH = $hMax;
                            $w = $ratioXMax;
                            $h = $hMax;
                        }
                        else if ($ratioXMax != $ratioYMax && $ratioXMax >= $wMax && $ratioYMax < $hMax) {
                            $canvasW = $wMax;
                            $canvasH = $hMax;
                            $h = $ratioYMax;
                            $w = $wMax;
                        }
                        else if ($ratioXMax == $ratioYMax && $ratioYMax > $hMax) {
                            $canvasW = $wMax;
                            $canvasH = $hMax;
                            $h = $hMax;
                            $w = $hMax;
                        }
                    }
                    else if ($w > $minWidth || $h > $minHeight) {
                        $canvasW = $wMax;
                        $canvasH = $hMax;
                    }
                    else if ($w < $minWidth || $h < $minHeight) {
                        $canvasW = $minWidth;
                        $canvasH = $minHeight;
                    }

                    if ($canvasW > 0) {
                        // Create the canvas
                        try {
                            $canvas = new Imagick();
                            $canvas->newImage($canvasW, $canvasH, 'none', 'png');

                            $x = floor(($canvasW - $w) / 2);
                            $y = floor(($canvasH - $h) / 2);

                            // Get the image and resize
                            $thumb = new Imagick($filename);
                            $thumb->setImageFormat("png");
                            $thumb->resizeImage($w, $h, imagick::FILTER_CATROM, 1);

                            // Composite images
                            $canvas->compositeImage($thumb, imagick::COMPOSITE_OVER, $x, $y);

                            $infos = pathinfo($filename);
                            $name = $this->uploadName;
                            if ($name == '') {
                                $name = $infos['filename'] . '.png';
                            }

                            $canvas->writeImage($infos['dirname'] . '/' . $name);
                            $canvas->destroy();
                            $thumb->destroy();
                            @unlink($imageToDelete);
                            $w = $canvasW;
                            $h = $canvasH;
                        } catch (ImagickException $e) {
                            error_log($e);
                            return $this->renderPartial('room/uploadError', array('errorMessage' => $this->getContext()->getI18n()->__('text_upload_file_error_partial_imagick', array('%br%' => '<br />'))));
                        }
                    }

                    $this->picture = $dir . $name;
                    $this->pictureName = $name;
                    $this->size = $w . 'x' . $h;
                    $this->width = $w;
                    $this->height = $h;
                }
            }
        }

        /**
         * Member creates a room.
         *
         * All member are allowed to create a room on Betkup.
         *
         * @param sfWebRequest $request
         */
        public function executeCreate(sfWebRequest $request) {

            //SEO, make title and description dynamic.
            $this->setTitleDescriptionSEOFor("rooms", "create", array());

            $this->roomAccessPolicies = $this->getRoomPrivacyTypes($request);
            $this->roomTypes = $this->getRoomTypeNames($request);
            // Defaults
            $this->information = array(
                'roomAccess'  => sfConfig::get('mod_room_privacy_public'),
                'roomPicture' => sfConfig::get('mod_room_avatar_default'),
            );
            if ($request->isMethod('post')) {
                if ($this->getUser()->isAuthenticated()) {
                    $this->information = $request->getParameter('information', '');
                    $email = $this->getUser()->getAttribute('email', '', 'subscriber');

                    $params = array();
                    $params['communityId'] = sfConfig::get('app_sofun_community_id');
                    $params['adminEmail'] = $email;
                    $params['name'] = urlencode($this->information['roomName']);

                    if ($this->existsRoomName($request, $params ['name']) == 'true') {
                        $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_room_name_exists'));
                    }
                    else {
                        $params['description'] = $this->information ['roomDescription'];
                        $tags = array();
                        $offset = 0;
                        foreach (explode(" ", $this->information['roomTags']) as $tag) {
                            $tags[$offset] = urlencode($tag);
                            $offset += 1;
                        }
                        $params['tags'] = implode(" ", $tags);
                        $params['types'] = isset($this->information ['roomType']) ? implode(" ", $this->information ['roomType']) : array();
                        $params['accessPolicy'] = $this->information ['roomAccess'];
                        if ($this->information['roomAccess'] == sfConfig::get('mod_room_privacy_private')
                            || $this->information['roomAccess'] == sfConfig::get('mod_room_privacy_private_gambling_fr')
                        ) {
                            $params['password'] = $this->information ['roomPassword'];
                        }

                        $sofun = BetkupWrapper::_getSofunApp($request, $this);
                        try {
                            $response = $sofun->api_POST("/team/add", $params);
                        } catch (SofunApiException $e) {
                            error_log($e);
                        }

                        if ($response["http_code"] == "202") {
                            $teamUUID = $response['buffer']['uuid'];
                            $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_room_created_success'));
                            $room = $this->getRoom($request, $teamUUID);

                            if (isset($this->information['path_to_picture']) && isset($this->information['path_to_thumb'])) {
                                $this->renameAvatarByRoomUuid($this->information['path_to_picture'], $this->information['path_to_thumb'], $room['uuid']);
                            }
                            // Redirect to creation step #2 (Kups selection)
                            $this->redirect(array(
                                                 'module' => 'room', 'action' => 'createAddKups',
                                                 'uuid'   => $room['uuid']
                                            ));
                        }
                        else {
                            $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_room_created_failure'));
                        }
                    }
                }
                else {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_notice_room_create_must_login'));
                    $this->forward('account', 'login');
                }
            }
        }

        /**
         * Rename the room avatar picture by the room UUID
         *
         * @param string $pathToPicture
         * @param string $pathToThumb
         * @param int    $roomUuid
         */
        private function renameAvatarByRoomUuid($pathToPicture, $pathToThumb, $roomUuid) {
            if ($pathToPicture != '' && $pathToThumb != '') {

                $this->removeOldAvatarsFor($roomUuid);

                $pictureInfo = pathinfo($pathToPicture);
                $picture = new Imagick(sfConfig::get('sf_web_dir') . $pathToPicture);
                $picture->writeImage(sfConfig::get('sf_web_dir') . $this->getUploadPath() . $roomUuid . '.' . $pictureInfo['extension']);
                $picture->destroy();

                $thumbInfo = pathinfo($pathToThumb);
                $thumb = new Imagick(sfConfig::get('sf_web_dir') . $pathToThumb);
                $thumb->writeImage(sfConfig::get('sf_web_dir') . $this->getUploadPath() . $roomUuid . '_thumb.' . $pictureInfo['extension']);
                $thumb->destroy();

                @unlink(sfConfig::get('sf_web_dir') . $pathToPicture);
                @unlink(sfConfig::get('sf_web_dir') . $pathToThumb);

                return $this->getUploadPath() . $roomUuid . '.' . $pictureInfo['extension'];
            }
        }

        /**
         * Unlink old avatar picture
         *
         * @param int $roomUuid
         */
        private function removeOldAvatarsFor($name) {
            foreach ($this->getImagesExtensions() as $extension) {
                if (file_exists($this->getAvatarFileNameFor($name . '.' . $extension))) {
                    @unlink($this->getAvatarFileNameFor($name . '.' . $extension));
                }
                if (file_exists($this->getAvatarFileNameFor($name . '_thumb.' . $extension))) {
                    @unlink($this->getAvatarFileNameFor($name . '_thumb.' . $extension));
                }
            }
        }

        /**
         * Member creates a room step 2.
         *
         * Registering its room to available Kups.
         *
         * @param sfWebRequest $request
         */
        public function executeCreateAddKups(sfWebRequest $request) {

            $this->redirect('room_kups_create_step2', array(
                                                           'is_in_create_add_kups' => '1',
                                                           'uuid'                  => $request->getParameter('uuid')
                                                      ));

        }

        /**
         * Member creates a room step 3.
         *
         * Inviting new members.
         *
         * @param sfWebRequest $request
         */
        public function executeCreateInvite(sfWebRequest $request) {

            $this->redirect('room_invite_create_step3', array(
                                                             'is_in_create_invite' => '1',
                                                             'room_uuid'           => $request->getParameter('uuid')
                                                        ));
        }

        /**
         * Compute avatar's filename based on its name.
         *
         * @param str $name
         */
        private function getAvatarFileNameFor($name) {
            $webDir = sfConfig::get('sf_web_dir');
            return $webDir . $this->getAvatarPath($name);
        }

        /**
         * Returns avatar's path based on it's name.
         *
         * @param str $name
         */
        private function getAvatarPath($name) {
            $path = $this->getUploadPath() . str_replace(" ", "_", $name);
            return $path;
        }

        /**
         * Get the path to avatar directory
         *
         * @return string
         */
        private function getUploadPath() {
            return sfConfig::get('mod_room_avatar_path');
        }

        /**
         * Displays the administrator's edit tabs.
         *
         * @param sfWebRequest $request
         * @param integer      $uuid
         */
        private function setEditTabs(sfWebRequest $request, $uuid) {

            $this->tab = $request->getParameter('action');
            $this->dataTabs = array(
                'tab1' => array(
                    'id'      => '1',
                    'name'    => 'information',
                    'libelle' => $this->getContext()->getI18n()->__('label_room_tabbar_item1'),
                    'link'    => array('module' => 'room', 'action' => 'edit', 'uuid' => $uuid),
                ),
                'tab2' => array(
                    'id'      => '2',
                    'name'    => 'kups',
                    'libelle' => $this->getContext()->getI18n()->__('label_room_tabbar_item2'),
                    'link'    => array('module' => 'room', 'action' => 'kups', 'uuid' => $uuid),
                ),
                'tab3' => array(
                    'id'      => '3',
                    'name'    => 'members',
                    'libelle' => $this->getContext()->getI18n()->__('label_room_tabbar_item3'),
                    'link'    => array('module' => 'room', 'action' => 'members', 'uuid' => $uuid),
                ),

            );

        }

        /**
         * Returns the tabs while viewing a kKp withing a Room.
         *
         * @param sfWebRequest $request
         * @param int          $room_uuid
         * @param int          $kup_uuid
         */
        private function setKupTabs(sfWebRequest $request, $room_uuid, $kup_uuid) {

            // Items for the menu
            $this->tab = '';
            $this->tab = $request->getParameter('tab');

            // Determine if the user can invite friends
            // If canInvite = 1 the user can invite, if it's 0 the user can't invite
            if (!isset($this->canInvite)) {
                $this->canInvite = 0;
            }

            $return = array(
                'tab1' => array(
                    'id'      => '1',
                    'name'    => 'predictions',
                    'libelle' => $this->getContext()->getI18n()->__('label_tab_kup_prediction'),
                    'link'    => array(
                        'module'   => 'room', 'action' => 'kup', 'room_uuid' => $room_uuid,
                        'kup_uuid' => $kup_uuid, 'tab' => 'predictions'
                    ),
                ),
                'tab2' => array(
                    'id'      => '2',
                    'name'    => 'ranking',
                    'libelle' => $this->getContext()->getI18n()->__('label_tab_kup_ranking'),
                    'link'    => array(
                        'module'   => 'room', 'action' => 'kupRanking', 'room_uuid' => $room_uuid,
                        'kup_uuid' => $kup_uuid, 'tab' => 'ranking'
                    ),
                ),
                'tab3' => array(
                    'id'      => '3',
                    'name'    => 'results',
                    'libelle' => $this->getContext()->getI18n()->__('label_tab_kup_results'),
                    'link'    => array(
                        'module'   => 'room', 'action' => 'kupResults', 'room_uuid' => $room_uuid,
                        'kup_uuid' => $kup_uuid, 'tab' => 'results'
                    ),
                ),
                'tab4' => array(
                    'id'      => '4',
                    'name'    => 'rules',
                    'libelle' => $this->getContext()->getI18n()->__('label_tab_kup_rules'),
                    'link'    => array(
                        'module'   => 'room', 'action' => 'kupRules', 'room_uuid' => $room_uuid,
                        'kup_uuid' => $kup_uuid, 'tab' => 'rules'
                    ),
                ),
            );

            if ($this->canInvite == 1) {
                $return['tab5'] = array(
                    'id'      => '5',
                    'name'    => 'invite',
                    'libelle' => $this->getContext()->getI18n()->__('label_tab_kup_invite'),
                    'link'    => array(
                        'module'             => 'room', 'action' => 'invite',
                        'is_room_kup_invite' => '1', 'kup_uuid' => $kup_uuid,
                        'room_uuid'          => $room_uuid, 'tabInvite' => '1',
                        'tab'                => 'inviteFriends'
                    )
                );
            }

            return $return;
        }

        /**
         * Rooms's administrator edits a kup.
         *
         * @param sfWebRequest $request
         */
        public function executeEdit(sfWebRequest $request) {

            $uuid = $this->getRoomUUID($request);
            if ($uuid == -1) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_missing_room_uuid'));
                $this->redirect(array('module' => 'room', 'action' => 'home'));
            }

            $this->setEditTabs($request, $uuid);

            $this->roomAccessPolicies = $this->getRoomPrivacyTypes($request);
            $this->roomTypes = $this->getRoomTypeNames($request);

            $room = $this->getRoom($request, $uuid);
            $avatar = sfConfig::get('mod_room_avatar_default');
            if ($this->isAvatarExist($room['uuid'])) {
                $avatar = $this->getAvatar($room['uuid']);
            }

            $this->information = array(
                'roomName'        => $room['name'],
                'roomDescription' => $room['description'],
                'roomAccess'      => $room['privacy'],
                'roomTags'        => implode(" ", $this->getRoomTagNames($room)),
                'roomType'        => $this->getRoomTypesNameFor($room),
                'roomPicture'     => $avatar
            );

            $this->dataRoom = $this->getRoomDataForWidget($room);

            //SEO, make title and description dynamic.
            $this->setTitleDescriptionSEOFor("rooms", "edit", $this->dataRoom);

            if ($request->isMethod('post')) {

                $this->information = $request->getParameter('information');

                $email = $this->getUser()->getAttribute('email', '', 'subscriber');

                if (!isset($this->information['roomType'])) {
                    $this->information['roomType'] = array();
                }
                $params = array();
                $params ['communityId'] = sfConfig::get('app_sofun_community_id');
                $params ['adminEmail'] = $email;
                $params ['name'] = $room['name'];
                $params ['teamId'] = $room['uuid'];
                $params ['description'] = $this->information ['roomDescription'];
                $params['tags'] = $this->information ['roomTags'];
                $params['types'] = implode(" ", $this->information['roomType']);

                $params ['accessPolicy'] = $this->information ['roomAccess'];
                if ($this->information ['roomAccess'] == sfConfig::get('mod_room_privacy_private')
                    || $this->information ['roomAccess'] == sfConfig::get('mod_room_privacy_private_gambling_fr')
                ) {
                    $params ['password'] = $this->information ['roomPassword'];
                }

                $sofun = BetkupWrapper::_getSofunApp($request, $this);
                try {
                    $response = $sofun->api_POST("/team/edit", $params);
                } catch (SofunApiException $e) {
                    error_log($e);
                }

                if ($response ["http_code"] == "202") {
                    $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_room_edited_success'));
                    if (isset($this->information['path_to_picture']) && isset($this->information['path_to_thumb'])) {
                        $this->information['roomPicture'] = $this->renameAvatarByRoomUuid($this->information['path_to_picture'], $this->information['path_to_thumb'], $room['uuid']);
                    }
                }
                else {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_room_edited_failure'));
                }
            }
        }

        /**
         * Get the file extension that is accepted for the avatar picture
         *
         * @return array
         */
        private function getImagesExtensions() {
            return array('png', 'jpg', 'JPEG', 'jpeg', 'gif');
        }

        /**
         * Detect if the avatar file is exist in the avatar directory
         *
         * @param string $name
         *
         * @return boolean
         */
        private function isAvatarExist($name) {
            $extensions = $this->getImagesExtensions();
            $countExtensions = count($extensions);
            for ($i = 0; $i < $countExtensions; $i++) {
                if (file_exists($this->getAvatarFileNameFor($name . '.' . $extensions[$i]))) {
                    return true;
                }
            }
            return false;
        }

        /**
         * Get the avatar by it's name. Depending on extensions available.
         *
         * Return false if no file find.
         *
         * @param string $name
         *
         * @return string|boolean
         */
        private function getAvatar($name) {
            $extensions = $this->getImagesExtensions();
            $countExtensions = count($extensions);
            for ($i = 0; $i < $countExtensions; $i++) {
                if (file_exists($this->getAvatarFileNameFor($name . '.' . $extensions[$i]))) {
                    return $this->getAvatarPath($name . '.' . $extensions[$i]);
                }
            }
            return false;
        }

        /**
         * Renders the room's choice kups.
         *
         * @param sfWebRequest $request
         */
        public function executeKups(sfWebRequest $request) {

            $this->roomAccessPolicies = $this->getRoomPrivacyTypes($request);

            $uuid = $this->uuid = $this->getRoomUUID($request);
            if ($uuid == -1) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_missing_room_uuid'));
                $this->redirect(array('module' => 'room', 'action' => 'home'));
            }

            $this->setEditTabs($request, $uuid);
            $room = $this->getRoom($request, $uuid);

            $this->information = $this->dataRoom = $this->getRoomDataForWidget($room);
            $this->information ['access'] = sfConfig::get('mod_room_privacy_default');
            $this->information ['picture'] = sfConfig::get('mod_room_avatar_default');


            //SEO, make title and description dynamic.
            $this->setTitleDescriptionSEOFor("rooms", "addKups", $this->dataRoom);

            /**
             * Use an other template when this module is call by an other one.
             *
             * @param integer is_in_create_add_kups
             */
            if ($request->getParameter('is_in_create_add_kups') == 1) {
                //Template used when you are in step 2 for create a new room
                $this->setTemplate('createAddKups');
            }
        }

        /**
         * Display view to manage members for room administrator.
         *
         * @param sfWebRequest $request
         */
        public function executeMembers(sfWebRequest $request) {

            $this->roomUI = $request->getAttribute('roomUI', "");
            $this->roomAccessPolicies = $this->getRoomPrivacyTypes($request);

            $uuid = $this->uuid = $this->getRoomUUID($request);
            if ($uuid == -1) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_missing_room_uuid'));
                $this->redirect(array('module' => 'room', 'action' => 'home'));
            }

            $this->setEditTabs($request, $uuid);

            $room = $this->getRoom($request, $uuid);

            $this->information = $this->dataRoom = $this->getRoomDataForWidget($room);
            $this->information ['access'] = sfConfig::get('mod_room_privacy_default');
            $this->information ['picture'] = sfConfig::get('mod_room_avatar_default');

            // TODO not implemeted (not available to room administrator for now)
            $this->data = array();
            $this->kupsForSelectBox = array();

        }

        /**
         * Returns the name of the rooms to display on the front room section.
         *
         * @param $home      bool (true = all part in one)
         * @param $frontPart Int (part index)
         */
        private function getFrontRoomNames($frontPart = 1) {
            $cacheKey = 'room_home_name_part_' . $frontPart;
            $names = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($names)) {
                $config = sfConfig::get('mod_room_home_rooms_front_' . $frontPart);
                $names = explode(",", $config);
                if (!empty($names)) {
                    sfMemcache::getInstance()->set($cacheKey, $names, 0, 0);
                }
            }
            return $names;
        }

        /**
         * Renders the room's home.
         *
         * @param sfWebRequest $request
         */
        public function executeHome(sfWebRequest $request) {
        }

        /**
         * Searching for rooms.
         *
         * This method initializes data that search widgets will reuse.
         *
         * @param sfWebRequest $request
         */
        public function executeSearch(sfWebRequest $request) {


            //SEO, make title and description dynamic.
            $this->setTitleDescriptionSEOFor("rooms", "search", array());

            $this->defaultSearchText = $request->getParameter('roomHomeSearchText', '');

            $searchTerms = Data::searchTermsRoom();
            $this->rows = array(
                array(
                    'title'      => $this->getContext()->getI18n()->__('label_room_search_kups'),
                    'type'       => 'selectMultiple',
                    'pic_class'  => 'pic-sport',
                    'scrollbars' => false,
                    'id'         => sfConfig::get('app_kup_search_params_sports'),
                    'items'      => $searchTerms[sfConfig::get('app_kup_search_params_sports')]
                ),
                array(
                    'title'      => $this->getContext()->getI18n()->__('label_room_search_categories'),
                    'type'       => 'selectMultiple',
                    'pic_class'  => 'pic-category',
                    'scrollbars' => false,
                    'id'         => 'CATEGORY',
                    'items'      => $searchTerms['CATEGORY']
                ),
                array(
                    'title'      => $this->getContext()->getI18n()->__('label_room_search_access'),
                    'type'       => 'selectMultiple',
                    'pic_class'  => 'pic-access',
                    'scrollbars' => false,
                    'id'         => 'ACCESS',
                    'items'      => $searchTerms['ACCESS']
                ),
                array(
                    'title'      => $this->getContext()->getI18n()->__('label_room_search_sorting'),
                    'type'       => 'selectMultiple',
                    'pic_class'  => 'pic-sort',
                    'scrollbars' => false,
                    'id'         => sfConfig::get('app_kup_search_params_sorting'),
                    'items'      => $searchTerms[sfConfig::get('app_kup_search_params_sorting')]
                )
            );
        }

        private function filterAvailableKups(sfWebRequest $request, $roomKups) {

            $cacheKey = 'room_kups_available';
            $kups = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($kups)) {
                $filtered = array();
                $params = array(
                    'offset'    => 0,
                    'batchSize' => 100,
                    'status'    => 'ALL_OPENED', // Kups that are not closed yet.
                );
                $kups = $this->getKupsData($request, $params, $with_batch_info = false, $with_security = false);
                if (!empty($kups)) {
                    sfMemcache::getInstance()->set($cacheKey, $kups, 0, 3600);
                }
            }

            $offset = 0;
            foreach ($kups as $kup) {

                // Exclude Kups that are closed. (no events opened for bet anymore)
                if ($kup['status'] > 2 || $kup['status'] == -1) {
                    continue;
                }

                $found = false;
                foreach ($roomKups as $roomKup) {
                    if ($this->getContext()->getI18n()->__($roomKup['name']) == $kup['name']) {
                        $found = true;
                        break;
                    }
                }
                if ($found == false) {

                    // Set the display and the room uuid for kups to use it in preview -> editkups action
                    $kup['display'] = 'left';
                    $kup['room_uuid'] = $this->uuid;

                    $filtered[$offset] = $kup;
                    $offset += 1;
                }
            }

            return $filtered;

        }

        /**
         *
         * Enter description here ...
         *
         * @param sfWebRequest $request
         * @param unknown_type $metaKupUUID
         * @param integer      $stake
         */
        private function addRoomKup(sfWebRequest $request, $metaKupUUID, $stake = 0, $repartition = 3) {

            $params['communityId'] = sfConfig::get('app_sofun_community_id');
            $params['metaKupId'] = $metaKupUUID;
            $params['stake'] = $stake;
            $params['repartitionType'] = $repartition;

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_POST("/team/" . $this->uuid . "/kup/add", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] != "202") {
                error_log($response['buffer']);

            }
        }

        /**
         *
         * Enter description here ...
         *
         * @param sfWebRequest $request
         * @param unknown_type $metaKupUUID
         */
        private function delRoomKup(sfWebRequest $request, $kupUUID) {

            $params['communityId'] = sfConfig::get('app_sofun_community_id');
            $params['kupId'] = $kupUUID;

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_POST("/team/" . $this->uuid . "/kup/del", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] != "202") {
                error_log($response['buffer']);

            }
        }

        /**
         * Display 2 columns for manage kups in room edition
         *
         * This is here as a dedicated actions because loaded in AJAX.
         *
         * @param sfWebRequest $request
         * @param int          $uuid
         */
        public function executeEditKups(sfWebRequest $request) {

            $this->uuid = $request->getParameter('uuid');

            $this->availableStakes = $this->getKupStakeTypes();
            $this->availableJackpotRepartitions = $this->getKupJackpotRepartitions();

            if ($request->isXmlHttpRequest()) {

                $this->kup = $request->getParameter('kup', '');
                $this->what = $request->getParameter('what', '');
                $this->stake = $request->getParameter('stake', '');

                // If the kup is selected to be free, repartition is set to 3.
                $this->repartition = $request->getParameter('repartition');
                if ($this->stake == 0) {
                    $this->repartition = 3;
                }

                if ($this->what == 'add') {
                    $this->addRoomKup($request, $this->kup, $this->stake, $this->repartition);
                }
                else if ($this->what == 'del') {
                    $this->delRoomKup($request, $this->kup);
                }

            }

            // Kups already registered against this room.
            $this->roomKups = $this->getRoomKups($request, array(
                                                                'uuid'          => $this->uuid,
                                                                'with_security' => false,
                                                           ));

            // Available Kups for this room.
            $this->availableKups = $this->filterAvailableKups($request, $this->roomKups);

        }

        /**
         * Returns all available stakes an administrator can choose from while registering a Kup to its room.
         *
         * <p>
         *
         * Only predefined values available
         */
        private function getKupStakeTypes() {

            return array(
                '0'   => 'label_kup_stake_zero',
                '0.5' => '0.5 €',
                '1'   => '1 €',
                '2'   => '2 €',
                '3'   => '3 €',
                '4'   => '4 €',
                '5'   => '5 €',
                '10'  => '10 €',
                '15'  => '15 €',
                '20'  => '20 €',
                '50'  => '50 €',
                '100' => '100 €'
            );

        }

        /**
         * Returns all available jackport répartition's types an administrator can choose from while registering a Kup
         * to its room.
         *
         * <p>
         *
         * Only predifined values available.
         */
        private function getKupJackpotRepartitions() {
            // Keys must match with the platform
            // Do not change those unless you know what you are doing
            return array(
                '1' => 'Le 1er (% : 100)',
                '2' => 'Les 2 premiers (% : 70, 30)',
                '3' => 'Les 3 premiers (% : 50, 30, 20)',
                '55' => 'Les 5 premiers (1er : 30%, 2ème 25%, 3ème : 15%, 4ème : 20%, 5ème: 10%)',
                '4' => 'Les 10 premiers (% : 25, 20, 15, 10, 5, 5, 5, 5, 5, 5)',
                '5' => 'Les 13 premiers (1er : 23%, 2ème 15%, 3ème : 13%, 4ème : 10%, 5ème : 7%; du 6ème au 13ème : 4%)',
                '6' => 'Les 20 premiers (1er : 20%, 2ème 12%, 3ème : 10%, 4ème : 8%, 5ème au 10ème : 5%; du 11ème au 20ème : 2%)',
                '30' => 'Les 30 premiers (1er : 15%, 2ème 10 %, 3ème : 7%, 4e au 10e : 11e au 30e : 2%)'

            );
            // XXX i18n for labels
        }

        /**
         * Member joins room.
         *
         * @param sfWebRequest $request
         */
        public function executeJoin(sfWebRequest $request) {
            $room_type = $request->getParameter('room_type', '');

            $uuid = $this->getRoomUUID();
            $needAdvancedAccounting = $request->getParameter('need_advanced_account', '0');
            if ($needAdvancedAccounting == 1 && $this->getUser()->getAttribute('account_type', '', 'subscriber') == sfConfig::get('mod_room_registration_account_type_simple')) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('Vous devez être connecté avec un compte complet pour rejoindre cette Room.'));
                $this->redirect(array(
                                     'module' => 'room', 'action' => 'view',
                                     'uuid'   => intval($uuid)
                                ));
            }

            $email = $this->getUser()->getAttribute('email', '', 'subscriber');
            $params = array(
                'email'       => $email,
                'communityId' => sfConfig::get('app_sofun_community_id'),
                'password'    => $request->getParameter("password", ""),
            );

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_POST("/team/" . $uuid . "/member/add", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_joined_room_success'));
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

                    // We flush the user cache for this Room.
                    $cacheKey = 'room_credentials_and_privacy_for_' . str_replace(array('-', '.', '@'), '_', $email) . '_' . $uuid;
                    sfMemcache::getInstance()->set($cacheKey, array(), 0, 1);
                }
            }
            else {
                if ($room_type == sfConfig::get('mod_room_privacy_private') || $room_type == sfConfig::get('mod_room_privacy_private_gambling_fr')) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_joined_private_room_error'));
                }
                else {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_joined_room_error'));
                }
            }

            $this->setTemplate('view');
            $this->redirect(array('module' => 'room', 'action' => 'view', 'uuid' => intval($uuid)));

        }

        /**
         * Member leaves a room.
         *
         * @param sfWebRequest $request
         */
        public function executeLeave(sfWebRequest $request) {

            $uuid = $this->getRoomUUID();
            $email = $this->getUser()->getAttribute('email', '', 'subscriber');

            $params = array(
                'email'       => $email,
                'communityId' => sfConfig::get('app_sofun_community_id'),
                'password'    => $this->getContext()->getRequest()->getParameter("password", ""),
            );

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_POST("/team/" . $uuid . "/member/del", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_left_room_success'));
                // We flush the user cache for this Room.
                $cacheKey = 'room_credentials_and_privacy_for_' . str_replace(array('-', '.', '@'), '_', $email) . '_' . $uuid;
                sfMemcache::getInstance()->set($cacheKey, array(), 0, 1);
            }
            else {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_left_room_error'));
            }

            $this->setTemplate('view');
            $this->redirect(array('module' => 'room', 'action' => 'view', 'uuid' => intval($uuid)));

        }

        /**
         * Default view for a kup in a room
         *
         * /room/<room_uuid>/kup/<kup_uuid>
         *
         * @param sfWebRequest $request
         */
        public function executeKup(sfWebRequest $request) {

            $this->roundUUID = $request->getParameter('roundUUID', '');
            $this->room_uuid = $request->getParameter('room_uuid');
            $this->kup_uuid = $request->getParameter('kup_uuid');
            $this->stage = $request->getParameter('stage');

            $room = $this->getRoom($request, $this->room_uuid);
            $this->dataRoom = $this->getRoomDataForWidget($room);
            $this->canInvite = $this->getInvitePrivacy($this->dataRoom['privacy']);
            $this->kupData = $this->getKupData($request, $this->kup_uuid);
            $this->dataKupTabs = $this->setKupTabs($request, $this->room_uuid, $this->kup_uuid);
            $this->setPredictionsViewTemplate($this->kupData);

            //SEO, make title and description dynamic.
            $this->setTitleDescriptionSEOFor("room-kups", "kup", $this->kupData, $this->dataRoom['name']);

            // If there are draft predictions, delete them if the user wat to.
            if($request->isMethod('get')) {
                $empty_draft = $request->getParameter('empty_draft', 0);
                if($empty_draft) {
                    $this->getUser()->getAttributeHolder()->removeNamespace('predictionsSave');
                }
            }

            // Forward to login if the user isn't connected
            // Or if the user have a simple account in case of gambling public Room.
            if ($request->isMethod('post')) {

                // We test if the user have submit the login form.
                // If he has, we don't save the draft again.
                $formConnexion = $request->getParameter('connexion', '');
                $formConnexionLogin = $request->getParameter('connexionLogin', '');
                if ($formConnexion == '' && $formConnexionLogin == '') {
                    $this->saveDraftPredictions($request, $this->kup_uuid);
                }

                if (!$this->getUser()->isAuthenticated()) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_notice_kup_predictions_saved_failed_must_login'));
                    $this->forward('account', 'login');
                }
                else if($this->getUser()->isAuthenticated()
                    && (
                        $this->dataRoom['privacy'] == sfConfig::get('mod_room_privacy_public_gambling_fr')
                    )
                    && (
                        $this->getUser()->getAttribute('account_type', '', 'subscriber') != sfConfig::get('app_credentials_account_type_gambling_fr')
                            &&
                        $this->getUser()->getAttribute('account_type', '', 'subscriber') != sfConfig::get('app_credentials_account_type_gambling_fr_verified')
                    )
                ) {
                    $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_need_advanced_account_to_join_room'));
                    $this->redirect('account_register_update_room_kup', array(
                                                                             'room_uuid' => $this->room_uuid,
                                                                             'kup_uuid' => $this->kup_uuid,
                                                                             'redirect_route' => 'room_auto_join'));
                }
                else if($this->getUser()->isAuthenticated() &&
                        !$this->getUser()->hasCredential(sfConfig::get('mod_room_security_betkup_member'))) {
                    // Automatically add the user to the Room if he's not member already.
                    if($this->room_uuid != '') {
                        $this->joinRoom($request, $this->room_uuid);
                    }
                }
            }
        }

        /**
         * Display Kup's ranking tab within a room
         *
         * /room/<room_uuid>/kupRanking/<kup_uuid>
         *
         * @param sfWebRequest $request
         */
        public function executeKupRanking(sfWebRequest $request) {

            $this->room_uuid = $request->getParameter('room_uuid');
            $this->kup_uuid = $request->getParameter('kup_uuid');

            $this->urlForFacebook = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                              'module'    => 'room',
                                                                                                              'action'    => 'kupRanking',
                                                                                                              'room_uuid' => $this->room_uuid,
                                                                                                              'kup_uuid'  => $this->kup_uuid
                                                                                                         ));

            $this->offset = $request->getParameter('offset', 0);
            $this->batch = 10;

            $room = $this->getRoom($request, $this->room_uuid);
            $this->dataRoom = $this->getRoomDataForWidget($room);

            $this->canInvite = $this->getInvitePrivacy($this->dataRoom['privacy']);

            $this->dataKupTabs = $this->setKupTabs($request, $this->room_uuid, $this->kup_uuid);

            $this->kupData = $this->getKupData($request, $this->kup_uuid);
            if ($this->kupData['repartition'] == 4) {
                $this->kupData['nbWinners'] = 10;
            }
            else {
                $this->kupData['nbWinners'] = $this->kupData['repartition'];
            }

            //SEO, make title and description dynamic.
            $this->setTitleDescriptionSEOFor("room-kups", "ranking", $this->kupData, $this->dataRoom['name']);

            $this->kupsRankingData = array();
            $this->userRanking = array();

            // Get Kup's ranking
            $ranking = $this->getKupRanking($request, $this->kup_uuid, $this->offset, $this->batch);
            if (isset($ranking['entries'])) {

                $offset = 0;
                foreach ($ranking['entries'] as $entry) {
                    $this->kupsRankingData[$offset] = $entry;
                    $member = $entry['member'];

                    $this->kupsRankingData[$offset]['member']['nickName'] = Util::getNicknameFor($member);

                    $avatar = $member['avatarBig'];
                    $avatar2 = $member['avatarSmall'];
                    // Handle Facebook avatar in PLAIN HTTP
                    if (is_string($avatar) && util::startswith($avatar, "http://")) {
                        $count = 1;
                        $avatar = str_replace("http", "https", $avatar, $count);
                        $avatar2 = str_replace("http", "https", $avatar2, $count);
                        $this->kupsRankingData[$offset]['member']['avatarSmall'] = $avatar2;
                        $this->kupsRankingData[$offset]['member']['avatarBig'] = $avatar;
                    }

                    if ($this->getUser()->isAuthenticated() && $this->getUser()->getAttribute('email', '', 'subscriber') == $member['email']) {
                        $this->userRanking = $entry;
                    }

                    $offset++;
                }

                //Get member position
                $this->memberPosition = $ranking['memberPosition'];

                // Get total numbers of players
                $this->nbPlayers = $ranking['totalMembers'];

                unset($ranking);

            }

        }

        /**
         * Determine if the wether or not a member can invite within a room.
         *
         * @param $privacy, privacy of the room.
         */
        private function getInvitePrivacy($privacy) {
            $canInvite = 0;
            if ($privacy == sfConfig::get('mod_room_privacy_public')
                || $privacy == sfConfig::get('mod_room_privacy_public_gambling_fr')
            ) {
                $canInvite = 1;
            }
            return $canInvite;
        }

        /**
         * Send invites to selected email / list.
         *
         * @param sfWebRequest $request
         */
        public function executeInvite(sfWebRequest $request) {

            // Default
            if ($request->getAttribute('roomUI', '')) {
                $this->roomUI = $request->getAttribute('roomUI', '');
            }
            // We get the room infos
            $this->roomUuid = $request->getParameter('room_uuid');
            $this->room_uuid = $this->roomUuid;
            $room = $this->getRoom($request, $this->roomUuid);
            $this->roomData = $this->getRoomDataForWidget($room);

            // We get the tab menu
            if ($request->getParameter('is_room_kup_invite') != '1') {
                $this->setEditTabs($request, $this->roomUuid);
            }

            // If this module is called by an other one, we take the template of the caller.
            // Caller = Creation room module
            if ($request->getParameter('is_in_create_invite') == '1') {
                $this->setTemplate('createInvite');
            }

            // Caller = Kup in room module
            if ($request->getParameter('is_room_kup_invite') == '1') {
                $this->is_room_kup_invite = $request->getParameter('is_room_kup_invite');
                $this->kupUuid = $request->getParameter('kup_uuid');
                $this->kupData = $this->getKupData($request, $this->kupUuid);
                $this->tabInvite = $request->getParameter('tabInvite');
                $this->canInvite = 0;
                if ($this->tabInvite == 1) {
                    $this->canInvite = 1;
                }

                //SEO, make title and description dynamic.
                $this->setTitleDescriptionSEOFor("room-kups", "kup-invite", $this->kupData, $this->roomData['name']);

                $this->urlShareFacebook = $this->getCustomUriPrefix($request) . $this->getController()->genUrl(array(
                                                                                                                    'module'    => 'room',
                                                                                                                    'action'    => 'kup',
                                                                                                                    'room_uuid' => $this->roomUuid,
                                                                                                                    'kup_uuid'  => $this->kupUuid
                                                                                                               ));
                $this->publishMsg = $this->getPublishFacebookMessageFor($this->kupData);
                $this->publishProperties = $this->getFacebookPublishMessageFor($request, $this->kupData);

                // Get the tab menu for kup
                $this->dataKupTabs = $this->setKupTabs($request, $this->roomUuid, $this->kupUuid);

                // Invite possibility only for kup in public room, otherwise redirect to prono
                if ($this->roomData['privacy'] == sfConfig::get('mod_room_privacy_private')
                    || $this->roomData['privacy'] == sfConfig::get('mod_room_privacy_private_gambling_fr')
                ) {
                    $this->redirect($this->getController()->genUrl(array(
                                                                        'module'    => 'room',
                                                                        'action'    => 'kup',
                                                                        'kup_uuid'  => $this->kupUuid,
                                                                        'room_uuid' => $this->roomUuid
                                                                   )));
                }

                $avatarsPath = sfConfig::get('mod_room_avatar_path');
                $dir = sfConfig::get('sf_web_dir') . $avatarsPath;
                $handle = opendir($dir);
                $this->avatarList = array();
                while ($entry = @readdir($handle)) {
                    $info = pathinfo($entry);
                    $this->avatarList[$info['filename']] = $avatarsPath . $entry;
                }
                closedir($handle);
                if ($this->roomUI != '' && isset($this->roomUI["avatar-room"])) {
                    $this->publishImage = $this->roomUI["avatar-room"];
                }
                else {
                    $this->publishImage = (isset($this->avatarList[$this->room_uuid])) ? $this->avatarList[$this->room_uuid] : sfConfig::get('mod_room_avatar_default');
                }

                // Set the kup inside room template
                $this->setTemplate('kupInvite');
            }
            else {
                //SEO, make title and description dynamic.
                $this->setTitleDescriptionSEOFor("rooms", "invite", $this->roomData);
            }
        }

        /**
         * Send invitation emails.
         *
         * @param sfWebRequest $request
         * @param int          $room_uuid
         * @param str          $email_subject
         * @param str          $email_body
         * @param array        $email_rcpts
         */
        private function invite(sfWebRequest $request, $room_uuid, $email_subject = '', $email_body = '', $email_rcpts = array()) {

            $room_uuid = strval($room_uuid);
            if ($room_uuid == '-1' || $room_uuid == 'me') {
                return false;
            }

            $params = array(
                'communityId'   => sfConfig::get('app_sofun_community_id'),
                'inviter_email' => $this->getUser()->getAttribute('email', '', 'subscriber'),
                'email_subject' => $email_subject,
                'email_body'    => $email_body,
                'email_rcpts'   => $email_rcpts,
            );

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_POST("/team/" . $room_uuid . "/invite", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_invites_sent_sucess'));
                return true;
            }
            else {
                error_log($response['buffer']);
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_notice_invites_sent_failure'));
                return false;
            }

        }

        /**
         * Displays Kup within room results view.
         *
         * @param sfWebRequest $request
         */
        public function executeKupResults(sfWebRequest $request) {

            $this->room_uuid = $request->getParameter('room_uuid');
            $this->kup_uuid = $request->getParameter('kup_uuid');
            $room = $this->getRoom($request, $this->room_uuid);
            $this->dataRoom = $this->getRoomDataForWidget($room);

            $this->canInvite = $this->getInvitePrivacy($this->dataRoom['privacy']);
            $this->dataKupTabs = $this->setKupTabs($request, $this->room_uuid, $this->kup_uuid);
            $this->kupData = $this->getKupData($request, $this->kup_uuid);

            //SEO, make title and description dynamic.
            $this->setTitleDescriptionSEOFor("room-kups", "results", $this->kupData, $this->dataRoom['name']);

            $this->setResultsViewTemplate($this->kupData);
        }

        /**
         * Displays Kup within room rules view.
         *
         * @param sfWebRequest $request
         */
        public function executeKupRules(sfWebRequest $request) {

            $this->room_uuid = $request->getParameter('room_uuid');
            $this->kup_uuid = $request->getParameter('kup_uuid');
            $this->module = $request->getParameter('module');

            $room = $this->getRoom($request, $this->room_uuid);
            $this->dataRoom = $this->getRoomDataForWidget($room);

            $this->canInvite = $this->getInvitePrivacy($this->dataRoom['privacy']);

            $this->dataKupTabs = $this->setKupTabs($request, $this->room_uuid, $this->kup_uuid);

            $this->kupData = $this->getKupData($request, $this->kup_uuid);

            //SEO, make title and description dynamic.
            $this->setTitleDescriptionSEOFor("room-kups", "rules", $this->kupData, $this->dataRoom['name']);

        }

        /**
         * Display Kup's bet view.
         *
         * @param sfWebRequest $request
         */
        public function executeKupBet(sfWebRequest $request) {

            $this->room_uuid = $request->getParameter('room_uuid');
            $this->kup_uuid = $request->getParameter('kup_uuid');
            $this->hasPreds = $request->getParameter('hasPreds', '');

            $this->dataKupTabs = $this->setKupTabs($request, $this->room_uuid, $this->kup_uuid);

            $room = $this->getRoom($request, $this->room_uuid);
            $this->roomData = $this->getRoomDataForWidget($room);

            // Get Kup's data given its uuid.
            $this->kupData = $this->getKupData($request, $this->kup_uuid);

            //SEO, make title and description dynamic.
            $this->setTitleDescriptionSEOFor("room-kups", "bet", $this->kupData, $this->roomData['name']);

            // If Kup is closed or cancelled redirect to ranking
            if ($this->kupData['status'] >= 3 || $this->kupData['status'] == -1) {
                $this->redirect(array(
                                     'module' => 'kup', 'action' => 'ranking',
                                     'uuid'   => $this->uuid
                                ));
            }

            // If no predictions, redirect to prediction page
            if ($this->hasPreds != "1" && $this->kupData['hasPredictions'] != "1") {
                $this->redirect(array(
                                     'module'   => 'room', 'action' => 'kup',
                                     'kup_uuid' => $this->kup_uuid, 'room_uuid' => $this->room_uuid,
                                ));
            }

            // Redirect to step 3 (invite friend) when the kup is free
            // Or the kup is not free but the user is already participant
            if ($this->kupData['type'] == sfConfig::get('mod_room_kup_type_free')) {
                $this->redirect('room_kup_invite_step3', array(
                                                              'kup_uuid'           => $this->kup_uuid,
                                                              'room_uuid'          => $this->room_uuid,
                                                              'is_room_kup_invite' => '1'
                                                         ));
            }
            else if ($this->kupData['type'] == sfConfig::get('mod_room_kup_type_gambling_fr') && $this->kupData['is_participant'] == '1') {
                $this->redirect('room_kup_invite_step3', array(
                                                              'kup_uuid'           => $this->kup_uuid,
                                                              'room_uuid'          => $this->room_uuid,
                                                              'is_room_kup_invite' => '1'
                                                         ));
            }

            $this->_bet($request, $this->kup_uuid, $this->room_uuid, $this->kupData);
        }

        /**
         * Display paged rooms.
         *
         * @param sfWebRequest $request
         */
        public function executeRoomsThumbnails(sfWebRequest $request) {

            if ($request->isXmlHttpRequest()) {

                $this->parentModule = $request->getParameter('module_parent', '');
                $this->nbLine = $request->getParameter('nbLine', "2");
                $this->roomUI = $request->getParameter('room_ui', "");
                $this->nbDisplay = $request->getParameter('nbDisplay', "1");

                $offset = $request->getParameter('offset');
                $batchSize = $request->getParameter('batchSize');

                $this->roomData = array();

                $params = array(
                    'email'     => $this->getUser()->getAttribute('email', '', 'subscriber'),
                    'offset'    => $offset,
                    'batchSize' => $batchSize
                );
                $batchedRooms = $this->getRoomsData($request, $params);
                $displayRoom = array();

                for ($i = 0; $i < $this->nbLine; $i++) {
                    $displayRoom[$i] = array();
                }

                $j = 0;
                $i = 0;
                foreach ($batchedRooms as $kups) {
                    array_push($displayRoom[$i], $kups);
                    $j++;
                    // If we get the number of kup we want to be displayed
                    if ($j == $this->nbDisplay) {
                        $i++;
                    }
                }
                for ($i = 0; $i < $this->nbLine; $i++) {
                    $this->roomData[$i] = $displayRoom[$i];
                }
            }

        }

        /**
         * Display a paged room block for search results.
         *
         * @param sfWebRequest $request
         *
         * @see /room action search
         */
        public function executeRoomsThumbnailsSearch(sfWebRequest $request) {

            if ($request->isXmlHttpRequest()) {

                $this->offset = $request->getParameter('offset', 0);
                $this->batchSize = $request->getParameter('batchSize', 6);
                $this->nbLine = $request->getParameter('nbLine', "2");
                $this->roomUI = $request->getParameter('room_ui', "");
                $this->nbDisplay = $request->getParameter('nbDisplay', "3");

                $this->keywords = $request->getParameter('roomHomeSearchText', "");
                $this->sports = $this->getQuerySearchSportsFor($request);
                $this->sorting = $this->getQuerySearchSortFor($request);
                $this->category = $request->getParameter('category', "");
                $this->access = $request->getParameter('access', "");

                $params = array(
                    'keywords'  => $this->keywords,
                    'sports'    => $this->sports,
                    'sort'      => $this->sorting,
                    'category'  => $this->category,
                    'access'    => $this->access,
                    'offset'    => $this->offset,
                    'batchSize' => $this->batchSize
                );

                $this->totalRooms = $this->countRooms($request, $params);
                $this->pagerSize = round($this->totalRooms / $this->batchSize);

                $this->roomData = array();
                $batchedRooms = $this->getRoomsData($request, $params);
                $this->displayRooms = count($batchedRooms);
                $displayRoom = array();

                for ($i = 0; $i < $this->nbLine; $i++) {
                    $displayRoom[$i] = array();
                }
                $j = 0;
                $i = 0;
                foreach ($batchedRooms as $kups) {
                    array_push($displayRoom[$i], $kups);
                    $j++;
                    // If we get the number of kup we want to be displayed
                    if ($j == $this->nbDisplay) {
                        $i++;
                        $j = 0;
                    }
                }
                for ($i = 0; $i < $this->nbLine; $i++) {
                    $this->roomData[$i] = $displayRoom[$i];
                }
            }

        }

        /**
         * Display paged rooms on room's home
         *
         * @param sfWebRequest $request
         *
         * @see /room action home
         */
        public function executeRoomsThumbnailsHome(sfWebRequest $request) {

            if ($request->isXmlHttpRequest()) {

                $this->nbLine = $request->getParameter('nbLine', "2");
                $this->roomUI = $request->getParameter('room_ui', "");
                $this->nbDisplay = $request->getParameter('nbDisplay', "3");
                $this->totalRoom = $request->getParameter('total', "0");
                $offset = $request->getParameter('offset', '0');
                $batchSize = $request->getParameter('batchSize', '6');

                $this->roomData = array();

                $countFrontPart = floor($offset / $batchSize) + 1;
                if (floor($this->totalRoom / $batchSize) >= $countFrontPart) {

                    $cacheKey = 'room_home_front_part_' . $countFrontPart;
                    $this->roomData = sfMemcache::getInstance()->get($cacheKey, array());
                    if (empty($this->roomData)) {
                        $customOffset = 0;
                        $params = array(
                            'name'      => implode(",", $this->getFrontRoomNames($countFrontPart)),
                            'offset'    => $customOffset,
                            'batchSize' => $batchSize
                        );
                        $batchedRooms = $this->getRoomsData($request, $params);
                        $displayRoom = array();
                        for ($i = 0; $i < $this->nbLine; $i++) {
                            $displayRoom[$i] = array();
                        }
                        $j = 0;
                        $i = 0;
                        foreach ($batchedRooms as $kups) {
                            array_push($displayRoom[$i], $kups);
                            $j++;
                            // If we get the number of kup we want to be displayed
                            if ($j == $this->nbDisplay) {
                                $i++;
                            }
                        }
                        for ($i = 0; $i < $this->nbLine; $i++) {
                            $this->roomData[$i] = $displayRoom[$i];
                        }
                        if (!empty($this->roomData)) {
                            sfMemcache::getInstance()->set($cacheKey, $this->roomData, 0, 3600);
                        }
                    }
                }

            }
        }

        /**
         * Room's administrator deletes a Kup.
         *
         * @param sfWebRequest $request
         */
        public function executeDelete(sfWebRequest $request) {

            $uuid = $this->getRoomUUID($request);
            if ($uuid == -1) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_missing_room_uuid'));
                $this->redirect(array('module' => 'room', 'action' => 'home'));
            }

            $params = array(
                'communityId' => '1',
                'teamId'      => $uuid,
            );

            $sofun = BetkupWrapper::_getSofunApp($request, $this);
            try {
                $response = $sofun->api_POST("/team/del", $params);
            } catch (SofunApiException $e) {
                error_log($e);
            }

            if ($response["http_code"] == "202") {
                $this->getUser()->setFlash('notice', $this->getContext()->getI18n()->__('flash_notice_room_deleted_success'));
                $this->redirect(array('module' => 'room', 'action' => 'home'));
            }
            else {
                $this->getUser()->setFlash('error', $this->getContext()->getI18n()->__('flash_error_room_delete_fail'));
            }

            $this->setTemplate('view');

        }

        /**
         * Display the widget.
         *
         * @param sfWebRequest $request
         */
        public function executeWidgetRanking(sfWebRequest $request) {
            $this->room_uuid = $request->getParameter('room_uuid', '');

            $params = array(
                'uuid' => $this->room_uuid
            );
            $this->kupsData = $this->getRoomKups($request, $params);
        }

        /**
         * Display the kups for a room.
         *
         * @param sfWebRequest $request
         */
        public function executeWidgetKups(sfWebRequest $request) {
            $this->room_uuid = $request->getParameter('room_uuid', '');
            $this->urlToLink = $request->getParameter('urlToLink', '');
            $this->kupsData = $request->getParameter('kupsData', array());
            $this->urlToLink = $request->getParameter('urlToLink', '');
        }

        /**
         * Display count down or ranking list.
         *
         * @param sfWebRequest $request
         */
        public function executeWidgetKupRanking(sfWebRequest $request) {
            $this->room_uuid = $request->getParameter('room_uuid', '');
            $this->kup_uuid = $request->getParameter('kup_uuid', '');
            $this->urlToLink = $request->getParameter('urlToLink', '');

            $params = array(
                'uuid' => $this->room_uuid
            );
            $kupsData = $this->getRoomKups($request, $params);

            if ($this->kup_uuid == '0') {
                $this->kupData = array();
                $this->kupRanking = $this->getRoomRankingFor($request, $this->room_uuid, 0, 6);
            }
            else {
                $this->kupData = $this->getKupDataByUuid($this->kup_uuid, $kupsData);
                $this->kupRanking = $this->getRanking($request, $this->kup_uuid, 0, 6);
            }
        }

        public function executeGetWidgetUrl(sfWebRequest $request) {
            $room_uuid = $request->getParameter('room_uuid', '');
            $kup_uuid = $request->getParameter('kup_uuid', '');
            $url = $this->getContext()->getController()->genUrl(array(
                                                                     'module'    => 'room',
                                                                     'action'    => 'widgetKupRanking',
                                                                     'kup_uuid'  => $kup_uuid,
                                                                     'room_uuid' => $room_uuid
                                                                ));
            return $this->renderText($url);
        }

        private function getKupDataByUuid($kup_uuid, $kupsData) {
            foreach ($kupsData as $kupData) {
                if ($kup_uuid == $kupData['uuid']) {
                    return $kupData;
                }
            }
        }

        /**
         * Facebook Like page Room Fans Facebook.
         *
         * @param sfWebRequest $request
         */
        public function executeLikePageFansFacebook(sfWebRequest $request) {

        }

    }

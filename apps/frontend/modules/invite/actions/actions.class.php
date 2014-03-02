<?php

/**
 * Member Invite Actions.
 *
 * @package    betkup.fr
 * @subpackage invite
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: actions.class.php 5251 2012-06-14 14:22:40Z jmasmejean $
 */
class inviteActions extends betkupActions {

    /**
     * Get emails from member selection then update session.
     *
     * @param sfWebRequest $request
     */
    public function executeEmailsAdd(sfWebRequest $request) {

        // array of selected emails in session.
        $this->emails = $this->getUser ()->getAttribute ('emails', array(), 'invite' );

        // operation : add / del
        $param = $request->getParameter('param', '');

        // Manually inserted email (one at a time)
        $email = $request->getParameter('email', '');

        $this->error = "";
        if ($param == "addManual" || $param == "delManual") {
            switch ($param) {
                case "addManual" :
                    if (isset($email) && $email != '') {
                        if (Util::checkEmail ($email)) {
                            if (!array_key_exists($email, $this->emails)) {
                                $this->emails[$email] = $email;
                                $this->getUser()->setAttribute('emails', $this->emails, 'invite');
                            } else {
                                $this->error = $this->getContext()->getI18n()->__('flash_error_email_already_in_list');
                            }
                        } else {
                            $this->error = $this->getContext()->getI18n()->__('flash_error_email_format_incorrect');
                        }
                    } else {
                        $this->error = $this->getContext()->getI18n()->__('flash_error_email_missing');
                    }
                    break;
                case "delManual" :
                    unset ($this->emails[array_search($email, $this->emails)]);
                    $this->getUser ()->setAttribute ('emails', $this->emails, 'invite');
                    break;
            }
        }

    }

    /**
     * Main template to display Invite module loaded in ajax.
     *
     * NEVER DO QUERY CALLS IN THIS METHOD
     *
     * @param sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request) {
		if($request->isXmlHttpRequest()) {
	        // Redirects when the user is not logged in
	        if(!$this->getUser()->isAuthenticated()) {
	            return $this->renderComponent('interface', 'redirect');
	        }
	
	        $this->room_uuid = $request->getParameter('room_uuid');
	        $this->kup_uuid = $request->getParameter('kup_uuid');
	        $this->type_invite = $request->getParameter('type_invite', 'email');
			$this->customMessage = $request->getParameter('customMessage', '');
			$this->customUrl = $request->getParameter('customUrl', '');
	        // Security for ajax calls : All variables need to NOT be NULL.
	        if ($this->room_uuid == '') {
	            $this->room_uuid = 0;
	        }
	
	        if ($this->kup_uuid == '') {
	            $this->kup_uuid = 0;
	        }
	
	        if ($this->type_invite == '') {
	            $this->type_invite = 0;
	        }
		}
    }

    /**
     * Used to dispach the component you need for invite module ajax call.
     *
     * NEVER DO QUERY CALLS IN THIS METHOD
     *
     * @param sfWebRequest $request
     */
    public function executeComponentDispatcher(sfWebRequest $request) {

        if($this->getRequest()->isXmlHttpRequest()) {

            // Redirect when the user is not loged in
            if(!$this->getUser()->isAuthenticated()) {
                return $this->renderComponent('interface', 'redirect', array('url'=>$this->generateUrl('sf_guard_signin')));
            }
            
            $this->customMessage = $request->getParameter('customMessage', '');
			$this->customUrl = $request->getParameter('customUrl', '');
			
            // If you want to display invite module from a room, you need the room uuid and room_data.
            $this->roomUuid = $request->getParameter('room_uuid', '0');
            $room = $this->getRoom($request, $this->roomUuid);
            $this->roomData = $this->getRoomDataForWidget($room);

            // If you want to display invite module from a kup, you need the kup uuid.
            $this->kupUuid = $request->getParameter('kup_uuid', '0');
            $this->kupData = $this->getKupData($request, $this->kupUuid);

            // It's represent the module you want to display (email, facebook, twitter, link...).
            $this->typeInvite = $request->getParameter('type_invite', 'email');

            // The module/component you will call to display it in the right side of the invite module.
            $this->calledModule = $request->getParameter('called_module', 'invite');
            $this->calledComponent = $request->getParameter('called_component', 'emails');

            // Initialization of variables
            $this->params = array();

            // When you call invite module for a room
            if($this->roomUuid != '0' && $this->kupUuid == '0') {
                $this->params = array(
	    			'room_uuid' => $this->roomUuid,
	    			'type_invite' => $this->typeInvite,
	    			'room_data' => $this->roomData,
	    			'url' => $this->getCustomUriPrefix($request).$this->getController()->genUrl(array('module' => 'room', 'action' => 'view', 'uuid' => $this->roomUuid))
                );
                // When you call invite module for a generic kup
            } else if($this->kupUuid != '0' && $this->roomUuid == '0') {
                $this->params = array(
	    			'kup_uuid' => $this->kupUuid,
	    			'type_invite' => $this->typeInvite,
	    			'kup_data' => $this->kupData,
	    			'url' => $this->getCustomUriPrefix($request).$this->getController()->genUrl(array('module' => 'kup', 'action' => 'view', 'uuid' => $this->kupUuid))
                );
                // When you call invite module for a kup inside a room
            } else if($this->roomUuid != '0' && $this->kupUuid != '0') {
                $this->params = array(
	    			'type_invite' => $this->typeInvite,
	    			'room_uuid' => $this->roomUuid,
	    			'room_data' => $this->roomData,
	    			'kup_uuid' => $this->kupUuid,
	    			'kup_data' => $this->kupData,
	    			'url' => $this->getCustomUriPrefix($request).$this->getController()->genUrl(array('module' => 'room', 'action' => 'kup', 'room_uuid' => $this->roomUuid, 'kup_uuid' => $this->kupUuid))
                );
            }
            if($this->customMessage != '') {
            	$this->params['customMessage'] = $this->customMessage;
            }
            if($this->customUrl != '') {
            	$this->params['url'] = $this->getCustomUriPrefix($request).$this->customUrl;
            }
                        
        	// Only for facebook
	        if($this->typeInvite == 'facebook') {
	            $this->invite_send = FALSE;
		        if ($request->isMethod ('post')) {
		            if ( $_POST["ids"] > 0 ) {
		                $this->invite_send = TRUE;
		            }
		        }
		        $this->params['invite_send'] = $this->invite_send;
	        }
        }
    }


    /**
     * Send email from mailing list
     *
     * Used for the invite friends Ajax module
     *
     * @param sfWebRequest $request
     */
    public function executeSendMail(sfWebRequest $request) {

        if($this->getRequest()->isXmlHttpRequest()) {
            // Mailer constants
            $email_subject =  $this->getContext()->getI18n()->__('label_room_invite_admin_subject');
            $email_body = $request->getParameter('mailBody');
            $email_rcpts = $this->getUser()->getAttribute('emails', '', 'invite');

            // Default value
            $uuid = -1;
            $type = '';

            if($request->getParameter('room_uuid') != '0') {
                $uuid = $request->getParameter('room_uuid');
                $type = 'room';
            }
            if($request->getParameter('kup_uuid') != '0') {
                $uuid = $request->getParameter('kup_uuid');
                $type = 'kup';
            }
            return $this->renderText($this->invite($request, $uuid, $type, $email_subject, $email_body, $email_rcpts));
        }
    }


    /**
     * Get emails from various provider using OpenInviter and update selection in session
     *
     * @param sfWebRequest $request
     */
    public function executeEmailsGet(sfWebRequest $request) {

        $this->invite_import_service = "gmail";
        $this->invite_import_email = "";
        $this->invite_import_password = "";
        $this->error = FALSE;

        $this->emails = $this->getUser()->getAttribute ('import', '', 'invite');
        $this->emails = array();

        if ($this->getUser()->getAttribute('provider', '', 'invite') != '' ) {
            $this->invite_import_service = $this->getUser()->getAttribute('provider', '', 'invite');
        }

        if ( $this->getUser()->getAttribute ('provider_email', '', 'invite' ) != '') {
            $this->invite_import_email = $this->getUser()->getAttribute('provider_email', '', 'invite');
        }

        if ( $this->getUser()->getAttribute ('provider_password', '', 'invite' ) != '') {
            $this->invite_import_password = $this->getUser()->getAttribute('provider_password', '', 'invite');
        }

        $this->param = $request->getParameter('param');
        if (!isset($this->param)) {
            $this->param = "";
        }

        if (!isset($this->error)) {
            $this->error = "";
        }

        if ($this->param == "import") {

            $array_parameters = explode ( "&", $request->getParameter ( 'other' ) );
            $array_parameters [0] = explode ( "=", $array_parameters [0] );
            $array_parameters [1] = explode ( "=", $array_parameters [1] );
            $array_parameters [2] = explode ( "=", $array_parameters [2] );

            $this->invite_import_service = $array_parameters [0] [1];
            $this->invite_import_email = $array_parameters [1] [1];
            $this->invite_import_password = $array_parameters [2] [1];

            $this->getUser ()->setAttribute ( 'provider', $this->invite_import_service, 'invite' );
            $this->getUser ()->setAttribute ( 'provider_email', $this->invite_import_email, 'invite' );
            $this->getUser ()->setAttribute ( 'provider_password', $this->invite_import_password, 'invite' );

            $open_inviter = new OpenInviter ();
            $open_inviter->getPlugins ();
            $open_inviter->startPlugin ($this->invite_import_service);
            $internal = $open_inviter->getInternalError ();
            if (! $open_inviter->login ( $this->invite_import_email, $this->invite_import_password )) {
                $internal = $open_inviter->getInternalError ();
                $this->error = ($internal ? $this->getContext()->getI18n()->__($internal) : $this->getContext()->getI18n()->__("label_invite_error_wrong_credentials"));
            } else if (! $arr_contact = $open_inviter->getMyContacts ()) {
                $this->error = $this->getContext()->getI18n()->__("label_invite_error_enable_to_get_contacts");
            } else {
                foreach ( $arr_contact as $key => $value ) {
                    $this->emails [$key] = $key;
                }
                $this->getUser ()->setAttribute ( 'import', $this->emails, 'invite' );
            }
        }
    }

    /**
     * Send invitation emails.
     *
     * @param sfWebRequest $request
     * @param int $room_uuid
     * @param str $email_subject
     * @param str $email_body
     * @param array $email_rcpts
     */
    private function invite(sfWebRequest $request, $uuid, $type, $email_subject='', $email_body='', $email_rcpts=array()) {

        $uuid = strval($uuid);
        if ($uuid == '-1' || $uuid == 'me') {
            return false;
        }

        $params = array(
	        'communityId' => sfConfig::get ('app_sofun_community_id'),
	        'inviter_email' => $this->getUser()->getAttribute('email', '', 'subscriber'),
	        'email_subject' => $email_subject,
	        'email_body' => $email_body,
	        'email_rcpts' => $email_rcpts,
        );

        $sofun = BetkupWrapper::_getSofunApp($request, $this);
        try {
            if($type == 'room') {
                $response = $sofun->api_POST("/team/" . $uuid . "/invite", $params);
            } else if($type == 'kup') {
                $response = $sofun->api_POST("/kup/" . $uuid . "/invite", $params);
            }
        } catch (SofunApiException $e) {
            error_log($e);
        }

        if ($response["http_code"] == "202") {
            return '202';
        } else {
            error_log($response['buffer']);
            return 'error';
        }
    }

	/**
     * Display admin invite Facebook request view.
     *
     * @param sfWebRequest $request
     */
    public function executeInviteFacebook(sfWebRequest $request) {

        $this->room_uuid = $request->getParameter('room_uuid');
        $this->kup_uuid = $request->getParameter('kup_uuid');

        // Send facebook invite request from a room
        if($this->room_uuid != 0 && $this->kup_uuid == 0) {
        	$room = $this->getRoom($request, $this->room_uuid);
        	$this->dataRoom = $this->getRoomDataForWidget($room);
        	$this->setEditTabs($request, $this->room_uuid);
        // Send facebook invite request from a kup
        } else if($this->room_uuid == 0 && $this->kup_uuid != 0) {

        // Send facebook invite request from kup in a room
        } else if($this->room_uuid != 0 && $this->kup_uuid != 0) {

        }

        $this->invite_send = FALSE;
        if ($request->isMethod ('post')) {
            if ( $_POST["ids"] > 0 ) {
                $this->invite_send = TRUE;
            }
        }
    }
}
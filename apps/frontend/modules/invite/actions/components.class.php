<?php

/**
 * Member Invite Components.
 *
 * @package    betkup.fr
 * @subpackage kup
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: components.class.php 1212 2011-07-01 13:00:47Z jbraconnier $
 */
class inviteComponents extends sfComponents {

    /**
     * Displays the left navigation menu to access various invite views.
     */
    public function executeMenu() {

        if (!isset($this->type_invite)) {
            $this->type_invite = sfConfig::get('mod_invites_type_email');
        }
    }

    /**
     * Displays a view where member can build up list of email recipients
     * from various provider and / or manual typing.
     */
    public function executeEmails() {

    	// Parameters passed to the component by invite/componentDispatcher action.
        if (!isset($this->type_invite)) {
            $this->type_invite = sfConfig::get('mod_invite_type_email');
        }

        if (!isset($this->invite_import_service)) {
            $this->invite_import_service = 'gmail';
        }

        if(!isset($this->room_uuid)) {
            $this->room_uuid = 0;
        }

        if(!isset($this->kup_uuid)) {
            $this->kup_uuid = 0;
        }

        // Default values
        $this->name = array("room" => '', "kup" => '');
        $text = '';
        $this->textDefault = '';

        // When you call invite module for a room
        if(!isset($this->room_data)) {
            $this->room_data = 0;
        } else {
            $this->name["room"] = $this->room_data['name'];

            // Public room
            if($this->room_data['privacy'] == sfConfig::get('mod_invite_privacy_room_public')
               || $this->room_data['privacy'] == sfConfig::get('mod_invite_privacy_room_public_gambling_fr')) {

                $text = $this->getContext()->getI18N()->__('label_room_public_invite_admin_body');
                $this->textDefault = sprintf($text, $this->name["room"], $this->url, $this->getUser()->getAttribute('firstName', '', 'subscriber'), $this->getUser()->getAttribute('nickName', '', 'subscriber'));

                // Private room
            } else if($this->room_data['privacy'] == sfConfig::get('mod_invite_privacy_room_private')
            		  || $this->room_data['privacy'] == sfConfig::get('mod_invite_privacy_room_private_gambling_fr')) {

                $text = $this->getContext()->getI18N()->__('label_room_private_invite_admin_body');
                $this->textDefault = sprintf($text, $this->name["room"], $this->url, $this->getUser()->getAttribute('firstName', '', 'subscriber'), $this->getUser()->getAttribute('nickName', '', 'subscriber'));
            }
        }

        // When you call invite module for a generic kup
        if(!isset($this->kup_data)) {
            $this->kup_data = '0';
        } else {

            $this->name["kup"] = $this->kup_data['name'];
            $this->description = $this->kup_data['description'];
            $this->days = Util::nombreJoursEntreDeuxDatesCustom( time(), $this->kup_data['startDate'], 'jours'); //XXX Fix it, startDate => effectiveDate
            $this->participants = $this->kup_data['legend3'];
            $this->benefit = $this->kup_data['jackpot'];

            // Kup with reward (No stake)
            if($this->kup_data['type'] == sfConfig::get('mod_invite_kup_free')) {

                $text = $this->getContext()->getI18N()->__('label_kup_reward_invite_admin_body');
                $this->textDefault = sprintf($text, $this->name["kup"], $this->participants, $this->days, $this->url, $this->description, $this->getUser()->getAttribute('firstName', '', 'subscriber'), $this->getUser()->getAttribute('nickName', '', 'subscriber'));

                // Kup with stake
            } else if($this->kup_data['type'] == sfConfig::get('mod_invite_kup_gambling_fr')) {

                $text = $this->getContext()->getI18N()->__('label_kup_stake_invite_admin_body');
                $this->textDefault = sprintf($text, $this->name["kup"], $this->benefit, $this->participants, $this->days, $this->url, $this->description, $this->getUser()->getAttribute('firstName', '', 'subscriber'), $this->getUser()->getAttribute('nickName', '', 'subscriber'));
            }
        }

        // When you call invite module for a kup inside a room
        if($this->kup_data != '0' && $this->room_data != '0') {
            $this->name["kup"] = $this->kup_data['name'];
            $this->name["room"] = $this->room_data['name'];
            $this->description = $this->kup_data['description'];
            $this->days = Util::nombreJoursEntreDeuxDatesCustom(time(), $this->kup_data['startDate'], 'jour(s)'); //XXX Fix it, startDate => effectiveDate
            $this->participants = $this->kup_data['legend3'];
            $this->benefit = $this->kup_data['jackpot'];

            	// Custom message
            if(isset($this->customMessage) && $this->customMessage != '') {
            	$text = $this->getContext()->getI18N()->__($this->customMessage);
                $this->textDefault = sprintf($text, $this->name["kup"], $this->participants, $this->days, $this->url, $this->description, $this->getUser()->getAttribute('firstName', '', 'subscriber'), $this->getUser()->getAttribute('nickName', '', 'subscriber'));
            	
            	// Kup inside room with reward (No stake)
            } else if($this->kup_data['type'] == sfConfig::get('mod_invite_kup_free')) {

                $text = $this->getContext()->getI18N()->__('label_room_kup_reward_invite_admin_body');
                $this->textDefault = sprintf($text, $this->name["kup"], $this->name["room"], $this->participants, $this->days, $this->url, $this->getUser()->getAttribute('firstName', '', 'subscriber'), $this->getUser()->getAttribute('nickName', '', 'subscriber'));

                // Kup inside room with stake
            } else if($this->kup_data['type'] == sfConfig::get('mod_invite_kup_gambling_fr')) {

                $text = $this->getContext()->getI18N()->__('label_room_kup_stake_invite_admin_body');
                $this->textDefault = sprintf($text, $this->name["kup"], $this->name["room"], $this->benefit, $this->participants, $this->days, $this->url, $this->getUser()->getAttribute('firstName', '', 'subscriber'), $this->getUser()->getAttribute('nickName', '', 'subscriber'));
            }
        }
    }

    /**
     * Displays a view where a member can leverage various Facebook services.
     * Request, Like, Send, Recommends, etc.
     */
    public function executeFacebook() {
    	$cache_expire = 60*60*24*365;
		header("Pragma: public");
		header("Cache-Control: max-age=".$cache_expire);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$cache_expire) . ' GMT');
		
    	// Parameters passed to the component by invite/componentDispatcher action.
        if(!isset($this->url)) {
            $this->url = '';
        }

        if(!isset($this->room_uuid)) {
        	$this->room_uuid = 0;
        }
    	if(!isset($this->kup_uuid)) {
        	$this->kup_uuid = 0;
        }
        
        // Show the apropriate message to send facebook request to friends
        $this->messageInviteFacebook = __('text_facebook_invite_generic');
        if($this->room_uuid != 0 && $this->kup_uuid == 0) {
        	$this->messageInviteFacebook = __('text_facebook_invite_room', array('%room%' => $this->room_data["name"]));
        } else if($this->room_uuid == 0 && $this->kup_uuid != 0) {
        	$this->messageInviteFacebook = __('text_facebook_invite_kup', array('%kup%' => $this->kup_data["name"]));
        } else if($this->room_uuid != 0 && $this->kup_uuid != 0) {
        	$this->messageInviteFacebook = __('text_facebook_invite_room_kup', array('%room%' => $this->room_data["name"], '%kup%' => $this->kup_data["name"]));
        }

        $this->exclude_ids = "";
    }

    /**
     * Display Facebook custom share button.
     * Typically, put at the top of a given page.
     */
    public function executeFacebookShare() {
		// Parameters passed to the component by invite/componentDispatcher action.
        if(!isset($this->url)) {
            $this->url = '';
        }
    }

    /**
     * Displays a view where a member can leverate / post to Twitter.
     */
    public function executeTwitter() {
		// Parameters passed to the component by invite/componentDispatcher action.
        if(!isset($this->url)) {
            $this->url = '';
        }

        $this->message = '';

        // Message for room
    	if($this->room_uuid != 0 && $this->kup_uuid == 0) {
    		$this->message = $this->getContext()->getI18N()->__('label_room_invite_twitter', array('%room_name%' => Util::coupe($this->room_data['name'], 10, '..')));
    	// Message for kup
    	} else if($this->room_uuid == 0 && $this->kup_uuid != 0) {
    		$this->message = $this->getContext()->getI18N()->__('label_kup_invite_twitter', array('%kup_name%' => Util::coupe($this->kup_data['name'], 10, '..')));
    	// Message for room kups
    	} else if($this->room_uuid != 0 && $this->kup_uuid != 0) {
    		$this->message = $this->getContext()->getI18N()->__('label_kup_room_invite_twitter', array('%kup_name%' => Util::coupe($this->kup_data['name'], 10, '..'), '%room_name%' => Util::coupe($this->room_data['name'], 10, '..')));
    	}
    }

    /**
     * Simply displays a link that one can copy and paste.
     */
    public function executeLink() {
		// Parameters passed to the component by invite/componentDispatcher action.
        if(!isset($this->url)) {
            $this->url = '';
        }

    }

}
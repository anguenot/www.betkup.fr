<?php

/**
 * My Betkup Components.
 *
 * @package    betkup.fr
 * @subpackage room
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: components.class.php 3275 2011-11-08 17:26:51Z jmasmejean $
 */
class meComponents extends sfComponents {

	/**
	 * Displays the content of the right column.
	 */
	public function executeRight() {

	}

	/**
	 * Displays the dashboard header including call to actions.
	 */
	public function executeDashboard() {

	}
        
        /**
	 * Select the status for kups
	 */
        public function executeSelectKupStatus() {
            $this->kupsStatus = array(
                sfConfig::get('app_kup_status_all_opened') => __('text_kups_active'),  
                sfConfig::get('app_kup_status_all_closed') => __('text_kups_closed'));

            $this->selectedKup = sfConfig::get('app_kup_status_all_opened');
	}

}
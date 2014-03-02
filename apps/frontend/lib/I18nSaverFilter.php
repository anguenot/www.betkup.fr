<?php

/**
 * i18n filter definition.
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: I18nSaverFilter.php 5275 2012-06-15 13:18:12Z anguenot $
 */
class I18nSaverFilter extends sfFilter {

	function execute ($filterChain) {
		$filterChain->execute();
		if ($this->isFirstCall()) {
			sfContext::getInstance()->getI18N()->getGlobalMessageSource()->save();
			sfContext::getInstance()->getI18N()->getMessageSource()->save();
		}
	}

}

?>
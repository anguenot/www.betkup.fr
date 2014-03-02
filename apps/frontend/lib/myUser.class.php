<?php

/**
 * Symfony Betkup.fr security user.
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: myUser.class.php 3037 2011-09-30 10:08:52Z anguenot $
 */
class sfBetkupSecurityUser extends sfBasicSecurityUser {

    public function isAuthenticated() {
        return(parent::isAuthenticated());
    }

    public function hasCredential($credentials, $useAnd = true) {
        return(parent::hasCredential($credentials, $useAnd));
    }

}

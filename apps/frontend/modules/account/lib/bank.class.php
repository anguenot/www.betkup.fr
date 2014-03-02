<?php

require_once(dirname(__FILE__) .'/php-iban/php-iban.php');
require_once(dirname(__FILE__) .'/cc.php');

/**
 * Collection of utils used for banking validation.
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: bank.class.php 3637 2012-01-24 18:12:35Z jmasmejean $
 */
class Bank {

    /**
     * Validated a RIB.
     *
     * @param String $rib
     */
    static function isValidRib($rib) {

        if(mb_strlen($rib) !== 23) {
            return false;
        }

        $key = substr($rib,-2);
        $bank = substr($rib,0,5);
        $branch = substr($rib,5,5);
        $account = substr($rib,10,11);
        $account = strtr($account, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', '12345678912345678923456789');

        return 97 - bcmod(89*$bank + 15 * $branch + 3 * $account,97) === (int)$key;
    }

    /**
     * Validates an IBAN.
     *
     * @param String $iban
     */
    static function isValidIBAN($iban) {
        return verify_iban($iban);
    }

    /**
     * Validats a BIC.
     *
     * @param String $bic
     */
    static function isValidBIC($bic) {

        if ($bic == '') {
            return false;
        }

        if (!(strlen($bic) == 8 || strlen($bic) == 11)) {
            return false;
        }

        $country = substr($bic,4,2);
        $valid_countries = Data::ISOCountries();

        if (!array_key_exists($country, $valid_countries)) {
            return false;
        }

        return true;
    }

    /**
     * Validates a CC.
     *
     *
     * @param String $cardnumber
     * @param String $cardname
     * @param unknown_type $errornumber
     * @param unknown_type $errortext
     */
    static function isValidCC ($cardname, $cardnumber, &$errornumber, &$errortext) {
        return checkCreditCard($cardnumber, $cardname, $errornumber, $errortext);
    }

}

?>
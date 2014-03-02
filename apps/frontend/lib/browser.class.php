<?php

/**
 * Browser related functions.
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: browser.class.php 3037 2011-09-30 10:08:52Z anguenot $
 */
class browser {

    static function get_browser() {

        // reversed array
        $browser = array(
            "OPERA",
            "MSIE", // parent
            "NETSCAPE",
            "FIREFOX",
            "SAFARI",
            "KONQUEROR",
            "MOZILLA" // parent
        );

        $info['browser'] = "OTHER";

        foreach ($browser as $parent) {
            if (($s = stripos($_SERVER['HTTP_USER_AGENT'], $parent)) !== FALSE) {
                $f = $s + strlen($parent);
                $version = substr($_SERVER['HTTP_USER_AGENT'], $f, 5);
                $version = preg_replace('/[^0-9,.]/', '', $version);

                $info['browser'] = $parent;
                $info['version'] = $version;
                break; // first match wins
            }
        }
        return $info;
    }

}
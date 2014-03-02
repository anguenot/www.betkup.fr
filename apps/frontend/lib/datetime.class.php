<?php

/**
 * Collection of date time functions.
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: datetime.class.php 3037 2011-09-30 10:08:52Z anguenot $
 */
Class DateTimeUtil {

    /**
     *
     * Returns the a DateTime object given a timestamp w/ timezone.
     *
     * @param integer $timestamp
     * @return DateTime
     */
    static function getDateTimeFromTimestamp($timestamp) {

        date_default_timezone_set('UTC');

        $date_str = strftime("%Y-%m-%d", substr($timestamp, 0, 10));
        return new DateTime($date_str);

    }

    /**
     *
     * Enter description here ...
     * @param unknown_type $timestamp
     */
    static function getDateFromTimestamp($timestamp) {

        date_default_timezone_set('UTC');

        $date_str = strftime("%Y-%m-%d", substr($timestamp, 0, 10));
        return date($date_str);

    }

    /**
     *
     * Returns the difference in between 2 dates.
     *
     * @param DateTime $oDate1
     * @param DateTime $oDate2
     * @return array
     */
    static function getDateTimeArrayDifference($oDate1, $oDate2) {

        $aIntervals = array(
	        'year'   => 0,
	        'month'  => 0,
	        'week'   => 0,
	        'day'    => 0,
	        'hour'   => 0,
	        'minute' => 0,
	        'second' => 0,
        );

        foreach($aIntervals as $sInterval => &$iInterval) {
            while($oDate1 <= $oDate2){
                $oDate1->modify('+1 ' . $sInterval);
                if ($oDate1 > $oDate2) {
                    $oDate1->modify('-1 ' . $sInterval);
                    break;
                } else {
                    $iInterval++;
                }
            }
        }

        return $aIntervals;
    }

    /**
     *
     * Returns a number of days in between 2 timestamps
     *
     * @param integer $time1
     * @param integer $time2
     * @return integer
     */
    static function getDateTimeDifferenceDays($time1, $time2) {

        $nb_days = 0;

        $oDate1 = DateTimeUtil::getDateTimeFromTimestamp(intval($time1));
        $oDate2 = DateTimeUtil::getDateTimeFromTimestamp(intval($time2));

        $diff = $oDate2->diff($oDate1);

        $nb_days = $diff->d;
        $nb_days += $diff->m * 30;
        $nb_days += $diff->y * 365;

        return $nb_days;

    }


}

?>
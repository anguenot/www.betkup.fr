<?php

    /**
     * Collection of utils used throughout the application.
     *
     * @package    betkup.fr
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: util.class.php 6539 2012-11-22 14:27:10Z jmasmejean $
     */
    class Util {

        static function age($naiss) {

            list($annee, $mois, $jour) = explode('-', $naiss);

            $today['mois'] = date('n');
            $today['jour'] = date('j');
            $today['annee'] = date('Y');

            $annees = $today['annee'] - $annee;

            if ($today['mois'] < $mois) {
                $annees--;
            }

            if ($mois == $today['mois'] && $jour > $today['jour']) {
                $annees--;
            }

            return $annees;
        }

        static function displayWithPosition($val) {
            if ($val == "NC") {
                return ('NC');
            }
            else if ($val == "1") {
                return ('1er');
            }
            else {
                return ($val . 'ème');
            }
        }

        static function displayDateFromTimestampComplet($val) {
            // Mardi 15 février - 20h45
            date_default_timezone_set('UTC');
            setlocale(LC_TIME, 'fr_FR');
            return (strftime("%A %d %B - %Hh%M", substr($val, 0, 10) + 7200));
        }

        static function displayDateSimpleFromTimestampComplet($val) {
            // Mardi 15 février
            date_default_timezone_set('UTC');
            setlocale(LC_TIME, 'fr_FR');
            return (strftime("%A %d %B", substr($val, 0, 10) + 7200));
        }

        static function displayDateChiffreFromTimestampComplet($val, $timezone = true) {
            if ($timezone) {
                return (strftime("%d %m %Y", substr($val, 0, 10)));
            }
            else {
                // This is the correct one (len - 3) the rest is buggy...
                return (strftime("%d %m %Y", substr($val, 0, strlen($val) - 3)));
            }
        }

        static function displayDateFormated($val, $timezone = true) {
            date_default_timezone_set('Europe/Paris');
            if ($timezone) {
                return (strftime("%d/%m/%y", substr($val, 0, 10)));
            }
            else {
                return (strftime("%d/%m/%y", substr($val, 0, 9)));
            }
        }

        static function displayTimeFromTimestamp($val, $timezone = true) {
            date_default_timezone_set('Europe/Paris');
            if ($timezone) {
                return (strftime("%Hh%M", substr($val, 0, 10)));
            }
            else {
                return (strftime("%Hh%M", substr($val, 0, 9)));
            }
        }

        static function displayDateCompleteFromTimestampComplet($val, $timezone = true) {
            if ($val == '') {
                return '-';
            }
            date_default_timezone_set('Europe/Paris');
            if ($timezone) {
                return (strftime("%d/%m/%Y - %Hh%M - %Z", substr($val, 0, 10)));
            }
            else {
                return (strftime("%d/%m/%Y - %Hh%M - %Z", substr($val, 0, 9)));
            }
        }

        static function array_replace_recursive($array, $array1) {

            function recurse($array, $array1) {
                foreach ($array1 as $key => $value) {
                    // create new key in $array, if it is empty or not an array
                    if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key]))) {
                        $array[$key] = array();
                    }
                    // overwrite the value in the base array
                    if (is_array($value)) {
                        $value = recurse($array[$key], $value);
                    }
                    $array[$key] = $value;
                }
                return $array;
            }

            // handle the arguments, merge one by one
            $args = func_get_args();
            $array = $args[0];
            if (!is_array($array)) {
                return $array;
            }
            for ($i = 1; $i < count($args); $i++) {
                if (is_array($args[$i])) {
                    $array = recurse($array, $args[$i]);
                }
            }
            return $array;
        }

        static function nomFichier($str) {
            $str = @ereg_replace("\\\'", "_", $str);
            $str = htmlentities($str, ENT_NOQUOTES);
            $str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $str);
            $str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str);
            $str = preg_replace('#\&[^;]+\;#', '', $str);
            $str = @ereg_replace(' ', '_', $str);
            return $str;
        }

        static function displayTableau($tab = array()) {
            echo '<pre>';
            print_r($tab);
            echo '</pre>';
        }

        static function telephone($telephone = "") {
            if (@eregi("[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]", $telephone)) {
                // On formatte le telephone
                $telephone = $telephone[0] . $telephone[1] . " " .
                    $telephone[2] . $telephone[3] . " " .
                    $telephone[4] . $telephone[5] . " " .
                    $telephone[6] . $telephone[7] . " " . $telephone[8] . $telephone[9];
            }
            return ($telephone);
        }

        static function prix($prix = "0.00") {
            $prix = @ereg_replace("[a-zA-Z]", "", $prix);
            if ($prix == "") {
                $prix = "0.00";
            }
            $prix = @ereg_replace(",", ".", $prix);
            $prix = @ereg_replace(" ", "", $prix);
            $prix = number_format($prix, 2, '.', ' ');
            return ($prix);
        }

        static function supprimeLesZeros($nombre = "0") {
            $nombre = $nombre / 1;
            return ($nombre);
        }

        /**
         *
         */
        static function dateFrancaisToMysql($date = '') {
            $date = str_replace("/", "", $date);
            return (substr($date, 4, 4) . "-" . substr($date, 2, 2) . "-" . substr($date, 0, 2));
        }

        /**
         * Affiche une date au format JJ/MM/AAAA
         *
         * @param 2010-10-01
         */
        static function dateFrancais($date = "") {

            if ($date == "" || $date == "0000-00-00") {
                // On recup la date du jour
                $dateFormatte = "";
            }
            else if (!@eregi("[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]", $date)) {
                // On recup la date du jour
                $dateFormatte = @date("d/m/Y");
            }
            else {
                $tabDate = explode("-", $date);
                $dateFormatte = $tabDate[2] . "/" . $tabDate[1] . "/" . $tabDate[0];
            }
            return ($dateFormatte);
        }

        /**
         * Affiche une date au format JJ/MM/AAAA HHhMM
         *
         * @param 2010-10-14 13:20:57
         */
        static function dateFrancaisComplete($date = "") {

            if ($date == "" || $date == "0000-00-00") {
                // On recup la date du jour
                $dateFormatte = "";
            }
            else if (!@eregi("[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9] [0-9][0-9]:[0-9][0-9]:[0-9][0-9]", $date)) {
                // On recup la date du jour
                $dateFormatte = @date("d/m/Y H:00:00");
            }
            else {
                // Premiere partie
                $date1 = explode(" ", $date);
                $datePartie1 = $date1[0];
                $datePartie2 = $date1[1];
                $tabDate1 = explode("-", $datePartie1);
                $tabDate2 = explode(":", $datePartie2);
                $dateFormatte = $tabDate1[2] . "/" . $tabDate1[1] . "/" . $tabDate1[0] . " à " . $tabDate2[0] . "h" . $tabDate2[1];
            }
            return ($dateFormatte);
        }

        /**
         * Affiche une date au format JJ/MM/AAAA
         *
         * @param 2010-10-14 13:20:57
         */
        static function dateFrancaisSimpleFromDatetime($date = "") {

            if ($date == "" || $date == "0000-00-00") {
                // On recup la date du jour
                $dateFormatte = "";
            }
            else if (!@eregi("[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9] [0-9][0-9]:[0-9][0-9]:[0-9][0-9]", $date)) {
                // On recup la date du jour
                $dateFormatte = @date("d/m/Y H:00:00");
            }
            else {
                // Premiere partie
                $date1 = explode(" ", $date);
                $datePartie1 = $date1[0];
                $datePartie2 = $date1[1];
                $tabDate1 = explode("-", $datePartie1);
                $tabDate2 = explode(":", $datePartie2);
                $dateFormatte = $tabDate1[2] . "/" . $tabDate1[1] . "/" . $tabDate1[0];
            }
            return ($dateFormatte);
        }

        /**
         * Affiche une date au format HH:MM
         *
         * @param 2010-10-14 13:20:57
         */
        static function HeureFromDatetime($date = "") {

            if ($date == "" || $date == "0000-00-00") {
                // On recup la date du jour
                $dateFormatte = "";
            }
            else if (!@eregi("[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9] [0-9][0-9]:[0-9][0-9]:[0-9][0-9]", $date)) {
                // On recup la date du jour
                $dateFormatte = @date("d/m/Y H:00:00");
            }
            else {
                // Premiere partie
                $date1 = explode(" ", $date);
                $datePartie1 = $date1[0];
                $datePartie2 = $date1[1];
                $tabDate1 = explode("-", $datePartie1);
                $tabDate2 = explode(":", $datePartie2);
                $dateFormatte = $tabDate2[0] . ":" . $tabDate2[1];
            }
            return ($dateFormatte);
        }

        /**
         * Calcule le nombre de semaines entre 2 dates
         *
         * @param <type> $date1 2010-02-01
         * @param <type> $date2 2010-01-01
         */
        static function nombreSemainesEntreDeuxDates($date1 = "") {
            $arrayDate1 = explode("-", $date1);
            $Date1 = mktime(0, 0, 0, $arrayDate1[1], $arrayDate1[2], $arrayDate1[0]);
            $Date2 = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
            $nombreDeSemaines = round(($Date1 - $Date2) / (60 * 60 * 24 * 7));
            return ($nombreDeSemaines);
        }

        static function nombreJoursEntreDeuxDates($startDate, $endDate, $day = '') {
            $diffSecondes = substr($endDate, 0, 10) - substr($startDate, 0, 10);
            $numberDays = round(($diffSecondes) / (60 * 60 * 24));
            if ($numberDays <= 0) {
                $numberDays = "< 1" . $day;
            }
            else {
                $numberDays = $numberDays . ' ' . $day;
            }
            return ($numberDays);
        }

        static function diffDate($startDate, $endDate) {
            $diffSecondes = substr($endDate, 0, 10) - substr($startDate, 0, 10);
            $numberDays = round(($diffSecondes) / (60 * 60 * 24));

            return ($numberDays);
        }

        /**
         * Return number of day between two date.
         * Return "< 1 $day" if endDate is equal to start date
         * Return time between two dates if -1 day
         *
         * @param timestamp $startDate
         * @param timestamp $endDate
         * @param string    $day
         *
         * @return string
         */
        static function nombreJoursEntreDeuxDatesCustom($startDate, $endDate, $day = '') {
            $diffSecondes = substr($endDate, 0, 10) - substr($startDate, 0, 10);
            $numberDays = round(($diffSecondes) / (60 * 60 * 24));

            if ($numberDays <= 0) {
                $numberDays = gmdate('H\hi\m', $diffSecondes);
            }
            else {
                $numberDays = $numberDays . ' ' . $day;
            }
            return ($numberDays);
        }

        /**
         * Convertit une chaine de caracteres en minuscules
         * Convertit la premiere lettre en Majuscule
         */
        static function formatNomPropre($chaine = "") {
            $chaineTmp = strtolower($chaine);
            $chaineTmp[0] = strtoupper($chaineTmp[0]);
            return ($chaineTmp);
        }

        /**
         * Coupe une chaine de caracteres
         *
         * @param string  $chaine: chaine a decouper
         * @param integer $long  : les $long premiers caracteres à garder dans $chaine
         * @param string  $fin   : signe de coupure de la chaine si $long plus grand que la longueur de $chaine
         */
        static function coupe($chaine = '', $long = 0, $fin = '') {
            $chaineTmp = "";
            if ($chaine == "") {
                return $chaineTmp = "";
            }
            if ($long == 0 /* or !is_int($long) */) {
                return $chaineTmp = $chaine;
            }
            if ($chaine != "") {
                if (($long > 0) and ($long < strlen($chaine))) {
                    $chaine = mb_substr($chaine, 0, $long, 'UTF-8');
                    return $chaineTmp = $chaine . $fin;
                }
                else {
                    return $chaineTmp = $chaine;
                }
            }
        }

        /**
         * Returns the months to displau on credit form CB expiration.
         *
         * @return array of months
         */
        static function getCBExpirationMonths() {
            $months = array();
            for ($i = 1; $i <= 12; $i++) {
                $months[] = sprintf("%02d", $i);
            }
            return $months;
        }

        static function getAvatarFor($member) {
            $memberId = $member['uuid'];
            $avatar = $member['avatarSmall'];

            $avatarsPath = sfConfig::get('sf_web_dir') . '/uploads/assets';
            $dir = opendir($avatarsPath) or die();

            while ($file = readdir($dir)) {
                if ($file != '.' && $file != '..') {
                    $pathInfos = pathinfo($file);
                    $fileName = $pathInfos['filename'];
                    if ($memberId . '_avatar' == $fileName) {
                        $avatar = '/uploads/assets/' . $pathInfos['basename'];
                        break;
                    }
                }
            }
            if (Util::startswith($avatar, "http://")) {
                $count = 1;
                $avatar = str_replace("http", "https", $avatar, $count);
            }
            if ($avatar == '') {
                $avatar = '/image/default/member/avatar/default_medium.png';
            }

            return $avatar;
        }

        static function getAvatarForUser($avatar) {

            if ($avatar == '') {
                $avatar = '/image/default/member/avatar/default_medium.png';
            }
            else {
               $avatar = str_replace("http://", "https://", $avatar);
            }

            return $avatar;
        }

        /**
         * Recursive version of glob
         *
         * @return array containing all pattern-matched files.
         *
         * @param string $sPattern     Pattern to glob for.
         * @param string $sDir         Directory to start with.
         * @param int    $nFlags       Flags sent to glob.
         */
        static function getFilesBeginningWith($sPattern, $sDir, $nFlags = NULL) {

            $sDir = escapeshellcmd($sDir);
            $aFiles = glob("$sDir/$sPattern", $nFlags);

            foreach (glob("$sDir/*", GLOB_ONLYDIR) as $sSubDir) {
                $aSubFiles = rglob($sSubDir, $sPattern, $nFlags);
                $aFiles = array_merge($aFiles, $aSubFiles);
            }

            return $aFiles;
        }

        /**
         * Returns the years to display on credit form CB expiration.
         *
         * @return array if year from current year
         */
        static function getCBExpirationYears() {
            $years = array();
            for ($i = date("Y"); $i <= 2015; $i++) {
                $years[] = sprintf("%02d", $i);
            }
            return $years;
        }

        /**
         * Returns the time diff text from now and date
         *
         * @param unknown_type $val
         */
        static function displayDiffFromTimestamp($val) {

            $dateNow = date(DATE_ATOM);
            $dateNow = new DateTime($dateNow);

            $dateEvent = date(DATE_ATOM, substr($val, 0, 10));
            $dateEvent = new DateTime($dateEvent);

            $diff = $dateEvent->diff($dateNow);

            $message = '';
            if (($diff->s) > 0) {
                $nb_seconds = $diff->s;
                $message = $nb_seconds . ' ' . 'seconds';
                if (($diff->s) == 1) {
                    $message = $nb_seconds . ' ' . 'second';
                }
            }

            if (($diff->i) > 0) {
                $nb_minutes = $diff->i;
                $message = $nb_minutes . ' ' . 'minutes';
                if (($diff->i) == 1) {
                    $message = $nb_minutes . ' ' . 'minute';
                }
            }

            if (($diff->h) > 0) {
                $nb_hours = $diff->h;
                $message = $nb_hours . ' ' . 'hours';
                if (($diff->h) == 1) {
                    $message = $nb_hours . ' ' . 'hour';
                }
            }

            if (($diff->d) > 0) {
                $nb_days = $diff->d;
                $message = $nb_days . ' ' . 'days';
                if (($diff->d) == 1) {
                    $message = $nb_days . ' ' . 'day';
                }
            }

            // XXX translate
            return $message;

        }

        static function file_get_contents_utf8($fn) {
            $content = file_get_contents($fn);
            return mb_convert_encoding($content, 'UTF-8',
                mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
        }

        static function checkEmail($email) {
            if (@eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $email)) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }

        static function startswith($string, $search) {
            $ret = false;
            if (strlen($string) >= strlen($search)) {
                $ret = (substr($string, 0, strlen($search)) == $search);
            }
            return $ret;
        }

        static function endswith($string, $search) {
            $string = strrev($string);
            $search = strrev($search);
            return Util::startswith($string, $search);
        }

        /**
         * Format the nickname, return FirstName L. if nickname is empty
         *
         * @param array $member
         *
         * @return string
         */
        static function getNicknameFor($member) {

            $nickname = $member['nickName'];
            $firstName = $member['firstName'];
            $lastName = $member['lastName'];

            if ($nickname == '') {
                $nickname = $firstName . " " . substr($lastName, 0, 1) . '.';
            }
            return $nickname;
        }

        static function getRepartitionsFor($repartitionId) {
            switch ($repartitionId) {
                case '1' :
                    $repartition = array(
                        'title'       => 'Le 1er',
                        'description' => '(1er : 100%)'
                    );
                    break;
                case '2' :
                    $repartition = array(
                        'title'       => 'Les 2 premiers',
                        'description' => '(1er : 70%, 2ème : 30%)'
                    );
                    break;
                case '3' :
                    $repartition = array(
                        'title'       => 'Les 3 premiers',
                        'description' => '(1er : 50%, 2ème : 30%, 3ème : 20%)'
                    );
                    break;
                case '4' :
                    $repartition = array(
                        'title'       => 'Les 10 premiers',
                        'description' => '(1er : 25%, 2ème 20%, 3ème : 15%, 4ème : 10%, du 5ème au 10ème : 5%)'
                    );
                    break;
                case '5' :
                    $repartition = array(
                        'title'       => 'Les 13 premiers',
                        'description' => '(1er : 23%, 2ème 15%, 3ème : 13%, 4ème : 10%, 5ème : 7%; du 6ème au 13ème : 4%)'
                    );
                    break;
                case '6' :
                    $repartition = array(
                        'title'       => 'Les 20 premiers',
                        'description' => '(1er : 20%, 2ème 12%, 3ème : 10%, 4ème : 8%, 5ème au 10ème : 5%; du 11ème au 20ème : 2%)'
                    );
                    break;
                case '55' :
                    $repartition = array(
                        'title'       => 'Les 5 premiers',
                        'description' => '(1er : 30%, 2ème : 25%, 3ème : 20%, 4ème : 15%, 5ème : 10%)'
                    );
                    break;
                case '30' :
                    $repartition = array(
                        'title'       => 'Les 30 premiers',
                        'description' => '(1er : 15%, 2ème : 10 %, 3ème : 7%, 4ème au 10ème : 4%, 11ème au 30ème : 2%)'
                    );
                    break;
                default:
                    $repartition = $repartitionId;
                    break;
            }
            return $repartition;
        }

        static function getRepartitionsArrayBoxFor($repartitionId) {
            switch ($repartitionId) {
                case '1' :
                    $repartition = array(
                        0 => array(
                            'title'       => '1er',
                            'description' => '100%)'
                        )
                    );
                    break;
                case '2' :
                    $repartition = array(
                        0    => array(
                            'title'       => '1er',
                            'description' => '70%'
                        ), 1 => array(
                            'title'       => '2ème',
                            'description' => '30%'
                        )
                    );
                    break;
                case '3' :
                    $repartition = array(
                        0    => array(
                            'title'       => '1er',
                            'description' => '50%'
                        ), 1 => array(
                            'title'       => '2ème',
                            'description' => '30%'
                        ), 2 => array(
                            'title'       => '3ème',
                            'description' => '20%'
                        )
                    );
                    break;
                case '4' :
                    $repartition = array(
                        0    => array(
                            'title'       => '1er',
                            'description' => '25%'
                        ), 1 => array(
                            'title'       => '2ème',
                            'description' => '20%'
                        ), 2 => array(
                            'title'       => '3ème',
                            'description' => '15%'
                        ), 3 => array(
                            'title'       => '4ème',
                            'description' => '10%'
                        ), 4 => array(
                            'title'       => '5ème au 10ème',
                            'description' => '5%'
                        )
                    );
                    break;
                case '5' :
                    $repartition = array(
                        0    => array(
                            'title'       => '1er',
                            'description' => '23%'
                        ), 1 => array(
                            'title'       => '2ème',
                            'description' => '15%'
                        ), 2 => array(
                            'title'       => '3ème',
                            'description' => '13%'
                        ), 3 => array(
                            'title'       => '4ème',
                            'description' => '10%'
                        ), 4 => array(
                            'title'       => '5ème',
                            'description' => '7%'
                        ), 5 => array(
                            'title'       => '6ème au 13ème',
                            'description' => '4%'
                        )
                    );
                    break;
                case '6' :
                    $repartition = array(
                        0    => array(
                            'title'       => '1er',
                            'description' => '20%'
                        ), 1 => array(
                            'title'       => '2ème',
                            'description' => '12%'
                        ), 2 => array(
                            'title'       => '3ème',
                            'description' => '10%'
                        ), 3 => array(
                            'title'       => '4ème',
                            'description' => '8%'
                        ), 4 => array(
                            'title'       => '5ème au 10ème',
                            'description' => '5%'
                        ), 5 => array(
                            'title'       => '11ème au 20ème',
                            'description' => '2%'
                        )
                    );
                    break;
                case '55' :
                    $repartition = array(
                        0    => array(
                            'title'       => '1er',
                            'description' => '30%'
                        ), 1 => array(
                            'title'       => '2ème',
                            'description' => '25%'
                        ), 2 => array(
                            'title'       => '3ème',
                            'description' => '20%'
                        ), 3 => array(
                            'title'       => '4ème',
                            'description' => '15%'
                        ), 4 => array(
                            'title'       => '5ème',
                            'description' => '10%'
                        )
                    );
                    break;
                case '30' :
                    $repartition = array(
                        0    => array(
                            'title'       => '1er',
                            'description' => '15%'
                        ), 1 => array(
                            'title'       => '2ème',
                            'description' => '10%'
                        ), 2 => array(
                            'title'       => '3ème',
                            'description' => '7%'
                        ), 3 => array(
                            'title'       => '4ème au 10ème',
                            'description' => '4%'
                        ), 4 => array(
                            'title'       => '11ème au 30ème',
                            'description' => '2%'
                        )
                    );
                    break;
                default:
                    $repartition = $repartitionId;
                    break;
            }
            return $repartition;
        }

        static function getNumberOfWinnersFor($repartition_type) {
            $nb_winners = 0;
            if ($repartition_type == 4) {
                $nb_winners = 10;
            } else if ($repartition_type == 5) {
                $nb_winners = 13;
            } else if ($repartition_type == 6) {
                $nb_winners = 20;
            } else if ($repartition_type == 55) {
                $nb_winners = 5;
            } else {
                $nb_winners = $repartition_type;
            }
            return $nb_winners;
        }

        static function generateRandomPass($password_length = 10) {

            $list = "0123456789abcdefghijklmaopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            mt_srand((double)microtime()*1000000);
            $pass ="";
            while(strlen($pass) < $password_length) {
                $pass .= $list[mt_rand(0, strlen($list)-1)];
            }

            return $pass;
        }

        /**
         * Format a tweet : add links and take @ and # into account.
         *
         * @param $text
         *
         * @return mixed
         */
        static function formatTweet($text) {
            $text = preg_replace('#http://[a-z0-9._/-]+#i', '<a class="tweet-inline-link" href="$0" target="_blank" onFocus="this.blur();">$0</a>', $text);
            $text = preg_replace('#https://[a-z0-9._/-]+#i', '<a class="tweet-inline-link" href="$0" target="_blank" onFocus="this.blur();">$0</a>', $text);
            $text = preg_replace('#^@([a-z0-9_]+)#i', '<a class="tweet-name-link" href="https://twitter.com/$1" target="_blank" onFocus="this.blur();">@$1</a>', $text);
            $text = preg_replace('# \#([a-z0-9_-]+)#i', ' #<a class="tweet-name-link" href="https://search.twitter.com/search?q=%23$1" target="_blank">$1</a>', $text);
            return $text;
        }

    }

?>
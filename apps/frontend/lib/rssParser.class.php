<?php
    /**
     * RSSParser Class, parse an external RSS feed into an array
     *
     * @package  betkup.fr
     * @author   Sofun Gaming SAS
     * @version  SVN: $Id: rssParser.class.php 5843 2012-08-07 13:53:10Z jmasmejean $
     */
    class RSSParser {

        /**
         * Custom RSS parser
         *
         * Take an RSS feed URL and parse items into an array
         *
         * @param url     $url
         * @param boolean $onlyImage true if we want only feeds that containing an image (via enclosure tags)
         *
         * @return array $feed['feed'] = Array()
         */
        static function parser($url, $onlyImage = false) {

            $cacheKey = self::getIdFromUrl($url);
            $newFeed = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($newFeed)) {
                try {

                    if (self::getFeedFor($url)) {
                        $feedSource = self::getFeedFor($url);
                        $feedArray = self::objectToArray($feedSource);

                        $i = 0;
                        foreach ($feedArray as $key => $feed) {
                            if ($onlyImage) {
                                if ($key == 'channel') {
                                    foreach ($feed['item'] as $value) {
                                        if (isset($value['enclosure'])) {
                                            $newFeed['feed'][$i] = $value;
                                            $i++;
                                        }
                                    }
                                }
                            }
                            else {
                                if ($key == 'channel') {
                                    foreach ($feed['item'] as $value) {
                                        $newFeed['feed'][$i] = $value;
                                        $i++;
                                    }
                                }
                            }
                        }
                        sfMemcache::getInstance()->set($cacheKey, $newFeed);
                    }
                    else {
                        throw new Exception('error_service_unavailable');
                    }
                } catch (Exception $e) {
                    return array('error' => array('message' => $e->getMessage()));
                }
            }
            return $newFeed;
        }

        /**
         * Normalize url : remove special caracters to generate an ID.
         *
         * @param string $url
         *
         * @return string
         */
        static function getIdFromUrl($url) {

            $parsedUrl = str_replace(array('http://', 'https://', 'www.'), '', $url);
            $from = '/-:. ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
            $to = '_____aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
            $id = strtr($parsedUrl, $from, $to);

            return 'rss_feed_' . $id;
        }

        /**
         * Convert an object to an array
         *
         * @param   object  $object The object to convert
         *
         * @return  array
         */
        static function objectToArray($object) {
            if (!is_object($object) && !is_array($object)) {
                return $object;
            }
            if (is_object($object)) {
                $object = get_object_vars($object);
            }
            return array_map('self::objectToArray', $object);
        }

        /**
         * Parse an XML feed into an object using simplexml php library
         *
         * @uses simplexml PHP Library
         *
         * @param url $url
         *
         * @return object
         */
        static function getFeedFor($url) {
            $feed = '';
            try {
                if (@simplexml_load_file($url)) {
                    $feed = simplexml_load_file($url);
                }
                else {
                    throw new Exception("Simplexml error");
                }
            } catch (Exception $e) {
                return false;
            }
            return $feed;
        }
    }

?>
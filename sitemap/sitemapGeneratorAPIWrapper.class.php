<?php
    include_once(dirname(__FILE__) . '/sitemapGeneratorConstants.class.php');

    class SitemapGeneratorAPIWrapper extends SitemapGeneratorConstants {

        private static $ROOMS = array();

        private static $KUPS = array();

        private static $ROOM_KUPS = array();

        public function __construct() {

        }

        public function sofunAPIHelper() {

            $config = array(
                'consumerId'     => $this->consumerId,
                'consumerSecret' => $this->consumerSecret,
                'domain'         => $this->domain,
                'protocol'       => $this->protocol,
            );

            $sofun = new Sofun($config);
            $sofun->init();
            return $sofun;
        }

        public function getApiRooms($params) {
            if(empty(self::$ROOMS)) {

                $params['communityId'] = $this->community_id;

                $sofun = $this->sofunAPIHelper();
                try {
                    $response = $sofun->api_POST("/team/search", $params);
                } catch (SofunApiException $e) {
                    error_log($e);
                }

                if ($response["http_code"] == "202") {
                    self::$ROOMS = $response['buffer'];
                }
                else {
                    error_log($response['buffer']);
                }

            }
            return self::$ROOMS;
        }

        public function getApiRoomKups($params) {
            if(empty(self::$ROOM_KUPS)) {

                $rooms = self::$ROOMS;

                if(count($rooms) > 0) {
                    $i=0;
                    foreach($rooms as $room) {

                        $sofun = $this->sofunAPIHelper();
                        try {
                            $response = $sofun->api_GET("/team/" . $room['uuid'] . "/kups/" . $params['offset'] . "/" . $params['batchSize'] . "/get");
                        } catch (SofunApiException $e) {
                            error_log($e);
                        }

                        if ($response["http_code"] == "202") {
                            self::$ROOM_KUPS[$i] = $response['buffer'];
                            self::$ROOM_KUPS[$i]['room_uuid'] = $room['uuid'];
                            $i++;
                        }
                        else {
                            error_log($response['buffer']);
                        }
                    }
                }
            }

            return self::$ROOM_KUPS;
        }

        public function getApiKups($params) {

            if(empty(self::$KUPS)) {
                $params['communityId'] = $this->community_id;
                $params['isTemplate'] = 1;

                $sofun = $this->sofunAPIHelper();
                try {
                    $response = $sofun->api_POST("/kup/search/", $params);
                } catch (SofunApiException $e) {
                    error_log($e);
                }

                if ($response["http_code"] == "202") {
                    self::$KUPS = $response['buffer'];
                }
                else {
                    error_log($response['buffer']);
                }
            }

            return self::$KUPS;
        }

        public function getKupsUrlsFor($params) {
            $kups = $this->getApiKups($params);
            $urls = array();

            foreach ($kups['results'] as $kup) {

                $url = 'kup/' . $kup['uuid'];
                $urls[] = $this->genUrl($url) . '/view';
                $urls[] = $this->genUrl($url) . '/ranking';
                $urls[] = $this->genUrl($url) . '/rules';
            }

            return $urls;
        }

        public function getRoomKupsUrlsFor($params) {
            $roomKups = $this->getApiRoomKups($params);
            $urls = array();

            $i=0;
            foreach ($roomKups as $roomKup) {

                if(isset($params['maxRooms']) && $i == $params['maxRooms']) {
                    break;
                }
                $url = 'room/'.$roomKup['room_uuid'].'/kup/' . $roomKup['uuid'];
                $urls[] = $this->genUrl($url) . '/view';
                $urls[] = $this->genUrl($url) . '/ranking';
                $urls[] = $this->genUrl($url) . '/rules';
                $i++;
            }

            return $urls;
        }

        public function getRoomsUrlsFor($params) {
            $rooms = $this->getApiRooms($params);
            $urls = array();

            foreach ($rooms as $room) {
                $url = 'room/' . $room['uuid'];
                $urls[] = $this->genUrl($url) . '/view';
                $urls[] = $this->genUrl($url) . '/kupsNews';
                $urls[] = $this->genUrl($url) . '/roomKupsRanking';
            }

            return $urls;
        }
    }

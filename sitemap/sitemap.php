#!/usr/bin/env php
<?php
    chdir(dirname(__FILE__));
    // Include Symfony needed class.
    require_once(dirname(__FILE__) . '/../lib/vendor/symfony/lib/yaml/sfYaml.php');

    // Include sofun sdk.
    require_once(dirname(__FILE__) . '/../apps/frontend/lib/sofun-php-sdk/src/oauth/OAuth.php');
    require_once(dirname(__FILE__) . '/../apps/frontend/lib/sofun-php-sdk/src/sofun.php');
    require_once(dirname(__FILE__) . '/../apps/frontend/lib/sofun.php');

    // Include affiliate classes.
    include_once(dirname(__FILE__) . '/sitemapGeneratorConstants.class.php');
    include_once(dirname(__FILE__) . '/sitemapGeneratorAPIWrapper.class.php');

    /**
     * Sitemap generator for Betkup.
     */
    class SitemapGenerator extends SitemapGeneratorConstants {

        public static $COUNT = 0;

        private $API = NULL;

        private static $KUPS = array();

        private static $ROOMS = array();

        private static $ROOM_KUPS = array();

        private static $PROMOS = array();

        private static $SITEMAP_PATH = "/../web/sitemap.xml";

        public function __construct($useApi = '') {

            if ($useApi !== '' && is_bool($useApi)) {
                $this->useApi = $useApi;
            }
            if ($this->useApi === TRUE) {
                $this->API = new SitemapGeneratorAPIWrapper();
            }
        }

        public function setLocalPromos($PROMOS) {
            self::$PROMOS = $PROMOS;
        }

        public function getLocalPromos() {
            return self::$PROMOS;
        }

        /**
         * Get the number of lines written.
         *
         * @return int
         */
        public function getCountLines() {
            return self::$COUNT;
        }

        /**
         * @param $KUPS
         */
        public function setLocalKups($KUPS) {
            self::$KUPS = $KUPS;
        }

        /**
         * @return array
         */
        public function getLocalKups() {

            if (empty(self::$KUPS)) {
                $params = array(
                    'sports'       => 'ALL',
                    'stake'        => 'ALL',
                    'status'       => 'ALL',
                    'sort'         => 'START_DATE',
                    'offset'       => 0,
                    'batchSize'    => 1000,
                    'withRoomKups' => 0,
                );
                $kups = $this->API->getKupsUrlsFor($params);
                $this->setLocalKups($kups);
            }

            return self::$KUPS;
        }

        /**
         * @param $ROOMS
         */
        public function setLocalRooms($ROOMS) {
            self::$ROOMS = $ROOMS;
        }

        /**
         * @return array
         */
        public function getLocalRooms() {

            if (empty(self::$ROOMS)) {
                $params = array(
                    'offset'    => 0,
                    'batchSize' => 3000
                );
                $rooms = $this->API->getRoomsUrlsFor($params);
                $this->setLocalRooms($rooms);
            }

            return self::$ROOMS;
        }

        /**
         * @param $ROOM_KUPS
         */
        public function setLocalRoomKups($ROOM_KUPS) {
            self::$ROOM_KUPS = $ROOM_KUPS;
        }

        /**
         * @return array
         */
        public function getLocalRoomKups() {

            if (empty(self::$ROOM_KUPS)) {
                // TOO SLOW !!!
                $params = array(
                    'offset'    => 0,
                    'batchSize' => 10,
                    'maxRooms'  => 10
                );
                //$roomKups = $this->API->getRoomKupsUrlsFor($params);
                //$this->setLocalRoomKups($roomKups);
            }

            return self::$ROOM_KUPS;
        }

        /**
         * Create the sitemap XML file and add URL node into it.
         *
         * Override this method if you want another formatted output.
         */
        public function createSitemap() {

            $document = new DOMDocument("1.0", 'UTF-8');
            $root = $document->createElement("urlset");

            $xmlns = $document->createAttribute('xmlns');
            $xmlnsxsi = $document->createAttribute('xmlns:xsi');
            $xsi = $document->createAttribute('xsi:schemaLocation');
            $xmlns->value = $this->xmlnsValue;
            $xmlnsxsi->value = $this->xmlnsxsiValue;
            $xsi->value = $this->xsiValue;

            $root->appendChild($xmlns);
            $root->appendChild($xmlnsxsi);
            $root->appendChild($xsi);
            $document->appendChild($root);

            $staticUrls = $this->getSitemapStaticUrls();
            $kups = $this->getLocalKups();
            $rooms = $this->getLocalRooms();
            $roomKups = $this->getLocalRoomKups();

            if (!empty($staticUrls)) {
                foreach ($staticUrls as $urls) {
                    $this->addXmlUrl($document, $root, $urls['link'], $urls['priority']);
                }
            }

            if (!empty($kups)) {
                foreach ($kups as $urlKup) {
                    $this->addXmlUrl($document, $root, $urlKup, '0.7');
                }
            }

            if (!empty($rooms)) {
                foreach ($rooms as $urlRoom) {
                    $this->addXmlUrl($document, $root, $urlRoom, '0.7');
                }
            }

            if (!empty($roomKups)) {
                foreach ($roomKups as $urlRoomKup) {
                    $this->addXmlUrl($document, $root, $urlRoomKup, '0.5');
                }
            }

            $this->setPromosForSitemap();
            $promos = $this->getLocalPromos();

            if (!empty($promos)) {
                foreach ($promos as $promo) {
                    $this->addXmlUrl($document, $root, $promo['link'], $promo['priority']);
                }
            }

            $document->formatOutput = true;
            $document->preserveWhitespace = true;
            $document->save(dirname(__FILE__) . self::$SITEMAP_PATH);
        }

        /**
         * Add an url node into the XML document
         *
         * @param DOMDocument $document
         * @param DOMElement  $root
         * @param string      $url
         * @param string      $priority
         * @param string      $date
         * @param string      $frequency
         */
        private function addXmlUrl(DOMDocument $document, DOMElement $root, $link, $priority = '0.5', $date = "", $frequency = 'monthly') {

            if ($date == "") {
                $date = date('Y-m-d');
            }

            $url = $document->createElement('url');
            $root->appendChild($url);
            $loc = $document->createElement('loc', $link);
            $url->appendChild($loc);
            $lastmod = $document->createElement('lastmod', $date);
            $url->appendChild($lastmod);
            $changefreq = $document->createElement('changefreq', $frequency);
            $url->appendChild($changefreq);
            $priority = $document->createElement('priority', $priority);
            $url->appendChild($priority);

            // Increment the counter to know how many URLs has been written.
            self::$COUNT++;
        }

        /**
         * Get the title and link for promos page.
         *
         * @return array
         */
        private function setPromosForSitemap() {
            $dataBindings = array();
            $challengesList = $this->getDataFromFile('module.yml', 'config', 'all');
            foreach ($challengesList as $type => $bindings) {
                if ($type == 'promos' || $type == 'challenges') {

                    $bindingsList = explode(' ', $bindings);
                    foreach ($bindingsList as $binding) {
                        $data = $this->getDataFromFile($binding);
                        $link = explode(',', $data['link']);

                        if (isset($data['uuid'])) {
                            $dataBindings['promos'][] = array(
                                'link'     => $this->genUrl($link[0] . "/" . $link[1] . '/' . $data['uuid']),
                                'priority' => '0.5'
                            );
                        }
                    }
                }
            }
            $this->setLocalPromos($dataBindings['promos']);
        }

        /**
         * Returns the challenges or promos data given a file.
         *
         * @param string $file
         */
        private function getDataFromFile($file, $directory = 'data', $index = 'datas') {

            $module_dir = dirname(__FILE__) . "/../apps/frontend/modules";
            $module_name = 'challenge';
            $bindings = sfYaml::load($module_dir . '/' . $module_name . '/' . $directory . '/' . $file);
            $config = $bindings[$index];

            return $config;
        }
    }


    $timestart = microtime(true);

    $generator = new SitemapGenerator();

    echo "Debut du script: " . date("H:i:s", $timestart) . "\n";

    $generator->createSitemap();

    $timeend = microtime(true);
    $time = $timeend - $timestart;
    $page_load_time = number_format($time, 3);
    echo "Fin du script: " . date("H:i:s", $timeend) . "\n";
    echo $generator->getCountLines() . " lignes ??crites en " . $page_load_time . " sec" . "\n";

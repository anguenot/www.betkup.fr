<?php

    /**
     * Home actions.
     *
     * <p/>
     *
     * See config/security.yml for module security settings. All actions needs to be
     * protected unless necessary.
     *
     * <p/>
     *
     * This module does not and shall not contain any admin related actions: only
     * member related account management actions.
     *
     * @package    betkup.fr
     * @subpackage home
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: actions.class.php 6120 2012-09-12 15:09:15Z jmasmejean $
     */
    class homeActions extends betkupActions {

        /**
         * Returns the quote data given a file.
         *
         * @param string $file
         */
        private function getQuoteFromFile($file) {
            $module_dir = sfConfig::get('sf_app_module_dir');
            $module_name = 'home';
            $data = 'data/quotes';
            $config = sfYaml::load($module_dir . '/' . $module_name . '/' . $data . '/' . $file);
            return $config['quote'];
        }

        /**
         * Display the landing page optimized for google.
         *
         * @param sfWebRequest $request
         */
        public function executeLandingPage(sfWebRequest $request) {

            $partnerId = $request->getParameter('PARTNER', '');

            if ($partnerId == '75563') {
                $this->referer = 'facebook';
            }
            else {
                $this->referer = 'Ailleurs';
            }

            $this->kupsData = $this->getFrontKupsData($request);
            $this->winnersData = $this->getFrontWinners($request);

        }

        /**
         * Get domain from an URL.
         *
         * ex : http://www.the.url.com/params gives => the.url.com
         *
         * @param sfWebRequest $request
         * @param string       $url
         *
         * @return string
         */
        private function getDomainFromUrl(sfWebRequest $request, $refererUrl) {
            $newUrl = str_replace('www.', '', $refererUrl);
            $parsedUrl = parse_url($newUrl);
            $domain = '';
            if (!empty($parsedUrl["host"])) {
                $domain = $parsedUrl["host"];
            }
            else {
                $domain = $parsedUrl["path"];
            }
            if ($domain == '') {
                $domain = $request->getUriPrefix();
            }
            $domain = str_replace(array('https://', 'http://'), '', $domain);
            return $domain;
        }


        /**
         * Get the winners list to display on landing page.
         *
         * @param sfWebRequest $request
         *
         * @return array
         */
        private function getFrontWinners(sfWebRequest $request) {
            $winnersData = array();

            // XXX get data from API.
            $winnersData = array(
                0 => array(
                    'name'        => 'MPOMES',
                    'avatar'      => '/uploads/assets/1613483_avatar.png',
                    'jackpot'     => '100',
                    'stake'       => '5',
                    'sport'       => 'Football',
                    'picto_sport' => '/kup/default/picto_foot_mini.png'
                ),
                1 => array(
                    'name'        => 'Michaelopenmind',
                    'avatar'      => 'https://graph.facebook.com/100000174932251/picture?type=small',
                    'jackpot'     => '80',
                    'stake'       => '4',
                    'sport'       => 'Football',
                    'picto_sport' => '/kup/default/picto_foot_mini.png'
                ),
                2 => array(
                    'name'        => 'Lamb13',
                    'avatar'      => 'https://www.betkup.fr/uploads/assets/2713971_avatar.png',
                    'jackpot'     => '120',
                    'stake'       => '0',
                    'sport'       => 'Tennis',
                    'picto_sport' => '/kup/default/picto_tennis_mini.png'
                ),
                3 => array(
                    'name'        => 'Egriim',
                    'avatar'      => 'https://graph.facebook.com/785579700/picture?type=small',
                    'jackpot'     => '63',
                    'stake'       => '4',
                    'sport'       => 'Rugby',
                    'picto_sport' => '/kup/default/picto_rugby_mini.png'
                ),
                4 => array(
                    'name'        => 'OscarBlunt',
                    'avatar'      => '/image/default/member/avatar/default_small.png',
                    'jackpot'     => '170',
                    'stake'       => '0',
                    'sport'       => 'Cyclisme',
                    'picto_sport' => '/kup/default/picto_cycling_mini.png'
                )
            );

            return $winnersData;
        }

        /**
         * Returns the quotes to display on the home page sections.
         *
         * Quotes are defined within yml files in /home/data/quotes
         *
         * @param sfWebRequest $request
         */
        private function getQuotesData(sfWebRequest $request) {
            $cacheKey = 'home_quotes';
            $quotes = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($quotes)) {
                $quotes = array();
                $config = sfConfig::get('mod_home_quotes');
                $files = explode(" ", $config);
                $offset = 0;
                foreach ($files as $file) {
                    $quote = $this->getQuoteFromFile($file);
                    $quotes[$offset] = array(
                        'picture' => $quote['picture'],
                        'text'    => $this->getContext()->getI18n()->__($quote['text']),
                        'author'  => $this->getContext()->getI18n()->__($quote['author']),
                    );
                    $offset += 1;
                }
                if (!empty($quotes)) {
                    sfMemcache::getInstance()->set($cacheKey, $quotes, 0, 0);
                }
            }
            return $quotes;
        }

        /**
         * Returns the name of the rooms to display in the front rooms section on home page.
         */
        private function getFrontRoomNames() {
            $config = sfConfig::get('mod_home_rooms_front');
            $names = explode(",", $config);
            return $names;
        }

        /**
         * Order the front Rooms.
         */
        private function sortFrontRooms($rooms) {
            $ordered = array();
            $names = $this->getFrontRoomNames();
            $offset = 0;
            $iteration = 0;
            while ((count($ordered) < count($rooms)) && $iteration <= count($rooms)) {
                foreach ($names as $name) {
                    foreach ($rooms as $room) {
                        if ($room['name'] == $name) {
                            $ordered[$offset] = $room;
                            $offset += 1;
                            break;
                        }
                    }
                }
                $iteration++;
            }
            if (count($ordered) < count($rooms)) {
                $ordered = $rooms;
            }
            return $ordered;
        }

        /**
         * Returns front rooms data to display on home page.
         *
         * @param sfWebRequest $request
         */
        private function getFrontRoomsData(sfWebRequest $request) {
            $cacheKey = 'home_rooms_front';
            $sorted = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($sorted)) {
                $params = array(
                    'name'      => implode(",", $this->getFrontRoomNames()),
                    'offset'    => 0,
                    'batchSize' => 6,
                );
                $rooms = $this->getRoomsData($request, $params);
                $sorted = $this->sortFrontRooms($rooms);
                if (!empty($sorted)) {
                    sfMemcache::getInstance()->set($cacheKey, $sorted, 0, 86400);
                }
            }
            return $sorted;
        }

        /**
         * Returns front kups data to display on home page.
         *
         * <p>
         *
         * We will fetch the 6 Kups sorted by start_date ASC
         *
         * @param sfWebRequest $request
         */
        private function getFrontKupsData(sfWebRequest $request) {
            $cacheKey = 'home_kups_front';
            $kups = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($kups)) {
                $params = array(
                    'offset'    => 0,
                    'batchSize' => 6,
                    'status'    => 'ALL_OPENED',
                );
                $kups = $this->getKupsData($request, $params);
                if (!empty($kups)) {
                    sfMemcache::getInstance()->set($cacheKey, $kups, 0, 86400);
                }
            }
            return $kups;
        }

        /**
         * Returns the front feed data to display on home page.
         *
         * This method is public since we will need to call it in AJAX for batch implementation.
         *
         * @param sfWebRequest $request
         * @param int          $start
         * @param int          $batch_size
         * @param str          $kup_name
         */
        private function getFrontFeedData($request, $start = 0, $batch_size = 10, $kup_name = '') {
            // TODO filter by Kup and cache
            $feed = $this->getCommunityFeed($request, $start, $batch_size);
            return $this->getFeedData($request, $feed);
        }

        /**
         * Returns the front ranking data to display on home page.
         *
         * This method is public since we will need to call it in AJAX for batch implementation.
         *
         * @param sfWebRequest $request
         * @param int          $start
         * @param int          $batch_size
         * @param str          $kup_name
         */
        private function getFrontRankingData($request, $start = 0, $batch_size = 10, $kup_name = '') {
            // TODO filter by Kup and cache
            $ranking = $this->getCommunityRanking($request, $start, $batch_size);
            return $this->getRankingData($request, $ranking);
        }

        /**
         * Renders Betkup.fr home for anonymous user.
         *
         * @param sfWebRequest $request
         */
        public function executeIndex(sfWebRequest $request) {

            // Get front rooms data
            $this->roomsData = $this->getFrontRoomsData($request);

            // Get front kups data
            $this->kupsData = $this->getFrontKupsData($request);

            // Get betkup activity feed data.
            // We fetch the beginning of the list w/ default batch size.
            //$this->feedData = $this->getFrontFeedData($request, 0, sfConfig::get('mod_home_feed_batch_size'));
            $this->feedData = array();

            // Get betkup community ranking data
            // We fetch the beginning of the list w/ default batch size.
            //$this->rankingData = $this->getFrontRankingData($request, 0, sfConfig::get('mod_home_ranking_batch_size'));
            $this->rankingData = array();

            // Get home quotes data
            $this->quotesData = $this->getQuotesData($request);

        }

        /**
         * Display "how to" page.
         *
         * @param sfWebRequest $request
         */
        public function executeHowto(sfWebRequest $request) {
        }

        /**
         * Display "Bet in trust" page.
         *
         * @param sfWebRequest $request
         */
        public function executeBetTrust(sfWebRequest $request) {
            $this->culture = $this->getUser()->getCulture();
        }

        /**
         * Display the FAQ page
         *
         * @param sfWebRequest $request
         */
        public function executeFaq(sfWebRequest $request) {
        }

        /**
         * Display the FAQ account part.
         *
         * @param sfWebRequest $request
         */
        public function executeFaqAccount(sfWebRequest $request) {
        }

        /**
         * Display the FAQ kup room part.
         *
         * @param sfWebRequest $request
         */
        public function executeFaqKupRoom(sfWebRequest $request) {
        }

        /**
         * Display the FAQ payment part.
         *
         * @param sfWebRequest $request
         */
        public function executeFaqPaymen(sfWebRequest $request) {

        }

        /**
         * Display the FAQ predictions part.
         *
         * @param sfWebRequest $request
         */
        public function executeFaqPredictions(sfWebRequest $request) {
        }

        /**
         * Display the FAQ register part.
         *
         * @param sfWebRequest $request
         */
        public function executeFaqRegister(sfWebRequest $request) {
        }

        /**
         * Sitemap action.
         *
         * Generate the site map for Betkup web site.
         *
         *
         * @param sfWebRequest $request
         */
        public function executeSitemap(sfWebRequest $request) {

            $cacheKey = 'betkup_sitemap_data';
            $this->sitemapData = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($this->sitemapData)) {
                // Search open and in-comming Kups by sports.
                $kupsData = $this->getKupsForSitemapBySports($request);

                // Search promos and challenges
                $promosChallengesData = $this->getPromosChallengesForSitemap($request);

                // Get static urls
                $staticUrl = $this->getSitemapStaticUrls($request);

                $this->sitemapData = array_merge($staticUrl, $kupsData, $promosChallengesData);

                if (!empty($this->sitemapData)) {
                    // 15 days in cache
                    sfMemcache::getInstance()->set($cacheKey, $this->sitemapData, 0, 1296000);
                }
                // Update the sitemap.xml file.
                $this->updateSitemapXmlFile($this->sitemapData);
            }
        }

        /**
         * Function used to update the sitemap XML file.
         *
         * @param $data
         */
        private function updateSitemapXmlFile($data) {
            $directory = sfConfig::get('sf_web_dir');
            $filename = 'sitemap.xml';

            $file = fopen($directory . '/' . $filename, 'w');
            if ($file) {
                fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>');
                fwrite($file, "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
                foreach ($data as $bindings) {
                    foreach ($bindings as $entities) {
                        foreach ($entities as $binding) {
                            fwrite($file, "\n\t" . '<url>');
                            fwrite($file, "\n\t\t" . '<loc>');
                            fwrite($file, $binding['link']);
                            fwrite($file, '</loc>');
                            fwrite($file, "\n\t\t" . '<lastmod>');
                            fwrite($file, date('Y-m-d'));
                            fwrite($file, '</lastmod>');
                            fwrite($file, "\n\t\t" . '<changefreq>');
                            fwrite($file, 'monthly');
                            fwrite($file, '</changefreq>');
                            fwrite($file, "\n\t\t" . '<priority>');
                            fwrite($file, $binding['priority']);
                            fwrite($file, '</priority>');
                            fwrite($file, "\n\t" . '</url>');
                        }
                    }
                }
                fwrite($file, "\n" . '</urlset>');
                fclose($file);
            }

        }

        /**
         * Get the static URLs to create sitemap for Betkup.
         *
         * @param sfWebRequest $request
         *
         * @return array
         */
        private function getSitemapStaticUrls(sfWebRequest $request) {
            $urls = array(
                'static' => array(
                    0 => array(
                        array(
                            'title'    => $this->getContext()->getI18N()->__('text_sitemap_static_url_home'),
                            'link'     => 'https://www.betkup.fr/',
                            'priority' => '0.5'
                        ),
                        array(
                            'title'    => $this->getContext()->getI18N()->__('text_sitemap_static_url_kups'),
                            'link'     => 'https://www.betkup.fr/kup',
                            'priority' => '1.0'
                        ),
                        array(
                            'title'    => $this->getContext()->getI18N()->__('text_sitemap_static_url_rooms'),
                            'link'     => 'https://www.betkup.fr/room',
                            'priority' => '0.9'
                        ),
                        array(
                            'title'    => $this->getContext()->getI18N()->__('text_sitemap_static_url_howto'),
                            'link'     => 'https://www.betkup.fr/home/howto',
                            'priority' => '0.8'
                        ),
                        array(
                            'title'    => $this->getContext()->getI18N()->__('text_sitemap_static_url_challenges'),
                            'link'     => 'https://www.betkup.fr/challenge',
                            'priority' => '0.7'
                        ),
                        array(
                            'title'    => $this->getContext()->getI18N()->__('text_sitemap_static_url_bettrust'),
                            'link'     => 'https://www.betkup.fr/home/betTrust',
                            'priority' => '0.6'
                        ),
                        array(
                            'title'    => $this->getContext()->getI18N()->__('text_sitemap_static_url_register'),
                            'link'     => 'https://www.betkup.fr/register',
                            'priority' => '0.6'
                        ),
                        array(
                            'title'    => $this->getContext()->getI18N()->__('text_sitemap_static_url_registerAdvanced'),
                            'link'     => 'https://www.betkup.fr/registerAdvanced',
                            'priority' => '0.5'
                        ),
                        array(
                            'title'    => $this->getContext()->getI18N()->__('text_sitemap_static_url_faq'),
                            'link'     => 'https://www.betkup.fr/home/faq',
                            'priority' => '0.5'
                        )
                    )
                )
            );

            return $urls;
        }

        /**
         * Get the title and link for promos/challenges page.
         *
         * @param sfWebRequest $request
         *
         * @return array
         */
        private function getPromosChallengesForSitemap(sfWebRequest $request) {
            $dataBindings = array();
            $challengesList = $this->getDataFromFile('module.yml', 'config', 'all');
            foreach ($challengesList as $type => $bindings) {
                if ($type == 'promos' || $type == 'challenges') {

                    $bindingsList = explode(' ', $bindings);
                    foreach ($bindingsList as $binding) {
                        $data = $this->getDataFromFile($binding);
                        $link = explode(',', $data['link']);

                        if (isset($data['uuid'])) {
                            $dataBindings['other']['promos'][] = array(
                                'title'    => $data['title'],
                                'link'     => $request->getUriPrefix() . $this->getController()->genUrl(array(
                                                                                                             'module'  => $link[0],
                                                                                                             'action'  => $link[1],
                                                                                                             'uuid'    => $data['uuid']
                                                                                                        )),
                                'priority' => '0.5'
                            );
                        }
                        else if (isset($data['room_name'])) {
                            $challengeData = $this->getRoomByName($request, $data['room_name']);
                            $dataBindings['other']['challenges'][] = array(
                                'title'    => $challengeData['name'],
                                'link'     => $request->getUriPrefix() . $this->getController()->genUrl(array(
                                                                                                             'module'  => $link[0],
                                                                                                             'action'  => $link[1],
                                                                                                             'uuid'    => $challengeData['uuid']
                                                                                                        )),
                                'priority' => '0.5'
                            );
                        }

                    }
                }
            }
            return $dataBindings;
        }

        /**
         * Get kups by sports used to generate dynamic sitemap.
         *
         * @param sfWebRequest $request
         *
         * @return array
         */
        private function getKupsForSitemapBySports(sfWebRequest $request) {
            $offset = 0;
            $batchSize = 20;
            $withRoomKups = 0;

            // Default search values
            $stake = sfConfig::get('app_params_type_stake_all');
            $status = 'ALL_OPENED';
            $sorting = sfConfig::get('app_params_type_sorting_start_date');

            $sports = array();
            // Sport soccer
            $sports[0] = sfConfig::get('app_params_type_sports_soccer');

            // Sport tennis
            $sports[1] = sfConfig::get('app_params_type_sports_tennis');

            // Sport rugby
            $sports[2] = sfConfig::get('app_params_type_sports_rugby');

            // Sport f1
            $sports[3] = sfConfig::get('app_params_type_sports_f1');

            $kupsData = array();
            foreach ($sports as $sport) {
                $params = array(
                    'sports'       => $sport,
                    'stake'        => $stake,
                    'status'       => $status,
                    'sort'         => $sorting,
                    'offset'       => $offset,
                    'batchSize'    => $batchSize,
                    'withRoomKups' => $withRoomKups
                );

                $results = $this->getKupsData($request, $params, true);
                $kups = $results['results'];
                foreach ($kups as $kup) {
                    $kupsData['sports'][$sport][] = array(
                        'title'    => $kup['name'],
                        'link'     => $request->getUriPrefix() . $this->getController()->genUrl(array(
                                                                                                     'module'  => 'kup',
                                                                                                     'action'  => 'view',
                                                                                                     'uuid'    => $kup['uuid']
                                                                                                )),
                        'priority' => '0.5'
                    );
                }
            }

            return $kupsData;
        }

        /**
         * Returns the challenges or promos data given a file.
         *
         * @param string $file
         */
        private function getDataFromFile($file, $directory = 'data', $index = 'datas') {

            $cacheKey = str_replace('.yml', '', $file) . '_' . $directory . '_' . $index;
            $config = sfMemcache::getInstance()->get($cacheKey, array());
            if(empty($config)) {
                $module_dir = sfConfig::get('sf_app_module_dir');
                $module_name = 'challenge';
                $bindings = sfYaml::load($module_dir . '/' . $module_name . '/' . $directory . '/' . $file);
                $config = $bindings[$index];
                sfMemcache::getInstance()->set($cacheKey, $config, 0, 0);
            }
            return $config;
        }

    }

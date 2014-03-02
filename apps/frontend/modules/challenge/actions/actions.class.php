<?php

    /**
     * challenge actions.
     *
     * @package    betkup.fr
     * @subpackage challenge
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: actions.class.php 6420 2012-11-06 12:48:58Z jmasmejean $
     */
    class challengeActions extends betkupActions {

        /**
         * Executes home action
         *
         * @param sfRequest $request A request object
         */
        public function executeHome(sfWebRequest $request) {
            $this->dataEvents = $this->getData($request, 'events', false);
            $this->dataPromos = $this->getData($request, 'promos', false);
            $this->dataKups = $this->getData($request, 'kups', false);
            $this->dataChallenges = $this->getData($request, 'challenges', false);
        }

        /**
         * Executes promos action
         *
         * @param sfRequest $request A request object
         */
        public function executePromos(sfWebRequest $request) {
            $this->uuid = $request->getParameter('uuid', '');
            $this->promos = $this->getPromosById($request, $this->uuid, true);
            $this->setComponentAction($this->promos['component_route']);
        }

        /**
         * Returns the challenges or promos / kups data given a file and a type.
         *
         * @param string $file
         */
        private function getDataFromFile($file) {
            $module_dir = sfConfig::get('sf_app_module_dir');
            $module_name = 'challenge';
            $data = 'data';
            $config = sfYaml::load($module_dir . '/' . $module_name . '/' . $data . '/' . $file);
            return $config['datas'];
        }

        /**
         * Returns the kups and promos to display on the challenge page sections.
         *
         * Kups are defined within yml files in /home/data
         *
         * @param sfWebRequest $request
         * @param string       $type
         * @param boolean      $with_archive
         */
        private function getData(sfWebRequest $request, $type, $with_archive = true) {
            if ($type == 'challenges') {
                $cacheKey = $with_archive ? 'challenge_challenges_archive' : 'challenge_challenges';
                $challenges = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($challenges)) {
                    $config = sfConfig::get('mod_challenge_challenges');
                    $challenges = $this->getDataFor($request, $config, $type, $with_archive);
                    if (!empty($challenges)) {
                        sfMemcache::getInstance()->set($cacheKey, $challenges, 0, 0);
                    }
                }
                return $challenges;
            }
            else if ($type == 'promos') {
                $cacheKey = $with_archive ? 'challenge_promos_archive' : 'challenge_promos';
                $promos = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($promos)) {
                    $config = sfConfig::get('mod_challenge_promos');
                    $promos = $this->getDataFor($request, $config, $type, $with_archive);
                    if (!empty($promos)) {
                        sfMemcache::getInstance()->set($cacheKey, $promos, 0, 0);
                    }
                }
                return $promos;
            }
            else if ($type == 'kups') {
                $cacheKey = $with_archive ? 'challenge_kups_archive' : 'challenge_kups';
                $kups = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($kups)) {
                    $config = sfConfig::get('mod_challenge_kups');
                    $kups = $this->getDataFor($request, $config, $type, $with_archive);
                    if (!empty($kups)) {
                        sfMemcache::getInstance()->set($cacheKey, $kups, 0, 0);
                    }
                }
                return $kups;
            }
            else if ($type == 'events') {
                $cacheKey = $with_archive ? 'challenge_events_archive' : 'challenge_events';
                $events = sfMemcache::getInstance()->get($cacheKey, array());
                if (empty($events)) {
                    $config = sfConfig::get('mod_challenge_events');
                    $events = $this->getDataFor($request, $config, $type, $with_archive);
                    if (!empty($events)) {
                        sfMemcache::getInstance()->set($cacheKey, $events, 0, 0);
                    }
                }
                return $events;
            }
            else {
                return NULL;
            }
        }

        /**
         * Get data from yml depending on files and type.
         *
         * @param sfWebRequest $request
         * @param              $config
         * @param              $type
         * @param bool         $with_archive
         *
         * @return array
         */
        private function getDataFor(sfWebRequest $request, $config, $type, $with_archive = true) {
            $all_data = array();
            $files = explode(" ", $config);
            if (!empty($files) && $files[0] != '') {
                $offset = 0;
                foreach ($files as $file) {
                    $data = $this->getDataFromFile($file);
                    $linkOptions = array();

                    // Avoid archive data.
                    if (!$with_archive) {
                        if (isset($data['isArchive']) && $data['isArchive'] == 1) {
                            continue;
                        }
                    }

                    if (isset($data['uuid'])) {
                        $linkOptions = array('uuid' => $data['uuid']);
                    }
                    if ($type == 'challenges' && isset($data['room_name'])) {
                        $room = $this->getRoomByName($request, $data['room_name']);
                        if (isset($room['uuid'])) {
                            $linkOptions = array('uuid' => $room['uuid']);
                        }
                        else {
                            $linkOptions = array();
                        }
                    }
                    if (isset($data['kups_search_params'])) {
                        $linkOptions = array('selectedDatas' => $data['kups_search_params']);
                    }
                    $all_data[$offset] = array(
                        'uuid'            => isset($data['uuid']) ? $data['uuid'] : '',
                        'component_route' => isset($data['component_route']) ? $data['component_route'] : '',
                        'type'            => $data['type'],
                        'title'           => $data['title'],
                        'avatar'          => $data['avatar'],
                        'link'            => $this->getLinkFor($data['link'], $linkOptions),
                        'link_label'      => $data['link_label'],
                        'arguments'       => $data['arguments']
                    );
                    $offset++;
                }
            }
            return $all_data;
        }

        /**
         * Get formated link given module/action and options.
         *
         * @param array $link (array containing module/action)
         * @param array $options
         *
         * @return mixed
         */
        private function getLinkFor($link, $options = array()) {
            $explodedLink = explode(',', $link);
            $route = array('module' => $explodedLink[0], 'action' => $explodedLink[1]);
            $uri = array_merge($route, $options);
            $sfLink = $this->getController()->genUrl($uri);
            return $sfLink;
        }

        /**
         * Get the promo ID from file.
         *
         * @param sfWebRequest $request
         * @param string       $uuid
         *
         * @return string
         */
        private function getPromosById(sfWebRequest $request, $uuid, $with_archive = true) {
            $cacheKey = $with_archive ? 'challenge_promo_data_by_id_for_' . $uuid . '_archive' : 'challenge_promo_data_by_id_for_' . $uuid;
            $promo = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($promo)) {
                $data = $this->getData($request, 'promos', $with_archive);
                foreach ($data as $promos) {
                    if (isset($promos['uuid']) && $promos['uuid'] == $uuid) {
                        $promo = $promos;
                        if (!empty($promo)) {
                            sfMemcache::getInstance()->set($cacheKey, $promo, 0, 0);
                        }
                    }
                }
            }
            return $promo;
        }

        private function setComponentAction($componentRoute) {
            $route = explode(',', $componentRoute);
            $this->componentModule = $route[0];
            $this->componentName = $route[1];
        }

    }

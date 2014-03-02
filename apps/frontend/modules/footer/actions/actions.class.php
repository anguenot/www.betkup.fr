<?php

    /**
     * Footer actions.
     *
     * @package    betkup.fr
     * @subpackage footer
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: actions.class.php 6544 2012-11-22 17:11:24Z jmasmejean $
     */
    class footerActions extends betkupActions {

        /**
         * Display list of tweets on footer.
         *
         * @param sfWebRequest $request
         */
        public function executeThumbnailTweets(sfWebRequest $request) {
            $this->tweets = $this->getTweetsUI($this->getApiTweets($request));
        }

        /**
         * Get the last tweets from twitter API for an Ajax call.
         *
         * @param sfWebRequest $request
         */
        public function executeGetLastApiTweets(sfWebRequest $request) {
            if ($request->isXmlHttpRequest()) {
                $forced = $request->getParameter('forced', false);

                $tweets = $this->getApiTweets($request);

                $lastTweet = '';
                if (isset($tweets[0]) && isset($tweets[0]['text'])) {
                    $lastTweet = md5($tweets[0]['text']);
                }

                if ($forced || $this->isLastTweet($lastTweet)) {
                    return $this->renderText(json_encode($this->getTweetsUI($tweets)));
                }
                else {
                    // If there is no new tweet, we return a code 400.
                    return $this->renderText(json_encode(array('code' => '400')));
                }
            }
            return sfView::NONE;
        }

        /**
         * Check if there is a on date tweet to display notification.
         *
         * @return bool
         */
        private function isLastTweet() {
            $cacheKey = "twitter_previous_last_tweet";
            $previousLastTweet = sfMemcache::getInstance()->get($cacheKey, '');
            $currentLastTweet = $this->getCurrentLastTweet();

            if ($previousLastTweet == '') {
                sfMemcache::getInstance()->set($cacheKey, $currentLastTweet, 0, 0);
                $previousLastTweet = $currentLastTweet;
            }

            $return = false;
            if ($previousLastTweet != $currentLastTweet) {
                sfMemcache::getInstance()->set($cacheKey, $currentLastTweet, 0, 0);
                $return = true;
            }

            return $return;
        }

        /**
         * Put the current last tweet hash in cache
         *
         * @param $tweetHash
         */
        private function setCurrentLastTweet($tweetHash) {
            $cacheKey = "twitter_current_last_tweet";
            sfMemcache::getInstance()->set($cacheKey, $tweetHash, 0, 0);
        }

        /**
         * Retrieve the last tweet from cache.
         *
         * @return string
         */
        private function getCurrentLastTweet() {
            $cacheKey = "twitter_current_last_tweet";
            $tweetHash = sfMemcache::getInstance()->get($cacheKey, '');
            return $tweetHash;
        }

        /**
         * Format a tweet and add link.
         *
         * Customize date display, screen name display and text
         *
         * @param $tweets
         *
         * @return mixed
         */
        private function getTweetsUI($tweets) {

            /*
             * Format a tweet to take links, @ and # into account.
             *
             * @param $item
             * @param $key
             */
            function formatTweet(&$item, $key) {
                if (isset($item['text'])) {
                    $item['text'] = Util::formatTweet($item['text']);
                }
                if (isset($item['user']) && isset($item['user']['screen_name'])) {
                    $item['user']['screen_name'] = Util::formatTweet('@' . $item['user']['screen_name']);
                }
                if (isset($item['created_at'])) {
                    $item['created_at'] = date('d/m/Y H\hi', strtotime($item['created_at']));
                }
            }

            if(is_array($tweets) && count($tweets) > 0) {
                array_walk($tweets, 'formatTweet');
            }

            return $tweets;
        }

        /**
         * Get the last tweets from twitter API or from cache.
         *
         * @param sfWebRequest $request
         *
         * @return array|mixed|string
         */
        private function getApiTweets(sfWebRequest $request) {
            $useCachedResults = $request->getParameter('use_cached_results', '1');

            $cacheKey = 'twitter_last_tweets';
            $tweets = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($tweets) || !$useCachedResults) {

                $params = array(
                    'count' => sfConfig::get('mod_footer_twitter_count')
                );
                $oauthTwitterConnector = $this->getTwitterOAuthConnector();
                $tweets = RSSParser::objectToArray($oauthTwitterConnector->get("statuses/user_timeline", $params));

                if (!empty($tweets)) {
                    sfMemcache::getInstance()->set($cacheKey, $tweets, 0, 7); // 7s cache

                    $lastTweet = '';
                    if (isset($tweets[0]) && isset($tweets[0]['text'])) {
                        $lastTweet = md5($tweets[0]['text']);
                    }
                    $currentLastTweet = $this->getCurrentLastTweet();

                    if ($lastTweet != $currentLastTweet) {
                        $this->setCurrentLastTweet($lastTweet);
                    }
                }
            }

            return $tweets;
        }

        /**
         * Get the TwitterOAuth connector to deal with Twitter API.
         *
         * @return TwitterOAuth object
         */
        private function getTwitterOAuthConnector() {

            $consumer_key = sfConfig::get('mod_footer_twitter_oauth_consumer_key');
            $consumer_secret = sfConfig::get('mod_footer_twitter_oauth_consumer_secret');
            $oauth_token = sfConfig::get('mod_footer_twitter_oauth_access_token');
            $oauth_token_secret = sfConfig::get('mod_footer_twitter_oauth_token_secret');

            $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

            return $connection;
        }

    }

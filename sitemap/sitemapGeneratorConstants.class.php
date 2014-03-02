<?php
    class SitemapGeneratorConstants {

        // General constants.
        protected $useApi = true;
        protected $urlPrefix = "https://dev.betkup.fr";

        // API constants.
        protected $consumerId = 'cac383dba35fb6f7eef12ba8cee504c6';
        protected $consumerSecret = '4a85d20e5cbad626a494f75d233cd688';
        protected $domain = "beta.staging.api.sofungaming.com";
        protected $protocol = "http://";
        protected $community_id = 1;

        // Sitemap generator constants.
        protected $xmlnsValue = "http://www.sitemaps.org/schemas/sitemap/0.9";
        protected $xmlnsxsiValue = "http://www.w3.org/2001/XMLSchema-instance";
        protected $xsiValue = "http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd";

        /**
         * Concatenate the url prefix with the given url parameter.
         *
         * @param $url
         *
         * @return string
         */
        protected function genUrl($url) {
            $prefix = $this->urlPrefix;
            return $prefix . '/' . $url;
        }

        /**
         * Get the static URLs to create sitemap for Betkup.
         *
         * @return array
         */
        protected function getSitemapStaticUrls() {
            $urls = array(
                array(
                    'link'     => $this->urlPrefix,
                    'priority' => '0.5'
                ),
                array(
                    'link'     => $this->urlPrefix.'/kup',
                    'priority' => '1.0'
                ),
                array(
                    'link'     => $this->urlPrefix.'/room',
                    'priority' => '0.9'
                ),
                array(
                    'link'     => $this->urlPrefix.'/home/howto',
                    'priority' => '0.8'
                ),
                array(
                    'link'     => $this->urlPrefix.'/challenge',
                    'priority' => '0.7'
                ),
                array(
                    'link'     => $this->urlPrefix.'/home/betTrust',
                    'priority' => '0.6'
                ),
                array(
                    'link'     => $this->urlPrefix.'/register',
                    'priority' => '0.6'
                ),
                array(
                    'link'     => $this->urlPrefix.'/registerAdvanced',
                    'priority' => '0.5'
                ),
                array(
                    'link'     => $this->urlPrefix.'/home/faq',
                    'priority' => '0.5'
                )
            );

            return $urls;
        }
    }

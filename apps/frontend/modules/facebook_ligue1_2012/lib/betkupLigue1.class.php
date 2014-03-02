<?php
    /**
     * Created by JetBrains PhpStorm.
     * User: jonathanmasmejean
     * Date: 06/08/12
     * Time: 14:29
     * To change this template use File | Settings | File Templates.
     */
    class BetkupLigue1 extends betkupActions {

        /**
         * Get the clubs bindings for facebook ligue 1 app.
         *
         * @return array
         */
        static function getLigue1ClubsBindings() {
            $cacheKey = 'clubs_config_facebook_l1_bindings';
            $clubBindings = sfMemcache::getInstance()->get($cacheKey, array());
            if (empty($clubBindings)) {
                $module_dir = sfConfig::get('sf_app_module_dir');
                $module_name = 'facebook_ligue1_2012';
                $data = 'data';
                $file = 'clubs.yml';
                $config = sfYaml::load($module_dir . '/' . $module_name . '/' . $data . '/' . $file);
                $clubBindings = $config['clubs'];
                if (!empty($clubBindings)) {
                    sfMemcache::getInstance()->set($cacheKey, $clubBindings, 0, 0);
                }
            }
            return $clubBindings;
        }

        /**
         * Test if the user have all facebook permissions (scope) needed.
         *
         * @param $scope
         * @param $facebookPermissions
         *
         * @return bool
         */
        static function appFacebookPermissionsMatch($scope, $facebookPermissions) {
            $appPermissions = explode(',', $scope);

            foreach ($appPermissions as $permission) {
                if (array_key_exists($permission, $facebookPermissions) && $facebookPermissions[$permission] == 1) {
                    continue;
                }
                else {
                    return false;
                }
            }
            return true;
        }

        /**
         * Decode a base64 url
         *
         * @param $input
         *
         * @return string
         */
        static function base64_url_decode($input) {
            return base64_decode(strtr($input, '-_', '+/'));
        }

        /**
         * Parse the facebook signed request to an object
         *
         * @param $signed_request
         * @param $secret
         *
         * @return mixed|null
         */
        static function parse_signed_request($signed_request, $secret) {
            list($encoded_sig, $payload) = explode('.', $signed_request, 2);
            // decode the data
            $sig = BetkupLigue1::base64_url_decode($encoded_sig);
            $data = json_decode(BetkupLigue1::base64_url_decode($payload), true);

            if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
                error_log('Unknown algorithm. Expected HMAC-SHA256');
                return null;
            }
            // check sig
            $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
            if ($sig !== $expected_sig) {
                error_log('Bad Signed JSON signature!');
                return null;
            }
            return $data;
        }
    }

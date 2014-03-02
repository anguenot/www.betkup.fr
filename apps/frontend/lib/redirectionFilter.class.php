<?php

    /**
     * Filter implementing a redirect mecanism in use throughout the application.
     *
     * @package    betkup.fr
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: redirectionFilter.class.php 3037 2011-09-30 10:08:52Z anguenot $
     */
    class RedirectionFilter extends sfFilter {

        private static $LOG_KEY = "RedirectionFilter : ";
        private static $flashMessage = "";

        public function execute($filterChain) {

            $context = $this->getContext();
            $request = $context->getRequest();
            $module = $context->getModuleName();
            $action = $context->getActionName();
            $user = $context->getUser();
            $referer = '';

            // Execute this filter only on login page.
            if ($module == sfConfig::get('sf_secure_module') && $action == sfConfig::get('sf_secure_action')) {

                // Add possibility to set custom parameter to use for redirectUrl by retrieving request attribute/parameter.
                $defaultUrl = $request->getAttribute('customRedirectUrl', '');
                $customRedirect = $request->getParameter('customRedirectUrl', $defaultUrl);
                if ($customRedirect != '') {
                    $referer = $customRedirect;
                    $context->getLogger()->debug(RedirectionFilter::$LOG_KEY . "Set custom redirect url : " . $referer);
                }

                // If it have been forwarded and referer is null.
                $is_forward = $context->getController()->getActionStack()->getSize() > 1 ? true : false;
                if ($referer == '' && $is_forward) {

                    // if we have been forwarded, then the referer is the current URL.
                    $referer = $request->getUri();
                    // If referer is still null, we set it with default redirection value from app.yml
                    if ($referer == '') {
                        $referer = $this->getDefaultReferer($request);
                    }

                    // Add custom security for private Room.
                    $this->customRoomSecurityFor($request);
                }
            }

            if ($referer != '') {
                // We save the referer.
                $context->getLogger()->debug(RedirectionFilter::$LOG_KEY . "Save referer url : " . $referer);
                $user->setAttribute('referer', $referer, sfConfig::get('app_redirection_filter_namespace_name'));
            }

            if (RedirectionFilter::$flashMessage != '') {
                $this->getContext()->getUser()->setFlash('error', RedirectionFilter::$flashMessage);
            }

            $filterChain->execute();

        }

        /**
         * Return the default URL from app.yml config file.
         *
         * @param $request
         *
         * @return string
         */
        private function getDefaultReferer($request) {
            $route = $this->getContext()->getController()->genUrl(sfConfig::get('app_redirection_filter_success_login'));
            $prefix = $this->getCustomUriPrefix($request);

            return $prefix . $route;
        }

        /**
         * Format all uriPrefix to https if app is Secure
         *
         * @param sfWebRequest $request
         */
        private function getCustomUriPrefix($request) {
            if (sfConfig::get('app_is_secure_ssl') == true) {
                return str_replace('http:', 'https:', $request->getUriPrefix());
            }
            else {
                return $request->getUriPrefix();
            }
        }

        /**
         * Redirect to the room home page if user has no credentials / is not connected
         *
         * @param sfWebRequest $request
         */
        private function customRoomSecurityFor($request) {

            $context = $this->getContext();
            $module = $context->getModuleName();
            $action = $context->getActionName();
            $requestModuleAction = $module . '/' . $action;

            RedirectionFilter::$flashMessage = $context->getUser()->getFlash('error', '');

            // Add a custom security when the user attempt to watch a private room kup view
            // when not connected hasn't the credentials needed, we force redirect to the current room kup view.
            if ($requestModuleAction == 'room/kup' || $requestModuleAction == 'room/kupRanking') {
                $credentials = array(
                    array(
                        'room_member', 'room_public_anonymous', 'room_public_connected'
                    )
                );
                $hasCredentials = $context->getUser()->hasCredential($credentials);

                if (!$hasCredentials) {
                    $context->getController()->redirect($context->getController()->genUrl(array(
                                                                                               'module' => 'room',
                                                                                               'action' => 'view',
                                                                                               'uuid'   => $request->getParameter('room_uuid')
                                                                                          )));
                }
            }
        }
    }

?>
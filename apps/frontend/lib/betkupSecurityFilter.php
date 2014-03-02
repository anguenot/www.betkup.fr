<?php
    /**
     * Betkup Security Filter.
     *
     * @package    betkup.fr
     * @subpackage lib
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: betkupSecurityFilter.class.php 2803 2011-09-09 22:57:20Z jmasmejean $
     */
    class betkupSecurityFilter extends sfBasicSecurityFilter {

        /**
         * Executes this filter.
         *
         * Override the Symfony execute function (revision 23810).
         *
         * @param sfFilterChain $filterChain A sfFilterChain instance
         */
        public function execute($filterChain) {

            // disable security on login and secure actions
            if ((sfConfig::get('sf_login_module') == $this->context->getModuleName()) && (sfConfig::get('sf_login_action') == $this->context->getActionName())
                || (sfConfig::get('sf_secure_module') == $this->context->getModuleName()) && (sfConfig::get('sf_secure_action') == $this->context->getActionName())
            ) {
                $filterChain->execute();
                return;
            }

            /*
             * Override => Take the credentials into account even if the user is not connected.
             *
             * from revision 23810 (symfony).
             */
            //////////////////////////////////////////////////////////////////////////////////////////////////////////
            $credential = $this->getUserCredential();

            if (!$this->context->getUser()->isAuthenticated()
                && (null !== $credential && !$this->context->getUser()->hasCredential($credential))
            ) {
                if (sfConfig::get('sf_logging_enabled')) {
                    $this->context->getEventDispatcher()->notify(new sfEvent($this, 'application.log', array(sprintf('Action "%s/%s" requires authentication, forwarding to "%s/%s"', $this->context->getModuleName(), $this->context->getActionName(), sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action')))));
                }

                // the user is not authenticated and don't have necessary credentials.
                $this->forwardToLoginAction();
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////

            if (null !== $credential && !$this->context->getUser()->hasCredential($credential)) {
                if (sfConfig::get('sf_logging_enabled')) {
                    $this->context->getEventDispatcher()->notify(new sfEvent($this, 'application.log', array(sprintf('Action "%s/%s" requires credentials "%s", forwarding to "%s/%s"', $this->context->getModuleName(), $this->context->getActionName(), sfYaml::dump($credential, 0), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action')))));
                }

                // the user doesn't have access
                $this->forwardToSecureAction();
            }

            // the user has access, continue
            $filterChain->execute();
        }
    }

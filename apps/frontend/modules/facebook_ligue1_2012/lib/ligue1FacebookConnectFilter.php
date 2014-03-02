<?php

    /**
     * Filter forcing a Facebook connect for players that are not authenticated.
     *
     * Simple accounts can use this aplication since this is a free predictions only application.
     *
     * @package    betkup.fr
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: facebookConnectFilter.class.php 5636 2012-07-12 16:54:26Z jmasmejean $
     */
    class ligue1FacebookConnectFilter extends sfFilter {

        public function execute($filterChain) {

            $action = $this->getContext()->getActionName();
            $module = $this->getContext()->getModuleName();

            header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
            if ($this->isFirstCall() && $action != 'facebookConnect' && $action != 'likePage' && $action != 'landingPage') {

                if ($this->getContext()->getUser()->getAttribute('access_token', '', 'subscriber') == '' || !$this->getContext()->getUser()->isAuthenticated()) {
                    if (!$this->getContext()->getUser()->isAuthenticated() || $this->getContext()->getUser()->getAttribute('access_token', '', 'subscriber') == '') {
                        $this->getContext()->getController()->redirect(
                            $this->getContext()->getController()->genUrl(
                                array('module' => $module, 'action' => 'facebookConnect')));
                    }
                }
            }
            $filterChain->execute();
        }
    }

?>
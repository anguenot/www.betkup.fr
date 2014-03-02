<?php

/**
 * Filter forcing user to remain in Facebook Canvas.
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: facebookCanvasFilter.class.php 6153 2012-09-20 14:38:55Z jmasmejean $
 */
class sfFacebookCanvasFilter extends sfFilter
{

    public function execute($filterChain)
    {
        $action = $this->getContext()->getActionName();
        $module = $this->getContext()->getModuleName();
        $request = $this->getContext()->getRequest();
        if ($this->isFirstCall() && $action != 'facebookConnect') {
            // If within Facebook, the referer is always apps.facebook.com
            $referer = $request->getReferer();
            if ($referer == '' && ($module == 'facebook_ligue1_2012' && $action == 'landingPage' && $request->getParameter('kup_uuid', '') == '')) {
                $this->getContext()->getController()->redirect("https://apps.facebook.com/" . sfConfig::get('mod_' . $module . '_facebook_canvas_ns') . "/" . $action);
            }
        }
        $filterChain->execute();
    }
}

?>
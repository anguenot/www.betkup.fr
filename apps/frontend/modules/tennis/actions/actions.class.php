<?php

/**
 * tennis actions.
 *
 * @package    betkup.fr
 * @subpackage tennis
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tennisActions extends betkupActions {
	
	/**
	 * Execute results action. Display the results for the kup
	 * 
	 * @param sfWebRequest $request
	 * @return json
	 */
	public function executeResults(sfWebRequest $request) {
		$cerror = 204;
		if($request->isXmlHttpRequest()) {
		}
		$response = array('cerror' => $cerror);
		return $this->renderText(json_encode($response));
	}
}

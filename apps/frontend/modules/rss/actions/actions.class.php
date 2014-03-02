<?php

/**
 * rss actions.
 *
 * @package    betkup.fr
 * @subpackage rss
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rssActions extends betkupActions
{
    /**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request) {
	    
		$rssFeed = new RSSFeed();
		$feed = $rssFeed->createRSSFeed();
		
	    for($i=0; $i<20; $i++) {
	    	$rssFeed->addFeedItem($feed, 'title'.$i, time(), 'Jon');
	    }
	    $filePath = sfConfig::get('sf_web_dir').'/rss/test.xml';
	    $rssFeed->saveRSS($feed, $filePath);
	    
	    //$rssFeed->openRSS($filePath);
		return $this->renderText('RSS');
	}
}

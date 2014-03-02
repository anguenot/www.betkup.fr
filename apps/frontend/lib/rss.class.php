<?php 
/**
 * Abstract RSS Feed class.
 * 
 * <p/>
 * 
 * Define primitives to create an RSS 2.0 Feeds.
 * 
 * @package  betkup.fr
 * @author   Sofun Gaming SAS
 * @version  SVN: $Id: rssParser.class.php 4416 2012-04-12 15:42:13Z jmasmejean $
 *
 */
class RSSFeed {
	
	private $channelId = 'betkupFeed';
	private $channelTitle = 'RSS Betkup';
	private $channelLink = 'https://betkup.fr';
	private $channelDescription = 'Ceci est un flux RSS de test';
	
	public function __construct() {
		
	}
	
	public function __destruct() {
		
	}
	
	public function createRSSFeed() {
	
		$file = new DOMDocument('1.0', 'UTF-8');
		
		$root = $file->createElement("rss");
		$root->setAttribute("version", "2.0");
		$root = $file->appendChild($root);
		
		$element_channel = $file->createElement("channel");
		$element_channel->setAttribute('id', $this->channelId);
		$element_channel->setIdAttribute('id', true);
		$element_channel = $root->appendChild($element_channel);
		
		$element_description = $file->createElement("description");
		$element_description = $element_channel->appendChild($element_description);
		$texte_description = $file->createTextNode($this->channelDescription);
		$texte_description = $element_description->appendChild($texte_description);
		
		$element_link = $file->createElement("link");
		$element_link = $element_channel->appendChild($element_link);
		$texte_link = $file->createTextNode($this->channelLink);
		$texte_link = $element_link->appendChild($texte_link);
		
		$element_title = $file->createElement("title");
		$element_title = $element_channel->appendChild($element_title);
		$texte_title = $file->createTextNode($this->channelTitle);
		$texte_title = $element_title->appendChild($texte_title);
		
		$file->validateOnParse = true;
		
		return $file;
	}
	
	public function addFeedItem($file, $title, $timestamp, $author, $imageUrl = '', $imageLink = '') {
		
		$element_channel = $file->getElementById($this->channelId);
		
		$element_item = $file->createElement("item");
		$element_item = $element_channel->appendChild($element_item);
		
		$element_title = $file->createElement("title");
		$element_title = $element_item->appendChild($element_title);
		$texte_title = $file->createTextNode($title);
		$texte_title = $element_title->appendChild($texte_title);
		
		$element_link = $file->createElement("link");
		$element_link = $element_item->appendChild($element_link);
		$texte_link = $file->createTextNode("Lien vers la news");
		$texte_link = $element_link->appendChild($texte_link);
		
		$element_date = $file->createElement("pubDate");
		$element_date = $element_item->appendChild($element_date);
		$texte_date = $file->createTextNode(date("d/m/Y H:i",$timestamp));
		$texte_date = $element_date->appendChild($texte_date);
		
		$element_author = $file->createElement("author");
		$element_author = $element_item->appendChild($element_author);
		$texte_author = $file->createTextNode($author);
		$texte_author = $element_author->appendChild($texte_author);
	}
	
	/**
	 * Save the RSS feed to the specified path.
	 * 
	 * @param string $filePath
	 */
	public function saveRSS($file, $filePath) {
		if($file->save($filePath) === false) {
			return false;
		}
	}
	
	/**
	 * Open the RSS feed from the specified path.
	 * 
	 * @param $filePath
	 * @return file
	 */
	public function openRSS($filePath) {
		$file = new DOMDocument();
		$file->load($filePath);
		
		return $file;
	}
}
?>
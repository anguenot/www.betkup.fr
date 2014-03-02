<?php

/**
 * Symfony memcache singleton
 *
 * @see sfMemcache
 *
 * @package    betkup.fr
 * @author     Sofun Gaming SAS
 * @version    SVN: $Id: sfMemcacheSingletonCache.class.php 5920 2012-08-14 16:05:50Z anguenot $
 */
class sfMemcacheSingletonCache extends sfMemcacheCache
{

    public function initialize($options = array())
    {
        // we create our own memcache instance here
        // sfMemcacheCache checks for a memcache key in the
        // options array and takes this value without
        // creating a new memcache instance
        // other option values, like prefix etc. are assigned to the subclass
        $memcache = sfMemcache::getInstance();

        $options['memcache'] = $memcache;
        parent::initialize($options);
    }

    public function clean($mode = sfCache::ALL)
    {
        // Clearing the symfony cache will trigger flushing your complete memcache.
        // If you do not want to allow this, you may overwrite the clean method in this child class
        // Do nothing here to avoid what's explained above.
    }

}

?>

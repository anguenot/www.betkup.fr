<?php
    /**
     * Abstract betkupWebResponse class.
     *
     * <p/>
     *
     * Abstract class that betkup.fr webResponse should inherit from.
     *
     * @package    betkup.fr
     * @author     Sofun Gaming SAS
     * @version    SVN: $Id: betkupWebResponse.class.php 6059 2012-09-04 12:31:30Z jmasmejean $
     */
    class betkupWebResponse extends sfWebResponse {

        /**
         * Overrides symfony getTitle() function to use i18n in title.
         *
         * Retrieves title for the current web response.
         *
         * @return string Title
         */
        public function getTitle() {
            return isset($this->metas['title']) ? sfContext::getInstance()->getI18N()->__($this->metas['title']) : '';
        }
    }

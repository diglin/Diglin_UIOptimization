<?php
/**
 * Diglin
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * @category    Diglin
 * @package     Diglin_UIOptimization
 * @copyright   Copyright (c) 2011-2013 Diglin (http://www.diglin.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Diglin_UIOptimization_Model_Cron
{
    /**
     * Delete content of media/js and media/css folders to refresh with updated compressed/minified js/css content
     * If disabled, the updates are done each time an original file is updated. Can be resource overload on live website.
     * 
     * @param Mage_Core_Model_Observer $observer
     */
    public function regenerateMediaFiles ($observer)
    {
        if (Mage::getStoreConfigFlag('uioptimization/general/cronupdate') 
            && (Mage::getStoreConfigFlag('uioptimization/csscompression/enabled') || Mage::getStoreConfigFlag('uioptimization/jscompression/enabled'))) {
            // Clean up media/css and media/js folders and recreate the folders if necessary
            try {
                Mage::getModel('core/design_package')->cleanMergedJsCss();
                Mage::dispatchEvent('clean_media_cache_after');
            } catch (Exception $e) {
                Mage::logException($e);
                return;
            }
            $stores = Mage::app()->getStores();
            foreach ($stores as $id => $v) {
                $url = Zend_Uri_Http::fromString(Mage::app()->getStore($id)->getBaseUrl());
                // Recreate the js and css compressed file by using the normal process
                try {
                    $curl = new Zend_Http_Client_Adapter_Curl();
                    $curl->setCurlOption(CURLOPT_SSL_VERIFYPEER, false);
                    $curl->setCurlOption(CURLOPT_SSL_VERIFYHOST, 1);
                    $curl->connect($url->getHost(), $url->getPort(), Mage::app()->getStore($id)->isCurrentlySecure());
                    $curl->write(Zend_Http_Client::GET, $url);
                    $curl->close();
                    Mage::log('[Diglin_UIOptimization_Model_Cron] Update media js/css content for the different stores', ZEND_LOG::DEBUG);
                } catch (Exception $e) {
                    Mage::logException($e);
                    return;
                }
            }
        }
    }
}

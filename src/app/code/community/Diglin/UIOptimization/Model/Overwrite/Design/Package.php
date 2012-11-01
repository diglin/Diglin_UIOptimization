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
 * @copyright   Copyright (c) 2011-2012 Diglin (http://www.diglin.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Diglin_UIOptimization_Model_Overwrite_Design_Package extends Mage_Core_Model_Design_Package
{
    /**
     * Merge specified css files and return URL to the merged file on success
     *
     * @param $files
     * @return string
     */
    public function getMergedCssUrl ($files)
    {
        $suffixFilename = (Mage::app()->getStore()->isCurrentlySecure()) ? '-ssl' : '';
        $targetFilename = md5(implode(',', $files)) . $suffixFilename . '.css';
        $targetDir = $this->_initMergerDir('css');
        if (! $targetDir) {
            return '';
        }
        if (Mage::helper('core')->mergeFiles($files, $targetDir . DS . $targetFilename, false, array($this, 'beforeMergeCss'), 'css')) {
            return Mage::getBaseUrl('media') . 'css/' . $targetFilename;
        }
        return '';
    }
}

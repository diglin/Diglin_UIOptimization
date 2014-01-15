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
class Diglin_UIOptimization_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Retreive some basic information depending on the type of file: original path, destination path, type, name, static
     *
     * @param string $name
     * @param string $type
     * @param bool $static
     * @return array $info
     */
    public function getCompressedInfo($name, $type = 'css', $static = false)
    {
        $info = array();
        $designPackage = Mage::getDesign();

        $orgname = $name;
        if(!$static){
            $info['orgskin_path'] = $designPackage->getFilename ( $orgname, array ('_type' => 'skin' ) );
        }else{
            $info['orgskin_path'] = Mage::getBaseDir() . DS . 'js'. DS . $name;
        }

        $orgpath = explode ( DS, $info['orgskin_path'] );
        if (count ( $orgpath ) > 1 && !$static) {
            // Get the theme of the original file
            $info['theme_name'] = $orgpath [count ( $orgpath ) - (count ( explode ( '/', $orgname ) ) + 1)];
        }
        $suffixFilename = (Mage::app()->getStore()->isCurrentlySecure())?'-ssl':'';
        $suffixFilename.= '_'.Mage::app()->getStore()->getId();
        $name = substr ( $name, 0, strpos($name, '.' . $type) );
        $name = $name . $suffixFilename .'_cp.'.$type;

        $file_path = explode('/', $name);
        if(count($file_path) > 1){
            $name = array_pop($file_path);
            $info['file_path'] = implode(DS, $file_path);
        }else{
            $info['file_path'] = '';
        }

        $info['original_name'] = $orgname;
        $info['new_name'] = $name;
        $info['type'] = $type;
        $info['static'] = $static;

        $targetDir = $this->initMergerDir ( $type );
        if (! $targetDir) {
            $info['success'] = false;
            return $info;
        }

        if(!$static){
            $info['targetPath'] = $targetDir . DS . 'skin' . DS . $info['theme_name'] . DS . $info['file_path'];
        }else{
            $info['targetPath'] = $targetDir . DS . $info['file_path'];
        }
        $info['targetPathFile']  = $info['targetPath'] . DS . $name;

        if(!file_exists($info['targetPath'])){
            $ioFile = new Diglin_Io_File();
            $ioFile->mkdir($info['targetPath'], 0755, true);
        }

        return $info;
    }
    /**
     * Provide the path URL of the filesystem for js or css files compressed or not
     *
     * @param array $info
     * @param string|array $mergeCallback
     * @return string
     */
    public function getResultPath ($info, $mergeCallback)
    {
        $designPackage = Mage::getDesign();
        // Skin items
        if (! $info['result'] && ! $info['static']) { // Default Folder
            return ($mergeCallback ? $designPackage->getFilename($info['original_name'], array('_type' => 'skin')) : $designPackage->getSkinUrl($info['original_name'], array()));
        } else {
            if (! $info['static']) {
                return ($mergeCallback ? $info['targetPathFile'] : Mage::getBaseUrl('media') . $info['type'] . '/skin/' . $info['theme_name'] . '/' . $info['file_path'] . '/' . $info['new_name']);
                 // Static Items
            } else {
                if (! $info['result'] && $info['static']) { // Default folder
                    return $mergeCallback ? Mage::getBaseDir() . DS . 'js' . DS . $info['original_name'] : Mage::getBaseUrl('js') . $info['original_name'];
                } else {
                    return $mergeCallback ? $info['targetPathFile'] : Mage::getBaseUrl('media') . $info['type'] . '/' . $info['file_path'] . '/' . $info['new_name'];
                }
            }
        }
    }

    /**
     * Make sure merger dir exists and writeable
     * Also can clean it up
     *
     * @param string $dirRelativeName
     * @param bool $cleanup
     * @return bool|string
     */
    public function initMergerDir ($dirRelativeName, $cleanup = false)
    {
        $mediaDir = Mage::getBaseDir('media');
        try {
            $dir = Mage::getBaseDir('media') . DS . $dirRelativeName;
            if ($cleanup) {
                Diglin_Io_File::rmdirRecursive($dir);
            }
            if (! is_dir($dir)) {
                mkdir($dir);
            }
            return is_writeable($dir) ? $dir : false;
        } catch (Exception $e) {
            Mage::logException($e);
        }
        return false;
    }

    /**
     * Add trailing slash if necessary
     *
     * @param string $url
     */
    public function getTrailingSlash ($url)
    {
        if (Mage::getStoreConfig('web/seo/trailingslash')) {
            if (! preg_match('/\\.(rss|html|htm|xml|php?)$/', strtolower($url)) && substr($url, - 1) != '/') {
                $url .= '/';
            }
        }
        return $url;
    }
}

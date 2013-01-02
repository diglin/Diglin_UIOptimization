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
class Diglin_UIOptimization_Block_Optimize_Head extends Mage_Page_Block_Html_Head 
{
    /**
     * Merge static and skin files of the same format into a set of HEAD directives or even into a directive
     *
     * Will attempt to merge into 1 directive, if merging callback is provided. In this case it will generate
     * filenames, rather than render urls.
     * The merger callback is responsible for checking whether files exist, merging them and giving result URL
     *
     * @param string $format - HTML element format for sprintf('<element src="%s"%s />', $src, $params)
     * @param array $staticItems - array of relative names of static items to be grabbed from js/ folder
     * @param array $skinItems - array of relative names of skin items to be found in skins according to design config
     * @param callback $mergeCallback
     * @return string
     */
    protected function &_prepareStaticAndSkinElements($format, array $staticItems, array $skinItems, $mergeCallback = null)
    {
        $designPackage = Mage::getDesign();
        $baseJsUrl = Mage::getBaseUrl('js');
        $items = array();
        if ($mergeCallback && !is_callable($mergeCallback)) {
            $mergeCallback = null;
        }

        // get static files from the js folder, no need in lookups
        foreach ($staticItems as $params => $rows) {
            foreach ($rows as $name) {
                if(strpos($name, '.css') !== false && Mage::getStoreConfigFlag('uioptimization/csscompression/enabled')){
                    $items[$params][] = $this->_prepareCssCompression($name, $mergeCallback, true);
                }else if(strpos($name, '.js') !== false && Mage::getStoreConfigFlag('uioptimization/jscompression/enabled')){
                    $items[$params][] = $this->_prepareJsCompression($name, $mergeCallback, true);
                }else{
                    $items[$params][] = $mergeCallback ? Mage::getBaseDir() . DS . 'js' . DS . $name : $baseJsUrl . $name;
                }
            }
        }

        // lookup each file basing on current theme configuration
        foreach ($skinItems as $params => $rows) {
            foreach ($rows as $name) {
                if(strpos($name, '.css') !== false && Mage::getStoreConfigFlag('uioptimization/csscompression/enabled')){
                    $items[$params][] = $this->_prepareCssCompression($name, $mergeCallback);
                }else if(strpos($name, '.js') !== false && Mage::getStoreConfigFlag('uioptimization/jscompression/enabled')){
                    $items[$params][] = $this->_prepareJsCompression($name, $mergeCallback);
                }else{
                    $items[$params][] = $mergeCallback ? $designPackage->getFilename($name, array('_type' => 'skin'))
                        : $designPackage->getSkinUrl($name, array());
                }
            }
        }

        $html = '';
        foreach ($items as $params => $rows) {
            // attempt to merge
            $mergedUrl = false;
            if ($mergeCallback) {
                $mergedUrl = call_user_func($mergeCallback, $rows);
            }
            // render elements
            $params = trim($params);
            $params = $params ? ' ' . $params : '';
            if ($mergedUrl) {
                $html .= sprintf($format, $mergedUrl, $params);
            } else {
                foreach ($rows as $src) {
                    $html .= sprintf($format, $src, $params);
                }
            }
        }
        return $html;
    }
    
    /**
     * Compress CSS files and write them to media/css folders
     * 
     * @param string $name
     * @param string|array $mergeCallback
     * @param bool $static
     * @return string
     */
    protected function _prepareCssCompression($name, $mergeCallback = null, $static = false)
    {        
        $designPackage = Mage::getDesign ();
        $config = Mage::getStoreConfig('uioptimization/csscompression');
        $uiHelper = Mage::helper('uioptimization');
        $options = array();
        
        if($config['type'] == 'yuicompressor'){//YUI Compressor
            $minifier = 'Diglin_Minify_YUICompressor';
            $method = 'minifyCss';
            // init Minify class with YUI Compressor
            Diglin_Minify_YUICompressor::$jarFile = Mage::getBaseDir('lib') . DS . 'Diglin' . DS . 'yuicompressor' . DS . 'yuicompressor.jar' ;
            Diglin_Minify_YUICompressor::$tempDir = Mage::getBaseDir('tmp');
            if(strlen($config['java_path']) > 0){
                Diglin_Minify_YUICompressor::$javaExecutable = $config['java_path'];
            }
        }elseif($config['type'] == 'googleminify'){// Google Minify
            $minifier = 'Diglin_Minify_CSS';
            $method = 'minify';
            $options = array('minifierOptions' => array(Diglin_Minify::TYPE_CSS => array('preserveComments' => $config['preserve_comments'])));
        }else{// CSS Tidy
            $css = new Diglin_Csstidy_Core();
            
            switch($config['template']){
                case 'custom':
                    $css->load_template ( $config['custom_template'] );
                    break;
                case 'low_compression':
                case 'default':
                case 'high_compression':
                case 'highest_compression':
                default:
                    $css->load_template ( $config['template'] );
                    break;
            }
            
            $css->set_cfg ( 'remove_last_;', $config['remove_last_semicolon'] );
            $css->set_cfg ( 'remove_bslash', $config['remove_bslash'] );
            $css->set_cfg ( 'compress_colors', $config['compress_colors'] );
            $css->set_cfg ( 'compress_font-weight', $config['compress_font'] );
            $css->set_cfg ( 'lowercase_s', $config['lowercase_s'] );
            $css->set_cfg ( 'optimise_shorthands', $config['optimise_shorthands'] ); //0 = none, 1=safe optimize, 2=all optimize
            $css->set_cfg ( 'case_properties', $config['case_properties'] );
            $css->set_cfg ( 'sort_properties', $config['sort_properties'] );
            $css->set_cfg ( 'sort_selectors', $config['sort_selectors'] );
            $css->set_cfg ( 'merge_selectors', $config['merge_selectors'] );
            $css->set_cfg ( 'discard_invalid_properties', $config['discard_invalid_properties'] );
            $css->set_cfg ( 'css_level', $config['css_level'] ); //css2.0, css2.1, css1.0
            $css->set_cfg ( 'preserve_css', $config['preserve_css'] );
            $css->set_cfg ( 'timestamp', $config['timestamp'] );
        }
        
        $info = $uiHelper->getCompressedInfo($name, 'css', $static);
        if(!isset($info['result']) || $info['result'] != false){
            $info['result'] = true;
        }
        
        if (! file_exists ( $info['targetPathFile'] ) && $info['result'] || 
        !Mage::getStoreConfigFlag('uioptimization/general/cronupdate') && $info['result'] && filemtime($info['orgskin_path']) > filemtime($info['targetPathFile']) ) {
            $ioFile = new Diglin_Io_File();
            if($config['type'] == 'csstidy'){// CSS Tidy
                $css_code = $ioFile->read ( $info['orgskin_path'] );
                $css->parse ( $css_code );
                $cssText = $css->print->plain ();
            }else if($config['type'] == 'googleminify' || $config['type'] == 'yuicompressor'){ // Google Minify or YUI Compressor
                $options += array(
                    'quiet' => true,// quiet will allow to get the content as array mixed null, or, if the 'quiet' option is set to true, an array with keys "success" (bool), "statusCode" (int), "content" (string), and "headers" (array).
                    'files' => array($info['orgskin_path']),
                    'encodeMethod' => '',
                    'minifiers' => array(Diglin_Minify::TYPE_CSS => array($minifier, $method))
                );
                $results = Diglin_Minify::serve('Files', $options);
                $cssText = $results['content']; 
            }
            
            //clean or fix @import and url(...); by comparing the path with the original CSS file (not the compressed one otherwise the path is wrong)
            $cssText = $designPackage->beforeMergeCss($info['orgskin_path'], $cssText);
            
            $info['result'] = $ioFile->write (  $info['targetPathFile'], $cssText, 0644 );
        };
        return $uiHelper->getResultPath($info, $mergeCallback);
    }
    
    /**
     * Compress JS files and write them to media/js folders
     * 
     * @param string $name
     * @param string|array $mergeCallback
     * @param bool $static
     * @return string
     */
    protected function _prepareJsCompression($name, $mergeCallback = null, $static = false)
    {    
        $config = Mage::getStoreConfig('uioptimization/jscompression');
        $uiHelper = Mage::helper('uioptimization');
        $options = array();
        
        $info = $uiHelper->getCompressedInfo($name, 'js', $static);
        if(!isset($info['result']) || $info['result'] != false){
            $info['result'] = true;
        }
        
        if (! file_exists ( $info['targetPathFile'] ) && $info['result'] || !Mage::getStoreConfigFlag('uioptimization/general/cronupdate') && $info['result'] && filemtime($info['orgskin_path']) > filemtime($info['targetPathFile'])) {
            switch($config['type']){
                case 'packer':
                    $minifier = 'Diglin_Minify_Packer';
                    $method = 'minify';
                    break;
                case 'yuicompressor':
                    $minifier = 'Diglin_Minify_YUICompressor';
                    $method = 'minifyJs';
                    Diglin_Minify_YUICompressor::$jarFile = Mage::getBaseDir('lib') . DS . 'Diglin' . DS .'yuicompressor' . DS . 'yuicompressor.jar' ;
                    Diglin_Minify_YUICompressor::$tempDir = Mage::getBaseDir('tmp');
                    if(strlen($config['java_path']) > 0){
                        Diglin_Minify_YUICompressor::$javaExecutable = $config['java_path'];
                    }
                    $options = array('minifierOptions' => 
                        array(Diglin_Minify::TYPE_JS => 
                            array(
                            'disable-optimizations'=>$config['disable_alloptimisation'],
                            'preserve-semi' => $config['preserve_semic'],
                            'nomunge' => $config['minify_only']
                            )
                        ));
                    break;
                case 'jsmin':
                default:
                    $minifier = 'Diglin_JSMin';
                    $method = 'minify';
                    break;
            }
            
            $options += array(
                'quiet' => true,// quiet will allow to get the content as array mixed null, or, if the 'quiet' option is set to true, an array with keys "success" (bool), "statusCode" (int), "content" (string), and "headers" (array).
                'minifiers' => array(Diglin_Minify::TYPE_JS => array($minifier, $method)),
                'files' => array($info['orgskin_path']),
                'encodeMethod' => '',
                
            );
            $results = Diglin_Minify::serve('Files', $options);
            
            if($results['success']){
                $io = new Diglin_Io_File ();
                $info['result'] = $io->write ( $info['targetPathFile'], $results['content'], 0644 );
            }else{
                $info['result'] = false;
            }
        }
        return $uiHelper->getResultPath($info, $mergeCallback);
    }
    
    /**
     * Canonical URL
     * @return $this Rissip_UIOptimization_Block_Optimize_Head
     */
    public function getCanonicalUrl ()
    {
        Mage::dispatchEvent('uioptimization_canonicalurl_before', array('head' => $this, 'transport' => ''));
        
        if(is_string($this->transport) && strlen($this->transport) > 0){
            return $this->transport;
        }
        
        $handles = Mage::app()->getLayout()->getUpdate()->getHandles();
        
        $searchHandles = array('catalogsearch_result_index', 'catalogsearch_advanced_index', 'catalogsearch_advanced_result');
        $productHandles = array('catalog_product_view');
        $homeHandles = array('cms_index_index');
        $blogHandles = array('blog_post_view', 'blog_cat_view');
        
        foreach ($handles as $handle){
            // Catalog Search 
            if (in_array($handle, $searchHandles)  && Mage::getStoreConfigFlag('uioptimization/seo/search')) {
                return $this->_setCanonicalSearchUrl();
            }elseif (!Mage::getStoreConfigFlag('uioptimization/seo/search')) {
                return;
            }
            
            // Catalog Product
            if (in_array($handle, $productHandles) && Mage::getStoreConfigFlag('uioptimization/seo/products')) {
                return $this->_setCanonicalProductUrl();
            }elseif (!Mage::getStoreConfigFlag('uioptimization/seo/products')) {
                return;
            }
            
            // Homepage CMS
            if (in_array($handle, $homeHandles)  && Mage::getStoreConfigFlag('uioptimization/seo/cmshome')) {
                return $this->_setCanonicalHomeUrl();
            }elseif (!Mage::getStoreConfigFlag('uioptimization/seo/cmshome')) {
                return;
            }
        }
        return $this->_setCanonicalUrl();
    }

    private function _setCanonicalUrl()
    {
        if (empty($this->_data['urlKey'])) {
            $url = Mage::helper('core/url')->getCurrentUrl();
            $parsedUrl = parse_url($url);
            $port = isset($parsedUrl['port']) ? $parsedUrl['port'] : null;
            $headUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . ($port && '80' != $port ? ':' . $port : '') . $parsedUrl['path'];
            $this->_data['urlKey'] = Mage::helper('uioptimization')->getTrailingSlash($headUrl);
        }
        return $this->_data['urlKey'];
    } 
    
    /**
     * Canonical URL for homepage
     */
    private function _setCanonicalHomeUrl ()
    {
        if (empty($this->_data['urlKey'])) {
            $url = Mage::helper('core/url')->getCurrentUrl();
            $request = Mage::app()->getRequest();
            $currentUri = $request->getRequestUri();
            
            // Purpose: provide a canonical url for shop having store code in header for the homepage
            if($request->getBaseUrl() && strpos($currentUri, $request->getBaseUrl()) !== false ){
                $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) . substr($currentUri,strlen( $request->getBaseUrl()) +1);
                
                $currentUriClean = trim($currentUri, '/');
                $parts = explode('/', $currentUriClean);
                
                // Add code store to url if not provided by the client
                if(count($parts) <= 1 && Mage::getStoreConfigFlag('web/url/use_store') && Mage::getStoreConfigFlag('web/seo/use_rewrites')){
                    $url .= Mage::app()->getStore()->getCode() . '/';
                }
            }
            
            $parsedUrl = parse_url($url);
            $port = isset($parsedUrl['port']) ? $parsedUrl['port'] : null;
            $headUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . ($port && '80' != $port ? ':' . $port : '') . $parsedUrl['path'];
            $this->_data['urlKey'] = Mage::helper('uioptimization')->getTrailingSlash($headUrl);
        }
        return $this->_data['urlKey'];
    }
    
    /**
     * Canonical Product URL
     */
    private function _setCanonicalProductUrl ()
    {
        if (empty($this->_data['urlKey'])) {
            $product_id = $this->getRequest()->getParam('id');
            $_item = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($product_id);
            $headUrl = Mage::getBaseUrl() . $_item->getUrlPath() /*. Mage::helper('catalog/product')->getProductUrlSuffix()*/;
            $this->_data['urlKey'] = Mage::helper('uioptimization')->getTrailingSlash($headUrl);
        }
        return $this->_data['urlKey'];
    }

    private function _setCanonicalSearchUrl()
    {
        if (empty($this->_data['urlKey'])) {
            
            $headUrl = $this->_setCanonicalUrl();
            $request = Mage::app()->getRequest();
            $searchParam = $request->getParam('q');
            $searchNameParam = $request->getParam('name');
            $searchDescParam = $request->getParam('description');
            $params = array();
            if($searchParam) $params[] = 'q='.$searchParam;
            if($searchNameParam) $params[] = 'name='.$searchNameParam;
            if($searchDescParam) $params[] = 'description='.$searchDescParam;
            $this->_data['urlKey'] = $headUrl . ((count($params))? '?' .implode('&', $params): '');
        }
        return $this->_data['urlKey'];
    }
}

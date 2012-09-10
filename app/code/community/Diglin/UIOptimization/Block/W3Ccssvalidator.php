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
class Diglin_UIOptimization_Block_W3Ccssvalidator extends Mage_Core_Block_Template
{
    
    protected $_validator;
    
    public $results;
    
    protected function _beforeToHtml()
    {
        if ( !Mage::getStoreConfig('uioptimization/w3ccssvalidator/enabled') 
        || !Mage::helper('core')->isDevAllowed() 
        || strpos($_SERVER['HTTP_USER_AGENT'], 'W3C_Validator') !== false) {
            return '';
        }
        
           /**
            * To force to include the PEAR libs installed in Magento (downloader/pearlib) - Without that 
         * we cannot have the Services_W3C_HTMLValidator dependencies
         * The var $pear is not used here for the moment. But the call to Varien_Pear is necessary
            */
        //$pear = Varien_Pear::getInstance (); // not compatible with Magento > 1.5
        $config = Mage::getStoreConfig ( 'uioptimization' );
        
        $this->_validator = new Diglin_Services_W3C_CSSValidator ();
        
        if(!empty($config['w3ccssvalidator']['validator_uri'])){
            $this->_validator->validator_uri = $config['w3ccssvalidator']['validator_uri'];
        };
        
        if(!empty($config['w3ccssvalidator']['charset'])){
            $this->_validator->charset = $config['w3ccssvalidator']['charset'];
        };
        
        if(!empty($config['w3ccssvalidator']['fbd'])){
            $this->_validator->fbc = (int)$config['w3ccssvalidator']['fbc'];
        };
        
        if(!empty($config['w3ccssvalidator']['doctype'])){
            $this->_validator->doctype = $config['w3ccssvalidator']['doctype'];
        };
        
        if(!empty($config['w3ccssvalidator']['fbc'])){
            $this->_validator->fbd = (int)$config['w3ccssvalidator']['fbc'];
        };
        
        //$this->results = $this->_validator->validate('http://www.google.com/');
        $this->results = $this->_validator->validateUri(Mage::helper('core/url')->getCurrentUrl());
    
        return parent::_beforeToHtml();
    }
    
    /**
     * 
     * @return Services_W3C_HTMLValidator_Response $this->results
     */
    public function getValidatorResults()
    {
        return $this->results;
    }
}

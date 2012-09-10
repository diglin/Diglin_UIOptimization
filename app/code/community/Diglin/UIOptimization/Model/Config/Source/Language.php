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
class Diglin_UIOptimization_Model_Config_Source_Language
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'en','label'=>Mage::helper('uioptimization')->__("English")),
            array('value' => 'de','label'=>Mage::helper('uioptimization')->__("German")),
            array('value' => 'es','label'=>Mage::helper('uioptimization')->__("Spanish; Castilian")),
            array('value' => 'fr','label'=>Mage::helper('uioptimization')->__("French")),
            array('value' => 'it','label'=>Mage::helper('uioptimization')->__("Italian")),
            array('value' => 'ja','label'=>Mage::helper('uioptimization')->__("Japanese")),
            array('value' => 'ko','label'=>Mage::helper('uioptimization')->__("Korean")),
            array('value' => 'nl','label'=>Mage::helper('uioptimization')->__("Dutch; Flemish")),
            array('value' => 'zh-cn','label'=>Mage::helper('uioptimization')->__("Chinese (China)")),
        );
    }
}
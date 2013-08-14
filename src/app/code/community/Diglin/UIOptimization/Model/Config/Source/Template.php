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
class Diglin_UIOptimization_Model_Config_Source_Template
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'default', 'label' => 'Standard (balance between readability and size)'),
            array('value' => 'high_compression', 'label' => 'High (moderate readability, smaller size)'),
            array('value' => 'highest_compression', 'label' => 'Highest (no readability, smallest size)'),
            array('value' => 'low_compression', 'label' => 'Low (higher readability)'),
            array('value' => 'custom', 'label' => 'Custom (feel the textarea below)'),
        );
    }
}
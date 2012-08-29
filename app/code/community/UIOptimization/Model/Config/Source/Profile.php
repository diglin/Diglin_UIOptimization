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
class Diglin_UIOptimization_Model_Config_Source_Profile
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'none', 'label' => 'none profile'),
            array('value' => 'css1', 'label' => 'CSS level 1'),
            array('value' => 'css2', 'label' => 'CSS level 2'),
            array('value' => 'css21', 'label' => 'CSS level 2.1'),
            array('value' => 'css3', 'label' => 'CSS level 3'),
            array('value' => 'svg', 'label' => 'SVG'),
            array('value' => 'svgbasic', 'label' => 'SVG Basic'),
            array('value' => 'svgtiny', 'label' => 'SVG Tiny'),
            array('value' => 'mobile', 'label' => 'Mobile'),
            array('value' => 'atsc-tv', 'label' => 'ATSC TV'),
            array('value' => 'tv', 'label' => 'TV'),
        );
    }
}
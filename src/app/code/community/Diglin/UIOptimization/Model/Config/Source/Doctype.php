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
class Diglin_UIOptimization_Model_Config_Source_Doctype
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
          array('value' => "Inline", 'label' => "(detect automatically)"),
          array('value' => "HTML5", 'label' => "HTML5 (experimental)"),
          array('value' => "XHTML 1.0 Strict", 'label' => "XHTML 1.0 Strict"),
          array('value' => "XHTML 1.0 Transitional", 'label' => "XHTML 1.0 Transitional"),
          array('value' => "XHTML 1.0 Frameset", 'label' => "XHTML 1.0 Frameset"),
          array('value' => "HTML 4.01 Strict", 'label' => "HTML 4.01 Strict"),
          array('value' => "HTML 4.01 Transitional", 'label' => "HTML 4.01 Transitional"),
          array('value' => "HTML 4.01 Frameset", 'label' => "HTML 4.01 Frameset"),
          array('value' => "HTML 3.2", 'label' => "HTML 3.2"),
          array('value' => "HTML 2.0", 'label' => "HTML 2.0"),
          array('value' => "ISO/IEC 15445:2000 (&quot;ISO HTML&quot;)", 'label' => "ISO/IEC 15445:2000 (\"ISO HTML\")"),
          array('value' => "XHTML 1.1", 'label' => "XHTML 1.1"),
          array('value' => "XHTML + RDFa", 'label' => "XHTML + RDFa"),
          array('value' => "XHTML Basic 1.0", 'label' => "XHTML Basic 1.0"),
          array('value' => "XHTML Basic 1.1", 'label' => "XHTML Basic 1.1"),
          array('value' => "XHTML Mobile Profile 1.2", 'label' => "XHTML Mobile Profile 1.2"),
          array('value' => "XHTML-Print 1.0", 'label' => "XHTML-Print 1.0"),
          array('value' => "XHTML 1.1 plus MathML 2.0", 'label' => "XHTML 1.1 plus MathML 2.0"), 
          array('value' => "XHTML 1.1 plus MathML 2.0 plus SVG 1.1", 'label' => "XHTML 1.1 plus MathML 2.0 plus SVG 1.1"), 
          array('value' => "MathML 2.0", 'label' => "MathML 2.0"),
          array('value' => "SVG 1.0", 'label' => "SVG 1.0"),
          array('value' => "SVG 1.1", 'label' => "SVG 1.1"),
          array('value' => "SVG 1.1 Tiny", 'label' => "SVG 1.1 Tiny"),
          array('value' => "SVG 1.1 Basic", 'label' => "SVG 1.1 Basic"),
          array('value' => "SMIL 1.0", 'label' => "SMIL 1.0"),
          array('value' => "SMIL 2.0", 'label' => "SMIL 2.0"),
        );
    }
}
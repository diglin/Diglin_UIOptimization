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
class Diglin_UIOptimization_Model_Config_Source_Charset
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
                array('value' => "", 'label' => "(detect automatically)"),
                array('value' => "utf-8", 'label' => "utf-8 (Unicode, worldwide)"),
                array('value' => "utf-16", 'label' => "utf-16 (Unicode, worldwide)"),
                array('value' => "iso-8859-1", 'label' => "iso-8859-1 (Western Europe)"),
                array('value' => "iso-8859-2", 'label' => "iso-8859-2 (Central Europe)"),
                array('value' => "iso-8859-3", 'label' => "iso-8859-3 (Southern Europe)"),
                array('value' => "iso-8859-4", 'label' => "iso-8859-4 (North European)"),
                array('value' => "iso-8859-5", 'label' => "iso-8859-5 (Cyrillic)"),
                array('value' => "iso-8859-6-i", 'label' => "iso-8859-6-i (Arabic)"),
                array('value' => "iso-8859-7", 'label' => "iso-8859-7 (Greek)"),
                array('value' => "iso-8859-8", 'label' => "iso-8859-8 (Hebrew, visual)"),
                array('value' => "iso-8859-8-i", 'label' => "iso-8859-8-i (Hebrew, logical)"),
                array('value' => "iso-8859-9", 'label' => "iso-8859-9 (Turkish)"),
                array('value' => "iso-8859-10", 'label' => "iso-8859-10 (Latin 6)"),
                array('value' => "iso-8859-11", 'label' => "iso-8859-11 (Latin/Thai)"),
                array('value' => "iso-8859-13", 'label' => "iso-8859-13 (Latin 7, Baltic Rim)"),
                array('value' => "iso-8859-14", 'label' => "iso-8859-14 (Latin 8, Celtic)"),
                array('value' => "iso-8859-15", 'label' => "iso-8859-15 (Latin 9)"),
                array('value' => "iso-8859-16", 'label' => "iso-8859-16 (Latin 10)"),
                array('value' => "us-ascii", 'label' => "us-ascii (basic English)"),
                array('value' => "euc-jp", 'label' => "euc-jp (Japanese, Unix)"),
                array('value' => "shift_jis", 'label' => "shift_jis (Japanese, Win/Mac)"),
                array('value' => "iso-2022-jp", 'label' => "iso-2022-jp (Japanese, email)"),
                array('value' => "euc-kr", 'label' => "euc-kr (Korean)"),
                array('value' => "ksc_5601", 'label' => "ksc_5601 (Korean)"),
                array('value' => "gb2312", 'label' => "gb2312 (Chinese, simplified)"),
                array('value' => "gb18030", 'label' => "gb18030 (Chinese, simplified)"),
                array('value' => "big5", 'label' => "big5 (Chinese, traditional)"),
                array('value' => "big5-HKSCS", 'label' => "Big5-HKSCS (Chinese, Hong Kong)"),
                array('value' => "tis-620", 'label' => "tis-620 (Thai)"),
                array('value' => "koi8-r", 'label' => "koi8-r (Russian)"),
                array('value' => "koi8-u", 'label' => "koi8-u (Ukrainian)"),
                array('value' => "iso-ir-111", 'label' => "iso-ir-111 (Cyrillic KOI-8)"),
                array('value' => "macintosh", 'label' => "macintosh (MacRoman)"),
                array('value' => "windows-1250", 'label' => "windows-1250 (Central Europe)"),
                array('value' => "windows-1251", 'label' => "windows-1251 (Cyrillic)"),
                array('value' => "windows-1252", 'label' => "windows-1252 (Western Europe)"),
                array('value' => "windows-1253", 'label' => "windows-1253 (Greek)"),
                array('value' => "windows-1254", 'label' => "windows-1254 (Turkish)"),
                array('value' => "windows-1255", 'label' => "windows-1255 (Hebrew)"),
                array('value' => "windows-1256", 'label' => "windows-1256 (Arabic)"),
                array('value' => "windows-1257", 'label' => "windows-1257 (Baltic Rim)"),
        );
    }
}
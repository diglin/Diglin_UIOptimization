<?php
/**
 * Copyright (c) 2007, Laurent Laville <pear@laurent-laville.org>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the authors nor the names of its contributors
 *       may be used to endorse or promote products derived from this software
 *       without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * PHP version 5
 *
 * @category Web_Services
 * @package  Diglin_Services_W3C_CSSValidator
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @version  CVS: $Id: CSSValidator.php 294912 2010-02-11 22:56:41Z clockwerx $
 * @link     http://pear.php.net/package/Diglin_Services_W3C_CSSValidator
 * @since    File available since Release 0.1.0
 */

#require_once 'HTTP/Request2.php';

#require_once 'Services/W3C/CSSValidator/Response.php';
#require_once 'Services/W3C/CSSValidator/Error.php';
#require_once 'Services/W3C/CSSValidator/Warning.php';

/**
 * Base class for utilizing the W3C CSS Validator service.
 *
 * @category Web_Services
 * @package  Diglin_Services_W3C_CSSValidator
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @link     http://pear.php.net/package/Diglin_Services_W3C_CSSValidator
 * @since    Class available since Release 0.1.0
 */
class Diglin_Services_W3C_CSSValidator
{
    /**
     * URI to the W3C validator.
     *
     * @var    string
     */
    const VALIDATOR_URI = 'http://jigsaw.w3.org/css-validator/validator';

    /**
     * The URL of the document to validate
     *
     * @var    string
     */
    protected $uri;

    /**
     * Internally used filename of a file to upload to the validator
     * POSTed as multipart/form-data
     *
     * @var    string
     */
    protected $uploaded_file;

    /**
     * CSS fragment to validate.
     *
     * Full documents only. At the moment, will only work if data is sent with the
     * UTF-8 encoding.
     *
     * @var    string
     */
    protected $fragment;

    /**
     * Options list (available with default values) :
     *
     * output - Output format
     *          Triggers the various outputs formats of the validator. If unset,
     *          the usual Web html format will be sent. If set to soap12,
     *          the SOAP1.2 interface will be triggered.
     *
     * warning - Warning level
     *           Default value is '1', and value could one of these :
     *           <ul>
     *             <li>2</li> all warning messages
     *             <li>1</li> normal report
     *             <li>0</li> most important warning messages
     *             <li>no</li> none messages
     *           </ul>
     *
     * profile - Profile
     *           Default value is 'css21', and value could one of these :
     *           <ul>
     *             <li>none</li> none profile
     *             <li>css1</li> CSS level 1
     *             <li>css2</li> CSS level 2
     *             <li>css21</li> CSS level 2.1
     *             <li>css3</li> CSS level 3
     *             <li>svg</li> SVG
     *             <li>svgbasic</li> SVG Basic
     *             <li>svgtiny</li> SVG Tiny
     *             <li>mobile</li> Mobile
     *             <li>atsc-tv</li> ATSC TV
     *             <li>tv</li> TV
     *           </ul>
     *
     * usermedium - User medium
     *              Default value is 'all', and value could one of these :
     *              <ul>
     *                <li>all</li>
     *                <li>aural</li>
     *                <li>braille</li>
     *                <li>embossed</li>
     *                <li>handheld</li>
     *                <li>print</li>
     *                <li>projection</li>
     *                <li>screen</li>
     *                <li>tty</li>
     *                <li>tv</li>
     *                <li>presentation</li>
     *              </ul>
     *
     * lang - Language used for response messages
     *        Default value is 'en', and value could one of these :
     *        en, fr, ja, es, zh-cn, nl, de
     *
     * @var    array
     */
    protected $options;

    /**
     * Diglin_HTTP_Request2 object.
     *
     * @var    object
     */
    protected $request;

    /**
     * Constructor for the class.
     *
     * @return void
     */
    public function __construct(Diglin_HTTP_Request2 $request = null)
    {
        $this->options = array('output' => 'soap12', 'warning' => '1',
            'profile' => 'css21', 'usermedium' => 'all', 'lang' => 'en');

        if (empty($request)) {
            $request = new Diglin_HTTP_Request2();
        }

        $this->request = $request;
    }

    /**
     * Sets options for the class.
     *
     * @param string $option Name of option to set
     * @param string $val    Value of option to set
     *
     * @return void
     */
    public function __set($option, $val)
    {
        // properties that can be set directly
        $setting_allowed = array('uri');

        if (isset($this->options[$option])) {
            $this->options[$option] = $val;
        } elseif (property_exists($this, $option)) {
            if (in_array($option, $setting_allowed)) {
                $this->$option = $val;
            }
        }
    }

    /**
     * Gets options for the class.
     *
     * @param string $option Name of option to set
     *
     * @return mixed
     */
    public function __get($option)
    {
        // properties that can be get directly
        $getting_allowed = array('uri');

        $r = null;
        if (isset($this->options[$option])) {
            $r = $this->options[$option];
        } elseif (property_exists($this, $option)) {
            if (in_array($option, $getting_allowed)) {
                $r = $this->$option;
            }
        }
        return $r;
    }

    /**
     * Validates a given URI
     *
     * Executes the validator using the current parameters and returns a Response
     * object on success.
     *
     * @param string $uri The address to the page to validate ex: http://example.com/
     *
     * @return mixed object Diglin_Services_W3C_CSSValidator_Response
     *                      if web service call successfull,
     *               boolean FALSE otherwise
     */
    public function validateUri($uri)
    {
        $this->uri = $uri;
        $this->buildRequest('uri');
        if ($response = $this->sendRequest()) {
            return $this->parseSOAP12Response($response->getBody());
        } else {
            return false;
        }
    }

    /**
     * Validates the local file
     *
     * Requests validation on the local file, from an instance of the W3C validator.
     * The file is posted to the W3C validator using multipart/form-data.
     *
     * @param string $file file to be validated.
     *
     * @return mixed object Diglin_Services_W3C_CSSValidator_Response
     *                      if web service call successfull,
     *               boolean FALSE otherwise
     */
    public function validateFile($file)
    {
        if (file_exists($file)) {
            $this->uploaded_file = $file;
            $this->buildRequest('file'); //return $this->request;
            if ($response = $this->sendRequest()) {
                return $this->parseSOAP12Response($response->getBody());
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Validate an html string
     *
     * @param string $css Full css document fragment
     *
     * @return mixed object Diglin_Services_W3C_CSSValidator_Response
     *                      if web service call successfull,
     *               boolean FALSE otherwise
     */
    public function validateFragment($css)
    {
        $this->fragment = $css;
        $this->buildRequest('fragment');
        if ($response = $this->sendRequest()) {
            return $this->parseSOAP12Response($response->getBody());
        } else {
            return false;
        }
    }

    /**
     * Prepares a request object to send to the validator.
     *
     * @param string $type uri, file, or fragment
     *
     * @return void
     */
    protected function buildRequest($type = 'uri')
    {
        $this->request->setURL(self::VALIDATOR_URI);
        switch ($type) {
        case 'uri':
        default:
            $this->request->setMethod(Diglin_HTTP_Request2::METHOD_GET);
            $this->setQueryVariable('uri', $this->uri);
            $method = 'setQueryVariable';
            break;
        case 'file':
            $this->request->setMethod(Diglin_HTTP_Request2::METHOD_POST);
            $this->request->addUpload('file',
                                     $this->uploaded_file,
                                     null,
                                     'text/css');
            $method = 'addPostParameter';
            break;
        case 'fragment':
            $this->request->setMethod(Diglin_HTTP_Request2::METHOD_GET);
            $this->setQueryVariable('text', $this->fragment);
            $method = 'setQueryVariable';
            break;
        }

        $options = array('output', 'warning', 'profile', 'usermedium', 'lang');
        foreach ($options as $option) {
            if (isset($this->options[$option])) {
                if (is_bool($this->options[$option])) {
                    $this->request->$method($option,
                        intval($this->options[$option]));
                } else {
                    $this->$method($option, $this->options[$option]);
                }
            }
        }
    }

    /**
     * Set a querystring variable for the request
     * 
     * @param string $name  Name of the querystring parameter
     * @param mixed  $value Value of the parameter
     * 
     * @return void
     */
    protected function setQueryVariable($name, $value = '')
    {
        $url = $this->request->getURL();
        $url->setQueryVariable($name, $value);
        $this->request->setURL($url);
    }
    
    /**
     * Add post data to the request
     * 
     * @param string $name  Name of the post field
     * @param mixed  $value Value of the field
     * 
     * @return void
     */
    protected function addPostParameter($name, $value = '')
    {
        $this->request->addPostParameter($name, $value);
    }
    

    /**
     * Actually sends the request to the CSS Validator service
     *
     * @return bool TRUE if request was sent successfully, FALSE otherwise
     */
    protected function sendRequest()
    {
        try {
            return $this->request->send();
        } catch (Exception $e) {
            throw new Exception('Error sending request', null, $e);
        }
    }

    /**
     * Parse an XML response from the validator
     *
     * This function parses a SOAP 1.2 response xml string from the validator.
     *
     * @param string $xml The raw soap12 XML response from the validator.
     *
     * @return mixed object Diglin_Services_W3C_CSSValidator_Response
     *                      if parsing soap12 response successfully,
     *               boolean FALSE otherwise
     */
    protected function parseSOAP12Response($xml)
    {
        $doc = new DOMDocument();
        // try to load soap 1.2 xml response, and suppress warning reports if any
        if (@$doc->loadXML($xml)) {
            $response = new Diglin_Services_W3C_CSSValidator_Response();

            // Get the standard CDATA elements
            $cdata = array('uri', 'checkedby', 'csslevel', 'date');
            foreach ($cdata as $var) {
                $element = $doc->getElementsByTagName($var);
                if ($element->length) {
                    $response->$var = $element->item(0)->nodeValue;
                }
            }
            // Handle the bool element validity
            $element = $doc->getElementsByTagName('validity');
            if ($element->length &&
                $element->item(0)->nodeValue == 'true') {
                $response->validity = true;
            } else {
                $response->validity = false;
            }
            if (!$response->validity) {
                $errors = $doc->getElementsByTagName('error');
                foreach ($errors as $error) {
                    $response->addError(new
                        Diglin_Services_W3C_CSSValidator_Error($error));
                }
            }
            $warnings = $doc->getElementsByTagName('warning');
            foreach ($warnings as $warning) {
                    $response->addWarning(new
                        Diglin_Services_W3C_CSSValidator_Warning($warning));
            }
            return $response;
        } else {
            // Could not load the XML document
            return false;
        }
    }
}
?>

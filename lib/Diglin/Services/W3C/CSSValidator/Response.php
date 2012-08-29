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
 * @version  CVS: $Id: Response.php 246860 2007-11-23 17:56:45Z farell $
 * @link     http://pear.php.net/package/Diglin_Services_W3C_CSSValidator
 * @since    File available since Release 0.1.0
 */

/**
 * Base class for a W3C CSS Validator Response.
 *
 * @category Web_Services
 * @package  Diglin_Services_W3C_CSSValidator
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @link     http://pear.php.net/package/Diglin_Services_W3C_CSSValidator
 * @since    Class available since Release 0.1.0
 */
class Diglin_Services_W3C_CSSValidator_Response
{
    /**
     * The address of the document validated. In EARL terms, this is
     * the TestSubject.
     *
     * @var    string
     */
    public $uri;

    /**
     * Location of the service which provided the validation result. In EARL terms,
     * this is the Assertor.
     *
     * @var    string
     */
    public $checkedby;

    /**
     * The CSS level (or profile) in use during the validation.
     *
     * @var    string
     */
    public $csslevel;

    /**
     * The actual date of the validation.
     *
     * @var    string
     */
    public $date;

    /**
     * Whether or not the document validated passed or not formal validation
     *
     * @var    bool
     */
    public $validity;

    /**
     * Array of Diglin_Services_W3C_CSSValidator_Error objects (if applicable)
     *
     * @var    array
     */
    public $errors = array();

    /**
     * Array of Diglin_Services_W3C_CSSValidator_Warning objects (if applicable)
     *
     * @var    array
     */
    public $warnings = array();

    /**
     * Returns the validity of the checked document.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->validity;
    }

    /**
     * Adds a new error on stack
     *
     * @param object $error instance of Diglin_Services_W3C_CSSValidator_Error class
     *
     * @return void
     */
    public function addError($error)
    {
        if ($error instanceof Diglin_Services_W3C_CSSValidator_Error) {
            $this->errors[] = $error;
        }
    }

    /**
     * Adds a new warning on stack
     *
     * @param object $warning instance of Diglin_Services_W3C_CSSValidator_Warning class
     *
     * @return void
     */
    public function addWarning($warning)
    {
        if ($warning instanceof Diglin_Services_W3C_CSSValidator_Warning) {
            $this->warnings[] = $warning;
        }
    }
}
?>
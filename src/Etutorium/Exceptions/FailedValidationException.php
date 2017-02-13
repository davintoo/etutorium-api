<?php

namespace Etutorium\Exceptions;

/**
 * Class FailedValidationException
 *
 * @category Etutorium
 * @package  Etutorium
 * @author   Alex Slubsky <aslubsky@gmail.com>
 */
class FailedValidationException extends BaseException
{
    private $_response = null;

    public function setResponse($response)
    {
        $this->_response = $response;
    }

    public function getResponse()
    {
       return $this->_response;
    }
}
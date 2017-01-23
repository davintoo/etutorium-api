<?php

namespace Etutorium\Endpoints;

/**
 * Class AbstractEndpoint
 *
 * @category Etutorium
 * @package  Etutorium\Endpoints
 * @author   Alex Slubsky <aslubsky@gmail.com>
 */
abstract class AbstractEndpoint
{
    /** @var array */
    protected $params = array();

    /** @var  string */
    protected $method = null;

    /** @var  array */
    protected $body = null;

    /** @var array */
    private $options = [];

    /** @var  bool */
    protected $authRequired;

    /** @var  string */
    protected $uri;

    /**
     * @return string
     */
    public function getURI()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return bool
     */
    public function authRequired()
    {
        return $this->authRequired;
    }


    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param array $body
     *
     * @return $this
     */
    public function setBody($body)
    {
        if (isset($body) !== true) {
            return $this;
        }

        $this->body = $body;

        return $this;
    }
}

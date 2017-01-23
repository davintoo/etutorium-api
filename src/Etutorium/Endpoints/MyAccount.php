<?php

namespace Etutorium\Endpoints;

/**
 * Class MyAccount
 *
 * @category Etutorium
 * @package  Etutorium\Endpoints
 * @author   Alex Slubsky <aslubsky@gmail.com>
 */
class MyAccount extends AbstractEndpoint
{
    /** @var  bool */
    protected $authRequired = true;

    /** @var  string */
    protected $uri = '/rest/webinar';

    /** @var  string */
    protected $method = 'GET';
}

<?php

namespace Etutorium\Endpoints;

/**
 * Class Login
 *
 * @category Etutorium
 * @package  Etutorium\Endpoints
 * @author   Alex Slubsky <aslubsky@gmail.com>
 */
class Login extends AbstractEndpoint
{
    /** @var  bool */
    protected $authRequired = false;

    /** @var  string */
    protected $uri = '/authentication/account/login';

    /** @var  string */
    protected $method = 'POST';
}

<?php

namespace Etutorium\Endpoints;

/**
 * Class AddUser
 *
 * @category Etutorium
 * @package  Etutorium\Endpoints
 * @author   Alex Slubsky <aslubsky@gmail.com>
 */
class AddUser extends AbstractEndpoint
{
    /** @var  bool */
    protected $authRequired = true;

    /** @var  string */
    protected $uri = '/api/invite/register';
//    protected $uri = '/invite/register-participant';

    /** @var  string */
    protected $method = 'POST';
}

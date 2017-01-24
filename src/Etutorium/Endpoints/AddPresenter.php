<?php

namespace Etutorium\Endpoints;

/**
 * Class AddPresenter
 *
 * @category Etutorium
 * @package  Etutorium\Endpoints
 * @author   Alex Slubsky <aslubsky@gmail.com>
 */
class AddPresenter extends AbstractEndpoint
{
    /** @var  bool */
    protected $authRequired = true;

    /** @var  string */
    protected $uri = '/api/invite/register';
//    protected $uri = '/invite/register-participant';

    /** @var  string */
    protected $method = 'POST';
}

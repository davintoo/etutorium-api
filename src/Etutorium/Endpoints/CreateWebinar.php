<?php

namespace Etutorium\Endpoints;

/**
 * Class CreateWebinar
 *
 * @category Etutorium
 * @package  Etutorium\Endpoints
 * @author   Alex Slubsky <aslubsky@gmail.com>
 */
class CreateWebinar extends AbstractEndpoint
{
    /** @var  bool */
    protected $authRequired = true;

    /** @var  string */
    protected $uri = '/cabinet/webinar';

    /** @var  string */
    protected $method = 'POST';
}

<?php

namespace Etutorium\Endpoints;

/**
 * Class GetWebinar
 *
 * @category Etutorium
 * @package  Etutorium\Endpoints
 * @author   Alex Slubsky <aslubsky@gmail.com>
 */
class GetWebinar extends AbstractEndpoint
{
    /** @var  bool */
    protected $authRequired = true;

    /** @var  string */
    protected $uri = '/cabinet/webinar';

    /** @var  string */
    protected $method = 'GET';

    public function setId($id)
    {
        $this->uri = $this->uri . '/' . $id;
    }
}

<?php

namespace Etutorium\Endpoints;

/**
 * Class GetUserLink
 *
 * @category Etutorium
 * @package  Etutorium\Endpoints
 * @author   Alex Slubsky <aslubsky@gmail.com>
 */
class GetUserLink extends AbstractEndpoint
{
    /** @var  bool */
    protected $authRequired = true;

    /** @var  string */
    protected $uri = '/rest/participant';

    /** @var  string */
    protected $method = 'GET';

    public function setBody($body)
    {
        $this->uri = $this->uri . '?' . http_build_query($body);
        echo $this->uri . "\n";
    }
}

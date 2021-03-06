<?php

namespace Etutorium;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Class Transport
 *
 * @category Etutorium
 * @package  Etutorium
 * @author   Alex Slubsky <aslubsky@gmail.com>
 */
class Transport
{
    /** @var Client */
    protected $client;

    public function __construct($endPoint)
    {
        $this->client = new Client([
            'base_uri' => $endPoint
        ]);
    }

    private function _makeRequest($method, $uri, $params, $body = null, $token = null)
    {
        $headers = [
            'Accept' => 'application/json'
        ];
        if ($token) {
            $headers = [
                'X-ApiKey-Token' => $token
            ];
        }

        return new Request($method, $uri, $headers);
    }

    public function performRequest($method, $uri, $params, $body, $token = null)
    {
        $request = $this->_makeRequest($method, $uri, $params, $body, $token);
        $options = [];
        if($body) {
            $options['json'] = $body;
        }
        $res = $this->client->send($request, $options);
        return \GuzzleHttp\json_decode($res->getBody(), true);
    }
}

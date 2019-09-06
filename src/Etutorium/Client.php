<?php

namespace Etutorium;

use Etutorium\Endpoints\AbstractEndpoint;
use Etutorium\Exceptions\BaseException;
use Etutorium\Exceptions\FailedValidationException;

/**
 * Class Client
 *
 * @category Etutorium
 * @package  Etutorium
 * @author   Alex Slubsky <aslubsky@gmail.com>
 */
class Client
{
    /**
     * @var Transport
     */
    protected $transport;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var string
     */
    private $_apiToken = null;

    /**
     * Client constructor
     *
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->params = $params;//@todo add validation

        $this->transport = new Transport($this->params['endPoint']);
        $this->_apiToken = $this->params['apiToken'];
    }

    /**
     * @return array
     */
    public function getMyAccount()
    {
        $endpoint = new \Etutorium\Endpoints\MyAccount();
        return $this->performRequest($endpoint);
    }

    /**
     * @return array
     */
    public function getWebinar($webinarId)
    {
        $endpoint = new \Etutorium\Endpoints\GetWebinar();
        $endpoint->setId($webinarId);
        return $this->_checkResponse(
            $this->performRequest($endpoint)
        );
    }

    /**
     * @return array
     */
    public function createWebinar($params = [])
    {
        $endpoint = new \Etutorium\Endpoints\CreateWebinar();
        $endpoint->setBody($params);
        return $this->performRequest($endpoint);
    }

    /**
     * @return string|false
     */
    public function getUserLink($webinarId, $username)
    {
        $endpoint = new \Etutorium\Endpoints\GetUserLink();
        $endpoint->setBody([
            'webinar_id' => $webinarId,
            'username' => $username

        ]);
        $res = $this->_checkResponse(
            $this->performRequest($endpoint)
        );
        if ($res && count($res) > 0) {
            return 'https://room.etutorium.com/login/' . $res[0]['access_token'] . '/true';
        }
        return false;
    }

    /**
     * @return array
     */
    public function addUser($webinarId, $username, $userFirstName, $userSecondName)
    {
        $endpoint = new \Etutorium\Endpoints\AddUser();
        $endpoint->setBody([
            'webinarID' => $webinarId,
            'participants' => [
                [
                    'email' => $username,
                    'username' => $username,
                    'first_name' => $userFirstName,
                    'second_name' => $userSecondName,
                    'role' => 'listener'
                ]
            ],
            'role' => 'listener',
            'send_notification' => 0
        ]);
        return $this->_checkResponse(
            $this->performRequest($endpoint)
        );
    }

    /**
     * @return array
     */
    public function addPresenter($webinarId, $username, $userFirstName, $userSecondName)
    {
        $endpoint = new \Etutorium\Endpoints\AddPresenter();
        $endpoint->setBody([
            'webinarID' => $webinarId,
            'participants' => [
                [
                    'email' => $username,
                    'username' => $username,
                    'first_name' => $userFirstName,
                    'second_name' => $userSecondName,
                    'role' => 'presenter'
                ]
            ],
            'role' => 'presenter',
            'send_notification' => 0
        ]);
        return $this->_checkResponse(
            $this->performRequest($endpoint)
        );
    }

    /**
     * @return array
     */
    public function addModerator($webinarId, $username, $userFirstName, $userSecondName)
    {
        $endpoint = new \Etutorium\Endpoints\AddPresenter();
        $endpoint->setBody([
            'webinarID' => $webinarId,
            'participants' => [
                [
                    'email' => $username,
                    'username' => $username,
                    'first_name' => $userFirstName,
                    'second_name' => $userSecondName,
                    'role' => 'moderator'
                ]
            ],
            'role' => 'moderator',
            'send_notification' => 0
        ]);
        return $this->_checkResponse(
            $this->performRequest($endpoint)
        );
    }

    protected function _checkResponse($response)
    {
        if (isset($response['ok']) && $response['ok']) {
            return $response['response'];
        }
        $exception = new FailedValidationException('Invalid responce:' . print_r($response, true));
        $exception->setResponse($response);
        throw $exception;
    }

    /**
     * @param $endpoint AbstractEndpoint
     *
     * @return array
     * @throws BaseException
     */
    private function performRequest(AbstractEndpoint $endpoint)
    {
        return $this->transport->performRequest(
            $endpoint->getMethod(),
            $endpoint->getURI(),
            $endpoint->getParams(),
            $endpoint->getBody(),
            $this->_apiToken
        );
    }
}

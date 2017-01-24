<?php

namespace Etutorium;

use Etutorium\Endpoints\AbstractEndpoint;
use Etutorium\Exceptions\InvalidLoginException;

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
    private $_authToken = null;

    /**
     * Client constructor
     *
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->params = $params;//@todo add validation

        $this->transport = new Transport($this->params['endPoint']);
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
        return $this->_checkResponse(
            $this->performRequest($endpoint)
        );
    }

    /**
     * @return array
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
            return 'https://room.etutorium.com/login/' . $res['access_token'];
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
            'username' => $username,
            'first_name' => $userFirstName,
            'second_name' => $userSecondName,
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
    protected function login($username, $password)
    {
        $endpoint = new \Etutorium\Endpoints\Login();
        $endpoint->setBody([
            'username' => $username,
            'password' => $password
        ]);
        return $this->performRequest($endpoint);
    }

    private function _getTokenPath()
    {
        return $this->params['tokenStorePath'];
    }

    private function _getAuthToken()
    {
        if ($this->_authToken !== null) {
            return $this->_authToken;
        }
        if (file_exists($this->_getTokenPath())) {
            $this->_authToken = file_get_contents($this->_getTokenPath());
            return $this->_authToken;
        }
        return null;
    }

    private function _setAuthToken($token)
    {
        $this->_authToken = $token;
        file_put_contents($this->_getTokenPath(), $token);
    }

    private function _login($endpoint)
    {
        $token = $this->_getAuthToken();
        if (!$token) {
            $res = $this->login($this->params['username'], $this->params['password']);
            if ($res && $res['ok']) {
                $token = $res['response']['token'];
                $this->_setAuthToken($token);
            } else {
                throw new InvalidLoginException('Unable to authorize: ' . print_r($res, true));
            }
//                print_r($res);
//                exit;
        }
        return $token;
    }

    protected function _checkResponse($response)
    {
        if (isset($response['ok']) && $response['ok']) {
            return $response['response'];
        }
        throw new \Exception('Invalid responce:' . print_r($response, true));
    }

    /**
     * @param $endpoint AbstractEndpoint
     *
     * @throws \Exception
     * @return array
     */
    private function performRequest(AbstractEndpoint $endpoint)
    {
        try {
            $token = null;
            if ($endpoint->authRequired()) {
                $token = $this->_login($endpoint);
            }

            return $this->transport->performRequest(
                $endpoint->getMethod(),
                $endpoint->getURI(),
                $endpoint->getParams(),
                $endpoint->getBody(),
                $token
            );
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
//            print_r($ex);
            if ($ex->getResponse()->getStatusCode() == 401) {
                $this->_setAuthToken('');
                $token = $this->_login($endpoint);

                return $this->transport->performRequest(
                    $endpoint->getMethod(),
                    $endpoint->getURI(),
                    $endpoint->getParams(),
                    $endpoint->getBody(),
                    $token
                );
            } else {
                throw new \Exception($ex);
            }
        }
    }
}

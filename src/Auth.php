<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

use Guzzle\Http\ClientInterface;
use SWCO\AppNexusAPI\Exceptions\NoAuthException;

class Auth
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return ClientInterface
     * @throws \InvalidArgumentException
     */
    public function getClient()
    {
        if ($this->client === null) {
            throw new \InvalidArgumentException("`setClient()` must be called before `getClient()`");
        }

        return $this->client;
    }

    /**
     * @param            $username
     * @param            $password
     * @param \Exception $lastException
     * @throws Exceptions\NoAuthException
     * @return string The token
     */
    public function auth($username, $password, \Exception $lastException = null)
    {
        $request = $this->getClient()->post(
            "auth",
            null,
            json_encode(
                array("auth" => array("username" => $username, "password" => $password))
            )
        );
        $response = $request->send();
        $data     = $response->json();
        if (isset($data['response']['token'])) {
            return $data['response']['token'];
        } else {
            throw new NoAuthException("Auth Failed", 0, $lastException);
        }
    }
}

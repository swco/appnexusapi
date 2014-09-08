<?php

namespace SWCO\AppNexusAPI;

use Guzzle\Http\ClientInterface;

interface RequestInterface
{
    /**
     * @param string          $username
     * @param string          $password
     * @param null|string     $token
     * @param IServiceFactory $serviceFactory
     * @param ClientInterface $client
     * @param Auth            $auth
     */
    public function __construct(
        $username,
        $password,
        $token = null,
        IServiceFactory $serviceFactory = null,
        ClientInterface $client = null,
        Auth $auth = null
    );

    /**
     * @param string  $service
     * @param boolean $reset
     * @return $this
     * @throws Exceptions\BadServiceException
     */
    public function get($service, $reset = true);

    /**
     * @param string $key
     * @param string $val
     * @return $this
     */
    public function where($key, $val);

    /**
     * @param \DateTime $dateTime
     * @return $this
     */
    public function since(\DateTime $dateTime);

    /**
     * This method should no longer be called with an array of integers. This functionality will be removed in the next
     * major release. Please use `whereIds()` as a replacement.
     *
     * @param int|int[] $id
     * @return $this
     */
    public function whereId($id);

    /**
     * @param int[] $ids
     * @return $this
     */
    public function whereIds(array $ids);

    /**
     * @param int $offset
     * @return $this
     */
    public function offsetBy($offset);

    /**
     * @param int $limit
     * @return $this
     */
    public function limitBy($limit);

    /**
     * @param string $key
     * @param string $direction
     * @return $this
     */
    public function sortBy($key, $direction);

    /**
     * @return array
     */
    public function getFilter();

    /**
     * Reset the filter
     */
    public function reset();

    /**
     * @param array $postData
     * @return Response
     * @throws Exceptions\AppNexusAPIException
     * @throws \Exception
     */
    public function send(array $postData = array());

    /**
     * @param null|string $username
     * @param null|string $password
     * @param boolean     $storeToken
     * @return string
     */
    public function auth($username = null, $password = null, $storeToken = true);
} 

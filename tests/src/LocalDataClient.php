<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\RequestInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocalDataClient implements ClientInterface
{
    public function setConfig($config)
    {
        return $this;
    }

    public function getConfig($key = false)
    {
        return null;
    }

    public function createRequest(
        $method = RequestInterface::GET,
        $uri = null,
        $headers = null,
        $body = null,
        array $options = array()
    ) {
        return new LocalDataRequest();
    }

    public function get($uri = null, $headers = null, $options = array())
    {
        return new LocalDataRequest();
    }

    public function head($uri = null, $headers = null, array $options = array())
    {
        return new LocalDataRequest();
    }

    public function delete($uri = null, $headers = null, $body = null, array $options = array())
    {
        return null;
    }

    public function put($uri = null, $headers = null, $body = null, array $options = array())
    {
        return null;
    }

    public function patch($uri = null, $headers = null, $body = null, array $options = array())
    {
        return null;
    }

    public function post($uri = null, $headers = null, $postBody = null, array $options = array())
    {
        return null;
    }

    public function options($uri = null, array $options = array())
    {
        return new LocalDataRequest();
    }

    public function send($requests)
    {
        return new LocalDataRequest();
    }

    public function getBaseUrl($expand = true)
    {
        return null;
    }

    public function setBaseUrl($url)
    {
        return $this;
    }

    public function setUserAgent($userAgent, $includeDefault = false)
    {
        return $this;
    }

    public function setSslVerification($certificateAuthority = true, $verifyPeer = true, $verifyHost = 2)
    {
        return $this;
    }

    public static function getAllEvents()
    {
        return array();
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        return $this;
    }

    public function getEventDispatcher()
    {
        return null;
    }

    public function dispatch($eventName, array $context = array())
    {
        return null;
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        return $this;
    }
}

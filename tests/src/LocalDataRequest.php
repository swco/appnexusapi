<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\Header;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocalDataRequest implements  RequestInterface
{

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

    public function getParams()
    {
        return null;
    }

    public function addHeader($header, $value)
    {
        return $this;
    }

    public function addHeaders(array $headers)
    {
        return $this;
    }

    public function getHeader($header)
    {
        return null;
    }

    public function getHeaders()
    {
        return null;
    }

    public function hasHeader($header)
    {
        return false;
    }

    public function removeHeader($header)
    {
        return $this;
    }

    public function setHeader($header, $value)
    {
        return $this;
    }

    public function setHeaders(array $headers)
    {
        return $this;
    }

    public function getHeaderLines()
    {
        return array();
    }

    public function getRawHeaders()
    {
        return '';
    }

    public function send()
    {
        return new LocalDataResponse();
    }

    public function setClient(ClientInterface $client)
    {
        return $this;
    }

    public function getClient()
    {
        return null;
    }

    public function setUrl($url)
    {
        return $this;
    }

    public function getUrl($asObject = false)
    {
        return '';
    }

    public function getResource()
    {
        return '';
    }

    public function getQuery()
    {
        return null;
    }

    public function getMethod()
    {
        return '';
    }

    public function getScheme()
    {
        return '';
    }

    public function setScheme($scheme)
    {
        return $this;
    }

    public function getHost()
    {
        return '';
    }

    public function setHost($host)
    {
        return $this;
    }

    public function getPath()
    {
        return '';
    }

    public function setPath($path)
    {
        return $this;
    }

    public function getPort()
    {
        return null;
    }

    public function setPort($port)
    {
        return $this;
    }

    public function getUsername()
    {
        return '';
    }

    public function getPassword()
    {
        return '';
    }

    public function setAuth($user, $password = '', $scheme = 'Basic')
    {
        return $this;
    }

    public function getProtocolVersion()
    {
        return '';
    }

    public function setProtocolVersion($protocol)
    {
        return $this;
    }

    public function getResponse()
    {
        return new LocalDataResponse();
    }

    public function setResponse(Response $response, $queued = false)
    {
        return $this;
    }

    public function startResponse(Response $response)
    {
        return $this;
    }

    public function setResponseBody($body)
    {
        return $this;
    }

    public function getResponseBody()
    {
        return null;
    }

    public function getState()
    {
        return '';
    }

    public function setState($state, array $context = array())
    {
        return '';
    }

    public function getCurlOptions()
    {
        return null;
    }

    public function getCookies()
    {
        return array();
    }

    public function getCookie($name)
    {
        return null;
    }

    public function addCookie($name, $value)
    {
        return $this;
    }

    public function removeCookie($name)
    {
        return $this;
    }

    public function __toString()
    {
        return '';
    }
}

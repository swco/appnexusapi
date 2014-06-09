<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use Guzzle\Http\Message\Header;
use Guzzle\Http\Message\MessageInterface;

class LocalDataResponse implements MessageInterface
{
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

    public function json()
    {
        return '';
    }
}

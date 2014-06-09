<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use SWCO\AppNexusAPI\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    private function getRequest()
    {
        return new Request('username', 'password', 'token', null, new LocalDataClient());
    }

    private function getBadResponseData()
    {
        return require __DIR__ . '/data/error-responses.php';
    }

    /**
     * @expectedException        \SWCO\AppNexusAPI\Exceptions\BadServiceException
     * @expectedExceptionMessage Unrecognised service [foo]
     */
    public function testExceptionThrowWhenBadServiceUsed()
    {
        $this->getRequest()->get('foo');
    }

    /**
     * @expectedException        \SWCO\AppNexusAPI\Exceptions\BadServiceException
     * @expectedExceptionMessage [device-make] does not support `since()`
     */
    public function testExceptionThrowWhenAttemptToUseSinceWithNoSupport()
    {
        $this->getRequest()->get(Request::SERVICE_DEVICE_MAKE)->since(new \DateTime())->send();
    }

    /**
     * @expectedException        \SWCO\AppNexusAPI\Exceptions\BadServiceException
     * @expectedExceptionMessage A service must be set via `get($service)` before calling [send]
     */
    public function testExceptionThrowWhenNoServiceSet()
    {
        $this->getRequest()->send();
    }

    /**
     * @expectedException        \SWCO\AppNexusAPI\Exceptions\AppNexusAPIException
     * @expectedExceptionMessage Call failed with no status.
     */
    public function testExceptionThrowWhenNoStatusAndNoError()
    {
        $errorResponses = $this->getBadResponseData();

        $stubLocalDataResponse = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataResponse');
        $stubLocalDataResponse->expects($this->once())
            ->method('json')
            ->will($this->returnValue(json_decode($errorResponses['no-status-no-error'], true)));

        $stubLocalDataRequest = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataRequest');
        $stubLocalDataRequest->expects($this->once())
            ->method('send')
            ->will($this->returnValue($stubLocalDataResponse));

        $stubLocalDataClient = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataClient');
        $stubLocalDataClient->expects($this->once())
            ->method('get')
            ->will($this->returnValue($stubLocalDataRequest));

        $request = new Request('username', 'password', 'token', null, $stubLocalDataClient);

        $request->get(Request::SERVICE_BRAND)->send();
    }

    /**
     * @expectedException        \SWCO\AppNexusAPI\Exceptions\AppNexusAPIException
     * @expectedExceptionMessage Call failed with error [123: ERROR]
     */
    public function testExceptionThrowWhenNoStatusWithError()
    {
        $errorResponses = $this->getBadResponseData();

        $stubLocalDataResponse = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataResponse');
        $stubLocalDataResponse->expects($this->once())
            ->method('json')
            ->will($this->returnValue(json_decode($errorResponses['no-status-with-error'], true)));

        $stubLocalDataRequest = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataRequest');
        $stubLocalDataRequest->expects($this->once())
            ->method('send')
            ->will($this->returnValue($stubLocalDataResponse));

        $stubLocalDataClient = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataClient');
        $stubLocalDataClient->expects($this->once())
            ->method('get')
            ->will($this->returnValue($stubLocalDataRequest));

        $request = new Request('username', 'password', 'token', null, $stubLocalDataClient);

        $request->get(Request::SERVICE_BRAND)->send();
    }

    public function testGetSingleServiceHelper()
    {
        $categorySixJson = require __DIR__ . '/data/category6.php';

        $stubLocalDataResponse = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataResponse');
        $stubLocalDataResponse->expects($this->once())
            ->method('json')
            ->will($this->returnValue(json_decode($categorySixJson, true)));

        $stubLocalDataRequest = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataRequest');
        $stubLocalDataRequest->expects($this->once())
            ->method('send')
            ->will($this->returnValue($stubLocalDataResponse));

        $stubLocalDataClient = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataClient');
        $stubLocalDataClient->expects($this->once())
            ->method('get')
            ->will($this->returnValue($stubLocalDataRequest));

        $request = new Request('username', 'password', 'token', null, $stubLocalDataClient);

        $response = $request->getCategory(6);

        $this->assertInstanceOf('\SWCO\AppNexusAPI\Services\Category', $response);
    }
}

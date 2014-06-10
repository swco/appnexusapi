<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use SWCO\AppNexusAPI\Request;

class ResponseTest extends ServicesDataProvider
{
    public function testResponseMethods()
    {
        $categoryData = $this->getData('category');

        $stubLocalDataResponse = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataResponse');
        $stubLocalDataResponse->expects($this->once())
            ->method('json')
            ->will($this->returnValue($categoryData));

        $stubLocalDataRequest = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataRequest');
        $stubLocalDataRequest->expects($this->once())
            ->method('send')
            ->will($this->returnValue($stubLocalDataResponse));

        $stubLocalDataClient = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataClient');
        $stubLocalDataClient->expects($this->once())
            ->method('get')
            ->will($this->returnValue($stubLocalDataRequest));

        $request  = new Request('username', 'password', 'token', null, $stubLocalDataClient);
        $response = $request->get(Request::SERVICE_CATEGORY)->send();

        $this->assertEquals($categoryData['response']['status'], $response->getStatus());
        $this->assertEquals($categoryData['response']['start_element'], $response->getStartElement());
        $this->assertEquals($categoryData['response']['count'], $response->getCount());
        $this->assertEquals(count($categoryData['response']['categories']), $response->getNumElements());
    }
}

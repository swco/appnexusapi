<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use SWCO\AppNexusAPI\DataPool;
use SWCO\AppNexusAPI\Request;

class DataPoolTest extends ServicesDataProvider
{
    public function testDataPool()
    {
        $stubLocalDataResponse = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataResponse');
        $stubLocalDataResponse->expects($this->exactly(2))
            ->method('json')
            ->will($this->onConsecutiveCalls($this->getData('device-make'), $this->getData('device-make-100')));

        $stubLocalDataRequest = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataRequest');
        $stubLocalDataRequest->expects($this->exactly(2))
            ->method('send')
            ->will($this->returnValue($stubLocalDataResponse));

        $stubLocalDataClient = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataClient');
        $stubLocalDataClient->expects($this->exactly(2))
            ->method('get')
            ->will($this->returnValue($stubLocalDataRequest));

        $request = new Request('username', 'password', 'token', null, $stubLocalDataClient);

        $request->get(Request::SERVICE_DEVICE_MAKE);

        $dataPool = new DataPool();

        $data = $dataPool->get($request, 200);
        $this->assertEquals(200, $data->getNumElements());
    }

    public function testDataPoolWithOffset()
    {
        $stubLocalDataResponse = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataResponse');
        $stubLocalDataResponse->expects($this->once())
            ->method('json')
            ->will($this->returnValue($this->getData('device-make-100')));

        $stubLocalDataRequest = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataRequest');
        $stubLocalDataRequest->expects($this->once())
            ->method('send')
            ->will($this->returnValue($stubLocalDataResponse));

        $stubLocalDataClient = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataClient');
        $stubLocalDataClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('/device-make?start_element=100&num_elements=100'),
                $this->anything()
            )
            ->will($this->returnValue($stubLocalDataRequest));

        $request = new Request('username', 'password', 'token', null, $stubLocalDataClient);

        $request->get(Request::SERVICE_DEVICE_MAKE)->offsetBy(100);

        $dataPool = new DataPool();

        $data = $dataPool->get($request, 100, true);
        $this->assertEquals(100, $data->getNumElements());
    }
}

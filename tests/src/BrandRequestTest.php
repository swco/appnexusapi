<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use SWCO\AppNexusAPI\BrandRequest;
use SWCO\AppNexusAPI\Request;

class BrandRequestTest extends ServicesDataProvider
{
    public function testSimpleFilter()
    {
        $brandRequest = BrandRequest::newFromRequest($this->getRequest());
        $this->assertEquals(array(), $brandRequest->getFilter());

        $brandRequest->where('foo', 'bar');
        $this->assertEquals(array('foo' => 'bar'), $brandRequest->getFilter());

        $brandRequest->reset();
        $this->assertEquals(array(), $brandRequest->getFilter());

        $brandRequest->simple();
        $this->assertEquals(array('simple' => 'true'), $brandRequest->getFilter());
        $brandRequest->reset();

        $brandRequest->simple()->offsetBy(5)->limitBy(5)->sortBy('id', 'desc')->whereId(5);
        $this->assertEquals(
            array(
                'simple'        => 'true',
                'start_element' => 5,
                'num_elements'  => 5,
                'sort'          => 'id.desc',
                'id'            => 5,
            ),
            $brandRequest->getFilter()
        );
    }

    public function testNewCollections()
    {
        $stubLocalDataResponse = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataResponse');
        $stubLocalDataResponse->expects($this->once())
            ->method('json')
            ->will($this->returnValue($this->getData('brand-simple')));

        $stubLocalDataRequest = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataRequest');
        $stubLocalDataRequest->expects($this->once())
            ->method('send')
            ->will($this->returnValue($stubLocalDataResponse));

        $stubLocalDataClient = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataClient');

        $stubLocalDataClient->expects($this->once())
            ->method('get')
            ->will($this->returnValue($stubLocalDataRequest));

        $request = BrandRequest::newFromRequest(
            new Request('username', 'password', 'token', null, $stubLocalDataClient)
        );

        $services = $request->getBrands();

        foreach($services as $service) {
            $this->assertInstanceOf('\SWCO\AppNexusAPI\Services\Brand', $service);
            $this->assertEquals(0, $service->getNumCreatives());
        }
    }
}

<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use Guzzle\Http\ClientInterface;
use SWCO\AppNexusAPI\BrandRequest;
use SWCO\AppNexusAPI\Request;

class BrandRequestTest extends ServicesDataProvider
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ClientInterface
     */
    private function getMockLocalDataClient()
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

        return $stubLocalDataClient;
    }

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
        $request = BrandRequest::newFromRequest(
            new Request('username', 'password', 'token', null, $this->getMockLocalDataClient())
        );

        $services = $request->getBrands();

        foreach($services as $service) {
            $this->assertInstanceOf('\SWCO\AppNexusAPI\Services\Brand', $service);
            $this->assertEquals(0, $service->getNumCreatives());
        }
    }

    public function testSimpleBrandRequests()
    {
        $request = BrandRequest::newFromRequest(
            new Request('username', 'password', 'token', null, $this->getMockLocalDataClient())
        );
        $request->getBrand(1, true);
        $filter = $request->getFilter();
        $this->assertTrue(isset($filter['simple']));

        $request = BrandRequest::newFromRequest(
            new Request('username', 'password', 'token', null, $this->getMockLocalDataClient())
        );
        $request->getBrand(1);
        $filter = $request->getFilter();
        $this->assertFalse(isset($filter['simple']));

        $request = BrandRequest::newFromRequest(
            new Request('username', 'password', 'token', null, $this->getMockLocalDataClient())
        );
        $request->getBrands(true);
        $filter = $request->getFilter();
        $this->assertTrue(isset($filter['simple']));

        $request = BrandRequest::newFromRequest(
            new Request('username', 'password', 'token', null, $this->getMockLocalDataClient())
        );
        $request->getBrands();
        $filter = $request->getFilter();
        $this->assertFalse(isset($filter['simple']));
    }
}

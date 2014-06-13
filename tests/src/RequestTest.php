<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use SWCO\AppNexusAPI\Request;

class RequestTest extends ServicesDataProvider
{
    private function getBadResponseData()
    {
        return require dirname(__DIR__) . '/data/error-responses.php';
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
     * @expectedExceptionMessage A service must be set via `get($service)` before calling [buildRequestObject]
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
        $stubLocalDataResponse = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataResponse');
        $stubLocalDataResponse->expects($this->once())
            ->method('json')
            ->will($this->returnValue($this->getData('category6')));

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

    public function testFilter()
    {
        $request = $this->getRequest();
        $this->assertEquals(array(), $request->getFilter());

        $request->where('foo', 'bar');
        $this->assertEquals(array('foo' => 'bar'), $request->getFilter());

        $request->reset();
        $this->assertEquals(array(), $request->getFilter());

        $dateTime = new \DateTime();
        $request->since($dateTime);
        $this->assertEquals(array('since' => $dateTime->format('Y-m-d H:i:s')), $request->getFilter());
        $request->reset();

        $request->offsetBy(5);
        $this->assertEquals(array('start_element' => 5), $request->getFilter());
        $request->reset();

        $request->limitBy(5);
        $this->assertEquals(array('num_elements' => 5), $request->getFilter());
        $request->reset();

        $request->whereId(5);
        $this->assertEquals(array('id' => 5), $request->getFilter());
        $request->reset();

        // temp support
        $request->whereId(array(3,5,7));
        $this->assertEquals(array('id' => '3,5,7'), $request->getFilter());
        $request->reset();

        $request->whereIds(array(3,5,7));
        $this->assertEquals(array('id' => '3,5,7'), $request->getFilter());
        $request->reset();

        $request->sortBy('id', 'desc');
        $this->assertEquals(array('sort' => 'id.desc'), $request->getFilter());
        $request->reset();

        $request->where('foo', 'bar')->since($dateTime)->offsetBy(5)->limitBy(5)->sortBy('id', 'desc')->whereId(5);
        $this->assertEquals(
            array(
                'foo'           => 'bar',
                'since'         => $dateTime->format('Y-m-d H:i:s'),
                'start_element' => 5,
                'num_elements'  => 5,
                'sort'          => 'id.desc',
                'id'            => 5,
            ),
            $request->getFilter()
        );
    }

    public function testSinceKey()
    {
        $stubLocalDataResponse = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataResponse');
        $stubLocalDataResponse->expects($this->once())
            ->method('json')
            ->will($this->returnValue(json_decode(require dirname(__DIR__) . '/data/category.php', true)));

        $stubLocalDataRequest = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataRequest');
        $stubLocalDataRequest->expects($this->once())
            ->method('send')
            ->will($this->returnValue($stubLocalDataResponse));

        $dateTime = \DateTime::createFromFormat("Y-m-d H:i:s", "2014-00-00 00:00:00");

        $stubLocalDataClient = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataClient');
        $stubLocalDataClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo(
                    sprintf('/category?min_last_modified=%s', urlencode($dateTime->format("Y-m-d H:i:s")))),
                $this->anything()
            )
            ->will($this->returnValue($stubLocalDataRequest));

        $request = new Request('username', 'password', 'token', null, $stubLocalDataClient);

        $request->get(Request::SERVICE_CATEGORY)->since($dateTime)->send();
    }

    /**
     * @dataProvider newInstanceDataProvider
     */
    public function testNewCollections($class, $file, $key, $method)
    {
        $fullClass = sprintf('\SWCO\AppNexusAPI\Services\%s', $class);

        $stubLocalDataResponse = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataResponse');
        $stubLocalDataResponse->expects($this->once())
            ->method('json')
            ->will($this->returnValue($this->getData($file)));

        $stubLocalDataRequest = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataRequest');
        $stubLocalDataRequest->expects($this->once())
            ->method('send')
            ->will($this->returnValue($stubLocalDataResponse));

        $stubLocalDataClient = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataClient');

        $stubLocalDataClient->expects($this->once())
            ->method($class === 'DomainAuditStatus' ? 'post' : 'get')
            ->will($this->returnValue($stubLocalDataRequest));

        $request = new Request('username', 'password', 'token', null, $stubLocalDataClient);

        if ($class === 'DomainAuditStatus') {
            $services = call_user_func(array($request, $method), array());
        } else {
            $services = call_user_func(array($request, $method));
        }

        foreach($services as $service) {
            $this->assertInstanceOf($fullClass, $service);
        }
    }

    public function testAuth()
    {
        $stubLocalDataResponse = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataResponse');
        $stubLocalDataResponse->expects($this->once())
            ->method('json')
            ->will($this->returnValue(array('response' => array('token' => 'the-token'))));

        $stubLocalDataRequest = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataRequest');
        $stubLocalDataRequest->expects($this->once())
            ->method('send')
            ->will($this->returnValue($stubLocalDataResponse));

        $stubLocalDataClient = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataClient');
        $stubLocalDataClient->expects($this->once())
            ->method('post')
            ->will($this->returnValue($stubLocalDataRequest));

        $request = new Request('username', 'password', null, null, $stubLocalDataClient);
        $this->assertEquals('the-token', $request->auth());
    }
}

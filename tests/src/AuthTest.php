<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use SWCO\AppNexusAPI\Auth;

class AuthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage `setClient()` must be called before `getClient()`
     */
    public function testExceptionThrownWhenClientNotSet()
    {
        $auth = new Auth();
        $auth->getClient();
    }

    /**
     * @expectedException        \SWCO\AppNexusAPI\Exceptions\NoAuthException
     * @expectedExceptionMessage Auth Failed
     */
    public function testExceptionThrownOnAuthFail()
    {
        $stubLocalDataResponse = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataResponse');
        $stubLocalDataResponse->expects($this->once())
            ->method('json')
            ->will($this->returnValue(array()));

        $stubLocalDataRequest = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataRequest');
        $stubLocalDataRequest->expects($this->once())
            ->method('send')
            ->will($this->returnValue($stubLocalDataResponse));

        $stubLocalDataClient = $this->getMock('\SWCO\AppNexusAPI\Tests\LocalDataClient');
        $stubLocalDataClient->expects($this->once())
            ->method('post')
            ->will($this->returnValue($stubLocalDataRequest));

        $auth = new Auth();
        $auth->setClient($stubLocalDataClient);
        $auth->auth('username', 'password');
    }

    public function testTokenReturnedOnSuccess()
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

        $auth = new Auth();
        $auth->setClient($stubLocalDataClient);
        $this->assertEquals('the-token', $auth->auth('username', 'password'));
    }
}

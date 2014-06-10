<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

class AbstractCoreServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnValues()
    {
        $stub = $this->getMockForAbstractClass('\SWCO\AppNexusAPI\AbstractCoreService');

        $this->assertInternalType('bool', $stub->supportsSince());
        $this->assertInternalType('string', $stub->getRequestVerb());
    }
}

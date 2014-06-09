<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

class AbstractGetServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnValues()
    {
        $stub = $this->getMockForAbstractClass('\SWCO\AppNexusAPI\AbstractGetService');

        $this->assertInternalType('bool', $stub->supportsSince());
        $this->assertInternalType('bool', $stub->needsPost());
    }
}

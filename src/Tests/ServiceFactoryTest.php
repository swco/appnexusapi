<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use SWCO\AppNexusAPI\ServiceFactory;

class ServiceFactoryTest extends ServicesDataProvider
{
    private function getServiceFactory()
    {
        return new ServiceFactory();
    }

    /**
     * @dataProvider newInstanceDataProvider
     */
    public function testNewInstances($class)
    {
        $this->assertInstanceOf(
            sprintf('\SWCO\AppNexusAPI\Services\%s', $class),
            call_user_func(
                array(
                    $this->getServiceFactory(),
                    sprintf('new%sInstance', $class)
                )
            )
        );
    }

    /**
     * @dataProvider newInstanceDataProvider
     */
    public function testNewCollections($class, $file, $key)
    {
        $fullClass = sprintf('\SWCO\AppNexusAPI\Services\%s', $class);
        $services  = call_user_func(
            array(
                $this->getServiceFactory(),
                sprintf('new%sCollection', $class)
            ),
            $this->getData($file, $key)
        );

        foreach($services as $service) {
            $this->assertInstanceOf($fullClass, $service);
        }
    }
}

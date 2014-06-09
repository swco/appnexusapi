<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use SWCO\AppNexusAPI\ServiceFactory;

class ServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    private function getData($fileName, $sectionKey = null)
    {
        $json    = require __DIR__ . sprintf("/data/%s.php", $fileName);
        $dataArr = json_decode($json, true);

        return $sectionKey ? $dataArr['response'][$sectionKey] : $dataArr;
    }

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

    public function newInstanceDataProvider()
    {
        return array(
            array(
                'class' => 'Brand',
                'file'  => 'brand',
                'key'   => 'brands',
            ),
            array(
                'class' => 'Carrier',
                'file'  => 'carrier',
                'key'   => 'carriers',
            ),
            array(
                'class' => 'Category',
                'file'  => 'category',
                'key'   => 'categories',
            ),
            array(
                'class' => 'DeviceMake',
                'file'  => 'device-make',
                'key'   => 'device-makes',
            ),
            array(
                'class' => 'DeviceModel',
                'file'  => 'device-model',
                'key'   => 'device-models',
            ),
            array(
                'class' => 'DomainAuditStatus',
                'file'  => 'domain-audit-status',
                'key'   => 'urls',
            ),
            array(
                'class' => 'Language',
                'file'  => 'language',
                'key'   => 'languages',
            ),
            array(
                'class' => 'OperatingSystem',
                'file'  => 'operating-system',
                'key'   => 'operating-systems',
            ),
            array(
                'class' => 'PlatformMember',
                'file'  => 'platform-member',
                'key'   => 'platform-members',
            ),
            array(
                'class' => 'TechnicalAttribute',
                'file'  => 'technical-attribute',
                'key'   => 'technical-attributes',
            ),
        );
    }
}

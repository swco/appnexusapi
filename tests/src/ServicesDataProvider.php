<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests;

use SWCO\AppNexusAPI\Request;

abstract class ServicesDataProvider extends \PHPUnit_Framework_TestCase
{
    protected function getData($fileName, $sectionKey = null)
    {
        $json    = require dirname(__DIR__) . sprintf("/data/%s.php", $fileName);
        $dataArr = json_decode($json, true);

        return $sectionKey ? $dataArr['response'][$sectionKey] : $dataArr;
    }

    protected function getRequest()
    {
        return new Request('username', 'password', 'token', null, new LocalDataClient());
    }

    public function newInstanceDataProvider()
    {
        return array(
            array(
                'class' => 'Brand',
                'file'  => 'brand',
                'key'   => 'brands',
                'get'   => 'getBrands',
            ),
            array(
                'class' => 'Carrier',
                'file'  => 'carrier',
                'key'   => 'carriers',
                'get'   => 'getCarriers',
            ),
            array(
                'class' => 'Category',
                'file'  => 'category',
                'key'   => 'categories',
                'get'   => 'getCategories',
            ),
            array(
                'class' => 'DeviceMake',
                'file'  => 'device-make',
                'key'   => 'device-makes',
                'get'   => 'getDeviceMakes',
            ),
            array(
                'class' => 'DeviceModel',
                'file'  => 'device-model',
                'key'   => 'device-models',
                'get'   => 'getDeviceModels',
            ),
            array(
                'class' => 'DomainAuditStatus',
                'file'  => 'domain-audit-status',
                'key'   => 'urls',
                'get'   => 'getDomainAuditStatuses',
            ),
            array(
                'class' => 'Language',
                'file'  => 'language',
                'key'   => 'languages',
                'get'   => 'getLanguages',
            ),
            array(
                'class' => 'OperatingSystem',
                'file'  => 'operating-system',
                'key'   => 'operating-systems',
                'get'   => 'getOperatingSystems',
            ),
            array(
                'class' => 'PlatformMember',
                'file'  => 'platform-member',
                'key'   => 'platform-members',
                'get'   => 'getPlatformMembers',
            ),
            array(
                'class' => 'TechnicalAttribute',
                'file'  => 'technical-attribute',
                'key'   => 'technical-attributes',
                'get'   => 'getTechnicalAttributes',
            ),
        );
    }
}

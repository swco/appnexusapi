<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests\Services;

use SWCO\AppNexusAPI\Services\Brand;
use SWCO\AppNexusAPI\Services\Carrier;
use SWCO\AppNexusAPI\Services\Category;
use SWCO\AppNexusAPI\Services\DeviceMake;
use SWCO\AppNexusAPI\Services\DeviceModel;
use SWCO\AppNexusAPI\Services\DomainAuditStatus;

class ServicesTest extends \PHPUnit_Framework_TestCase
{
    private function getData($fileName, $sectionKey = null)
    {
        $json    = require dirname(__DIR__) . sprintf("/data/%s.php", $fileName);
        $dataArr = json_decode($json, true);

        return $sectionKey ? $dataArr['response'][$sectionKey] : $dataArr;
    }

    private function getArray($data)
    {
        return is_array($data) ? $data : array();
    }

    public function testBrandServiceImport()
    {
        foreach ($this->getData('brand', 'brands') as $data) {
            $obj = new Brand();
            $obj->import($data);

            $this->assertEquals($data['id'], $obj->getId());
            $this->assertEquals($data['name'], $obj->getName());
            $this->assertCount(count($this->getArray($data['urls'])), $obj->getUrls());
            $this->assertEquals($data['category_id'], $obj->getCategoryId());
            $this->assertEquals($data['company_id'], $obj->getCompanyId());
            $this->assertEquals(new \DateTime($data['last_modified']), $obj->getLastModified());
            $this->assertEquals($data['num_creatives'], $obj->getNumCreatives());
            $this->assertEquals($data['is_premium'], $obj->isPremium());

            $this->assertInternalType('int', $obj->getId());
            $this->assertInternalType('string', $obj->getName());
            $this->assertInternalType('array', $obj->getUrls());
            $this->assertInternalType('int', $obj->getCategoryId());
            $this->assertInternalType('int', $obj->getCompanyId());
            $this->assertInstanceOf('\DateTime', $obj->getLastModified());
            $this->assertInternalType('int', $obj->getNumCreatives());
            $this->assertInternalType('bool', $obj->isPremium());
        }
    }

    public function testCarrierServiceImport()
    {
        foreach ($this->getData('carrier', 'carriers') as $data) {
            $obj = new Carrier();
            $obj->import($data);

            $this->assertEquals($data['id'], $obj->getId());
            $this->assertEquals($data['name'], $obj->getName());
            $this->assertCount(count($this->getArray($data['codes'])), $obj->getCodes());
            $this->assertEquals($data['country_code'], $obj->getCountryCode());
            $this->assertEquals($data['country_name'], $obj->getCountryName());

            $this->assertInternalType('int', $obj->getId());
            $this->assertInternalType('string', $obj->getName());
            $this->assertInternalType('array', $obj->getCodes());
            $this->assertInternalType('string', $obj->getCountryCode());
            $this->assertInternalType('string', $obj->getCountryName());
        }
    }

    public function testCategoryServiceImport()
    {
        foreach ($this->getData('category', 'categories') as $data) {
            $obj = new Category();
            $obj->import($data);

            $this->assertEquals($data['id'], $obj->getId());
            $this->assertEquals($data['is_brand_eligible'], $obj->isBrandEligible());
            $this->assertCount(count($this->getArray($data['whitelist']['countries'])), $obj->getCountries());
            $this->assertCount(
                count($this->getArray($data['whitelist']['countries_and_brands'])),
                $obj->getCountriesBrands()
            );
            $this->assertEquals(new \DateTime($data['last_modified']), $obj->getLastModified());
            $this->assertEquals($data['name'], $obj->getName());
            $this->assertCount(
                count($this->getArray($data['whitelist']['regions_and_brands'])),
                $obj->getRegionsBrands()
            );
            $this->assertEquals($data['requires_whitelist'], $obj->requiresWhitelist());
            $this->assertEquals($data['requires_whitelist_on_external'], $obj->requiresWhitelistOnExternal());
            $this->assertEquals($data['requires_whitelist_on_managed'], $obj->requiresWhitelistOnManaged());
            $this->assertEquals($data['is_sensitive'], $obj->isSensitive());

            $this->assertInternalType('int', $obj->getId());
            $this->assertInternalType('bool', $obj->isBrandEligible());
            $this->assertInternalType('array', $obj->getCountries());
            $this->assertInternalType('array', $obj->getCountriesBrands());
            $this->assertInstanceOf('\DateTime', $obj->getLastModified());
            $this->assertInternalType('string', $obj->getName());
            $this->assertInternalType('array', $obj->getRegionsBrands());
            $this->assertInternalType('bool', $obj->requiresWhitelist());
            $this->assertInternalType('bool', $obj->requiresWhitelistOnExternal());
            $this->assertInternalType('bool', $obj->requiresWhitelistOnManaged());
            $this->assertInternalType('bool', $obj->isSensitive());
        }
    }

    public function testDeviceMakeServiceImport()
    {
        foreach ($this->getData('device-make', 'device-makes') as $data) {
            $obj = new DeviceMake();
            $obj->import($data);

            $this->assertEquals($data['id'], $obj->getId());
            $this->assertEquals($data['name'], $obj->getName());
            $this->assertCount(count($this->getArray($data['codes'])), $obj->getCodes());

            $this->assertInternalType('int', $obj->getId());
            $this->assertInternalType('string', $obj->getName());
            $this->assertInternalType('array', $obj->getCodes());
        }
    }

    public function testDeviceModelServiceImport()
    {
        foreach ($this->getData('device-model', 'device-models') as $data) {
            $obj = new DeviceModel();
            $obj->import($data);

            $this->assertEquals($data['id'], $obj->getId());
            $this->assertEquals($data['name'], $obj->getName());
            $this->assertCount(
                count($this->getArray(isset($data['codes']) ? $data['codes'] : array())), $obj->getCodes()
            );
            $this->assertEquals($data['device_make_id'], $obj->getDeviceMakeId());
            $this->assertEquals($data['device_type'], $obj->getDeviceType());
            $this->assertEquals($data['screen_height'], $obj->getScreenHeight());
            $this->assertEquals($data['screen_width'], $obj->getScreenWidth());

            $this->assertInternalType('int', $obj->getId());
            $this->assertInternalType('string', $obj->getName());
            $this->assertInternalType('array', $obj->getCodes());
            $this->assertInternalType('int', $obj->getDeviceMakeId());
            $this->assertInternalType('string', $obj->getDeviceType());
            $this->assertInternalType('int', $obj->getScreenHeight());
            $this->assertInternalType('int', $obj->getScreenWidth());
        }
    }

    public function testDomainAuditStatusServiceImport()
    {
        foreach ($this->getData('domain-audit-status', 'urls') as $data) {
            $obj = new DomainAuditStatus();
            $obj->import($data);

            $this->assertEquals($data['id'], $obj->getId());
            $this->assertEquals(new \DateTime($data['audit_datetime']), $obj->getAuditDatetime());
            $this->assertEquals($data['audit_status'], $obj->getAuditStatus());
            $this->assertEquals($data['content_category_id'], $obj->getContendCategoryId());
            $this->assertEquals($data['found'], $obj->isFound());
            $this->assertEquals($data['intended_audience'], $obj->getIntendedAudience());
            $this->assertEquals($data['reason'], $obj->getReason());
            $this->assertEquals($data['url'], $obj->getUrl());

            $this->assertInternalType('int', $obj->getId());
            $this->assertInstanceOf('\DateTime', $obj->getAuditDatetime());
            $this->assertInternalType('string', $obj->getAuditStatus());
            $this->assertInternalType('int', $obj->getContendCategoryId());
            $this->assertInternalType('bool', $obj->isFound());
            $this->assertInternalType('string', $obj->getIntendedAudience());
            $this->assertInternalType('string', $obj->getReason());
            $this->assertInternalType('string', $obj->getUrl());
        }
    }
}

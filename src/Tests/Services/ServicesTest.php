<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests\Services;

use SWCO\AppNexusAPI\Services\Brand;
use SWCO\AppNexusAPI\Services\Carrier;

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
}

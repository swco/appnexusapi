<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Tests\Services;

use SWCO\AppNexusAPI\Services\Brand;

class ServicesTest extends \PHPUnit_Framework_TestCase
{
    public function testBrandServiceImport()
    {
        $brandJSON = require dirname(__DIR__ ). '/data/brand.php';
        $brandData = json_decode($brandJSON, true);

        $brand = $brandData['response']['brands'][0];

        $brandObj = new Brand();
        $brandObj->import($brand);

        $this->assertEquals($brand['id'], $brandObj->getId());
        $this->assertEquals($brand['name'], $brandObj->getName());
        $this->assertEquals(is_array($brand['urls']) ? $brand['urls'] : array(), $brandObj->getUrls());
        $this->assertEquals($brand['category_id'], $brandObj->getCategoryId());
        $this->assertEquals($brand['company_id'], $brandObj->getCompanyId());
        $this->assertEquals(new \DateTime($brand['last_modified']), $brandObj->getLastModified());
        $this->assertEquals($brand['num_creatives'], $brandObj->getNumCreatives());
        $this->assertEquals($brand['is_premium'], $brandObj->isPremium());
    }
}

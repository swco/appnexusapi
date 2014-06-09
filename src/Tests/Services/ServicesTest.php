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
use SWCO\AppNexusAPI\Services\Language;
use SWCO\AppNexusAPI\Services\OperatingSystem;
use SWCO\AppNexusAPI\Services\PlatformMember;
use SWCO\AppNexusAPI\Services\TechnicalAttribute;
use SWCO\AppNexusAPI\Tests\ServicesDataProvider;

class ServicesTest extends ServicesDataProvider
{
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

    public function testSupportsSince()
    {
        $doNotSupportSince = array(
            new Carrier(),
            new DeviceMake(),
            new DeviceModel(),
            new DomainAuditStatus(),
            new Language(),
        );

        foreach ($doNotSupportSince as $obj) {
            $this->assertFalse($obj->supportsSince());
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

    public function testLanguageServiceImport()
    {
        foreach ($this->getData('language', 'languages') as $data) {
            $obj = new Language();
            $obj->import($data);

            $this->assertEquals($data['id'], $obj->getId());
            $this->assertEquals($data['name'], $obj->getName());
            $this->assertEquals(new \DateTime($data['last_activity']), $obj->getLastActivity());
            $this->assertEquals($data['code'], $obj->getCode());

            $this->assertInternalType('int', $obj->getId());
            $this->assertInternalType('string', $obj->getName());
            $this->assertInternalType('string', $obj->getCode());
            $this->assertInstanceOf('\DateTime', $obj->getLastActivity());
        }
    }

    public function testOperatingSystemServiceImport()
    {
        foreach ($this->getData('operating-system', 'operating-systems') as $data) {
            $obj = new OperatingSystem();
            $obj->import($data);

            $this->assertEquals($data['id'], $obj->getId());
            $this->assertEquals($data['name'], $obj->getName());
            $this->assertEquals(new \DateTime($data['last_modified']), $obj->getLastModified());
            $this->assertEquals($data['platform_type'], $obj->getPlatformType());

            $this->assertInternalType('int', $obj->getId());
            $this->assertInternalType('string', $obj->getName());
            $this->assertInstanceOf('\DateTime', $obj->getLastModified());
            $this->assertInternalType('string', $obj->getPlatformType());
        }
    }

    public function testPlatformMemberServiceImport()
    {
        foreach ($this->getData('platform-member', 'platform-members') as $data) {
            $obj = new PlatformMember();
            $obj->import($data);

            $this->assertEquals($data['id'], $obj->getId());
            $this->assertEquals($data['name'], $obj->getName());
            $this->assertEquals(new \DateTime($data['last_modified']), $obj->getLastModified());
            $this->assertEquals($data['is_iash_compliant'], $obj->isIASHCompliant());
            $this->assertEquals($data['active'], $obj->isActive());
            $this->assertEquals(new PlatformMember\Bidder($data['bidder'] ? : array()), $obj->getBidder());
            if (isset($data['contact_info'][0]) && $data['contact_info'][0]) {
                $this->assertEquals(new PlatformMember\ContactInfo($data['contact_info'][0]), $obj->getContactInfo());
            } elseif (isset($data['contact_info']) && $data['contact_info']) {
                $this->assertEquals(new PlatformMember\ContactInfo($data['contact_info']), $obj->getContactInfo());
            } else {
                $this->assertEquals(new PlatformMember\ContactInfo(), $obj->getContactInfo());
            }
            $this->assertEquals($data['daily_imps_any_audit_status'], $obj->getDailyImpressionsAnyAuditStatus());
            $this->assertEquals($data['daily_imps_appnexus_reviewed'], $obj->getDailyImpressionsAppNexusReviewed());
            $this->assertEquals(
                $data['daily_imps_appnexus_seller_reviewed'], $obj->getDailyImpressionsAppNexusSellerReviewed()
            );
            $this->assertEquals($data['default_discrepancy_pct'], $obj->getDefaultDiscrepancyPCT());
            $this->assertEquals($data['email'], $obj->getEmail());
            $this->assertEquals($data['platform_exposure'], $obj->getPlatformExposure());
            $this->assertEquals($data['primary_type'], $obj->getPrimaryType());
            $this->assertEquals($data['has_resold'], $obj->hasResold());
            $this->assertEquals($data['seller_type'], $obj->getSellerType());
            $this->assertEquals(
                new PlatformMember\VisibilityRules($data['visibility_rules']), $obj->getVisibilityRules()
            );

            $this->assertInternalType('int', $obj->getId());
            $this->assertInternalType('string', $obj->getName());
            $this->assertInstanceOf('\DateTime', $obj->getLastModified());
            $this->assertInternalType('bool', $obj->isIASHCompliant());
            $this->assertInternalType('bool', $obj->isActive());
            $this->assertInstanceOf('\SWCO\AppNexusAPI\Services\PlatformMember\Bidder', $obj->getBidder());
            $this->assertInstanceOf('\SWCO\AppNexusAPI\Services\PlatformMember\ContactInfo', $obj->getContactInfo());
            $this->assertInternalType('int', $obj->getDailyImpressionsAnyAuditStatus());
            $this->assertInternalType('int', $obj->getDailyImpressionsAppNexusReviewed());
            $this->assertInternalType('int', $obj->getDailyImpressionsAppNexusSellerReviewed());
            $this->assertInternalType('float', $obj->getDefaultDiscrepancyPCT());
            $this->assertInternalType('string', $obj->getEmail());
            $this->assertInternalType('string', $obj->getPlatformExposure());
            $this->assertInternalType('string', $obj->getPrimaryType());
            $this->assertInternalType('bool', $obj->hasResold());
            $this->assertInternalType('string', $obj->getSellerType());
            $this->assertInstanceOf(
                '\SWCO\AppNexusAPI\Services\PlatformMember\VisibilityRules', $obj->getVisibilityRules()
            );
        }
    }

    public function testTechnicalAttributeServiceImport()
    {
        foreach ($this->getData('technical-attribute', 'technical-attributes') as $data) {
            $obj = new TechnicalAttribute();
            $obj->import($data);

            $this->assertEquals($data['id'], $obj->getId());
            $this->assertEquals($data['name'], $obj->getName());
            $this->assertEquals(new \DateTime($data['last_modified']), $obj->getLastModified());

            $this->assertInternalType('int', $obj->getId());
            $this->assertInternalType('string', $obj->getName());
            $this->assertInstanceOf('\DateTime', $obj->getLastModified());
        }
    }

    public function testCarrierCodeServiceImport()
    {
        foreach ($this->getData('carrier', 'carriers') as $data) {
            if (is_array($data['codes'])) {
                foreach ($data['codes'] as $code) {
                    $obj = new Carrier\Code();
                    $obj->import($code);

                    $this->assertEquals($code['id'], $obj->getId());
                    $this->assertEquals($code['carrier_id'], $obj->getCarrierId());
                    $this->assertEquals($code['code'], $obj->getCode());
                    $this->assertEquals($code['notes'], $obj->getNotes());

                    $this->assertInternalType('int', $obj->getId());
                    $this->assertInternalType('int', $obj->getCarrierId());
                    $this->assertInternalType('string', $obj->getCode());
                    $this->assertInternalType('string', $obj->getNotes());
                }
            }
        }
    }

    /* No data available
    public function testCategoryBrandServiceImport()
    {
        foreach ($this->getData('category', 'categories') as $data) {
            if (is_array($data['whitelist']['countries_and_brands'])) {
                foreach ($data['whitelist']['countries_and_brands'] as $countriesAndBrands) {
                    if ($countriesAndBrands['brand']) {
                        $obj = new Category\Brand();
                        $obj->import($countriesAndBrands['brand']);

                        $this->assertEquals($countriesAndBrands['brand']['id'], $obj->getId());
                        $this->assertEquals($countriesAndBrands['brand']['name'], $obj->getName());

                        $this->assertInternalType('int', $obj->getId());
                        $this->assertInternalType('string', $obj->getName());
                    }
                }
            }
        }
    }*/

    public function testCategoryCountryServiceImport()
    {
        foreach ($this->getData('category', 'categories') as $data) {
            if (is_array($data['whitelist']['countries'])) {
                foreach ($data['whitelist']['countries'] as $countries) {
                    $obj = new Category\Country();
                    $obj->import($countries);

                    $this->assertEquals($countries['country'], $obj->getCountry());

                    $this->assertInternalType('string', $obj->getCountry());
                }
            }
        }
    }

    /* No data available
    public function testCategoryCountryBrandServiceImport()
    {
        foreach ($this->getData('category', 'categories') as $data) {
            if (is_array($data['whitelist']['countries_and_brands'])) {
                foreach ($data['whitelist']['countries_and_brands'] as $countriesAndBrands) {
                    $obj = new Category\CountryBrand();
                    $obj->import($countriesAndBrands);

                    $this->assertEquals(new Category\Brand($countriesAndBrands['brand']), $obj->getBrand());
                    $this->assertEquals($countriesAndBrands['brand_id'], $obj->getBrandId());
                    $this->assertEquals($countriesAndBrands['brand_name'], $obj->getBrandName());
                    $this->assertEquals($countriesAndBrands['country'], $obj->getCountry());

                    $this->assertInstanceOf('\SWCO\AppNexusAPI\Services\Category\Brand', $obj->getBrand());
                    $this->assertInternalType('int', $obj->getBrandId());
                    $this->assertInternalType('string', $obj->getBrandName());
                    $this->assertInternalType('string', $obj->getCountry());
                }
            }
        }
    }*/

    /* No data available
    public function testCategoryRegionBrandServiceImport()
    {
        foreach ($this->getData('category', 'categories') as $data) {
            if (is_array($data['whitelist']['regions_and_brands'])) {
                foreach ($data['whitelist']['regions_and_brands'] as $regionsAndBrands) {
                    $obj = new Category\RegionBrand();
                    $obj->import($regionsAndBrands);

                    $this->assertEquals(new Category\Brand($regionsAndBrands['brand']), $obj->getBrand());
                    $this->assertEquals($regionsAndBrands['brand_id'], $obj->getBrandId());
                    $this->assertEquals($regionsAndBrands['brand_name'], $obj->getBrandName());
                    $this->assertEquals($regionsAndBrands['region'], $obj->getRegion());

                    $this->assertInstanceOf('\SWCO\AppNexusAPI\Services\Category\Brand', $obj->getBrand());
                    $this->assertInternalType('int', $obj->getBrandId());
                    $this->assertInternalType('string', $obj->getBrandName());
                    $this->assertInternalType('string', $obj->getRegion());
                }
            }
        }
    }*/

    public function testDeviceMakeCodeServiceImport()
    {
        foreach ($this->getData('device-make', 'device-makes') as $data) {
            if (is_array($data['codes'])) {
                foreach ($data['codes'] as $code) {
                    $obj = new DeviceMake\Code();
                    $obj->import($code);

                    $this->assertEquals($code['code'], $obj->getCode());
                    $this->assertEquals($code['device_make_id'], $obj->getDeviceMakeId());
                    $this->assertEquals($code['id'], $obj->getId());
                    $this->assertEquals($code['notes'], $obj->getNotes());

                    $this->assertInternalType('string', $obj->getCode());
                    $this->assertInternalType('int', $obj->getDeviceMakeId());
                    $this->assertInternalType('int', $obj->getId());
                    $this->assertInternalType('string', $obj->getNotes());
                }
            }
        }
    }

    public function testDeviceModelCodeServiceImport()
    {
        foreach ($this->getData('device-model', 'device-models') as $data) {
            if (isset($data['codes']) && is_array($data['codes'])) {
                foreach ($data['codes'] as $code) {
                    $obj = new DeviceModel\Code();
                    $obj->import($code);

                    $this->assertEquals($code['code'], $obj->getCode());
                    $this->assertEquals($code['device_model_id'], $obj->getDeviceModelId());
                    $this->assertEquals($code['id'], $obj->getId());
                    $this->assertEquals($code['notes'], $obj->getNotes());

                    $this->assertInternalType('string', $obj->getCode());
                    $this->assertInternalType('int', $obj->getDeviceModelId());
                    $this->assertInternalType('int', $obj->getId());
                    $this->assertInternalType('string', $obj->getNotes());
                }
            }
        }
    }

    public function testPlatformMemberBidderServiceImport()
    {
        foreach ($this->getData('platform-member', 'platform-members') as $data) {
            if ($data['bidder']) {
                $obj = new PlatformMember\Bidder();
                $obj->import($data['bidder']);

                $this->assertEquals($data['bidder']['id'], $obj->getId());
                $this->assertEquals($data['bidder']['name'], $obj->getName());

                $this->assertInternalType('int', $obj->getId());
                $this->assertInternalType('string', $obj->getName());
            }
        }
    }

    public function testPlatformMemberContactInfoServiceImport()
    {
        foreach ($this->getData('platform-member', 'platform-members') as $data) {
            if ($data['contact_info']) {
                $contactInfo = isset($data['contact_info'][0]) ? $data['contact_info'][0] : $data['contact_info'];
                $obj = new PlatformMember\ContactInfo();
                $obj->import($contactInfo ? : array());

                $this->assertEquals($contactInfo['name'], $obj->getName());
                $this->assertEquals($contactInfo['additional_info'], $obj->getAdditionalInfo());
                $this->assertEquals($contactInfo['address'], $obj->getAddress());
                $this->assertEquals($contactInfo['city'], $obj->getCity());
                $this->assertEquals($contactInfo['country'], $obj->getCountry());
                $this->assertEquals($contactInfo['email'], $obj->getEmail());
                $this->assertEquals($contactInfo['phone'], $obj->getPhone());
                $this->assertEquals($contactInfo['postal_code'], $obj->getPostalCode());
                $this->assertEquals($contactInfo['region'], $obj->getRegion());
                $this->assertEquals($contactInfo['title'], $obj->getTitle());
                $this->assertEquals($contactInfo['types'], $obj->getTypes());
                $this->assertEquals($contactInfo['website_url'], $obj->getWebsiteURL());

                $this->assertInternalType('string', $obj->getName());
                $this->assertInternalType('string', $obj->getAdditionalInfo());
                $this->assertInternalType('string', $obj->getAddress());
                $this->assertInternalType('string', $obj->getCity());
                $this->assertInternalType('string', $obj->getCountry());
                $this->assertInternalType('string', $obj->getEmail());
                $this->assertInternalType('string', $obj->getPhone());
                $this->assertInternalType('string', $obj->getPostalCode());
                $this->assertInternalType('string', $obj->getRegion());
                $this->assertInternalType('string', $obj->getTitle());
                $this->assertInternalType('array', $obj->getTypes());
                $this->assertInternalType('string', $obj->getWebsiteURL());
            }
        }
    }

    public function testPlatformMemberVisibilityRulesServiceImport()
    {
        foreach ($this->getData('platform-member', 'platform-members') as $data) {
            if ($data['visibility_rules']) {
                $vr  = $data['visibility_rules'];
                $obj = new PlatformMember\VisibilityRules();
                $obj->import($vr);

                $this->assertEquals($vr['expose_age'], $obj->canExposeAge());
                $this->assertEquals($vr['expose_custom_categories'], $obj->getExposedCustomCategories());
                $this->assertEquals($vr['expose_gender'], $obj->canExposeGender());
                $this->assertEquals($vr['expose_publishers'], $obj->canExposePublishers());
                $this->assertEquals($vr['expose_tags'], $obj->canExposeTags());
                $this->assertEquals($vr['expose_universal_categories'], $obj->canExposeUniversalCategories());
                $this->assertEquals($vr['url_exposure'], $obj->getUrlExposure());

                $this->assertInternalType('array', $obj->getCustomCategories());
                $this->assertInternalType('bool', $obj->canExposeAge());
                $this->assertInternalType('string', $obj->getExposedCustomCategories());
                $this->assertInternalType('bool', $obj->canExposeGender());
                $this->assertInternalType('bool', $obj->canExposePublishers());
                $this->assertInternalType('bool', $obj->canExposeTags());
                $this->assertInternalType('bool', $obj->canExposeUniversalCategories());
                $this->assertInternalType('string', $obj->getUrlExposure());
            }
        }
    }
}

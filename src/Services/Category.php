<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractCoreService;
use SWCO\AppNexusAPI\Services\Category\Country;
use SWCO\AppNexusAPI\Services\Category\CountryBrand;
use SWCO\AppNexusAPI\Services\Category\RegionBrand;

class Category extends AbstractCoreService
{
    /**
     * The ID of the category.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The name of the category.
     *
     * @var string
     */
    protected $name = '';

    /**
     * If true, the category is listed as "sensitive", and is often banned by publishers.
     *
     * @var boolean
     */
    protected $sensitive = false;

    /**
     * Whether brands or creatives in this category require whitelisting in order to serve.
     *
     * @var boolean
     */
    protected $requiresWhitelist = false;

    /**
     * Whether brands or creatives in this category require whitelisting in order to serve on managed inventory.
     *
     * @var boolean
     */
    protected $requiresWhitelistOnManaged = false;

    /**
     * Whether brands or creatives in this category require whitelisting in order to serve on external (i.e., RTB)
     * inventory.
     *
     * @var boolean
     */
    protected $requiresWhitelistOnExternal = false;

    /**
     * The date and time when the category was last modified.
     *
     * @var \DateTime
     */
    protected $lastModified;

    /**
     * If true, the AppNexus audit team may associate the category with brands.
     *
     * @var boolean
     */
    protected $brandEligible = false;

    /**
     * The countries where this category is whitelisted.
     *
     * @var Category\Country[]
     */
    protected $countries = array();

    /**
     * This array contains brand whitelist settings grouped by country.
     *
     * @var Category\CountryBrand[]
     */
    protected $countriesBrands = array();

    /**
     * This array contains brand whitelist settings grouped by region.
     *
     * @var Category\RegionBrand[]
     */
    protected $regionsBrands = array();

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->id                          = $data['id'];
        $this->name                        = $data['name'];
        $this->sensitive                   = $data['is_sensitive'];
        $this->requiresWhitelist           = $data['requires_whitelist'];
        $this->requiresWhitelistOnManaged  = $data['requires_whitelist_on_managed'];
        $this->requiresWhitelistOnExternal = $data['requires_whitelist_on_external'];
        $this->lastModified                = \DateTime::createFromFormat("Y-m-d H:i:s", $data['last_modified']);
        $this->brandEligible               = $data['is_brand_eligible'];

        if (isset($data['whitelist']['countries'])) {
            foreach ($data['whitelist']['countries'] as $country) {
                $countryObj = new Country();
                $this->countries[] = $countryObj->import($country);
            }
        }

        if (isset($data['whitelist']['countries_and_brands'])) {
            foreach ($data['whitelist']['countries_and_brands'] as $countryBrand) {
                $countryBrandObj = new CountryBrand();
                $this->countriesBrands[] = $countryBrandObj->import($countryBrand);
            }
        }

        if (isset($data['whitelist']['regions_and_brands'])) {
            foreach ($data['whitelist']['regions_and_brands'] as $regionBrand) {
                $regionBrandObj = new RegionBrand();
                $this->regionsBrands[] = $regionBrandObj->import($regionBrand);
            }
        }

        return $this;
    }

    /**
     * @return boolean
     */
    public function isBrandEligible()
    {
        return $this->brandEligible;
    }

    /**
     * @return Category\Country[]
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * @return Category\CountryBrand[]
     */
    public function getCountriesBrands()
    {
        return $this->countriesBrands;
    }

    /**
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Category\RegionBrand[]
     */
    public function getRegionsBrands()
    {
        return $this->regionsBrands;
    }

    /**
     * @return boolean
     */
    public function requiresWhitelist()
    {
        return $this->requiresWhitelist;
    }

    /**
     * @return boolean
     */
    public function requiresWhitelistOnExternal()
    {
        return $this->requiresWhitelistOnExternal;
    }

    /**
     * @return boolean
     */
    public function requiresWhitelistOnManaged()
    {
        return $this->requiresWhitelistOnManaged;
    }

    /**
     * @return boolean
     */
    public function isSensitive()
    {
        return $this->sensitive;
    }
}

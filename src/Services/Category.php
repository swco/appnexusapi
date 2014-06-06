<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractGetService;
use SWCO\AppNexusAPI\Services\Category\Country;
use SWCO\AppNexusAPI\Services\Category\CountryBrand;
use SWCO\AppNexusAPI\Services\Category\RegionBrand;

class Category extends AbstractGetService
{
    /**
     * The ID of the category.
     *
     * @var int
     */
    protected $id;

    /**
     * The name of the category.
     *
     * @var string
     */
    protected $name;

    /**
     * If true, the category is listed as "sensitive", and is often banned by publishers.
     *
     * @var bool
     */
    protected $sensitive;

    /**
     * Whether brands or creatives in this category require whitelisting in order to serve.
     *
     * @var bool
     */
    protected $requiresWhitelist;

    /**
     * Whether brands or creatives in this category require whitelisting in order to serve on managed inventory.
     *
     * @var bool
     */
    protected $requiresWhitelistOnManaged;

    /**
     * Whether brands or creatives in this category require whitelisting in order to serve on external (i.e., RTB)
     * inventory.
     *
     * @var bool
     */
    protected $requiresWhitelistOnExternal;

    /**
     * The date and time when the category was last modified.
     *
     * @var \DateTime
     */
    protected $lastModified;

    /**
     * If true, the AppNexus audit team may associate the category with brands.
     *
     * @var bool
     */
    protected $brandEligible;

    /**
     * The countries where this category is whitelisted.
     *
     * @var Category\Country[]
     */
    protected $countries;

    /**
     * This array contains brand whitelist settings grouped by country.
     *
     * @var Category\CountryBrand[]
     */
    protected $countriesBrands;

    /**
     * This array contains brand whitelist settings grouped by region.
     *
     * @var Category\RegionBrand[]
     */
    protected $regionsBrands;

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

        foreach ($data['whitelist']['countries'] as $country) {
            $countryObj = new Country();
            $this->countries[] = $countryObj->import($country);
        }

        foreach ($data['whitelist']['countries_and_brands'] as $countryBrand) {
            $countryBrandObj = new CountryBrand();
            $this->countriesBrands[] = $countryBrandObj->import($countryBrand);
        }

        foreach ($data['whitelist']['regions_and_brands'] as $regionBrand) {
            $regionBrandObj = new RegionBrand();
            $this->regionsBrands[] = $regionBrandObj->import($regionBrand);
        }

        return $this;
    }
}

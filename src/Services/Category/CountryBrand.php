<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services\Category;

use SWCO\AppNexusAPI\AbstractService;

class CountryBrand extends AbstractService
{
    /**
     * The ID of the brand.
     *
     * @var int
     */
    protected $brandId = 0;

    /**
     * The name of the brand.
     *
     * @var string
     */
    protected $brandName = '';

    /**
     * An object containing information about the brand whitelisted in this country.
     *
     * @var Brand
     */
    protected $brand;

    /**
     * A 2-character string referencing the country in which the brand is whitelisted. For a list of supported codes,
     * see the ISO 3166-1 country codes.
     *
     * @var string
     */
    protected $country = '';

    public function import(array $data)
    {
        $this->brandId   = $data['brand_id'];
        $this->brandName = $data['brand_name'];
        $this->brand     = new Brand();
        $this->brand->import($data['brand']);
        $this->country = $data['country'];

        return $this;
    }

    /**
     * @return Brand|null
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return int
     */
    public function getBrandId()
    {
        return $this->brandId;
    }

    /**
     * @return string
     */
    public function getBrandName()
    {
        return $this->brandName;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}

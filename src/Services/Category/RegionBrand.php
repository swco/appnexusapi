<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services\Category;

use SWCO\AppNexusAPI\AbstractService;

class RegionBrand extends AbstractService
{
    /**
     * The ID of the brand.
     *
     * @var int
     */
    protected $brandId;

    /**
     * The name of the brand.
     *
     * @var string
     */
    protected $brandName;

    /**
     * An object containing information about the brand whitelisted in this region.
     *
     * @var Brand
     */
    protected $brand;

    /**
     * A string referencing the region in which the brand is whitelisted. For a list of supported codes, see the ISO
     * 3166-2.
     *
     * @var string
     */
    protected $region;

    public function import(array $data)
    {
        $this->brandId   = $data['brand_id'];
        $this->brandName = $data['brand_name'];
        $this->brand     = new Brand();
        $this->brand->import($data['brand']);
        $this->region = $data['region'];

        return $this;
    }
}

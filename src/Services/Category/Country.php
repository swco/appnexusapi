<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services\Category;

use SWCO\AppNexusAPI\AbstractService;

class Country extends AbstractService
{
    /**
     * The country where this category is whitelisted.
     *
     * @var string
     */
    protected $country = '';

    public function import(array $data)
    {
        $this->country = $data['country'];

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}

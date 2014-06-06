<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractGetService;
use SWCO\AppNexusAPI\Services\Carrier\Code;

class Carrier extends AbstractGetService
{
    /**
     * The ID of the mobile carrier.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The name of the mobile carrier.
     *
     * @var string
     */
    protected $name = '';

    /**
     * The ISO code for the country in which the carrier operates.
     *
     * @link http://dev.maxmind.com/geoip/legacy/codes/iso3166/
     * @var string
     */
    protected $countryCode = '';

    /**
     * Not yet available.
     *
     * The name of the country in which the carrier operates.
     *
     * @var string
     */
    protected $countryName = '';

    /**
     * Third-party representations for the mobile carrier. See Codes below for more details.
     *
     * @var Carrier\Code[]
     */
    protected $codes = array();

    /**
     * @return boolean
     */
    public function supportsSince()
    {
        return false;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->id          = $data['id'];
        $this->name        = $data['name'];
        $this->countryCode = $data['country_code'];
        $this->countryName = $data['country_name'];

        if (is_array($data['codes'])) {
            foreach ($data['codes'] as $code) {
                $codeObj       = new Code();
                $this->codes[] = $codeObj->import($code);
            }
        }

        return $this;
    }

    /**
     * @return Carrier\Code[]
     */
    public function getCodes()
    {
        return $this->codes;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

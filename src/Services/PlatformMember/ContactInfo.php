<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services\PlatformMember;

use SWCO\AppNexusAPI\AbstractService;

class ContactInfo extends AbstractService
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $email = '';

    /**
     * @var string
     */
    protected $phone = '';

    /**
     * @var string
     */
    protected $address = '';

    /**
     * @var string
     */
    protected $address2 = '';

    /**
     * @var string
     */
    protected $city = '';

    /**
     * @var string
     */
    protected $country = '';

    /**
     * @var string
     */
    protected $region = '';

    /**
     * @var string
     */
    protected $postalCode = '';

    /**
     * @var string
     */
    protected $additionalInfo = '';

    /**
     * @var string
     */
    protected $websiteURL = '';

    /**
     * "supply" or "demand"
     *
     * @var string[]
     */
    protected $types = array();

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->name           = $data['name'];
        $this->title          = $data['title'];
        $this->email          = $data['email'];
        $this->phone          = $data['phone'];
        $this->address        = $data['address'];
        $this->address2       = $data['address_2'];
        $this->city           = $data['city'];
        $this->country        = $data['country'];
        $this->region         = $data['region'];
        $this->postalCode     = $data['postal_code'];
        $this->additionalInfo = $data['additional_info'] ? : '';
        $this->websiteURL     = $data['website_url'] ? : '';
        $this->types          = $data['types'];

        return $this;
    }

    /**
     * @return string
     */
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string[]
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @return string
     */
    public function getWebsiteURL()
    {
        return $this->websiteURL;
    }
}

<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractCoreService;

class Brand extends AbstractCoreService
{
    /**
     * The ID of the brand.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The name of the brand.
     *
     * @var string
     */
    protected $name = '';

    /**
     * URLs associated with the brand. The format is ["brandurl.com", "brandurl.net", ...]
     *
     * @var string[]
     */
    protected $urls = array();

    /**
     * If true, the brand is a premium brand.
     *
     * @var boolean
     */
    protected $premium = false;

    /**
     * The ID of the category associated with the brand.
     *
     * @var int
     */
    protected $categoryId = 0;

    /**
     * The ID of the company associated with the brand.
     *
     * @var int
     */
    protected $companyId = 0;

    /**
     * The number of active creatives assigned to the brand. This includes your own creatives as well as all other
     * active creatives on the platform.
     *
     * @var int
     */
    protected $numCreatives = 0;

    /**
     * The day and time when the brand was last modified.
     *
     * @var \DateTime
     */
    protected $lastModified;

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->id           = $data['id'];
        $this->name         = $data['name'];
        $this->urls         = is_array($data['urls']) ? $data['urls'] : array();
        $this->premium      = $data['is_premium'];
        $this->categoryId   = $data['category_id'];
        $this->companyId    = $data['company_id'] ? : 0;
        $this->numCreatives = $data['num_creatives'] ? (int)$data['num_creatives'] : 0;
        $this->lastModified = \DateTime::createFromFormat("Y-m-d H:i:s", $data['last_modified']);

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * @return int
     */
    public function getNumCreatives()
    {
        return $this->numCreatives;
    }

    /**
     * @return boolean
     */
    public function isPremium()
    {
        return $this->premium;
    }
}

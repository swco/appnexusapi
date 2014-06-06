<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractGetService;

class Brand extends AbstractGetService
{
    /**
     * The ID of the brand.
     *
     * @var int
     */
    protected $id;

    /**
     * The name of the brand.
     *
     * @var string
     */
    protected $name;

    /**
     * URLs associated with the brand. The format is ["brandurl.com", "brandurl.net", ...]
     *
     * @var string[]
     */
    protected $urls;

    /**
     * If true, the brand is a premium brand.
     *
     * @var bool
     */
    protected $premium;

    /**
     * The ID of the category associated with the brand.
     *
     * @var int
     */
    protected $categoryId;

    /**
     * The ID of the company associated with the brand.
     *
     * @var int
     */
    protected $companyId;

    /**
     * The number of active creatives assigned to the brand. This includes your own creatives as well as all other
     * active creatives on the platform.
     *
     * @var int
     */
    protected $numCreatives;

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
        $this->urls         = $data['urls'];
        $this->premium      = $data['is_premium'];
        $this->categoryId   = $data['category_id'];
        $this->companyId    = $data['company_id'];
        $this->numCreatives = $data['num_creatives'];
        $this->lastModified = \DateTime::createFromFormat("Y-m-d H:i:s", $data['last_modified']);

        return $this;
    }
}

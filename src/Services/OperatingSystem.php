<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractGetService;

class OperatingSystem extends AbstractGetService
{
    /**
     * The ID of the operating system.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The name of the operating system.
     *
     * @var string
     */
    protected $name = '';

    /**
     * The type of platform on which the operating system runs. Possible values: "web", "mobile", or "both".
     *
     * @var string
     */
    protected $platformType = '';

    /**
     * Not yet supported.
     *
     * @var int
     */
    protected $OSFamilyId = 0;

    /**
     * Date and time the operating system entry was last modified
     *
     * @var \DateTime
     */
    protected $lastModified;

    /**
     * Not yet supported.
     *
     * @var string
     */
    protected $OSFamilyName = '';

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->id           = $data['id'];
        $this->name         = $data['name'];
        $this->platformType = $data['platform_type'];
        $this->OSFamilyId   = $data['os_family_id'];
        $this->OSFamilyName = $data['os_family_name'];
        $this->lastModified = \DateTime::createFromFormat("Y-m-d H:i:s", $data['last_modified']);

        return $this;
    }

    /**
     * @return \DateTime|null
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
     * @return string
     */
    public function getPlatformType()
    {
        return $this->platformType;
    }
}

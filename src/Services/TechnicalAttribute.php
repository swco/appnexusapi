<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractGetService;

class TechnicalAttribute extends AbstractGetService
{
    /**
     * The internal identifier for the technical attribute
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The name of the technical attribute
     *
     * @var string
     */
    protected $name = '';

    /**
     * The date/time at which the technical attribute was last modified
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
}

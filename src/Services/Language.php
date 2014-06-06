<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractGetService;

class Language extends AbstractGetService
{
    /**
     * The ID of the language.
     *
     * @var int
     */
    protected $id;

    /**
     * The name of the language.
     *
     * @var string
     */
    protected $name;

    /**
     * The code for the language.
     *
     * @var string
     */
    protected $code;

    /**
     * The date and time of the last update to the language entry.
     *
     * @var \DateTime
     */
    protected $lastActivity;

    /**
     * @return bool
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
        $this->id           = $data['id'];
        $this->name         = $data['name'];
        $this->code         = $data['code'];
        $this->lastActivity = \DateTime::createFromFormat("Y-m-d H:i:s", $data['last_activity']);

        return $this;
    }
}

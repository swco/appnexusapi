<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services\DeviceMake;

use SWCO\AppNexusAPI\AbstractService;

class Code extends AbstractService
{
    /**
     * The ID for the device make.
     *
     * @var int
     */
    protected $id;

    /**
     * The third-party representation for the device make.
     *
     * @var string
     */
    protected $code;

    /**
     * Identification information about the third-party.
     *
     * @var string
     */
    protected $notes;

    /**
     * The ID for the device make.
     *
     * @var int
     */
    protected $deviceMakeId;

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->id           = $data['id'];
        $this->code         = $data['code'];
        $this->notes        = $data['notes'];
        $this->deviceMakeId = $data['device_make_id'];

        return $this;
    }
}

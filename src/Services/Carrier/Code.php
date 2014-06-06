<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services\Carrier;

use SWCO\AppNexusAPI\AbstractService;

class Code extends AbstractService
{
    /**
     * The ID of the code.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The third-party representation for carrier.
     *
     * @var string
     */
    protected $code = '';

    /**
     * Identification information about the third-party.
     *
     * @var string
     */
    protected $notes = '';

    /**
     * The ID of the carrier.
     *
     * @var int
     */
    protected $carrierId = 0;

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->id        = $data['id'];
        $this->code      = $data['code'];
        $this->notes     = $data['notes'];
        $this->carrierId = $data['carrier_id'];

        return $this;
    }

    /**
     * @return int
     */
    public function getCarrierId()
    {
        return $this->carrierId;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }
}


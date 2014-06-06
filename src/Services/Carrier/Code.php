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
    protected $id;

    /**
     * The third-party representation for carrier.
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
     * The ID of the carrier.
     *
     * @var int
     */
    protected $carrierId;

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
}


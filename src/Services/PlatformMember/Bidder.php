<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services\PlatformMember;

use SWCO\AppNexusAPI\AbstractService;

class Bidder extends AbstractService
{
    /**
     * The ID of the bidder.
     *
     * @var int
     */
    protected $id;

    /**
     * The name of the bidder.
     *
     * @var string
     */
    protected $name;

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->id   = $data['id'];
        $this->name = $data['name'];

        return $this;
    }
}

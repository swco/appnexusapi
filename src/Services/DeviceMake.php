<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractGetService;
use SWCO\AppNexusAPI\Services\DeviceMake\Code;

class DeviceMake extends AbstractGetService
{
    /**
     * The ID of the device make.
     *
     * @var int
     */
    protected $id;

    /**
     * The name of the device make, i.e., "Apple".
     *
     * @var string
     */
    protected $name;

    /**
     * Third-party representations for the device make.
     *
     * @var DeviceMake\Code[]
     */
    protected $codes;

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
        $this->id                          = $data['id'];
        $this->name                        = $data['name'];

        foreach ($data['codes'] as $code) {
            $codeObj       = new Code();
            $this->codes[] = $codeObj->import($code);
        }

        return $this;
    }
}

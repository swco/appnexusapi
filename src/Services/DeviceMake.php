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
    protected $id = 0;

    /**
     * The name of the device make, i.e., "Apple".
     *
     * @var string
     */
    protected $name = '';

    /**
     * Third-party representations for the device make.
     *
     * @var DeviceMake\Code[]
     */
    protected $codes = array();

    /**
     * @return boolean
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
        $this->id   = $data['id'];
        $this->name = $data['name'];

        if ($data['codes']) {
            foreach ($data['codes'] as $code) {
                $codeObj       = new Code();
                $this->codes[] = $codeObj->import($code);
            }
        }

        return $this;
    }

    /**
     * @return DeviceMake\Code[]
     */
    public function getCodes()
    {
        return $this->codes;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

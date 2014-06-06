<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

abstract class AbstractGetService extends AbstractService
{
    protected $id;

    /**
     * @return bool
     */
    public function supportsSince()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function needsPost()
    {
        return false;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

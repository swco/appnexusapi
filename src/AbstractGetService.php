<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

abstract class AbstractGetService extends AbstractService
{
    protected $id;

    /**
     * @return boolean
     */
    public function supportsSince()
    {
        return true;
    }

    /**
     * @return boolean
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

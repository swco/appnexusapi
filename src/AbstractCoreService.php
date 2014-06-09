<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

abstract class AbstractCoreService extends AbstractService
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
     * @return string
     */
    public function getRequestVerb()
    {
        return 'get';
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

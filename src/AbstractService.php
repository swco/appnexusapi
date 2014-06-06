<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

abstract class AbstractService
{
    abstract public function import(array $data);

    public function __construct(array $data = array())
    {
        if ($data) {
            $this->import($data);
        }
    }
}

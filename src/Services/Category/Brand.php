<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services\Category;

use SWCO\AppNexusAPI\AbstractService;

class Brand extends AbstractService
{
    /**
     * The ID of the brand.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The name of the brand.
     *
     * @var string
     */
    protected $name = '';

    public function import(array $data)
    {
        $this->id   = $data['id'];
        $this->name = $data['name'];

        return $this;
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
    public function getName()
    {
        return $this->name;
    }
}

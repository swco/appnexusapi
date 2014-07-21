<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

class Response extends \ArrayIterator
{
    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $startElement;

    /**
     * @param array  $services
     * @param string $status
     * @param int    $count
     * @param int    $startElement
     */
    public function __construct(array $services, $status, $count, $startElement)
    {
        parent::__construct($services);
        $this->status       = $status;
        $this->count        = $count;
        $this->startElement = $startElement;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return int
     */
    public function getStartElement()
    {
        return $this->startElement;
    }

    /**
     * @return int
     */
    public function getNumElements()
    {
        return $this->count();
    }
}

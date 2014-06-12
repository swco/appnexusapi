<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

use Guzzle\Http\ClientInterface;

class BrandRequest extends Request
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        $username,
        $password,
        $token = null,
        IServiceFactory $serviceFactory = null,
        ClientInterface $client = null
    )
    {
        parent::__construct($username, $password, $token, $serviceFactory, $client);
        $this->get(Request::SERVICE_BRAND, false);
    }

    /**
     * @return $this
     */
    public function simple()
    {
        $this->where('simple', 'true');

        return $this;
    }
}

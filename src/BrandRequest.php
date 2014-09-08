<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

use Guzzle\Http\ClientInterface;
use SWCO\AppNexusAPI\Services\Brand;

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
        ClientInterface $client = null,
        Auth $auth = null
    )
    {
        parent::__construct($username, $password, $token, $serviceFactory, $client, $auth);
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

    /**
     * @param int  $id
     * @param bool $simple
     * @return Brand
     */
    public function getBrand($id, $simple = false)
    {
        $this->get(self::SERVICE_BRAND)->whereId($id);

        if ($simple) {
            $this->simple();
        }

        return $this->returnOne($this->send());
    }

    /**
     * @param bool $simple
     * @return Brand[]
     */
    public function getBrands($simple = false)
    {
        $this->get(self::SERVICE_BRAND, false);

        if ($simple) {
            $this->simple();
        }

        return $this->send();
    }
}

<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use SWCO\AppNexusAPI\Exceptions\AppNexusAPIException;
use SWCO\AppNexusAPI\Exceptions\BadServiceException;
use SWCO\AppNexusAPI\Services\Brand;
use SWCO\AppNexusAPI\Services\Carrier;
use SWCO\AppNexusAPI\Services\Category;
use SWCO\AppNexusAPI\Services\DeviceMake;
use SWCO\AppNexusAPI\Services\DeviceModel;
use SWCO\AppNexusAPI\Services\DomainAuditStatus;
use SWCO\AppNexusAPI\Services\Language;
use SWCO\AppNexusAPI\Services\OperatingSystem;
use SWCO\AppNexusAPI\Services\PlatformMember;
use SWCO\AppNexusAPI\Services\TechnicalAttribute;

class Request
{
    const SERVICE_BRAND               = "brand";
    const SERVICE_CARRIER             = "carrier";
    const SERVICE_CATEGORY            = "category";
    const SERVICE_DEVICE_MAKE         = "device-make";
    const SERVICE_DEVICE_MODEL        = "device-model";
    const SERVICE_DOMAIN_AUDIT_STATUS = "url-audit-search";
    const SERVICE_LANGUAGE            = "language";
    const SERVICE_OPERATING_SYSTEM    = "operating-system";
    const SERVICE_PLATFORM_MEMBER     = "platform-member";
    const SERVICE_TECHNICAL_ATTRIBUTE = "technical-attribute";

    /**
     * @var array
     */
    private $allowedServices = array(
        self::SERVICE_BRAND               => true,
        self::SERVICE_CARRIER             => true,
        self::SERVICE_CATEGORY            => true,
        self::SERVICE_DEVICE_MAKE         => true,
        self::SERVICE_DEVICE_MODEL        => true,
        self::SERVICE_DOMAIN_AUDIT_STATUS => true,
        self::SERVICE_LANGUAGE            => true,
        self::SERVICE_OPERATING_SYSTEM    => true,
        self::SERVICE_PLATFORM_MEMBER     => true,
        self::SERVICE_TECHNICAL_ATTRIBUTE => true,
    );

    const APP_NEXUS_API_URL = 'http://api.appnexus.com';

    /**
     * @var array
     */
    private $classes = array();

    /**
     * @var string
     */
    private $service;

    /**
     * @var array
     */
    private $where = array();

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string|null
     */
    private $token;

    /**
     * @var IServiceFactory
     */
    private $serviceFactory;

    public function __construct($username, $password, $token = null, IServiceFactory $serviceFactory = null)
    {
        $this->username       = $username;
        $this->password       = $password;
        $this->token          = $token;
        $this->serviceFactory = $serviceFactory ? : new ServiceFactory();
    }

    /**
     * @param string $service
     * @param bool   $reset
     * @return $this
     * @throws Exceptions\BadServiceException
     */
    public function get($service, $reset = true)
    {
        if (!isset($this->allowedServices[$service])) {
            throw new BadServiceException(sprintf("Unrecognised service [%s]", $service));
        }

        if ($reset) {
            $this->where = array();
        }

        $this->service = $service;

        return $this;
    }

    /**
     * @param string $key
     * @param string $val
     * @return $this
     */
    public function where($key, $val)
    {
        $this->where[$key] = $val;

        return $this;
    }

    /**
     * @param \DateTime $dateTime
     * @return $this
     */
    public function since(\DateTime $dateTime)
    {
        return $this->where("since", $dateTime->format("Y-m-d H:i:s"));
    }

    /**
     * @param int|int[] $id
     * @return $this
     */
    public function whereId($id)
    {
        $ids = is_array($id) ? implode(',', $id) : $id;

        return $this->where("id", $ids);
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offsetBy($offset)
    {
        return $this->where("start_element", $offset);
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limitBy($limit)
    {
        return $this->where("num_elements", $limit);
    }

    /**
     * @param string $key
     * @param string $direction
     * @return $this
     */
    public function sortBy($key, $direction)
    {
        $direction = strtolower($direction);
        $direction = array_key_exists($direction, array('asc' => true, 'desc' => true)) ? $direction : 'asc';

        return $this->where("sort", sprintf("%s.%s", $key, $direction));
    }

    public function reset()
    {
        $this->where = array();
    }

    /**
     * @param array $postData
     * @return AbstractService
     * @throws Exceptions\BadServiceException
     * @throws Exceptions\AppNexusAPIException
     */
    public function send(array $postData = array())
    {
        $where = $this->where;

        if (isset($where['since'])) {
            if (!$this->getServiceObject($this->getService())->supportsSince()) {
                throw new BadServiceException(sprintf("[%s] does not support `since()`", $this->getService()));
            }

            switch ($this->getService()) {
                case self::SERVICE_LANGUAGE:
                    $key = 'min_last_activity';
                    break;
                default:
                    $key = 'min_last_modified';
                    break;
            }

            $where[$key] = $where['since'];
            unset($where['since']);
        }

        $uri    = sprintf("/%s?%s", $this->getService(), http_build_query($where));
        $client = new Client(self::APP_NEXUS_API_URL);
        if ($this->getServiceObject($this->getService())->needsPost()) {
            $request = $client->post($uri, array('Authorization' => $this->token), json_encode($postData));
        } else {
            $request = $client->get($uri, array('Authorization' => $this->token));
        }

        try {
            $response = $request->send();
            $data     = $response->json();
        } catch (ClientErrorResponseException $e) {
            $data = $e->getResponse()->json();
        } catch (\Exception $e) {
            $data = array();
        }

        if (!isset($data['response']['status']) || $data['response']['status'] !== "OK") {
            if (isset($data['response']['error'], $data['response']['error_id'])) {
                if ($data['response']['error_id'] === 'NOAUTH'
                    && $data['response']['error'] === 'Authentication failed - not logged in') {
                    $request = $client->post(
                        "auth",
                        null,
                        json_encode(
                            array("auth" => array("username" => $this->username, "password" => $this->password))
                        )
                    );
                    $response = $request->send();
                    $data     = $response->json();
                    if (isset($data['response']['token'])) {
                        $this->token = $data['response']['token'];
                        return $this->send();
                    } else {
                        throw new AppNexusAPIException("Auth Failed");
                    }
                } else {
                    throw new AppNexusAPIException(
                        sprintf(
                            "Call failed with error [%s: %s]",
                            $data['response']['error_id'],
                            $data['response']['error']
                        )
                    );
                }
            } else {
                throw new AppNexusAPIException("Call failed with no status.");
            }
        }

        return $this->getServiceObjectCollection($this->getService(), $data['response']);
    }

    /**
     * @return string
     * @throws Exceptions\BadServiceException
     */
    private function getService()
    {
        if ($this->service === null) {
            $callers = debug_backtrace();
            throw new BadServiceException(
                sprintf("A service must be set via `get(\$service)` before calling [%s]", $callers[1]['function'])
            );
        }

        return $this->service;
    }

    /**
     * @param string $service
     * @return AbstractGetService
     * @throws Exceptions\BadServiceException
     */
    private function getServiceObject($service)
    {
        switch ($service) {
            case self::SERVICE_BRAND:
                return isset($this->classes[$service]) ?
                    $this->classes[$service] :
                    $this->classes[$service] = $this->serviceFactory->newBrandInstance();
            case self::SERVICE_CARRIER:
                return isset($this->classes[$service]) ?
                    $this->classes[$service] :
                    $this->classes[$service] = $this->serviceFactory->newCarrierInstance();
            case self::SERVICE_CATEGORY:
                return isset($this->classes[$service]) ?
                    $this->classes[$service] :
                    $this->classes[$service] = $this->serviceFactory->newCategoryInstance();
            case self::SERVICE_DEVICE_MAKE:
                return isset($this->classes[$service]) ?
                    $this->classes[$service] :
                    $this->classes[$service] = $this->serviceFactory->newDeviceMakeInstance();
            case self::SERVICE_DEVICE_MODEL:
                return isset($this->classes[$service]) ?
                    $this->classes[$service] :
                    $this->classes[$service] = $this->serviceFactory->newDeviceModelInstance();
            case self::SERVICE_DOMAIN_AUDIT_STATUS:
                return isset($this->classes[$service]) ?
                    $this->classes[$service] :
                    $this->classes[$service] = $this->serviceFactory->newDomainAuditStatusInstance();
            case self::SERVICE_LANGUAGE:
                return isset($this->classes[$service]) ?
                    $this->classes[$service] :
                    $this->classes[$service] = $this->serviceFactory->newLanguageInstance();
            case self::SERVICE_OPERATING_SYSTEM:
                return isset($this->classes[$service]) ?
                    $this->classes[$service] :
                    $this->classes[$service] = $this->serviceFactory->newOperatingSystemInstance();
            case self::SERVICE_PLATFORM_MEMBER:
                return isset($this->classes[$service]) ?
                    $this->classes[$service] :
                    $this->classes[$service] = $this->serviceFactory->newPlatformMemberInstance();
            case self::SERVICE_TECHNICAL_ATTRIBUTE:
                return isset($this->classes[$service]) ?
                    $this->classes[$service] :
                    $this->classes[$service] = $this->serviceFactory->newTechnicalAttributeInstance();
        }

        throw new BadServiceException(sprintf("Unrecognised service [%s]", $service));
    }

    /**
     * @param string $service
     * @param array  $data
     * @return AbstractGetService[]
     * @throws Exceptions\BadServiceException
     */
    private function getServiceObjectCollection($service, array $data)
    {
        switch ($service) {
            case self::SERVICE_BRAND:
                return $this->serviceFactory->newBrandCollection(
                    $this->getDataArray($data, 'brands', 'brand')
                );
            case self::SERVICE_CARRIER:
                return $this->serviceFactory->newCarrierCollection(
                    $this->getDataArray($data, 'carriers', 'carrier')
                );
            case self::SERVICE_CATEGORY:
                return $this->serviceFactory->newCategoryCollection(
                    $this->getDataArray($data, 'categories', 'category')
                );
            case self::SERVICE_DEVICE_MAKE:
                return $this->serviceFactory->newDeviceMakeCollection(
                    $this->getDataArray($data, 'device-makes', 'device-make')
                );
            case self::SERVICE_DEVICE_MODEL:
                return $this->serviceFactory->newDeviceModelCollection(
                    $this->getDataArray($data, 'device-models', 'device-model')
                );
            case self::SERVICE_DOMAIN_AUDIT_STATUS:
                return $this->serviceFactory->newDomainAuditStatusCollection(
                    $this->getDataArray($data, 'urls')
                );
            case self::SERVICE_LANGUAGE:
                return $this->serviceFactory->newLanguageCollection(
                    $this->getDataArray($data, 'languages', 'language')
                );
            case self::SERVICE_OPERATING_SYSTEM:
                return $this->serviceFactory->newOperatingSystemCollection(
                    $this->getDataArray($data, 'operating-systems', 'operating-system')
                );
            case self::SERVICE_PLATFORM_MEMBER:
                return $this->serviceFactory->newPlatformMemberCollection(
                    $this->getDataArray($data, 'platform-members', 'platform-member')
                );
            case self::SERVICE_TECHNICAL_ATTRIBUTE:
                return $this->serviceFactory->newTechnicalAttributeCollection(
                    $this->getDataArray($data, 'technical-attributes', 'technical-attribute')
                );
        }

        throw new BadServiceException(sprintf("Unrecognised service [%s]", $service));
    }

    /**
     * @param array  $data
     * @param string $multipleKey
     * @param string $singleKey
     * @return array
     */
    private function getDataArray(array $data, $multipleKey, $singleKey = null)
    {
        if (isset($data[$multipleKey])) {
            return $data[$multipleKey];
        } elseif($singleKey !== null && isset($data[$singleKey])) {
            return array($data[$singleKey]);
        }

        return array();
    }

    /* -( HELPERS )-------------------------------------------------------------------------------------------------- */

    /**
     * @param $services
     * @return AbstractGetService
     * @throws Exceptions\AppNexusAPIException
     */
    private function returnOne($services)
    {
        if (!is_array($services)) {
            throw new AppNexusAPIException("Service not found.");
        }

        return reset($services);
    }

    /**
     * @param int $id
     * @return Brand
     */
    public function getBrand($id)
    {
        return $this->returnOne($this->get(self::SERVICE_BRAND)->whereId($id)->send());
    }

    /**
     * @return Brand[]
     */
    public function getBrands()
    {
        return $this->get(self::SERVICE_BRAND, false)->send();
    }

    /**
     * @param int $id
     * @return Carrier
     */
    public function getCarrier($id)
    {
        return $this->returnOne($this->get(self::SERVICE_CARRIER)->whereId($id)->send());
    }

    /**
     * @return Carrier[]
     */
    public function getCarriers()
    {
        return $this->get(self::SERVICE_CARRIER, false)->send();
    }

    /**
     * @param int $id
     * @return Category
     */
    public function getCategory($id)
    {
        return $this->returnOne($this->get(self::SERVICE_CATEGORY)->whereId($id)->send());
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->get(self::SERVICE_CATEGORY, false)->send();
    }

    /**
     * @param int $id
     * @return DeviceMake
     */
    public function getDeviceMake($id)
    {
        return $this->returnOne($this->get(self::SERVICE_DEVICE_MAKE)->whereId($id)->send());
    }

    /**
     * @return DeviceMake[]
     */
    public function getDeviceMakes()
    {
        return $this->get(self::SERVICE_DEVICE_MAKE, false)->send();
    }

    /**
     * @param int $id
     * @return DeviceModel
     */
    public function getDeviceModel($id)
    {
        return $this->returnOne($this->get(self::SERVICE_DEVICE_MODEL)->whereId($id)->send());
    }

    /**
     * @return DeviceModel[]
     */
    public function getDeviceModels()
    {
        return $this->get(self::SERVICE_DEVICE_MODEL, false)->send();
    }

    /**
     * @param array $urls
     * @return DomainAuditStatus[]
     */
    public function getDomainAuditStatuses(array $urls)
    {
        return $this->get(self::SERVICE_DOMAIN_AUDIT_STATUS, false)->send(array("urls" => $urls));
    }

    /**
     * @param int $id
     * @return Language
     */
    public function getLanguage($id)
    {
        return $this->returnOne($this->get(self::SERVICE_LANGUAGE)->whereId($id)->send());
    }

    /**
     * @return Language[]
     */
    public function getLanguages()
    {
        return $this->get(self::SERVICE_LANGUAGE, false)->send();
    }

    /**
     * @param int $id
     * @return OperatingSystem
     */
    public function getOperatingSystem($id)
    {
        return $this->returnOne($this->get(self::SERVICE_OPERATING_SYSTEM)->whereId($id)->send());
    }

    /**
     * @return OperatingSystem[]
     */
    public function getOperatingSystems()
    {
        return $this->get(self::SERVICE_OPERATING_SYSTEM, false)->send();
    }

    /**
     * @param int $id
     * @return PlatformMember
     */
    public function getPlatformMember($id)
    {
        return $this->returnOne($this->get(self::SERVICE_PLATFORM_MEMBER)->whereId($id)->send());
    }

    /**
     * @return PlatformMember[]
     */
    public function getPlatformMembers()
    {
        return $this->get(self::SERVICE_PLATFORM_MEMBER, false)->send();
    }

    /**
     * @param int $id
     * @return TechnicalAttribute
     */
    public function getTechnicalAttribute($id)
    {
        return $this->returnOne($this->get(self::SERVICE_TECHNICAL_ATTRIBUTE)->whereId($id)->send());
    }

    /**
     * @return TechnicalAttribute[]
     */
    public function getTechnicalAttributes()
    {
        return $this->get(self::SERVICE_TECHNICAL_ATTRIBUTE, false)->send();
    }
}
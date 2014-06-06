<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

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

class ServiceFactory implements IServiceFactory
{
    /**
     * @return Brand
     */
    public function newBrandInstance()
    {
        return new Brand();
    }

    /**
     * @param array $data
     * @return Brand[]
     */
    public function newBrandCollection(array $data)
    {
        return $this->newCollection("newBrandInstance", $data);
    }

    /**
     * @return Carrier
     */
    public function newCarrierInstance()
    {
        return new Carrier();
    }

    /**
     * @param array $data
     * @return Carrier[]
     */
    public function newCarrierCollection(array $data)
    {
        return $this->newCollection("newCarrierInstance", $data);
    }

    /**
     * @return Category
     */
    public function newCategoryInstance()
    {
        return new Category();
    }

    /**
     * @param array $data
     * @return Category[]
     */
    public function newCategoryCollection(array $data)
    {
        return $this->newCollection("newCategoryInstance", $data);
    }

    /**
     * @return DeviceMake
     */
    public function newDeviceMakeInstance()
    {
        return new DeviceMake();
    }

    /**
     * @param array $data
     * @return DeviceMake[]
     */
    public function newDeviceMakeCollection(array $data)
    {
        return $this->newCollection("newDeviceMakeInstance", $data);
    }

    /**
     * @return DeviceModel
     */
    public function newDeviceModelInstance()
    {
        return new DeviceModel();
    }

    /**
     * @param array $data
     * @return DeviceModel[]
     */
    public function newDeviceModelCollection(array $data)
    {
        return $this->newCollection("newDeviceModelInstance", $data);
    }

    /**
     * @return DomainAuditStatus
     */
    public function newDomainAuditStatusInstance()
    {
        return new DomainAuditStatus();
    }

    /**
     * @param array $data
     * @return DomainAuditStatus[]
     */
    public function newDomainAuditStatusCollection(array $data)
    {
        return $this->newCollection("newDomainAuditStatusInstance", $data);
    }

    /**
     * @return Language
     */
    public function newLanguageInstance()
    {
        return new Language();
    }

    /**
     * @param array $data
     * @return Language[]
     */
    public function newLanguageCollection(array $data)
    {
        return $this->newCollection("newLanguageInstance", $data);
    }

    /**
     * @return OperatingSystem
     */
    public function newOperatingSystemInstance()
    {
        return new OperatingSystem();
    }

    /**
     * @param array $data
     * @return OperatingSystem[]
     */
    public function newOperatingSystemCollection(array $data)
    {
        return $this->newCollection("newOperatingSystemInstance", $data);
    }

    /**
     * @return PlatformMember
     */
    public function newPlatformMemberInstance()
    {
        return new PlatformMember();
    }

    /**
     * @param array $data
     * @return PlatformMember[]
     */
    public function newPlatformMemberCollection(array $data)
    {
        return $this->newCollection("newPlatformMemberInstance", $data);
    }

    /**
     * @return TechnicalAttribute
     */
    public function newTechnicalAttributeInstance()
    {
        return new TechnicalAttribute();
    }

    /**
     * @param array $data
     * @return TechnicalAttribute[]
     */
    public function newTechnicalAttributeCollection(array $data)
    {
        return $this->newCollection("newTechnicalAttributeInstance", $data);
    }

    /**
     * @param string $instanceMethod
     * @param array  $collectionData
     * @return AbstractGetService[]
     */
    private function newCollection($instanceMethod, array $collectionData)
    {
        $collection = array();

        foreach ($collectionData as $data) {
            $obj = $this->$instanceMethod()->import($data);
            $collection[$obj->getId()] = $obj;
        }

        return $collection;
    }
}

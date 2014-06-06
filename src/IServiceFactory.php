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

interface IServiceFactory
{
    /**
     * @return Brand
     */
    public function newBrandInstance();

    /**
     * @param array $data
     * @return Brand[]
     */
    public function newBrandCollection(array $data);

    /**
     * @return Carrier
     */
    public function newCarrierInstance();

    /**
     * @param array $data
     * @return Carrier[]
     */
    public function newCarrierCollection(array $data);

    /**
     * @return Category
     */
    public function newCategoryInstance();

    /**
     * @param array $data
     * @return Category[]
     */
    public function newCategoryCollection(array $data);

    /**
     * @return DeviceMake
     */
    public function newDeviceMakeInstance();

    /**
     * @param array $data
     * @return DeviceMake[]
     */
    public function newDeviceMakeCollection(array $data);

    /**
     * @return DeviceModel
     */
    public function newDeviceModelInstance();

    /**
     * @param array $data
     * @return DeviceModel[]
     */
    public function newDeviceModelCollection(array $data);

    /**
     * @return DomainAuditStatus
     */
    public function newDomainAuditStatusInstance();

    /**
     * @param array $data
     * @return DomainAuditStatus[]
     */
    public function newDomainAuditStatusCollection(array $data);

    /**
     * @return Language
     */
    public function newLanguageInstance();

    /**
     * @param array $data
     * @return Language[]
     */
    public function newLanguageCollection(array $data);

    /**
     * @return OperatingSystem
     */
    public function newOperatingSystemInstance();

    /**
     * @param array $data
     * @return OperatingSystem[]
     */
    public function newOperatingSystemCollection(array $data);

    /**
     * @return PlatformMember
     */
    public function newPlatformMemberInstance();

    /**
     * @param array $data
     * @return PlatformMember[]
     */
    public function newPlatformMemberCollection(array $data);

    /**
     * @return TechnicalAttribute
     */
    public function newTechnicalAttributeInstance();

    /**
     * @param array $data
     * @return TechnicalAttribute[]
     */
    public function newTechnicalAttributeCollection(array $data);
} 

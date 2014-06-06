<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractGetService;
use SWCO\AppNexusAPI\Services\PlatformMember\Bidder;
use SWCO\AppNexusAPI\Services\PlatformMember\ContactInfo;
use SWCO\AppNexusAPI\Services\PlatformMember\VisibilityRules;

class PlatformMember extends AbstractGetService
{
    /**
     * The ID of the member.
     *
     * @var int
     */
    protected $id;

    /**
     * The name of the member.
     *
     * @var string
     */
    protected $name;

    /**
     * The type of member, which indicates the primary type of transactions this member performs with AppNexus. Possible
     * values: "network", "buyer", "seller", or "data_provider".
     *
     * @var string
     */
    protected $primaryType;

    /**
     * The visibility of the member on the platform. Possible values:
     *   "public" - The member name is shown
     *   "private" - Only the member ID is shown
     *   "hidden" - The member is not shown by this service at all
     *
     * @var string
     */
    protected $platformExposure;

    /**
     * The email address to use to contact the member.
     *
     * @var string
     */
    protected $email;

    /**
     * The number of daily impressions through inventory that has any audit status, to include: unaudited,
     * AppNexus-reviewed, seller-reviewed, and both AppNexus- and seller-reviewed.
     *
     * @var int
     */
    protected $dailyImpressionsAnyAuditStatus;

    /**
     * The number of daily impressions through inventory that has been audited by AppNexus.
     *
     * @var int
     */
    protected $dailyImpressionsAppNexusReviewed;

    /**
     * The number of daily impressions through inventory that has one of these three audit statuses: seller-reviewed,
     * AppNexus-reviewed, and both seller- and AppNexus-reviewed.
     *
     * @var int
     */
    protected $dailyImpressionsAppNexusSellerReviewed;

    /**
     * If true, the member is IASH compliant.
     *
     * @var bool
     */
    protected $IASHCompliant;

    /**
     * If true, the member has exposed inventory for resale to other members. You can use the Inventory Resold Service
     * to view information about the exposed inventory.
     *
     * @var bool
     */
    protected $resold;

    /**
     * The level of detail included in the member's bid requests, if primary_type is "seller".
     *
     * @var PlatformMember\VisibilityRules
     */
    protected $visibilityRules;

    /**
     * The ID and name of the bidder that that member uses to buy impressions.
     *
     * @var PlatformMember\Bidder
     */
    protected $bidder;

    /**
     * The selling relationship between the member and AppNexus. Possible values:
     *   "platform" - AppNexus charges the member for selling inventory based on the member's contract
     *   "partner" - AppNexus does not charge the member for selling but rather charges buyers, based on their
     *               contracts, when they buy this member's inventory
     *
     * @var string
     */
    protected $sellerType;

    /**
     * The contact and additional info for the member.
     *
     * @var PlatformMember\ContactInfo
     */
    protected $contactInfo;

    /**
     * If true, the member is active.
     *
     * @var bool
     */
    protected $active;

    /**
     * The date and time when the member entry was last modified.
     *
     * @var \DateTime
     */
    protected $lastModified;

    /**
     * The percent that AppNexus deducts from each bid for certain external supply partners based on past discrepancies
     * between what AppNexus and the supply partner recorded as won impressions.
     *
     * @var float
     */
    protected $defaultDiscrepancyPCT;

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->id                                     = $data['id'];
        $this->name                                   = $data['name'];
        $this->primaryType                            = $data['primary_type'];
        $this->platformExposure                       = $data['platform_exposure'];
        $this->email                                  = $data['email'];
        $this->dailyImpressionsAnyAuditStatus         = $data['daily_imps_any_audit_status'];
        $this->dailyImpressionsAppNexusReviewed       = $data['daily_imps_appnexus_reviewed'];
        $this->dailyImpressionsAppNexusSellerReviewed = $data['daily_imps_appnexus_seller_reviewed'];
        $this->IASHCompliant                          = $data['is_iash_compliant'];
        $this->resold                                 = $data['has_resold'];
        $visibilityRules                              = new VisibilityRules();
        $this->visibilityRules                        = $visibilityRules->import($data['visibility_rules']);
        $bidder                                       = new Bidder();
        $this->bidder                                 = $bidder->import($data['bidder']);
        $this->sellerType                             = $data['seller_type'];
        $this->contactInfo                            = new ContactInfo();
        $this->active                                 = $data['active'];
        $this->lastModified                           = \DateTime::createFromFormat(
            "Y-m-d H:i:s",
            $data['last_modified']
        );
        $this->defaultDiscrepancyPCT                  = $data['default_discrepancy_pct'];

        if ($data['contact_info'] !== null) {
            $this->contactInfo = $this->contactInfo->import($data['contact_info']);
        }

        return $this;
    }
}

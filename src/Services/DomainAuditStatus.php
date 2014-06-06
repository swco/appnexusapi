<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractGetService;

class DomainAuditStatus extends AbstractGetService
{
    /**
     * The AppNexus ID for the domain.
     *
     * @var int
     */
    protected $id;

    /**
     * The domain.
     *
     * @var string
     */
    protected $url;

    /**
     * If audit_status is "rejected" or "unauditable", the reason provided by AppNexus.
     *
     * @var string
     */
    protected $reason;

    /**
     * The content category of the domain, as determined by AppNexus. If audit_status is "rejected", this will be null.
     * You can use the read-only Content Category Service to view more details about specific content categories.
     *
     * @var int
     */
    protected $contendCategoryId;

    /**
     * The intended audience of the domain, as determined by AppNexus. Possible values: "mature", "young_adult",
     * "children", or "general". If audit_status is "rejected", this will be null.
     *
     * @var string
     */
    protected $intendedAudience;

    /**
     * The audit status of the domain. Possible values: "unaudited", "pending", "audited", "rejected", "unauditable",
     * or "is_adserver".
     *
     * @var string
     */
    protected $auditStatus;

    /**
     * The date and time when the domain was audited by AppNexus.
     *
     * @var \DateTime
     */
    protected $auditDatetime;

    /**
     * If true, the domain is on the AppNexus platform.
     *
     * @var bool
     */
    protected $found;

    /**
     * @return bool
     */
    public function supportsSince()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function needsPost()
    {
        return true;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->url   = $data['url'];
        $this->found = $data['found'];

        if ($this->found) {
            $this->id                = $data['id'];
            $this->reason            = $data['reason'];
            $this->contendCategoryId = $data['content_category_id'];
            $this->intendedAudience  = $data['intended_audience'];
            $this->auditStatus       = $data['audit_status'];
            if ($data['audit_datetime']) {
                $this->auditDatetime = \DateTime::createFromFormat("Y-m-d H:i:s", $data['audit_datetime']);
            }
        }

        return $this;
    }
}

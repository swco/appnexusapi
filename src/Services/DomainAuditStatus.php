<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractCoreService;

class DomainAuditStatus extends AbstractCoreService
{
    /**
     * The AppNexus ID for the domain.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The domain.
     *
     * @var string
     */
    protected $url = '';

    /**
     * If audit_status is "rejected" or "unauditable", the reason provided by AppNexus.
     *
     * @var string
     */
    protected $reason = '';

    /**
     * The content category of the domain, as determined by AppNexus. If audit_status is "rejected", this will be null.
     * You can use the read-only Content Category Service to view more details about specific content categories.
     *
     * @var int
     */
    protected $contendCategoryId = 0;

    /**
     * The intended audience of the domain, as determined by AppNexus. Possible values: "mature", "young_adult",
     * "children", or "general". If audit_status is "rejected", this will be null.
     *
     * @var string
     */
    protected $intendedAudience = '';

    /**
     * The audit status of the domain. Possible values: "unaudited", "pending", "audited", "rejected", "unauditable",
     * or "is_adserver".
     *
     * @var string
     */
    protected $auditStatus = '';

    /**
     * The date and time when the domain was audited by AppNexus.
     *
     * @var \DateTime
     */
    protected $auditDatetime;

    /**
     * If true, the domain is on the AppNexus platform.
     *
     * @var boolean
     */
    protected $found = false;

    /**
     * @return boolean
     */
    public function supportsSince()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getRequestVerb()
    {
        return 'post';
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
            $this->reason            = $data['reason'] ? : '';
            $this->contendCategoryId = $data['content_category_id'] ? : 0;
            $this->intendedAudience  = $data['intended_audience'] ? : '';
            $this->auditStatus       = $data['audit_status'];
            if ($data['audit_datetime']) {
                $this->auditDatetime = \DateTime::createFromFormat("Y-m-d H:i:s", $data['audit_datetime']);
            }
        }

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getAuditDatetime()
    {
        return $this->auditDatetime;
    }

    /**
     * @return string
     */
    public function getAuditStatus()
    {
        return $this->auditStatus;
    }

    /**
     * @return int
     */
    public function getContendCategoryId()
    {
        return $this->contendCategoryId;
    }

    /**
     * @return boolean
     */
    public function isFound()
    {
        return $this->found;
    }

    /**
     * @return string
     */
    public function getIntendedAudience()
    {
        return $this->intendedAudience;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}

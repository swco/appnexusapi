<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services\PlatformMember;

use SWCO\AppNexusAPI\AbstractService;

class VisibilityRules extends AbstractService
{
    /**
     * If true, the seller sends publisher IDs in bid requests.
     *
     * @var bool
     */
    protected $exposePublishers;

    /**
     * If true, the seller sends placement IDs in bid requests.
     *
     * @var bool
     */
    protected $exposeTags;

    /**
     * If true, the seller sends the age of users in bid requests.
     *
     * @var bool
     */
    protected $exposeAge;

    /**
     * If true, the seller sends the gender of users in bid requests.
     *
     * @var bool
     */
    protected $exposeGender;

    /**
     * If true, the seller sends AppNexus-defined universal content categories in bid requests.
     *
     * @var bool
     */
    protected $exposeUniversalCategories;

    /**
     * The visibility of custom content categories in the seller's bid requests. Possible values:
     *   "none" - No custom categories are passed in bid requests
     *   "all" - All custom categories are passed in bid requests
     *   "list" - The custom categories listed in the custom_categories array are passed in bid requests
     *
     * @var string
     */
    protected $exposeCustomCategories;

    /**
     * The custom content categories that the seller passes in bid requests, if expose_custom_categories is "list".
     *
     * @var \stdClass[]
     */
    protected $customCategories;

    /**
     * The visibility of impression urls in the seller's bid requests. Possible values:
     *   "full" - Full URLs are passed in bid requests
     *   "domain" - Only domains of URLs are passed in bid requests
     *   "hidden" - URLs are not passed in bid requests (Note that you may still receive the seller's default URL, if
     *              the seller has one configured)
     * @var string
     */
    protected $urlExposure;

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->exposePublishers                                     = $data['expose_publishers'];
        $this->exposeTags                                   = $data['expose_tags'];
        $this->exposeAge                            = $data['expose_age'];
        $this->exposeGender                       = $data['expose_gender'];
        $this->exposeUniversalCategories         = $data['expose_universal_categories'];
        $this->exposeCustomCategories       = $data['expose_custom_categories'];
        $this->urlExposure = $data['url_exposure'];

        if (is_array($data['custom_categories'])) {
            foreach ($data['custom_categories'] as $customCategory) {
                $this->customCategories[] = (object)$customCategory;
            }
        }

        return $this;
    }
}

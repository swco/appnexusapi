<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractGetService;
use SWCO\AppNexusAPI\Services\DeviceModel\Code;

class DeviceModel extends AbstractGetService
{
    /**
     * The ID of the device model.
     *
     * @var int
     */
    protected $id;

    /**
     * The name of the device model, i.e., "IPhone".
     *
     * @var string
     */
    protected $name;

    /**
     * The ID of the device make to which the model belongs. For example, the "IPhone" device model would belong to the
     * "Apple" device make.
     *
     * @var int
     */
    protected $deviceMakeId;

    /**
     * The type of device. Possible values: "pc", "phone", or "tablet".
     *
     * @var string
     */
    protected $deviceType;

    /**
     * The width of the screen on the device.
     *
     * @var int
     */
    protected $screenWidth;

    /**
     * The height of the screen on the device.
     *
     * @var int
     */
    protected $screenHeight;

    /**
     * Not yet available.
     *
     * If true, the device supports JavaScript creatives. If null, AppNexus does not know whether or not the device
     * supports JavaScript.
     *
     * @var bool
     */
    protected $supportsJS;

    /**
     * Not yet available.
     *
     * If true, the device supports cookies. If null, AppNexus does not know whether or not the device supports cookies.
     *
     * @var bool
     */
    protected $supportsCookies;

    /**
     * Not yet available.
     *
     * If true, the device supports Flash creatives. If null, AppNexus does not know whether or not the device supports
     * Flash.
     *
     * @var bool
     */
    protected $supportsFlash;

    /**
     * Not yet available.
     *
     * If true, the device can pass the latitude and longitude of users, when GPS data is available.
     *
     * @var bool
     */
    protected $supportsGEO;

    /**
     * Not yet available.
     *
     * If true, the device supports HTML video creatives. If null, AppNexus does not know whether or not the device
     * supports HTML video.
     *
     * @var bool
     */
    protected $supportsHTMLVideo;

    /**
     * Not yet available.
     *
     * If true, the device supports HTML audio creatives. If null, AppNexus does not know whether or not the device
     * supports HTML audio.
     *
     * @var bool
     */
    protected $supportsHTMLAudio;

    /**
     * Not yet available.
     *
     * The name of the device make to which the model belongs.
     *
     * @var string
     */
    protected $deviceMakeName;

    /**
     * Third-party representations for the device model.
     *
     * @var DeviceModel\Code[]
     */
    protected $codes;

    /**
     * @return bool
     */
    public function supportsSince()
    {
        return false;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->id                = $data['id'];
        $this->name              = $data['name'];
        $this->deviceMakeId      = $data['device_make_id'];
        $this->deviceType        = $data['device_type'];
        $this->screenWidth       = $data['screen_width'];
        $this->screenHeight      = $data['screen_height'];
        $this->supportsJS        = $data['supports_js'];
        $this->supportsCookies   = $data['supports_cookies'];
        $this->supportsFlash     = $data['supports_flash'];
        $this->supportsGEO       = $data['supports_geo'];
        $this->supportsHTMLVideo = $data['supports_html_video'];
        $this->supportsHTMLAudio = $data['supports_html_audio'];
        $this->deviceMakeName    = $data['device_make_name'];

        foreach ($data['codes'] as $code) {
            $codeObj       = new Code();
            $this->codes[] = $codeObj->import($code);
        }

        return $this;
    }
}

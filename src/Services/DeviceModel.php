<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI\Services;

use SWCO\AppNexusAPI\AbstractCoreService;
use SWCO\AppNexusAPI\Services\DeviceModel\Code;

class DeviceModel extends AbstractCoreService
{
    /**
     * The ID of the device model.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The name of the device model, i.e., "IPhone".
     *
     * @var string
     */
    protected $name = '';

    /**
     * The ID of the device make to which the model belongs. For example, the "IPhone" device model would belong to the
     * "Apple" device make.
     *
     * @var int
     */
    protected $deviceMakeId = 0;

    /**
     * The type of device. Possible values: "pc", "phone", or "tablet".
     *
     * @var string
     */
    protected $deviceType = '';

    /**
     * The width of the screen on the device.
     *
     * @var int
     */
    protected $screenWidth = 0;

    /**
     * The height of the screen on the device.
     *
     * @var int
     */
    protected $screenHeight = 0;

    /**
     * Not yet available.
     *
     * If true, the device supports JavaScript creatives. If null, AppNexus does not know whether or not the device
     * supports JavaScript.
     *
     * @var boolean
     */
    protected $supportsJS = false;

    /**
     * Not yet available.
     *
     * If true, the device supports cookies. If null, AppNexus does not know whether or not the device supports cookies.
     *
     * @var boolean
     */
    protected $supportsCookies = false;

    /**
     * Not yet available.
     *
     * If true, the device supports Flash creatives. If null, AppNexus does not know whether or not the device supports
     * Flash.
     *
     * @var boolean
     */
    protected $supportsFlash = false;

    /**
     * Not yet available.
     *
     * If true, the device can pass the latitude and longitude of users, when GPS data is available.
     *
     * @var boolean
     */
    protected $supportsGEO = false;

    /**
     * Not yet available.
     *
     * If true, the device supports HTML video creatives. If null, AppNexus does not know whether or not the device
     * supports HTML video.
     *
     * @var boolean
     */
    protected $supportsHTMLVideo = false;

    /**
     * Not yet available.
     *
     * If true, the device supports HTML audio creatives. If null, AppNexus does not know whether or not the device
     * supports HTML audio.
     *
     * @var boolean
     */
    protected $supportsHTMLAudio = false;

    /**
     * Not yet available.
     *
     * The name of the device make to which the model belongs.
     *
     * @var string
     */
    protected $deviceMakeName = '';

    /**
     * Third-party representations for the device model.
     *
     * @var DeviceModel\Code[]
     */
    protected $codes = array();

    /**
     * @return boolean
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
        $this->screenWidth       = $data['screen_width'] ? : 0;
        $this->screenHeight      = $data['screen_height'] ? : 0;
        $this->supportsJS        = $data['supports_js'];
        $this->supportsCookies   = $data['supports_cookies'];
        $this->supportsFlash     = $data['supports_flash'];
        $this->supportsGEO       = $data['supports_geo'];
        $this->supportsHTMLVideo = $data['supports_html_video'];
        $this->supportsHTMLAudio = $data['supports_html_audio'];
        $this->deviceMakeName    = $data['device_make_name'];

        if (isset($data['codes']) && $data['codes']) {
            foreach ($data['codes'] as $code) {
                $codeObj       = new Code();
                $this->codes[] = $codeObj->import($code);
            }
        }

        return $this;
    }

    /**
     * @return DeviceModel\Code[]
     */
    public function getCodes()
    {
        return $this->codes;
    }

    /**
     * @return int
     */
    public function getDeviceMakeId()
    {
        return $this->deviceMakeId;
    }

    /**
     * @return string
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getScreenHeight()
    {
        return $this->screenHeight;
    }

    /**
     * @return int
     */
    public function getScreenWidth()
    {
        return $this->screenWidth;
    }
}

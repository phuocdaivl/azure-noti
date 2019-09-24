<?php
namespace DaiDP\AzureNoti;

use DaiDP\AzureNoti\Platform\AppleEndpoint;
use DaiDP\AzureNoti\Platform\GoogleEndpoint;
use DaiDP\AzureNoti\Platform\PlatformEndpoint;

/**
 * Class PlatformFactory
 * @package DaiDP\AzureNoti
 * @author DaiDP
 * @since Sep, 2019
 */
class PlatformFactory
{
    const ENDPOINT_APPLE = 'apple';
    const ENDPOINT_FCM   = 'fcm';

    /**
     * Get endpoint notification
     *
     * @param $name
     * @return PlatformEndpoint
     * @throws \Exception
     */
    public static function getEndpoint($name)
    {
        switch ($name)
        {
            case self::ENDPOINT_APPLE:
                return app()->get(AppleEndpoint::class);

            case self::ENDPOINT_FCM:
                return app()->get(GoogleEndpoint::class);
        }

        throw new \Exception('Can\'t find endpoint "'. $name .'"');
    }
}
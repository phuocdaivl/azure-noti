<?php
namespace DaiDP\AzureNoti;

use DaiDP\AzureNoti\Support\Setable;

/**
 * Class Message
 * @package DaiDP\AzureNoti
 * @author DaiDP
 * @since Sep, 2019
 */
class Message extends Setable
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $body;

    /**
     * @var int
     */
    public $badges;

    /**
     * @var array
     */
    public $data = [];

    /**
     * @var string
     */
    public $notification_id;
}
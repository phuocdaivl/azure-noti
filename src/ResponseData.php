<?php
namespace DaiDP\AzureNoti;

use DaiDP\AzureNoti\Support\Setable;

/**
 * Class ResponseData
 * @package namespace DaiDP\AzureNoti;
 * @author DaiDP
 * @since Sep, 2019
 */
class ResponseData
{
    public $error;
    public $data;

    /**
     * ResponseData constructor.
     * @param $error
     * @param $data
     */
    public function __construct($error, $data)
    {
        $this->error = $error;
        $this->data  = $data;
    }
}
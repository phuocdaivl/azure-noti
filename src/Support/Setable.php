<?php
namespace DaiDP\AzureNoti\Support;

/**
 * Class Setable
 * @package DaiDP\AzureNoti\Support
 * @author DaiDP
 * @since Sep, 2019
 */
abstract class Setable
{
    /**
     * Setable constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        foreach ($data as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
    }

    /**
     * Convert message to array
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
<?php
namespace DaiDP\AzureNoti\Support;

/**
 * Class Token
 * @package DaiDP\AzureNoti\Support
 * @author DaiDP
 * @since Sep, 2019
 */
class Token
{
    protected $ttl;
    protected $endpoint;
    protected $hubPath;
    protected $sasKeyName;
    protected $sasKeyValue;


    /**
     * Token constructor.
     * @param $connectString
     * @param $hubPath
     * @param int $ttl Time in Minus
     * @throws \Exception
     */
    public function __construct($connectString, $hubPath, $ttl = 60)
    {
        $this->hubPath = $hubPath;
        $this->ttl     = $ttl;

        $this->parseConnectionString($connectString);
    }

    /**
     * Create Azure Authorization token
     *
     * @param $uri
     * @return string
     */
    public function generateSasToken($uri)
    {
        $targetUri = strtolower(rawurlencode(strtolower($uri)));

        $expires       = time();
        $expires       = $expires + $this->ttl * 60;
        $toSign        = $targetUri . "\n" . $expires;

        $signature = rawurlencode(base64_encode(hash_hmac('sha256', $toSign, $this->sasKeyValue, TRUE)));

        $token = "SharedAccessSignature sr=" . $targetUri . "&sig=" . $signature . "&se=" . $expires . "&skn=" . $this->sasKeyName;

        return $token;
    }

    /**
     * Get azure service endpoint
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Get azure hub path
     * @return string
     */
    public function getHubPath()
    {
        return $this->hubPath;
    }

    /**
     * Get azure namespace
     * @return string
     */
    public function getNamespace()
    {
        $part = explode('/', $this->hubPath);
        return end($part);
    }

    /**
     * Parse connection string
     *
     * @param $connectionString
     * @throws \Exception
     */
    protected function parseConnectionString($connectionString)
    {
        $parts = explode(";", $connectionString);
        if (sizeof($parts) != 3) {
            throw new \Exception("Error parsing connection string: " . $connectionString);
        }

        foreach ($parts as $part) {
            if (strpos($part, "Endpoint") === 0) {
                $this->endpoint = "https" . substr($part, 11);
            } else if (strpos($part, "SharedAccessKeyName") === 0) {
                $this->sasKeyName = substr($part, 20);
            } else if (strpos($part, "SharedAccessKey") === 0) {
                $this->sasKeyValue = substr($part, 16);
            }
        }
    }
}
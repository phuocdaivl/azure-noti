<?php
namespace DaiDP\AzureNoti\Platform;

use DaiDP\AzureNoti\HttpClient;
use DaiDP\AzureNoti\Message;
use DaiDP\AzureNoti\ResponseData;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PlatformEndpoint
 * @package DaiDP\AzureNoti\Platform
 * @author DaiDP
 * @since Sep, 2019
 */
abstract class PlatformEndpoint
{
    protected $client;


    /**
     * PlatformEndpoint constructor.
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send a native notification
     *
     * @param $deviceToken
     * @param Message $message
     * @return ResponseData
     */
    abstract public function sendNativeNotification($deviceToken, Message $message);

    /**
     * Build registration payload
     *
     * @param $token
     * @param array $tags
     * @return mixed
     */
    abstract protected function genRegistrationPayload($token, array $tags);

    /**
     * Creates a new registration. This method generates a registration ID, which you can subsequently use to retrieve,
     * update, and delete this registration
     * use ResponseData.data.title to get registration ID
     * @see https://docs.microsoft.com/en-us/previous-versions/azure/reference/dn223265%28v%3dazure.100%29#response-body
     *
     * @param $token
     * @param array $tags
     * @return ResponseData
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createRegistration($token, array $tags)
    {
        $response = $this->client->post('/registrations', [
            'body' => $this->genRegistrationPayload($token, $tags),
            'headers' => [
                'Content-Type' => 'application/xml'
            ]
        ]);

        return $this->parseResponse($response);
    }

    /**
     * Convert xml to array
     *
     * @param $xmlString
     * @return mixed
     */
    protected function convertXmlToArray($xmlString)
    {
        $xml  = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        return json_decode($json,TRUE);
    }

    /**
     * Parse response data
     *
     * @param ResponseInterface $response
     * @return ResponseData
     */
    protected function parseResponse(ResponseInterface $response)
    {
        $isError = !in_array($response->getStatusCode(), [200, 201]);
        $rspData = $this->convertXmlToArray($response->getBody()->getContents());

        return new ResponseData(intval($isError), $rspData);
    }
}
<?php
namespace DaiDP\AzureNoti;

use DaiDP\AzureNoti\Support\Token;
use GuzzleHttp\Client;

class HttpClient
{
    const API_VERSION = '?api-version=2015-01';

    /**
     * @var Token
     */
    protected $token;


    /**
     * HttpClient constructor.
     */
    public function __construct()
    {
        $this->token = app()->get('daidp.azure_noti.token');
    }

    /**
     * Post action
     *
     * @param $action
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($action, array $options = [])
    {
        return $this->request('POST', $action, $options);
    }


    /**
     * Request to Azure service
     *
     * @param $method
     * @param $action
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $action, array $options = [])
    {
        $uri = $this->token->getEndpoint() . $this->token->getNamespace();
        $uri .= $action . self::API_VERSION;

        // Tạo header
        $headers = $options['headers'] ?? [];
        $headers['Authorization'] = $this->token->generateSasToken($uri);
        $options['headers'] = $headers;

        $oClient = new Client([
            'http_errors' => false
        ]);

        return $oClient->request($method, $uri, $options);
    }
}
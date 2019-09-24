<?php
namespace DaiDP\AzureNoti\Platform;

use DaiDP\AzureNoti\Message;

/**
 * Class AppleEndpoint
 * @package DaiDP\AzureNoti\Platform
 * @author DaiDP
 * @since Sep, 2019
 */
class AppleEndpoint extends PlatformEndpoint
{
    /**
     * Send a native notification
     *
     * @param $deviceToken
     * @param Message $message
     * @return \DaiDP\AzureNoti\ResponseData
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendNativeNotification($deviceToken, Message $message)
    {
        $response = $this->client->post('/messages', [
            'json' => $this->genNotificationPayload($message),
            'headers' => [
                'Content-Type' => 'application/json;charset=utf-8',
                'ServiceBusNotification-DeviceHandle' => $deviceToken,
                'ServiceBusNotification-Format' => 'apple'
            ]
        ]);

        return $this->parseResponse($response);
    }

    /**
     * Build registration payload
     * @see https://docs.microsoft.com/en-us/previous-versions/azure/reference/dn223265%28v%3dazure.100%29#request-body
     *
     * @param $token
     * @param array $tags
     * @return string
     */
    protected function genRegistrationPayload($token, array $tags)
    {
        $tags = implode(',', $tags);

        $payload  = '<?xml version="1.0" encoding="utf-8"?>';
        $payload .= '<entry xmlns="http://www.w3.org/2005/Atom">';
        $payload .= '    <content type="application/xml">';
        $payload .= '        <AppleRegistrationDescription xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.microsoft.com/netservices/2010/10/servicebus/connect">';
        $payload .= '            <Tags>'. $tags .'</Tags>';
        $payload .= '            <GcmRegistrationId>'. $token .'</GcmRegistrationId> ';
        $payload .= '        </AppleRegistrationDescription>';
        $payload .= '    </content>';
        $payload .= '</entry>';

        return $payload;
    }

    /**
     * Build notification payload
     *
     * @param Message $message
     * @return array
     */
    public function genNotificationPayload(Message $message)
    {
        $payload = [
            'aps' => [
                'alert' => [
                    'title' => $message->title,
                    'body' => $message->body
                ],
                'badges' => $message->badges,
                //'sound' => 'chime.aiff'
            ],
            'data' => [
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                'notification_id' => '' . $message->notification_id
            ]
        ];

        $payload['data'] = array_merge($payload['data'], $message->data);

        return $payload;
    }
}
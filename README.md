# DaiDP Azure Notification
Create Registration and send notification

[![Latest Version on Packagist](https://img.shields.io/packagist/v/phuocdaivl/azure-noti?style=flat-square)](https://packagist.org/packages/phuocdaivl/azure-noti)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/phuocdaivl/azure-noti/master.svg?style=flat-square)](https://travis-ci.org/phuocdaivl/azure-noti)
[![Total Downloads](https://img.shields.io/packagist/dt/phuocdaivl/azure-noti.svg?style=flat-square)](https://packagist.org/packages/phuocdaivl/azure-noti)

## Download & Install
```bash
composer require phuocdaivl/azure-noti
```

## Add service provider
Add the service provider to the providers array in the <span style='color:red'>`config/app.php`</span> config file as follows:

```bash
'providers' => [

    ...

    DaiDP\AzureNoti\Providers\AzureNotiServiceProvider::class,
]
```

Well done.

### Basic use:
```bash
use \DaiDP\AzureNoti\PlatformFactory;

$endpoint = PlatformFactory::getEndpoint(PlatformFactory::ENDPOINT_FCM);
```

### Methods
The following methods are available on the PlatformEndpoint instance.

#### createRegistration()
Create or update Registration ID
```bash
$fcmRegistration = 'fPDLWe0fKpY:APA91bHocOJCoKx5GV9ETT0bUmJDQAWiT8Ql4zFB5Ycr_sAm6tQ6aOmcTnGC3LwiyCa-beaXZoWrkxWTDvBkUVE8Th_XWNQUdzeNlbZ2MmT-lVj4Gxe4baoqVYYtmoAvZvZxghPZirOo';
$tags = ['tag1', 'tag2'];
$result = $endpoint->createRegistration($fcmRegistration, $tags);
```

#### sendNativeNotification()
Set new password for account

```bash
$message = new \DaiDP\AzureNoti\Message([
    'title' => 'Test push notification',
    'body' => 'great match!'
]);
$fcmRegistration = 'fPDLWe0fKpY:APA91bHocOJCoKx5GV9ETT0bUmJDQAWiT8Ql4zFB5Ycr_sAm6tQ6aOmcTnGC3LwiyCa-beaXZoWrkxWTDvBkUVE8Th_XWNQUdzeNlbZ2MmT-lVj4Gxe4baoqVYYtmoAvZvZxghPZirOo';
$result = $endpoint->sendNativeNotification($device, $message);
```
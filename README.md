#### SMS Gateway Library
Simple library to interact with some SMS gateways to send SMS.

#### Installation
Please install this library with `composer`. Run the following composer command to add this library
```bash
composer require previewtechs/sms-gateway
```

#### Usage
```php
<?php

use Previewtechs\SMSGateway\Client;
use Previewtechs\SMSGateway\Providers\SSLWireless;
use Previewtechs\SMSGateway\SMS\Message;

require "vendor/autoload.php";

$sslWireless = new SSLWireless("SSL_WIRELESS_USERNAME", "SSL_WIRELESS_PASSWORD", "SSL_WIRELESS_SID");


$client = new Client($sslWireless);

$message = (new Message())
    ->setRecipient("8801717530114")
    ->setMessage("Final Testing");

try {
    $r = $client->send([$message]);
    echo $r->isSuccess() . PHP_EOL;
    print_r($r->getMessages());
} catch (Exception $e) {
    echo $e->getMessage();
}
```

#### Supported Providers
 - [SSL Wireless Limited, Bangladesh](http://www.sslwireless.com)


#### For Gateway Providers

If you have your own SMS gateway and you provide API. Please build your own provider and send us pull request.
We will add those here too. To build your own provider, please follow `src/ProviderInterface.php`.

If you have any questions, please feel free to create an Issue or write us at [shaharia@previewtechs.com](mailto:shaharia@previewtechs.com)


#### Contributors

Feel free to contribute in this library. Add your own provider and send us pull request.

#### Issue

If you have any issue, please write an issue in [https://github.com/PreviewTechnologies/sms-gateway/issues](https://github.com/PreviewTechnologies/sms-gateway/issues)
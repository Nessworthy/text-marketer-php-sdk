# Text Marketer SDK

An unofficial library-in-progress to assist with text marketer operations.

## Requirements

* PHP 7.1+
* ext_mbstring

## Composer

```
composer require nessworthy\textmarketer-php-sdk
```

## Example Usage

### Creating & Sending SMS Messages

```php
<?php

$apiCredentials = new Nessworthy\TextMarketer\Authentication\Simple('api_username', 'api_password');

$textMarketer = new \Nessworthy\TextMarketer\Endpoint\Sandbox\Sandbox($apiCredentials);

$messageCommand = new \Nessworthy\TextMarketer\Message\Command\SendMessage(
    'This is a test message',
    ['447777777777'],
    'Test Company Inc'
);

$deliveryResult = $textMarketer->sendMessage($messageCommand);

if ($deliveryResult->isSent()) {
    echo 'Message sent with the ID of ' . $deliveryResult->getMessageId();
} elseif ($deliveryResult->isQueued()) {
    echo 'Message queued with the ID of ' . $deliveryResult->getMessageId();
} elseif ($deliveryResult->isScheduled()) {
    echo 'Is scheduled with the ID of ' . $deliveryResult->getScheduledId();
}

```
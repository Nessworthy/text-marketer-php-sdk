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

$apiCredentials = new Nessworthy\TextMarketer\Authentication\SimpleAuthentication('api_username', 'api_password');

$textMarketer = /*new Endpoint($apiCredentials);*/

$messageCommand = new \Nessworthy\TextMarketer\Message\SendMessage(
    'This is a test message',
    ['447777777777'],
    'Test Company Inc'
);

$deliveryReport = $textMarketer->sendMessage($messageCommand);

```
# Text Marketer SDK

An unofficial library-in-progress to assist with text marketer operations.

## Requirements

* PHP 5.5+, PHP7+
* ext_mbstring

## Composer

```
composer require nessworthy\textmarketer-php-sdk
```

## Example Usage

### Creating & Sending SMS Messages

```php
<?php
use Nessworthy\TextMarketer\TextMarketer;
use Nessworthy\TextMarketer\Dispatcher\ProductionDispatcher;
use Nessworthy\TextMarketer\Message\SimpleMessage;
use Nessworthy\TextMarketer\Authentication\SimpleAuthentication;
use \Nessworthy\TextMarketer\Dispatcher\SMSDispatchFailedException;


// Your API credentials.
$authentication = new SimpleAuthentication('username', 'password');

$textDispatcher = new ProductionDispatcher($authentication);
// Alternatively, use SandBoxDispatcher for text marketer sandbox testing, or DevNullDispatcher for local testing.
// Or you can extend the Dispatcher interface and create your own (for example, to log internally).

$textMarketer = new TextMarketer($textDispatcher);

$message = new SimpleMessage('Hello World', ['447000000000'], 'Test Company Inc.');

try {
    $result = $textMarketer->sendSMS($message);
    echo sprintf('Message #%s dispatched!', $result->getMessageID());
} catch (SMSDispatchFailedException $e) {
    echo 'Dispatch failed: ' . $e->getMessage();
    // Or
    echo 'Dispatch failed: ' . implode("\n", $e->getAllErrors());
}
```
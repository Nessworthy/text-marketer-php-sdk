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

### Setting up:

```php
$apiCredentials = new \Nessworthy\TextMarketer\Authentication\Simple('api_username', 'api_password');

// Sandbox is TextMarketer's sandbox environment for testing.
$textMarketer = new \Nessworthy\TextMarketer\Endpoint\Sandbox($apiCredentials);
```

### Creating & Sending SMS Messages

```php
$messageCommand = new \Nessworthy\TextMarketer\Message\SendMessage(
    'This is a test message', // Your SMS Message.
    ['447777777777'],         // The array of contact numbers.
    'TestCompanyInc',         // Who the message was sent from.
    'testmessage',            // Optional: Tag your message for delivery report filtering.
    24,                       // Optional: Mark the message as time-sensitive: Should only be sent if it is within X hours.
    true,                     // Optional: If true, if any recipient is matched in your STOP group the message will not be sent.
    'myTxtUsEmail@address.com'// Optional: Your txtUS enterprise email (txtUS accounts only).
);

$deliveryResult = $textMarketer->sendMessage($messageCommand);
// Or to schedule a message:
// $scheduledDate = (new DateTimeImmutable)->modify('+1 month');
// $deliveryResult = $textMarketer->sendScheduledMessage($messageCommand, $scheduledDate); 

if ($deliveryResult->isSent()) {
    echo 'Message sent with the ID of ' . $deliveryResult->getMessageId();
} elseif ($deliveryResult->isQueued()) {
    echo 'Message queued with the ID of ' . $deliveryResult->getMessageId();
} elseif ($deliveryResult->isScheduled()) {
    echo 'Is scheduled with the ID of ' . $deliveryResult->getScheduledId();
}

// You can also delete scheduled messages using:
// $textMarketer->deleteScheduledMessage($scheduledMessageId);
```

### Handling & Transferring Credits ###

```php
// Retrieving your credit amount:
echo sprintf('I have %d remaining credits!', $textMarketer->getCreditCount());

// Transferring credits:
$transferResult = $textMarketer->transferCreditsToAccountById(100, $someAccountId);
// Or by credentials:
// $destinationCredentials = new \Nessworthy\TextMarketer\Authentication\Simple('username', 'password'));
// $transferResult = $textMarketer->transferCreditsToAccountByCredentials(100, $destinationCredentials);

echo sprintf(
    'I had %d credits. After transferring, I now have %d!',
    $transferResult->getSourceCreditsBeforeTransfer(),
    $transferResult->getSourceCreditsAfterTransfer()
);

echo sprintf(
    'The target account had %d credits. After transferring, it now has %d!',
    $transferResult->getTargetCreditsBeforeTransfer(),
    $transferResult->getTargetCreditsAfterTransfer()
);
```

### Keyword Availability ###

```php
$keyword = 'mykeyword';
$keywordAvailability = $textMarketer->checkKeywordAvailability($keyword);

echo sprintf(
    'The keyword "%s" %s available! It %s been recycled (used previously).',
    $keyword,
    ($keywordAvailability->isAvailable() ? 'is' : 'is not'),
    ($keywordAvailability->isRecycled() ? 'has' : 'has not')
);
```

### Group Management ###

### Delivery Reports ###

### Account Management ###

### Exception / Error Handling ###

```php
// All exceptions extend \Nessworthy\TextMarketer\TextMarketerException.
try {
    // Send a text marketer request.
} catch (\Nessworthy\TextMarketer\Endpoint\EndpointException $e) {
    // $e->getMessage() and $e->getCode() return the first message.
    // Or for all errors...
    foreach ($e->getAllEndpointErrors() as $error) {
        error_log(sprintf('TextMarketer Message Error: [%s] %s', $error->getCode(), $error->getMessage()));         
    }
}
```
# Text Marketer PHP SDK [![Build Status](https://travis-ci.org/Nessworthy/text-marketer-php-sdk.svg?branch=master)](https://travis-ci.org/Nessworthy/text-marketer-php-sdk)

An unofficial library-in-progress to assist with text marketer API interactions.

## Requirements

* PHP 7.2.5 or higher
* `ext-mbstring`
* `ext-dom`

## Composer

```
composer require nessworthy\textmarketer
```

## Example Usage

* [Setting Up](#setting-up)
* [Creating and Sending SMS Messages](#creating-and-sending-sms-messages)
    * [Scheduling Messages](#scheduling-messages)
    * [Deleting Scheduled Messages](#deleting-scheduled-messages)
* [Handling and Transferring Credits](#handling-and-transferring-credits)
    * [Fetching your Current Credits](#fetching-your-current-credits)
    * [Transferring Credits by Account ID or Credentials](#transferring-credits-by-account-id-or-credentials)
* [Keyword Availability](#keyword-availability)
* [Group Management](#group-management)
    * [Fetching your List of Groups](#fetching-your-list-of-groups)
    * [Adding One or More Numbers to a Group](#adding-one-or-more-numbers-to-a-group)
    * [Creating a New Group](#creating-a-new-group)
    * [Fetching Information for an Existing Group](#fetching-information-for-an-existing-group)
* [Delivery Reports](#delivery-reports)
    * [Filtering by Report Name](#filtering-by-report-name)
    * [Filtering by Report Name and Date Range](#filtering-by-report-name-and-date-range)
    * [Filtering by Report Name and Tag](#filtering-by-report-name-and-tag)
    * [Filtering by Report Name, Tag, and Date Range](#filtering-by-report-name-tag-and-date-range)
* [Account Management](#account-management)
    * [Fetching your Account Information](#fetching-your-account-information)
    * [Fetching Account Information by Account ID](#fetching-account-information-by-account-id)
    * [Updating Your Account Information](#updating-your-account-information)
    * [Creating a New Sub-Account](#creating-a-new-sub-account)
* [Exception and Error Handling](#exception-and-error-handling)

### Setting up

```php
$apiCredentials = new \Nessworthy\TextMarketer\Authentication\Simple('api_username', 'api_password');
$httpClient = new \GuzzleHttp\Client();

$textMarketer = new \Nessworthy\TextMarketer\TextMarketer($apiCredentials, $httpClient);
```

#### Parameters

* Credentials - An implementation of `\Nessworthy\TextMarketer\Authentication`
* Endpoint (optional) - The text marketer endpoint to use when sending out messages. Should be one of:
    * `\Nessworthy\TextMarketer\TextMarketer::ENDPOINT_PRODUCTION` (default)
    * `\Nessworthy\TextMarketer\TextMarketer::ENDPOINT_SANDBOX`
* HTTP Client (optional) - The HTTP client to send requests out.
    * Expects an implementation of  `GuzzleHttp\ClientInterface`
    * By default, an instance of `GuzzleHttp\Client` is used.

### Creating and Sending SMS Messages

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

if ($deliveryResult->isSent()) {
    echo 'Message sent with the ID of ' . $deliveryResult->getMessageId();
} elseif ($deliveryResult->isQueued()) {
    echo 'Message queued with the ID of ' . $deliveryResult->getMessageId();
} elseif ($deliveryResult->isScheduled()) {
    echo 'Is scheduled with the ID of ' . $deliveryResult->getScheduledId();
}
```

#### Scheduling Messages

```php
$scheduledDate = (new DateTimeImmutable)->modify('+1 month');
$deliveryResult = $textMarketer->sendScheduledMessage($messageCommand, $scheduledDate);
```

#### Deleting Scheduled Messages

```php
// Scheduled message ID can be found from the delivery result for scheduled messages:
// $scheduledMessageId = $deliveryResult->getScheduledId();
$textMarketer->deleteScheduledMessage($scheduledMessageId);
```

### Handling and Transferring Credits ###

#### Fetching your Current Credits #### 

```php
echo sprintf('I have %d remaining credits!', $textMarketer->getCreditCount());
```

#### Transferring Credits by Account ID or Credentials

```php
$transferResult = $textMarketer->transferCreditsToAccountById(100, $someAccountId);

// Or by credentials:

$destinationCredentials = new \Nessworthy\TextMarketer\Authentication\Simple('username', 'password'));
$transferResult = $textMarketer->transferCreditsToAccountByCredentials(100, $destinationCredentials);

echo sprintf(
    'I had %d credits. After transferring, I now have %d!',
    $transferResult->getSourceCreditsBeforeTransfer(),
    $transferResult->getSourceCreditsAfterTransfer()
);
echo '<br>';
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

#### Fetching Your List of Groups ####

```php
$groupCollection = $textMarketer->getGroupsList();

echo sprintf(
    'I have %s groups!',
    $groupCollection->isEmpty() ? 'no' : $groupCollection->getTotal()
);

echo '<br>';
echo 'Here is a summary of each group:';
foreach ($groupCollection->asArray() as $groupSummary) {
    echo sprintf(
        'Group name: %s (ID: %d) has %s numbers. It %s a stop group!',
        $groupSummary->getName(),
        $groupSummary->getId(),
        $groupSummary->getNumberCount(),
        $groupSummary->isStopGroup() ? 'IS' : 'IS NOT'
    );
    echo '<br/>';
}

```

#### Adding One or More Numbers to a Group ####

```php
$numbersToAdd = new Nessworthy\TextMarketer\Message\Part\PhoneNumberCollection([
    '44700000000',
    '44700000001',
    '44700000002',
]);

$result = $textMarketer->addNumbersToGroup('MyGroupNameOrID', $numbersToAdd);

// Of the numbers - which ones were actually added to the list.
echo 'Added numbers: ' . $textMarketer->getTotalAddedNumbers();
echo 'Numbers added:<br>' . implode('<br>',$textMarketer->getAddedNumbers();
echo '<br>';

// Of the numbers - which ones were not added because they were on a STOP list.
echo 'Stopped numbers: ' . $textMarketer->getTotalStoppedNumbers();
echo 'Numbers added:<br>' . implode('<br>',$textMarketer->getStoppedNumbers();
echo '<br>';

// Of the numbers - which ones were not added because they were already on it.
echo 'Duplicated numbers: ' . $textMarketer->getTotalDuplicateNumbers();
echo 'Numbers added:<br>' . implode('<br>',$textMarketer->getDuplicateNumbers(); 
```

#### Creating a New Group ####

```php
$group = $textMarketer->createGroup('mygroup');

echo sprintf(
    'A new group was created by the name "%s" with an assigned ID of "%d"! The group %s a stop group.',
    $group->getName(),
    $group->getId(),
    $group->isStopGroup() ? 'IS' : 'IS NOT'
);

// You can also use getNumberCount() and getNumbers(), which will return 0 and an empty array, respectively.
```

#### Fetching Information for an Existing Group ####

```php
$group = $textMarketer->getGroupInformation('mygroup');

echo sprintf(
    'The group is called "%s" with an assigned ID of "%d"! The group %s a stop group.',
    $group->getName(),
    $group->getId(),
    $group->isStopGroup() ? 'IS' : 'IS NOT'
);

echo '<br/>';

echo sprintf(
    'The group has %d numbers. Here they are:<br>%s',
    $group->getNumberCount(),
    implode('<br>', $group->getNumbers())
);
``` 

### Delivery Reports ###

```php

$reportCollection = $textMarketer->getDeliveryReportList();

echo sprintf(
    'I have %s reports in total!',
    $reportCollection->isEmpty() ? 'no' : $reportCollection->getTotal()
);

foreach ($reportCollection->asArray() as $report) {
    echo '<br>';
    echo sprintf(
        'Report %s (last updated: %s) has extension %s.',
        $report->getName(),
        $report->getLastUpdated->format('d-m-Y H:i:s'),
        $report->getExtension()
    );
}

```

All report-related calls return the results in the same format as above.

#### Filtering by Report Name ####

```php
$reportCollection = $textMarketer->getDeliveryReportListByName('ReportName');
```

#### Filtering By Report Name and Date Range ####

```php
$from = new DateTimeImmutable();
$to = $from->modify('-1 week');
$dateRange = new \Nessworthy\TextMarketer\DateRange($from, $to);
$reportCollection = $textMarketer->getDeliveryReportListByNameAndDateRange('ReportName', $dateRange);
```

#### Filtering by Report Name and Tag ####

```php
$from = new DateTimeImmutable();
$reportCollection = $textMarketer->getDeliveryReportListByNameAndTag('ReportName', 'mytag');
```

#### Filtering by Report Name, Tag, and Date Range ####  

```php
$from = new DateTimeImmutable();
$to = $from->modify('-1 week');
$dateRange = new \Nessworthy\TextMarketer\DateRange($from, $to);
$reportCollection = $textMarketer->getDeliveryReportListByNameTagAndDateRange('ReportName', 'mytag', $dateRange);
```

### Account Management ###

All methods here return an instance of `Nessworthy\TextMarketer\Account\AccountInformation`.
These objects contain both account and API credentials - it would be wise to not cache or otherwise save them as-is!

#### Fetching Your Account Information ####

```php
$accountInformation = $textMarketer->getAccountInformation();

echo 'Account ID: ' . $accountInformation->getId();
echo '<br>Company Name: ' . $accountInformation->getCompanyName();
echo '<br>Account Created At: ' . $accountInformation->getCreatedDate()->format('d/m/Y H:i:s');
echo '<br>Remaining Credits: ' . $accountInformation->getRemainingCredits();
echo '<br>Notification Email: ' . $accountInformation->getNotificationEmail();
echo '<br>Notification Mobile Number: ' . $accountInformation->getNotificationMobile();
echo '<br>Account Username: ' . $accountInformation->getUiUserName();
echo '<br>Account Password: ' . $accountInformation->getUiPassword();
echo '<br>API Username: ' . $accountInformation->getApiUserName();
echo '<br>API Password: ' . $accountInformation->getApiPassword();
``` 

#### Fetching Account Information by Account ID ####

Note: The account ID should be typed as a string.

```php
$accountInformation = $textMarketer->getAccountInformationForAccountId($accountId);
```

#### Updating Your Account Information ####

Note: There's no way to update another account's information - you must use their credentials.

All of the fields for `UpdateAccountInformation` are optional - pass `null` when you don't
want to change a particular field.

Certain restrictions apply when updating your account information. [See here for what you can use](https://wiki.textmarketer.co.uk/display/DevDoc/account+POST+method).

```php
$newAccountDetails = new Nessworthy\TextMarketer\Account\UpdateAccountInformation(
    'uiusername',               // The new UI Username.
    'uipassword',               // The new UI Password.
    'apiusername',              // The new API Username.
    'apipassword',              // The new API Password.
    'Company Name',             // The new company name.
    'notification@email.com',   // The new notification email address.
    '447000000000',             // The new notification mobile number.
);

$updatedAccountInformation = $textMarketer->updateAccountInformation($newAccountDetails);
```

#### Creating a New Sub-Account ####

Note: Creating new account is disabled by default - you will need to contact TextMarketer to enable this.
Like updating your account, you must at least provide a notification email address OR a notification mobile number

These fields are subject to the same restrictions as that when updating you account information.

```php
$subAccount = new Nessworthy\TextMarketer\Account\CreateSubAccount(
    'uiusername',              // The new account's username
    'uipassword',              // Optional: The new account's password. If null is given, a random password will be generated.
    'Company Name',            // The new account's company name.
    'notification@email.com',  // Optional: The new account's notification email address.
    '447000000000',            // Optional: The new account's notification mobile number.
    false,                     // Whether to use the same pricing as the parent account.
    'PROMOCODE'                // Optional: A promo code for the account if you have one.
);
```


### Exception and Error Handling ###

```php
// All exceptions extend \Nessworthy\TextMarketer\TextMarketerException.
try {
    // Send a text marketer request.
} catch (\Nessworthy\TextMarketer\Endpoint\EndpointException $e) {
    // $e->getMessage() and $e->getCode() return the first message & message code.
    // Or for all errors...
    foreach ($e->getAllEndpointErrors() as $error) {
        error_log(sprintf('TextMarketer Message Error: [%s] %s', $error->getCode(), $error->getMessage()));         
    }
}
```

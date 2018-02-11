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

### Handling & Transferring Credits ###

#### Fetching your Current Credits #### 

```php
echo sprintf('I have %d remaining credits!', $textMarketer->getCreditCount());
```

#### Transferring Credits (by account ID or credentials)

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

#### Fetch Your List of Groups ####

```php
$groupCollection = $textMarketer->getGroupsList();

echo sprintf(
    'I have %s groups!',
    $groupCollection->isEmpty() ? 'no' : $groupCollection->getTotal(),
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

#### Add One or More Numbers to a Group ####

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

#### Create a New Group ####

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

#### Fetch Information for an Existing Group

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

#### Filter by Report Name ####

```php
$reportCollection = $textMarketer->getDeliveryReportListByName('ReportName');
```

#### Filter By Report Name & Date Range ####

```php
$from = new DateTimeImmutable();
$to = $from->modify('-1 week');
$dateRange = new \Nessworthy\TextMarketer\DateRange($from, $to);
$reportCollection = $textMarketer->getDeliveryReportListByNameAndDateRange('ReportName', $dateRange);
```

#### Filter by Report Name & Tag ####

```php
$from = new DateTimeImmutable();
$reportCollection = $textMarketer->getDeliveryReportListByNameAndTag('ReportName', 'mytag');
```

#### Filter by Report Name, Tag, & Date Range ####  

```php
$from = new DateTimeImmutable();
$to = $from->modify('-1 week');
$dateRange = new \Nessworthy\TextMarketer\DateRange($from, $to);
$reportCollection = $textMarketer->getDeliveryReportListByNameTagAndDateRange('ReportName', 'mytag', $dateRange);
```

### Account Management ###

### Exception / Error Handling ###

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
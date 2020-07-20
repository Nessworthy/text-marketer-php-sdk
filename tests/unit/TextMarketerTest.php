<?php

namespace Nessworthy\TextMarketer\Tests;

use DateTimeImmutable;
use GuzzleHttp\ClientInterface;
use Nessworthy\TextMarketer\Authentication;
use Nessworthy\TextMarketer\TextMarketer;
use Nessworthy\TextMarketer\Message\SendMessage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class TextMarketerTest extends TestCase
{
    /**
     * @var TextMarketer
     */
    private $textMarketer;

    /**
     * @var ClientInterface|MockObject
     */
    private $httpClient;

    public function setUp()
    {
        /** @var Authentication|MockObject $credentials */
        $credentials = $this->createMock(Authentication::class);
        $credentials
            ->expects(self::once())
            ->method('getUsername')
            ->willReturn('test_username');
        $credentials
            ->expects(self::once())
            ->method('getPassword')
            ->willReturn('test_password');

        /** @var ClientInterface|MockObject $fakeHttpClient */
        $fakeHttpClient = $this->createMock(ClientInterface::class);
        $this->httpClient = $fakeHttpClient;

        $this->textMarketer = new TextMarketer($credentials, $fakeHttpClient, 'http://fakeendpoint.local');
    }

    public function testSendMessage()
    {
        $body = $this->createMock(StreamInterface::class);
        $body
            ->method('getContents')
            ->willReturn('<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE response PUBLIC
"-//textmarketer.co.uk//DTD Web Services REST 1.6//EN"
"http://api.textmarketer.co.uk/services/rest/DTD/sms_post.dtd">
<response processed_date="2011-04-14T12:01:01+01:00">
    <message_id>1006486913</message_id>
    <scheduled_id>0</scheduled_id>
    <credits_used>1</credits_used>
    <status>SENT</status>
</response>');

        /** @var ResponseInterface|MockObject $response */
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getBody')
            ->willReturn($body);


        $this->httpClient
            ->method('request')
            ->willReturn($response);

        $sendMessage = $this->createMock(SendMessage::class);
        $sendMessage
            ->expects(self::once())
            ->method('getMessageText')
            ->willReturn('Test Message Text');
        $sendMessage
            ->expects(self::once())
            ->method('getMessageRecipients')
            ->willReturn(['0000000001']);
        $sendMessage
            ->expects(self::once())
            ->method('getMessageOriginator')
            ->willReturn('Originator');
        $sendMessage
            ->expects(self::once())
            ->method('hasCustomTag')
            ->willReturn(false);
        $sendMessage
            ->expects(self::once())
            ->method('hasHourValidity')
            ->willReturn(false);
        $sendMessage
            ->expects(self::once())
            ->method('isCheckSTOPEnabled')
            ->willReturn(false);
        $sendMessage
            ->expects(self::once())
            ->method('hasTxtUsEmail')
            ->willReturn(false);

        $result = $this->textMarketer->sendMessage($sendMessage);

        $this->assertTrue($result->isSent());
        $this->assertFalse($result->isScheduled());
        $this->assertFalse($result->isQueued());
        $this->assertEquals($result->getCreditsUsed(), 1);
        $this->assertEquals('1006486913', $result->getMessageId());
    }

    public function testSendScheduledMessage()
    {
        $body = $this->createMock(StreamInterface::class);
        $body
            ->method('getContents')
            ->willReturn('<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE response PUBLIC
"-//textmarketer.biz//DTD Web Services REST 1.6//EN"
"http://api.textmarketer.co.uk/services/rest/DTD/sms_post.dtd">
<response processed_date="2020-07-20T21:17:53+01:00">
<message_id>0</message_id>
<scheduled_id>1234567890</scheduled_id>
<credits_used>1</credits_used>
<status>SCHEDULED</status>
</response>');

        /** @var ResponseInterface|MockObject $response */
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getBody')
            ->willReturn($body);


        $this->httpClient
            ->method('request')
            ->willReturn($response);

        $sendMessage = $this->createMock(SendMessage::class);
        $sendMessage
            ->expects(self::once())
            ->method('getMessageText')
            ->willReturn('Test Message Text');
        $sendMessage
            ->expects(self::once())
            ->method('getMessageRecipients')
            ->willReturn(['0000000001']);
        $sendMessage
            ->expects(self::once())
            ->method('getMessageOriginator')
            ->willReturn('Originator');
        $sendMessage
            ->expects(self::once())
            ->method('hasCustomTag')
            ->willReturn(false);
        $sendMessage
            ->expects(self::once())
            ->method('hasHourValidity')
            ->willReturn(false);
        $sendMessage
            ->expects(self::once())
            ->method('isCheckSTOPEnabled')
            ->willReturn(false);
        $sendMessage
            ->expects(self::once())
            ->method('hasTxtUsEmail')
            ->willReturn(false);

        $result = $this->textMarketer->sendScheduledMessage($sendMessage, (new DateTimeImmutable('2020-07-20T21:17:53+00:00')));

        $this->assertFalse($result->isSent());
        $this->assertTrue($result->isScheduled());
        $this->assertFalse($result->isQueued());
        $this->assertEquals($result->getCreditsUsed(), 1);
        $this->assertNull($result->getMessageId());
        $this->assertEquals('1234567890', $result->getScheduledId());
    }

    public function testDeleteScheduledMessage()
    {
        $body = $this->createMock(StreamInterface::class);
        $body
            ->method('getContents')
            ->willReturn('<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE response PUBLIC
"-//textmarketer.biz//DTD Web Services REST 1.6//EN"
"http://api.textmarketer.co.uk/services/rest/DTD/sms_delete.dtd">
<response processed_date="2013-07-15T15:14:18+01:00">
    <scheduled_id>101</scheduled_id>
    <status>DELETED</status>
</response>');

        /** @var ResponseInterface|MockObject $response */
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getBody')
            ->willReturn($body);


        $this->httpClient
            ->method('request')
            ->willReturn($response);



        $this->textMarketer->deleteScheduledMessage(101);
    }

    public function testGetCreditCount()
    {
        $body = $this->createMock(StreamInterface::class);
        $body
            ->method('getContents')
            ->willReturn('<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE response PUBLIC
"-//textmarketer.co.uk//DTD Web Services REST 1.6//EN"
"http://api.textmarketer.co.uk/services/rest/DTD/credits_get.dtd">
<response processed_date="2011-04-12T14:00:09+01:00">
<credits>450</credits>
</response>');

        /** @var ResponseInterface|MockObject $response */
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getBody')
            ->willReturn($body);


        $this->httpClient
            ->method('request')
            ->willReturn($response);



        $amount = $this->textMarketer->getCreditCount();

        self::assertEquals(450, $amount);
    }

    public function testTransferringCreditsById()
    {
        $body = $this->createMock(StreamInterface::class);
        $body
            ->method('getContents')
            ->willReturn('<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE response PUBLIC
"-//textmarketer.co.uk//DTD Web Services REST 1.6//EN"
"http://api.textmarketer.co.uk/services/rest/DTD/credits_post.dtd">
<response processed_date="2011-04-14T11:16:06+01:00">
<source_credits_before>442</source_credits_before>
<source_credits_after>441</source_credits_after>
<target_credits_before>121</target_credits_before>
<target_credits_after>122</target_credits_after>
</response>');

        /** @var ResponseInterface|MockObject $response */
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getBody')
            ->willReturn($body);


        $this->httpClient
            ->method('request')
            ->willReturn($response);



        $report = $this->textMarketer->transferCreditsToAccountById(1, 1234567890);

        self::assertEquals(442, $report->getSourceCreditsBeforeTransfer());
        self::assertEquals(441, $report->getSourceCreditsAfterTransfer());
        self::assertEquals(121, $report->getTargetCreditsBeforeTransfer());
        self::assertEquals(122, $report->getTargetCreditsAfterTransfer());
    }

    public function testTransferringCreditsByCredentials()
    {
        $body = $this->createMock(StreamInterface::class);
        $body
            ->method('getContents')
            ->willReturn('<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE response PUBLIC
"-//textmarketer.co.uk//DTD Web Services REST 1.6//EN"
"http://api.textmarketer.co.uk/services/rest/DTD/credits_post.dtd">
<response processed_date="2011-04-14T11:16:06+01:00">
<source_credits_before>442</source_credits_before>
<source_credits_after>441</source_credits_after>
<target_credits_before>121</target_credits_before>
<target_credits_after>122</target_credits_after>
</response>');

        /** @var ResponseInterface|MockObject $response */
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getBody')
            ->willReturn($body);


        $this->httpClient
            ->method('request')
            ->willReturn($response);


        $destinationAccountDetails = $this->createMock(Authentication::class);
        $destinationAccountDetails
            ->expects(self::once())
            ->method('getUserName')
            ->willReturn('test');
        $destinationAccountDetails
            ->expects(self::once())
            ->method('getPassword')
            ->willReturn('test');
        
        $report = $this->textMarketer->transferCreditsToAccountByCredentials(1, $destinationAccountDetails);

        self::assertEquals(442, $report->getSourceCreditsBeforeTransfer());
        self::assertEquals(441, $report->getSourceCreditsAfterTransfer());
        self::assertEquals(121, $report->getTargetCreditsBeforeTransfer());
        self::assertEquals(122, $report->getTargetCreditsAfterTransfer());
    }

    public function testCheckKeywordAvailability()
    {
        $body = $this->createMock(StreamInterface::class);
        $body
            ->method('getContents')
            ->willReturn('<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE response PUBLIC
"-//textmarketer.co.uk//DTD Web Services REST 1.6//EN"
"http://api.textmarketer.co.uk/services/rest/DTD/keywords_get.dtd">
<response processed_date="2011-04-15T10:13:50+01:00">
<available>true</available>
<recycle>false</recycle>
</response>');

        /** @var ResponseInterface|MockObject $response */
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getBody')
            ->willReturn($body);


        $this->httpClient
            ->method('request')
            ->willReturn($response);

        $availability = $this->textMarketer->checkKeywordAvailability('test');

        self::assertTrue($availability->isAvailable());
        self::assertFalse($availability->isRecycled());
    }

    public function testGetAccountInformation()
    {
        $body = $this->createMock(StreamInterface::class);
        $body
            ->method('getContents')
            ->willReturn('<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE response PUBLIC
"-//textmarketer.co.uk//DTD Web Services REST 1.6//EN"
"http://api.textmarketer.co.uk/services/rest/DTD/groups_get.dtd">
<response processed_date="2012-04-11T11:23:14+02:00">
    <account>
        <account_id>abcdefghijklmnopqrstuvwx</account_id>
        <api_password>my_api_password</api_password>
        <api_username>my_api_username</api_username>
        <company_name>Bill\'s Bakery</company_name>
        <create_date>2012-02-12T01:00:00+02:00</create_date>
        <credits>833</credits>
        <notification_email>bill@billsbakery.com</notification_email>
        <notification_mobile>447777777777</notification_mobile>
        <password>my_UI_password</password>
        <username>my_UI_username</username>
    </account>
</response>');

        /** @var ResponseInterface|MockObject $response */
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getBody')
            ->willReturn($body);


        $this->httpClient
            ->method('request')
            ->willReturn($response);

        $accountInformation = $this->textMarketer->getAccountInformation();

        self::assertEquals('my_UI_password', $accountInformation->getUiPassword());
        self::assertEquals('my_UI_username', $accountInformation->getUiUserName());
        self::assertEquals('my_api_username', $accountInformation->getApiUserName());
        self::assertEquals('my_api_password', $accountInformation->getApiPassword());
        self::assertEquals('Bill\'s Bakery', $accountInformation->getCompanyName());
        self::assertEquals('abcdefghijklmnopqrstuvwx', $accountInformation->getId());
        self::assertEquals('bill@billsbakery.com', $accountInformation->getNotificationEmail());
        self::assertEquals('447777777777', $accountInformation->getNotificationMobile());
        self::assertEquals('833', $accountInformation->getRemainingCredits());

        $date = new DateTimeImmutable('2012-02-12T01:00:00+02:00');

        self::assertEquals($date->format('c'), $accountInformation->getCreatedDate()->format('c'));
    }

    public function testGetAccountInformationForId()
    {
        $body = $this->createMock(StreamInterface::class);
        $body
            ->method('getContents')
            ->willReturn('<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE response PUBLIC
"-//textmarketer.co.uk//DTD Web Services REST 1.6//EN"
"http://api.textmarketer.co.uk/services/rest/DTD/groups_get.dtd">
<response processed_date="2012-04-11T11:23:14+02:00">
    <account>
        <account_id>abcdefghijklmnopqrstuvwx</account_id>
        <api_password>my_api_password</api_password>
        <api_username>my_api_username</api_username>
        <company_name>Bill\'s Bakery</company_name>
        <create_date>2012-02-12T01:00:00+02:00</create_date>
        <credits>833</credits>
        <notification_email>bill@billsbakery.com</notification_email>
        <notification_mobile>447777777777</notification_mobile>
        <password>my_UI_password</password>
        <username>my_UI_username</username>
    </account>
</response>');

        /** @var ResponseInterface|MockObject $response */
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getBody')
            ->willReturn($body);


        $this->httpClient
            ->method('request')
            ->willReturn($response);

        $accountInformation = $this->textMarketer->getAccountInformationForAccountId('abcdefghijklmnopqrstuvwx');

        self::assertEquals('my_UI_password', $accountInformation->getUiPassword());
        self::assertEquals('my_UI_username', $accountInformation->getUiUserName());
        self::assertEquals('my_api_username', $accountInformation->getApiUserName());
        self::assertEquals('my_api_password', $accountInformation->getApiPassword());
        self::assertEquals('Bill\'s Bakery', $accountInformation->getCompanyName());
        self::assertEquals('abcdefghijklmnopqrstuvwx', $accountInformation->getId());
        self::assertEquals('bill@billsbakery.com', $accountInformation->getNotificationEmail());
        self::assertEquals('447777777777', $accountInformation->getNotificationMobile());
        self::assertEquals('833', $accountInformation->getRemainingCredits());

        $date = new DateTimeImmutable('2012-02-12T01:00:00+02:00');

        self::assertEquals($date->format('c'), $accountInformation->getCreatedDate()->format('c'));
    }

}

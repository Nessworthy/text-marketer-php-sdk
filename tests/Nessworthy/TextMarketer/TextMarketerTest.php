<?php

namespace Nessworthy\TextMarketer\Tests;

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
            ->expects($this->once())
            ->method('getUsername')
            ->willReturn('test_username');
        $credentials
            ->expects($this->once())
            ->method('getPassword')
            ->willReturn('test_password');

        /** @var ClientInterface|MockObject $fakeHttpClient */
        $fakeHttpClient = $this->createMock(ClientInterface::class);
        $this->httpClient = $fakeHttpClient;

        $this->textMarketer = new TextMarketer($credentials, 'http://fakeendpoint.local', $fakeHttpClient);
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
            ->expects($this->once())
            ->method('getMessageText')
            ->willReturn('Test Message Text');
        $sendMessage
            ->expects($this->once())
            ->method('getMessageRecipients')
            ->willReturn(['0000000001']);
        $sendMessage
            ->expects($this->once())
            ->method('getMessageOriginator')
            ->willReturn('Originator');
        $sendMessage
            ->expects($this->once())
            ->method('hasCustomTag')
            ->willReturn(false);
        $sendMessage
            ->expects($this->once())
            ->method('hasHourValidity')
            ->willReturn(false);
        $sendMessage
            ->expects($this->once())
            ->method('isCheckSTOPEnabled')
            ->willReturn(false);
        $sendMessage
            ->expects($this->once())
            ->method('hasTxtUsEmail')
            ->willReturn(false);

        $result = $this->textMarketer->sendMessage($sendMessage);

        $this->assertTrue($result->isSent());
        $this->assertFalse($result->isScheduled());
        $this->assertFalse($result->isQueued());
        $this->assertEquals($result->getCreditsUsed(), 1);
        $this->assertEquals('1006486913', $result->getMessageId());
    }
}

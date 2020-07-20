<?php

namespace Nessworthy\TextMarketer\Test\Integration;

use DateTimeImmutable;
use GuzzleHttp\Client;
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

    public function setUp()
    {
        $this->textMarketer = new TextMarketer(
            new Authentication\Simple(getenv('TM_SANDBOX_USER'), getenv('TM_SANDBOX_PASSWORD')),
            TextMarketer::ENDPOINT_SANDBOX,
            new Client
        );
    }

    public function testCanFetchCreditCount()
    {
        $this->textMarketer->getCreditCount();
        self::assertTrue(true);
    }

    public function testCanFetchAccountDetails()
    {
        $this->textMarketer->getAccountInformation();
        self::assertTrue(true);
    }

    public function testCanFetchDeliveryReportList()
    {
        $this->textMarketer->getDeliveryReportList();
        self::assertTrue(true);
    }

    public function testCanFetchGroupsList()
    {
        $this->textMarketer->getGroupsList();
        self::assertTrue(true);
    }

    public function testCanSendBasicMessage()
    {
        $message = new SendMessage(
            'Test Message',
            ['+440000000000'],
            'IntTest'
        );
        $this->textMarketer->sendMessage($message);
        self::assertTrue(true);
    }

    public function testCanSendScheduledMessage()
    {
        $message = new SendMessage(
            'Test Message',
            ['+440000000000'],
            'IntTest'
        );
        $this->textMarketer->sendScheduledMessage($message, (new DateTimeImmutable)->modify('+1 hour'));
        self::assertTrue(true);
    }

    public function testCanCreateSendGroup()
    {
        $this->textMarketer->createGroup('TestSendGroup');
        self::assertTrue(true);
    }
}

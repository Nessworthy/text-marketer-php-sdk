<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Tests\Account;

use Nessworthy\TextMarketer\Message\DeliveryReport;
use PHPUnit\Framework\TestCase;

class DeliveryReportTest extends TestCase
{
    public function testSentDeliveryReportGettersAllReturnCorrectData()
    {
        $report = DeliveryReport::createSent(
            '00000000001',
            10
        );

        $this->assertEquals('00000000001', $report->getMessageId());
        $this->assertEquals(10, $report->getCreditsUsed());

        $this->assertTrue($report->isSent());
        $this->assertFalse($report->isScheduled());
        $this->assertFalse($report->isQueued());

        $this->assertNull($report->getScheduledId());
    }

    public function testQueuedDeliveryReportGettersAllReturnCorrectData()
    {
        $report = DeliveryReport::createQueued(
            '00000000002',
            10
        );

        $this->assertEquals('00000000002', $report->getMessageId());
        $this->assertEquals(10, $report->getCreditsUsed());

        $this->assertFalse($report->isSent());
        $this->assertFalse($report->isScheduled());
        $this->assertTrue($report->isQueued());

        $this->assertNull($report->getScheduledId());
    }

    public function testScheduledDeliveryReportGettersAllReturnCorrectData()
    {
        $report = DeliveryReport::createScheduled(
            '00000000003',
            10
        );

        $this->assertEquals('00000000003', $report->getScheduledId());
        $this->assertEquals(10, $report->getCreditsUsed());

        $this->assertFalse($report->isSent());
        $this->assertTrue($report->isScheduled());
        $this->assertFalse($report->isQueued());

        $this->assertNull($report->getMessageId());
    }
}

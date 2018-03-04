<?php

namespace Nessworthy\TextMarketer\Tests\SendGroup;

use Nessworthy\TextMarketer\SendGroup\SendGroupSummary;
use PHPUnit\Framework\TestCase;

class SendGroupSummaryTest extends TestCase
{

    public function testGetId(): void
    {
        $sendGroupSummary = new SendGroupSummary('someid', 'Group Name', 10, false);

        $this->assertEquals('someid', $sendGroupSummary->getId());
    }

    public function testGetName(): void
    {
        $sendGroupSummary = new SendGroupSummary('someid', 'Group Name', 10, false);

        $this->assertEquals('Group Name', $sendGroupSummary->getName());
    }

    public function testGetNumberCount(): void
    {
        $sendGroupSummary = new SendGroupSummary('someid', 'Group Name', 10, false);

        $this->assertEquals(10, $sendGroupSummary->getNumberCount());
    }

    public function testIsStopGroup(): void
    {
        $sendGroupSummaryWithFalseStopGroup = new SendGroupSummary('someid', 'Group Name', 10, false);
        $this->assertFalse($sendGroupSummaryWithFalseStopGroup->isStopGroup());

        $sendGroupSummaryWithFalseStopGroup = new SendGroupSummary('someid', 'Group Name', 10, true);
        $this->assertTrue($sendGroupSummaryWithFalseStopGroup->isStopGroup());
    }
}

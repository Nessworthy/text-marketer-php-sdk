<?php

namespace Nessworthy\TextMarketer\Tests\SendGroup;

use Nessworthy\TextMarketer\SendGroup\SendGroupSummary;
use Nessworthy\TextMarketer\SendGroup\SendGroupSummaryCollection;
use PHPUnit\Framework\TestCase;

class SendGroupSummaryCollectionTest extends TestCase
{

    public function testAsArray(): void
    {
        $summary = $this->createMock(SendGroupSummary::class);

        $collection = new SendGroupSummaryCollection($summary);

        $this->assertEquals([$summary], $collection->asArray());
    }

    public function testGetTotal(): void
    {
        $summary = $this->createMock(SendGroupSummary::class);

        $collection = new SendGroupSummaryCollection($summary);

        $this->assertEquals(1, $collection->getTotal());
    }

    public function testIsEmpty(): void
    {
        $summary = $this->createMock(SendGroupSummary::class);

        $nonEmptyCollection = new SendGroupSummaryCollection($summary);
        $emptyCollection = new SendGroupSummaryCollection();

        $this->assertFalse($nonEmptyCollection->isEmpty());
        $this->assertTrue($emptyCollection->isEmpty());
    }
}

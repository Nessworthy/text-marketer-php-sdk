<?php
namespace Nessworthy\TextMarketer\Test\Unit\DeliveryReport;

use Nessworthy\TextMarketer\DeliveryReport\DeliveryReport;
use Nessworthy\TextMarketer\DeliveryReport\DeliveryReportCollection;
use PHPUnit\Framework\TestCase;

class DeliveryReportCollectionTest extends TestCase
{
    private $stubbedReports;

    public function setUp(): void
    {
        $stubbedReports = [];
        $stubbedReports[] = $this->createMock(DeliveryReport::class);
        $stubbedReports[] = $this->createMock(DeliveryReport::class);
        $stubbedReports[] = $this->createMock(DeliveryReport::class);
        $this->stubbedReports = $stubbedReports;
    }

    public function testAsArray(): void
    {
        $collection = new DeliveryReportCollection(...$this->stubbedReports);
        $emptyCollection = new DeliveryReportCollection();

        $this->assertEquals($this->stubbedReports, $collection->asArray());
        $this->assertEmpty($emptyCollection->asArray());
    }

    public function testGetTotal(): void
    {
        $collection = new DeliveryReportCollection(...$this->stubbedReports);
        $emptyCollection = new DeliveryReportCollection();

        $this->assertEquals(\count($this->stubbedReports), $collection->getTotal());
        $this->assertEquals(0, $emptyCollection->getTotal());
    }

    public function testIsEmpty(): void
    {
        $collection = new DeliveryReportCollection(...$this->stubbedReports);
        $emptyCollection = new DeliveryReportCollection();

        $this->assertFalse($collection->isEmpty());
        $this->assertTrue($emptyCollection->isEmpty());
    }
}

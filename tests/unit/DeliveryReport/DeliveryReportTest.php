<?php
namespace DeliveryReport;

use Nessworthy\TextMarketer\DeliveryReport\DeliveryReport;
use PHPUnit\Framework\TestCase;

class DeliveryReportTest extends TestCase
{
    /** @var DeliveryReport */
    private $report;
    private $updated;

    public function setUp(): void
    {
        parent::setUp();
        $updated = new \DateTimeImmutable();
        $report = new DeliveryReport('MyReport', $updated, 'csv');
        $this->report = $report;
        $this->updated = $updated;

    }

    public function testGetName()
    {
        $this->assertEquals('MyReport', $this->report->getName());
    }

    public function testGetLastUpdated()
    {
        $this->assertEquals($this->updated, $this->report->getLastUpdated());
    }

    public function testGetExtension()
    {
        $this->assertEquals('csv', $this->report->getExtension());
    }
}

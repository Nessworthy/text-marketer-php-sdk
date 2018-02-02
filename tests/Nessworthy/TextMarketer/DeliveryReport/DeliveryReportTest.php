<?php
/**
 * Created by PhpStorm.
 * User: Sean.Nessworthy
 * Date: 02/02/2018
 * Time: 13:54
 */

namespace DeliveryReport;

use Nessworthy\TextMarketer\DeliveryReport\DeliveryReport;
use PHPUnit\Framework\TestCase;

class DeliveryReportTest extends TestCase
{
    /** @var DeliveryReport */
    private $report;
    private $updated;

    public function setUp()
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

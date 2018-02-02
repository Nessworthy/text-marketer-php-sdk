<?php
/**
 * Created by PhpStorm.
 * User: Sean.Nessworthy
 * Date: 02/02/2018
 * Time: 13:41
 */

namespace Credit;

use Nessworthy\TextMarketer\Credit\TransferReport;
use PHPUnit\Framework\TestCase;

class TransferReportTest extends TestCase
{

    /** @var TransferReport */
    private $report;

    public function setUp()
    {
        parent::setUp();
        $this->report = new TransferReport(100, 200, 300, 400);
    }

    public function testGetSourceCreditsBefore()
    {
        $this->assertEquals(100, $this->report->getSourceCreditsBeforeTransfer());
    }

    public function testGetSourceCreditsAfter()
    {
        $this->assertEquals(200, $this->report->getSourceCreditsAfterTransfer());
    }

    public function testGetTargetCreditsBefore()
    {
        $this->assertEquals(300, $this->report->getTargetCreditsBeforeTransfer());
    }

    public function testGetTargetCreditsAfter()
    {
        $this->assertEquals(400, $this->report->getTargetCreditsAfterTransfer());
    }
}

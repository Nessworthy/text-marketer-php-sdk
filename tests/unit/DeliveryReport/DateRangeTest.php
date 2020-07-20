<?php
namespace DeliveryReport;

use Nessworthy\TextMarketer\DeliveryReport\DateRange;
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase
{
    private $from;
    private $to;
    /** @var DateRange */
    private $range;

    public function setUp(): void
    {
        parent::setUp();
        $before = new \DateTimeImmutable('2017-01-01 00:00:00');
        $after = new \DateTimeImmutable('2018-05-10 00:00:00');
        $this->from = $before;
        $this->to = $after;
        $this->range = new DateRange($before, $after);
    }

    public function testGetFrom()
    {
        $this->assertEquals($this->from, $this->range->getFrom());
    }

    public function testGetTo()
    {
        $this->assertEquals($this->to, $this->range->getTo());
    }
}

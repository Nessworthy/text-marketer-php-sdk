<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\DeliveryReport;

class DateRange
{
    /**
     * @var \DateTimeImmutable
     */
    private $from;
    /**
     * @var \DateTimeImmutable
     */
    private $to;

    public function __construct(\DateTimeImmutable $from, \DateTimeImmutable $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getFrom(): \DateTimeImmutable
    {
        return $this->from;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getTo(): \DateTimeImmutable
    {
        return $this->to;
    }
}

<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\DeliveryReport;

use Nessworthy\TextMarketer\Message\MessageDeliveryReport;

final class DeliveryReportCollection
{
    private $reports;
    private $total;

    public function __construct(DeliveryReport ...$reports)
    {
        $this->reports = $reports;
        $this->total = \count($reports);
    }

    /**
     * @return DeliveryReport[]
     */
    public function asArray(): array
    {
        return $this->reports;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function isEmpty(): bool
    {
        return $this->getTotal() === 0;
    }
}

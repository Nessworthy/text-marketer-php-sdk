<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\SendGroup;

final class SendGroupSummaryCollection
{
    /**
     * @var SendGroupSummary[]
     */
    private $sendGroups;
    private $total;

    public function __construct(SendGroupSummary ...$sendGroups)
    {
        $this->sendGroups = $sendGroups;
        $this->total = \count($sendGroups);
    }

    /**
     * @return SendGroupSummary[]
     */
    public function asArray(): array
    {
        return $this->sendGroups;
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

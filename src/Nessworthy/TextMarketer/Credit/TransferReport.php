<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Credit;

final class TransferReport
{
    /**
     * @var int
     */
    private $sourceCreditsBefore;
    /**
     * @var int
     */
    private $sourceCreditsAfter;
    /**
     * @var int
     */
    private $targetCreditsBefore;
    /**
     * @var int
     */
    private $targetCreditsAfter;

    public function __construct(
        int $sourceCreditsBefore,
        int $sourceCreditsAfter,
        int $targetCreditsBefore,
        int $targetCreditsAfter
    ) {
        $this->sourceCreditsBefore = $sourceCreditsBefore;
        $this->sourceCreditsAfter = $sourceCreditsAfter;
        $this->targetCreditsBefore = $targetCreditsBefore;
        $this->targetCreditsAfter = $targetCreditsAfter;
    }

    /**
     * @return int
     */
    public function getSourceCreditsBeforeTransfer(): int
    {
        return $this->sourceCreditsBefore;
    }

    /**
     * @return int
     */
    public function getSourceCreditsAfterTransfer(): int
    {
        return $this->sourceCreditsAfter;
    }

    /**
     * @return int
     */
    public function getTargetCreditsBeforeTransfer(): int
    {
        return $this->targetCreditsBefore;
    }

    /**
     * @return int
     */
    public function getTargetCreditsAfterTransfer(): int
    {
        return $this->targetCreditsAfter;
    }
}
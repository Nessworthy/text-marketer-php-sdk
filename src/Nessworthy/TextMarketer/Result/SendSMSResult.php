<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Result;

class SendSMSResult
{
    const STATUS_SUCCESS = 'success';
    const STATUS_QUEUED = 'queued';
    const STATUS_SCHEDULED = 'scheduled';

    private $messageId;
    private $creditsRemaining;
    private $creditsUsed;
    private $status;

    public function __construct(int $messageId, int $creditsRemaining, int $creditsUsed, string $status)
    {
        $this->messageId = $messageId;
        $this->creditsRemaining = $creditsRemaining;
        $this->creditsUsed = $creditsUsed;
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getMessageID(): int
    {
        return $this->messageId;
    }

    /**
     * @return int
     */
    public function getCreditsRemaining(): int
    {
        return $this->creditsRemaining;
    }

    /**
     * @return int
     */
    public function getCreditsUsed(): int
    {
        return $this->creditsUsed;
    }

    /**
     * @return bool
     */
    public function wasSent(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    /**
     * @return bool
     */
    public function wasQueued(): bool
    {
        return $this->status === self::STATUS_QUEUED;
    }

    /**
     * @return bool
     */
    public function wasScheduled(): bool
    {
        return $this->status === self::STATUS_SCHEDULED;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
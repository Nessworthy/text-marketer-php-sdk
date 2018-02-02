<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Message;

final class MessageDeliveryReport
{
    private const STATUS_SENT = 'SENT';
    private const STATUS_QUEUED = 'QUEUED';
    private const STATUS_SCHEDULED = 'SCHEDULED';

    /**
     * @var string
     */
    private $messageId;
    /**
     * @var string
     */
    private $scheduledId;
    /**
     * @var int
     */
    private $creditsUsed;
    /**
     * @var string
     */
    private $status;

    public static function createSent(
        string $messageId,
        int $creditsUsed
    ): self {
        return new self($messageId, null, $creditsUsed, self::STATUS_SENT);
    }

    public static function createScheduled(
        string $scheduleId,
        int $creditsUsed
    ): self {
        return new self(null, $scheduleId, $creditsUsed, self::STATUS_SCHEDULED);
    }

    public static function createQueued(
        string $messageId,
        int $creditsUsed
    ): self {
        return new self($messageId, null, $creditsUsed, self::STATUS_QUEUED);
    }

    private function __construct(
        ?string $messageId,
        ?string $scheduledId,
        int $creditsUsed,
        string $status
    ) {

        $this->messageId = $messageId;
        $this->scheduledId = $scheduledId;
        $this->creditsUsed = $creditsUsed;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    /**
     * @return string
     */
    public function getScheduledId(): ?string
    {
        return $this->scheduledId;
    }

    /**
     * @return int
     */
    public function getCreditsUsed(): int
    {
        return $this->creditsUsed;
    }

    public function isSent(): bool
    {
        return $this->status === self::STATUS_SENT;
    }

    public function isScheduled(): bool
    {
        return $this->status === self::STATUS_SCHEDULED;
    }

    public function isQueued(): bool
    {
        return $this->status === self::STATUS_QUEUED;
    }
}

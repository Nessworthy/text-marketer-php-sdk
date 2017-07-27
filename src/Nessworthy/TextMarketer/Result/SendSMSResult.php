<?php
namespace Nessworthy\TextMarketer\Result;

class SendSMSResult
{
    const STATUS_SENT = 'SENT';
    const STATUS_QUEUED = 'QUEUED';
    const STATUS_SCHEDULED = 'SCHEDULED';

    private $dateProcessed;
    private $messageId;
    private $scheduledId;
    private $creditsUsed;
    private $status;

    public function __construct(\DateTimeImmutable $processedDate, $messageId, $scheduledId, $creditsUsed, $status)
    {
        $this->dateProcessed = $processedDate;
        $this->messageId = (int) $messageId;
        $this->scheduledId = (int) $scheduledId;
        $this->creditsUsed = (int) $creditsUsed;
        $this->status = $status;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateProcessed()
    {
        return $this->dateProcessed;
    }

    /**
     * @return int
     */
    public function getMessageID()
    {
        return $this->messageId;
    }

    /**
     * @return int
     */
    public function getScheduledID()
    {
        return $this->scheduledId;
    }

    /**
     * @return int
     */
    public function getCreditCost()
    {
        return $this->creditsUsed;
    }

    /**
     * @return bool
     */
    public function wasSent()
    {
        return $this->status === self::STATUS_SENT;
    }

    /**
     * @return bool
     */
    public function wasQueued()
    {
        return $this->status === self::STATUS_QUEUED;
    }

    /**
     * @return bool
     */
    public function wasScheduled()
    {
        return $this->status === self::STATUS_SCHEDULED;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}
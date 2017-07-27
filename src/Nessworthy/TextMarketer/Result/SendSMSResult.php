<?php
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

    public function __construct($messageId, $creditsRemaining, $creditsUsed, $status)
    {
        $this->messageId = (int) $messageId;
        $this->creditsRemaining = (int) $creditsRemaining;
        $this->creditsUsed = (int) $creditsUsed;
        $this->status = $status;
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
    public function getCreditsRemaining()
    {
        return $this->creditsRemaining;
    }

    /**
     * @return int
     */
    public function getCreditsUsed()
    {
        return $this->creditsUsed;
    }

    /**
     * @return bool
     */
    public function wasSent()
    {
        return $this->status === self::STATUS_SUCCESS;
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
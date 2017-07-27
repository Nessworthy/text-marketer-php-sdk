<?php

/**
 * DevNull dispatcher will eat all requests and do nothing with them.
 * Will always return a successful response.
 */
class DevNullDispatcher implements \Nessworthy\TextMarketer\Dispatcher\Dispatcher
{
    /**
     * @inheritdoc
     */
    public function dispatchSMSMessage(\Nessworthy\TextMarketer\Message\Message $message)
    {
        return new \Nessworthy\TextMarketer\Result\SendSMSResult(
            new DateTimeImmutable(),
            0,
            0,
            0,
            \Nessworthy\TextMarketer\Result\SendSMSResult::STATUS_SENT
        );
    }
}
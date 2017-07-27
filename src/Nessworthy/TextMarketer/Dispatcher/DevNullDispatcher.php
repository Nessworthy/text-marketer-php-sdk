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
            0,
            9999,
            0,
            \Nessworthy\TextMarketer\Result\SendSMSResult::STATUS_SUCCESS
        );
    }
}
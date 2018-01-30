<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Dispatcher;

use Nessworthy\TextMarketer\Message\Message;
use Nessworthy\TextMarketer\Result\MockSMSResult;
use Nessworthy\TextMarketer\Result\SendSMSResult;

/**
 * DevNull dispatcher will eat all requests and do nothing with them.
 * Will always return a successful response.
 */
class DevNullDispatcher implements Dispatcher
{
    /**
     * @inheritdoc
     */
    public function dispatchSMSMessage(Message $message): SendSMSResult
    {
        return new MockSMSResult();
    }
}
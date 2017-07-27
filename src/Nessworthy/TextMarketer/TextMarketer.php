<?php
namespace Nessworthy\TextMarketer;

use Nessworthy\TextMarketer\Dispatcher\Dispatcher;
use Nessworthy\TextMarketer\Dispatcher\SMSDispatchFailedException;
use Nessworthy\TextMarketer\Message\Message;
use Nessworthy\TextMarketer\Result\SendSMSResult;

class TextMarketer
{
    private $dispatcher;

    /**
     * TextMarketer constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Message $message
     * @throws SMSDispatchFailedException
     * @return SendSMSResult
     */
    public function sendSMS(Message $message)
    {
        return $this->dispatcher->dispatchSMSMessage($message);
    }
}
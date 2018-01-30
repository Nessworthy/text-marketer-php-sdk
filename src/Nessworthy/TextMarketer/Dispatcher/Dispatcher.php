<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Dispatcher;

use Nessworthy\TextMarketer\Message\Message;
use Nessworthy\TextMarketer\Result\SendSMSResult;

interface Dispatcher
{
    /**
     * @param Message $message
     * @throws SMSDispatchFailedException
     * @return SendSMSResult
     */
    public function dispatchSMSMessage(Message $message): SendSMSResult;
}
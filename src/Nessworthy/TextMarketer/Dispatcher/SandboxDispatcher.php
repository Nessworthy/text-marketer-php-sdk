<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Dispatcher;

use Nessworthy\TextMarketer\Message\Message;

class SandboxDispatcher extends UriDispatcher implements Dispatcher
{
    const ENVIRONMENT_URI = 'http://sandbox.api.textmarketer.co.uk/services/rest/';

    public function dispatchSMSMessage(Message $message)
    {
        return $this->dispatchSMSMessageRequestToUri(self::ENVIRONMENT_URI, $message);
    }
}
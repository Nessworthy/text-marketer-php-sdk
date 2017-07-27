<?php
namespace Nessworthy\TextMarketer\Dispatcher;

use Nessworthy\TextMarketer\Message\Message;

class ProductionDispatcher extends UriDispatcher implements Dispatcher
{
    const ENVIRONMENT_URI = 'https://api.textmarketer.co.uk/services/rest/';

    public function dispatchSMSMessage(Message $message)
    {
        return $this->dispatchSMSMessageRequestToUri(self::ENVIRONMENT_URI, $message);
    }
}

<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Dispatcher;

use Nessworthy\TextMarketer\Message\Message;
use Nessworthy\TextMarketer\Result\SendSMSResult;

class ProductionDispatcher extends UriDispatcher implements Dispatcher
{
    const ENVIRONMENT_URI = 'https://api.textmarketer.co.uk/services/rest/';

    public function dispatchSMSMessage(Message $message): SendSMSResult
    {
        return $this->dispatchSMSMessageRequestToUri(self::ENVIRONMENT_URI, $message);
    }
}

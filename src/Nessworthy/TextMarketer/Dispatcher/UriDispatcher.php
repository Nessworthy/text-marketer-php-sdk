<?php
namespace Nessworthy\TextMarketer\Dispatcher;

use Nessworthy\TextMarketer\Authentication\Authentication;
use Nessworthy\TextMarketer\Message\Message;
use Nessworthy\TextMarketer\Result\SendSMSResult;

/**
 * TODO: Something like this could have easily been injected in, instead.
 * Class UriDispatcher
 * @package Nessworthy\TextMarketer\Dispatcher
 */
abstract class UriDispatcher
{
    const READ_CHUNK_SIZE = 1024;

    private $authentication;

    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    public function dispatchSMSMessageRequestToUri(
        $uri,
        Message $message
    ) {
        $queryParameters = [];
        $queryParameters['username'] = $this->authentication->getUserName();
        $queryParameters['password'] = $this->authentication->getPassword();
        $queryParameters['to'] = implode(',', $message->getMessageRecipients());
        $queryParameters['message'] = $message->getMessageText();
        $queryParameters['orig'] = $message->getMessageOriginator();

        $url = $uri . http_build_query($queryParameters);

        $stream = fopen($url, 'rb');

        $result = '';

        while (!feof($stream)) {
            $result .= fread($stream, self::READ_CHUNK_SIZE);
        }

        fclose($stream);

        // TODO: Maybe split this up?
        $dom = new \DOMDocument();
        $dom->loadXML($result);
        $responseCollection = $dom->getElementsByTagName('response');
        if ($responseCollection->length === 0) {
            throw new InvalidResponseException(
                'Expected a response element, but none were found.',
                InvalidResponseException::E_BAD_FORMAT
            );
        }
        $response = $responseCollection->item(0);

        $dateProcessed = new \DateTimeImmutable($response->getAttribute('processed_date'));

        $errorCollection = $response->getElementsByTagName('errors');
        if ($errorCollection->length > 0) {
            $errors = [];
            /** @var \DOMElement $errorNode */
            foreach ($errorCollection as $errorNode) {
                $errors[(int)$errorNode->getAttribute('code')] = $errorNode->textContent;
            }
            throw new SMSDispatchFailedException($errors);
        }

        $messageId = (int) $response->getElementsByTagName('message_id')->item(0)->textContent;
        $scheduledId = (int) $response->getElementsByTagName('scheduled_id')->item(0)->textContent;
        $creditsUsed = (int) $response->getElementsByTagName('credits_used')->item(0)->textContent;
        $status = $response->getElementsByTagName('status')->item(0)->textContent;

        return new SendSMSResult($dateProcessed, $messageId, $scheduledId, $creditsUsed, $status);
    }
}

<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Endpoint\Sandbox;

use GuzzleHttp\Client;
use Nessworthy\TextMarketer\Authentication\Authentication;
use Nessworthy\TextMarketer\Endpoint\DeleteScheduledMessageException;
use Nessworthy\TextMarketer\Endpoint\EndpointError;
use Nessworthy\TextMarketer\Endpoint\MessageEndpoint;
use Nessworthy\TextMarketer\Endpoint\SendMessageException;
use Nessworthy\TextMarketer\Endpoint\SendScheduledMessageException;
use Nessworthy\TextMarketer\Message\Command\SendMessage;
use Nessworthy\TextMarketer\Message\MessageDeliveryReport;

class Sandbox implements MessageEndpoint
{
    /**
     * @var Client
     */
    private $httpClient;
    /**
     * @var Authentication
     */
    private $authentication;

    public function __construct(Authentication $authentication, Client $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->authentication = $authentication;
    }

    /**
     * @inheritDoc
     */
    public function sendMessage(SendMessage $message): MessageDeliveryReport
    {
        $response = $this->toDomDocument($this->sendPostRequest(
            $this->buildEndpointUri('sms'),
            $this->buildSendMessageRequestParameters($message)
        ));

        return $this->handleSendMessageResponse($response, SendMessageException::class);
    }

    /**
     * @inheritDoc
     */
    public function sendScheduledMessage(SendMessage $message, \DateTimeImmutable $deliveryTime): MessageDeliveryReport
    {
        $data = $this->buildSendMessageRequestParameters($message);
        $data['schedule'] = $deliveryTime->format('c');
        $response = $this->toDomDocument($this->sendPostRequest(
            $this->buildEndpointUri('sms'),
            $data
        ));

       return $this->handleSendMessageResponse($response, SendScheduledMessageException::class);
    }

    /**
     * @inheritDoc
     */
    public function deleteScheduledMessage(string $scheduleId): void
    {
        $response = $this->toDomDocument(
            $this->sendDeleteRequest(
                $this->buildEndpointUri('sms', $scheduleId)
            )
        );

        $this->handleDeleteScheduleMessageResponse($response);
    }

    private function buildEndpointUri(string ...$components): string
    {
        return 'http://sandbox.textmarketer.biz/services/rest/'
            . implode(
                '/', array_map(
                    'urlencode',
                    $components
                )
            );
    }

    private function buildSendMessageRequestParameters(SendMessage $message): array
    {
        $return = [
            'message' => $message->getMessageText(),
            'to' => implode(',', $message->getMessageRecipients()),
            'originator' => $message->getMessageOriginator(),
        ];

        if ($message->hasTxtUsEmail()) {
            $return['email'] = $message->getTxtUsEmail();
        }

        if ($message->hasHourValidity()) {
            $return['validity'] = $message->getValidity();
        }

        $return['check_stop'] = $message->isCheckSTOPEnabled();

        return $return;
    }

    /**
     * @param \DomNodeList $errors
     * @return EndpointError[]
     */
    private function buildEndpointErrors($errors): array
    {
        $errorList = [];
        /** @var \DOMNode $error */
        foreach ($errors as $error) {
            $errorList[] = new EndpointError(
                (int) $error->attributes->getNamedItem('code')->textContent,
                $error->textContent
            );
        }
        return $errorList;
    }


    private function sendDeleteRequest(string $endpoint): string
    {
        return $this->sendAuthenticatedHttpRequest('delete', $endpoint);
    }

    private function sendPostRequest(string $endpoint, array $postData = []): string
    {
        return $this->sendAuthenticatedHttpRequest('post', $endpoint, ['form_params' => $postData]);
    }

    private function sendAuthenticatedHttpRequest(string $method, string $endpoint, array $options = []): string
    {
        $options['auth'] = [$this->authentication->getUserName(), $this->authentication->getPassword()];
        return $this->sendSimpleHttpRequest($method, $endpoint, $options);
    }

    private function sendSimpleHttpRequest(string $method, string $endpoint, array $options = []): string
    {
        return $this->httpClient->{$method}($method, $endpoint, $options);
    }

    private function handleAnyErrors(string $exceptionClass, \DOMDocument $domDocument): void
    {
        $errors = $domDocument->getElementsByTagName('errors');

        if ($errors->length > 0) {
            throw new $exceptionClass(...$this->buildEndpointErrors($errors));
        }
    }

    private function toDomDocument(string $xml): \DOMDocument
    {
        $domDocument = new \DOMDocument();
        $domDocument->loadXML($xml);
        return $domDocument;
    }

    private function handleSendMessageResponse(\DOMDocument $response, $errorExceptionClass): MessageDeliveryReport
    {

        $this->handleAnyErrors(SendMessageException::class, $response);

        $messageId = $response->getElementsByTagName('message_id')->item(0)->textContent;
        $scheduleId = $response->getElementsByTagName('scheduled_id')->item(0)->textContent;
        $creditsUsed = (int) $response->getElementsByTagName('credits_used')->item(0)->textContent;
        $status = $response->getElementsByTagName('status')->item(0)->textContent;

        switch ($status) {
            case 'SENT':
                return MessageDeliveryReport::createSent($messageId, $creditsUsed);
                break;
            case 'QUEUED':
                return MessageDeliveryReport::createQueued($messageId, $creditsUsed);
                break;
            case 'SCHEDULED':
                return MessageDeliveryReport::createScheduled($scheduleId, $creditsUsed);
                break;
        }

        throw new $errorExceptionClass(new EndpointError(
            -1,
            'Unexpected status from the endpoint: ' . $status
        ));
    }

    private function handleDeleteScheduleMessageResponse($response): void
    {
        $this->handleAnyErrors(DeleteScheduledMessageException::class, $response);
    }
}

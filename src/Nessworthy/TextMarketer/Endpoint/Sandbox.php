<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Endpoint;

use GuzzleHttp\Client;
use Nessworthy\TextMarketer\Authentication\Authentication;
use Nessworthy\TextMarketer\Credit\TransferReport;
use Nessworthy\TextMarketer\Message\SendMessage;
use Nessworthy\TextMarketer\Message\MessageDeliveryReport;

class Sandbox implements MessageEndpoint, CreditEndpoint
{
    /**
     * @var Client
     */
    private $httpClient;
    /**
     * @var Authentication
     */
    private $authentication;

    public function __construct(Authentication $authentication, Client $httpClient = null)
    {
        if ($httpClient === null) {
            $httpClient = new Client();
        }

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

        return $this->handleSendMessageResponse($response);
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

       return $this->handleSendMessageResponse($response);
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

    /**
     * @inheritDoc
     */
    public function getCreditCount(): int
    {
        $response = $this->toDomDocument(
            $this->sendGetRequest(
                $this->buildEndpointUri('credits')
            )
        );

        $this->handleAnyErrors($response);

        return (int) $response->getElementsByTagName('credits')->item(0)->textContent;
    }

    /**
     * @inheritDoc
     */
    public function transferCreditsToAccountById(int $quantity, string $destinationAccountId): TransferReport
    {
        $response = $this->toDomDocument(
            $this->sendPostRequest(
                $this->buildEndpointUri('credits'),
                ['quantity' => $quantity, 'target' => $destinationAccountId]
            )
        );

        $this->handleAnyErrors($response);

        $sourceBefore = (int) $response->getElementsByTagName('source_credits_before')->item(0)->textContent;
        $sourceAfter = (int) $response->getElementsByTagName('source_credits_after')->item(0)->textContent;
        $targetBefore = (int) $response->getElementsByTagName('target_credits_before')->item(0)->textContent;
        $targetAfter = (int) $response->getElementsByTagName('target_credits_after')->item(0)->textContent;

        return new TransferReport($sourceBefore, $sourceAfter, $targetBefore, $targetAfter);
    }

    /**
     * @inheritDoc
     */
    public function transferCreditsToAccountByCredentials(int $quantity, Authentication $destinationAccountDetails): TransferReport
    {
        // TODO: DRY!
        $response = $this->toDomDocument(
            $this->sendPostRequest(
                $this->buildEndpointUri('credits'),
                [
                    'quantity' => $quantity,
                    'target_username' => $destinationAccountDetails->getUserName(),
                    'target_password' => $destinationAccountDetails->getPassword()
                ]
            )
        );

        $this->handleAnyErrors($response);

        $sourceBefore = (int) $response->getElementsByTagName('source_credits_before')->item(0)->textContent;
        $sourceAfter = (int) $response->getElementsByTagName('source_credits_after')->item(0)->textContent;
        $targetBefore = (int) $response->getElementsByTagName('target_credits_before')->item(0)->textContent;
        $targetAfter = (int) $response->getElementsByTagName('target_credits_after')->item(0)->textContent;

        return new TransferReport($sourceBefore, $sourceAfter, $targetBefore, $targetAfter);
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

    private function sendGetRequest(string $endpoint): string
    {
        return $this->sendAuthenticatedHttpRequest('get', $endpoint);
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

    /**
     * @param \DOMDocument $domDocument
     * @throws EndpointException
     */
    private function handleAnyErrors(\DOMDocument $domDocument): void
    {
        $errors = $domDocument->getElementsByTagName('errors');

        if ($errors->length > 0) {
            throw new EndpointException(...$this->buildEndpointErrors($errors));
        }
    }

    private function toDomDocument(string $xml): \DOMDocument
    {
        $domDocument = new \DOMDocument();
        $domDocument->loadXML($xml);
        return $domDocument;
    }

    /**
     * @param \DOMDocument $response
     * @return MessageDeliveryReport
     * @throws EndpointException
     */
    private function handleSendMessageResponse(\DOMDocument $response): MessageDeliveryReport
    {

        $this->handleAnyErrors($response);

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

        throw new EndpointException(new EndpointError(
            -1,
            'Unexpected status from the endpoint: ' . $status
        ));
    }

    /**
     * @param $response
     * @throws EndpointException
     */
    private function handleDeleteScheduleMessageResponse($response): void
    {
        $this->handleAnyErrors($response);
    }
}

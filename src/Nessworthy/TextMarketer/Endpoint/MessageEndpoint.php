<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Endpoint;

use Nessworthy\TextMarketer\Message\MessageDeliveryReport;
use Nessworthy\TextMarketer\Message\Command\SendMessage;

/**
 * Message Endpoint
 *
 * The API available to you to interact with Text Marketer's SMS API.
 *
 * @package Nessworthy\TextMarketer\Endpoint
 */
interface MessageEndpoint
{
    /**
     * Send an SMS message.
     * @param SendMessage $message
     * @return MessageDeliveryReport
     * @throws EndpointException
     */
    public function sendMessage(SendMessage $message): MessageDeliveryReport;

    /**
     * Schedule an SMS message to be sent out at a given date.
     * @param SendMessage $message
     * @param \DateTimeImmutable $deliveryTime
     * @return MessageDeliveryReport
     * @throws EndpointException
     */
    public function sendScheduledMessage(SendMessage $message, \DateTimeImmutable $deliveryTime): MessageDeliveryReport;

    /**
     * Delete a scheduled SMS message.
     * Note - this will fail if the message has already been sent.
     * @param string $scheduleId
     * @throws EndpointException
     */
    public function deleteScheduledMessage(string $scheduleId): void;
}

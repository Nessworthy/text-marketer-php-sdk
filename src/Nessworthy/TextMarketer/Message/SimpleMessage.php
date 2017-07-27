<?php
namespace Nessworthy\TextMarketer\Message;

use Nessworthy\TextMarketer\Message\Part\MessagePayload;
use Nessworthy\TextMarketer\Message\Part\Originator;
use Nessworthy\TextMarketer\Message\Part\PhoneNumberCollection;

class SimpleMessage implements Message
{
    private $payload;
    private $phoneNumbers;
    private $originator;

    /**
     * @param string $message The text message payload.
     *                        Up to 612 characters from the GSM alphabet.
     *                        The SMS characters we can support is documented at
     *                        @link http://www.textmarketer.co.uk/blog/2009/07/bulk-sms/supported-and-unsupported-characters-in-text-messages-gsm-character-set/.
     *                        Please ensure that data is encoded in UTF-8.
     *
     * @param string[] $phoneNumbers An array of phone numbers who this message should be sent to.
     *
     * @param string $originator The originating source of the message.
     *                           A string (up to 11 alpha-numeric characters) or the international mobile
     *                           number (up to 16 digits) of the sender, to be displayed
     *                           to the recipient, e.g. 447777123123 for a UK number.
     * @throws InvalidMessageException
     */
    public function __construct($message, $phoneNumbers, $originator)
    {
        // I don't mind making this a bit easier for the user by not having them produce value objects.
        $this->payload = new MessagePayload($message);
        $this->phoneNumbers = new PhoneNumberCollection($phoneNumbers);
        $this->originator = new Originator($originator);
    }

    /**
     * @inheritDoc
     */
    public function getMessageText()
    {
        return $this->payload->getPayload();
    }

    /**
     * @inheritDoc
     */
    public function getMessageRecipients()
    {
        return $this->phoneNumbers->getAllRecipients();
    }

    /**
     * @inheritDoc
     */
    public function getMessageOriginator()
    {
        return $this->originator->getOriginator();
    }
}

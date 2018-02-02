<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Message\Command;

use Nessworthy\TextMarketer\Message\InvalidMessageException;
use Nessworthy\TextMarketer\Message\Part\MessagePayload;
use Nessworthy\TextMarketer\Message\Part\Originator;
use Nessworthy\TextMarketer\Message\Part\PhoneNumberCollection;
use Nessworthy\TextMarketer\Message\Part\CustomTag;
use Nessworthy\TextMarketer\Message\Part\Validity;

class SendMessage
{
    private $payload;
    /** @var PhoneNumberCollection */
    private $phoneNumbers;
    private $originator;
    private $customTag;
    private $validity;
    private $checkSTOP;
    private $txtUsEmail;

    /**
     * @param string $message The text message payload.
     *                        Up to 612 characters from the GSM alphabet.
     *                        The SMS characters we can support is documented at
     * @link http://www.textmarketer.co.uk/blog/2009/07/bulk-sms/supported-and-unsupported-characters-in-text-messages-gsm-character-set/.
     *                        Please ensure that data is encoded in UTF-8.
     *
     * @param string[] $phoneNumbers An array of phone numbers who this message should be sent to.
     *
     * @param string $originator The originating source of the message.
     *                           A string (up to 11 alpha-numeric characters) or the international mobile
     *                           number (up to 16 digits) of the sender, to be displayed
     *                           to the recipient, e.g. 447777123123 for a UK number.
     * @param string $customTag An optional tag to facilitate filtering in reports.
     *                          If used, must be an 1-20 character alpha-numeric string.
     * @param int $validForHours An optional amount in hours to allow the message to attempt be sent for.
     *                           If used, must be inclusively between 1 and 72.
     * @param bool $checkSTOP If true, the recipient numbers will be checked against the STOP group.
     * @param string $txtUsEmail An email address for incoming responses. Must match a txtUs Enterprise originator.
     *                           Only available for txtUs Enterprise users.
     *
     * @throws \Nessworthy\TextMarketer\Message\InvalidMessageException
     */
    public function __construct(
        string $message,
        array $phoneNumbers,
        string $originator,
        string $customTag = null,
        int $validForHours = null,
        bool $checkSTOP = false,
        string $txtUsEmail = null
    ) {
        // I don't mind making this a bit easier for the user by not having them produce value objects.
        $this->payload = new MessagePayload($message);
        $this->handlePhoneNumbers($phoneNumbers);
        $this->originator = new Originator($originator);
        $this->customTag = $customTag ? new CustomTag($customTag) : null;
        $this->validity = $validForHours ? new Validity($validForHours) : null;
        $this->checkSTOP = $checkSTOP;
        $this->txtUsEmail = $txtUsEmail;
    }

    /**
     * @inheritDoc
     */
    public function getMessageText(): string
    {
        return $this->payload->getPayload();
    }

    /**
     * @inheritDoc
     */
    public function getMessageRecipients(): array
    {
        return $this->phoneNumbers->getAllRecipients();
    }

    /**
     * @inheritDoc
     */
    public function getMessageOriginator(): string
    {
        return $this->originator->getOriginator();
    }

    /**
     * @return bool
     */
    public function hasCustomTag(): bool
    {
        return $this->customTag !== null;
    }

    /**
     * @return string|null
     */
    public function getCustomTag(): ?string
    {
        return $this->customTag->toString();
    }

    /**
     * @return bool
     */
    public function hasHourValidity(): bool
    {
        return $this->validity !== null;
    }

    /**
     * @return int|null
     */
    public function getValidity(): ?int
    {
        return $this->validity->toInt();
    }

    /**
     * @return bool
     */
    public function isCheckSTOPEnabled(): bool
    {
        return $this->checkSTOP;
    }

    public function getTxtUsEmail(): ?string
    {
        return $this->txtUsEmail;
    }

    /**
     * @param string[] $phoneNumbers
     * @throws InvalidMessageException
     */
    private function handlePhoneNumbers(array $phoneNumbers): void
    {
        $numbers = new PhoneNumberCollection($phoneNumbers);

        if ($numbers->getTotal() === 0) {
            throw new InvalidMessageException(
                'Messages must be sent to at least one recipient. None were provided.',
                InvalidMessageException::E_RECIPIENTS_TOO_FEW
            );
        }

        // TODO: Support up to more, but trickle at the dispatcher level.
        if ($numbers->getTotal() > 500) {
            throw new InvalidMessageException(
                sprintf(
                    'Up to 500 recipients can be used for a single message. You have somehow exceeded that limit by trying to send this to %s recipients.',
                    \count($phoneNumbers)
                ),
                InvalidMessageException::E_RECIPIENTS_TOO_MANY
            );
        }

        $this->phoneNumbers = $numbers;
    }

    public function hasTxtUsEmail(): bool
    {
        return $this->txtUsEmail !== null;
    }
}

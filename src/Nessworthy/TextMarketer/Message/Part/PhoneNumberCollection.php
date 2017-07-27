<?php
namespace Nessworthy\TextMarketer\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;

class PhoneNumberCollection
{
    private $phoneNumbers;

    /**
     * PhoneNumberCollection constructor.
     * @param string[] $phoneNumbers A collection of phone numbers. Supports prefixing with international code.
     * @throws InvalidMessageException
     */
    public function __construct(array $phoneNumbers)
    {
        $phoneNumbers = array_values($phoneNumbers);

        if (count($phoneNumbers) === 0) {
            throw new InvalidMessageException(
                'Messages must be sent to at least one recipient. None were provided.',
                InvalidMessageException::E_RECIPIENTS_TOO_FEW
            );
        }

        // TODO: Support up to more, but trickle at the dispatcher level.
        if (count($phoneNumbers) > 500) {
            throw new InvalidMessageException(
                sprintf(
                    'Up to 500 recipients can be used for a single message. You have somehow exceeded that limit by trying to send this to %s recipients.',
                    count($phoneNumbers)
                ),
                InvalidMessageException::E_RECIPIENTS_TOO_MANY
            );
        }

        foreach ($phoneNumbers as $index => $phoneNumber) {
            if (!is_string($phoneNumber)) {
                throw new InvalidMessageException(
                    sprintf(
                        'Recipients must only be provided as strings. The recipient as position %s was of type %s.',
                        $index,
                        gettype($phoneNumber)
                    ),
                    InvalidMessageException::E_RECIPIENTS_INVALID
                );
            }
            if (!ctype_digit($phoneNumber)) {
                throw new InvalidMessageException(
                    sprintf(
                    'Recipients must only be numbers. The recipient at position %d contained more than that.',
                        $index
                    ),
                    InvalidMessageException::E_RECIPIENTS_INVALID
                );
            }
        }

        $this->phoneNumbers = $phoneNumbers;
    }

    /**
     * @return string[]
     */
    public function getAllRecipients()
    {
        return $this->phoneNumbers;
    }
}

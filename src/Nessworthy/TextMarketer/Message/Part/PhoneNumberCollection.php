<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;

final class PhoneNumberCollection
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

        foreach ($phoneNumbers as $index => $phoneNumber) {
            if (!\is_string($phoneNumber)) {
                throw new InvalidMessageException(
                    sprintf(
                        'Phone numbers must only be provided as strings. The number as position %s was of type %s.',
                        $index,
                        \gettype($phoneNumber)
                    ),
                    InvalidMessageException::E_RECIPIENTS_INVALID
                );
            }
            if (!ctype_digit($phoneNumber)) {
                throw new InvalidMessageException(
                    sprintf(
                    'Phone numbers must only contain numbers. The number at position %d contained more than that.',
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
    public function getAllRecipients(): array
    {
        return $this->phoneNumbers;
    }

    public function getTotal(): int
    {
        return \count($this->phoneNumbers);
    }
}

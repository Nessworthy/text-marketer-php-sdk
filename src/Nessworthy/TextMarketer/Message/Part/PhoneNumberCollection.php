<?php declare(strict_types=1);
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

        foreach ($phoneNumbers as $index => $phoneNumber) {
            if (!\is_string($phoneNumber)) {
                throw new InvalidMessageException(
                    sprintf(
                        'Phone numbers must only be provided as strings. The number at position %s was of type %s.',
                        $index,
                        \gettype($phoneNumber)
                    ),
                    InvalidMessageException::E_RECIPIENTS_INVALID
                );
            }
            if (!preg_match('#^\+?\d+$#', $phoneNumber)) {
                throw new InvalidMessageException(
                    sprintf(
                    'Phone numbers must only contain numbers with an optional prefix of +. The number at position %d contained more than that.',
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
    public function asArray(): array
    {
        return $this->phoneNumbers;
    }

    public function getTotal(): int
    {
        return \count($this->phoneNumbers);
    }
}

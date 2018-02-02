<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;

final class Validity
{
    private $hours;

    /**
     * Validity constructor.
     * @param int $timeInHours
     * @throws InvalidMessageException
     */
    public function __construct(int $timeInHours)
    {
        if ($timeInHours < 1) {
            throw new InvalidMessageException(
                'The lowest amount of time a message can be valid for is 1 hour, a lower amount was provided.',
                InvalidMessageException::E_VALIDITY_TOO_LOW
            );
        }

        if ($timeInHours > 72) {
            throw new InvalidMessageException(
                'The highest amount of time a message can be valid for is 72 hours, a higher amount was provided.',
                InvalidMessageException::E_VALIDITY_TOO_HIGH
            );
        }

        $this->hours = $timeInHours;
    }

    public function toInt(): int
    {
        return $this->hours;
    }
}

<?php
namespace Nessworthy\TextMarketer\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;

class Originator
{
    private $originator;

    /**
     * Originator constructor.
     * @param string $originator The originating source of the message.
     *                           A string (up to 11 alpha-numeric characters) or the international mobile
     *                           number (up to 16 digits) of the sender, to be displayed
     *                           to the recipient, e.g. 447777123123 for a UK number.
     * @throws InvalidMessageException
     */
    public function __construct($originator)
    {
        if (!is_string($originator)) {
            throw new InvalidMessageException(
                sprintf(
                    'The originator was expected to be a string, %s given.',
                    gettype($originator)
                ),
                InvalidMessageException::E_ORIGINATOR_INVALID
            );
        }

        $length = strlen($originator);
        if ($length > 16 || (!is_numeric($originator) && $length > 11)) {
            throw new InvalidMessageException(
                sprintf(
                    'The originator was too long. The originator can be 11 alpha-numeric characters, or 16 digits. %s characters given.',
                    $length
                ),
                InvalidMessageException::E_ORIGINATOR_TOO_LONG
            );
        }

        if ($length < 1) {
            throw new InvalidMessageException(
                'The originator was too short. It\'s a required field, and can\'t be empty.',
                InvalidMessageException::E_ORIGINATOR_TOO_SHORT
            );
        }
        $this->originator = $originator;
    }

    public function getOriginator()
    {
        return $this->originator;
    }
}

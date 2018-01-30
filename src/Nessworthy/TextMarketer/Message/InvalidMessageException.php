<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Message;

use Nessworthy\TextMarketer\TextMarketerException;

class InvalidMessageException extends  TextMarketerException
{
    /**
     * Used when the supplied message payload is not a string.
     */
    const E_MESSAGE_INVALID = 501;

    /**
     * Used when the supplied message payload is too short (read: 0 characters).
     */
    const E_MESSAGE_TOO_SHORT = 502;

    /**
     * Used when the message is too long (612 character limit).
     */
    const E_MESSAGE_TOO_LONG = 503;

    /**
     * Used when the message payload contains characters which are not in the standard GSM 03.38 alphabet.
     * @link https://en.wikipedia.org/wiki/GSM_03.38
     */
    const E_MESSAGE_NOT_GSM_ONLY = 504;

    /**
     * Used when the recipient list is not an array of strings.
     */
    const E_RECIPIENTS_INVALID = 511;

    /**
     * Used when the recipient list contains too few recipients (read: 0).
     */
    const E_RECIPIENTS_TOO_FEW = 512;

    /**
     * Used when the recipient list contains too many recipients (limit of 500).
     * https://wiki.textmarketer.co.uk/display/DevDoc/Sending+SMS
     */
    const E_RECIPIENTS_TOO_MANY = 513;

    /**
     * Used when the originator given is not a string.
     */
    const E_ORIGINATOR_INVALID = 521;

    /**
     * Used when the originator given is too short (read: 0 characters).
     */
    const E_ORIGINATOR_TOO_SHORT = 522;

    /**
     * Used when the originator given is too long (limit of 11 alphanumeric characters, or 16 digits).
     */
    const E_ORIGINATOR_TOO_LONG = 523;
}

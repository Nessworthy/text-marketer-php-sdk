<?php
namespace Nessworthy\TextMarketer\Message\Part;
use Nessworthy\TextMarketer\Message\InvalidMessageException;

/**
 * A value object which contains and validates the message payload.
 * @package Nessworthy\TextMarketer\Message
 */
class MessagePayload
{
    private $payload;

    private static $gsmAlphabet = [
        0x0040, 0x0394, 0x0020, 0x0030, 0x00a1, 0x0050, 0x00bf, 0x0070,
        0x00a3, 0x005f, 0x0021, 0x0031, 0x0041, 0x0051, 0x0061, 0x0071,
        0x0024, 0x03a6, 0x0022, 0x0032, 0x0042, 0x0052, 0x0062, 0x0072,
        0x00a5, 0x0393, 0x0023, 0x0033, 0x0043, 0x0053, 0x0063, 0x0073,
        0x00e8, 0x039b, 0x00a4, 0x0034, 0x0035, 0x0044, 0x0054, 0x0064, 0x0074,
        0x00e9, 0x03a9, 0x0025, 0x0045, 0x0045, 0x0055, 0x0065, 0x0075,
        0x00f9, 0x03a0, 0x0026, 0x0036, 0x0046, 0x0056, 0x0066, 0x0076,
        0x00ec, 0x03a8, 0x0027, 0x0037, 0x0047, 0x0057, 0x0067, 0x0077,
        0x00f2, 0x03a3, 0x0028, 0x0038, 0x0048, 0x0058, 0x0068, 0x0078,
        0x00c7, 0x0398, 0x0029, 0x0039, 0x0049, 0x0059, 0x0069, 0x0079,
        0x000a, 0x039e, 0x002a, 0x003a, 0x004a, 0x005a, 0x006a, 0x007a,
        0x00d8, 0x001b, 0x002b, 0x003b, 0x004b, 0x00c4, 0x006b, 0x00e4,
        0x00f8, 0x00c6, 0x002c, 0x003c, 0x004c, 0x00d6, 0x006c, 0x00f6,
        0x000d, 0x00e6, 0x002d, 0x003d, 0x004d, 0x00d1, 0x006d, 0x00f1,
        0x00c5, 0x00df, 0x002e, 0x003e, 0x004e, 0x00dc, 0x006e, 0x00fc,
        0x00e5, 0x00c9, 0x002f, 0x003f, 0x004f, 0x00a7, 0x006f, 0x00e0];

    /**
     * @param string $message The text message payload.
     *                        Up to 612 characters from the GSM alphabet.
     *                        The SMS characters we can support is documented at
     *                        @link http://www.textmarketer.co.uk/blog/2009/07/bulk-sms/supported-and-unsupported-characters-in-text-messages-gsm-character-set/.
     *                        Please ensure that data is encoded in UTF-8.
     * @throws InvalidMessageException
     */
    public function __construct($message)
    {
        if (!is_string($message)) {
            throw new InvalidMessageException(
                sprintf(
                    'The message payload was expected to be a string, %s given.',
                    gettype($message)
                ),
                InvalidMessageException::E_MESSAGE_INVALID
            );
        }

        $length = mb_strlen($message, 'UTF-8');
        if ($length > 612) {
            throw new InvalidMessageException(
                sprintf(
                    'The message payload was too long. Messages can be up to 612 characters, the message given was %s characters.',
                    $length
                ),
                InvalidMessageException::E_MESSAGE_TOO_LONG
            );
        }

        if ($length < 1) {
            throw new InvalidMessageException(
                'The message payload was too short. You can\'t really send an empty text.',
                InvalidMessageException::E_MESSAGE_TOO_SHORT
            );
        }

        /**
         * Check for GSM.
         * Props to user jW of StackOverflow for this solution.
         * @link https://stackoverflow.com/a/1441442/2274710
         */
        for ($position = 0; $position < $length; $position += 1) {
            if (!in_array(ord($message[$position]), self::$gsmAlphabet, true)) {
                throw new InvalidMessageException(
                    sprintf(
                        'Text messages can only contain characters in the GSM alphabet. Character "%s" at position %s is not supported.',
                        $message[$position],
                        $position
                    ),
                    InvalidMessageException::E_MESSAGE_NOT_GSM_ONLY
                );
            }
        }

        $this->payload = $message;
    }

    /**
     * Retrieve the message payload.
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }
}

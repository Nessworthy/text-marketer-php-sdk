<?php declare(strict_types=1);
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
        '@','Δ',' ','0','¡','P','¿','p',
        '£','_','!','1','A','Q','a','q',
        '$','Φ','"','2','B','R','b','r',
        '¥','Γ','#','3','C','S','c','s',
        'è','Λ','¤','4','D','T','d','t',
        'é','Ω','%','5','E','U','e','u',
        'ù','Π','&','6','F','V','f','v',
        'ì','Ψ','\'','7','G','W','g','w',
        'ò','Σ','(','8','H','X','h','x',
        'Ç','Θ',')','9','I','Y','i','y',
        "\n",'Ξ','*',':','J','Z','j','z',
        'Ø',"\x1B",'+',';','K','Ä','k','ä',
        'ø','Æ',',','<','L','Ö','l','ö',
        "\r",'æ','-','=','M','Ñ','m','ñ',
        'Å','ß','.','>','N','Ü','n','ü',
        'å','É','/','?','O','§','o','à'];

    /**
     * @param string $message The text message payload.
     *                        Up to 612 characters from the GSM alphabet.
     *                        The SMS characters we can support is documented at
     *                        @link http://www.textmarketer.co.uk/blog/2009/07/bulk-sms/supported-and-unsupported-characters-in-text-messages-gsm-character-set/.
     *                        Please ensure that data is encoded in UTF-8.
     * @throws InvalidMessageException
     */
    public function __construct(string $message)
    {
        $length = \strlen($message);
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
         * Props to user Sergey Shunchkin of StackOverflow for this solution.
         * @link https://stackoverflow.com/a/12196609/2274710
         */
        $length = mb_strlen( $message, 'UTF-8');

        for ($currentPosition = 0; $currentPosition < $length; $currentPosition++) {
            if (!\in_array(mb_substr($message,$currentPosition,1,'UTF-8'), self::$gsmAlphabet, true)) {
                throw new InvalidMessageException(
                    sprintf(
                        'Text messages can only contain characters in the GSM alphabet. Character "%s" at position %s is not supported.',
                        mb_substr($message, $currentPosition, 1, 'UTF-8'),
                        $currentPosition
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
    public function getPayload(): string
    {
        return $this->payload;
    }
}

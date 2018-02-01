<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;

class CustomTag
{
    private $tag;

    /**
     * CustomTag constructor.
     * @param string $tag
     * @throws InvalidMessageException
     */
    public function __construct(string $tag)
    {
        if ('' === $tag) {
            throw new InvalidMessageException(
                'The custom tag must be at least 1 character, but an empty string was given.',
                InvalidMessageException::E_CUSTOM_TAG_TOO_SHORT
            );
        }

        if (\strlen($tag) > 20) {
            throw new InvalidMessageException(
                'The custom tag must be at most 20 characters. ' . \strlen($tag) . ' supplied.',
                InvalidMessageException::E_CUSTOM_TAG_TOO_LONG
            );
        }

        if (!preg_match('#^[a-zA-Z0-9]+$#', $tag)) {
            throw new InvalidMessageException(
                'The custom tag must be alphanumeric and should therefore only contain basic letters and numbers.',
                InvalidMessageException::E_CUSTOM_TAG_INVALID
            );
        }


        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->tag;
    }
}

<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Test\Unit\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;
use Nessworthy\TextMarketer\Message\Part\CustomTag;
use PHPUnit\Framework\TestCase;

class CustomTagTest extends TestCase
{
    public function testUsingAcceptableTagIsRetrievable()
    {
        $tag = new CustomTag('MyCustomTag');
        $this->assertEquals('MyCustomTag', $tag->toString());
    }

    public function testUsingAnEmptyTagThrowsInvalidMessageException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_CUSTOM_TAG_TOO_SHORT);

        new CustomTag('');
    }

    /**
     * @dataProvider customTagsOverTwentyCharactersProvider
     * @param string $customTagOverTwentyCharacters
     */
    public function testUsingTagMoreThanTwentyCharactersLongThrowsInvalidMessageException(string $customTagOverTwentyCharacters)
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_CUSTOM_TAG_TOO_LONG);

        new CustomTag($customTagOverTwentyCharacters);
    }

    /**
     * @dataProvider nonAlphaNumericTagProvider
     * @param string $nonAlphaNumericTag
     */
    public function testUsingNonAlphaNumericTagThrowsInvalidMessageException(string $nonAlphaNumericTag)
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_CUSTOM_TAG_INVALID);

        new CustomTag($nonAlphaNumericTag);
    }

    public function customTagsOverTwentyCharactersProvider()
    {
        return [
            ['abcdefghijklmnopqrstu'],
            ['abcdefghijklmnopqrstuv'],
            ['abcdefghijklmnopqrstuvw'],
            ['abcdefghijklmnopqrstuvwx'],
            ['€€€€€€€€€€1'],
            ['010110110101110110010101001010101010'], // Not actually binary.
            [str_repeat('all work and no beer make homer go crazy', 100)]
        ];
    }

    public function nonAlphaNumericTagProvider()
    {
        return [
            ['My name is sean'],
            ['cookie.cooookieee.'],
            ['☺'],
            ['DoubleRainbow!'],
        ];
    }
}

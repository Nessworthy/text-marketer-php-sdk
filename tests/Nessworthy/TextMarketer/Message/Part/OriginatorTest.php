<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Tests\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;
use Nessworthy\TextMarketer\Message\Part\Originator;
use PHPUnit\Framework\TestCase;

class OriginatorTest extends TestCase
{
    /**
     * @dataProvider acceptableOriginatorsProvider
     * @param string $originatorString
     */
    public function testAcceptableOriginatorNamesAreTheSameInTheGetter(string $originatorString)
    {
        $originator = new Originator($originatorString);
        $this->assertEquals($originatorString, $originator->getOriginator());
    }

    /**
     * @dataProvider alphaNumericOriginatorsOverElevenCharactersProvider
     */
    public function testAlphaNumericOriginatorsOver11CharactersThrowInvalidMessageException(string $originatorString)
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_ORIGINATOR_TOO_LONG);
        new Originator($originatorString);
    }

    public function testEmptyOriginatorThrowsInvalidMessageException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_ORIGINATOR_TOO_SHORT);
        new Originator('');
    }

    public function testMobileNumberProviderOverSixteenCharactersThrowsInvalidMessageException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_ORIGINATOR_TOO_LONG);
        new Originator('123456789101234567');
    }

    public function acceptableOriginatorsProvider()
    {
        return [
            ['JohnSmith'],
            ['A'],
            ['John12345'],
            ['ASixteenCha'],
            ['5'],
            ['0000000000000000'],
        ];
    }

    public function alphaNumericOriginatorsOverElevenCharactersProvider()
    {
        return [
            ['JonathonSmithy'],
            ['JonathonSmall'],
            ['JonnySmaller'],
            ['J0nnySm4ll3r'],
        ];
    }
}

<?php
namespace Nessworthy\TextMarketer\Tests\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;
use Nessworthy\TextMarketer\Message\Part\Originator;
use PHPUnit\Framework\TestCase;

class OriginatorTest extends TestCase
{
    public function testPassingNonStringThrowsInvalidException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_ORIGINATOR_INVALID);

        new Originator(['array']);
    }

    public function testPassingLongPayloadThrowsInvalidException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_ORIGINATOR_TOO_LONG);

        new Originator(str_repeat('a', 12));
    }

    public function testPassingOnlyDigitsAllowsLongerOriginator()
    {
        $originator = new Originator('1234567890123456');
        $this->assertEquals('1234567890123456', $originator->getOriginator());
    }

    public function testPassingEvenLongerDigitStringThrowsInvalidException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_ORIGINATOR_TOO_LONG);

        new Originator('12345678901234567');
    }

    public function testPassingEmptyStringThrowsInvalidException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_ORIGINATOR_TOO_SHORT);

        new Originator('');
    }
}
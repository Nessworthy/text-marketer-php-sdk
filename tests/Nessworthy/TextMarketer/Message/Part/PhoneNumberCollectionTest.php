<?php
namespace Nessworthy\TextMarketer\Tests\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;
use Nessworthy\TextMarketer\Message\Part\PhoneNumberCollection;
use PHPUnit\Framework\TestCase;

class PhoneNumberCollectionTest extends TestCase
{

    public function testAsArray(): void
    {
        $numbers = ['07000000000', '07000000001', '07000000002'];
        $collection = new PhoneNumberCollection($numbers);
        $emptyCollection = new PhoneNumberCollection([]);

        $this->assertEquals($numbers, $collection->asArray());
        $this->assertEmpty($emptyCollection->asArray());
    }

    public function testGetTotal(): void
    {
        $numbers = ['07000000000', '+44700000001', '07000000002'];
        $collection = new PhoneNumberCollection($numbers);
        $emptyCollection = new PhoneNumberCollection([]);

        $this->assertEquals(3, $collection->getTotal());
        $this->assertEquals(0, $emptyCollection->getTotal());
    }

    public function testPassingNonStringAsNumberThrowsInvalidMessageException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_RECIPIENTS_INVALID);
        new PhoneNumberCollection([true]);
    }

    public function testPassingNumberWhichContainsLettersThrowsInvalidMessageException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_RECIPIENTS_INVALID);
        new PhoneNumberCollection(['+44078batman0000']);
    }
}

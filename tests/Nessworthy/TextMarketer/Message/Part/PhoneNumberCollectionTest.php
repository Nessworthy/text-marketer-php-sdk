<?php
namespace Nessworthy\TextMarketer\Tests\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;
use Nessworthy\TextMarketer\Message\Part\PhoneNumberCollection;
use PHPUnit\Framework\TestCase;

class PhoneNumberCollectionTest extends TestCase
{
    public function testPassingTooManyPhoneNumbersThrowsInvalidException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_RECIPIENTS_TOO_MANY);

        new PhoneNumberCollection(array_fill(0, 501, '111111111'));
    }

    public function testPassingEmptyArrayThrowsInvalidException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_RECIPIENTS_TOO_FEW);

        new PhoneNumberCollection([]);
    }

    public function testPassingInvalidPhoneNumberThrowException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_RECIPIENTS_INVALID);

        new PhoneNumberCollection(['0000000000', 'apple']);
    }

    public function testPassingInvalidTypeForPhoneNumberThrowsException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_RECIPIENTS_INVALID);

        new PhoneNumberCollection(['0000000000', []]);
    }

    public function testPassingPhoneNumbersWorksNormally()
    {
        $numbers = array_fill(0, 100, '1111111111');
        $collection = new PhoneNumberCollection($numbers);
        $this->assertEquals($numbers, $collection->getAllRecipients());
    }
}
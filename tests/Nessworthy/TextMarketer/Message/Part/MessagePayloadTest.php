<?php
namespace Nessworthy\TextMarketer\Tests\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;
use Nessworthy\TextMarketer\Message\Part\MessagePayload;
use PHPUnit\Framework\TestCase;

class MessagePayloadTest extends TestCase
{
    public function testPassingNonStringThrowsInvalidException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_MESSAGE_INVALID);

        new MessagePayload(['array']);
    }

    public function testPassingLongPayloadThrowsInvalidException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_MESSAGE_TOO_LONG);

        new MessagePayload(str_repeat('a', 613));
    }

    public function testPassingEmptyStringThrowsInvalidException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_MESSAGE_TOO_SHORT);

        new MessagePayload('');
    }

    public function testPassingCharacterOutsideOfGSMAlphabetThrowsInvalidException()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_MESSAGE_NOT_GSM_ONLY);

        new MessagePayload('¿');
    }

    public function testPassingValidMessageDoesNotThrowException()
    {
        $message = 'Hello, my name is Nessworthy and I enjoy writing unit tests :).';
        $payload = new MessagePayload($message);
        $this->assertEquals($message, $payload->getPayload());
    }
}
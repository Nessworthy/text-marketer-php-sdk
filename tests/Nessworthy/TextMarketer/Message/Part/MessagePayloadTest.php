<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Tests\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;
use Nessworthy\TextMarketer\Message\Part\MessagePayload;
use PHPUnit\Framework\TestCase;

class MessagePayloadTest extends TestCase
{
    /**
     * @dataProvider acceptableMessageProvider
     * @param string $message
     */
    public function testNormalMessageReturnsExactResult(string $message)
    {
        $payload = new MessagePayload($message);
        $this->assertEquals($message, $payload->getPayload());
    }

    /**
     * @dataProvider longMessageProvider
     * @param string $longMessage
     */
    public function testInvalidMessageExceptionIsThrownIfMessageIsLongerThan612Characters(string $longMessage)
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_MESSAGE_TOO_LONG);
        new MessagePayload($longMessage);
    }

    public function testInvalidMessageExceptionIsThrownIfMessageIsEmpty()
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_MESSAGE_TOO_SHORT);
        new MessagePayload('');
    }

    /**
     * @dataProvider nonGSMMessageProvider
     */
    public function testMessagesContainingNonGSMCharactersTriggerInvalidMessageException(string $message)
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_MESSAGE_NOT_GSM_ONLY);
        new MessagePayload($message);
    }

    public function longMessageProvider()
    {
        return [
            [str_repeat('a', 613)],
            [str_repeat('A', 620)],
            [str_repeat('!', 630)],
            [str_repeat('@', 650)],
            [str_repeat('@', 613)],
            [str_repeat('€', 307)], // Multi-byte!
        ];
    }

    public function nonGSMMessageProvider()
    {
        return [
            ['© Some Guy 2010'],
            ['Happy times! ☺'],
            ['I have the 7 of ♥'],
        ];
    }

    public function acceptableMessageProvider()
    {
        return [
            ['@ΔSP0¡P¿p'],
            ['£_!1AQaq$Φ"2BRbr¥Γ#3CScs'],
            ['èΛ¤4DTdtéΩ%5EUeuùΠ&6FVfvìΨ\'7GWgw'],
            ['òΣ(8HXhxÇΘ)9IYiyLFΞ*:JZjzØESC+;KÄkä'],
            ['øÆ,<LÖlöCRæ-=MÑmñÅß.>NÜnüåÉ/?O§oà'],
        ];
    }
}
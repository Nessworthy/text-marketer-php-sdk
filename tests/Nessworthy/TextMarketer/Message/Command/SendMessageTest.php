<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Tests\Message\Command;

use Nessworthy\TextMarketer\Message\Command\SendMessage;
use PHPUnit\Framework\TestCase;

/**
 * Class SendMessageTest
 * @package Nessworthy\TextMarketer\Tests\Message
 *
 * Just a note: Validation testing is done in the Part VOs.
 */
class SendMessageTest extends TestCase
{
    public function testSettingUpMessageReturnsCorrectDetails()
    {
        $message = new SendMessage(
            'My test message',
            ['447777777'],
            'Testing',
            'customtag',
            50,
            true,
            'my.email@address.com'
        );

        $this->assertEquals('My test message', $message->getMessageText());
        $this->assertEquals(['447777777'], $message->getMessageRecipients());
        $this->assertEquals('Testing', $message->getMessageOriginator());
        $this->assertEquals('customtag', $message->getCustomTag());
        $this->assertEquals(50, $message->getValidity());
        $this->assertEquals(true, $message->isCheckSTOPEnabled());
        $this->assertEquals('my.email@address.com', $message->getTxtUsEmail());

        $this->assertTrue($message->hasHourValidity());
        $this->assertTrue($message->hasCustomTag());
    }
}

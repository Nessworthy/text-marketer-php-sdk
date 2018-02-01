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
            'Testing'
        );

        $this->assertEquals('My test message', $message->getMessageText());
        $this->assertEquals(['447777777'], $message->getMessageRecipients());
        $this->assertEquals('Testing', $message->getMessageOriginator());
    }
}

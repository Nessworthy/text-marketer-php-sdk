<?php

namespace Nessworthy\TextMarketer\Test\Unit\SendGroup;

use Nessworthy\TextMarketer\Message\Part\PhoneNumberCollection;
use Nessworthy\TextMarketer\SendGroup\SendGroup;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SendGroupTest extends TestCase
{

    public function testGetId(): void
    {
        /** @var MockObject|PhoneNumberCollection $stubbedCollection */
        $stubbedCollection = $this->createMock(PhoneNumberCollection::class);

        $sendGroup = new SendGroup('my-id', 'My Name', false, $stubbedCollection);

        $this->assertEquals('my-id', $sendGroup->getId());
    }

    public function testGetName(): void
    {
        /** @var MockObject|PhoneNumberCollection $stubbedCollection */
        $stubbedCollection = $this->createMock(PhoneNumberCollection::class);

        $sendGroup = new SendGroup('my-id', 'My Name', false, $stubbedCollection);

        $this->assertEquals('My Name', $sendGroup->getName());
    }

    public function testGetNumbers(): void
    {
        /** @var MockObject|PhoneNumberCollection $stubbedCollection */
        $stubbedCollection = $this->createMock(PhoneNumberCollection::class);
        $stubbedCollection
            ->method('asArray')
            ->willReturn(['0000000019']);

        $sendGroup = new SendGroup('my-id', 'My Name', false, $stubbedCollection);

        $this->assertEquals(['0000000019'], $sendGroup->getNumbers());
    }

    public function testGetNumberCount(): void
    {
        /** @var MockObject|PhoneNumberCollection $stubbedCollection */
        $stubbedCollection = $this->createMock(PhoneNumberCollection::class);
        $stubbedCollection
            ->method('getTotal')
            ->willReturn(50);

        $sendGroup = new SendGroup('my-id', 'My Name', false, $stubbedCollection);

        $this->assertEquals(50, $sendGroup->getNumberCount());
    }

    public function testIsStopGroup(): void
    {
        /** @var MockObject|PhoneNumberCollection $stubbedCollection */
        $stubbedCollection = $this->createMock(PhoneNumberCollection::class);

        $sendGroupIsStopGroup = new SendGroup('my-id', 'My Name', true, $stubbedCollection);
        $sendGroupIsNotStopGroup = new SendGroup('my-id', 'My Name', false, $stubbedCollection);

        $this->assertTrue($sendGroupIsStopGroup->isStopGroup());
        $this->assertFalse($sendGroupIsNotStopGroup->isStopGroup());
    }
}

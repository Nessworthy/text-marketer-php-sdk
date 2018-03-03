<?php

namespace Nessworthy\TextMarketer\Tests\Keyword;

use Nessworthy\TextMarketer\Keyword\KeywordAvailability;
use PHPUnit\Framework\TestCase;

class KeywordAvailabilityTest extends TestCase
{

    public function testIsAvailable()
    {
        $keywordIsAvailableObject = new KeywordAvailability(true, true);
        $keywordIsNotAvailableObject = new KeywordAvailability(false, true);

        $this->assertTrue($keywordIsAvailableObject->isAvailable());
        $this->assertFalse($keywordIsNotAvailableObject->isAvailable());
    }

    public function testIsRecycled()
    {
        $keywordIsRecycledObject = new KeywordAvailability(true, true);
        $keywordIsNotRecycledObject = new KeywordAvailability(true, false);

        $this->assertTrue($keywordIsRecycledObject->isRecycled());
        $this->assertFalse($keywordIsNotRecycledObject->isRecycled());
    }
}

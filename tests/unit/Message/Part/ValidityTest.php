<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Test\Unit\Message\Part;

use Nessworthy\TextMarketer\Message\InvalidMessageException;
use Nessworthy\TextMarketer\Message\Part\Validity;
use PHPUnit\Framework\TestCase;

class ValidityTest extends TestCase
{
    public function testAcceptableValidityIsRetrievable()
    {
        $validity = new Validity(24);
        $this->assertEquals(24, $validity->toInt());
    }

    /**
     * @dataProvider hoursUnderOneProvider
     * @param int $hourUnderOne
     */
    public function testPassingValidityUnderAnHourThrowsInvalidMessageException(int $hourUnderOne)
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_VALIDITY_TOO_LOW);
        new Validity($hourUnderOne);
    }

    /**
     * @dataProvider hoursOverSeventyTwoProvider
     * @param int $hoursOverSeventyTwo
     */
    public function testPassingValidityOverSeventyTwoHoursThrowsInvalidMessageException(int $hoursOverSeventyTwo)
    {
        $this->expectException(InvalidMessageException::class);
        $this->expectExceptionCode(InvalidMessageException::E_VALIDITY_TOO_HIGH);
        new Validity($hoursOverSeventyTwo);
    }

    public function hoursUnderOneProvider()
    {
        return [
            [0],
            [-1],
            [-10],
            [-1e2],
            [-77],
        ];
    }

    public function hoursOverSeventyTwoProvider()
    {
        return [
            [73],
            [730],
            [7300],
            [10e3],
        ];
    }
}

<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Tests\Account\Command;

use Nessworthy\TextMarketer\Account\AccountInformationException;
use Nessworthy\TextMarketer\Account\Command\UpdateAccountInformation;
use PHPUnit\Framework\TestCase;

class UpdateAccountInformationTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testPassingAccountUserNameLessThanFiveCharactersThrowsAccountInformationException()
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_USERNAME_TOO_SHORT);

        new UpdateAccountInformation(
            'sean',
            null,
            null,
            null,
            null,
            null,
            null
        );
    }

    public function testPassingAccountUserNameGreaterThanTwentyCharactersThrowsAccountInformationException()
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_USERNAME_TOO_LONG);

        new UpdateAccountInformation(
            'iaintthesharpesttooli',
            null,
            null,
            null,
            null,
            null,
            null
        );
    }

    /**
     * @dataProvider nonAlphaNumericValidStringProvider
     * @param string $accountName
     */
    public function testPassingNonAlphaNumericAccountUserNameThrowsAccountInformationException(string $accountName)
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_USERNAME_INVALID);

        new UpdateAccountInformation(
            $accountName,
            null,
            null,
            null,
            null,
            null,
            null
        );
    }

    public function testPassingAccountPasswordLessThanFiveCharactersThrowsAccountInformationException()
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_PASSWORD_TOO_SHORT);

        new UpdateAccountInformation(
            null,
            'dude',
            null,
            null,
            null,
            null,
            null
        );
    }

    public function testPassingAccountPasswordGreaterThanTwentyCharactersThrowsAccountInformationException()
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_PASSWORD_TOO_LONG);

        new UpdateAccountInformation(
            null,
            'onceuponatimetherewas',
            null,
            null,
            null,
            null,
            null
        );
    }

    /**
     * @dataProvider nonAlphaNumericValidStringProvider
     * @param string $accountPassword
     */
    public function testPassingNonAlphaNumericAccountPasswordThrowsAccountInformationException(string $accountPassword)
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_PASSWORD_INVALID);

        new UpdateAccountInformation(
            null,
            $accountPassword,
            null,
            null,
            null,
            null,
            null
        );
    }

    public function testUnfinished()
    {
        $this->markTestIncomplete('Missing tests for api creds, company name, email and number.');
    }

    public function nonAlphaNumericValidStringProvider()
    {
        return [
            ['( ͡° ͜ʖ ͡°)'],
            ['space seperated'],
            ['1+1=11'],
            ['düfromage'],
        ];
    }
}

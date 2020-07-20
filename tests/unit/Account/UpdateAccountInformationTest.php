<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Test\Unit\Account;

use Nessworthy\TextMarketer\Account\AccountInformationException;
use Nessworthy\TextMarketer\Account\UpdateAccountInformation;
use PHPUnit\Framework\TestCase;

class UpdateAccountInformationTest extends TestCase
{
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

    public function testPassingApiUserNameLessThanFiveCharactersThrowsAccountInformationException()
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_API_USERNAME_TOO_SHORT);

        new UpdateAccountInformation(
            null,
            null,
            'cape',
            null,
            null,
            null,
            null
        );
    }

    public function testPassingApiUserNameGreaterThanTwentyCharactersThrowsAccountInformationException()
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_API_USERNAME_TOO_LONG);

        new UpdateAccountInformation(
            null,
            null,
            'waslookingkindadumbwi',
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
    public function testPassingNonAlphaNumericApiUserNameThrowsAccountInformationException(string $accountName)
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_API_USERNAME_INVALID);

        new UpdateAccountInformation(
            null,
            null,
            $accountName,
            null,
            null,
            null,
            null
        );
    }

    public function testPassingApiPasswordLessThanFiveCharactersThrowsAccountInformationException()
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_API_PASSWORD_TOO_SHORT);

        new UpdateAccountInformation(
            null,
            null,
            null,
            'dude',
            null,
            null,
            null
        );
    }

    public function testPassingApiPasswordGreaterThanTwentyCharactersThrowsAccountInformationException()
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_API_PASSWORD_TOO_LONG);

        new UpdateAccountInformation(
            null,
            null,
            null,
            'onceuponatimetherewas',
            null,
            null,
            null
        );
    }

    /**
     * @dataProvider nonAlphaNumericValidStringProvider
     * @param string $accountPassword
     */
    public function testPassingNonAlphaNumericApiPasswordThrowsAccountInformationException(string $accountPassword)
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_API_PASSWORD_INVALID);

        new UpdateAccountInformation(
            null,
            null,
            null,
            $accountPassword,
            null,
            null,
            null
        );
    }


    public function testPassingCompanyNameLessThanThreeCharactersThrowsAccountInformationException()
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_COMPANY_NAME_TOO_SHORT);

        new UpdateAccountInformation(
            null,
            null,
            null,
            null,
            'oy',
            null,
            null
        );
    }

    public function testPassingCompanyNameGreaterThanFourtyCharactersThrowsAccountInformationException()
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_COMPANY_NAME_TOO_LONG);

        new UpdateAccountInformation(
            null,
            null,
            null,
            null,
            str_repeat('f', 41),
            null,
            null
        );
    }

    public function testPassingInvalidEmailToNotificationEmailThrowsAccountInformationException()
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_NOTIFICATION_EMAIL_INVALID);

        new UpdateAccountInformation(
            null,
            null,
            null,
            null,
            null,
            'invalid.email.address',
            null
        );
    }

    public function testPassingInvalidMobileNumberToNotificationMobileThrowsAccountInformationException()
    {
        $this->expectException(AccountInformationException::class);
        $this->expectExceptionCode(AccountInformationException::E_NOTIFICATION_MOBILE_INVALID);

        new UpdateAccountInformation(
            null,
            null,
            null,
            null,
            null,
            null,
            'herp'
        );
    }

    public function testPassingAcceptableInputsAreAllRetrievable()
    {
        $account = new UpdateAccountInformation(
            'account-name',
            'account-password',
            'api-username',
            'api-password',
            'My Company Name',
            'company.email@mycompany.com',
            '447777777777'
        );

        $this->assertEquals('account-name', $account->getAccountUserName());
        $this->assertEquals('account-password', $account->getAccountPassword());
        $this->assertEquals('api-username', $account->getApiUserName());
        $this->assertEquals('api-password', $account->getApiPassword());
        $this->assertEquals('My Company Name', $account->getCompanyName());
        $this->assertEquals('company.email@mycompany.com', $account->getNotificationEmail());
        $this->assertEquals('447777777777', $account->getNotificationMobile());
    }

    public function testPassingAllNullIsAlsoAcceptableAndRetrievable()
    {
        $account = new UpdateAccountInformation(
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $this->assertEquals(null, $account->getAccountUserName());
        $this->assertEquals(null, $account->getAccountPassword());
        $this->assertEquals(null, $account->getApiUserName());
        $this->assertEquals(null, $account->getApiPassword());
        $this->assertEquals(null, $account->getCompanyName());
        $this->assertEquals(null, $account->getNotificationEmail());
        $this->assertEquals(null, $account->getNotificationMobile());
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

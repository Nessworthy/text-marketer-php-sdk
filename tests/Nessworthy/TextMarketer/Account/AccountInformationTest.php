<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Tests\Account;

use Nessworthy\TextMarketer\Account\AccountInformation;
use PHPUnit\Framework\TestCase;

class AccountInformationTest extends TestCase
{
    public function testAccountInformationGettersAllReturnCorrectData()
    {
        $accountCreation = new \DateTimeImmutable();
        $accountInformation = new AccountInformation(
            '12345abcdefghijklmnop',
            'api.username',
            'api.password',
            'My Company',
            $accountCreation,
            1001,
            'notification@email.com',
            '447777777777',
            'ui.user.name',
            'ui.user.password'
        );

        $this->assertEquals('12345abcdefghijklmnop', $accountInformation->getAccountId());
        $this->assertEquals('api.username', $accountInformation->getApiUserName());
        $this->assertEquals('api.password', $accountInformation->getApiPassword());
        $this->assertEquals('My Company', $accountInformation->getCompanyName());
        $this->assertEquals($accountCreation, $accountInformation->getAccountCreatedDate());
        $this->assertEquals(1001, $accountInformation->getRemainingCredits());
        $this->assertEquals('notification@email.com', $accountInformation->getNotificationEmail());
        $this->assertEquals('447777777777', $accountInformation->getNotificationMobile());
        $this->assertEquals('ui.user.name', $accountInformation->getUiUserName());
        $this->assertEquals('ui.user.password', $accountInformation->getUiPassword());
    }
}
<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Tests\Account;

use Nessworthy\TextMarketer\Account\CreateSubAccount;
use PHPUnit\Framework\TestCase;

class CreateSubAccountTest extends TestCase
{
    public function testSubAccountInformationGettersAllReturnCorrectData()
    {
        $subAccountQuery = new CreateSubAccount(
            'username',
            'password',
            'My Company',
            'notification@email.com',
            '447777777777',
            false,
            'ABCDEFG'
        );

        $this->assertEquals('username', $subAccountQuery->getUserName());
        $this->assertEquals('password', $subAccountQuery->getPassword());
        $this->assertEquals('My Company', $subAccountQuery->getCompanyName());
        $this->assertEquals('notification@email.com', $subAccountQuery->getNotificationEmail());
        $this->assertEquals('447777777777', $subAccountQuery->getNotificationMobile());
        $this->assertFalse($subAccountQuery->enablePricingOverride());
        $this->assertEquals('ABCDEFG', $subAccountQuery->getPromoCode());
    }
}

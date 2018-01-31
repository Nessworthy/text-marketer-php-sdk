<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Endpoint;

use Nessworthy\TextMarketer\Account\AccountInformation;
use Nessworthy\TextMarketer\Account\CreateSubAccount;
use Nessworthy\TextMarketer\Message\DeliveryReport;
use Nessworthy\TextMarketer\Message\SendMessage;

interface Endpoint
{
    public function sendMessage(SendMessage $message): DeliveryReport;

    public function getCreditCount(): int;

    public function getAccountInformation(): AccountInformation;

    public function getAccountInformationForAccountId(string $accountId): AccountInformation;

    public function createSubAccount(CreateSubAccount $subAccountDetails): AccountInformation;
}
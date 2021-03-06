<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Endpoint;

use Nessworthy\TextMarketer\Account\AccountInformation;
use Nessworthy\TextMarketer\Account\CreateSubAccount;
use Nessworthy\TextMarketer\Account\UpdateAccountInformation;

/**
 * Account Endpoint
 *
 * The API available to you to interact with Text Marketer's Account Management API.
 *
 * Note - Some of these methods expect an account ID.
 * This can be found in the page footer at https://messagebox.textmarketer.co.uk.
 *
 * @package Nessworthy\TextMarketer\Endpoint
 */
interface AccountEndpoint
{
    /**
     * Retrieve information for the account in use.
     * Warning - this endpoint returns passwords!
     * @return AccountInformation
     * @throws EndpointException
     */
    public function getAccountInformation(): AccountInformation;

    /**
     * Retrieve information for a given account or sub account.
     * @param string $accountId
     * @return AccountInformation
     * @throws EndpointException
     */
    public function getAccountInformationForAccountId(string $accountId): AccountInformation;

    /**
     * Update account information for the account in use.
     * @param UpdateAccountInformation $newAccountInformation
     * @return AccountInformation
     * @throws EndpointException
     */
    public function updateAccountInformation(UpdateAccountInformation $newAccountInformation): AccountInformation;

    /**
     * Create a new sub-account for the account in use.
     * Note - This feature is disabled by default until you request Text Marketer to enable it.
     * @param CreateSubAccount $subAccountDetails
     * @return AccountInformation
     * @throws EndpointException
     */
    public function createSubAccount(CreateSubAccount $subAccountDetails): AccountInformation;
}

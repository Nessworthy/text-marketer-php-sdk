<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Endpoint;

use Nessworthy\TextMarketer\Authentication\Authentication;
use Nessworthy\TextMarketer\Credit\TransferReport;

/**
 * Credit Endpoint
 *
 * The API available to you to interact with Text Marketer's Credit Management API.
 *
 * Note - Some of these methods expect an account ID.
 * This can be found in the page footer at https://messagebox.textmarketer.co.uk.
 *
 * @package Nessworthy\TextMarketer\Endpoint
 */
interface CreditEndpoint
{
    /**
     * Retrieves the amount of credits the account in use currently has available.
     * @return int
     */
    public function getCreditCount(): int;

    /**
     * Transfer credits from the account in use to another account using its account ID.
     * @param string $destinationAccountId
     * @return TransferReport
     */
    public function transferCreditsToAccountById(string $destinationAccountId): TransferReport;

    /**
     * Transfer credits from the account in use to another account using its username and password.
     * @param Authentication $destinationAccountDetails
     * @return TransferReport
     */
    public function transferCreditsToAccountByCredentials(Authentication $destinationAccountDetails): TransferReport;

}
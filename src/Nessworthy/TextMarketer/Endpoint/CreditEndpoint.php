<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Endpoint;

use Nessworthy\TextMarketer\Authentication;
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
     * @throws EndpointException
     */
    public function getCreditCount(): int;

    /**
     * Transfer credits from the account in use to another account using its account ID.
     * @param int $quantity
     * @param string $destinationAccountId
     * @return TransferReport
     * @throws EndpointException
     */
    public function transferCreditsToAccountById(int $quantity, string $destinationAccountId): TransferReport;

    /**
     * Transfer credits from the account in use to another account using its username and password.
     * @param int $quantity
     * @param Authentication $destinationAccountDetails
     * @return TransferReport
     * @throws EndpointException
     */
    public function transferCreditsToAccountByCredentials(int $quantity, Authentication $destinationAccountDetails): TransferReport;

}
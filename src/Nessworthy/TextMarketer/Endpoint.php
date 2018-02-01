<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer;

use Nessworthy\TextMarketer\Account\AccountInformation;
use Nessworthy\TextMarketer\Account\CreateSubAccount;
use Nessworthy\TextMarketer\Authentication\Authentication;
use Nessworthy\TextMarketer\Message\DeliveryReport;
use Nessworthy\TextMarketer\Message\Part\PhoneNumberCollection;
use Nessworthy\TextMarketer\Message\SendMessage;

/**
 * Interface Endpoint
 *
 * The API available to you to interact with Text Marketer's API.
 *
 * Note - Some of these methods expect an account ID.
 * This can be found in the page footer at https://messagebox.textmarketer.co.uk.
 *
 * @package Nessworthy\TextMarketer\Endpoint
 */
interface Endpoint
{
    /**
     * Send an SMS message.
     * @param SendMessage $message
     * @return DeliveryReport
     */
    public function sendMessage(SendMessage $message): DeliveryReport;

    /**
     * Schedule an SMS message to be sent out at a given date.
     * @param SendMessage $message
     * @param \DateTimeImmutable $deliveryTime
     * @return DeliveryReport
     */
    public function sendScheduledMessage(SendMessage $message, \DateTimeImmutable $deliveryTime): DeliveryReport;

    /**
     * Delete a scheduled SMS message.
     * Note - this will fail if the message has already been sent.
     * @param string $scheduleId
     */
    public function deleteScheduledMessage(string $scheduleId): void;

    /**
     * Retrieve information for the account in use.
     * Warning - this endpoint returns passwords!
     * @return AccountInformation
     */
    public function getAccountInformation(): AccountInformation;

    /**
     * Retrieve information for a given account or sub account.
     * @param string $accountId
     * @return AccountInformation
     */
    public function getAccountInformationForAccountId(string $accountId): AccountInformation;

    /**
     * Create a new sub-account for the account in use.
     * Note - This feature is disabled by default until you request Text Marketer to enable it.
     * @param CreateSubAccount $subAccountDetails
     * @return AccountInformation
     */
    public function createSubAccount(CreateSubAccount $subAccountDetails): AccountInformation;

    /**
     * Retrieves the amount of credits the account in use currently has available.
     * @return int
     */
    public function getCreditCount(): int;

    /**
     * Transfer credits from the account in use to another account using its account ID.
     * @param string $destinationAccountId
     * @return CreditTransferReport
     */
    public function transferCreditsToAccountById(string $destinationAccountId): CreditTransferReport;

    /**
     * Transfer credits from the account in use to another account using its username and password.
     * @param Authentication $destinationAccountDetails
     * @return CreditTransferReport
     */
    public function transferCreditsToAccountByCredentials(Authentication $destinationAccountDetails): CreditTransferReport;

    /**
     * Retrieve the full list of delivery reports available for the account in use.
     * @return DeliveryReportCollection
     */
    public function getDeliveryReportList(): DeliveryReportCollection;

    /**
     * Retrieve a filtered list of reports by name.
     * @param string $reportName
     * @return DeliveryReportCollection
     */
    public function getDeliveryReportListByName(string $reportName): DeliveryReportCollection;

    /**
     * Retrieve a filtered list of reports by name between the specified date range.
     * @param string $reportName
     * @param DateRange $createdBetween
     * @return DeliveryReportCollection
     */
    public function getDeliveryReportListByNameAndDateRange(string $reportName, DateRange $createdBetween): DeliveryReportCollection;

    /**
     * Retrieve a filtered list of reports by name and tag.
     * @param string $reportName
     * @param string $tag
     * @return DeliveryReportCollection
     */
    public function getDeliveryReportListByNameAndTag(string $reportName, string $tag): DeliveryReportCollection;

    /**
     * Retrieve a filtered list of reports by name and tag between the specified date range.
     * @param string $reportName
     * @param string $tag
     * @param DateRange $createdBetween
     * @return DeliveryReportCollection
     */
    public function getDeliveryReportListByNameTagAndDateRange(string $reportName, string $tag, DateRange $createdBetween): DeliveryReportCollection;

    /**
     * Retrieve the availability information of a given keyword.
     * @param string $keyword
     * @return KeywordAvailability
     */
    public function checkKeywordAvailability(string $keyword): KeywordAvailability;

    /**
     * Retrieve the full list of groups for the account in use.
     * @return SendGroupCollection
     */
    public function getGroupsList(): SendGroupCollection;

    /**
     * Add one or more numbers to a group.
     * @param string $groupNameOrId
     * @param PhoneNumberCollection $numbers
     * @return AddNumbersToGroupReport
     */
    public function addNumbersToGroup(string $groupNameOrId, PhoneNumberCollection $numbers): AddNumbersToGroupReport;

    /**
     * Create a new group.
     * @param string $groupName
     * @return GroupReport
     */
    public function createGroup(string $groupName): GroupReport;

    /**
     * Retrieve information for a given group.
     * @param string $groupNameOrId
     * @return GroupReport
     */
    public function getGroupInformation(string $groupNameOrId): GroupReport;
}

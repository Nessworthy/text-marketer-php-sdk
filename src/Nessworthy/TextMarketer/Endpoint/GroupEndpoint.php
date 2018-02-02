<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Endpoint;

use Nessworthy\TextMarketer\Message\Part\PhoneNumberCollection;
use Nessworthy\TextMarketer\SendGroup\AddNumbersToGroupReport;
use Nessworthy\TextMarketer\SendGroup\SendGroup;
use Nessworthy\TextMarketer\SendGroup\SendGroupSummaryCollection;

/**
 * Send Group Endpoint
 *
 * The API available to you to interact with Text Marketer's Send Group API.
 *
 * @package Nessworthy\TextMarketer\Endpoint
 */
interface GroupEndpoint
{
    /**
     * Retrieve the full list of groups for the account in use.
     * @return SendGroupSummaryCollection
     */
    public function getGroupsList(): SendGroupSummaryCollection;

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
     * @return SendGroup
     */
    public function createGroup(string $groupName): SendGroup;

    /**
     * Retrieve information for a given group.
     * @param string $groupNameOrId
     * @return SendGroup
     */
    public function getGroupInformation(string $groupNameOrId): SendGroup;
}
<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Endpoint;

use Nessworthy\TextMarketer\DeliveryReport\DateRange;
use Nessworthy\TextMarketer\DeliveryReport\DeliveryReportCollection;

/**
 * DeliveryReport Endpoint
 *
 * The API available to you to interact with Text Marketer's Delivery Reports API.
 *
 * @package Nessworthy\TextMarketer\Endpoint
 */
interface DeliveryReportEndpoint
{
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
}

<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Endpoint;

use Nessworthy\TextMarketer\Keyword\KeywordAvailability;

/**
 * Keyword Endpoint
 *
 * The API available to you to interact with Text Marketer's Keyword API.
 *
 * @package Nessworthy\TextMarketer\Endpoint
 */
interface KeywordEndpoint
{
    /**
     * Retrieve the availability information of a given keyword.
     * @param string $keyword
     * @return KeywordAvailability
     * @throws EndpointException
     */
    public function checkKeywordAvailability(string $keyword): KeywordAvailability;
}

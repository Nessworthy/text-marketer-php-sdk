<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Authentication;

use Nessworthy\TextMarketer\TextMarketerException;

/**
 * Class InvalidAuthenticationException
 * When handling error responses, you should use the error code constants to determine what went wrong.
 * @package Nessworthy\TextMarketer\Authentication
 */
final class InvalidAuthenticationException extends TextMarketerException
{
    /**
     * Given when your username is not valid. For example, if it is not a string.
     */
    public const E_INVALID_USERNAME = 501;

    /**
     * Given when your password is not valid. For example, if it is not a string.
     */
    public const E_INVALID_PASSWORD = 502;
}
<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Account;

use Nessworthy\TextMarketer\TextMarketerException;

final class AccountInformationException extends TextMarketerException
{
    /**
     * Signifies that the account username provided is too short.
     * Account usernames must be 5 characters at least.
     */
    public const E_USERNAME_TOO_SHORT = 501;

    /**
     * Signifies that the account username provided is too long.
     * Account usernames must be 20 characters at most.
     */
    public const E_USERNAME_TOO_LONG = 502;

    /**
     * Signifies that the account username contains characters not supported.
     * Account usernames must only use a combination of alphanumeric characters, '-' and '_'.
     */
    public const E_USERNAME_INVALID = 503;

    /**
     * Signifies that the account password provided is too short.
     * Account passwords must be 5 characters at least.
     */
    public const E_PASSWORD_TOO_SHORT = 511;

    /**
     * Signifies that the account password provided is too long.
     * Account passwords must be 20 characters at most.
     */
    public const E_PASSWORD_TOO_LONG = 512;

    /**
     * Signifies that the account password contains characters not supported.
     * Account passwords must only use a combination of alphanumeric characters, '-' and '_'.
     */
    public const E_PASSWORD_INVALID = 513;

    /**
     * Signifies that the API username provided is too short.
     * API usernames must be 5 characters at least.
     */
    public const E_API_USERNAME_TOO_SHORT = 521;

    /**
     * Signifies that the API username provided is too long.
     * API usernames must be 20 characters at most.
     */
    public const E_API_USERNAME_TOO_LONG = 522;

    /**
     * Signifies that the API username contains characters not supported.
     * API usernames must only use a combination of alphanumeric characters, '-' and '_'.
     */
    public const E_API_USERNAME_INVALID = 523;

    /**
     * Signifies that the account password provided is too short.
     * Account passwords must be 5 characters at least.
     */
    public const E_API_PASSWORD_TOO_SHORT = 531;

    /**
     * Signifies that the account password provided is too long.
     * Account passwords must be 20 characters at most.
     */
    public const E_API_PASSWORD_TOO_LONG = 532;

    /**
     * Signifies that the account password contains characters not supported.
     * Account passwords must only use a combination of alphanumeric characters, '-' and '_'.
     */
    public const E_API_PASSWORD_INVALID = 533;

    /**
     * Signifies that the company name provided is too short.
     * Company names must be 3 characters at least.
     */
    public const E_COMPANY_NAME_TOO_SHORT = 541;

    /**
     * Signifies that the company name provided is too long.
     * Company names must be 40 characters at most.
     */
    public const E_COMPANY_NAME_TOO_LONG = 542;

    /**
     * Signifies that the notification email is not a valid email address.
     */
    public const E_NOTIFICATION_EMAIL_INVALID = 551;

    /**
     * Signifies that the notification mobile number is not a valid UK mobile number.
     */
    public const E_NOTIFICATION_MOBILE_INVALID = 561;
}

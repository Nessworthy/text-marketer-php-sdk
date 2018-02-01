<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Account\Command;

use Nessworthy\TextMarketer\Account\AccountInformationException;

/**
 * Class UpdateAccountInformation
 *
 * Command to update account information.
 *
 * Fields set as null represent fields which should not be updated.
 *
 * @package Nessworthy\TextMarketer\Account\Command
 */
class UpdateAccountInformation
{
    /**
     * @var string
     */
    private $accountUserName;
    /**
     * @var string
     */
    private $accountPassword;
    /**
     * @var string
     */
    private $accountApiUserName;
    /**
     * @var string
     */
    private $accountApiPassword;
    /**
     * @var string
     */
    private $companyName;
    /**
     * @var string
     */
    private $notificationEmail;
    /**
     * @var string
     */
    private $notificationMobile;
    /**
     * @var bool
     */
    private $overridePricing;

    /**
     * UpdateAccountInformation constructor.
     * @param string|null $accountUserName
     * @param string|null $accountPassword
     * @param string|null $apiUserName
     * @param string|null $apiPassword
     * @param string|null $companyName
     * @param string|null $notificationEmail
     * @param string|null $notificationMobile
     * @param bool|null $overridePricing
     * @throws AccountInformationException
     */
    public function __construct(
        string $accountUserName = null,
        string $accountPassword = null,
        string $apiUserName = null,
        string $apiPassword = null,
        string $companyName = null,
        string $notificationEmail = null,
        string $notificationMobile = null,
        bool $overridePricing = null
    ) {
        $this->handleAccountUserName($accountUserName);
        $this->handleAccountPassword($accountPassword);
        $this->handleApiUserName($apiUserName);
        $this->handleApiPassword($apiPassword);
        $this->handleCompanyName($companyName);
        $this->handleNotificationEmail($notificationEmail);
        $this->handleNotificationMobile($notificationMobile);
        $this->overridePricing = $overridePricing;
    }

    /**
     * @return string|null
     */
    public function getAccountUserName(): ?string
    {
        return $this->accountUserName;
    }

    /**
     * @return string|null
     */
    public function getAccountPassword(): ?string
    {
        return $this->accountPassword;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @return string|null
     */
    public function getNotificationEmail(): ?string
    {
        return $this->notificationEmail;
    }

    /**
     * @return string|null
     */
    public function getNotificationMobile(): ?string
    {
        return $this->notificationMobile;
    }

    /**
     * @return bool|null
     */
    public function isOverridePricing(): ?bool
    {
        return $this->overridePricing;
    }

    /**
     * @return string
     */
    public function getAccountApiUserName(): string
    {
        return $this->accountApiUserName;
    }

    /**
     * @return string
     */
    public function getAccountApiPassword(): string
    {
        return $this->accountApiPassword;
    }

    private function isAlphaNumericDashUnderscore(string $string): bool
    {
        return (bool) preg_match('#^[a-zA-Z0-9-_]+$#', $string);
    }

    /**
     * @param string $accountUserName
     * @throws AccountInformationException
     */
    private function handleAccountUserName(string $accountUserName = null): void
    {
        if ($accountUserName === null) {
            return;
        }

        if (\strlen($accountUserName) < 5) {
            throw new AccountInformationException(
                'The new account username is too small. It must be at least 5 characters.',
                AccountInformationException::E_USERNAME_TOO_SHORT
            );
        }
        if (\strlen($accountUserName) > 20) {
            throw new AccountInformationException(
                'The new account username is too small. It must be at least 20 characters.',
                AccountInformationException::E_USERNAME_TOO_LONG
            );
        }
        if (!$this->isAlphaNumericDashUnderscore($accountUserName)) {
            throw new AccountInformationException(
                'The new account username must only contain alpha-numeric, \'-\', and \'_\' characters.',
                AccountInformationException::E_USERNAME_INVALID
            );
        }
        $this->accountUserName = $accountUserName;
    }

    /**
     * @param string $accountPassword
     * @throws AccountInformationException
     */
    private function handleAccountPassword(string $accountPassword = null): void
    {
        if ($accountPassword === null) {
            return;
        }

        if (\strlen($accountPassword) < 5) {
            throw new AccountInformationException(
                'The new account password is too small. It must be at least 5 characters.',
                AccountInformationException::E_PASSWORD_TOO_SHORT
            );
        }
        if (\strlen($accountPassword) > 20) {
            throw new AccountInformationException(
                'The new account password is too small. It must be at least 20 characters.',
                AccountInformationException::E_PASSWORD_TOO_LONG
            );
        }
        if (!$this->isAlphaNumericDashUnderscore($accountPassword)) {
            throw new AccountInformationException(
                'The new account password must only contain alpha-numeric, \'-\', and \'_\' characters.',
                AccountInformationException::E_PASSWORD_INVALID
            );
        }
        $this->accountPassword = $accountPassword;
    }

    /**
     * @param string $accountApiUserName
     * @throws AccountInformationException
     */
    private function handleApiUserName(string $accountApiUserName = null): void
    {
        if ($accountApiUserName === null) {
            return;
        }

        if (\strlen($accountApiUserName) < 5) {
            throw new AccountInformationException(
                'The new API username is too small. It must be at least 5 characters.',
                AccountInformationException::E_API_USERNAME_TOO_SHORT
            );
        }
        if (\strlen($accountApiUserName) > 20) {
            throw new AccountInformationException(
                'The new API username is too small. It must be at least 20 characters.',
                AccountInformationException::E_API_USERNAME_TOO_LONG
            );
        }
        if (!$this->isAlphaNumericDashUnderscore($accountApiUserName)) {
            throw new AccountInformationException(
                'The new API username must only contain alpha-numeric, \'-\', and \'_\' characters.',
                AccountInformationException::E_API_USERNAME_INVALID
            );
        }
        $this->accountApiUserName = $accountApiUserName;
    }

    /**
     * @param string $accountApiPassword
     * @throws AccountInformationException
     */
    private function handleApiPassword(string $accountApiPassword = null): void
    {
        if ($accountApiPassword === null) {
            return;
        }
        if (\strlen($accountApiPassword) < 5) {
            throw new AccountInformationException(
                'The new API password is too small. It must be at least 5 characters.',
                AccountInformationException::E_API_PASSWORD_TOO_SHORT
            );
        }
        if (\strlen($accountApiPassword) > 20) {
            throw new AccountInformationException(
                'The new API password is too small. It must be at least 20 characters.',
                AccountInformationException::E_API_PASSWORD_TOO_LONG
            );
        }
        if (!$this->isAlphaNumericDashUnderscore($accountApiPassword)) {
            throw new AccountInformationException(
                'The new API password must only contain alpha-numeric, \'-\', and \'_\' characters.',
                AccountInformationException::E_API_PASSWORD_INVALID
            );
        }
        $this->accountApiPassword = $accountApiPassword;
    }

    /**
     * @param string $companyName
     * @throws AccountInformationException
     */
    private function handleCompanyName(string $companyName = null): void
    {
        if ($companyName === null) {
            return;
        }
        if (\strlen($companyName) < 5) {
            throw new AccountInformationException(
                'The new company name is too small. It must be at least 3 characters.',
                AccountInformationException::E_COMPANY_NAME_TOO_SHORT
            );
        }
        if (\strlen($companyName) > 20) {
            throw new AccountInformationException(
                'The new company name is too small. It must be at least 40 characters.',
                AccountInformationException::E_COMPANY_NAME_TOO_LONG
            );
        }
        $this->companyName = $companyName;
    }

    /**
     * @param string $notificationEmail
     * @throws AccountInformationException
     */
    private function handleNotificationEmail(string $notificationEmail = null): void
    {
        if ($notificationEmail === null) {
            return;
        }

        if (!filter_var($notificationEmail, FILTER_VALIDATE_EMAIL)) {
            throw new AccountInformationException(
                'The new company email must be a valid email address.',
                AccountInformationException::E_NOTIFICATION_EMAIL_INVALID
            );
        }
        $this->companyName = $notificationEmail;
    }

    /**
     * @param string $notificationMobile
     * @throws AccountInformationException
     */
    private function handleNotificationMobile(string $notificationMobile = null): void
    {
        if ($notificationMobile === null) {
            return;
        }

        if (!ctype_digit($notificationMobile)) {
            throw new AccountInformationException(
                'The notification mobile number provided must be a valid UK phone number.',
                AccountInformationException::E_NOTIFICATION_MOBILE_INVALID
            );
        }
        $this->notificationMobile = $notificationMobile;
    }
}

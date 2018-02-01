<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Account\Command;

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
     * @var string
     */
    private $promoCode;

    public function __construct(
        string $accountUserName = null,
        string $accountPassword = null,
        string $companyName = null,
        string $notificationEmail = null,
        string $notificationMobile = null,
        bool $overridePricing = null,
        string $promoCode = null
    ) {
        $this->accountUserName = $accountUserName;
        $this->accountPassword = $accountPassword;
        $this->companyName = $companyName;
        $this->notificationEmail = $notificationEmail;
        $this->notificationMobile = $notificationMobile;
        $this->overridePricing = $overridePricing;
        $this->promoCode = $promoCode;
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
     * @return string|null
     */
    public function getPromoCode(): ?string
    {
        return $this->promoCode;
    }
}

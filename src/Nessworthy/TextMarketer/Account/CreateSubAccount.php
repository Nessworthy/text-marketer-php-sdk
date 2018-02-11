<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Account;

class CreateSubAccount
{
    /**
     * @var string
     */
    private $username;
    /**
     * @var string|null
     */
    private $password;
    /**
     * @var string
     */
    private $companyName;
    /**
     * @var string|null
     */
    private $notificationEmail;
    /**
     * @var string|null
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
        string $username,
        ?string $password = null,
        string $companyName,
        ?string $notificationEmail = null,
        ?string $notificationMobile = null,
        bool $overridePricing,
        string $promoCode = null
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->companyName = $companyName;
        $this->notificationEmail = $notificationEmail;
        $this->notificationMobile = $notificationMobile;
        $this->overridePricing = $overridePricing;
        $this->promoCode = $promoCode;
    }

    /**
     * @return string
     */
    public function getAccountUserName(): string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getAccountPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
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
     * @return bool
     */
    public function enablePricingOverride(): bool
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
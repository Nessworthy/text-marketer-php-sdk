<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Account\Command;

class CreateSubAccount
{
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;
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
        string $username,
        string $password,
        string $companyName,
        string $notificationEmail,
        string $notificationMobile,
        bool $overridePricing,
        string $promoCode
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
    public function getUserName(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
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
     * @return string
     */
    public function getNotificationEmail(): string
    {
        return $this->notificationEmail;
    }

    /**
     * @return string
     */
    public function getNotificationMobile(): string
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
     * @return string
     */
    public function getPromoCode(): string
    {
        return $this->promoCode;
    }
}
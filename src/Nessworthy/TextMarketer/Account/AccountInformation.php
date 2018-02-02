<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Account;

final class AccountInformation
{
    /**
     * @var string
     */
    private $accountId;
    /**
     * @var string
     */
    private $apiUserName;
    /**
     * @var string
     */
    private $apiPassword;
    /**
     * @var string
     */
    private $companyName;
    /**
     * @var \DateTimeImmutable
     */
    private $accountCreatedDate;
    /**
     * @var int
     */
    private $remainingCredits;
    /**
     * @var string
     */
    private $notificationEmail;
    /**
     * @var string
     */
    private $notificationMobile;
    /**
     * @var string
     */
    private $uiUserName;
    /**
     * @var string
     */
    private $uiPassword;

    public function __construct(
        string $accountId,
        string $apiUserName,
        string $apiPassword,
        string $companyName,
        \DateTimeImmutable $accountCreatedDate,
        int $remainingCredits,
        string $notificationEmail,
        string $notificationMobile,
        string $uiUserName,
        string $uiPassword
    ) {

        $this->accountId = $accountId;
        $this->apiUserName = $apiUserName;
        $this->apiPassword = $apiPassword;
        $this->companyName = $companyName;
        $this->accountCreatedDate = $accountCreatedDate;
        $this->remainingCredits = $remainingCredits;
        $this->notificationEmail = $notificationEmail;
        $this->notificationMobile = $notificationMobile;
        $this->uiUserName = $uiUserName;
        $this->uiPassword = $uiPassword;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @return string
     */
    public function getApiUserName(): string
    {
        return $this->apiUserName;
    }

    /**
     * @return string
     */
    public function getApiPassword(): string
    {
        return $this->apiPassword;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getAccountCreatedDate(): \DateTimeImmutable
    {
        return $this->accountCreatedDate;
    }

    /**
     * @return int
     */
    public function getRemainingCredits(): int
    {
        return $this->remainingCredits;
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
     * @return string
     */
    public function getUiUserName(): string
    {
        return $this->uiUserName;
    }

    /**
     * @return string
     */
    public function getUiPassword(): string
    {
        return $this->uiPassword;
    }
}
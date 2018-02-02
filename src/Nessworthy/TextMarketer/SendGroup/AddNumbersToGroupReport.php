<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\SendGroup;

use Nessworthy\TextMarketer\Message\Part\PhoneNumberCollection;

final class AddNumbersToGroupReport
{
    /**
     * @var PhoneNumberCollection
     */
    private $addedNumbers;
    /**
     * @var PhoneNumberCollection
     */
    private $stoppedNumbers;
    /**
     * @var PhoneNumberCollection
     */
    private $duplicateNumbers;

    public function __construct(
        PhoneNumberCollection $addedNumbers,
        PhoneNumberCollection $stoppedNumbers,
        PhoneNumberCollection $duplicateNumbers
    ) {
        $this->addedNumbers = $addedNumbers;
        $this->stoppedNumbers = $stoppedNumbers;
        $this->duplicateNumbers = $duplicateNumbers;
    }

    /**
     * @return string[]
     */
    public function getAddedNumbers(): array
    {
        return $this->addedNumbers->getAllRecipients();
    }

    /**
     * @return int
     */
    public function getTotalAddedNumbers(): int
    {
        return $this->addedNumbers->getTotal();
    }

    /**
     * @return string[]
     */
    public function getStoppedNumbers(): array
    {
        return $this->stoppedNumbers->getAllRecipients();
    }

    /**
     * @return int
     */
    public function getTotalStoppedNumbers(): int
    {
        return $this->stoppedNumbers->getTotal();
    }

    /**
     * @return string[]
     */
    public function getDuplicateNumbers(): array
    {
        return $this->duplicateNumbers->getAllRecipients();
    }

    /**
     * @return int
     */
    public function getTotalDuplicateNumbers(): int
    {
        return $this->duplicateNumbers->getTotal();
    }
}

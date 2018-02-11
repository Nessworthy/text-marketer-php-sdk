<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\SendGroup;

use Nessworthy\TextMarketer\Message\Part\PhoneNumberCollection;

final class SendGroup
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var bool
     */
    private $isStopGroup;
    /**
     * @var PhoneNumberCollection
     */
    private $numbers;

    public function __construct(string $id, string $name, bool $isStopGroup, PhoneNumberCollection $numbers)
    {
        $this->id = $id;
        $this->name = $name;
        $this->isStopGroup = $isStopGroup;
        $this->numbers = $numbers;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getNumbers(): array
    {
        return $this->numbers->asArray();
    }

    /**
     * @return int
     */
    public function getNumberCount(): int
    {
        return $this->numbers->getTotal();
    }

    /**
     * @return bool
     */
    public function isStopGroup(): bool
    {
        return $this->isStopGroup;
    }
}
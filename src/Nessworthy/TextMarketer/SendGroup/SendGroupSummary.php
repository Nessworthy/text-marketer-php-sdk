<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\SendGroup;

final class SendGroupSummary
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $numbers;
    /**
     * @var bool
     */
    private $isStopGroup;

    public function __construct(string $id, string $name, int $numbers, bool $isStopGroup)
    {
        $this->id = $id;
        $this->name = $name;
        $this->numbers = $numbers;
        $this->isStopGroup = $isStopGroup;
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
     * @return int
     */
    public function getNumbers(): int
    {
        return $this->numbers;
    }

    /**
     * @return bool
     */
    public function isStopGroup(): bool
    {
        return $this->isStopGroup;
    }
}

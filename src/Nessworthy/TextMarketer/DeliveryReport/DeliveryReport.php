<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\DeliveryReport;

class DeliveryReport
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var \DateTimeImmutable
     */
    private $lastUpdated;
    /**
     * @var string
     */
    private $extension;

    public function __construct(string $name, \DateTimeImmutable $lastUpdated, string $extension)
    {
        $this->name = $name;
        $this->lastUpdated = $lastUpdated;
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getLastUpdated(): \DateTimeImmutable
    {
        return $this->lastUpdated;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }
}

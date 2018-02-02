<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Keyword;

final class KeywordAvailability
{
    /**
     * @var bool
     */
    private $isAvailable;
    /**
     * @var bool
     */
    private $isRecycled;

    public function __construct(bool $isAvailable, bool $isRecycled)
    {
        $this->isAvailable = $isAvailable;
        $this->isRecycled = $isRecycled;
    }

    /**
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }

    /**
     * @return bool
     */
    public function isRecycled(): bool
    {
        return $this->isRecycled;
    }
}

<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Endpoint;

final class EndpointError
{
    /**
     * @var int
     */
    private $code;
    /**
     * @var string
     */
    private $message;

    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
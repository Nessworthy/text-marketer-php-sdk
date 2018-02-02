<?php declare(strict_types=1);

namespace Nessworthy\TextMarketer\Endpoint;

use Nessworthy\TextMarketer\TextMarketerException;

abstract class EndpointException extends TextMarketerException
{
    /**
     * @var array
     */
    private $messages;

    public function __construct(EndpointError ...$errors)
    {
        $this->messages = $errors;
        parent::__construct($errors[0]->getMessage(), $errors[0]->getCode());
    }

    /**
     * @return EndpointError[]
     */
    public function getAllEndpointErrors(): array
    {
        return $this->messages;
    }
}

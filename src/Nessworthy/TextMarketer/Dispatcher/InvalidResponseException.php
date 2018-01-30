<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Dispatcher;

use Nessworthy\TextMarketer\TextMarketerException;

class InvalidResponseException extends TextMarketerException
{
    const E_BAD_FORMAT = 501;
}
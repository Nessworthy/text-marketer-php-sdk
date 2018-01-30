<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Result;

class MockSMSResult extends SendSMSResult
{
    public function __construct()
    {
        parent::__construct('', 9999, 0, SendSMSResult::STATUS_SUCCESS);
    }
}
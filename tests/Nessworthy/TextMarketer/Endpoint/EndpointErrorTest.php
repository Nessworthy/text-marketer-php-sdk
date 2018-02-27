<?php
namespace Nessworthy\TextMarketer\Tests\Endpoint;

use Nessworthy\TextMarketer\Endpoint\EndpointError;
use PHPUnit\Framework\TestCase;

class EndpointErrorTest extends TestCase
{

    public function testGetCode(): void
    {
        $error = new EndpointError(500, 'My error message.');
        $this->assertEquals(500, $error->getCode());
    }

    public function testGetMessage(): void
    {
        $error = new EndpointError(500, 'My error message.');
        $this->assertEquals('My error message.', $error->getMessage());
    }
}

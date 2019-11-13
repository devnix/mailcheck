<?php

namespace Devnix\Mailcheck\Tests;

use Devnix\Mailcheck\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testGetLocal()
    {
        $email = new Email('admin@localhost');
        $this->assertEquals('admin', $email->getLocal());
    }

    public function testGetDomain()
    {
        $email = new Email('admin@localhost');
        $this->assertEquals('localhost', $email->getDomain());
    }

    public function testValidate()
    {
        $email = new Email('admin@localhost');
        $this->assertTrue($email->validate());

        $email = new Email('ad@min@localhost');
        $this->assertFalse($email->validate());
    }
}

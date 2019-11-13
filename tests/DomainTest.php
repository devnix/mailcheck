<?php

namespace Devnix\Mailcheck\Tests;

use Devnix\Mailcheck\Domain;
use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    public function testGetSuffix()
    {
        $domain = new Domain('example.com');
        $this->assertEquals('com', $domain->getSuffix());

        $domain = new Domain('www.example.com');
        $this->assertEquals('com', $domain->getSuffix());

        $domain = new Domain('example.co.uk');
        $this->assertEquals('co.uk', $domain->getSuffix());

        $domain = new Domain('www.example.co.uk');
        $this->assertEquals('co.uk', $domain->getSuffix());
    }

    public function testGetSubdomain()
    {
        $domain = new Domain('example.com');
        $this->assertEquals('', $domain->getSubdomain());

        $domain = new Domain('www.example.com');
        $this->assertEquals('www', $domain->getSubdomain());

        $domain = new Domain('example.co.uk');
        $this->assertEquals('', $domain->getSubdomain());

        $domain = new Domain('www.example.co.uk');
        $this->assertEquals('www', $domain->getSubdomain());
    }

    public function testGetHostname()
    {
        $domain = new Domain('example.com');
        $this->assertEquals('example', $domain->getHostname());

        $domain = new Domain('www.example.com');
        $this->assertEquals('example', $domain->getHostname());

        $domain = new Domain('example.co.uk');
        $this->assertEquals('example', $domain->getHostname());

        $domain = new Domain('www.example.co.uk');
        $this->assertEquals('example', $domain->getHostname());
    }

    public function testGetDomainWithoutSuffix()
    {
        $domain = new Domain('example.com');
        $this->assertEquals('example', $domain->getDomainWithoutSuffix());

        $domain = new Domain('www.example.com');
        $this->assertEquals('www.example', $domain->getDomainWithoutSuffix());

        $domain = new Domain('example.co.uk');
        $this->assertEquals('example', $domain->getDomainWithoutSuffix());

        $domain = new Domain('www.example.co.uk');
        $this->assertEquals('www.example', $domain->getDomainWithoutSuffix());
    }
}

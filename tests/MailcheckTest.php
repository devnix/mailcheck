<?php

namespace Devnix\Mailcheck\Tests;

use Devnix\Mailcheck\Mailcheck;
use PHPUnit\Framework\TestCase;

class MailcheckTest extends TestCase
{
    /**
     * @var Mailcheck
     */
    protected $mailcheck;

    public function setUp(): void
    {
        $this->mailcheck = new Mailcheck();
    }

    public function testSuggest()
    {
        // Domain checks
        $this->assertContains('example@gmail.com', $this->mailcheck->suggest('example@gmil.com'));
        $this->assertContains('example@hotmail.com', $this->mailcheck->suggest('example@hotmilcm'));

        // This is a recognized domain, why should we give suggestions!?
        $this->assertEmpty($this->mailcheck->suggest('example@gmail.com'));
        $this->assertEmpty($this->mailcheck->suggest('example@hotmail.com'));
        $this->assertEmpty($this->mailcheck->suggest('example@hotmail.es'));
        $this->assertEmpty($this->mailcheck->suggest('example@willnotfoundtld'));

        // TLD checks
        $this->assertContains('example@foobar.es', $this->mailcheck->suggest('example@foobar.ess'));

        // This is a recognized TLD, why should we give suggestions!?
        $this->assertEmpty($this->mailcheck->suggest('example@foobar.es'));
        $this->assertEmpty($this->mailcheck->suggest('example@foobar.com'));
        $this->assertEmpty($this->mailcheck->suggest('example@foobar.de'));
    }

    public function testSuggestOne()
    {
        // Domain checks
        $this->assertEquals('example@gmail.com', $this->mailcheck->suggestOne('example@gmail.comm'));
        $this->assertEquals('example@gmail.com', $this->mailcheck->suggestOne('example@gmail com'));
        $this->assertEquals('example@hotmail.com', $this->mailcheck->suggestOne('example@hotmail.co'));

        // This is a recognized domain, why should we give suggestions!?
        $this->assertNull($this->mailcheck->suggestOne('example@gmail.com'));
        $this->assertNull($this->mailcheck->suggestOne('example@hotmail.com'));
        $this->assertNull($this->mailcheck->suggestOne('example@hotmail.es'));

        // TLD checks
        $this->assertEquals('example@foobar.es', $this->mailcheck->suggestOne('example@foobar.ess'));

        // This is a recognized TLD, why should we give suggestions!?
        $this->assertNull($this->mailcheck->suggestOne('example@foobar.es'));
        $this->assertNull($this->mailcheck->suggestOne('example@foobar.com'));
        $this->assertNull($this->mailcheck->suggestOne('example@foobar.de'));
    }
}

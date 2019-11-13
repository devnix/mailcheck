<?php

namespace Devnix\Mailcheck;

use Egulias\EmailValidator\EmailLexer;
use Egulias\EmailValidator\EmailParser;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Exception\InvalidEmail;
use Egulias\EmailValidator\Validation\RFCValidation;

class Email
{
    /**
     * @var string
     */
    protected $local;

    /**
     * @var Domain
     */
    protected $domain;

    public function __construct(string $email)
    {
        $parser = new EmailParser(new EmailLexer());

        try {
            $parsedEmail = $parser->parse($email);
        } catch (InvalidEmail $e) {
            preg_match('/(.*)@(.*)/', $email, $splittedEmail);

            $parsedEmail = [
                'local' => $splittedEmail[1],
                'domain' => $splittedEmail[2],
            ];
        }

        $this->local = $parsedEmail['local'];
        $this->domain = new Domain($parsedEmail['domain']);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFullAddress();
    }

    /**
     * @return string
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * @return Domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getFullAddress()
    {
        return $this->getLocal().'@'.$this->getDomain();
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $validator = new EmailValidator();

        return $validator->isValid($this->getFullAddress(), new RFCValidation());
    }
}

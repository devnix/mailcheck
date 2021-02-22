<?php

namespace Devnix\Mailcheck;

use Utopia\Domains\Domain as DomainParser;

class Domain
{
    protected $domain;

    public function __construct(string $domain)
    {
        $this->domain = new DomainParser($domain);
    }

    public function __toString()
    {
        return $this->domain->get();
    }

    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->domain->getSuffix();
    }

    /**
     * @return string
     */
    public function getTld()
    {
        return $this->domain->getTld();
    }

    /**
     * @return string
     */
    public function getSubdomain()
    {
        return $this->domain->getSub();
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->domain->getName();
    }

    /**
     * @return string
     */
    public function getDomainWithoutSuffix()
    {
        $result = '';

        if ('' !== $this->getSubdomain()) {
            $result .= $this->getSubdomain().'.';
        }

        $result .= $this->getHostname();

        return $result;
    }
}

<?php

namespace Devnix\Mailcheck;

use LayerShifter\TLDExtract\Extract;
use LayerShifter\TLDExtract\ResultInterface;

class Domain
{
    /**
     * @var ResultInterface
     */
    protected $domain;

    public function __construct(string $domain)
    {
        $extract = new Extract(null, null, Extract::MODE_ALLOW_ICANN | Extract::MODE_ALLOW_PRIVATE | Extract::MODE_ALLOW_NOT_EXISTING_SUFFIXES);
        $this->domain = $extract->parse($domain);
    }

    public function __toString()
    {
        return $this->domain->getFullHost();
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
    public function getSubdomain()
    {
        return $this->domain->getSubdomain();
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->domain->getHostname();
    }

    /**
     * @return string
     */
    public function getDomainWithoutSuffix()
    {
        $result = '';

        if (!empty($this->domain->getSubdomain())) {
            $result .= $this->domain->getSubdomain().'.';
        }

        $result .= $this->domain->getHostname();

        return $result;
    }
}

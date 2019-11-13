<?php

namespace Devnix\Mailcheck\Dictionary;

use Devnix\Mailcheck\ParameterBag;

class Standard implements DictionaryInterface
{
    /**
     * @var ParameterBag
     */
    protected $providers = null;

    /**
     * @var ParameterBag
     */
    protected $tlds = null;

    public function __construct()
    {
        $this->setProviders(new ParameterBag(include __DIR__.'/../../data/providers.php'));
        $this->setTlds(new ParameterBag(include __DIR__.'/../../data/tlds.php'));
    }

    /**
     * {@inheritdoc}
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * @return self
     */
    protected function setProviders(ParameterBag $providers)
    {
        $this->providers = $providers;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTlds()
    {
        return $this->tlds;
    }

    /**
     * @return self
     */
    protected function setTlds(ParameterBag $tlds)
    {
        $this->tlds = $tlds;

        return $this;
    }
}

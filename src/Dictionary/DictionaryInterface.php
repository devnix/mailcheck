<?php

namespace Devnix\Mailcheck\Dictionary;

use Devnix\Mailcheck\ParameterBag;

interface DictionaryInterface
{
    /**
     * @return ParameterBag
     */
    public function getProviders();

    /**
     * @return ParameterBag
     */
    public function getTlds();
}
